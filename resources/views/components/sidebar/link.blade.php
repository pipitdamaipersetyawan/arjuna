@props(['icon','route','title'])

@php
$active = request()->routeIs($route);
@endphp

<a href="{{ route($route) }}"
   class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all
   {{ $active ? 'bg-blue-600 text-white shadow-md border-l-4 border-white'
              : 'hover:bg-slate-800 text-slate-300' }}">

    <i data-lucide="{{ $icon }}" class="w-5"></i>
    <span>{{ $title }}</span>
</a>