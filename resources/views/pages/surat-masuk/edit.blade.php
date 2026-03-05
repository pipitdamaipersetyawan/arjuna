<x-app-layout>

<div class="bg-white p-6 rounded-2xl shadow-sm border">

    <h2 class="text-lg font-semibold mb-6">Edit Surat Masuk</h2>

    <form action="{{ route('surat-masuk.update',$data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- TANGGAL INPUT --}}
            <div>
                <label class="text-sm">Tanggal Input</label>
                <input type="date" name="tanggal"
                       value="{{ old('tanggal', $data->tanggal) }}"
                       class="input">
            </div>

            {{-- TANGGAL SURAT --}}
            <div>
                <label class="text-sm">Tanggal Surat</label>
                <input type="date" name="tanggal_surat"
                       value="{{ old('tanggal_surat', $data->tanggal_surat) }}"
                       class="input">
            </div>

            {{-- NOMOR SURAT --}}
            <div>
                <label class="text-sm">Nomor Surat</label>
                <input type="text" name="nomor_surat"
                       value="{{ old('nomor_surat', $data->nomor_surat) }}"
                       class="input">
            </div>

            {{-- SURAT DARI --}}
            <div>
                <label class="text-sm">Surat Dari</label>
                <input type="text" name="surat_dari"
                       value="{{ old('surat_dari', $data->surat_dari) }}"
                       class="input">
            </div>

            {{-- ISI INFORMASI --}}
            <div class="md:col-span-2">
                <label class="text-sm">Isi Informasi</label>
                <textarea name="isi_informasi" rows="3"
                          class="input">{{ old('isi_informasi', $data->isi_informasi) }}</textarea>
            </div>

            {{-- KLASIFIKASI --}}
            <div>
                <label class="text-sm">Klasifikasi</label>
                <select name="klasifikasi_kode" class="input">
                    <option value="">-- pilih --</option>

                    @foreach($klasifikasi as $k)
                        <option value="{{ $k->kode }}"
                        {{ old('klasifikasi_kode', $data->klasifikasi_kode) == $k->kode ? 'selected' : '' }}>
                            {{ $k->kode }} - {{ $k->nama }}
                        </option>
                    @endforeach

                </select>
            </div>

            {{-- KETERANGAN --}}
            <div>
                <label class="text-sm">Keterangan</label>
                <input type="text" name="keterangan"
                       value="{{ old('keterangan', $data->keterangan) }}"
                       class="input">
            </div>

        </div>

        {{-- BUTTON --}}
        <div class="mt-6 flex justify-end gap-3">

            <a href="{{ route('surat-masuk.riwayat') }}"
               class="px-4 py-2 rounded-lg bg-slate-200 text-sm">
               Batal
            </a>

            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg text-sm shadow">
                Update
            </button>

        </div>

    </form>

</div>

</x-app-layout>
