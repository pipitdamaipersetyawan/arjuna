<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>

@page {
    margin: 25px 30px;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    color: #000;
}

.kop-table {
    width: 100%;
}

.kop-table td {
    vertical-align: middle;
}

.kop-text {
    text-align: center;
    line-height: 1.3;
}

.kop-text .besar {
    font-size: 14px;
    font-weight: bold;
}

.kop-text .sedang {
    font-size: 12px;
    font-weight: bold;
}

.garis {
    border-bottom: 3px solid #000;
    margin-top: 8px;
    margin-bottom: 15px;
}

.judul {
    text-align: center;
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 3px;
}

.periode {
    text-align: center;
    font-size: 11px;
    margin-bottom: 15px;
}

table.data {
    width: 100%;
    border-collapse: collapse;
}

table.data th {
    background: #f2f2f2;
    font-weight: bold;
    text-align: center;
}

table.data th, table.data td {
    border: 1px solid #000;
    padding: 4px;
}

table.data td {
    vertical-align: top;
}

.total {
    margin-top: 8px;
    font-weight: bold;
}

.footer-area {
    margin-top: 35px;
    width: 100%;
}

.footer-area td {
    vertical-align: top;
}

.qr-box {
    text-align: center;
    font-size: 9px;
}

.page-number {
    position: fixed;
    bottom: 10px;
    right: 20px;
    font-size: 9px;
}

</style>
</head>
<body>

{{-- ================== KOP ================== --}}
<table class="kop-table">
<tr>
<td width="15%">
    <img src="{{ public_path('logo.png') }}" width="75">
</td>
<td class="kop-text">
    <div class="besar">PEMERINTAH KOTA SEMARANG</div>
    <div class="sedang">BAGIAN ADMINISTRASI PEMBANGUNAN</div>
    Gedung Moch Ikhsan Lt 5
</td>
<td width="15%"></td>
</tr>
</table>

<div class="garis"></div>

{{-- ================== JUDUL ================== --}}
<div class="judul">LAPORAN SURAT MASUK</div>

<div class="periode">
Periode:
@if(request('start') && request('end'))
    {{ request('start') }} s/d {{ request('end') }}
@else
    SEMUA DATA
@endif
</div>

{{-- ================== TABEL ================== --}}
<table class="data">
<thead>
<tr>
    <th width="4%">No</th>
    <th width="12%">Tanggal</th>
    <th width="15%">Pengirim</th>
    <th width="15%">No Surat</th>
    <th width="20%">Isi</th>
    <th width="12%">Klasifikasi</th>
</tr>
</thead>
<tbody>
@foreach($data as $i => $row)
<tr>
    <td align="center">{{ $i+1 }}</td>
    <td align="center">
        {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}
    </td>
    <td>{{ $row->surat_dari }}</td>
    <td>{{ $row->nomor_surat }}</td>
    <td>{{ $row->isi_informasi }}</td>
    <td align="center">{{ $row->klasifikasi_kode }}</td>
</tr>
@endforeach
</tbody>
</table>

<div class="total">
Total Data: {{ count($data) }}
</div>

{{-- ================== FOOTER ================== --}}
<table class="footer-area">
<tr>
<td width="65%"></td>
<td width="35%" class="qr-box">
    Semarang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br><br>
    <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="90"><br>
    Scan untuk validasi laporan
</td>
</tr>
</table>

<div class="page-number">
    Halaman {PAGE_NUM} / {PAGE_COUNT}
</div>

</body>
</html>
