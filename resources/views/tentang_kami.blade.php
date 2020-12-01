@extends('layouts')
@section('content')
<!-- content -->
<div class="bg-white">
	<div class="box-container" id="box-container">
		<div class="title-content">
			<h1>Tentang Kami</h1>
			<div class="center-line"></div>
		</div>

		<div class="container">
			<div class="col-sm-12">
				<div class="list-berita-page">
                    <ul>
                        <li>
                            <h4>Tujuan Platform donasi buku</h4>   
                            <p>Platform Donasi Buku Daring menjadi salah satu strategi untuk mengajak masyarakat luas, baik perorangan maupun lembaga, untuk memberikan kontribusi, bantuan buku atau sarana dan prasarana lainnya yang dibutuhkan oleh TBM dan para penggiat literasi di seluruh Tanah Air.  Aplikasi yang memuat data profil TBM beserta kegiatan dan kebutuhannya ini mempertemukan kebutuhan TBM dengan para donatur yang dapat berkontribusi dalam membantu dan menyukseskan gerakan literasi di masyarakat. Donatur bisa memilih TBM yang akan dibantu dan memberikan bantuan yang sesuai dengan kebutuhan masing-masing TBM. Jenis dan bentuk bantuan pun menjadi lebih tepat sasaran. </p>
                        
                        </li>
                        <li>
                            <h4>Tentang PMPK </h4>
                            <p>Direktorat Pendidikan Masyarakat dan Pendidikan Khusus merupakan unit organisasi Direktorat Jenderal Pendidikan Anak Usia Dini, Pendidikan Dasar,dan Pendidikan Menengah yang mengemban amanat dalam memajukan pembangunan SDM melalui usaha bersama semua anak bangsa untuk meningkatkan mutu pendidikan dan memajukan kebudayaan di bidang pendidikan keaksaraan, pendidikan kesetaraan, dan pendidikan khusus.</p>
                        </li>
                        <img src="{{asset('img/history-tbm.png')}}" alt="" width="100%" class="m-t-40">
                        <img src="{{asset('img/tentang-tbm-01.jpg')}}" alt="" width="100%"  class="m-t-40">
                        <img src="{{asset('img/tentang-tbm-05.jpg')}}" alt="" width="100%"  class="m-t-40">
                    </ul>
				</div>
			</div>
			 
		</div>
	</div>
</div>
@endsection