<main class="flex-1 overflow-auto p-4 lg:p-6 bg-gradient-to-br from-gray-100 to-gray-200" role="main">

    <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="mb-4 lg:mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="hover:text-indigo-500 transition-colors duration-200 flex items-center">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
            </li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li class="text-gray-800 font-semibold flex items-center">
                <i class="fas fa-layer-group mr-1"></i> Edit Category
            </li>
        </ol>
    </nav>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl animate-fade-in mb-3">
            <p class="text-green-600 text-sm flex items-center">
                <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
            </p>
        </div>
    @endif

    <!-- Form -->
    <form wire:submit.prevent="update" class="space-y-6">
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
                        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Category</h2>
                    </div>
                    <div class="text-sm bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full font-medium">
                        Editing
                    </div>
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <x-form.input id="name" label="Title *" icon="tag" wireModel="name" :error="$errors->first('name')" />
                </div>
                <!-- Description -->
                <x-form.textarea id="description" label="Description" icon="align-left" wireModel="description"
                    :error="$errors->first('description')" />

                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2 flex items-center">
                        Image <span class="text-red-500 ml-1">*</span>
                        <i class="fas fa-info-circle ml-2 text-gray-400 hover:text-gray-600 cursor-help"
                            title="Upload an image for the category"></i>
                    </label>

                    <label
                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors @error('image') border-red-500 @enderror">

                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            {{-- নতুন image preview --}}
                            @if ($image && in_array(strtolower($image->extension()), ['jpg', 'jpeg', 'png', 'webp', 'gif']))
                                <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg mb-2">

                                {{-- পুরনো image preview --}}
                            @elseif ($oldImage)
                                <img src="{{ asset($oldImage) }}" class="w-32 h-32 object-cover rounded-lg mb-2">

                                {{-- fallback --}}
                            @else
                                <svg class="w-6 h-6 mb-2 text-gray-500" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56
                        0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137
                        5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10
                        15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-1 text-xs text-gray-500"><span class="font-semibold">Click to
                                        upload</span> or drag and drop</p>
                            @endif
                        </div>

                        <input type="file" wire:model="image" accept="image/*" class="hidden" />
                    </label>

                    @error('image')
                        <p class="mt-1 text-sm text-red-500 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>


                <!-- Featured + Sort Order -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-form.switch-toggle label="Featured Category" wireModel="is_featured" :checked="$is_featured" />
                    <x-form.input id="sort_order" label="Sort Order" icon="sort-numeric-up" type="number"
                        wireModel="sort_order" :error="$errors->first('sort_order')" />
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end pt-6  border-gray-200">
                    <x-buttons.primary>Save Changes</x-buttons.primary>
                </div>
            </section>
        </div>
    </form>
</main>
