<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ARJUNA</title>

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- TOMSELECT CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-slate-100 antialiased" style="font-family: 'Inter', sans-serif; font-size:14.5px;">

<div class="flex min-h-screen overflow-x-hidden">

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- ================= TOPBAR ================= --}}
        <div class="flex justify-between items-center px-6 py-3 bg-white border-b">

            {{-- BREADCRUMB --}}
            <div class="flex flex-col">
                @isset($breadcrumbs)
                    <div class="flex items-center text-xs text-slate-500">
                        <span class="text-slate-400">Dashboard</span>

                        @foreach ($breadcrumbs as $item)
                            <svg class="w-3 h-3 mx-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5l7 7-7 7"/>
                            </svg>

                            <span class="text-slate-700 font-medium">
                                {{ $item }}
                            </span>
                        @endforeach
                    </div>
                @endisset
            </div>

            {{-- JAM --}}
            <div class="hidden lg:flex flex-col items-center text-center leading-tight">
                <div id="clock" class="text-sm font-semibold text-slate-1000"></div>
                <div id="tanggal" class="text-xs text-slate-500"></div>
            </div>

            {{-- USER DROPDOWN --}}
            <div x-data="{ open:false }" class="relative">

                <div @click="open = !open"
                     class="cursor-pointer flex items-center gap-3
                            bg-slate-100 hover:bg-slate-200
                            px-4 py-2 rounded-full transition">

                    <div class="w-10 h-10 rounded-full
                                bg-gradient-to-br from-indigo-500 to-blue-600
                                text-white flex items-center justify-center shadow">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </div>

                    <div class="text-right hidden sm:block leading-tight">
                        <div class="text-sm font-semibold text-slate-700">
                            {{ Auth::user()->name }}
                        </div>
                        <div class="text-xs text-slate-500">
                            {{ Auth::user()->jabatan ?? 'Tata Usaha / Sekretaris' }}
                        </div>
                    </div>

                </div>

                <div x-show="open"
                     @click.outside="open=false"
                     x-transition
                     class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg py-2 z-50">

                    <a href="{{ route('profile.show') }}"
                       class="block px-4 py-2 text-sm hover:bg-slate-100">
                        Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-slate-100">
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

        {{-- RUNNING TEXT --}}
        <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white text-xs py-4 px-6 overflow-hidden">
            <div class="animate-marquee whitespace-nowrap">
                📢 Selamat datang di ARJUNA — Sistem Informasi E-Arsip & Persuratan Digital |
                Gunakan klasifikasi arsip dengan benar |
                Pastikan data naskah terinput dengan lengkap
            </div>
        </div>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 overflow-y-auto p-8">
            {{ $slot }}
        </main>

    </div>

</div>

{{-- TOMSELECT JS --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

{{-- GLOBAL SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    function updateClock() {
        const now = new Date()

        document.getElementById('clock').innerHTML =
            now.toLocaleTimeString('id-ID')

        document.getElementById('tanggal').innerHTML =
            now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            })
    }

    setInterval(updateClock, 1000)
    updateClock()

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos){

            let lat = pos.coords.latitude
            let lon = pos.coords.longitude

            fetch(`https://api.aladhan.com/v1/timings?latitude=${lat}&longitude=${lon}&method=20`)
            .then(res => res.json())
            .then(data => {
                let t = data.data.timings

                document.getElementById('jadwalSholat').innerHTML =
                    `Subuh ${t.Fajr} | Dzuhur ${t.Dhuhr} | Ashar ${t.Asr} | Maghrib ${t.Maghrib} | Isya ${t.Isha}`
            })

        })
    }

});
</script>

{{-- STACK SCRIPT UNTUK HALAMAN --}}
@stack('scripts')

@livewireScripts

</body>
</html>
