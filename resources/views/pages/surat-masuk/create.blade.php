<x-app-layout>

<div class="w-full">

    <div class="bg-white rounded-2xl shadow-sm border p-6">

        <h2 class="text-lg font-semibold text-slate-700 mb-6">
            {{ isset($data) ? 'Edit Surat Masuk' : 'Input Surat Masuk' }}
        </h2>

       <form method="POST"
      action="{{ isset($data)
            ? route('surat-masuk.update',$data->id)
            : route('surat-masuk.store') }}"
      enctype="multipart/form-data"
      class="space-y-5">

@csrf
@if(isset($data))
    @method('PUT')
@endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- TANGGAL --}}
                <div>
                    <label class="text-sm font-medium">
                        Tanggal <span class="text-red-500">*</span>
                    </label>

                   <input type="date" name="tanggal"
value="{{ old('tanggal', isset($data) ? $data->tanggal?->format('Y-m-d') : date('Y-m-d')) }}"
class="form-input w-full rounded-lg">

                    @error('tanggal')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KLASIFIKASI AGENDA --}}
                <div>
                    <label class="text-sm font-medium">
                        Klasifikasi Agenda <span class="text-red-500">*</span>
                    </label>

                    <select name="klasifikasi_kode"
                            id="klasifikasi"
                            class="form-input w-full rounded-lg">

                        <option value="">-- pilih klasifikasi --</option>

                        @foreach($klasifikasi as $k)
                            <option value="{{ $k->kode }}"
    {{ old('klasifikasi_kode', $data->klasifikasi_kode ?? '') == $k->kode ? 'selected' : '' }}>
    {{ $k->kode }} - {{ $k->nama }}
</option>
                        @endforeach

                    </select>

                    @error('klasifikasi_kode')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- SURAT DARI --}}
                <div>
                    <label class="text-sm font-medium">
                        Surat Dari <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="surat_dari"
                          value="{{ old('surat_dari', $data->surat_dari ?? '') }}"
                           class="form-input w-full rounded-lg">

                    @error('surat_dari')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- TANGGAL SURAT --}}
                <div>
                    <label class="text-sm font-medium">
                        Tanggal Surat <span class="text-red-500">*</span>
                    </label>

                    <input type="date" name="tanggal_surat"
value="{{ old('tanggal_surat', isset($data) ? $data->tanggal_surat?->format('Y-m-d') : '') }}"
class="form-input w-full rounded-lg">

                    @error('tanggal_surat')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- NO SURAT --}}
                <div class="col-span-2">
                    <label class="text-sm font-medium">
                        No. Surat <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="nomor_surat"
                          value="{{ old('nomor_surat', $data->nomor_surat ?? '') }}"
                           class="form-input w-full rounded-lg">

                    @error('nomor_surat')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- ISI INFORMASI --}}
                <div class="col-span-2">
                    <label class="text-sm font-medium">
                        Isi Informasi <span class="text-red-500">*</span>
                    </label>

                    <textarea name="isi_informasi"
                              rows="4"
                              class="form-input w-full rounded-lg">{{ old('isi_informasi', $data->isi_informasi ?? '') }}</textarea>

                    @error('isi_informasi')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- KETERANGAN --}}
                <div class="col-span-2">
                    <label class="text-sm font-medium">
                        Keterangan
                    </label>

                    <textarea name="keterangan"
          rows="3"
          class="form-input w-full rounded-lg">{{ old('keterangan', $data->keterangan ?? '') }}</textarea>
                </div>

                {{-- FILE --}}
                <div class="col-span-2">
                    <label class="text-sm font-medium">
                        Upload File (PDF, DOCX, XLSX, PPTX max 2MB)
                    </label>

                    <input type="file"
                           name="file_surat"
                           class="w-full border rounded-lg px-3 py-2 text-sm">
@if(isset($data) && $data->file)
    <a href="{{ asset('storage/'.$data->file) }}" target="_blank">
        Lihat file
    </a>
@endif
                    @error('file_surat')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="flex justify-end pt-3">
                <button type="submit"
class="bg-indigo-600 text-white px-6 py-2 rounded-lg">
{{ isset($data) ? 'Update' : 'Simpan Surat' }}
</button>
            </div>

        </form>

    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    new TomSelect("#klasifikasi",{
        create:false,
        sortField:{ field:"text", direction:"asc" },
        placeholder:"Ketik kode / nama klasifikasi..."
    });

});
</script>
@endpush

</x-app-layout>
