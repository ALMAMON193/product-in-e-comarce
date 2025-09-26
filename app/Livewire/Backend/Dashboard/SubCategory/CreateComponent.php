<?php

namespace App\Livewire\Backend\Dashboard\SubCategory;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateComponent extends Component
{
    use WithFileUploads;

    public $categories;

    public $subCategories = [];

    public function mount()
    {
        $this->categories = Category::all();
        $this->subCategories[] = [
            'category_id' => null,
            'name' => '',
            'description' => '',
            'image' => null,
            'is_featured' => false,
            'sort_order' => 0,
        ];
    }

    public function addSubCategory()
    {
        $this->subCategories[] = [
            'category_id' => null,
            'name' => '',
            'description' => '',
            'image' => null,
            'is_featured' => false,
            'sort_order' => 0,
        ];
    }

    public function removeSubCategory($index)
    {
        unset($this->subCategories[$index]);
        $this->subCategories = array_values($this->subCategories);
    }

    public function save()
    {
        $this->validate([
            'subCategories.*.category_id' => 'required|exists:categories,id',
            'subCategories.*.name' => 'required|string|max:255',
            'subCategories.*.image' => 'nullable|image|max:1024',
        ]);

        foreach ($this->subCategories as $subCat) {
            $imagePath = $subCat['image'] ? $subCat['image']->store('subcategories', 'public') : null;

            SubCategory::create([
                'category_id' => $subCat['category_id'],
                'name' => $subCat['name'],
                'slug' => Str::slug($subCat['name']),
                'description' => $subCat['description'],
                'image' => $imagePath,
                'is_featured' => $subCat['is_featured'] ?? false,
                'sort_order' => $subCat['sort_order'] ?? 0,
            ]);
        }

        session()->flash('message', count($this->subCategories).' SubCategories Saved Successfully!');
        $this->subCategories = [];
        $this->addSubCategory();
    }

    public function render()
    {
        return view('livewire.backend.dashboard.sub-category.create-component')->layout('backend.app');
    }
}
