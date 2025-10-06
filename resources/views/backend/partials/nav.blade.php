<!-- Mobile Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40 lg:hidden"></div>

<!-- Mobile Menu Button -->
<button id="mobileSidebarButton" class="lg:hidden p-3 text-gray-800 bg-gray-200 rounded-md fixed top-4 left-4 z-50">
    <i class="fas fa-bars text-xl"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed lg:static top-0 left-0 w-64 h-full bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50 flex flex-col">

    <!-- Logo -->
    <div class="p-6 border-b border-gray-700/50 flex items-center space-x-4">
        <div
            class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
            <i class="fas fa-tachometer-alt text-white text-xl"></i>
        </div>
        <div>
            <h1 class="text-xl font-bold">AdminPanel</h1>
            <p class="text-sm text-gray-300">v2.1</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-4 py-6 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-600 scrollbar-track-gray-800">
        <ul class="space-y-2">

            <!-- Project Dropdown -->
            <li>
                <button class="flex items-center w-full px-4 py-3 rounded-lg text-gray-300 hover:text-white"
                    onclick="toggleDropdown(this)">
                    <i class="fas fa-box w-5 mr-4"></i>
                    <span class="flex-1 text-left font-medium">Project</span>
                    <i class="fas fa-chevron-right ml-auto transition-transform dropdown-icon"></i>
                </button>
                <ul class="hidden mt-1 ml-6 pl-4 border-l border-gray-700/40 space-y-1 text-sm">
                    <li><a wire:navigate href="{{ route('categories.index') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-list w-4 mr-2"></i> Category List</a></li>
                    <li><a wire:navigate href="{{ route('categories.create') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-plus w-4 mr-2"></i> Add Category</a></li>
                    <li><a wire:navigate href="{{ route('sub.categories.index') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-list-alt w-4 mr-2"></i> Sub-Category List</a></li>
                    <li><a wire:navigate href="{{ route('sub.categories.create') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-folder-plus w-4 mr-2"></i> Add Sub-Category</a></li>
                    <li><a wire:navigate href="{{ route('product.index') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-boxes w-4 mr-2"></i> Product List</a></li>
                    <li><a wire:navigate href="{{ route('product.create') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-box w-4 mr-2"></i> Add Product</a></li>
                </ul>
            </li>

            <!-- Table Dropdown -->
            <li>
                <button class="flex items-center w-full px-4 py-3 rounded-lg text-gray-300 hover:text-white"
                    onclick="toggleDropdown(this)">
                    <i class="fas fa-box w-5 mr-4"></i>
                    <span class="flex-1 text-left font-medium">Table</span>
                    <i class="fas fa-chevron-right ml-auto transition-transform dropdown-icon"></i>
                </button>
                <ul class="hidden mt-1 ml-6 pl-4 border-l border-gray-700/40 space-y-1 text-sm">
                    <li><a wire:navigate href="{{ route('categories.index') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-list w-4 mr-2"></i> Basic Table</a></li>
                    <li><a wire:navigate href="{{ route('categories.create') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-plus w-4 mr-2"></i> Data Table</a></li>
                </ul>
            </li>
            <!-- From Dropdown -->
            <li>
                <button class="flex items-center w-full px-4 py-3 rounded-lg text-gray-300 hover:text-white"
                    onclick="toggleDropdown(this)">
                    <i class="fas fa-box w-5 mr-4"></i>
                    <span class="flex-1 text-left font-medium">From</span>
                    <i class="fas fa-chevron-right ml-auto transition-transform dropdown-icon"></i>
                </button>
                <ul class="hidden mt-1 ml-6 pl-4 border-l border-gray-700/40 space-y-1 text-sm">
                    <li><a wire:navigate href="{{ route('categories.index') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-list w-4 mr-2"></i> Basic Table</a></li>
                    <li><a wire:navigate href="{{ route('categories.create') }}"
                            class="flex items-center px-3 py-2 rounded-md hover:bg-gray-700/40 text-gray-300 hover:text-white"><i
                                class="fas fa-plus w-4 mr-2"></i> Data Table</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Profile -->
    <div class="p-4 border-t border-gray-700/50 mt-auto">
        <div
            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gradient-to-r hover:from-blue-600/20 hover:to-indigo-600/20 transition-all duration-300 group">
            <div class="relative">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face"
                    alt="Admin" class="w-10 h-10 rounded-full object-cover ring-2 ring-blue-500/30">
                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-gray-800">
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate">Al Mamon</p>
                <p class="text-xs text-gray-300 truncate">Administrator</p>
            </div>
            <button class="text-gray-300 hover:text-red-400 transition-colors p-1 opacity-0 group-hover:opacity-100">
                <i class="fas fa-sign-out-alt text-sm"></i>
            </button>
        </div>
    </div>
</aside>

<!-- JS -->
<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const mobileButton = document.getElementById('mobileSidebarButton');

    // Mobile toggle
    mobileButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    // Dropdown toggle
    function toggleDropdown(btn) {
        const menu = btn.nextElementSibling;
        menu.classList.toggle('hidden');
        const icon = btn.querySelector('.dropdown-icon');
        icon.classList.toggle('rotate-90');
    }
</script>
