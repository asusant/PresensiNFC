<!DOCTYPE html>
<html>
<head>
	<title>Cetak Nilai Praktikum</title>
</head>
<body onload="window.print()">
	<style type="text/css">
		@page {
			size: A4;
			margin: 50px;
		}
		@media print {
			html, body {
				width: 210mm;
				height: 297mm;
			}
		}
		body{
			font-size: 12pt;
			font-family: "Times New Roman";
		}

		table, td, th {
		  border: 1px solid black;
		}

		table {
		  border-collapse: collapse;
		  width: 100%;
		}

		th {
		  height: 50px;
		}

		.nb {
			border: none !important;
		}

	</style>
	<table width="100%" style="border: 0px;">
		<tr>
			<td style="border: 0px;" colspan="3" style="text-align: center;"><h2>Rekap Nilai Praktikum</h2></td>
		</tr>
		<tr>
			<td style="border: 0px;" width="15%">Praktikum</td>
			<td style="border: 0px;">:</td>
			<td style="border: 0px;">{{ $praktikum->praktikum }}</td>
		</tr>
		<tr>
			<td style="border: 0px;" width="15%">Dosen</td>
			<td style="border: 0px;">:</td>
			<td style="border: 0px;">{{ $praktikum->name.' - '.$praktikum->nip }}</td>
		</tr>
		<tr>
			<td style="border: 0px;" width="15%">Waktu Praktikum</td>
			<td style="border: 0px;">:</td>
			<td style="border: 0px;">{{ $praktikum->hari.', '.$praktikum->waktu_mulai.' - '.$praktikum->waktu_selesai }}</td>
		</tr>
	</table>
	<br>
	<table width="100%">
		<thead>
			<tr>
				<th>No</th>
				<th>NIM</th>
				<th>Nama</th>
				<th>Nilai Akhir</th>
				<th>Indeks</th>
			</tr>
		</thead>
		<tbody>
			@php $no=1; @endphp
			@foreach($peserta as $key => $row)
				<tr>
					<td  style="text-align: center;">{{ $no }}</td>
					<td>{{ $row->nim }}</td>
					<td>{{ $row->name }}</td>
					<td style="text-align: center;">{{ $row->nilai }}</td>
					<td style="text-align: center;">{{ Format::convertNilai($row->nilai) }}</td>
				</tr>
				@php $no++; @endphp
			@endforeach
		</tbody>
	</table>
	<br>
	<br>
	<table width="100%" class="nb">
		<tr>
			<td class="nb" width="75%"></td>
			<td class="nb" width="25%">{{ Format::$lokasi.', '.App\Models\Content::tanggal_indo(date('Y-m-d'), false) }}</td>
		</tr>
		<tr>
			<td class="nb" width="75%"></td>
			<td class="nb" width="25%">
				<br><br><br>
				{{ $praktikum->name }}
			</td>
		</tr>
	</table>
</body>
</html>