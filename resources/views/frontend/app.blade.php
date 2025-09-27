<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Filter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles()
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">Products</h1>
            <a href="{{ route('product.index') }}" wire:navigate
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-user mr-2"></i>Login
            </a>
        </div>
    </header>

    {{ $slot }}
    <!-- Toggle Sidebar Script -->
    <script>
        const toggleButton = document.getElementById('toggleFilters');
        const sidebar = document.getElementById('sidebar');

        toggleButton?.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    </script>

    @livewireScripts()
</body>

</html>
