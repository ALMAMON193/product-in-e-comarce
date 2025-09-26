<?php

use App\Livewire\Backend\Dashboard\Category\CreateComponent as CategoryCreateComponent;
use App\Livewire\Backend\Dashboard\Overview\IndexComponent as OverviewIndexComponent;
use App\Livewire\Backend\Dashboard\SubCategory\CreateComponent as SubCategoryCreateComponent;
use App\Livewire\Backend\Dashboard\Product\CreateComponent as ProductCreateComponent;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', OverviewIndexComponent::class)->name('dashboard');
Route::get('categories/create', CategoryCreateComponent::class)->name('categories.create');
Route::get('sub-categories/create', SubCategoryCreateComponent::class)->name('sub.categories.create');
Route::get('product/create', ProductCreateComponent::class)->name('product.create');
