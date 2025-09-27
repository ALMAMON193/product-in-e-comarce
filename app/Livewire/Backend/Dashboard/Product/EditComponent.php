<?php

namespace App\Livewire\Backend\Dashboard\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use WithFileUploads;

    public $slug;

    public $product;

    public $name;

    public $sku;

    public $weight;

    public $length;

    public $width;

    public $height;

    public $short_description;

    public $description;

    public $is_featured = false;

    public $price;

    public $sale_price;

    public $cost_price;

    public $stock_quantity;

    public $stock_status = 'in_stock';

    public $sort_order;

    public $thumbnail;

    public $thumbnailUploading = false;

    public $thumbnailCompleted = false;

    public $files = [];

    public $imagesUploading = [];

    public $imagesCompleted = [];

    public $tags = [''];

    public $categories = [];

    public $expandedCategories = [];

    public $selectedSubCategoriesMultiple = [];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::with('subCategories', 'productTags', 'productFiles', 'productPricing', 'productDetail')->where('slug', $slug)->firstOrFail();
        $this->name = $this->product->name;
        $this->sku = $this->product->sku;
        $this->weight = $this->product->productDetail->weight;
        $this->weight = $this->product->productDetail->thumbnail;
        $this->length = $this->product->productDetail->length;
        $this->width = $this->product->productDetail->width;
        $this->height = $this->product->productDetail->height;
        $this->short_description = $this->product->short_description;
        $this->description = $this->product->description;
        $this->is_featured = $this->product->is_featured;
        $this->price = $this->product->productPricing->price;
        $this->sale_price = $this->product->productPricing->sale_price;
        $this->cost_price = $this->product->productPricing->cost_price;
        $this->stock_quantity = $this->product->stock_quantity;
        $this->stock_status = $this->product->stock_status;
        $this->sort_order = $this->product->sort_order;
        $this->tags = $this->product->productTags->pluck('name')->toArray();

        $this->categories = Category::with('subCategories')->get();

        // Populate selected subcategories
        foreach ($this->product->subCategories as $subCategory) {
            $this->selectedSubCategoriesMultiple[$subCategory->category_id][] = $subCategory->id;
        }
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->expandedCategories)) {
            $this->expandedCategories = array_diff($this->expandedCategories, [$categoryId]);
        } else {
            $this->expandedCategories[] = $categoryId;
        }
    }

    public function toggleSubCategory($categoryId, $subCategoryId)
    {
        if (! isset($this->selectedSubCategoriesMultiple[$categoryId])) {
            $this->selectedSubCategoriesMultiple[$categoryId] = [];
        }

        if (in_array($subCategoryId, $this->selectedSubCategoriesMultiple[$categoryId])) {
            $this->selectedSubCategoriesMultiple[$categoryId] = array_diff(
                $this->selectedSubCategoriesMultiple[$categoryId],
                [$subCategoryId]
            );
            if (empty($this->selectedSubCategoriesMultiple[$categoryId])) {
                unset($this->selectedSubCategoriesMultiple[$categoryId]);
            }
        } else {
            $this->selectedSubCategoriesMultiple[$categoryId][] = $subCategoryId;
        }
    }

    public function addTagField()
    {
        $this->tags[] = '';
    }

    public function removeTagField($index)
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags);
    }

    public function removeImageFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files);
        unset($this->imagesUploading[$index]);
        unset($this->imagesCompleted[$index]);
    }

    public function removeExistingImage($index)
    {
        $existingImages = $this->product->images ? json_decode($this->product->images, true) : [];
        if (isset($existingImages[$index])) {
            Storage::delete($existingImages[$index]);
            unset($existingImages[$index]);
            $this->product->update(['images' => json_encode(array_values($existingImages))]);
            $this->product = $this->product->fresh(); // Refresh the product to reflect changes
        }
    }

    public function updatedThumbnail()
    {
        $this->thumbnailUploading = true;
        $this->thumbnailCompleted = false;
    }

    public function updatedFiles()
    {
        $this->imagesUploading = array_fill(0, count($this->files), true);
        $this->imagesCompleted = array_fill(0, count($this->files), false);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,'.$this->product->id,
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'is_featured' => 'boolean',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,preorder',
            'sort_order' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:102400', // 100MB, added mimes
            'files.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120000', // 5GB each, added mimes
            'tags.*' => 'nullable|string|max:50',
            'selectedSubCategoriesMultiple' => 'required|array|min:1',
        ]);

        // Handle thumbnail upload
        if ($this->thumbnail) {
            if ($this->product->thumbnail) {
                Storage::delete($this->product->thumbnail);
            }
            $thumbnailPath = $this->thumbnail->store('thumbnails', 'public');
            $this->product->thumbnail = $thumbnailPath;
        }

        // Handle gallery images
        $existingImages = $this->product->images ? json_decode($this->product->images, true) : [];
        if ($this->files) {
            foreach ($this->files as $file) {
                $path = $file->store('gallery', 'public');
                $existingImages[] = $path;
            }
        }
        $this->product->images = json_encode($existingImages);

        // Update product data
        $this->product->update([
            'name' => $this->name,
            'sku' => $this->sku,
            'weight' => $this->weight,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'is_featured' => $this->is_featured,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'cost_price' => $this->cost_price,
            'stock_quantity' => $this->stock_quantity,
            'stock_status' => $this->stock_status,
            'sort_order' => $this->sort_order,
            'tags' => json_encode(array_filter($this->tags)),
            'slug' => \Str::slug($this->name),
        ]);

        // Sync subcategories
        $subCategoryIds = [];
        foreach ($this->selectedSubCategoriesMultiple as $subCategories) {
            $subCategoryIds = array_merge($subCategoryIds, $subCategories);
        }
        $this->product->subCategories()->sync($subCategoryIds);

        $this->thumbnailUploading = false;
        $this->thumbnailCompleted = true;
        $this->imagesUploading = [];
        $this->imagesCompleted = array_fill(0, count($this->files), true);
        $this->files = []; // Clear uploaded files after save

        session()->flash('message', 'Product updated successfully!');
        $this->redirectRoute('dashboard.products.edit', $this->product->slug);
    }

    public function resetForm()
    {
        $this->name = $this->product->name;
        $this->sku = $this->product->sku;
        $this->weight = $this->product->weight;
        $this->length = $this->product->length;
        $this->width = $this->product->width;
        $this->height = $this->product->height;
        $this->short_description = $this->product->short_description;
        $this->description = $this->product->description;
        $this->is_featured = $this->product->is_featured;
        $this->price = $this->product->price;
        $this->sale_price = $this->product->sale_price;
        $this->cost_price = $this->product->cost_price;
        $this->stock_quantity = $this->product->stock_quantity;
        $this->stock_status = $this->product->stock_status;
        $this->sort_order = $this->product->sort_order;
        $this->tags = $this->product->tags ? json_decode($this->product->tags, true) : [''];
        $this->thumbnail = null;
        $this->files = [];
        $this->selectedSubCategoriesMultiple = [];
        foreach ($this->product->subCategories as $subCategory) {
            $this->selectedSubCategoriesMultiple[$subCategory->category_id][] = $subCategory->id;
        }
        $this->thumbnailUploading = false;
        $this->thumbnailCompleted = false;
        $this->imagesUploading = [];
        $this->imagesCompleted = [];
    }

    public function render()
    {
        return view('livewire.backend.dashboard.product.edit-component')->layout('backend.app');
    }
}
