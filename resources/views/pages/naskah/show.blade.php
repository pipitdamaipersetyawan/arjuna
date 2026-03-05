<x-app-layout>

<div class="max-w-4xl mx-auto">
    <div class="bg-white p-8 rounded-xl shadow border">

        <h2 class="text-xl font-bold mb-4">
            Detail Naskah
        </h2>

        <p><strong>Tanggal:</strong>
            {{ \Carbon\Carbon::parse($naskah->tanggal_surat)->translatedFormat('j F Y') }}
        </p>

        <p><strong>Nomor:</strong> {{ $naskah->nomor_surat }}</p>

        <p><strong>Perihal:</strong> {{ $naskah->perihal }}</p>

        <p><strong>Tujuan:</strong></p>
        <ul class="list-disc ml-6">
            @foreach($naskah->tujuan as $t)
                <li>{{ $t->nama }}</li>
            @endforeach
        </ul>

    </div>
</div>

</x-app-layout>
