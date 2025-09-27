<?php

namespace App\Livewire\Frontend;

use App\Models\Product;
use App\Models\SubCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ProductComponent extends Component
{
    use WithPagination;

    public $subCategory = 'all';

    public $priceRanges = [];

    public $sortBy = 'popular';

    public $perPage = 9;

    public $viewMode = 'grid';

    public $subCategories = [];

    public function mount()
    {
        $this->subCategories = SubCategory::all();
        \Log::info('SubCategories loaded: '.$this->subCategories->count());
    }

    public function updatedSubCategory()
    {
        \Log::info('SubCategory updated to: '.$this->subCategory);
        if ($this->subCategory !== 'all' && ! SubCategory::find($this->subCategory)) {
            $this->subCategory = 'all';
            \Log::warning('Invalid subcategory selected, resetting to all');
        }
        $this->resetPage();
    }

    public function updatedPriceRanges()
    {
        \Log::info('Price ranges updated: '.json_encode($this->priceRanges));
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

        // Apply subcategory filter
        if ($this->subCategory !== 'all' && ! empty($this->subCategory)) {
            $query->whereHas('subCategories', function ($q) {
                $q->where('sub_categories.id', $this->subCategory);
            });
        }

        // Apply price range filters
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

        // Get paginated results
        $products = $query->paginate($this->perPage);

        \Log::info('Query SQL: '.$query->toSql());
        \Log::info('Bindings: '.json_encode($query->getBindings()));
        \Log::info('Products count: '.$products->count());

        return view('livewire.frontend.product-component', [
            'products' => $products,
            'subCategories' => $this->subCategories,
        ])->layout('frontend.app');
    }

    private function applyPriceRange($query, $range)
    {
        switch ($range) {
            case 'under_25':
                $query->where('price', '<', 25);
                break;
            case '25_50':
                $query->where('price', '>=', 25)->where('price', '<=', 50);
                break;
            case '50_100':
                $query->where('price', '>=', 50)->where('price', '<=', 100);
                break;
            case '100_200':
                $query->where('price', '>=', 100)->where('price', '<=', 200);
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
