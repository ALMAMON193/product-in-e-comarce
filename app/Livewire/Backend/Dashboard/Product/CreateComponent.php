<?php

namespace App\Livewire\Backend\Dashboard\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductFile;
use App\Models\ProductPricing;
use App\Models\ProductTag;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateComponent extends Component
{
    use WithFileUploads;

    public $categories;

    public $subCategories; // keep if needed elsewhere

    // Collapsible multi-category
    public $expandedCategories = [];

    public $selectedSubCategoriesMultiple = []; // [category_id => [sub_category_id, ...]]

    // Product fields
    public $name = '';

    public $slug = '';

    public $sku = '';

    public $short_description = '';

    public $description = '';

    public $thumbnail = null;

    public $weight = null;

    public $length = null;

    public $width = null;

    public $height = null;

    public $tags = '';

    public $price = null;

    public $sale_price = null;

    public $cost_price = null;

    public $stock_quantity = 0;

    public $stock_status = 'in_stock';

    public $files = [];

    public $is_featured = false;

    public $sort_order = 0;

    // Validation state tracking
    public $validationState = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'sku' => [
                'required', 'string', 'min:3', 'max:50', 'regex:/^[A-Za-z0-9\-_]+$/',
                Rule::unique('products', 'sku'),
            ],
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:5000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'weight' => 'nullable|numeric|min:0|max:99999.99',
            'length' => 'nullable|numeric|min:0|max:9999.99',
            'width' => 'nullable|numeric|min:0|max:9999.99',
            'height' => 'nullable|numeric|min:0|max:9999.99',
            'tags' => 'nullable|string|max:1000',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'sale_price' => 'nullable|numeric|min:0|max:999999.99|lt:price',
            'cost_price' => 'nullable|numeric|min:0|max:999999.99',
            'stock_quantity' => 'nullable|integer|min:0|max:999999',
            'stock_status' => 'required|in:in_stock,out_of_stock,preorder',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,zip,rar|max:5120',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer|min:0|max:999999',
            'selectedSubCategoriesMultiple' => 'required|array|min:1',
        ];
    }

    public function mount()
    {
        $this->categories = Category::where('status', 'active')->orderBy('sort_order')->orderBy('name')->get();
        $this->subCategories = collect();
        $this->validationState = [];
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
        } else {
            $this->selectedSubCategoriesMultiple[$categoryId][] = $subCategoryId;
        }
    }

    public function updatedName($value)
    {
        if ($value) {
            $slug = Str::slug($value);
            $originalSlug = $slug;
            $counter = 1;

            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug.'-'.$counter;
                $counter++;
            }

            $this->slug = $slug;
        } else {
            $this->slug = '';
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $product = Product::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'sku' => $this->sku,
                'short_description' => $this->short_description ?? null,
                'description' => $this->description ?? null,
                'status' => 'active',
                'sort_order' => $this->sort_order ?? 0,
            ]);

            ProductDetail::create([
                'product_id' => $product->id,
                'thumbnail' => $this->thumbnail ? $this->thumbnail->store('thumbnails', 'public') : null,
                'weight' => $this->weight,
                'length' => $this->length,
                'width' => $this->width,
                'height' => $this->height,
                'tags' => $this->tags,
            ]);

            ProductPricing::create([
                'product_id' => $product->id,
                'price' => $this->price ?? 0,
                'sale_price' => $this->sale_price,
                'cost_price' => $this->cost_price,
                'stock_quantity' => $this->stock_quantity ?? 0,
                'stock_status' => $this->stock_status ?? 'in_stock',
            ]);

            if (! empty($this->files)) {
                foreach ($this->files as $file) {
                    ProductFile::create([
                        'product_id' => $product->id,
                        'file_path' => $file->store('project_files', 'public'),
                    ]);
                }
            }

            if (! empty($this->tags)) {
                $tags = array_filter(array_map('trim', explode(',', $this->tags)));
                foreach ($tags as $tag) {
                    ProductTag::create([
                        'product_id' => $product->id,
                        'name' => $tag,
                    ]);
                }
            }

            // Attach multiple category-subcategory pairs
            foreach ($this->selectedSubCategoriesMultiple as $categoryId => $subCategoryIds) {
                foreach ($subCategoryIds as $subCategoryId) {
                    $product->categories()->attach($categoryId, ['sub_category_id' => $subCategoryId]);
                }
            }

            session()->flash('message', 'Product created successfully!');
            $this->resetForm();

        } catch (\Exception $e) {
            logger('Product creation error: '.$e->getMessage());
            session()->flash('error', 'There was an error creating the product. Please try again.');
        }
    }

    public function resetForm()
    {
        $this->reset([
            'selectedSubCategoriesMultiple', 'name', 'slug', 'sku', 'short_description', 'description',
            'thumbnail', 'weight', 'length', 'width', 'height', 'tags', 'price', 'sale_price', 'cost_price',
            'stock_quantity', 'stock_status', 'files', 'is_featured', 'sort_order',
        ]);

        $this->expandedCategories = [];
        $this->stock_status = 'in_stock';
        $this->stock_quantity = 0;
        $this->sort_order = 0;

        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.backend.dashboard.product.create-component')->layout('backend.app');
    }
}
