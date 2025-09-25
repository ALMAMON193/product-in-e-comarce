<main class="flex-1 overflow-auto p-4 lg:p-6 bg-gradient-to-br from-gray-100 to-gray-200" role="main">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4 lg:mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('dashboard') }}" class="hover:text-indigo-500 transition-colors duration-200">Home</a>
            </li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li class="text-gray-800 font-semibold">Create Project Category</li>
        </ol>
    </nav>

    <!-- Form -->
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
            <section
                class="lg:col-span-4 bg-white/95 rounded-xl shadow-2xl p-6 border border-gray-100/50 backdrop-blur-sm">
                <h2 class="text-2xl font-bold mb-6 text-gray-900 tracking-tight">Project Category</h2>

                @foreach ($categories as $index => $category)
                    <div class="mb-6 space-y-4 border-b border-gray-200 pb-4 last:border-b-0">
                        <!-- Name Field -->
                        <div class="flex items-center">
                            <div class="flex-1">
                                <label for="name-{{ $index }}" class="block font-medium mb-2 text-gray-800">
                                    Title <span class="text-red-400 ml-1">*</span>
                                </label>
                                <input type="text" id="name-{{ $index }}"
                                    wire:model.defer="categories.{{ $index }}.name"
                                    placeholder="Enter category name"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white @error('categories.' . $index . '.name') border-red-400 @enderror">
                                @error('categories.' . $index . '.name')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            @if (count($categories) > 1)
                                <button type="button" wire:click="removeCategory({{ $index }})"
                                    class="ml-3 text-red-400 hover:text-red-500 transition-colors duration-200 p-2 rounded-full">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endif
                        </div>

                        <!-- Description Field -->
                        <div>
                            <label for="description-{{ $index }}" class="block font-medium mb-2 text-gray-800">
                                Description
                            </label>
                            <textarea id="description-{{ $index }}" wire:model.defer="categories.{{ $index }}.description"
                                placeholder="Enter category description"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white @error('categories.' . $index . '.description') border-red-400 @enderror"></textarea>
                            @error('categories.' . $index . '.description')
                                <p class="text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Image Field -->
                        <div>
                            <label for="image-{{ $index }}" class="block font-medium mb-2 text-gray-800">
                                Image
                            </label>
                            <input type="file" id="image-{{ $index }}"
                                wire:model="categories.{{ $index }}.image"
                                class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white @error('categories.' . $index . '.image') border-red-400 @enderror">
                            @error('categories.' . $index . '.image')
                                <p class="text-red-400 text-sm mt-1 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                            @if (isset($categories[$index]['image']) && $categories[$index]['image'])
                                <div class="mt-2">
                                    <img src="{{ $categories[$index]['image']->temporaryUrl() }}" alt="Preview"
                                        class="h-20 w-auto rounded">
                                </div>
                            @endif
                        </div>

                        <!-- Is Featured and Sort Order -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="is-featured-{{ $index }}"
                                    class="block font-medium mb-2 text-gray-800">
                                    Featured
                                </label>
                                <input type="checkbox" id="is-featured-{{ $index }}"
                                    wire:model.defer="categories.{{ $index }}.is_featured"
                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-400 border-gray-300 rounded">
                                @error('categories.' . $index . '.is_featured')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label for="sort-order-{{ $index }}"
                                    class="block font-medium mb-2 text-gray-800">
                                    Sort Order
                                </label>
                                <input type="number" id="sort-order-{{ $index }}"
                                    wire:model.defer="categories.{{ $index }}.sort_order" placeholder="0"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition-all duration-300 bg-gray-50 hover:bg-white @error('categories.' . $index . '.sort_order') border-red-400 @enderror">
                                @error('categories.' . $index . '.sort_order')
                                    <p class="text-red-400 text-sm mt-1 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Quick Add Button -->
                <button type="button" wire:click="addCategory"
                    class="mb-4 py-1.5 px-3 bg-gradient-to-r from-amber-400 to-amber-600 text-white rounded-full hover:from-amber-500 hover:to-amber-700 transition-all duration-300 shadow-sm hover:shadow-md text-xs font-medium">
                    Quick Add
                </button>

                <!-- Save Category Button -->
                <button type="submit"
                    class="w-52 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-lg hover:from-indigo-700 hover:to-purple-800 transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center font-semibold">
                    <i class="fas fa-save mr-2"></i> Save Category
                </button>

                <!-- Validation Message if No Category -->
                @error('categories')
                    <p class="text-red-400 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror

                <!-- Success Message -->
                @if (session()->has('message'))
                    <p class="text-green-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('message') }}
                    </p>
                @endif
            </section>
        </div>
    </form>
</main>
