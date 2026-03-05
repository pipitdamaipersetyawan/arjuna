<x-app-layout>

<div class="w-full">

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

<!-- JUDUL -->
<div class="text-center space-y-2 mb-6">

<h1 class="text-2xl font-bold tracking-wide">
LAPORAN NASKAH KELUAR
</h1>

@if(request('start') && request('end'))
<p class="text-gray-600 text-sm">
Periode {{ \Carbon\Carbon::parse(request('start'))->format('d F Y') }}
s/d
{{ \Carbon\Carbon::parse(request('end'))->format('d F Y') }}
</p>
@endif

@if(request('search'))
<p class="text-gray-600 text-sm">
Hasil pencarian untuk: <strong>{{ request('search') }}</strong>
</p>
@endif

</div>


<!-- TOMBOL CETAK / EXPORT -->
<div class="flex justify-start gap-3 mb-6 print-hidden">

<a href="{{ route('laporan.naskah-keluar.cetak', request()->query()) }}"
target="_blank"
class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow">
Cetak
</a>

<a href="{{ route('laporan.naskah-keluar.pdf', request()->query()) }}"
class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow">
Export PDF
</a>

<a href="{{ route('laporan.naskah-keluar.excel', request()->query()) }}"
class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow">
Export Excel
</a>

</div>


<!-- FILTER -->
<div class="bg-white shadow rounded-xl p-6 border mb-6 print-hidden">

<form method="GET" class="grid md:grid-cols-5 gap-4 items-end">

<div>
<label class="text-sm text-gray-600">Dari Tanggal</label>
<input type="date"
name="start"
value="{{ request('start') }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="text-sm text-gray-600">Sampai Tanggal</label>
<input type="date"
name="end"
value="{{ request('end') }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div class="md:col-span-2">
<label class="text-sm text-gray-600">Pencarian</label>
<input type="text"
name="search"
placeholder="Cari nomor / tujuan / perihal..."
value="{{ request('search') }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div class="flex gap-2">

<button
class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2">
Filter
</button>

<a href="{{ route('laporan.naskah-keluar') }}"
class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg px-4 py-2 text-center">
Reset
</a>

</div>

</form>

</div>


{{-- TABLE (TIDAK DIUBAH) --}}
<div class="overflow-x-auto rounded-xl border border-slate-300">
<table class="min-w-full text-sm">

<thead class="bg-slate-100 text-slate-700 uppercase text-xs">
<tr>
<th class="border px-3 py-2 text-center">No</th>
<th class="border px-3 py-2">Tanggal</th>
<th class="border px-3 py-2">Nomor Surat</th>
<th class="border px-3 py-2">Pengirim</th>
<th class="border px-3 py-2">Tujuan</th>
<th class="border px-3 py-2">Jenis</th>
<th class="border px-3 py-2">Sifat</th>
<th class="border px-3 py-2">Klasifikasi</th>
<th class="border px-3 py-2">Hal</th>
<th class="border px-3 py-2">File</th>
</tr>
</thead>

<tbody>
@forelse ($data as $item)

<tr class="hover:bg-slate-50">

<td class="border px-3 py-2 text-center">
{{ $loop->iteration + ($data->currentPage()-1) * $data->perPage() }}
</td>

<td class="border px-3 py-2">
{{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d M Y') }}
</td>

<td class="border px-3 py-2">
{{ $item->nomor_naskah }}
</td>

<td class="border px-3 py-2">
{{ $item->pengirim }}
</td>

<td class="border px-3 py-2 align-top">

@foreach($item->tujuan as $t)
<div class="mb-1 bg-slate-100 px-2 py-1 rounded text-xs inline-block">
{{ $t->nama }}
</div>
@endforeach

@if($item->tujuan_manual)
<div class="mb-1 bg-slate-100 px-2 py-1 rounded text-xs inline-block">
{{ $item->tujuan_manual }}
</div>
@endif

</td>

<td class="border px-3 py-2">
{{ $item->jenis_naskah }}
</td>

<td class="border px-3 py-2 text-center">
{{ $item->sifat_naskah }}
</td>

<td class="border px-3 py-2">
{{ $item->klasifikasi_kode }}
</td>

<td class="border px-3 py-2">
{{ $item->hal }}
</td>

<td class="border px-3 py-2 text-center">
@if($item->file)
✔
@else
-
@endif
</td>

</tr>

@empty

<tr>
<td colspan="10" class="text-center py-6 text-slate-500">
Data tidak ditemukan
</td>
</tr>

@endforelse

</tbody>

</table>
</div>


<div class="mt-6">
{{ $data->withQueryString()->links() }}
</div>

</div>
</div>

</x-app-layout>
