<x-app-layout>

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="py-6 px-4">

    {{-- VALIDASI --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded-lg shadow">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif


    {{-- FORM --}}
    <div class="bg-white shadow-xl rounded-2xl p-6 mb-6">

        <h2 class="text-lg font-semibold mb-4">
            {{ isset($pegawai) ? 'Edit Data Pegawai' : 'Form Data Pegawai' }}
        </h2>

        <form action="{{ isset($pegawai) ? route('pegawai.update',$pegawai->id) : route('pegawai.store') }}" method="POST">
            @csrf
            @if(isset($pegawai))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-sm">Nama Pegawai</label>
                    <input type="text" name="nama"
                        value="{{ $pegawai->nama ?? old('nama') }}"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                <div>
                    <label class="text-sm">NIP</label>
                    <input type="text" name="nip"
                        value="{{ $pegawai->nip ?? old('nip') }}"
                        class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

            </div>

            <button class="mt-4 bg-gradient-to-r from-indigo-500 to-blue-600 text-white px-6 py-2 rounded-lg shadow">
                {{ isset($pegawai) ? 'Update' : 'Simpan' }}
            </button>

        </form>

    </div>



    {{-- TABEL --}}
    <div class="bg-white shadow-xl rounded-2xl p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Data Pegawai</h2>

            <form method="GET">
                <input type="text" name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari pegawai..."
                       class="border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">
            </form>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full border border-gray-200">

                <thead class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white">
                    <tr>
                        <th class="p-3 border">No</th>
                        <th class="p-3 border">Nama</th>
                        <th class="p-3 border">NIP</th>
                        <th class="p-3 border">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pegawais as $p)
                    <tr class="text-center hover:bg-gray-50">

                        <td class="border p-2">{{ $loop->iteration }}</td>
                        <td class="border p-2">{{ $p->nama }}</td>
                        <td class="border p-2">{{ $p->nip }}</td>

                      <td class="border p-2">
    <div class="flex justify-center items-center gap-2">

        {{-- EDIT --}}
        <a href="{{ route('pegawai.edit',$p->id) }}"
           class="flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white text-sm px-3 py-1.5 rounded-lg shadow">

            {{-- ICON PENCIL --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M11 5h2M12 7v2m-7 9h14M5 19l4-4m0 0l10-10 4 4-10 10m-4-4h4" />
            </svg>

            Edit
        </a>

        {{-- HAPUS --}}
        <button
            data-id="{{ $p->id }}"
            class="btn-hapus flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-lg shadow">

            {{-- ICON TRASH --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                         a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4
                         a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
            </svg>

            Hapus
        </button>

    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            Data belum ada
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                <tfoot class="bg-gray-100 font-semibold">
                    <tr>
                        <td colspan="4" class="p-3 text-right">
                            Total Pegawai :
                            <span id="totalPegawai">{{ $pegawais->count() }}</span>
                        </td>
                    </tr>
                </tfoot>

            </table>

        </div>

    </div>

</div>


{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- AJAX HAPUS --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll('.btn-hapus').forEach(button => {

        button.addEventListener('click', function () {

            let id = this.dataset.id
            let row = this.closest("tr")

            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {

                if (result.isConfirmed) {

                    fetch(`/pegawai/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            "Accept": "application/json"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {

                        if(data.success){

                            row.remove()

                            let total = document.getElementById('totalPegawai')
                            total.innerText = total.innerText - 1

                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus',
                                'success'
                            )

                        }

                    })

                }

            })

        })

    })

})
</script>

</x-app-layout>