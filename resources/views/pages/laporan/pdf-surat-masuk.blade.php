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

.page-number {
    position: fixed;
    bottom: 10px;
    right: 20px;
    font-size: 9px;
}

</style>
</head>

<body>

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

<div class="judul">LAPORAN SURAT MASUK</div>

<div class="periode">
Periode:
@if(request('start') && request('end'))
{{ request('start') }} s/d {{ request('end') }}
@else
SEMUA DATA
@endif
</div>

<table class="data">
<thead>
<tr>
<th width="4%">No</th>
<th width="12%">Tanggal Input</th>
<th width="15%">Pengirim</th>
<th width="15%">No Surat</th>
<th width="20%">Isi Informasi</th>
<th width="12%">Klasifikasi</th>
<th width="12%">Keterangan</th>
</tr>
</thead>

<tbody>

@foreach($rows as $row)

<tr>
<td align="center">{{ $row[0] }}</td>
<td align="center">{{ $row[1] }}</td>
<td>{{ $row[2] }}</td>
<td>{{ $row[4] }}</td>
<td>{{ $row[5] }}</td>
<td align="center">{{ $row[6] }}</td>
<td>{{ $row[7] }}</td>
</tr>

@endforeach

</tbody>
</table>

<div class="total">
Total Data: {{ count($rows) }}
</div>

<table class="footer-area">
<tr>
<td width="65%"></td>
<td width="35%" style="text-align:center">
Semarang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
</td>
</tr>
</table>

<div class="page-number">
Halaman {PAGE_NUM} / {PAGE_COUNT}
</div>

</body>
</html>
