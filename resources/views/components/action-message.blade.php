<aside class="w-72 bg-slate-900 text-slate-200 min-h-screen">

    <div class="p-5 text-center border-b border-slate-700">
        <img src="{{ asset('logo/arjuna.png') }}" class="w-14 mx-auto mb-2">
        <h1 class="font-bold text-lg text-white">ARJUNA</h1>
    </div>

    <nav class="p-4 space-y-2 text-sm">

        <x-sidebar.link icon="home" route="dashboard" title="Beranda" />

        <x-sidebar.dropdown title="Naskah Masuk" icon="inbox">
            <x-sidebar.sublink route="#" title="Registrasi" />
            <x-sidebar.sublink route="#" title="Agenda" />
            <x-sidebar.sublink route="#" title="Disposisi" />
            <x-sidebar.sublink route="#" title="Log" />
        </x-sidebar.dropdown>

        <x-sidebar.dropdown title="Naskah Keluar" icon="send">
            <x-sidebar.sublink route="#" title="Registrasi" />
            <x-sidebar.sublink route="#" title="Daftar" />
            <x-sidebar.sublink route="#" title="Pemberkasan" />
            <x-sidebar.sublink route="#" title="Log" />
            <x-sidebar.sublink route="#" title="TTE" />
        </x-sidebar.dropdown>

    </nav>

</aside>