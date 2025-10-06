<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" as="style"
        onload="this.rel='stylesheet'">
</head>

<body class="bg-gray-100 font-sans text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('backend.partials.nav')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            @include('backend.partials.header')

            <!-- Dynamic Content -->
            {{ $slot }}
        </div>
    </div>

    @livewireScripts
    @stack('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.addEventListener('swal:alert', event => {
            Swal.fire({
                icon: event.detail.type,
                title: event.detail.message,
                timer: 2000,
                showConfirmButton: false
            });
        });
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>
