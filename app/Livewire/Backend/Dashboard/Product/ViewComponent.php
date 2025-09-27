<?php

namespace App\Livewire\Backend\Dashboard\Product;

use App\Models\Product;
use Livewire\Component;

class ViewComponent extends Component
{
    public $slug;

    public $product;

    public function mount($slug)
    {
        $this->slug = $slug;
        // Load product with all relationships
        $this->product = Product::with([
            'productDetail',
            'productPricing',
            'productTags',
            'productFiles',
            'subCategories.category',
        ])->where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.backend.dashboard.product.view-component')->layout('backend.app');
    }
}
