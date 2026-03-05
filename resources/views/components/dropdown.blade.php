@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white',
    'dropdownClasses' => '',
    'active' => false
])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    'none', 'false' => '',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    '60' => 'w-60',
    default => 'w-48',
};
@endphp

<div class="relative"
     x-data="{ open: {{ $active ? 'true' : 'false' }} }"
     @click.away="open = false">

    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div x-show="open"
        x-transition
        class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg
               {{ $alignmentClasses }} {{ $dropdownClasses }}"
        style="display: none;">

        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>

    </div>
</div>
