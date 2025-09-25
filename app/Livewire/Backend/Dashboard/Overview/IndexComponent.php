<?php

namespace App\Livewire\Backend\Dashboard\Overview;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.backend.dashboard.overview.index-component')->layout('backend.app', ['title' => 'Dashboard']);
    }
}
