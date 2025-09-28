<main class="flex-1 overflow-auto p-6 lg:p-8 bg-gradient-to-br from-gray-50 to-gray-100" role="main">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-3 text-sm text-gray-600 font-medium">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="hover:text-indigo-600 flex items-center transition-colors duration-200">
                    <i class="fas fa-home mr-2 text-indigo-500"></i>Home
                </a>
            </li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li>
                <a href="{{ route('product.index') }}"
                    class="hover:text-indigo-600 flex items-center transition-colors duration-200">
                    <i class="fas fa-boxes mr-2 text-indigo-500"></i>Products
                </a>
            </li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li class="text-gray-900 font-semibold flex items-center">
                <i class="fas fa-box mr-2 text-indigo-500"></i>{{ $product->name }}
            </li>
        </ol>
    </nav>

    <!-- Session Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-100 border border-green-300 rounded-xl animate-pulse">
            <p class="text-green-700 text-sm flex items-center font-medium">
                <i class="fas fa-check-circle mr-2 text-green-600"></i>{{ session('message') }}
            </p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-xl animate-pulse">
            <p class="text-red-700 text-sm flex items-center font-medium">
                <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>{{ session('error') }}
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: Product Details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Product Information -->
            <section x-data="{ open: true }"
                class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300 fade-in">
                <div class="flex items-center space-x-4 pb-4 border-b border-gray-200 cursor-pointer"
                    @click="open = !open">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Product Information</h3>
                    <i class="fas fa-chevron-down ml-auto text-gray-500" x-show="!open"></i>
                    <i class="fas fa-chevron-up ml-auto text-gray-500" x-show="open"></i>
                </div>
                <div x-show="open" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Product Name</p>
                        <p class="text-base text-gray-900">{{ $product->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">SKU</p>
                        <p class="text-base text-gray-900">{{ $product->sku }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Weight (Kg)</p>
                        <p class="text-base text-gray-900">{{ $product->productDetails->weight ?? 'N/A' }} kg</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Dimensions (cm)</p>
                        <p class="text-base text-gray-900">
                            {{ $product->productDetails->length ?? 'N/A' }} x
                            {{ $product->productDetails->width ?? 'N/A' }} x
                            {{ $product->productDetails->height ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600 font-medium">Short Description</p>
                        <p class="text-base text-gray-900">{{ $product->short_description ?? 'N/A' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-600 font-medium">Description</p>
                        <div class="text-base text-gray-900 prose">{!! $product->description ?? 'N/A' !!}</div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Status</p>
                        <span
                            class="inline-block px-3 py-1 text-xs font-semibold {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-full">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Sort Order</p>
                        <p class="text-base text-gray-900">{{ $product->sort_order }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Created At</p>
                        <p class="text-base text-gray-900">{{ $product->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 font-medium">Updated At</p>
                        <p class="text-base text-gray-900">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </section>

            <!-- Pricing & Stock -->
            <section x-data="{ open: true }"
                class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300 fade-in">
                <div class="flex items-center space-x-4 pb-4 border-b border-gray-200 cursor-pointer"
                    @click="open = !open">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-green-600 to-emerald-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Pricing & Stock</h3>
                    <i class="fas fa-chevron-down ml-auto text-gray-500" x-show="!open"></i>
                    <i class="fas fa-chevron-up ml-auto text-gray-500" x-show="open"></i>
                </div>
                <div x-show="open" x-transition class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    @if ($product->productPricing)
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Regular Price</p>
                            <p class="text-base text-gray-900">
                                ${{ number_format($product->productPricing->price, 2) }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 font-medium">Sale Price</p>
                            <p class="text-base text-gray-900">
                                {{ $product->productPricing->sale_price !== null
                                    ? '$' . number_format($product->productPricing->sale_price, 2)
                                    : 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 font-medium">Cost Price</p>
                            <p class="text-base text-gray-900">
                                {{ $product->productPricing->cost_price !== null
                                    ? '$' . number_format($product->productPricing->cost_price, 2)
                                    : 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 font-medium">Stock Quantity</p>
                            <p class="text-base text-gray-900">
                                {{ $product->productPricing->stock_quantity }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-600 font-medium">Stock Status</p>
                            <p class="text-base text-gray-900">
                                {{ ucfirst(str_replace('_', ' ', $product->productPricing->stock_status)) }}
                            </p>
                        </div>
                    @else
                        <div class="md:col-span-3">
                            <p class="text-gray-500 text-sm">No pricing information available.</p>
                        </div>
                    @endif
                </div>

            </section>

            <!-- File Uploads -->
            <section x-data="{ open: true }"
                class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300 fade-in">
                <div class="flex items-center space-x-4 pb-4 border-b border-gray-200 cursor-pointer"
                    @click="open = !open">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Product Files</h3>
                    <i class="fas fa-chevron-down ml-auto text-gray-500" x-show="!open"></i>
                    <i class="fas fa-chevron-up ml-auto text-gray-500" x-show="open"></i>
                </div>
                <div x-show="open" x-transition class="mt-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Thumbnail -->
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-2">Thumbnail Image</p>
                            <img src="{{ asset($product->productDetail?->thumbnail ?? 'placeholder.png') }}"
                                alt="{{ $product->name }}"
                                class="w-32 h-32 object-cover rounded-lg border border-gray-200 shadow-md hover:scale-105 transition-transform"
                                onerror="this.src='https://via.placeholder.com/144'">
                        </div>

                        <!-- Image Gallery -->
                        <div>
                            <p class="text-sm text-gray-600 font-medium mb-2">Image Gallery</p>
                            @if ($product->productFiles->isNotEmpty())
                                <div x-data="{ openLightbox: false, currentImage: '' }"
                                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                    @foreach ($product->productFiles as $file)
                                        <div class="relative group">
                                            <img src="{{ asset($file->file_path) }}" alt="Product File"
                                                class="w-full h-32 object-cover rounded-lg border border-gray-300 shadow-sm cursor-pointer hover:scale-105 transition-transform"
                                                @click="openLightbox = true; currentImage = '{{ asset($file->file_path) }}'"
                                                onerror="this.src='https://via.placeholder.com/144'">
                                        </div>
                                    @endforeach

                                    <!-- Lightbox -->
                                    <div x-show="openLightbox"
                                        class="lightbox fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
                                        @click="openLightbox = false">
                                        <img :src="currentImage" alt="Product Image"
                                            class="max-w-full max-h-[80vh] rounded-lg">
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">No images available.</p>
                            @endif
                        </div>
                    </div>
                </div>

            </section>

            <!-- Product Tags -->
            <section x-data="{ open: true }"
                class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300 fade-in">
                <div class="flex items-center space-x-4 pb-4 border-b border-gray-200 cursor-pointer"
                    @click="open = !open">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">4</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Product Tags</h3>
                    <i class="fas fa-chevron-down ml-auto text-gray-500" x-show="!open"></i>
                    <i class="fas fa-chevron-up ml-auto text-gray-500" x-show="open"></i>
                </div>
                <div x-show="open" x-transition class="mt-6">
                    @if ($product->productTags->isNotEmpty())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product->productTags as $tag)
                                <span
                                    class="inline-block px-3 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 rounded-full">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">No tags assigned.</p>
                    @endif
                </div>
            </section>
        </div>

        <!-- Right Side: Category Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 flex flex-col max-h-[600px]"
            style="height: fit-content;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-layer-group mr-2 text-indigo-600"></i>
                    Product Categories
                </h3>
            </div>
            <!-- Category Tree (Scrollable) -->
            <div
                class="flex-1 overflow-y-auto space-y-3 max-h-[500px] pr-3 scrollbar-thin scrollbar-thumb-indigo-200 scrollbar-track-gray-50">
                @foreach ($product->subCategories->groupBy('category_id') as $categoryId => $subCategories)
                    @php $category = $subCategories->first()->category; @endphp
                    <div x-data="{ open: true }"
                        class="border border-gray-200 rounded-md overflow-hidden transition-all duration-200 hover:shadow-md">
                        <!-- Category Header -->
                        <div class="flex items-center justify-between p-2 bg-gray-50 hover:bg-indigo-50 cursor-pointer transition-colors duration-200"
                            @click="open = !open">
                            <div class="flex items-center space-x-4">
                                <div class="w-3 h-3 flex items-center justify-center">
                                    <i class="fas" :class="open ? 'fa-minus' : 'fa-plus'"
                                        class="text-indigo-500 text-sm"></i>
                                </div>
                                <div class="flex items-center">
                                    <label class="text-sm font-semibold text-gray-800">{{ $category->name }}</label>
                                </div>
                            </div>
                            <span class="bg-indigo-200 text-indigo-900 text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $subCategories->count() }} selected
                            </span>
                        </div>
                        <!-- Subcategories -->
                        <div x-show="open" x-transition class="p-0 bg-white border-t border-gray-100">
                            <div class="max-h-48 overflow-y-auto">
                                @foreach ($subCategories as $subCategory)
                                    <div
                                        class="flex items-center space-x-4 p-2 hover:bg-indigo-50 border-b border-gray-100 last:border-b-0 transition-colors duration-200">
                                        <div class="w-4 h-4 flex items-center justify-center">
                                            <div class="w-4 h-4 bg-indigo-600 rounded-full"></div>
                                        </div>
                                        <label
                                            class="flex-1 text-sm font-medium text-gray-700 pl-4 border-l-2 border-indigo-100">
                                            {{ $subCategory->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($product->subCategories->isEmpty())
                    <div class="p-4 text-center text-gray-500 text-sm">
                        <i class="fas fa-info-circle mb-2 text-indigo-500"></i>
                        <p>No categories assigned</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="col-span-1 lg:col-span-3 flex justify-between items-center pt-6">
            <div class="flex items-center space-x-4">
                <a href="{{ route('product.index') }}"
                    class="px-6 py-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 transition-all duration-200 flex items-center text-gray-700 font-medium">
                    <i class="fas fa-arrow-left mr-2 text-gray-600"></i>
                    Back
                </a>
                <a href=""
                    class="px-6 py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white transition-all duration-200 transform hover:scale-105 shadow-xl flex items-center font-semibold">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Product
                </a>
                <button wire:click="delete({{ $product->id }})"
                    wire:confirm="Are you sure you want to delete this product?"
                    class="px-6 py-3 rounded-lg bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white transition-all duration-200 transform hover:scale-105 shadow-xl flex items-center font-semibold">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Product
                </button>
            </div>
            @if ($product->subCategories->isNotEmpty())
                <div class="flex items-center space-x-2 text-sm text-indigo-600 font-medium">
                    <i class="fas fa-check-circle text-indigo-500"></i>
                    <span>{{ $product->subCategories->count() }} categories selected</span>
                </div>
            @endif
        </div>
    </div>
</main>
