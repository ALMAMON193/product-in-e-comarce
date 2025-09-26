@props(['id', 'label', 'icon' => null, 'type' => 'text', 'error' => null, 'wireModel'])

<div class="space-y-2">
    <label for="{{ $id }}" class="block font-medium text-gray-800 flex items-center">
        @if ($icon)
            <i class="fas fa-{{ $icon }} text-blue-500 mr-2"></i>
        @endif
        {{ $label }}
    </label>

    <input id="{{ $id }}" type="{{ $type }}"
        {{ $attributes->merge([
            'class' =>
                'w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500
                                 focus:border-transparent transition-all duration-300 bg-white hover:border-gray-400
                                 placeholder-gray-400 ' . ($error ? 'border-red-400 ring-2 ring-red-100' : ''),
        ]) }}
        wire:model.defer="{{ $wireModel }}">

    @if ($error)
        <p class="text-red-500 text-sm mt-1 flex items-center animate-pulse">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ $error }}
        </p>
    @endif
</div>
