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
            <li>
                <a href="{{ route('categories.index') }}"
                    class="hover:text-indigo-500 transition-colors duration-200 flex items-center">
                    <i class="fas fa-layer-group mr-1"></i>Categories
                </a>
            </li>
            <li><i class="fas fa-chevron-right text-xs text-gray-400"></i></li>
            <li class="text-gray-800 font-semibold flex items-center">
                <i class="fas fa-eye mr-1"></i>Category Details
            </li>
        </ol>
    </nav>

    <!-- Success Message -->
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl animate-fade-in mb-6">
            <p class="text-green-600 text-sm flex items-center">
                <i class="fas fa-check-circle mr-2"></i> {{ session('message') }}
            </p>
        </div>
    @endif

    <!-- Category Details -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
        <section class="lg:col-span-4 bg-white/95 rounded-xl shadow-2xl p-6 border border-gray-100/50 backdrop-blur-sm">

            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-indigo-600 to-purple-700 rounded-lg flex items-center justify-center">
                        <i class="fas fa-layer-group text-white text-lg"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">{{ $category->name }}</h2>
                </div>
                <a href="{{ route('categories.edit', $category->slug) }}"
                    class="text-sm bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors duration-200 font-medium">
                    Edit Category
                </a>
            </div>

            <!-- Category Card -->
            <div
                class="bg-gradient-to-r from-gray-50/80 to-blue-50/50 rounded-xl p-6 border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Image -->
                    <div>
                        @if ($category->image)
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                class="w-full h-64 object-cover rounded-lg">
                        @else
                            <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Details -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1 flex items-center">
                                <i class="fas fa-tag mr-2"></i>Title
                            </label>
                            <p class="text-gray-800 text-lg">{{ $category->name }}</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1 flex items-center">
                                <i class="fas fa-align-left mr-2"></i>Description
                            </label>
                            <p class="text-gray-600">
                                {{ $category->description ?: 'No description available.' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-1 flex items-center">
                                    <i class="fas fa-star mr-2"></i>Featured
                                </label>
                                <span
                                    class="text-sm font-medium {{ $category->is_featured ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }} px-2 py-1 rounded-full">
                                    {{ $category->is_featured ? 'Featured' : 'Not Featured' }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-1 flex items-center">
                                    <i class="fas fa-sort-numeric-up mr-2"></i>Sort Order
                                </label>
                                <span class="text-sm font-medium bg-gray-100 text-gray-700 px-2 py-1 rounded-full">
                                    {{ $category->sort_order }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6 flex justify-end">
                <a href="{{ route('categories.index') }}"
                    class="text-sm bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors duration-200 font-medium">
                    Back to Categories
                </a>
            </div>
        </section>
    </div>
</main>
