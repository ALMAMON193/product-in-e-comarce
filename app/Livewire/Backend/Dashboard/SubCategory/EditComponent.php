<?php

namespace App\Livewire\Backend\Dashboard\SubCategory;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use WithFileUploads;

    public $subCategoryId;

    public $categories;

    public $category_id;

    public $name;

    public $description;

    public $image;      // New uploaded image

    public $oldImage;   // Old image path

    public $is_featured = false;

    public $sort_order = 0;

    // Add protected $rules property for better validation
    protected function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:sub_categories,name,'.$this->subCategoryId,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:102400', // 100MB = 102400KB
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function mount($slug)
    {
        $this->categories = Category::all();
        $subCategory = SubCategory::where('slug', $slug)->firstOrFail();

        // Set all properties
        $this->subCategoryId = $subCategory->id;
        $this->category_id = $subCategory->category_id;
        $this->name = $subCategory->name;
        $this->description = $subCategory->description;
        $this->oldImage = $subCategory->image;
        $this->is_featured = (bool) $subCategory->is_featured; // Ensure boolean
        $this->sort_order = $subCategory->sort_order ?? 0;
    }

    public function updatedImage()
    {
        // Clear previous errors
        $this->resetErrorBag('image');

        if ($this->image) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (! in_array(strtolower($this->image->extension()), $allowedExtensions)) {
                $this->reset('image');
                $this->addError('image', 'Please select a valid image file (jpg, jpeg, png, webp, gif).');

                return;
            }

            // Validate file size (100MB = 104857600 bytes)
            if ($this->image->getSize() > 104857600) {
                $this->reset('image');
                $this->addError('image', 'Image size must be less than 100MB.');

                return;
            }
        }
    }

    public function update()
    {
        // Validate the form data
        $validatedData = $this->validate();

        try {
            $subCategory = SubCategory::findOrFail($this->subCategoryId);

            // Handle image upload
            $imagePath = $this->oldImage;

            if ($this->image) {
                // Delete old image if it exists
                if ($this->oldImage && file_exists(public_path($this->oldImage))) {
                    Helper::deleteFile($this->oldImage);
                }

                // Upload new image
                $imagePath = Helper::uploadFile('subcategories', $this->image);
            }

            // Update the subcategory
            $subCategory->update([
                'category_id' => $this->category_id,
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'image' => $imagePath,
                'is_featured' => $this->is_featured ? 1 : 0,
                'sort_order' => (int) $this->sort_order,
            ]);

            // Clear the image property to avoid conflicts
            $this->reset('image');

            // Flash success message
            session()->flash('message', 'SubCategory updated successfully!');

            // Redirect to index page
            return $this->redirect(route('sub.categories.index'), navigate: true);

        } catch (\Exception $e) {
            // Handle any errors
            $this->addError('general', 'An error occurred while updating the subcategory: '.$e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.dashboard.sub-category.edit-component')
            ->layout('backend.app');
    }
}
