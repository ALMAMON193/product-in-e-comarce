@props(['icon' => 'plus', 'wireClick' => null, 'href' => null])

@if ($href)
    <a href="{{ $href }}"
        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white
              rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-md
              hover:shadow-lg transform hover:scale-105 font-medium">
        <i class="fas fa-{{ $icon }} mr-2"></i> {{ $slot }}
    </a>
@else
    <button type="button" @if ($wireClick) wire:click="{{ $wireClick }}" @endif
        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white
               rounded-lg hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-md
               hover:shadow-lg transform hover:scale-105 font-medium">
        <i class="fas fa-{{ $icon }} mr-2"></i> {{ $slot }}
    </button>
@endif
