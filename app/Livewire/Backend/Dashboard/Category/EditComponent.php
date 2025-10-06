<?php

namespace App\Livewire\Backend\Dashboard\Category;

use App\Helpers\Helper;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use WithFileUploads;

    public $categoryId;

    public $name;

    public $description;

    public $is_featured = false;

    public $sort_order = 0;

    public $image;      // new upload

    public $oldImage;   // old image path

    protected $rules = [
        'name' => 'required|string|max:255|unique:categories,name,{{categoryId}}',
        'description' => 'nullable|string',
        'is_featured' => 'boolean',
        'sort_order' => 'integer|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ];

    public function mount($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->is_featured = $category->is_featured;
        $this->sort_order = $category->sort_order;
        $this->oldImage = $category->image; // old image path
    }

    public function updatedImage()
    {
        // Livewire  warning  check
        if ($this->image && ! in_array(strtolower($this->image->extension()), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            $this->image = null;
            $this->addError('image', 'This file type cannot be previewed.');
        }
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$this->categoryId,
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
            'sort_order' => 'integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $category = Category::findOrFail($this->categoryId);

        $imagePath = $this->oldImage;

        if ($this->image) {
            // old image delete
            Helper::deleteFile($this->oldImage);

            // new image upload
            $imagePath = Helper::uploadFile('img', $this->image); // path adjust
        }

        $category->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'description' => $this->description,
            'is_featured' => $this->is_featured,
            'sort_order' => $this->sort_order,
            'image' => $imagePath,
        ]);

        session()->flash('message', 'Category updated successfully!');

        return redirect()->route('categories.index');
    }

    public function render()
    {
        return view('livewire.backend.dashboard.category.edit-component')
            ->layout('backend.app');
    }
}
