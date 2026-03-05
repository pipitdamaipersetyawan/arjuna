<aside class="w-72 h-screen flex flex-col
bg-gradient-to-b from-slate-800 via-slate-900 to-slate-950
text-slate-200 shadow-xl">


    {{-- LOGO --}}
    <div class="px-6 pt-6 pb-5 text-center border-b border-slate-700/60">

        <div class="flex items-center justify-center gap-3 mb-3">

            <img src="{{ asset('img/logo-arjuna.png') }}"
                 class="w-10 drop-shadow-xl">

            <div class="text-left leading-tight">
                <div class="text-slate-100 font-semibold tracking-wide">
                    ARJUNA
                </div>
                <div class="text-xs text-slate-400">
                    E-Arsip & Persuratan
                </div>
            </div>

        </div>

    </div>


    {{-- MENU --}}
    <nav class="flex-1 px-3 py-4 space-y-1 text-sm font-medium overflow-y-auto
backdrop-blur-sm">

        <x-sidebar.link icon="layout-dashboard" route="dashboard" title="Dashboard"/>

        <x-sidebar.dropdown icon="mail" title="Surat Masuk" :active="request()->routeIs('surat-masuk.*','disposisi.*')">
            <x-sidebar.sublink icon="file-plus" route="surat-masuk.index" title="Input Surat"/>
            {{-- <x-sidebar.sublink icon="share-2" route="disposisi.index" title="Disposisi"/> --}}
            <x-sidebar.sublink icon="history" route="surat-masuk.riwayat" title="Riwayat Surat"/>
        </x-sidebar.dropdown>

        <x-sidebar.dropdown icon="send" title="Surat Keluar">
            <x-sidebar.sublink icon="edit" route="naskah.create" title="Buat Naskah"/>
            <x-sidebar.sublink icon="history" route="naskah.index" title="Riwayat Naskah"/>
        </x-sidebar.dropdown>

        <x-sidebar.dropdown icon="archive"  title="Arsip" :active="request()->routeIs('arsip.*')">
           <x-sidebar.sublink icon="folder" route="arsip.aktif" title="Arsip Aktif"/>
           <x-sidebar.sublink icon="database" route="arsip.inaktif" title="Arsip Inaktif"/>
           <x-sidebar.sublink icon="clock" route="retensi.index" title="Retensi Arsip"/>

        </x-sidebar.dropdown>

        <x-sidebar.dropdown icon="bar-chart-3" title="Laporan">
            <x-sidebar.sublink icon="file-text" route="laporan.surat-masuk" title="Surat Masuk"/>
            <x-sidebar.sublink icon="file-text" route="laporan.naskah-keluar" title="Naskah Keluar"/>
            <x-sidebar.sublink icon="file-archive" route="laporan.arsip" title="Arsip"/>
        </x-sidebar.dropdown>

        <x-sidebar.dropdown icon="settings" title="Pengaturan">
            <x-sidebar.sublink icon="layers" route="klasifikasi.index" title="Klasifikasi Arsip"/>
            <x-sidebar.sublink icon="users" route="pegawai.index" title="Data Pegawai"/>
        </x-sidebar.dropdown>

    </nav>


    {{-- USER --}}
    <div class="p-4 border-t border-slate-800">

        <div class="flex items-center gap-3 bg-slate-700/40 backdrop-blur-md
                    rounded-2xl p-3">

            <div class="w-10 h-10 rounded-xl
                        bg-gradient-to-br from-indigo-500 to-indigo-700
                        flex items-center justify-center
                        text-white font-bold shadow">

                {{ strtoupper(substr(auth()->user()->name,0,1)) }}

            </div>

            <div class="text-xs leading-tight">
                <div class="text-white font-semibold">
                    {{ auth()->user()->name }}
                </div>

                <div class="text-slate-400 truncate max-w-[130px]">
                    {{ auth()->user()->email }}
                </div>
            </div>

        </div>

    </div>

</aside>
