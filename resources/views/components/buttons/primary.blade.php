@props(['icon' => 'save'])

<button type="submit"
    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white
           rounded-lg hover:from-indigo-700 hover:to-purple-800 transition-all duration-300 shadow-lg
           hover:shadow-xl transform hover:scale-105 font-semibold">
    <i class="fas fa-{{ $icon }} mr-2"></i> {{ $slot }}
</button>
