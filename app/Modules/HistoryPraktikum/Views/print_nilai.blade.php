<!DOCTYPE html>
<html>
<head>
	<title>Cetak Nilai Praktikum</title>
</head>
<body onload="window.print()">
	<style type="text/css">
		@page {
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
		  border: 0px;
		}

		table {
		  border-collapse: collapse;
		  width: 100%;
		}

		th {
		  height: 50px;
		}

	</style>
	<table width="100%" style="border: 0px;">
		<tr>
			<td colspan="3" style="text-align: center;"><h2>Rekap Nilai Praktikum</h2></td>
		</tr>
		<tr>
			<td width="15%">NIM</td>
			<td>:</td>
			<td>{{ $mahasiswa->nim }}</td>
		</tr>
		<tr>
			<td width="15%">Mahasiswa</td>
			<td>:</td>
			<td>{{ $mahasiswa->name }}</td>
		</tr>

		<tr>
			<td colspan="3"></td>
		</tr>

		<tr>
			<td width="15%">Praktikum</td>
			<td>:</td>
			<td>{{ $praktikum->praktikum }}</td>
		</tr>
		<tr>
			<td width="15%">Dosen</td>
			<td>:</td>
			<td>{{ $praktikum->name.' - '.$praktikum->nip }}</td>
		</tr>
		<tr>
			<td width="15%">Waktu Praktikum</td>
			<td>:</td>
			<td>{{ $praktikum->hari.', '.$praktikum->waktu_mulai.' - '.$praktikum->waktu_selesai }}</td>
		</tr>

		<tr>
			<td width="15%">Nilai</td>
			<td>:</td>
			<td><strong>{{ $praktikum->nilai }}</strong></td>
		</tr>
		
	</table>
	<br>
</body>
</html>