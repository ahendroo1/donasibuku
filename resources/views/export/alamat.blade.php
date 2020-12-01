<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{
			background-image: url('{{ public_path('assets/print.png') }}');
			background-color: #fff;
			font-family: Sans-serif;
		}
		table{
			border-collapse: collapse;
		}
		td{
			padding:3px;
		}
		@page { margin: 0px; }
		body { margin: 0px; }
		@page { size: 800pt 210pt; }
		table{
			font-size: 10px;
		}
	</style>
</head>
<body>
	<table width="100%" border="1" style="margin-top: 25px;margin-left: 15px;margin-right: 20px">
		<tr>
			<td style="text-align: center;color:#000;width: 300pt;">
				<center>
					<img src="{{ public_path('assets/icon/kemdikbud.png') }}" style="margin-top:20px;margin-bottom:20px;width: 100px">
				</center>
				<table>
					<tr>
						<td align="left">
							<div>
								<h3>Informasi Pengiriman</h3>
								<h3>No Donasi : {{$donasi}}</h3>
							</div>	
						</td>
						<td align="left">
							<img src="{{ public_path('assets/print_logo.png') }}" style="width: 50px;margin-left:20px;margin-right: 20px;float: left;">
							<img src="{{ public_path('assets/icon/gln.png') }}" style="width: 50px;float: left;margin-top: 8px;">
						</td>
					</tr>
				</table>
			</td>
			<td style="background: #fff;">
				<div style="margin-left:40px; ">
					<table>
						<tr>
							<td style="font-size: 12px;width: 300px;"><b>PENERIMA</b></td>
							<td style="font-size: 12px;"><b>PENGIRIM</b></td>
						</tr>
						<tr>
							<td><small style="font-size: 10px;color:#A8AEBA;">Nama TBM</small><br><span style="font-size: 12px;color:#3B4251;">{{$data->nama}}</span></td>
							<td><small style="font-size: 10px;color:#A8AEBA;">Nama Pengirim</small><br><span style="font-size: 12px;color:#3B4251;">{{$donatur->nama}}</span></td>
						</tr>
						<tr>
							<td><small style="font-size: 10px;color:#A8AEBA;">Penerima</small><br><span style="font-size: 12px;color:#3B4251;">{{$data->nama_ketua}} ( {{$data->tlpn_pengelola}} )</span></td>
							<td><small style="font-size: 10px;color:#A8AEBA;">Telepon Pengirim</small><br><span style="font-size: 12px;color:#3B4251;">{{$donatur->tlpn}}</span></td>
						</tr>
						<tr>
							<td><small style="font-size: 10px;color:#A8AEBA;">Alamat Penerima</small><br>
							<div style="width: 120pt;" valign="top"><span style="font-size: 12px;color:#3B4251;">{{$data->alamat}},{{$data->kodepos}},{{show_value($data->kota,'kabupaten','kabupaten')}},{{show_value($data->provinsi,'propinsi','propinsi')}}</span></div></td>
							<td valign="top"><small style="font-size: 10px;color:#A8AEBA;">Alamat Pengirim</small><br>
							<span style="font-size: 12px;color:#3B4251;">{{$donatur->alamat_pengirim}}</span></td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
</body>
</html>