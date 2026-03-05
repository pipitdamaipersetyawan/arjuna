<x-app-layout>

<div class="w-full">
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

{{-- HEADER --}}
<div class="mb-8">
    <h2 class="text-xl font-semibold text-slate-700">Buat Naskah</h2>
    <p class="text-sm text-slate-500">Lengkapi data naskah dengan benar</p>
</div>

<form action="{{ route('naskah.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

{{-- TANGGAL --}}
<div>
<label class="text-sm font-medium">Tanggal Surat <span class="text-red-500">*</span></label>

<input type="date" name="tanggal_surat"
value="{{ old('tanggal_surat', date('Y-m-d')) }}"
class="w-full rounded-lg border-slate-300 text-sm">

@error('tanggal_surat')
<div class="text-red-500 text-xs mt-1">{{ $message }}</div>
@enderror
</div>

{{-- NOMOR --}}
<div>
<label class="text-sm font-medium">Nomor Naskah <span class="text-red-500">*</span></label>

<input type="text" name="nomor_naskah"
value="{{ old('nomor_naskah') }}"
placeholder="Masukkan nomor manual"
class="w-full rounded-lg border-slate-300 text-sm">

@error('nomor_naskah')
<div class="mt-2 text-sm text-rose-500 bg-rose-50 border border-rose-200 px-3 py-2 rounded-lg">
    {{ $message }}
</div>
@enderror
</div>

{{-- PENGIRIM --}}
<div>
<label class="text-sm font-medium">Pengirim</label>
<input type="text"
value="Bagian Administrasi Pembangunan"
readonly
class="w-full rounded-lg bg-slate-100 border-slate-200 text-sm">
</div>

{{-- TUJUAN --}}
<div class="md:col-span-2">

    <label class="text-sm font-medium">
        Tujuan <span class="text-red-500">*</span>
    </label>

    {{-- INPUT MANUAL --}}
    <div class="flex gap-2 mb-2">
        <input type="text" id="manualTujuan"
               class="w-full border rounded-lg px-3 py-2 text-sm"
               placeholder="Tambah tujuan manual lalu tekan Enter">
    </div>

    {{-- DROPDOWN --}}
    <select id="tujuanSelect"
            class="w-full border rounded-lg px-3 py-2 text-sm">
        <option value="">-- pilih tujuan --</option>

       @foreach($listTujuan as $group => $items)
    <optgroup label="{{ $group }}">
        @foreach($items as $t)
            <option value="{{ $t->id }}">{{ $t->nama }}</option>
        @endforeach
    </optgroup>
@endforeach

    </select>

    {{-- HASIL TUJUAN TERPILIH --}}
    <div id="tujuanResult"
         class="mt-3 flex flex-wrap gap-2">
    </div>

    {{-- INPUT HIDDEN UNTUK KIRIM KE CONTROLLER --}}
    <div id="tujuanHidden"></div>

</div>

{{-- JENIS --}}
<div>
<label class="text-sm font-medium">Jenis Naskah <span class="text-red-500">*</span></label>

<select name="jenis_naskah" class="w-full border rounded-lg px-3 py-2 text-sm">
<option value="">-- pilih jenis --</option>

@foreach([
'INSTRUKSI','SURAT DINAS','SURAT EDARAN','SURAT BIASA','SURAT KETERANGAN',
'SURAT PERINTAH','SURAT IZIN','SURAT PERJANJIAN',
'SURAT PERINTAH TUGAS','SURAT PERINTAH PERJALANAN DINAS',
'SURAT KUASA','SURAT UNDANGAN',
'SURAT KETERANGAN MELAKSANAKAN TUGAS','SURAT PANGGILAN',
'NOTA DINAS','NOTA PENGAJUAN KONSEP NASKAH DINAS',
'LEMBAR DISPOSISI','TELAAHAN STAF','PENGUMUMAN','LAPORAN',
'REKOMENDASI','SURAT PENGANTAR','TELEGRAM','BERITA ACARA',
'NOTULEN','MEMO','DAFTAR HADIR','PIAGAM','SERTIFIKAT','STTPP'
] as $j)

<option value="{{ $j }}">{{ $j }}</option>

@endforeach


</select>
</div>

{{-- SIFAT --}}
<div>
<label class="text-sm font-medium">Sifat Naskah <span class="text-red-500">*</span></label>

<select name="sifat_naskah" class="w-full border rounded-lg px-3 py-2 text-sm">
<option value="">-- pilih --</option>
<option value="B">Biasa</option>
<option value="SR">Sangat Rahasia</option>
<option value="R">Rahasia</option>
<option value="T">Terbatas</option>
</select>
</div>

{{-- KLASIFIKASI --}}
<div>
<label class="text-sm font-medium">Klasifikasi <span class="text-red-500">*</span></label>

<select id="klasifikasi" name="klasifikasi_kode"
class="w-full border rounded-lg px-3 py-2 text-sm">

<option value="">-- pilih klasifikasi --</option>

@foreach ($klasifikasi as $k)
<option value="{{ $k->kode }}">
{{ $k->kode }} — {{ $k->nama }}
</option>
@endforeach

</select>
</div>

{{-- HAL --}}
<div class="md:col-span-2">
<label class="text-sm font-medium">Hal <span class="text-red-500">*</span></label>

<input type="text" name="hal"
value="{{ old('hal') }}"
class="w-full border rounded-lg px-3 py-2 text-sm">
</div>

</div>

{{-- RINGKASAN --}}
<div class="mt-6">
<label class="text-sm font-medium">Isi Ringkasan <span class="text-red-500">*</span></label>

<textarea name="ringkasan" rows="4"
class="w-full border rounded-lg px-3 py-2 text-sm">{{ old('ringkasan') }}</textarea>
</div>

{{-- FILE --}}
<div class="mt-6">
<label class="text-sm font-medium">
Upload File Naskah Format File : PDF, DOCX, XLSX, PPTX
<span class="text-slate-400 text-xs">(Maks: 2MB)</span>
</label>

<input type="file" name="file_naskah"
class="w-full border rounded-lg px-3 py-2 text-sm">
</div>

{{-- BUTTON --}}
<div class="mt-8 flex justify-end">
<button type="submit"
class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-6 py-3 rounded-lg shadow-sm">
Simpan Naskah
</button>
</div>

</form>
</div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ✅ TOMSELECT KLASIFIKASI (PUNYA KAMU - TIDAK DIUBAH)
    new TomSelect("#klasifikasi",{
        create:false,
        sortField:{ field:"text", direction:"asc" },
        placeholder:"Ketik kode / nama klasifikasi..."
    });


    // =====================================================
    // ✅ MULTI TUJUAN CUSTOM
    // =====================================================

    const select   = document.getElementById('tujuanSelect');
    const result   = document.getElementById('tujuanResult');
    const hidden   = document.getElementById('tujuanHidden');
    const manual   = document.getElementById('manualTujuan');

    function addTujuan(id, text)
    {
        if (document.getElementById('item-'+id)) return;

        // badge
        let badge = document.createElement('div');
        badge.id  = 'item-'+id;
        badge.className =
        "bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm flex items-center gap-2";

        badge.innerHTML = text +
        `<span class="cursor-pointer text-red-500 font-bold">&times;</span>`;

        // hidden input
        let input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'tujuan[]';
        input.value = id;
        input.id    = 'input-'+id;

        hidden.appendChild(input);
        result.appendChild(badge);

        // tombol hapus
        badge.querySelector('span').onclick = function () {
            badge.remove();
            input.remove();

            let option = new Option(text, id);
            select.add(option);
        }
    }

    // pilih dari dropdown
    if(select){
        select.addEventListener('change', function () {

            let id   = this.value;
            let text = this.options[this.selectedIndex].text;

            if (id) {
                addTujuan(id, text);
                this.querySelector(`option[value="${id}"]`).remove();
            }

            this.value = "";
        });
    }

    // input manual
    if(manual){
        manual.addEventListener('keypress', function (e) {

            if (e.key === 'Enter') {
                e.preventDefault();

                let text = this.value.trim();
                if (!text) return;

                let id = 'manual_' + Date.now();

                addTujuan(text, text);
                this.value = "";
            }

        });
    }

});
</script>
@endpush


</x-app-layout>
