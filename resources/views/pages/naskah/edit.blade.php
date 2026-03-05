<x-app-layout>

<div class="max-w-6xl mx-auto">
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

{{-- HEADER --}}
<div class="mb-8">
    <h2 class="text-xl font-semibold text-slate-700">
        Edit Naskah
    </h2>
    <p class="text-sm text-slate-500">
        Perbarui data naskah
    </p>
</div>

<form action="{{ route('naskah.update',$naskah->id) }}"
      method="POST"
      enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

{{-- TANGGAL --}}
<div>
<label class="text-sm font-medium">
Tanggal Surat <span class="text-red-500">*</span>
</label>

<input type="date"
name="tanggal_surat"
value="{{ old('tanggal_surat',$naskah->tanggal_surat) }}"
class="w-full rounded-lg border-slate-300 text-sm">

@error('tanggal_surat')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror
</div>

{{-- NOMOR --}}
<div>
<label class="text-sm font-medium">
Nomor Naskah <span class="text-red-500">*</span>
</label>

<input type="text"
name="nomor_naskah"
value="{{ old('nomor_naskah',$naskah->nomor_naskah) }}"
class="w-full rounded-lg border-slate-300 text-sm">

@error('nomor_naskah')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror
</div>

{{-- PENGIRIM --}}
<div>
<label class="text-sm font-medium">Pengirim</label>
<input type="text"
value="{{ $naskah->pengirim }}"
readonly
class="w-full rounded-lg bg-slate-100 border-slate-200 text-sm">
</div>

{{-- JENIS --}}
<div>
<label class="text-sm font-medium">
Jenis Naskah <span class="text-red-500">*</span>
</label>

<select name="jenis_naskah"
class="w-full border rounded-lg px-3 py-2 text-sm">

@foreach([
'INSTRUKSI','SURAT DINAS','SURAT EDARAN','SURAT BIASA','SURAT KETERANGAN',
'SURAT PERINTAH','SURAT IZIN','SURAT PERJANJIAN',
'SURAT PERINTAH TUGAS','SURAT PERINTAH PERJALANAN DINAS',
'SURAT KUASA','SURAT UNDANGAN','NOTA DINAS','LAPORAN'
] as $j)

<option value="{{ $j }}"
{{ $naskah->jenis_naskah == $j ? 'selected' : '' }}>
{{ $j }}
</option>

@endforeach
</select>

@error('jenis_naskah')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror
</div>

{{-- SIFAT --}}
<div>
<label class="text-sm font-medium">
Sifat Naskah <span class="text-red-500">*</span>
</label>

<select name="sifat_naskah"
class="w-full border rounded-lg px-3 py-2 text-sm">

<option value="B" {{ $naskah->sifat_naskah=='B'?'selected':'' }}>Biasa</option>
<option value="SR" {{ $naskah->sifat_naskah=='SR'?'selected':'' }}>Sangat Rahasia</option>
<option value="R" {{ $naskah->sifat_naskah=='R'?'selected':'' }}>Rahasia</option>
<option value="T" {{ $naskah->sifat_naskah=='T'?'selected':'' }}>Terbatas</option>

</select>

@error('sifat_naskah')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror
</div>

{{-- KLASIFIKASI --}}
<div>
<label class="text-sm font-medium">
Klasifikasi <span class="text-red-500">*</span>
</label>

<select id="klasifikasi"
name="klasifikasi_kode"
class="w-full border rounded-lg px-3 py-2 text-sm">

@foreach ($klasifikasi as $k)
<option value="{{ $k->kode }}"
{{ $naskah->klasifikasi_kode == $k->kode ? 'selected' : '' }}>
{{ $k->kode }} — {{ $k->nama }}
</option>
@endforeach

</select>

@error('klasifikasi_kode')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror
</div>

{{-- TUJUAN --}}
<div class="md:col-span-2">

<label class="text-sm font-medium">
Tujuan <span class="text-red-500">*</span>
</label>

<select id="tujuan"
        name="tujuan[]"
        multiple
        class="w-full">

{{-- tujuan dari master --}}
@foreach($listTujuan as $group => $items)
    <optgroup label="{{ $group }}">
        @foreach($items as $t)
            <option value="{{ $t->id }}"
                {{ $naskah->tujuan->pluck('id')->contains($t->id) ? 'selected' : '' }}>
                {{ $t->nama }}
            </option>
        @endforeach
    </optgroup>
@endforeach

{{-- tujuan manual lama dijadikan option selected --}}
{{-- @if($naskah->tujuan_manual) --}}
    {{-- @foreach(explode(',', $naskah->tujuan_manual) as $manual) --}}
        {{-- <option value="{{ trim($manual) }}" selected> --}}
            {{-- {{ trim($manual) }} --}}
        {{-- </option> --}}
    {{-- @endforeach --}}
{{-- @endif --}}

</select>

</div>

{{-- HAL --}}
<div class="md:col-span-2">
<label class="text-sm font-medium">
Hal <span class="text-red-500">*</span>
</label>

<input type="text"
name="hal"
value="{{ old('hal',$naskah->hal) }}"
class="w-full border rounded-lg px-3 py-2 text-sm">

@error('hal')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror
</div>

</div>

{{-- RINGKASAN --}}
<div class="mt-6">
<label class="text-sm font-medium">
Isi Ringkasan <span class="text-red-500">*</span>
</label>

<textarea name="ringkasan"
rows="4"
class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('ringkasan',$naskah->ringkasan) }}</textarea>

@error('ringkasan')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror
</div>

{{-- FILE --}}
<div class="mt-6">

<label class="text-sm font-medium">
Upload File Naskah Format File : PDF, DOCX, XLSX, PPTX
<span class="text-slate-400 text-xs">(Maks: 2MB)</span>
</label>

<input type="file" name="file_naskah"
class="w-full border rounded-lg px-3 py-2 text-sm">

@error('file_naskah')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror

@if(!empty($naskah->file))
<div class="mt-3 flex gap-2">

<a href="{{ asset('storage/'.$naskah->file) }}"
target="_blank"
class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs px-4 py-2 rounded-lg shadow">

Preview
</a>

<a href="{{ asset('storage/'.$naskah->file) }}"
download
class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs px-4 py-2 rounded-lg shadow">

Download
</a>

</div>
@endif

</div>

{{-- BUTTON --}}
<div class="mt-8 flex justify-end">
<button type="submit"
class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-6 py-3 rounded-lg shadow">
Update Naskah
</button>
</div>

</form>
</div>
</div>

{{-- TOMSELECT --}}
@push('scripts')
<script>
new TomSelect('#tujuan',{
    plugins:['remove_button'],
    create:true,
    persist:false,
    maxOptions:500,
    placeholder:'-- pilih tujuan --'
});
</script>
@endpush


</x-app-layout>
