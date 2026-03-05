<x-app-layout>

<div class="mb-4">
    <input type="text"
           id="searchKlasifikasi"
           placeholder="Cari kode / nama klasifikasi..."
           class="w-full border rounded-lg px-4 py-2">
</div>

<h2 class="text-lg font-semibold mb-4">Bagan Klasifikasi</h2>

<ul class="space-y-1">

@foreach($data as $item)
    @include('pages.master.partials.klasifikasi-item', ['item' => $item])
@endforeach

</ul>

</x-app-layout>
