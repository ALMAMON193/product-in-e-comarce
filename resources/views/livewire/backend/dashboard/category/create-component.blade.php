<main class="flex-1 overflow-auto p-4 lg:p-6 bg-gradient-to-br from-gray-100 to-gray-200" role="main">
    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4 lg:mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="hover:text-indigo-500 transition-colors duration-200 flex items-center">
                    <i class="fas fa-home mr-1"></i>Home
                </a>
            </li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li class="text-gray-800 font-semibold flex items-center">
                <i class="fas fa-layer-group mr-1"></i>Create Project Category
            </li>
        </ol>
    </nav>
    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl animate-fade-in">
            <p class="text-green-600 text-sm flex items-center">
                <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
            </p>
        </div>
    @endif
    <!-- Form -->
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
            <section
                class="lg:col-span-4 bg-white/95 rounded-xl shadow-2xl p-6 border border-gray-100/50 backdrop-blur-sm">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center">
                            <i class="fas fa-layer-group text-white text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Project Category</h2>
                    </div>
                    <div class="text-sm bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full font-medium">
                        {{ count($categories) }} {{ count($categories) === 1 ? 'Category' : 'Categories' }}
                    </div>
                </div>

                <!-- Dynamic Categories -->
                @foreach ($categories as $index => $category)
                    <div
                        class="mb-8 bg-gradient-to-r from-gray-50/80 to-blue-50/50 rounded-xl p-6 border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300 space-y-6">
                        <!-- Category Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-gray-200/60">
                            <div class="flex items-center space-x-3">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800">Category {{ $index + 1 }}</h3>
                            </div>
                            @if (count($categories) > 1)
                                <button type="button" wire:click="removeCategory({{ $index }})"
                                    class="text-red-400 hover:text-red-600 hover:bg-red-50 transition-all duration-200 p-2 rounded-lg transform hover:scale-110">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            @endif
                        </div>

                        <!-- Title -->
                        <x-form.input id="name-{{ $index }}" label="Title *" icon="tag"
                            wireModel="categories.{{ $index }}.name" :error="$errors->first('categories.' . $index . '.name')" />
                        <!-- Description -->
                        <x-form.textarea id="description-{{ $index }}" label="Description" icon="align-left"
                            wireModel="categories.{{ $index }}.description" :error="$errors->first('categories.' . $index . '.description')" />

                        <!-- Image Upload -->


                        <!-- Featured + Sort Order -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-form.switch-toggle label="Featured Category"
                                wireModel="categories.{{ $index }}.is_featured" :checked="isset($categories[$index]['is_featured']) &&
                                    $categories[$index]['is_featured']" />

                            <x-form.input id="sort-order-{{ $index }}" label="Sort Order" icon="sort-numeric-up"
                                type="number" wireModel="categories.{{ $index }}.sort_order"
                                :error="$errors->first('categories.' . $index . '.sort_order')" />
                        </div>
                    </div>
                @endforeach

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <x-buttons.add wireClick="addCategory">Quick Add Category</x-buttons.add>
                    <x-buttons.primary>
                        Save {{ count($categories) }} {{ count($categories) === 1 ? 'Category' : 'Categories' }}
                    </x-buttons.primary>
                </div>

                <!-- Validation Message if No Category -->
                @error('categories')
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <p class="text-red-600 text-sm flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i> {{ $message }}
                        </p>
                    </div>
                @enderror
            </section>
        </div>
    </form>
</main>
