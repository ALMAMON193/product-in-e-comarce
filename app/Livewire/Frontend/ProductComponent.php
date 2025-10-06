<?php

namespace App\Livewire\Frontend;

use App\Models\Product;
use App\Models\SubCategory;
use App\Traits\WithCustomPagination;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithCustomPagination, WithPagination;

    public $subCategory = 'all';

    public $priceRanges = [];

    public $sortBy = 'popular';

    public $perPage = 9;

    public $viewMode = 'grid';

    public $subCategories = [];

    public function mount()
    {
        $this->subCategories = SubCategory::all();
    }

    public function updatedSubCategory()
    {
        if ($this->subCategory !== 'all' && ! SubCategory::find($this->subCategory)) {
            $this->subCategory = 'all';
        }
        $this->resetPage();
    }

    public function updatedPriceRanges()
    {
        $this->resetPage();
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    public function render()
    {
        $query = Product::query()
            ->with(['productPricing', 'productDetail'])
            ->where('status', 'active');

        // Filter by subcategory
        if ($this->subCategory !== 'all' && ! empty($this->subCategory)) {
            $query->whereHas('subCategories', function ($q) {
                $q->where('sub_categories.id', $this->subCategory);
            });
        }

        // Filter by price ranges
        if (! empty($this->priceRanges)) {
            $query->where(function ($q) {
                foreach ($this->priceRanges as $range) {
                    $q->orWhereHas('productPricing', function ($pq) use ($range) {
                        $this->applyPriceRange($pq, $range);
                    });
                }
            });
        }

        // Apply sorting
        $this->applySorting($query);

        $products = $query->paginate($this->perPage);

        return view('livewire.frontend.product-component', [
            'products' => $products,
            'subCategories' => $this->subCategories,
            'pageRange' => $this->getPageRange($products),
        ])->layout('frontend.app');
    }

    private function applyPriceRange($query, $range)
    {
        switch ($range) {
            case 'under_25':
                $query->where('price', '<', 25);
                break;
            case '25_50':
                $query->whereBetween('price', [25, 50]);
                break;
            case '50_100':
                $query->whereBetween('price', [50, 100]);
                break;
            case '100_200':
                $query->whereBetween('price', [100, 200]);
                break;
            case 'over_200':
                $query->where('price', '>', 200);
                break;
        }
    }

    private function applySorting($query)
    {
        switch ($this->sortBy) {
            case 'price_low_to_high':
                $query->leftJoin('product_pricings', 'products.id', '=', 'product_pricings.product_id')
                    ->orderByRaw('COALESCE(product_pricings.price, 0) ASC')
                    ->select('products.*');
                break;

            case 'price_high_to_low':
                $query->leftJoin('product_pricings', 'products.id', '=', 'product_pricings.product_id')
                    ->orderByRaw('COALESCE(product_pricings.price, 0) DESC')
                    ->select('products.*');
                break;

            case 'newest':
                $query->orderBy('products.created_at', 'desc');
                break;

            default: // popular
                $query->orderBy('products.sort_order', 'asc')
                    ->orderBy('products.created_at', 'desc');
                break;
        }
    }
}
