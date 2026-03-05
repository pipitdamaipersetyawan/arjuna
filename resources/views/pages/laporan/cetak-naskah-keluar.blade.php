<!DOCTYPE html>
<html>
<head>
<title>Laporan Naskah Keluar</title>

<style>
body{font-family:Arial;font-size:12px}
table{border-collapse:collapse;width:100%}
th,td{border:1px solid #000;padding:5px}
th{background:#eee}
</style>

</head>

<body onload="window.print()">

<h2 style="text-align:center">
LAPORAN NASKAH KELUAR
</h2>

<table>

<tr>
<th>No</th>
<th>Tanggal</th>
<th>Nomor</th>
<th>Pengirim</th>
<th>Hal</th>
</tr>

@foreach($data as $i => $d)

<tr>
<td>{{ $i+1 }}</td>
<td>{{ $d->tanggal_surat }}</td>
<td>{{ $d->nomor_naskah }}</td>
<td>{{ $d->pengirim }}</td>
<td>{{ $d->hal }}</td>
</tr>

@endforeach

</table>

</body>
</html>
