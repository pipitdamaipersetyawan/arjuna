<x-app-layout>

<div class="w-full px-8 py-6">

<h1 class="text-xl font-semibold text-slate-700 mb-4">
Arsip Aktif
</h1>

<!-- FILTER -->
<form method="GET" class="flex flex-wrap items-center gap-2 mb-5">

<input
type="text"
name="search"
value="{{ request('search') }}"
placeholder="Cari nomor surat..."
class="border rounded-lg px-3 py-2 text-sm w-56"
/>

<input
type="date"
name="start"
value="{{ request('start') }}"
class="border rounded-lg px-3 py-2 text-sm"
/>

<input
type="date"
name="end"
value="{{ request('end') }}"
class="border rounded-lg px-3 py-2 text-sm"
/>

<select
name="perPage"
class="border rounded-lg px- py-2 text-sm"
>

<option value="10" {{ request('perPage')==10?'selected':'' }}>10</option>
<option value="25" {{ request('perPage')==25?'selected':'' }}>25</option>
<option value="50" {{ request('perPage')==50?'selected':'' }}>50</option>

</select>

<button
class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-lg text-sm"
>
Filter
</button>

</form>

<!-- TABLE -->
<div class="bg-white rounded-xl shadow border border-slate-200 overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-slate-100 text-slate-700">

<tr>

<th class="px-4 py-3 text-left">No</th>
<th class="px-4 py-3 text-left">Jenis</th>
<th class="px-4 py-3 text-left">Tanggal Input</th>
<th class="px-4 py-3 text-left">Tanggal Surat</th>
<th class="px-4 py-3 text-left">Nomor</th>
<th class="px-4 py-3 text-left">Pengirim</th>
<th class="px-4 py-3 text-left">Isi</th>

</tr>

</thead>

<tbody class="divide-y">

@foreach($data as $d)

<tr class="hover:bg-slate-50">

<td class="px-4 py-2">
{{ $data->firstItem() + $loop->index }}
</td>

<td class="px-4 py-2">

@if($d->jenis == 'Naskah Keluar')

<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
{{ $d->jenis }}
</span>

@else

<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-medium">
{{ $d->jenis }}
</span>

@endif

</td>

<td class="px-4 py-2">

{{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('d F Y') }}

</td>

<td class="px-4 py-2">

{{ \Carbon\Carbon::parse($d->tanggal_surat)->translatedFormat('d F Y') }}

</td>

<td class="px-4 py-2 text-blue-600 font-medium">

{{ $d->nomor_surat ?? '-' }}

</td>

<td class="px-4 py-2">

{{ $d->pengirim }}

</td>

<td class="px-4 py-2">

{{ $d->isi ?? '-' }}

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<!-- FOOTER -->
<div class="flex justify-between items-center mt-4 text-sm text-slate-600">

<div>

Menampilkan
{{ $data->firstItem() }}
-
{{ $data->lastItem() }}
dari
{{ $data->total() }}
data

</div>

<div>

{{ $data->links() }}

</div>

</div>

</div>

</x-app-layout>
