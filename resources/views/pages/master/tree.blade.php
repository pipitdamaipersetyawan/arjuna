<li>
    📁 {{ $item->kode }} - {{ $item->nama }}

    @if ($item->children->count())
        <ul style="margin-left:20px;">
            @foreach ($item->children as $child)
                @include('pages.master.tree', ['item' => $child])
            @endforeach
        </ul>
    @endif
</li>