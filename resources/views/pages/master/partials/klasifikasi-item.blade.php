<li class="klas-item">

<div class="flex items-center gap-2 cursor-pointer toggle">

    @if($item->children->count())
        <span class="arrow transition-transform">▶</span>
    @else
        <span class="w-3"></span>
    @endif

    <span class="font-semibold text-indigo-600">
        {{ $item->kode }}
    </span>

    <span>{{ $item->nama }}</span>

</div>

@if($item->children->count())
<ul class="ml-6 hidden">
    @foreach($item->children as $child)
        @include('pages.master.partials.klasifikasi-item',['item'=>$child])
    @endforeach
</ul>
@endif

</li>
