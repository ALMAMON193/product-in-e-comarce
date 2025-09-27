<?php

use App\Livewire\Backend\Dashboard\Category\CreateComponent as CategoryCreateComponent;
use App\Livewire\Backend\Dashboard\Category\IndexComponent as CategoryIndexComponent;
use App\Livewire\Backend\Dashboard\Overview\IndexComponent as OverviewIndexComponent;
use App\Livewire\Backend\Dashboard\Product\CreateComponent as ProductCreateComponent;
use App\Livewire\Backend\Dashboard\Product\EditComponent as ProductEditComponent;
use App\Livewire\Backend\Dashboard\Product\IndexComponent as ProjectIndexComponent;
use App\Livewire\Backend\Dashboard\Product\ViewComponent as ProductViewComponent;
use App\Livewire\Backend\Dashboard\SubCategory\CreateComponent as SubCategoryCreateComponent;
use App\Livewire\Backend\Dashboard\SubCategory\IndexComponent as SubCategoryIndexComponent;
use App\Livewire\Frontend\ProductComponent;
use Illuminate\Support\Facades\Route;

Route::get('', ProductComponent::class)->name('home');
Route::get('dashboard', OverviewIndexComponent::class)->name('dashboard');
Route::get('categories/create', CategoryCreateComponent::class)->name('categories.create');
Route::get('categories', CategoryIndexComponent::class)->name('categories.index');
Route::get('sub-categories/create', SubCategoryCreateComponent::class)->name('sub.categories.create');
Route::get('sub-categories', SubCategoryIndexComponent::class)->name('sub.categories.index');
Route::get('product/create', ProductCreateComponent::class)->name('product.create');
Route::get('products', ProjectIndexComponent::class)->name('product.index');
Route::get('product/{slug}', ProductViewComponent::class)->name('view.product');
Route::get('product/{slug}/edit', ProductEditComponent::class)->name('product.edit');
