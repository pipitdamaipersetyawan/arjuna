<x-app-layout>

<div class="bg-white p-6 rounded-2xl shadow-sm border">

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Riwayat Surat Masuk</h2>

        <a href="{{ route('surat-masuk.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm shadow">
            + Input Surat
        </a>
    </div>

    {{-- FILTER & SEARCH --}}
    <form method="GET" action="{{ route('surat-masuk.riwayat') }}" class="mb-4">

        <div class="grid grid-cols-1 md:grid-cols-6 gap-3">

    <input type="text" name="nomor"
           value="{{ request('nomor') }}"
           placeholder="Cari nomor surat..."
           class="input">

    <input type="text" name="asal_surat"
           value="{{ request('asal_surat') }}"
           placeholder="Cari asal surat..."
           class="input">

    <input type="text" name="informasi"
           value="{{ request('informasi') }}"
           placeholder="Cari informasi surat..."
           class="input">

    <input type="text" name="klasifikasi"
           value="{{ request('klasifikasi') }}"
           placeholder="Cari klasifikasi..."
           class="input">

    {{-- 📄 FILTER TANGGAL SURAT --}}
    <div class="md:col-span-3 flex flex-col">
        <label class="text-xs text-slate-1000">Tanggal Surat</label>
        <div class="flex gap-2">
            <input type="date" name="tgl_awal"
                   value="{{ request('tgl_awal') }}"
                   class="border rounded-lg px-3 py-2 text-sm w-full">

            <input type="date" name="tgl_akhir"
                   value="{{ request('tgl_akhir') }}"
                   class="border rounded-lg px-3 py-2 text-sm w-full">
        </div>
    </div>

    {{-- 📥 FILTER TANGGAL INPUT --}}
    <div class="md:col-span-3 flex flex-col">
        <label class="text-xs text-slate-1000">Tanggal Input</label>
        <div class="flex gap-2">
            <input type="date" name="input_awal"
                   value="{{ request('input_awal') }}"
                   class="border rounded-lg px-3 py-2 text-sm w-full">

            <input type="date" name="input_akhir"
                   value="{{ request('input_akhir') }}"
                   class="border rounded-lg px-3 py-2 text-sm w-full">
        </div>
    </div>

</div>
        <div class="flex flex-wrap justify-between items-center mt-3 gap-3">

            <select name="perPage" onchange="this.form.submit()"
                class="border rounded-lg px-5 py-2 text-sm">

                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>

            </select>

            <button class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm">
                Filter
            </button>

        </div>

    </form>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm border border-slate-300">
            <thead class="bg-slate-100 text-slate-700">
                <tr>
                    <th class="px-3 py-2 border">No</th>
                    <th class="p-3 border whitespace-nowrap">Tanggal Input</th>
                    <th class="p-3 border whitespace-nowrap">Surat Dari</th>
                    <th class="p-3 border whitespace-nowrap">Tanggal Surat</th>
                    <th class="p-3 border whitespace-nowrap">No Surat</th>
                    <th class="p-3 border whitespace-nowrap">Isi Informasi</th>
                    <th class="p-3 border whitespace-nowrap">Klasifikasi</th>
                    <th class="p-3 border whitespace-nowrap">Keterangan</th>
                    <th class="p-3 border whitespace-nowrap">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $row)
                <tr class="hover:bg-slate-50">

                    <td class="border px-3 py-2">
                        {{ $loop->iteration + ($data->firstItem() ?? 0) - 1 }}
                    </td>

                    <td class="border px-3 py-2">
                       {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $row->surat_dari }}
                    </td>

                    <td class="border px-3 py-2">
                       {{ \Carbon\Carbon::parse($row->tanggal_surat)->translatedFormat('d F Y') }}
                    </td>

                    <td class="border px-3 py-2 font-medium text-indigo-600">
                        {{ $row->nomor_surat }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $row->isi_informasi }}
                    </td>

                    <td class="border px-3 py-2">

                            {{ $row->klasifikasi_kode }}

                    </td>

                    <td class="border px-3 py-2">
                        {{ $row->keterangan }}
                    </td>

<td class="border px-3 py-2">
    <div class="flex justify-center gap-2">

        {{-- EDIT --}}
        <a href="{{ route('surat-masuk.edit',$row->id) }}"
           class="inline-flex items-center gap-1 bg-amber-400 hover:bg-amber-500 text-white text-xs font-medium px-3 py-1.5 rounded-lg shadow transition">

            ✏️ Edit
        </a>

        {{-- DELETE --}}
        <form method="POST"
              action="{{ route('surat-masuk.destroy',$row->id) }}"
              onsubmit="return confirm('Hapus data ini?')">

            @csrf
            @method('DELETE')

            <button
                class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium px-3 py-1.5 rounded-lg shadow transition">

                🗑️ Hapus
            </button>

        </form>

    </div>
</td>

                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-6 text-slate-500 border">
                        Data tidak ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- INFO + PAGINATION --}}
    <div class="mt-4 flex justify-between items-center">

        <div class="text-sm text-slate-600">
            Menampilkan
            {{ $data->firstItem() ?? 0 }}
            -
            {{ $data->lastItem() ?? 0 }}
            dari
            {{ $data->total() }} data
        </div>

        {{ $data->links() }}

    </div>

</div>

</x-app-layout>
