<x-app-layout>

<div id="area-print" class="w-full px-12 py-8 space-y-6">

    <!-- JUDUL -->
    <div class="text-center space-y-2">
        <h1 class="text-2xl font-bold tracking-wide">
            LAPORAN SURAT MASUK
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

    <!-- ACTION BUTTON -->
    <div class="flex justify-start gap-3 mt-4 print-hidden">

        <button onclick="window.print()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">
            Cetak
        </button>

        <a href="{{ route('laporan.surat-masuk.pdf', request()->query()) }}"
            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow transition">
            Export PDF
        </a>

        <a href="{{ route('laporan.surat-masuk.excel', request()->query()) }}"
            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow transition">
            Export Excel
        </a>

    </div>

    <!-- FILTER -->
    <div class="bg-white shadow rounded-xl p-6 border print-hidden">
        <form method="GET" action="{{ route('laporan.surat-masuk') }}"
              class="grid md:grid-cols-5 gap-4 items-end">

            <div>
                <label class="text-sm text-gray-600">Dari Tanggal</label>
                <input type="date" name="start"
                    value="{{ request('start') }}"
                    class="w-full border rounded-lg px-4 py-2">
            </div>

            <div>
                <label class="text-sm text-gray-600">Sampai Tanggal</label>
                <input type="date" name="end"
                    value="{{ request('end') }}"
                    class="w-full border rounded-lg px-4 py-2">
            </div>

            <div class="md:col-span-2">
                <label class="text-sm text-gray-600">Pencarian</label>
                <input type="text" name="search"
                    value="{{ request('search') }}"
                    placeholder="Nomor Surat / Pengirim / Isi"
                    class="w-full border rounded-lg px-4 py-2">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2">
                    Filter
                </button>

                <a href="{{ route('laporan.surat-masuk') }}"
                    class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg px-4 py-2 text-center">
                    Reset
                </a>
            </div>

        </form>
    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-xl border overflow-hidden">
        <div class="bg-white shadow rounded-xl border overflow-hidden">

<div class="overflow-x-auto print:overflow-visible">
            <table class="w-full text-sm text-gray-700 border-collapse">

                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="border px-6 py-3 text-left font-semibold">No</th>
                        <th class="border px-6 py-3 text-left font-semibold">Tanggal Surat</th>
                        <th class="border px-6 py-3 text-left font-semibold">Pengirim</th>
                        <th class="border px-6 py-3 text-left font-semibold">Nomor Surat</th>
                        <th class="border px-6 py-3 text-left font-semibold">Isi Informasi</th>
                        <th class="border px-6 py-3 text-left font-semibold">Klasifikasi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $index => $item)
                    <tr>
                        <td class="border px-6 py-3">
                            {{ $data->firstItem() + $index }}
                        </td>
                        <td class="border px-6 py-3">
                            {{ \Carbon\Carbon::parse($item->tanggal_surat)->format('d M Y') }}
                        </td>
                        <td class="border px-6 py-3">
                            {{ $item->surat_dari }}
                        </td>
                        <td class="border px-6 py-3">
                            {{ $item->nomor_surat }}
                        </td>
                        <td class="border px-6 py-3">
                            {{ $item->isi_informasi }}
                        </td>
                        <td class="border px-6 py-3">
                            {{ $item->klasifikasi_kode }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="border text-center py-10 text-gray-500">
                            Tidak ada data ditemukan
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="flex justify-between items-center px-6 py-4 bg-gray-50 text-sm">
            <div>
                Total Data:
                <strong>{{ $data->total() }}</strong>
            </div>

            <div class="print-hidden">
                {{ $data->withQueryString()->links() }}
            </div>
        </div>
    </div>

</div>

{{-- PRINT CSS --}}
<style>
@media print {

    body * {
        visibility: hidden;
    }

    #area-print, #area-print * {
        visibility: visible;
    }

    #area-print {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    /* sembunyikan tombol dan pagination */
    .print-hidden {
        display: none !important;
    }

    /* hilangkan card */
    .bg-white {
        box-shadow: none !important;
        border: none !important;
    }

    /* tabel print */
    table {
        width: 100%;
        border-collapse: collapse !important;
        font-size: 12px;
    }

    th, td {
        border: 1px solid black !important;
        padding: 6px !important;
    }

    th {
        background: #f0f0f0 !important;
        font-weight: bold;
    }

    h1 {
        font-size: 20px;
        margin-bottom: 20px;
    }

}
</style>

</x-app-layout>
