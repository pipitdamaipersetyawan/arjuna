<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

@page {
margin:25px 30px;
}

body{
font-family: DejaVu Sans, sans-serif;
font-size:11px;
}

table{
border-collapse: collapse;
width:100%;
}

th,td{
border:1px solid #000;
padding:4px;
}

th{
background:#f2f2f2;
text-align:center;
}

.judul{
text-align:center;
font-weight:bold;
margin-bottom:10px;
}

</style>

</head>

<body>

<div class="judul">
LAPORAN SURAT MASUK
</div>

<table>

<thead>

<tr>

<th width="5%">No</th>

<th width="15%">Tanggal Input</th>

<th width="20%">Pengirim</th>

<th width="20%">No Surat</th>

<th width="25%">Isi Informasi</th>

<th width="10%">Klasifikasi</th>

<th width="15%">Keterangan</th>

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

<td>{{ $row->keterangan ?? '-' }}</td>

</tr>

@endforeach

</tbody>

</table>

<br>

Total Data : {{ count($data) }}

</body>
</html>
