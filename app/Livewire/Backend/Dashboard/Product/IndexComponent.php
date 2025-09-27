<?php

namespace App\Livewire\Backend\Dashboard\Product;

use App\Models\Product;
use App\Traits\WithCustomPagination;
use Livewire\Component;
use Livewire\WithPagination;

class IndexComponent extends Component
{
    use WithCustomPagination,WithPagination;

    public $search = '';

    public $statusFilter = '';

    public $perPage = 10;

    public $selectedProducts = [];

    public $selectAll = false;

    protected $paginationTheme = 'tailwind';

    protected $updatesQueryString = ['search', 'statusFilter', 'perPage'];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProducts = Product::query()
                ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
                ->pluck('id')
                ->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $this->selectedProducts = array_diff($this->selectedProducts, [$id]);
        session()->flash('success', 'Product deleted successfully.');
    }

    public function deleteSelected()
    {
        Product::whereIn('id', $this->selectedProducts)->delete();
        $this->selectedProducts = [];
        $this->selectAll = false;
        session()->flash('success', 'Selected products deleted successfully.');
    }

    public function render()
    {
        $products = Product::query()
            ->with('productDetail') // assuming relation for thumbnail
            ->when($this->search, fn ($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.backend.dashboard.product.index-component', [
            'products' => $products,
            'pageRange' => $this->getPageRange($products),
        ])->layout('backend.app');
    }
}
