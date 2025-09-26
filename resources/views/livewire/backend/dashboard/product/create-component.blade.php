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
            <li class="text-gray-900 font-semibold flex items-center">
                <i class="fas fa-boxes mr-2 text-indigo-500"></i>Create Product
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
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="sku" label="SKU *" wireModel="sku" :error="$errors->first('sku')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="short_description" label="Short Description" wireModel="short_description"
                        :error="$errors->first('short_description')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.textarea id="description" label="Description" wireModel="description" :error="$errors->first('description')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="weight" type="number" step="0.01" label="Weight (Kg)" wireModel="weight"
                        :error="$errors->first('weight')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="length" type="number" step="0.01" label="Length (cm)" wireModel="length"
                        :error="$errors->first('length')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="width" type="number" step="0.01" label="Width (cm)" wireModel="width"
                        :error="$errors->first('width')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="height" type="number" step="0.01" label="Height (cm)" wireModel="height"
                        :error="$errors->first('height')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="tags" label="Tags Product" wireModel="tags" :error="$errors->first('tags')"
                        placeholder="tag1, tag2, tag3"
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
                    <x-form.input id="price" type="number" step="0.01" label="Regular Price" wireModel="price"
                        :error="$errors->first('price')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="sale_price" type="number" step="0.01" label="Sale Price"
                        wireModel="sale_price" :error="$errors->first('sale_price')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="cost_price" type="number" step="0.01" label="Cost Price"
                        wireModel="cost_price" :error="$errors->first('cost_price')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.input id="stock_quantity" type="number" label="Stock Quantity" wireModel="stock_quantity"
                        :error="$errors->first('stock_quantity')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                    <x-form.select id="stock_status" label="Stock Status" wireModel="stock_status" :error="$errors->first('stock_status')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                        <option value="in_stock">In Stock</option>
                        <option value="out_of_stock">Out of Stock</option>
                        <option value="preorder">Preorder</option>
                    </x-form.select>
                    <x-form.input id="sort_order" type="number" label="Sort Order" wireModel="sort_order"
                        :error="$errors->first('sort_order')"
                        class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg" />
                </div>
            </section>

            <!-- Additional Settings -->
            <section
                class="bg-white rounded-2xl p-6 border border-gray-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="flex items-center space-x-4 pb-4 border-b border-gray-200">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">3</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">File Uploads</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                    {{-- Thumbnail --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2 flex items-center">
                            Thumbnail Image <span class="text-red-500 ml-1">*</span>
                            <i class="fas fa-info-circle ml-2 text-gray-400 hover:text-gray-600 cursor-help"
                                title="Upload a thumbnail image for the project"></i>
                        </label>

                        <label
                            class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors @error('thumbnail') border-red-500 @enderror">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                @if ($thumbnailUploading ?? false)
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-2">
                                        </div>
                                        <p class="text-xs text-blue-600 font-medium">Uploading...</p>
                                    </div>
                                @else
                                    <svg class="w-6 h-6 mb-2 text-gray-500" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-1 text-xs text-gray-500"><span class="font-semibold">Click to
                                            upload</span> or drag and drop</p>
                                    <p class="text-[10px] text-gray-400">Any image format (max 100 MB)</p>
                                @endif
                            </div>
                            <input type="file" wire:model="thumbnail" accept="image/*" class="hidden"
                                {{ $thumbnailUploading ?? false ? 'disabled' : '' }} />
                        </label>

                        @error('thumbnail')
                            <p class="mt-1 text-sm text-red-500 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror

                        @if ($thumbnail)
                            <div class="mt-3 relative group">
                                <img src="{{ $thumbnail->temporaryUrl() }}"
                                    class="w-32 h-32 object-cover rounded-lg border border-gray-200"
                                    alt="Thumbnail Preview">
                                @if ($thumbnailCompleted ?? false)
                                    <div
                                        class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1.5 border-2 border-white shadow-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Image Gallery --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-2 flex items-center">
                            Image Gallery (Max 20)
                            <i class="fas fa-info-circle ml-2 text-gray-400 hover:text-gray-600 cursor-help"
                                title="Upload up to 20 images for the project gallery"></i>
                        </label>

                        <label
                            class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors @error('images.*') border-red-500 @enderror">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                @if (isset($imagesUploading) && in_array(true, $imagesUploading))
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-2">
                                        </div>
                                        <p class="text-xs text-blue-600 font-medium">Uploading images...</p>
                                    </div>
                                @else
                                    <svg class="w-6 h-6 mb-2 text-gray-500" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-1 text-xs text-gray-500"><span class="font-semibold">Click to
                                            upload</span> or drag and drop</p>
                                    <p class="text-[10px] text-gray-400">Any image format (max 5 GB each)</p>
                                @endif
                            </div>
                            <input type="file" wire:model="images" multiple accept="image/*" class="hidden"
                                {{ isset($imagesUploading) && in_array(true, $imagesUploading) ? 'disabled' : '' }} />
                        </label>

                        @error('images')
                            <p class="mt-1 text-sm text-red-500 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1 text-sm text-red-500 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror

                        {{-- Preview gallery --}}
                        <div class="mt-3 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-10 gap-4">
                            @foreach ($files as $index => $img)
                                <div class="relative group w-24 h-24">
                                    <img src="{{ $img->temporaryUrl() }}"
                                        class="w-full h-full object-cover rounded-lg border border-gray-200"
                                        alt="Gallery Image {{ $index + 1 }}" />

                                    {{-- Uploading overlay --}}
                                    @if (isset($imagesUploading[$index]) && $imagesUploading[$index])
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-50 rounded-lg flex items-center justify-center">
                                            <div
                                                class="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin">
                                            </div>
                                        </div>
                                        {{-- Completed check --}}
                                    @elseif(isset($imagesCompleted[$index]) && $imagesCompleted[$index])
                                        <div
                                            class="absolute -top-1 -right-1 bg-green-500 text-white rounded-full p-1 border-2 border-white shadow-sm">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Remove button --}}
                                    <button type="button" wire:click.prevent="removeImage({{ $index }})"
                                        class="absolute -top-2 -left-2 opacity-0 group-hover:opacity-100 transition-opacity bg-white hover:bg-gray-100 text-gray-700 rounded-full p-1.5 border border-gray-300 shadow-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <span
                                            class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                            Remove
                                        </span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </section>

        </div>

        <!-- Right Side: Category Section -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 flex flex-col max-h-[600px]">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900 flex items-center">
                    <i class="fas fa-layer-group mr-2 text-indigo-600"></i>
                    Product Category
                </h3>
            </div>

            <!-- Category Tree (Scrollable) -->
            <div
                class="flex-1 overflow-y-auto space-y-3 max-h-[500px] pr-3 scrollbar-thin scrollbar-thumb-indigo-200 scrollbar-track-gray-50">
                @foreach ($categories as $category)
                    <div
                        class="border border-gray-200 rounded-xl overflow-hidden transition-all duration-200 hover:shadow-md">
                        <!-- Category Header -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 hover:bg-indigo-50 cursor-pointer transition-colors duration-200"
                            wire:click="toggleCategory({{ $category->id }})">
                            <div class="flex items-center space-x-4">
                                <div class="w-6 h-6 flex items-center justify-center">
                                    @if (in_array($category->id, $expandedCategories))
                                        <i class="fas fa-minus text-indigo-500 text-sm"></i>
                                    @else
                                        <i class="fas fa-plus text-indigo-500 text-sm"></i>
                                    @endif
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="category_{{ $category->id }}"
                                        class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2"
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
                                    class="bg-indigo-200 text-indigo-900 text-xs font-semibold px-3 py-1 rounded-full">
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
                                                class="flex items-center space-x-4 p-4 hover:bg-indigo-50 border-b border-gray-100 last:border-b-0 transition-colors duration-200">
                                                <div class="w-6 h-6 flex items-center justify-center">
                                                    <div class="w-5 h-5 border-2 border-indigo-300 rounded-full flex items-center justify-center cursor-pointer hover:border-indigo-500 transition-colors duration-200"
                                                        wire:click="toggleSubCategory({{ $category->id }}, {{ $subCategory->id }})">
                                                        @if (isset($selectedSubCategoriesMultiple[$category->id]) &&
                                                                in_array($subCategory->id, $selectedSubCategoriesMultiple[$category->id]))
                                                            <div class="w-3 h-3 bg-indigo-600 rounded-full"></div>
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
                <div class="mt-4 p-4 bg-indigo-100 border border-indigo-200 rounded-xl">
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
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-200 text-indigo-900">
                                    {{ $category->name }} → {{ $subCategory->name }}
                                    <button type="button"
                                        class="ml-2 text-indigo-700 hover:text-indigo-900 focus:outline-none"
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
        <div class="col-span-1 lg:col-span-3 flex justify-between items-center pt-6">
            <div class="flex items-center space-x-4">
                <button type="button"
                    class="px-6 py-3 rounded-lg border border-gray-300 bg-white hover:bg-gray-100 transition-all duration-200 flex items-center text-gray-700 font-medium"
                    wire:click="resetForm">
                    <i class="fas fa-undo mr-2 text-gray-600"></i>
                    Reset
                </button>
                @if (!empty($selectedSubCategoriesMultiple))
                    <div class="flex items-center space-x-2 text-sm text-indigo-600 font-medium">
                        <i class="fas fa-check-circle text-indigo-500"></i>
                        <span>{{ array_sum(array_map('count', $selectedSubCategoriesMultiple)) }} categories
                            selected</span>
                    </div>
                @endif
            </div>
            <button type="submit"
                class="px-8 py-3 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white transition-all duration-200 transform hover:scale-105 shadow-xl flex items-center font-semibold">
                <span wire:loading.remove wire:target="save">
                    <i class="fas fa-save mr-2"></i>
                    Save Product
                </span>
                <span wire:loading wire:target="save" class="flex items-center">
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                    Saving...
                </span>
            </button>
        </div>
    </form>
</main>
