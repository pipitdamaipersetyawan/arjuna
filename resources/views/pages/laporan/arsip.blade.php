<x-app-layout>

<div id="area-print" class="w-full px-12 py-8 space-y-6">

<!-- JUDUL -->
<div class="text-center space-y-2">
<h1 class="text-2xl font-bold tracking-wide">
LAPORAN ARSIP INAKTIF
</h1>

@if(request('search'))
<p class="text-gray-600 text-sm">
Hasil pencarian: <strong>{{ request('search') }}</strong>
</p>
@endif

</div>

<!-- ACTION BUTTON -->
<div class="flex gap-3 print-hidden">

<button onclick="window.print()"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg">
Cetak
</button>

<a href="{{ route('laporan.arsip.pdf', request()->query()) }}"
class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg">
Export PDF
</a>

<a href="{{ route('laporan.arsip.excel', request()->query()) }}"
class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg">
Export Excel
</a>

</div>

<!-- SEARCH -->
<div class="print-hidden">

<form method="GET"
action="{{ route('laporan.arsip') }}"
class="flex gap-2 mb-4">

<input type="text"
name="search"
value="{{ request('search') }}"
placeholder="Cari nomor surat / pengirim / isi..."
class="border px-4 py-2 rounded w-80">

<button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
Cari
</button>

<a href="{{ route('laporan.arsip') }}"
class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">
Reset
</a>

</form>

</div>

<!-- TABLE -->
<div class="overflow-x-auto rounded-xl border border-gray-300">

<table class="w-full text-sm border-collapse">

<thead class="bg-gray-100">

<tr>

<th class="border px-4 py-2 text-center">No</th>
<th class="border px-4 py-2">Jenis</th>
<th class="border px-4 py-2">Tanggal</th>
<th class="border px-4 py-2">Nomor Surat</th>
<th class="border px-4 py-2">Pengirim</th>
<th class="border px-4 py-2">Isi</th>

</tr>

</thead>

<tbody>

@forelse($data as $index => $d)

<tr>

<td class="border px-4 py-2 text-center">
{{ $data->firstItem() + $index }}
</td>

<td class="border px-4 py-2">
{{ $d->jenis }}
</td>

<td class="border px-4 py-2">
{{ \Carbon\Carbon::parse($d->tanggal_surat)->format('d M Y') }}
</td>

<td class="border px-4 py-2">
{{ $d->nomor_surat }}
</td>

<td class="border px-4 py-2">
{{ $d->pengirim }}
</td>

<td class="border px-4 py-2">
{{ $d->isi }}
</td>

</tr>

@empty

<tr>
<td colspan="6" class="text-center py-6 text-gray-500">
Tidak ada data ditemukan
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<!-- PAGINATION -->
<div class="flex justify-between mt-4 text-sm">

<div>
Total Data: <strong>{{ $data->total() }}</strong>
</div>

<div class="print-hidden">
{{ $data->withQueryString()->links() }}
</div>

</div>

</div>

</x-app-layout>
