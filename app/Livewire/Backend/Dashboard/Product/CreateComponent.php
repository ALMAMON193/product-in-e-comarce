<?php

namespace App\Livewire\Backend\Dashboard\Product;

use App\Helpers\Helper;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductFile;
use App\Models\ProductPricing;
use App\Models\ProductTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateComponent extends Component
{
    use WithFileUploads;

    public $categories;

    public $expandedCategories = [];

    public $tags = [''];

    public $selectedSubCategoriesMultiple = [];

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

    public $price = null;

    public $sale_price = null;

    public $cost_price = null;

    public $stock_quantity = 0;

    public $stock_status = 'in_stock';

    public $files = [];

    public $is_featured = false;

    public $sort_order = 0;

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
            'tags' => 'required|array|min:1|max:20',
            'tags.*' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0|max:999999.99',
            'sale_price' => 'nullable|numeric|min:0|max:999999.99|lt:price',
            'cost_price' => 'nullable|numeric|min:0|max:999999.99',
            'stock_quantity' => 'nullable|integer|min:0|max:999999',
            'stock_status' => 'required|in:in_stock,out_of_stock,preorder',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx,zip,rar,jpg,jpeg,png,gif|max:5120',
            'is_featured' => 'boolean',
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

    public function mount()
    {
        $this->categories = Category::where('status', 'active')
            ->with('subCategories')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
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

    public function removeImageFile($index)
    {
        if (isset($this->files[$index])) {
            unset($this->files[$index]);
            $this->files = array_values($this->files);
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
        } else {
            $this->selectedSubCategoriesMultiple[$categoryId][] = $subCategoryId;
        }

        if (empty($this->selectedSubCategoriesMultiple[$categoryId])) {
            unset($this->selectedSubCategoriesMultiple[$categoryId]);
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

    // Real-time validation methods
    public function updatedSku()
    {
        $this->validateOnly('sku');
    }

    public function updatedPrice()
    {
        $this->validateOnly('price');
    }

    public function updatedSalePrice()
    {
        $this->validateOnly('sale_price');
    }

    public function updatedTags()
    {
        $this->validateOnly('tags');
    }

    public function save()
    {
        // Remove empty tags and reindex
        $this->tags = array_values(array_filter($this->tags, function ($tag) {
            return trim($tag) !== '';
        }));

        $this->validate();

        try {
            DB::beginTransaction();

            $product = Product::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'sku' => $this->sku,
                'short_description' => $this->short_description ?? null,
                'description' => $this->description ?? null,
                'status' => 'active',
                'is_featured' => $this->is_featured ?? false,
                'sort_order' => $this->sort_order ?? 0,
            ]);

            ProductDetail::create([
                'product_id' => $product->id,
                'thumbnail' => $this->thumbnail ? Helper::uploadFile('product_thumbnails', $this->thumbnail) : null,
                'weight' => $this->weight,
                'length' => $this->length,
                'width' => $this->width,
                'height' => $this->height,
            ]);

            ProductPricing::create([
                'product_id' => $product->id,
                'price' => $this->price ?? 0,
                'sale_price' => $this->sale_price,
                'cost_price' => $this->cost_price,
                'stock_quantity' => $this->stock_quantity ?? 0,
                'stock_status' => $this->stock_status ?? 'in_stock',
            ]);

            // Handle file uploads (fixed: use $file)
            if (! empty($this->files)) {
                foreach ($this->files as $file) {
                    ProductFile::create([
                        'product_id' => $product->id,
                        'file_path' => $file ? Helper::uploadFile('image-gallery', $file) : null,
                    ]);
                }
            }

            // Tags
            if (! empty($this->tags)) {
                foreach ($this->tags as $tag) {
                    $tag = trim($tag);
                    if ($tag !== '') {
                        ProductTag::create([
                            'product_id' => $product->id,
                            'name' => $tag,
                        ]);
                    }
                }
            }

            // Subcategories (many-to-many attach)
            if (! empty($this->selectedSubCategoriesMultiple)) {
                $subCategoryIds = [];
                foreach ($this->selectedSubCategoriesMultiple as $categoryId => $subCategoryIds_array) {
                    foreach ($subCategoryIds_array as $subCategoryId) {
                        $subCategoryIds[] = $subCategoryId;
                    }
                }
                if (! empty($subCategoryIds)) {
                    $product->subCategories()->attach($subCategoryIds);
                }
            }

            DB::commit();

            session()->flash('message', 'Product created successfully!');
            $this->resetForm();

            $this->redirectRoute('product.index');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Product creation error: '.$e->getMessage());
            Log::error('Stack trace: '.$e->getTraceAsString());
            session()->flash('error', 'There was an error creating the product: '.$e->getMessage());
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
        $this->tags = [''];
        $this->is_featured = false;

        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.backend.dashboard.product.create-component')->layout('backend.app');
    }
}
