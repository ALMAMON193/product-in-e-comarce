<?php

namespace App\Livewire\Backend\Dashboard\SubCategory;

use App\Models\SubCategory;
use Livewire\Component;

class ViewComponent extends Component
{
    public $subCategory;

    public function mount($slug)
    {
        $this->subCategory = SubCategory::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.backend.dashboard.sub-category.view-component')->layout('backend.app');
    }
}
