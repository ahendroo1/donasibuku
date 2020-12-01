<!DOCTYPE html>
<html>
	<head>
		<title>{!! $title_meta !!}</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<meta name="description" content="{{$description}}">
		<meta name="keywords" content="{{$keywords}}">
		<meta name="author" content="{{get_setting('appname')}}">
		<meta name="copyright" content="&copy;Coyright {{get_setting('appname')}}" />
		<link href="{{asset(get_setting('favicon'))}}" rel="shortcut icon">

		<link href="{{asset("assets/css/style.css")}}" rel="stylesheet">
		<link href="{{asset("assets/plugins/bootstrap/css/bootstrap.css")}}" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		
		<link rel="stylesheet" href="{{asset('assets/plugins/font-awesome-4.6.3/css/font-awesome.min.css')}}">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

	    <!-- Owl Carousel Assets -->
	    <link href="{{asset("assets/plugins/owl-carousel/owl.carousel.css")}}" rel="stylesheet">
	    <link href="{{asset("assets/plugins/owl-carousel/owl.theme.css")}}" rel="stylesheet">

  		<link rel="stylesheet" href="https://daneden.github.io/animate.css/animate.min.css" />

	</head>
	<script>
		function openNav() {
		    document.getElementById("mySidenav").style.width = "100%";
		    $('body').css({
		    	'overflow':'hidden'
		    });
		}

		function closeNav() {
		    document.getElementById("mySidenav").style.width = "0";
		    $('body').css({
		    	'overflow':'auto'
		    });
		}
	</script>

	<script type="text/javascript">
		// $('body').load(function() {
		// 	alert('a');
		//     // find the related link or click event and enable/add it
		// });
	</script>

	<body class="{{implode(' ',$body_class)}}">

		<div class="wrapper-tbm">
			<div class="wrapper-header">
				<div class="mobile-top-menu hd">
					<div id="mySidenav" class="sidenav">
						<div class="action-menu">
							<div class="logo">
								<a href="{{url('/')}}">
									<img src="{{asset(get_setting('logo'))}}">
								</a>
							</div>
							<div class="close-tbn">
								<a href="javascript:void(0)" class="closebtn" onclick="closeNav()"><i class="fa fa-times"></i></a>
							</div>
						</div>
					  
					  <div class="main-menu">
							<ul>
								<li>
									<a href="{{url('/daftar-buku')}}">DAFTAR BUKU</a>
								</li>
								<li>
									<a href="{{url('/tbm')}}">DAFTAR TBM</a>
								</li>
								<li>
									<a href="{{url('/toko-buku')}}">TOKO BUKU</a>
								</li>
								<li>
									<a href="{{url('/page/tentang-kita')}}">TENTANG KITA</a>
								</li>
								<li>
									<a href="{{url('/page/donatur')}}">DONATUR</a>
								</li>
								<li>
									@if(Session::get('ss_type_pengguna'))
									<a href="{{url('/profile')}}">PROFILE</a>
									@else
									<a href="{{url('/login')}}">LOGIN</a>
									@endif
								</li>
							</ul>					  	
					  </div>
					</div>
					
					<div class="wrapper-top-mobile">
						<div class="item">
							<span class="button-menu" onclick="openNav()"><i class="fa fa-bars"></i></span>
						</div>
						<div class="item">
							<a href="{{url('/')}}">{{get_setting('appname')}}</a>
						</div>
						<div class="item">							
							<div class="keranjang-button">
								<a href="{{url('keranjang')}}">
									<img src="{{asset('assets/img/ic_cart_32x32.png')}}">
									<?php 

										$total_item = total_item(Session::get('ss_id_donasi'));
										if($total_item != 0){

									?>
									<span class="number">{{total_item(Session::get('ss_id_donasi'))}}</span>
									<?php } ?>
								</a>
							</div>
						</div>
					</div>

				</div>
				<div class="top-menu hm">
					<div class="container">
						<div class="row">
							<div class="col-md-5">
								<div class="left-menu menu">
									<ul>
										<li>
											<a href="{{url('/daftar-buku')}}">DAFTAR BUKU</a>
										</li>
										<li>
											<a href="{{url('/tbm')}}">DAFTAR TBM</a>
										</li>
										<li>
											<a href="{{url('/toko-buku')}}">TOKO BUKU</a>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-md-2">
								<div class="logo animated">
									<div class="wrap-logo">
										<a href="{{url('/')}}">
											<img src="{{asset(get_setting('logo'))}}">
											<!-- TBM -->
										</a>
										<span class="hidden"></span>
									</div>
								</div>
								<div class="logo-small hidden animated">
									<div class="wrap-logo">
										<a href="{{url('/')}}">
											<img src="{{asset(get_setting('logo'))}}">
											<!-- TBM -->
										</a>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="right-menu menu">
									<ul>
										<li>
											<a href="{{url('/page/tentang-kita')}}">TENTANG KITA</a>
										</li>
										<li>
											<a href="{{url('/page/donatur')}}">DONATUR</a>
										</li>
										<li>
											@if(Session::get('ss_type_pengguna'))
											<a href="{{url('/profile')}}">PROFILE</a>
											@else
											<a href="{{url('/login')}}">LOGIN</a>
											@endif
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="keranjang-button">
							<a href="{{url('keranjang')}}">
								<img src="{{asset('assets/img/ic_cart_32x32.png')}}">
								<?php 

									$total_item = total_item(Session::get('ss_id_donasi'));
									if($total_item != 0){

								?>
								<span class="number">{{total_item(Session::get('ss_id_donasi'))}}</span>
								<?php } ?>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="wrapper-main">