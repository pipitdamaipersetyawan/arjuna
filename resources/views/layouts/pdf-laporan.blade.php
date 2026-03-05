<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
font-family: DejaVu Sans, sans-serif;
font-size:12px;
}

.header{
width:100%;
border-bottom:3px solid black;
padding-bottom:10px;
margin-bottom:15px;
}

.logo{
float:left;
width:80px;
}

.kop{
text-align:center;
}

.kop h2{
margin:0;
font-size:18px;
}

.kop h3{
margin:0;
font-size:15px;
}

.kop p{
margin:0;
font-size:12px;
}

.clear{
clear:both;
}

.judul{
text-align:center;
font-size:14px;
font-weight:bold;
margin-top:10px;
margin-bottom:5px;
}

.tanggal{
text-align:center;
font-size:11px;
margin-bottom:15px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid black;
padding:6px;
}

th{
background:#eeeeee;
text-align:center;
}

td{
vertical-align:top;
}

.no{
text-align:center;
width:30px;
}

</style>

</head>

<body>

<!-- HEADER -->
<div class="header">

<div class="logo">

@if(file_exists(public_path('logo.png')))
<img src="{{ public_path('logo.png') }}" width="70">
@endif

</div>

<div class="kop">

<h2>PEMERINTAH DAERAH</h2>
<h3>BAGIAN ADMINISTRASI PEMBANGUNAN</h3>
<p>Gedung Moch Ikhsan Lt 5</p>

</div>

<div class="clear"></div>

</div>

<!-- JUDUL -->
<div class="judul">
{{ $judul }}
</div>

<div class="tanggal">
Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}
</div>

<!-- TABLE -->
<table>

<thead>

<tr>

@foreach($columns as $c)

<th>{{ $c }}</th>

@endforeach

</tr>

</thead>

<tbody>

@foreach($rows as $i => $row)

<tr>

<td class="no">{{ $i+1 }}</td>

@foreach($row as $cell)

<td>{{ $cell }}</td>

@endforeach

</tr>

@endforeach

</tbody>

</table>

</body>
</html>
