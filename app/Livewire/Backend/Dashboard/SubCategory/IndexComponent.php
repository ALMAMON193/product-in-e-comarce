<?php

namespace App\Livewire\Backend\Dashboard\SubCategory;

use App\Models\SubCategory;
use App\Traits\WithCustomPagination;
use Livewire\Component;
use Livewire\WithPagination;

class IndexComponent extends Component
{
    use WithCustomPagination,WithPagination;

    public $search = '';

    public $statusFilter = '';

    public $perPage = 10;

    protected $paginationTheme = 'tailwind';

    // Reset pagination when search or filter changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    // Delete product
    public function delete($id)
    {
        $product = SubCategory::find($id);
        if ($product) {
            $product->delete();
            session()->flash('message', 'Product deleted successfully!');
        }
    }

    public function render()
    {
        $subCategories = SubCategory::query()
            ->when($this->search, fn ($query) => $query->where('name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter, fn ($query) => $query->where('status', $this->statusFilter))
            ->paginate($this->perPage);

        return view('livewire.backend.dashboard.sub-category.index-component', [
            'subCategories' => $subCategories,
            'pageRange' => $this->getPageRange($subCategories),
        ])->layout('backend.app');
    }
}
