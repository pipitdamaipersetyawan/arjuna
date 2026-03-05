<x-app-layout>

<div class="py-6">

    <h1 class="text-2xl font-bold text-slate-700 mb-6">
        Dashboard
    </h1>

    {{-- ================= MENU CARD ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-4 3xl:grid-cols-4 gap-6">

        {{-- SURAT MASUK --}}
        <div onclick="loadChart('masuk', this)" class="menu-card bg-gradient-to-br from-green-400 to-green-500">
            <div class="menu-top">
                <i class="ph ph-tray"></i>
                <span>•••</span>
            </div>
            <div class="menu-title">Surat Masuk</div>
            <div class="menu-sub">{{ $naskahMasuk }} Data</div>
        </div>

        {{-- NASKAH KELUAR --}}
        <div onclick="loadChart('keluar', this)" class="menu-card bg-gradient-to-br from-teal-400 to-teal-500">
            <div class="menu-top">
                <i class="ph ph-paper-plane-tilt"></i>
                <span>•••</span>
            </div>
            <div class="menu-title">Naskah Keluar</div>
            <div class="menu-sub">{{ $naskahKeluar }} Data</div>
        </div>

        {{-- ARSIP INAKTIF --}}
        <div onclick="loadChart('arsip', this)" class="menu-card bg-gradient-to-br from-rose-400 to-rose-500">
            <div class="menu-top">
                <i class="ph ph-archive-box"></i>
                <span>•••</span>
            </div>
            <div class="menu-title">Arsip Inaktif</div>
            <div class="menu-sub">{{ $arsipAktif }} Data</div>
        </div>

        {{-- PEGAWAI --}}
        <div onclick="loadChart('pegawai', this)" class="menu-card bg-gradient-to-br from-slate-500 to-slate-600">
            <div class="menu-top">
                <i class="ph ph-users"></i>
                <span>•••</span>
            </div>
            <div class="menu-title">Pegawai</div>
            <div class="menu-sub">{{ $pegawai }} Orang</div>
        </div>

        {{-- KLASIFIKASI INDUK --}}
        <div onclick="loadChart('klasifikasi_induk', this)" class="menu-card bg-gradient-to-br from-indigo-400 to-indigo-500">
            <div class="menu-top">
                <i class="ph ph-squares-four"></i>
                <span>•••</span>
            </div>
            <div class="menu-title">Klasifikasi Induk</div>
            <div class="menu-sub">{{ $klasifikasiInduk }} Data</div>
        </div>

        {{-- SUB KLASIFIKASI --}}
        <div onclick="loadChart('klasifikasi_sub', this)" class="menu-card bg-gradient-to-br from-purple-400 to-purple-500">
            <div class="menu-top">
                <i class="ph ph-git-branch"></i>
                <span>•••</span>
            </div>
            <div class="menu-title">Sub Klasifikasi</div>
            <div class="menu-sub">{{ $klasifikasiSub }} Data</div>
        </div>

    </div>

    {{-- ================= GRAFIK ================= --}}
    <div class="bg-white p-6 rounded-2xl shadow mt-8">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">

            <h2 class="font-semibold text-slate-700">
                Statistik <span id="judulChart" class="text-indigo-500 ml-2"></span>
            </h2>

            <div class="flex gap-2">
                <button onclick="setChartType('bar')" class="chart-btn">Bar</button>
                <button onclick="setChartType('line')" class="chart-btn">Line</button>
                <button onclick="setChartType('pie')" class="chart-btn">Pie</button>
                <button onclick="setChartType('doughnut')" class="chart-btn">Doughnut</button>
            </div>

        </div>

        <div class="relative w-full h-[300px] md:h-[380px]">
            <canvas id="chartNaskah"></canvas>
        </div>

    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
let chart;
let currentJenis = 'masuk';
let currentType  = 'bar';

async function loadChart(jenis = 'masuk', el = null) {

    currentJenis = jenis;

    document.querySelectorAll('.menu-card')
        .forEach(c => c.classList.remove('card-active'));

    if (el) el.classList.add('card-active');

    const response = await fetch(`/statistik/${jenis}`);
    const data = await response.json();

    document.getElementById('judulChart').innerText = data.judul;

    renderChart(data.label, data.jumlah);
}

function renderChart(label, jumlah) {

    if (chart) chart.destroy();

    const ctx = document.getElementById('chartNaskah');

    chart = new Chart(ctx, {
        type: currentType, // 🔥 SEMUA IKUT INI
        data: {
            labels: label,
            datasets: [{
                data: jumlah,
                backgroundColor: [
                    '#6366f1','#22c55e','#f59e0b',
                    '#ef4444','#0ea5e9','#a855f7'
                ],
                borderRadius: currentType === 'bar' ? 12 : 0,
                tension: 0.4,
                fill: currentType === 'line'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: currentType !== 'bar'
                }
            },
            scales: currentType === 'bar' || currentType === 'line'
                ? { y: { beginAtZero: true } }
                : {}
        }
    });
}

function setChartType(type){

    currentType = type;

    renderChart(
        chart.data.labels,
        chart.data.datasets[0].data
    );

}

document.addEventListener("DOMContentLoaded", () => {
    loadChart('masuk');
});
</script>


{{-- STYLE IOS --}}
<style>

.menu-card{
    border-radius:30px;
    padding:18px;
    color:white;
    cursor:pointer;
    height:130px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    box-shadow:
        0 10px 25px rgba(0,0,0,0.15),
        inset 0 1px 1px rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}

.menu-card:hover{
    transform: translateY(-6px) scale(1.03);
}

.card-active{
    transform: scale(1.06);
    outline: 3px solid white;
}

.menu-top i{
    font-size:28px;
    opacity:0.9;
}

.chart-btn{
    padding:6px 12px;
    font-size:12px;
    border-radius:10px;
    background:#f1f5f9;
    transition:0.2s;
}

.chart-btn:hover{
    background:#6366f1;
    color:white;
}

</style>

<script src="https://unpkg.com/@phosphor-icons/web"></script>

</x-app-layout>
