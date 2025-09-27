<div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-6">
            <button id="toggleFilters"
                class="w-full bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium flex items-center justify-between shadow-md hover:bg-indigo-700 transition duration-300">
                <span>Filters</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        <!-- Filters Sidebar -->
        <aside
            class="w-full lg:w-80 rounded-2xl bg-white shadow-lg p-6 lg:sticky lg:top-20 overflow-hidden transition-all duration-300">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-4">Refine Your Selection</h3>

            <!-- Subcategories -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Subcategories</h4>
                <div class="space-y-4 max-h-60 overflow-y-auto">
                    <label class="flex items-center cursor-pointer group">
                        <input type="radio" name="subCategory" value="all" wire:model.live="subCategory"
                            class="w-5 h-5 text-amber-500 focus:ring-amber-500 border-gray-300 transition duration-200">
                        <span class="ml-3 text-base text-gray-700 group-hover:text-amber-600 transition duration-200">
                            All Products
                        </span>
                    </label>
                    @forelse ($subCategories as $subCat)
                        <label class="flex items-center cursor-pointer group">
                            <input type="radio" name="subCategory" value="{{ $subCat->id }}"
                                wire:model.live="subCategory"
                                class="w-5 h-5 text-amber-500 focus:ring-amber-500 border-gray-300 transition duration-200">
                            <span
                                class="ml-3 text-base text-gray-700 group-hover:text-amber-600 transition duration-200">
                                {{ $subCat->name }}
                            </span>
                        </label>
                    @empty
                        <p class="text-sm text-gray-500 italic">No subcategories available at the moment.</p>
                    @endforelse
                </div>
            </div>

            <!-- Price Ranges -->
            <div>
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Price Range</h4>
                <div class="space-y-4">
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" value="under_25" wire:model.live="priceRanges"
                            class="w-5 h-5 text-amber-500 focus:ring-amber-500 border-gray-300 transition duration-200">
                        <span
                            class="ml-3 text-base text-gray-700 group-hover:text-amber-600 transition duration-200">Under
                            $25</span>
                    </label>
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" value="25_50" wire:model.live="priceRanges"
                            class="w-5 h-5 text-amber-500 focus:ring-amber-500 border-gray-300 transition duration-200">
                        <span
                            class="ml-3 text-base text-gray-700 group-hover:text-amber-600 transition duration-200">$25
                            - $50</span>
                    </label>
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" value="50_100" wire:model.live="priceRanges"
                            class="w-5 h-5 text-amber-500 focus:ring-amber-500 border-gray-300 transition duration-200">
                        <span
                            class="ml-3 text-base text-gray-700 group-hover:text-amber-600 transition duration-200">$50
                            - $100</span>
                    </label>
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" value="100_200" wire:model.live="priceRanges"
                            class="w-5 h-5 text-amber-500 focus:ring-amber-500 border-gray-300 transition duration-200">
                        <span
                            class="ml-3 text-base text-gray-700 group-hover:text-amber-600 transition duration-200">$100
                            - $200</span>
                    </label>
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" value="over_200" wire:model.live="priceRanges"
                            class="w-5 h-5 text-amber-500 focus:ring-amber-500 border-gray-300 transition duration-200">
                        <span
                            class="ml-3 text-base text-gray-700 group-hover:text-amber-600 transition duration-200">Over
                            $200</span>
                    </label>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1">
            <div
                class="bg-white rounded-2xl shadow-md p-6 mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <span class="text-lg font-medium text-gray-600">
                    {{ $products->total() }} Products Found
                </span>
                <div class="flex items-center gap-4">
                    <select wire:model.live="sortBy"
                        class="px-5 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200">
                        <option value="popular">Sort by: Popular</option>
                        <option value="price_low_to_high">Price: Low to High</option>
                        <option value="price_high_to_low">Price: High to Low</option>
                        <option value="newest">Newest First</option>
                    </select>
                    <div class="flex border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <button wire:click="setViewMode('grid')"
                            class="px-4 py-3 {{ $viewMode === 'grid' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600' }} hover:bg-indigo-700 hover:text-white transition duration-200">
                            <i class="fas fa-th"></i>
                        </button>
                        <button wire:click="setViewMode('list')"
                            class="px-4 py-3 {{ $viewMode === 'list' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600' }} hover:bg-indigo-700 hover:text-white transition duration-200">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div
                class="{{ $viewMode === 'grid' ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6' : 'space-y-6' }}">
                @if ($products->isEmpty())
                    <div class="text-center py-16 bg-gray-50 rounded-xl shadow-inner">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-xl font-semibold text-gray-700">Oops! No Products Found</h3>
                        <p class="mt-2 text-gray-500">It seems there are no products matching your filters. Try
                            adjusting your selection!</p>
                    </div>
                @else
                    @foreach ($products as $product)
                        <div
                            class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden rounded-t-2xl">
                                <img src="{{ $product->productDetail?->thumbnail ?? '/placeholder.png' }}"
                                    class="w-full h-56 object-cover transition-transform duration-300 group-hover:scale-105"
                                    alt="{{ $product->name }}">
                                <div
                                    class="absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-all duration-300">
                                </div>
                                @if ($product->productPricing?->sale_price)
                                    <span
                                        class="absolute top-4 left-4 bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded-full shadow-md">
                                        Sale
                                    </span>
                                @elseif($product->created_at->gt(now()->subDays(7)))
                                    <span
                                        class="absolute top-4 left-4 bg-green-500 text-white text-sm font-semibold px-3 py-1 rounded-full shadow-md">
                                        New
                                    </span>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-5">
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                    {{ $product->short_description ?? Str::limit($product->description, 100) }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-baseline space-x-2">
                                        <span class="text-xl font-bold text-indigo-600">
                                            ${{ number_format($product->productPricing?->sale_price ?? ($product->productPricing?->price ?? 0), 2) }}
                                        </span>
                                        @if ($product->productPricing?->sale_price)
                                            <span class="text-sm text-gray-500 line-through">
                                                ${{ number_format($product->productPricing?->price ?? 0, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                    <button class="text-indigo-600 hover:text-indigo-800 transition duration-200">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Pagination -->
            @if (!$products->isEmpty())
                <div class="mt-10 flex justify-center">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
