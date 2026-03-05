@props(['icon','route','title'])

<a href="{{ route($route) }}"
   class="flex items-center gap-2 hover:text-white transition">

    <i data-lucide="{{ $icon }}" class="w-4"></i>
    <span>{{ $title }}</span>

</a>