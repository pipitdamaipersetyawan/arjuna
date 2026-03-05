<x-app-layout>

<div class="p-6">

    <h1 class="text-xl font-bold mb-4">
        Menu Surat Keluar
    </h1>

    <div class="flex gap-4">

        <a href="{{ route('naskah.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
            Buat Naskah
        </a>

        <a href="{{ route('naskah.index') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg shadow">
            Riwayat Naskah
        </a>

    </div>

</div>

</x-app-layout>