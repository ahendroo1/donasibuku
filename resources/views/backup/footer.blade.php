
			</div>
			<div class="wrapper-footer">
				<div class="wrapper-big-footer">
					<div class="container">
						<div class="wrapper">
							<div class="row">
								<div class="col-md-6">
									<div class="sidebar left">
										<ul>
											<li>
												<a href="{{url('daftar-buku')}}">DONASI BUKU</a>
											</li>
											<li>
												<a href="{{url('tbm')}}">DAFTAR TBM</a>
											</li>
											<li>
												<a href="{{url('page/tentang-kita')}}">TENTANG KITA</a>
											</li>
											<li>
												<a href="{{url('page/cara-registrasi')}}">CARA REGISTRASI</a>
											</li>
											<li>
												<a href="{{url('page/cara-menambahkan-kebutuhan-buku')}}">CARA MENAMBAHKAN KEBUTUHAN BUKU</a>
											</li>
											<!-- <li>
												<a href="#">KEBIJAKAN</a>
											</li>
											<li>
												<a href="#">SYARAT DAN KETENTUAN</a>
											</li>
											<li>
												<a href="#">FAQ</a>
											</li> -->
										</ul>
									</div>
								</div>
								<div class="col-md-6">
									<div class="sidebar right">
										<div class="title">
											<div class="big">HUBUNGI KAMI</div>
											<div class="small">Kami akan sangat menghargai ini</div>
										</div>
										<div class="content">
											<form method="post" action="{{action("FrontController@postSendEmail")}}">
		    									<input type="hidden" name="_token" value="{{ csrf_token() }}" />
												<input type="email" name="email" id="email" placeholder="email">
												<textarea name="pesan" id="pesan" rows="8" placeholder="pesan"></textarea>
												<input type="submit" value="KIRIM">
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="wrapper">
					<div class="container">
						<div class="row">
							<div class="col-md-4 col-md-offset-4">
								<div class="sosmed ta-center">
									<ul>
										<?php $twitter = get_setting('twitter') ?>
										@if($twitter)
										<li>
											<a href="{{$twitter}}">
												<i class="fa fa-twitter"></i>
											</a>
										</li>
										@endif
										<?php $google_plus = get_setting('google-plus') ?>
										@if($google_plus)
										<li>
											<a href="{{$google_plus}}">
												<i class="fa fa-google-plus"></i>
											</a>
										</li>
										@endif
										<?php $youtube = get_setting('youtube') ?>
										@if($youtube)
										<li>
											<a href="{{$youtube}}">
												<i class="fa fa-youtube"></i>
											</a>
										</li>
										@endif
										<?php $instagram = get_setting('instagram') ?>
										@if($instagram)
										<li>
											<a href="{{$instagram}}">
												<i class="fa fa-instagram"></i>
											</a>
										</li>
										@endif
										<?php $facebook = get_setting('facebook') ?>
										@if($facebook)
										<li>
											<a href="{{$facebook}}">
												<i class="fa fa-facebook"></i>
											</a>
										</li>
										@endif
									</ul>
								</div>
							</div>
							<div class="col-md-4">
								<div class="tlpn ta-center">
									telepon kita di {{get_setting('no-telepon')}}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<script>
		$(document).ready(function() {
			// Show or hide the sticky footer button
			$(window).scroll(function() {
				if ($(this).scrollTop() > 10) {
					$('.top-menu .logo').addClass('hidden');
					$('.top-menu .logo-small').removeClass('hidden');
					$('.top-menu .logo-small').addClass('fadeIn');
				} else {
					$('.top-menu .logo').removeClass('hidden');
					$('.top-menu .logo').addClass('fadeIn');
					$('.top-menu .logo-small').addClass('hidden');
					$('.top-menu .logo-small').removeClass('fadeIn');
				}
			});
			
			// Animate the scroll to top
			// $('.top-menu .logo').click(function(event) {
			// 	event.preventDefault();
				
			// 	$('html, body').animate({scrollTop: 0}, 300);
			// })
		});
	</script>

	<script type="text/javascript">
		function ajakKota(id_prov){
		var id_prov    = id_prov;
		var dataString = 'id_prov='+ id_prov ;
			$.ajax({
				type: "GET",
				url: "{{url('ajak-kota')}}",
				data: dataString,
				cache: false,
				success: function(result){							
					document.getElementById("kota").innerHTML=result;
				}
			});
			}
	</script>

	<script type="text/javascript" src="{{asset("assets/plugins/owl-carousel/owl.carousel.js")}}"></script>
	<script type="text/javascript" src="{{asset("assets/plugins/bootstrap/js/bootstrap.min.js")}}"></script>
	</body>
</html>