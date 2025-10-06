<?php

use App\Livewire\Backend\Dashboard\Category\CreateComponent as CategoryCreateComponent;
use App\Livewire\Backend\Dashboard\Category\EditComponent as CategoryEditComponent;
use App\Livewire\Backend\Dashboard\Category\IndexComponent as CategoryIndexComponent;
use App\Livewire\Backend\Dashboard\Category\ViewComponent as CategoryViewComponent;
use App\Livewire\Backend\Dashboard\Overview\IndexComponent as OverviewIndexComponent;
use App\Livewire\Backend\Dashboard\Product\CreateComponent as ProductCreateComponent;
use App\Livewire\Backend\Dashboard\Product\EditComponent as ProductEditComponent;
use App\Livewire\Backend\Dashboard\Product\IndexComponent as ProjectIndexComponent;
use App\Livewire\Backend\Dashboard\Product\ViewComponent as ProductViewComponent;
use App\Livewire\Backend\Dashboard\SubCategory\CreateComponent as SubCategoryCreateComponent;
use App\Livewire\Backend\Dashboard\SubCategory\EditComponent as SubCategoryEditComponent;
use App\Livewire\Backend\Dashboard\SubCategory\IndexComponent as SubCategoryIndexComponent;
use App\Livewire\Backend\Dashboard\SubCategory\ViewComponent as SubCategoryViewComponent;
use App\Livewire\Frontend\ProductComponent;
use Illuminate\Support\Facades\Route;

// Frontend Home Page
Route::get('', ProductComponent::class)->name('home'); // Home page showing products

// Backend Dashboard Overview
Route::get('dashboard', OverviewIndexComponent::class)->name('dashboard'); // Admin dashboard main page

// Categories Routes
Route::get('categories/create', CategoryCreateComponent::class)->name('categories.create'); // Create a new category
Route::get('categories/{slug}/edit', CategoryEditComponent::class)->name('categories.edit'); // Edit a category by slug
Route::get('categories/{slug}', CategoryViewComponent::class)->name('categories.view'); // View category details
Route::get('categories', CategoryIndexComponent::class)->name('categories.index'); // List all categories

// Sub-Categories Routes
Route::get('sub-categories/create', SubCategoryCreateComponent::class)->name('sub.categories.create'); // Create a new sub-category
Route::get('sub-categories', SubCategoryIndexComponent::class)->name('sub.categories.index'); // List all sub-categories
Route::get('sub-categories/{slug}/edit', SubCategoryEditComponent::class)->name('sub.categories.edit'); // Edit a sub-category
Route::get('sub-categories/{slug}', SubCategoryViewComponent::class)->name('sub.categories.view'); // View sub-category details

// Products Routes
Route::get('product/create', ProductCreateComponent::class)->name('product.create'); // Create a new product
Route::get('products', ProjectIndexComponent::class)->name('product.index'); // List all products (note: variable name is ProjectIndexComponent, could rename to ProductIndexComponent for clarity)
Route::get('product/{slug}', ProductViewComponent::class)->name('view.product'); // View product details
Route::get('product/{slug}/edit', ProductEditComponent::class)->name('product.edit'); // Edit a product
