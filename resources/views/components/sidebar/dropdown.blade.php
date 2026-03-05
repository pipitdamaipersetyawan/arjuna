@props(['icon','title'])

<div x-data="{ open: false }">

    <button @click="open = !open"
        class="w-full flex items-center justify-between px-3 py-2 rounded-lg hover:bg-slate-800 transition">

        <div class="flex items-center gap-3">
            <i data-lucide="{{ $icon }}" class="w-5"></i>
            <span>{{ $title }}</span>
        </div>

        <i data-lucide="chevron-down" class="w-4"></i>
    </button>

    <div x-show="open" x-transition class="ml-8 mt-2 space-y-2 text-slate-400">
        {{ $slot }}
    </div>

</div>