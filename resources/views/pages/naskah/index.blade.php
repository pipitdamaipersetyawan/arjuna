<x-app-layout>


<div class="w-full px-4">

{{-- HEADER --}}
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-slate-700">Riwayat Naskah</h2>

    <a href="{{ route('naskah.create') }}"
       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm shadow">
        + Buat Naskah
    </a>
</div>

{{-- FILTER & SEARCH --}}
<form method="GET" action="{{ route('naskah.index') }}" class="mb-4">

<div class="grid grid-cols-1 md:grid-cols-6 gap-3">

<input type="text" name="nomor" value="{{ request('nomor') }}"
placeholder="Cari nomor..." class="input">

<input type="text" name="hal" value="{{ request('hal') }}"
placeholder="Cari hal..." class="input">

<input type="text" name="jenis" value="{{ request('jenis') }}"
placeholder="Cari jenis..." class="input">

<input type="text" name="klasifikasi" value="{{ request('klasifikasi') }}"
placeholder="Cari klasifikasi..." class="input">

<input type="date" name="tgl_awal" value="{{ request('tgl_awal') }}"
class="border rounded-lg px-3 py-2 text-sm w-full">

<input type="date" name="tgl_akhir" value="{{ request('tgl_akhir') }}"
class="border rounded-lg px-3 py-2 text-sm w-full">

<input type="text" name="tujuan"
value="{{ request('tujuan') }}"
placeholder="Cari tujuan..."
class="input">

</div>

<div class="flex flex-wrap justify-between items-center mt-3 gap-3">

<select name="perPage" onchange="this.form.submit()"
class="border rounded-lg px-6 py-2 text-sm">

<option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
<option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
<option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
<option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>

</select>

<button class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">
Filter
</button>

</div>

</form>

{{-- TABLE --}}
<div class="bg-white rounded-2xl shadow border border-slate-200 overflow-hidden">
<div class="w-full">

<table class="w-full table-fixed text-sm border border-slate-200">

<thead class="bg-slate-100 text-slate-600">
<tr>
<th class="p-3 border w-12">No</th>
<th class="p-3 border">Tanggal</th>
<th class="p-3 border">Nomor Surat</th>
<th class="p-3 border">Pengirim</th>
<th class="p-3 border">Tujuan</th>
<th class="p-3 border">Jenis</th>
<th class="p-3 border">Sifat</th>
<th class="p-3 border">Klasifikasi</th>
<th class="p-3 border">Hal</th>
<th class="p-3 border text-center">File</th>
<th class="p-3 border text-center">Aksi</th>
</tr>
</thead>

<tbody>

@forelse ($naskah as $item)
<tr class="hover:bg-slate-50 transition">

<td class="p-3 border text-center">
{{ $loop->iteration + $naskah->firstItem() - 1 }}
</td>

<td class="p-3 border whitespace-nowrap">
{{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') }}
</td>

<td class="p-3 border font-semibold text-indigo-600 whitespace-nowrap">
{{ $item->nomor_naskah }}
</td>

<td class="p-3 border">
{{ $item->pengirim }}
</td>

<td class="p-3 border">

{{-- TUJUAN DARI DATABASE --}}
@foreach($item->tujuan as $t)
    <div class="text-xs bg-indigo-50 text-indigo-700 px-2 py-1 rounded mb-1">
        {{ $t->nama }}
    </div>
@endforeach

{{-- TUJUAN MANUAL --}}
@if($item->tujuan_manual)
    @foreach(explode(',', $item->tujuan_manual) as $manual)
        <div class="text-xs bg-emerald-50 text-emerald-700 px-2 py-1 rounded mb-1">
            {{ trim($manual) }}
        </div>
    @endforeach
@endif

{{-- JIKA KOSONG SEMUA --}}
@if($item->tujuan->isEmpty() && !$item->tujuan_manual)
    -
@endif

</td>

<td class="p-3 border">
{{ $item->jenis_naskah }}
</td>

<td class="p-3 border text-center">
<span class="px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-700">
{{ $item->sifat_naskah }}
</span>
</td>

<td class="p-3 border">
{{ $item->klasifikasi_kode }}
</td>

<td class="p-3 border">
{{ $item->hal }}
</td>

<td class="p-3 border text-center">

@if($item->file)

<div class="flex flex-col items-center gap-1">

{{-- Nama file --}}
<div class="text-xs text-slate-600 break-all">
{{ $item->file ? basename($item->file) : '-' }}
</div>

{{-- tombol --}}
<div class="flex gap-2">

<a href="{{ route('preview.file', basename($item->file)) }}"
target="_blank"
class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-3 py-1 rounded">
Preview
</a>

<a href="{{ url('file/naskah/'.basename($item->file)) }}"
download
class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs px-3 py-1 rounded">
Download
</a>

</div>

</div>

@else
-
@endif

</td>
<td class="p-3 border">
<div class="flex justify-center gap-2">

<a href="{{ route('naskah.edit',$item->id) }}"
class="bg-amber-400 hover:bg-amber-500 text-white p-2 rounded-lg shadow">
✏️
</a>

<form action="{{ route('naskah.destroy',$item->id) }}"
method="POST"
onsubmit="return confirm('Hapus data?')">
@csrf
@method('DELETE')

<button class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg shadow">
🗑️
</button>
</form>

</div>
</td>

</tr>

@empty
<tr>
<td colspan="11" class="p-6 text-center text-slate-400 border">
Belum ada data
</td>
</tr>
@endforelse

</tbody>
</table>

</div>
</div>

{{-- PAGINATION --}}
<div class="mt-4 flex justify-between items-center">

<div class="text-sm text-slate-500">
Menampilkan {{ $naskah->firstItem() }} - {{ $naskah->lastItem() }}
dari {{ $naskah->total() }} data
</div>

{{ $naskah->links() }}

</div>

</div>

</x-app-layout>
