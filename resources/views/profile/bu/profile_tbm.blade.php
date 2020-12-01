@include('header')
<div class="wrapper-on-page">
	<div class="container">
		<div class="wrapper">
			<div class="row">
				<div class="col-md-4">
					<div class="left-sidebar">
						<div class="image">
							<img src="{{asset($tbm->image)}}">
						</div>
						@if($id_tbm)
							<?php $email = show_value($id_tbm,'tbm','email') ?>
							<div class="menu">
								<ul>
									<li>
										<a href="{{url('/tbm/'.$email)}}" class="{{($slug=='')?'active':''}}">
											Profile
										</a>
									</li>
									<li>
										<a href="{{url('/tbm/'.$email.'/pengelola')}}" class="{{($slug=='pengelola')?'active':''}}">
											Pengelola
										</a>
									</li>
									<li>
										<a href="{{url('/tbm/'.$email.'/kegiatan')}}" class="{{($slug=='kegiatan')?'active':''}}">
											Kegiatan TBM
										</a>
									</li>
									<li>
										<a href="{{url('/tbm/'.$email.'/kebutuhan')}}" class="{{($slug=='kebutuhan')?'active':''}}">
											Daftar Kebutuhan Buku
										</a>
									</li>
								</ul>
							</div>
						@else
							<div class="menu">
								<ul>
									<li>
										<a href="{{url('/profile')}}" class="{{($slug=='')?'active':''}}">
											Profile
										</a>
									</li>
									<li>
										<a href="{{url('/profile/pengelola')}}" class="{{($slug=='pengelola')?'active':''}}">
											Pengelola
										</a>
									</li>
									<li>
										<a href="{{url('/profile/kegiatan')}}" class="{{($slug=='kegiatan')?'active':''}}">
											Kegiatan TBM
										</a>
									</li>
									<li>
										<a href="{{url('/profile/kebutuhan')}}" class="{{($slug=='kebutuhan')?'active':''}}">
											Daftar Kebutuhan Buku
										</a>
									</li>
									<li>
										<a href="{{url('/logout')}}">
											Logout
										</a>
									</li>
								</ul>
							</div>
							<a href="{{url('profile/edit')}}" class="tbm-btn">
							Edit Profile
							</a>
						@endif
					</div>
				</div>
				<div class="col-md-8">
					@if($slug != '')
						@include('profile.'.$slug)
					@else
						<div class="main-sidebar">
							<div class="title">{{$tbm->nama}}</div>
							<div class="border-tbm"><span></span></div>
							<div class="detail">
								<div class="row">
									<div class="col-md-3">
										<label>Tahun Berdiri</label>
									</div>
									<div class="col-md-3">{{$tbm->tahun_berdiri}}</div>
									<div class="col-md-3">
										<label>No Ijin Oprasional</label>
									</div>
									<div class="col-md-3">{{$tbm->no_izin}}</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Provinsi</label>
									</div>
									<div class="col-md-3">{{show_value($tbm->provinsi,'propinsi','propinsi')}}</div>
									<div class="col-md-3">
										<label>Kab / Kota</label>
									</div>
									<div class="col-md-3">{{show_value($tbm->kota,'kabupaten','kabupaten')}}</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Alamat</label>
									</div>
									<div class="col-md-9">
										{{$tbm->alamat}}
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Kode Pos</label>
									</div>
									<div class="col-md-9">
										{{$tbm->kodepos}}
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>No Telepon</label>
									</div>
									<div class="col-md-3">{{$tbm->tlpn}}</div>
									<div class="col-md-3">
										<label>No Handphone</label>
									</div>
									<div class="col-md-3">{{$tbm->no_hp}}</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Email</label>
									</div>
									<div class="col-md-9">
										{{$tbm->email}}
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<label>Dokumen Penunjang TBM</label>
									</div>
									<div class="col-md-9">
										<div class="row dokumen">
											@foreach($dokumen as $item)
											<div class="col-md-4 item">
												<?php 

													$extension = asset($item->upload);
													$extension = pathinfo($extension);
													$extension = $extension['extension'];
													$array_extImage = array("png", "jpg", "jpeg", "gif","tiff","PNG", "JPG", "JPEG", "GIF","TIFF");

												?>
												@if(in_array($extension, $array_extImage))
													<a href="{{asset($item->upload)}}" target="_blank">
														<div class="upload">
															<img src="{{asset($item->upload)}}">
														</div>
													</a>
												@else
													<a href="{{asset($item->upload)}}" target="_blank">
														<div class="upload file p-5">
															{{substr($item->upload, 48)}}
														</div>
													</a>
												@endif
											</div>
											@endforeach
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<label>Lokasi</label>
									</div>
									<div class="col-md-12">								
			
										@if($tbm->latitude && $tbm->longitude)
										<div class="map">

											<style type="text/css">
											#map{
												height: 300px;
											}
											</style>
											<div id="map"></div>
											<?php
												    $Lat = $tbm->latitude;
												    $Lon = $tbm->longitude;
											?>
										    <script>
										      function initMap() {
										        // var myLatLng = {lat: -25.363, lng: 131.044};
										        var myLatLng = {lat: <?php echo $Lat ?>, lng: <?php echo $Lon ?>};

										        // Create a map object and specify the DOM element for display.
										        var map = new google.maps.Map(document.getElementById('map'), {
										          center: myLatLng,
										          scrollwheel: false,
										          zoom: 15
										        });

										        // Create a marker and set its position.
										        var marker = new google.maps.Marker({
										          map: map,
										          position: myLatLng
										        });
										      }

										    </script>
										    <script src="https://maps.googleapis.com/maps/api/js?key={{get_setting('google_api_key')}}&callback=initMap"
										        async defer></script><br>

										</div>
										@endif
									</div>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@include('footer')