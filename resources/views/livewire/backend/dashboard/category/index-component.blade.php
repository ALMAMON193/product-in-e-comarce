<main class="flex-1 overflow-auto p-4 lg:p-6" role="main">
    <nav aria-label="breadcrumb" class="mb-4 lg:mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-600">
            <li><a href="#" class="hover:text-blue-600 transition-colors">Home</a></li>
            <li><i class="fas fa-chevron-right text-xs"></i></li>
            <li class="text-gray-900 font-medium">categories</li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <!-- Table Header -->
        <div class="p-4 lg:p-6 border-b border-gray-200">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h3 class="text-lg lg:text-xl font-bold text-gray-800">All categories</h3>
                    <p class="text-sm text-gray-600 mt-1">Total <span
                            class="font-semibold">{{ $categories->total() }}</span> categories found</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <!-- Search -->
                    <div class="relative flex-1 sm:w-48 lg:w-64">
                        <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                            </svg>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search categories"
                            class="w-full pl-9 lg:pl-10 pr-4 py-2 lg:py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-1 focus:outline-none focus:ring-blue-500 focus:border-transparent" />
                    </div>

                    <!-- Status Filter -->
                    <div class="relative flex-1 sm:w-32 lg:w-48">
                        <select wire:model.live="statusFilter"
                            class="w-full pl-3 lg:pl-4 pr-8 lg:pr-10 py-2 lg:py-2.5 text-sm border border-gray-300 rounded-lg text-gray-700 focus:ring-1 focus:outline-none focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="on-hold">On Hold</option>
                        </select>
                    </div>

                    <!-- Per Page -->
                    <div class="relative w-full sm:w-20 lg:w-40">
                        <select wire:model.live="perPage"
                            class="w-full pl-3 lg:pl-4 pr-8 lg:pr-10 py-2 lg:py-2.5 text-sm border border-gray-300 rounded-lg text-gray-700 focus:ring-1 focus:outline-none focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <x-buttons.add :href="route('categories.create')" icon="plus" color="blue" navigate="true">
                        Add New
                    </x-buttons.add>
                </div>
            </div>
        </div>

        <!-- Table -->

        <div class="relative overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>

                        <th
                            class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>

                        <th
                            class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Description
                        </th>
                        <th
                            class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Status
                        </th>
                        <th
                            class="px-4 lg:px-6 py-3 lg:py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Created
                        </th>
                        <th
                            class="px-4 lg:px-6 py-3 lg:py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $item)
                        <tr class="hover:bg-gray-50 transition-colors">

                            <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm font-medium text-gray-600">{{ $item->name }}</div>
                            </td>
                            <td
                                class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                                <div class="text-sm text-gray-600">
                                    {{ Str::limit($item->description, 100, '...') ?? '-' }}</div>
                            </td>
                            <td
                                class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold {{ $item->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td
                                class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm text-gray-500 hidden lg:table-cell">
                                <div class="text-sm text-gray-600">{{ $item->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('categories.edit', $item->slug) }}" wire:navigate
                                        class="text-indigo-600 hover:text-indigo-900 transition-colors p-1"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('categories.view', $item->slug) }}" wire:navigate
                                        class="text-indigo-600 hover:text-indigo-900 transition-colors p-1"
                                        title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button wire:click="delete({{ $item->id }})" wire:confirm="Are you sure?"
                                        class="text-red-600 hover:text-red-900 transition-colors p-1" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <x-table-empty-state colspan="7" title="No categories Yet"
                            message="No categories have been added yet!">
                            <x-slot name="icon">
                                <svg class="w-14 h-14 text-red-500 animate-bounce" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                </svg>
                            </x-slot>
                        </x-table-empty-state>
                    @endforelse
                </tbody>
            </table>


            <!-- Loading Overlay -->
            <x-loading-overlay />
        </div>
        <!-- Footer Pagination -->
        <x-form.pagination :paginator="$categories" :pageRange="$pageRange" />
    </div>
</main>
