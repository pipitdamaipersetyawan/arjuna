<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
font-family: DejaVu Sans, sans-serif;
font-size:11px;
}

table{
border-collapse:collapse;
width:100%;
}

th,td{
border:1px solid #000;
padding:4px;
}

th{
background:#f2f2f2;
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

<th>No</th>

<th>Tanggal Input</th>

<th>Pengirim</th>

<th>No Surat</th>

<th>Isi Informasi</th>

<th>Klasifikasi</th>

<th>Keterangan</th>

</tr>

</thead>

<tbody>

@foreach($data as $i => $row)

<tr>

<td>{{ $i+1 }}</td>

<td>{{ $row->tanggal }}</td>

<td>{{ $row->surat_dari }}</td>

<td>{{ $row->nomor_surat }}</td>

<td>{{ $row->isi_informasi }}</td>

<td>{{ $row->klasifikasi_kode }}</td>

<td>{{ $row->keterangan ?? '-' }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>
