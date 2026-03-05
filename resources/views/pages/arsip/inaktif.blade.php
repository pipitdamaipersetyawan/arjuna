<x-app-layout>

<div class="bg-white p-6 rounded-2xl shadow-sm border">

    <h2 class="text-lg font-semibold mb-4">Arsip Inaktif</h2>

    {{-- FILTER --}}
    <form method="GET" class="mb-4 flex flex-wrap gap-3">

        <input type="text" name="cari"
               value="{{ request('cari') }}"
               placeholder="Cari nomor surat..."
               class="border rounded-lg px-3 py-2 text-sm">

        <input type="date" name="tgl_awal"
               value="{{ request('tgl_awal') }}"
               class="border rounded-lg px-3 py-2 text-sm">

        <input type="date" name="tgl_akhir"
               value="{{ request('tgl_akhir') }}"
               class="border rounded-lg px-3 py-2 text-sm">

        <select name="perPage" onchange="this.form.submit()"
                class="border rounded-lg px-5 py-2 text-sm">

            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>

        </select>

        <button class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm">
            Filter
        </button>

    </form>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm border">

            <thead class="bg-slate-100">
                <tr>
                    <th class="border p-2">No</th>
                    <th class="border p-2">Jenis</th>
                    <th class="border p-2">Tanggal Input</th>
                    <th class="border p-2">Tanggal Surat</th>
                    <th class="border p-2">Nomor</th>
                    <th class="border p-2">Pengirim</th>
                    <th class="border p-2">Isi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($data as $row)
                <tr>

                    <td class="border p-2">
                        {{ $loop->iteration + ($data->firstItem() ?? 0) - 1 }}
                    </td>

                    {{-- BADGE SUMBER --}}
                    <td class="border p-2">
                        @if($row->jenis == 'Surat Masuk')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                                Surat Masuk
                            </span>
                        @else
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                Naskah Keluar
                            </span>
                        @endif
                    </td>

                    <td class="border p-2">
                        {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}
                    </td>

                    <td class="border p-2">
                        {{ \Carbon\Carbon::parse($row->tanggal_surat)->translatedFormat('d F Y') }}
                    </td>

                    <td class="border p-2 text-indigo-600 font-medium">
                        {{ $row->nomor_surat }}
                    </td>

                    <td class="border p-2">
                        {{ $row->pengirim }}
                    </td>

                    <td class="border p-2">
                        {{ $row->isi }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        Data tidak ada
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="flex justify-between mt-4">

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
