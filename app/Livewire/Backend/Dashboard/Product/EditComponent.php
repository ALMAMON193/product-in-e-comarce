<?php

namespace App\Livewire\Backend\Dashboard\Product;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductFile;
use App\Models\ProductTag;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditComponent extends Component
{
    use WithFileUploads;

    public $slug;

    public $product;

    public $categories;

    public $expandedCategories = [];

    public $tags = [''];

    public $selectedSubCategoriesMultiple = [];

    // Product fields
    public $name = '';

    public $sku = '';

    public $short_description = '';

    public $description = '';

    public $thumbnail = null;

    public $weight = null;

    public $length = null;

    public $width = null;

    public $height = null;

    public $price = null;

    public $sale_price = null;

    public $cost_price = null;

    public $stock_quantity = 0;

    public $stock_status = 'in_stock';

    public $files = [];

    public $is_featured = false;

    public $sort_order = 0;

    // File upload states
    public $thumbnailUploading = false;

    public $thumbnailCompleted = false;

    public $filesUploadData = [];

    public $imagesUploading = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'sku' => [
                'required', 'string', 'min:3', 'max:50', 'regex:/^[A-Za-z0-9\-_]+$/',
                Rule::unique('products', 'sku')->ignore($this->product->id),
            ],
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:5000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight' => 'nullable|numeric|min:0|max:99999.99',
            'length' => 'nullable|numeric|min:0|max:9999.99',
            'width' => 'nullable|numeric|min:0|max:9999.99',
            'height' => 'nullable|numeric|min:0|max:9999.99',
            'tags' => 'required|array|min:1|max:20',
            'tags.*' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'sale_price' => 'nullable|numeric|min:0|max:999999.99|lt:price',
            'cost_price' => 'nullable|numeric|min:0|max:999999.99',
            'stock_quantity' => 'nullable|integer|min:0|max:999999',
            'stock_status' => 'required|in:in_stock,out_of_stock,preorder',
            'filesUploadData.*.file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'is_featured' => 'required|boolean',
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'selectedSubCategoriesMultiple' => 'required|array|min:1',
        ];
    }

    protected function messages()
    {
        return [
            'tags.required' => 'At least one product tag is required.',
            'tags.min' => 'Please provide at least one product tag.',
            'tags.*.required' => 'Tag field cannot be empty.',
            'tags.*.max' => 'Each tag must not exceed 255 characters.',
            'selectedSubCategoriesMultiple.required' => 'Please select at least one category.',
            'selectedSubCategoriesMultiple.min' => 'Please select at least one category.',
        ];
    }

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::with([
            'subCategories',
            'productTags',
            'productDetail',
            'productFiles',
            'productPricing',
        ])->where('slug', $slug)->firstOrFail();

        // Load categories
        $this->categories = Category::where('status', 'active')
            ->with('subCategories')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Basic product info with proper type conversion
        $this->name = $this->product->name;
        $this->sku = $this->product->sku;
        $this->short_description = $this->product->short_description;
        $this->description = $this->product->description;
        $this->is_featured = (bool) $this->product->is_featured;
        $this->sort_order = $this->product->sort_order ? (int) $this->product->sort_order : 0;

        // Product details with proper type conversion
        if ($this->product->productDetail) {
            $this->weight = $this->product->productDetail->weight ? (float) $this->product->productDetail->weight : null;
            $this->length = $this->product->productDetail->length ? (float) $this->product->productDetail->length : null;
            $this->width = $this->product->productDetail->width ? (float) $this->product->productDetail->width : null;
            $this->height = $this->product->productDetail->height ? (float) $this->product->productDetail->height : null;
        }

        // Pricing with proper type conversion
        if ($this->product->productPricing) {
            $this->price = $this->product->productPricing->price ? (float) $this->product->productPricing->price : null;
            $this->sale_price = $this->product->productPricing->sale_price ? (float) $this->product->productPricing->sale_price : null;
            $this->cost_price = $this->product->productPricing->cost_price ? (float) $this->product->productPricing->cost_price : null;
            $this->stock_quantity = (int) $this->product->productPricing->stock_quantity;
            $this->stock_status = $this->product->productPricing->stock_status;
        }

        // Tags - get names from ProductTag model
        $productTags = $this->product->productTags->pluck('name')->toArray();
        $this->tags = ! empty($productTags) ? $productTags : [''];

        // Categories - load selected subcategories
        $this->selectedSubCategoriesMultiple = [];
        foreach ($this->product->subCategories as $subCategory) {
            $this->selectedSubCategoriesMultiple[$subCategory->category_id][] = $subCategory->id;
        }
    }

    // Add these methods to handle boolean and numeric conversions
    public function updatedIsFeatured($value)
    {
        $this->is_featured = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function updatedPrice($value)
    {
        $this->price = is_numeric($value) ? (float) $value : null;
    }

    public function updatedSalePrice($value)
    {
        $this->sale_price = is_numeric($value) && $value !== '' ? (float) $value : null;
    }

    public function updatedCostPrice($value)
    {
        $this->cost_price = is_numeric($value) && $value !== '' ? (float) $value : null;
    }

    public function updatedStockQuantity($value)
    {
        $this->stock_quantity = is_numeric($value) ? (int) $value : 0;
    }

    public function updatedSortOrder($value)
    {
        $this->sort_order = is_numeric($value) && $value !== '' ? (int) $value : 0;
    }

    public function updatedWeight($value)
    {
        $this->weight = is_numeric($value) && $value !== '' ? (float) $value : null;
    }

    public function updatedLength($value)
    {
        $this->length = is_numeric($value) && $value !== '' ? (float) $value : null;
    }

    public function updatedWidth($value)
    {
        $this->width = is_numeric($value) && $value !== '' ? (float) $value : null;
    }

    public function updatedHeight($value)
    {
        $this->height = is_numeric($value) && $value !== '' ? (float) $value : null;
    }

    public function updatedName($value)
    {
        if ($value) {
            $slug = Str::slug($value);
            $originalSlug = $slug;
            $counter = 1;

            // Check if slug exists, excluding current product
            while (Product::where('slug', $slug)->where('id', '!=', $this->product->id)->exists()) {
                $slug = $originalSlug.'-'.$counter;
                $counter++;
            }

            $this->product->slug = $slug;
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
        if (count($this->tags) > 1) {
            unset($this->tags[$index]);
            $this->tags = array_values($this->tags);
        }
    }

    public function updatedFiles()
    {
        $this->imagesUploading = [];

        foreach ($this->files as $index => $file) {
            $this->filesUploadData[] = [
                'file' => $file,
                'completed' => false,
            ];
            $this->imagesUploading[] = true;
        }

        $this->files = [];
        $this->dispatch('files-processed');
    }

    public function removeImageFile($index)
    {
        if (isset($this->filesUploadData[$index])) {
            unset($this->filesUploadData[$index]);
            $this->filesUploadData = array_values($this->filesUploadData);

            if (isset($this->imagesUploading[$index])) {
                unset($this->imagesUploading[$index]);
                $this->imagesUploading = array_values($this->imagesUploading);
            }
        }
    }

    public function removeExistingImage($index)
    {
        try {
            DB::beginTransaction();

            $productFiles = $this->product->productFiles;

            if (isset($productFiles[$index])) {
                $productFile = $productFiles[$index];

                // Delete the physical file
                if (file_exists(public_path($productFile->file_path))) {
                    unlink(public_path($productFile->file_path));
                }

                // Delete from database
                $deleted = $productFile->delete();

                if ($deleted) {
                    DB::commit();

                    // Refresh the product
                    $this->product = $this->product->fresh(['productFiles']);

                    session()->flash('message', 'Image removed successfully!');

                    $this->dispatch('image-removed', [
                        'message' => 'Image removed successfully!',
                    ]);

                } else {
                    throw new \Exception('Failed to delete image from database');
                }

            } else {
                throw new \Exception('Image not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Failed to remove image', [
                'product_id' => $this->product->id,
                'index' => $index,
                'error' => $e->getMessage(),
            ]);

            session()->flash('error', 'Failed to remove image: '.$e->getMessage());
        }
    }

    public function updatedThumbnail()
    {
        $this->thumbnailUploading = true;
        $this->thumbnailCompleted = false;
    }

    public function save()
    {
        try {
            // Filter out empty tags and convert boolean
            $this->tags = array_filter(array_map('trim', $this->tags));
            $this->tags = array_values($this->tags);
            $this->is_featured = filter_var($this->is_featured, FILTER_VALIDATE_BOOLEAN);

            $this->validate();

            DB::beginTransaction();

            // Upload thumbnail if provided
            $thumbnailPath = null;
            if ($this->thumbnail) {
                // Delete old thumbnail if exists
                if ($this->product->productDetail?->thumbnail) {
                    Helper::deleteFile($this->product->productDetail->thumbnail);
                }
                $thumbnailPath = Helper::uploadFile('product_thumbnails', $this->thumbnail);
                $this->thumbnailUploading = false;
                $this->thumbnailCompleted = true;
            }

            // Check file upload limits
            $currentImageCount = $this->product->productFiles()->count();
            $newImageCount = count($this->filesUploadData);

            if ($currentImageCount + $newImageCount > 20) {
                DB::rollBack();
                session()->flash('error', 'You can upload a maximum of 20 images total. Currently you have '.$currentImageCount.' images.');

                return;
            }

            // Upload new gallery images
            foreach ($this->filesUploadData as $key => $fileData) {
                if (! $fileData['completed']) {
                    // Use your Helper to move file into `uploads/product_files` folder
                    $path = Helper::uploadFile('product_files', $fileData['file']);

                    // Create a ProductFile record
                    ProductFile::create([
                        'product_id' => $this->product->id,
                        'file_path' => $path,
                    ]);

                    // Mark as completed
                    $this->filesUploadData[$key]['completed'] = true;
                }
            }

            // Update main product
            $productUpdated = $this->product->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'sku' => $this->sku,
                'short_description' => $this->short_description ?? null,
                'description' => $this->description ?? null,
                'is_featured' => $this->is_featured ?? false,
                'sort_order' => $this->sort_order ?? 0,
                'updated_at' => now(),
            ]);

            if (! $productUpdated) {
                throw new Exception('Failed to update product basic information');
            }

            // Update or create product details
            $this->product->productDetail()->updateOrCreate(
                ['product_id' => $this->product->id],
                [
                    'thumbnail' => $thumbnailPath ?: ($this->product->productDetail?->thumbnail ?? null),
                    'weight' => $this->weight,
                    'length' => $this->length,
                    'width' => $this->width,
                    'height' => $this->height,
                    'updated_at' => now(),
                ]
            );

            // Update or create pricing
            $this->product->productPricing()->updateOrCreate(
                ['product_id' => $this->product->id],
                [
                    'price' => $this->price ?? 0,
                    'sale_price' => $this->sale_price,
                    'cost_price' => $this->cost_price,
                    'stock_quantity' => $this->stock_quantity ?? 0,
                    'stock_status' => $this->stock_status ?? 'in_stock',
                    'updated_at' => now(),
                ]
            );

            // Update tags - Delete existing and create new (based on your CreateComponent structure)
            $this->product->productTags()->delete();

            if (! empty($this->tags)) {
                foreach ($this->tags as $tag) {
                    if (trim($tag) !== '') {
                        ProductTag::create([
                            'product_id' => $this->product->id,
                            'name' => trim($tag),
                        ]);
                    }
                }
            }

            // Sync subcategories
            $subCategoryIds = [];
            foreach ($this->selectedSubCategoriesMultiple as $categoryId => $subCategoryIds_array) {
                foreach ($subCategoryIds_array as $subCategoryId) {
                    $subCategoryIds[] = $subCategoryId;
                }
            }

            if (! empty($subCategoryIds)) {
                $this->product->subCategories()->sync($subCategoryIds);
            }

            DB::commit();

            // Reset uploads after successful save
            $this->filesUploadData = [];
            $this->imagesUploading = [];
            $this->thumbnail = null;
            $this->thumbnailUploading = false;

            // Refresh product data
            $this->product = Product::with([
                'subCategories',
                'productTags',
                'productDetail',
                'productFiles',
                'productPricing',
            ])->find($this->product->id);

            // Reset categories and tags display
            $this->selectedSubCategoriesMultiple = [];
            foreach ($this->product->subCategories as $subCategory) {
                $this->selectedSubCategoriesMultiple[$subCategory->category_id][] = $subCategory->id;
            }

            $productTags = $this->product->productTags->pluck('name')->toArray();
            $this->tags = ! empty($productTags) ? $productTags : [''];

            session()->flash('message', 'Product "'.$this->product->name.'" updated successfully!');

            $this->dispatch('product-updated', [
                'product_name' => $this->product->name,
                'message' => 'Product updated successfully!',
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to update product: '.$e->getMessage());
        }
    }

    public function resetForm()
    {
        // Reset to original values with proper type conversion
        $this->name = $this->product->name;
        $this->sku = $this->product->sku;
        $this->short_description = $this->product->short_description;
        $this->description = $this->product->description;
        $this->is_featured = (bool) $this->product->is_featured;
        $this->sort_order = $this->product->sort_order ? (int) $this->product->sort_order : 0;

        // Product details
        if ($this->product->productDetail) {
            $this->weight = $this->product->productDetail->weight ? (float) $this->product->productDetail->weight : null;
            $this->length = $this->product->productDetail->length ? (float) $this->product->productDetail->length : null;
            $this->width = $this->product->productDetail->width ? (float) $this->product->productDetail->width : null;
            $this->height = $this->product->productDetail->height ? (float) $this->product->productDetail->height : null;
        }

        // Pricing
        if ($this->product->productPricing) {
            $this->price = $this->product->productPricing->price ? (float) $this->product->productPricing->price : null;
            $this->sale_price = $this->product->productPricing->sale_price ? (float) $this->product->productPricing->sale_price : null;
            $this->cost_price = $this->product->productPricing->cost_price ? (float) $this->product->productPricing->cost_price : null;
            $this->stock_quantity = (int) $this->product->productPricing->stock_quantity;
            $this->stock_status = $this->product->productPricing->stock_status;
        }

        // Tags
        $productTags = $this->product->productTags->pluck('name')->toArray();
        $this->tags = ! empty($productTags) ? $productTags : [''];

        // Reset file uploads
        $this->thumbnail = null;
        $this->files = [];
        $this->filesUploadData = [];
        $this->imagesUploading = [];
        $this->thumbnailUploading = false;
        $this->thumbnailCompleted = false;

        // Reset categories
        $this->selectedSubCategoriesMultiple = [];
        foreach ($this->product->subCategories as $subCategory) {
            $this->selectedSubCategoriesMultiple[$subCategory->category_id][] = $subCategory->id;
        }

        $this->resetValidation();
        session()->flash('message', 'Form reset successfully!');
    }

    // Real-time validation methods
    public function updatedSku()
    {
        $this->validateOnly('sku');
    }

    public function updatedTags()
    {
        $this->validateOnly('tags');
    }

    public function render()
    {
        return view('livewire.backend.dashboard.product.edit-component')->layout('backend.app');
    }
}
