<?php

namespace App\Livewire\Backend\Dashboard\Category;

use App\Models\Category;
use Livewire\Component;

class ViewComponent extends Component
{
    public $category;

    public function mount($slug)
    {
        $this->category = Category::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.backend.dashboard.category.view-component')->layout('backend.app');
    }
}
