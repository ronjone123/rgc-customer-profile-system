@props([
    'href' => url()->previous(),
    'label' => 'Back'
])

<a href="{{ $href }}"
   class="inline-flex items-center gap-2 text-sm text-gray-600 hover:text-gray-900">
    ← {{ $label }}
</a>
