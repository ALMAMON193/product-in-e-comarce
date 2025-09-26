@props(['label', 'icon' => 'star', 'wireModel', 'checkedLabel' => 'Featured', 'uncheckedLabel' => 'Not Featured'])

<div class="space-y-2">
    <label class="block font-medium text-gray-800 flex items-center">
        <i class="fas fa-{{ $icon }} text-yellow-500 mr-2"></i>
        {{ $label }}
    </label>
    <label class="relative inline-flex items-center cursor-pointer">
        <input type="checkbox" class="sr-only peer" wire:model.defer="{{ $wireModel }}">
        <div
            class="w-12 h-6 bg-gray-300 rounded-full peer peer-checked:bg-gradient-to-r
                   peer-checked:from-blue-500 peer-checked:to-indigo-600 after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6">
        </div>
        <span class="ml-3 text-sm text-gray-600">
            {{ $attributes->wire('model')->value() ? $checkedLabel : $uncheckedLabel }}
        </span>
    </label>
</div>
