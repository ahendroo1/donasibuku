<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		@import url('https://fonts.googleapis.com/css?family=Titillium+Web');
		body{
			font-family: 'Titillium Web', sans-serif;
		}
		.footer{
			padding-top: 10px;
			padding-bottom: 10px;
			text-align: center;
			background-color: #3951a2;
			color: #fff;
			font-size: 12px;
		}
		.btn-tbm{
			padding: 10px;
			font-size: 12px;
			border-radius: 5px;
			background-color: #002BAF;
			color: #fff;
			text-decoration: none;
		}
	</style>
</head>
<body>
	<div class="">
		<center><img src="{{asset('assets/icon/ic_logo_header.png')}}"></center>
		<h3>Pemberitahuan Donasi</h3>
		<p>permintaan buku dengan kategori : <b>{{$content['kategori']}}</b> telah mendapatkan seorang donatur.<br>
			Silahkan update judul buku yang anda terima. <br>
			Nomor Donasi : {{$content['no_donasi']}}<br>
			Nama Donatur : {{$content['nama_donatur']}}
			<br><br>
			<br>
			<a href="{{url('login')}}" class="btn-tbm" target="_blank">menuju halaman TBM</a><br><br><br>
			Terimasih
			<br>
			<br>

			<img src="https://cdn.shopify.com/s/files/1/1061/1924/files/Hugging_Face_Emoji_2028ce8b-c213-4d45-94aa-21e1a0842b4d_large.png?15202324258887420558" style="width: 50px;">
		</p>
	</div>
	<div class="footer">
		Kemendikbud - TBM &copy; 2018
	</div>
</body>
</html>