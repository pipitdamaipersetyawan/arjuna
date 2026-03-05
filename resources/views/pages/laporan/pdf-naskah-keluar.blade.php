<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
font-family: DejaVu Sans, sans-serif;
font-size:12px;
margin:40px;
}

/* HEADER */

.garis{
border-bottom:2px solid black;
margin-top:10px;
margin-bottom:20px;
}

.judul{
text-align:center;
margin-bottom:15px;
}

/* TABLE */

table{
width:100%;
border-collapse:collapse;
table-layout:fixed;
}

th,td{
border:1px solid black;
padding:6px;
vertical-align:top;
word-wrap:break-word;
}

th{
background:#eeeeee;
text-align:center;
}

td{
line-height:1.4;
}

/* FOOTER */

.footer{
margin-top:30px;
width:100%;
}

.ttd{
float:right;
text-align:center;
}

.qr{
margin-top:10px;
}

</style>

</head>

<body>

<!-- LOGO -->
<table width="100%" style="border:none;">
<tr>

<td width="90" style="border:none;">
<img src="{{ public_path('logo.png') }}" width="70">
</td>

<td style="border:none; text-align:center;">

<b style="font-size:14px;">PEMERINTAH KOTA SEMARANG</b><br>
<b style="font-size:13px;">BAGIAN ADMINISTRASI PEMBANGUNAN</b><br>
<span style="font-size:11px;">Gedung Moch Ikhsan Lt 5</span>

</td>

<td width="90" style="border:none;"></td>

</tr>
</table>

<hr style="border:1px solid black; margin-top:8px; margin-bottom:20px;">


<!-- JUDUL LAPORAN -->
<div class="judul">

<h3>LAPORAN NASKAH KELUAR</h3>

Periode: SEMUA DATA

</div>


<!-- TABEL DATA -->
<table>

<thead>
<tr>
<th width="30">No</th>
<th width="80">Tanggal</th>
<th width="120">Nomor Surat</th>
<th width="120">Pengirim</th>
<th width="150">Tujuan</th>
<th width="80">Jenis</th>
<th width="40">Sifat</th>
<th width="80">Klasifikasi</th>
<th width="120">Hal</th>
</tr>
</thead>

<tbody>

@foreach($data as $i => $item)

<tr>

<td align="center">{{ $i+1 }}</td>

<td>
{{ \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') }}
</td>

<td>
{{ $item->nomor_naskah ?? '-' }}
</td>

<td>
{{ $item->pengirim }}
</td>

<td>

@foreach($item->tujuan as $t)
{{ $t->nama }}<br>
@endforeach

@if($item->tujuan_manual)
{{ $item->tujuan_manual }}
@endif

</td>

<td>
{{ $item->jenis_naskah }}
</td>

<td align="center">
{{ $item->sifat_naskah }}
</td>

<td>
{{ $item->klasifikasi_kode }}
</td>

<td>
{{ $item->hal ?? '-' }}
</td>

</tr>

@endforeach

</tbody>

</table>


<!-- TOTAL DATA -->
<p style="margin-top:10px;">
<b>Total Data: {{ count($data) }}</b>
</p>


<!-- TANDA TANGAN + QR -->
<div class="footer">

<div class="ttd">

Semarang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}

<div class="qr">
<img src="data:image/svg+xml;base64,{{ $qrCode ?? '' }}" width="90">
</div>

<div style="font-size:10px">
Scan untuk validasi laporan
</div>

</div>

</div>

</body>
</html>
