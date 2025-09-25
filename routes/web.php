<?php

use App\Livewire\Backend\Dashboard\Category\CreateComponent as CategoryCreateComponent;
use App\Livewire\Backend\Dashboard\Overview\IndexComponent as OverviewIndexComponent;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', OverviewIndexComponent::class)->name('dashboard');
Route::get('categories/create', CategoryCreateComponent::class)->name('categories.create');
