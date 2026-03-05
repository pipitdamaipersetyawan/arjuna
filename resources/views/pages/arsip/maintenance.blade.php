<x-app-layout>

<div class="min-h-[70vh] flex flex-col items-center justify-center text-center">

    <img src="{{ asset('img/maintenance.svg') }}"
         class="w-64 mb-6 animate-bounce">

    <h1 class="text-2xl font-bold text-slate-700 mb-2">
        Sistem Sedang Dalam Pemeliharaan
    </h1>

    <p class="text-slate-500 max-w-md mb-6">
        Saat ini kami sedang melakukan peningkatan layanan
        untuk kenyamanan Anda.
        <br>Silakan kembali beberapa saat lagi.
    </p>

    <div class="w-10 h-10 border-4 border-indigo-500
                border-t-transparent rounded-full animate-spin">
    </div>

</div>

</x-app-layout>
