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
                <i class="fas fa-edit mr-2 text-indigo-500"></i>Edit Product
            </li>
        </ol>
    </nav>

    <!-- Session Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400 rounded-lg shadow-sm animate-fade-in"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-green-800 font-medium">{{ session('message') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button @click="show = false" class="text-green-600 hover:text-green-800 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-lg shadow-sm animate-fade-in"
            x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                </div>
                <div class="ml-3">
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button @click="show = false" class="text-red-600 hover:text-red-800 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side: Product Details -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Product Information -->
            <section
                class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center space-x-4 pb-4 border-b border-gray-200">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">1</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Product Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <x-form.input id="name" label="Product Name *" wireModel="name" :error="$errors->first('name')"
                        placeholder="Enter product name"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />

                    <x-form.input id="sku" label="SKU *" wireModel="sku" :error="$errors->first('sku')"
                        placeholder="Enter SKU code"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />

                    <x-form.input id="weight" type="number" step="0.01" label="Weight (Kg)" wireModel="weight"
                        :error="$errors->first('weight')" placeholder="Enter weight in Kg"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />

                    <x-form.input id="length" type="number" step="0.01" label="Length (cm)" wireModel="length"
                        :error="$errors->first('length')" placeholder="Enter length in cm"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />

                    <x-form.input id="width" type="number" step="0.01" label="Width (cm)" wireModel="width"
                        :error="$errors->first('width')" placeholder="Enter width in cm"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />

                    <x-form.input id="height" type="number" step="0.01" label="Height (cm)" wireModel="height"
                        :error="$errors->first('height')" placeholder="Enter height in cm"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />

                    <x-form.textarea id="short_description" label="Short Description" wireModel="short_description"
                        :error="$errors->first('short_description')" placeholder="Write a short description..."
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />

                    <x-form.textarea id="description" label="Description" wireModel="description" :error="$errors->first('description')"
                        placeholder="Write full product description..."
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />

                    <x-form.switch-toggle label="Featured Product" wireModel="is_featured" :error="$errors->first('is_featured')"
                        class="text-indigo-600" />
                </div>
            </section>

            <!-- Pricing & Stock -->
            <section
                class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center space-x-4 pb-4 border-b border-gray-200">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-green-600 to-emerald-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">2</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Pricing & Stock</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                    <x-form.input id="price" type="number" step="0.01" label="Regular Price"
                        wireModel="price" :error="$errors->first('price')" placeholder="Enter regular price"
                        class="border-gray-300 focus:ring-green-500 focus:border-green-500 rounded-lg" />

                    <x-form.input id="sale_price" type="number" step="0.01" label="Sale Price"
                        wireModel="sale_price" :error="$errors->first('sale_price')" placeholder="Enter sale price"
                        class="border-gray-300 focus:ring-green-500 focus:border-green-500 rounded-lg" />

                    <x-form.input id="cost_price" type="number" step="0.01" label="Cost Price"
                        wireModel="cost_price" :error="$errors->first('cost_price')" placeholder="Enter cost price"
                        class="border-gray-300 focus:ring-green-500 focus:border-green-500 rounded-lg" />

                    <x-form.input id="stock_quantity" type="number" label="Stock Quantity"
                        wireModel="stock_quantity" :error="$errors->first('stock_quantity')" placeholder="Enter stock quantity"
                        class="border-gray-300 focus:ring-green-500 focus:border-green-500 rounded-lg" />

                    <x-form.select id="stock_status" label="Stock Status" wireModel="stock_status" :error="$errors->first('stock_status')"
                        :options="[
                            'in_stock' => 'In Stock',
                            'out_of_stock' => 'Out of Stock',
                            'preorder' => 'Preorder',
                        ]"
                        class="border-gray-300 focus:ring-green-200 focus:border-green-200 rounded-lg" />

                    <x-form.input id="sort_order" type="number" label="Sort Order" wireModel="sort_order"
                        :error="$errors->first('sort_order')" placeholder="Enter sort order"
                        class="border-gray-300 focus:ring-green-500 focus:border-green-500 rounded-lg" />
                </div>
            </section>

            <!-- File Uploads -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <!-- Thumbnail -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Thumbnail Image <span
                            class="text-red-500">*</span></label>

                    <label
                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            @if ($thumbnailUploading)
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-2">
                                    </div>
                                    <p class="text-xs text-blue-600 font-medium">Uploading...</p>
                                </div>
                            @else
                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                        upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG or GIF (MAX. 100MB)</p>
                            @endif
                        </div>
                        <input type="file" wire:model.live="thumbnail" accept="image/*" class="hidden"
                            {{ $thumbnailUploading ? 'disabled' : '' }} />
                    </label>

                    <!-- Preview -->
                    <div class="mt-3">
                        @if ($thumbnail)
                            <img src="{{ $thumbnail->temporaryUrl() }}"
                                class="w-32 h-32 object-cover rounded-lg border border-gray-200"
                                alt="Thumbnail Preview">
                        @elseif($product && $product->productDetail?->thumbnail)
                            <img src="{{ asset($product->productDetail->thumbnail) }}"
                                class="w-32 h-32 object-cover rounded-lg border border-gray-200"
                                alt="Existing Thumbnail">
                        @else
                            <div
                                class="w-32 h-32 bg-gray-200 rounded-lg border border-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">No Image</span>
                            </div>
                        @endif
                    </div>

                    @error('thumbnail')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Gallery -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Image Gallery (Max 20)</label>

                    <label
                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            @if (isset($imagesUploading) && in_array(true, $imagesUploading))
                                <div class="flex flex-col items-center">
                                    <div
                                        class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-2">
                                    </div>
                                    <p class="text-xs text-blue-600 font-medium">Uploading images...</p>
                                </div>
                            @else
                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to
                                        upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG or GIF (Multiple files allowed)</p>
                            @endif
                        </div>
                        <input type="file" wire:model.live="files" multiple accept="image/*" class="hidden" />
                    </label>

                    <!-- Preview Gallery -->
                    <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        {{-- Existing Images --}}
                        @if ($product && $product->productFiles)
                            @foreach ($product->productFiles as $index => $file)
                                <div class="relative group">
                                    <img src="{{ asset($file->file_path) }}"
                                        class="w-full h-24 object-cover rounded-lg border border-gray-300"
                                        alt="Gallery Image {{ $index + 1 }}">
                                    <button type="button"
                                        wire:click.prevent="removeExistingImage({{ $index }})"
                                        wire:confirm="Are you sure you want to remove this image?"
                                        class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @endif

                        {{-- New Uploads --}}
                        @foreach ($filesUploadData as $index => $fileData)
                            <div class="relative group">
                                @if (method_exists($fileData['file'], 'temporaryUrl'))
                                    <img src="{{ $fileData['file']->temporaryUrl() }}"
                                        class="w-full h-24 object-cover rounded-lg border border-gray-300"
                                        alt="New Image {{ $index + 1 }}">
                                @endif

                                {{-- Spinner overlay for uploading --}}
                                @if (!$fileData['completed'])
                                    <div
                                        class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center rounded-lg">
                                        <div
                                            class="w-6 h-6 border-4 border-blue-500 border-t-transparent rounded-full animate-spin">
                                        </div>
                                    </div>
                                @endif

                                <button type="button" wire:click.prevent="removeImageFile({{ $index }})"
                                    class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    @error('files')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    @error('files.*')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Product Tags Section -->
            <section
                class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center space-x-4 pb-4 border-b border-gray-200">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Product Tags</h3>
                </div>

                <div class="mt-6 space-y-4">
                    @foreach ($tags as $index => $tag)
                        <div class="flex items-center space-x-3">
                            <input type="text" wire:model="tags.{{ $index }}" placeholder="Enter tag name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300 bg-white hover:border-gray-400 placeholder-gray-400" />
                            @if (count($tags) > 1)
                                <button type="button" wire:click="removeTagField({{ $index }})"
                                    class="text-red-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200 p-2 rounded-lg transform hover:scale-110">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            @endif
                        </div>
                        @error('tags.' . $index)
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    @endforeach

                    <button type="button" wire:click="addTagField"
                        class="px-4 py-2 mt-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition-colors duration-200 flex items-center space-x-2">
                        <i class="fas fa-plus text-xs"></i>
                        <span>Add More Tags</span>
                    </button>
                </div>
            </section>
        </div>

        <!-- Right Side: Category Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 flex flex-col max-h-[600px]"
            style="height: fit-content;">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-layer-group mr-2 text-indigo-600"></i>
                    Select Product Category
                </h3>
            </div>
            <!-- Show validation error -->
            @if ($errors->has('selectedSubCategoriesMultiple'))
                <p class="text-red-500 text-sm mb-2">
                    {{ $errors->first('selectedSubCategoriesMultiple') }}
                </p>
            @endif
            <!-- Category Tree (Scrollable) -->
            <div
                class="flex-1 overflow-y-auto space-y-3 max-h-[500px] pr-3 scrollbar-thin scrollbar-thumb-indigo-200 scrollbar-track-gray-50">
                @foreach ($categories as $category)
                    <div
                        class="border border-gray-200 rounded-md overflow-hidden transition-all duration-200 hover:shadow-md">
                        <!-- Category Header -->
                        <div class="flex items-center justify-between p-2 bg-gray-50 hover:bg-indigo-50 cursor-pointer transition-colors duration-200"
                            wire:click="toggleCategory({{ $category->id }})">
                            <div class="flex items-center space-x-4">
                                <div class="w-3 h-3 flex items-center justify-center">
                                    @if (in_array($category->id, $expandedCategories))
                                        <i class="fas fa-minus text-indigo-500 text-sm"></i>
                                    @else
                                        <i class="fas fa-plus text-indigo-500 text-sm"></i>
                                    @endif
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="category_{{ $category->id }}"
                                        class="w-3 h-3 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 focus:ring-1"
                                        {{ isset($selectedSubCategoriesMultiple[$category->id]) && !empty($selectedSubCategoriesMultiple[$category->id]) ? 'checked' : '' }}
                                        disabled>
                                    <label for="category_{{ $category->id }}"
                                        class="ml-3 text-sm font-semibold text-gray-800 cursor-pointer">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                            @if (isset($selectedSubCategoriesMultiple[$category->id]) && !empty($selectedSubCategoriesMultiple[$category->id]))
                                <span
                                    class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2 py-1 rounded-full">
                                    {{ count($selectedSubCategoriesMultiple[$category->id]) }} selected
                                </span>
                            @endif
                        </div>

                        <!-- Subcategories -->
                        @if (in_array($category->id, $expandedCategories))
                            <div class="p-0 bg-white border-t border-gray-100">
                                @if ($category->subCategories->count() > 0)
                                    <div class="max-h-48 overflow-y-auto">
                                        @foreach ($category->subCategories as $subCategory)
                                            <div
                                                class="flex items-center space-x-4 p-2 hover:bg-indigo-50 border-b border-gray-100 last:border-b-0 transition-colors duration-200">
                                                <div class="w-4 h-4 flex items-center justify-center">
                                                    <div class="w-4 h-4 border-2 border-indigo-300 rounded-full flex items-center justify-center cursor-pointer hover:border-indigo-500 transition-colors duration-200"
                                                        wire:click="toggleSubCategory({{ $category->id }}, {{ $subCategory->id }})">
                                                        @if (isset($selectedSubCategoriesMultiple[$category->id]) &&
                                                                in_array($subCategory->id, $selectedSubCategoriesMultiple[$category->id]))
                                                            <div class="w-2.5 h-2.5 bg-indigo-600 rounded-full"></div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <label
                                                    class="flex-1 text-sm font-medium text-gray-700 cursor-pointer pl-4 border-l-2 border-indigo-100"
                                                    wire:click="toggleSubCategory({{ $category->id }}, {{ $subCategory->id }})">
                                                    {{ $subCategory->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-4 text-center text-gray-500 text-sm">
                                        <i class="fas fa-info-circle mb-2 text-indigo-500"></i>
                                        <p>No subcategories available</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <!-- Selected Categories Summary -->
            @if (!empty($selectedSubCategoriesMultiple))
                <div class="mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-xl">
                    <h4 class="text-sm font-semibold text-indigo-900 mb-2 flex items-center">
                        <i class="fas fa-check-circle mr-2 text-indigo-600"></i>
                        Selected Categories ({{ array_sum(array_map('count', $selectedSubCategoriesMultiple)) }})
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($selectedSubCategoriesMultiple as $categoryId => $subCategoryIds)
                            @php $category = $categories->find($categoryId); @endphp
                            @foreach ($subCategoryIds as $subCategoryId)
                                @php $subCategory = $category->subCategories->find($subCategoryId); @endphp
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                    {{ $category->name }} → {{ $subCategory->name }}
                                    <button type="button"
                                        class="ml-2 text-indigo-600 hover:text-indigo-800 focus:outline-none"
                                        wire:click="toggleSubCategory({{ $categoryId }}, {{ $subCategoryId }})">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="col-span-1 lg:col-span-3 flex justify-between items-center pt-6 border-t border-gray-200">
            <div class="flex items-center space-x-4">
                <button type="button"
                    class="px-6 py-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 transition-all duration-200 flex items-center text-gray-700 font-medium shadow-sm"
                    wire:click="resetForm">
                    <i class="fas fa-undo mr-2 text-gray-600"></i>
                    Reset Form
                </button>

                <button type="submit"
                    class="px-8 py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white transition-all duration-200 transform hover:scale-105 shadow-lg flex items-center font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire:target="save">
                        <i class="fas fa-save mr-2"></i>
                        Update Product
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center">
                        <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin mr-2">
                        </div>
                        Updating...
                    </span>
                </button>
            </div>

            @if (!empty($selectedSubCategoriesMultiple))
                <div class="flex items-center space-x-2 text-sm text-indigo-600 font-medium">
                    <i class="fas fa-check-circle text-indigo-500"></i>
                    <span>{{ array_sum(array_map('count', $selectedSubCategoriesMultiple)) }} categories
                        selected</span>
                </div>
            @endif
        </div>
    </form>
</main>
