@extends('layouts')
@section('content')
<style type="text/css">
	@if(empty(Request::get('kategori_spnf')))
		#form-kategori_spnf{
			display: none;
		}
	@else
		#form-kategori_spnf{
			display: block;
		}
	@endif

	@if(empty(Request::get('nama_lembaga_naungan')))
		#nama_lembaga_naungan{
			display: none;
		}
	@else
		#nama_lembaga_naungan{
			display: block;
		}
	@endif
</style>
<?php
	$kode_phone = json_decode(file_get_contents("notelp.json"),true);
?>
<div class="container box-container" id="box-container">
	<div class="col-sm-8 col-sm-offset-2">
		<div class="title-register"><h2>Daftar TBM</h2></div>
		<div class="wrapper-register">
			<h4 class="m-t-40">Identitas Lembaga</h4>
			<div class="col-sm-10 col-sm-offset-1 box-form">
				<form id="formRegTBM-1" class="validatedForm" method="post" enctype="multipart/form-data">
					<div id="step-1">
						<input type="hidden" name="kategori_tbm" value="{{Request::get('kategori_tbm')}}">
						<input type="hidden" name="kategori_spm" value="{{Request::get('kategori_spm')}}">
						<input type="hidden" name="kategori_spnf" value="{{Request::get('kategori_spnf')}}">
						<input type="hidden" name="nama_lembaga_naungan" value="{{Request::get('nama_lembaga_naungan')}}">
						<div class="box-change">
							<div class="pull-left info-change">kategori TBM : {{Request::get('kategori_spm')}} </div>
							<div class="pull-right"><button class="btn btn-default menu-custom blue menu-right" type="button" data-toggle="modal" data-target="#modal-register">Ubah</button></div>
						</div>
						<div class="form-group form-group-custom">
							<label>Email <span class="required">*</span></label>
							<input type="email" id="email" class="form-control" required="" autocomplete="false" value="{{ old('email') }}">
						</div>
						<div class="form-group form-group-custom">
							<label>Password <span class="required">*</span></label>
							<input type="password" id="password" class="form-control" required="" autocomplete="false" value="{{ old('password') }}">
							<p class="pull-right">Kata Sandi minimal 8 karakter</p>
							<div class="clear"></div>
						</div>
						<div class="row m-t-30">
							<?php 
							$range_year = range(date('Y')-100,date('Y'));
							?>
							<div class="col-sm-6">
								<div class="form-group form-group-custom">
									<label>Tahun Berdiri <span class="required">*</span></label>
									<select class="form-control" id="tahun_berdiri" name="tahun_berdiri" required="" style="border-bottom: 1px solid#002BAF;">
										<option value="">*Pilih Tahun</option>
										@if(old('tahun_berdiri'))
										@foreach($range_year as $item)
										<option value="{{$item}}" <?php echo ($item == old('tahun_berdiri'))?'selected="selected"':''?>>{{$item}}</option>
										@endforeach
										@else
										@foreach($range_year as $item)
										<option value="{{$item}}" <?php echo ($item == date('Y'))?'selected="selected"':''?>>{{$item}}</option>
										@endforeach
										@endif
									</select>
									<!-- <hr class="border border-no-padding  m-tb-0"> -->
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-custom">
									<label>No. Ijin Operasional <span class="required">*</span></label>
									<input name="no_izin" id="no_izin" value="{{ old('no_izin') }}" autocomplete="off" type="text" class="form-control" required>
								</div>
							</div>
						</div>
						<div class="row m-t-30">
							<div class="col-sm-6">
								<div class="form-group form-group-custom">
									<label>Provinsi <span class="required">*</span></label>
									<select class="form-control" id="provinsi" onchange="ajakKota(this.value)" style="border-bottom: 1px solid#002BAF;">
										<option value="">*Pilih Porvinsi</option>
										@foreach($propinsi as $item)
										<option value="{{$item->id}}">{{$item->propinsi}}</option>
										@endforeach
									</select>
									<!-- <hr class="border border-no-padding  m-tb-0"> -->
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-group-custom">
									<label>Kab/Kota <span class="required">*</span></label>
									<select class="form-control" id="kota" style="border-bottom: 1px solid#002BAF;">
										<option value="">Pilih Kab / Kota</option>
									</select>
									<!-- <hr class="border border-no-padding  m-tb-0"> -->
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group form-group-custom">
									<label>Kecamatan <span class="required">*</span></label>
									<input name="kecamatan" id="kecamatan" value="{{ old('kecamatan') }}" autocomplete="off" type="text" class="form-control" required>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group form-group-custom">
									<label>Desa/Kelurahan <span class="required">*</span></label>
									<input name="desa" id="desa" value="{{ old('desa') }}" autocomplete="off" type="text" class="form-control" required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-custom">
									<label>RT <span class="required">*</span></label>
									<input name="rt" min="0" id="rt" value="{{ old('rt') }}" autocomplete="off" type="number" class="form-control" required>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group form-group-custom">
									<label>RW <span class="required">*</span></label>
									<input name="rw" min="0" id="rw" value="{{ old('rw') }}" autocomplete="off" type="number" class="form-control" required>
								</div>
							</div>
						</div>
						<div class="form-group form-group-custom">
							<label for="alamat">Jalan <span class="required">*</span></label>
							<textarea  name="alamat" id="alamat" autocomplete="off" required class="form-control" rows="4">{{ old('alamat') }}</textarea>
						</div>
						<div class="form-group form-group-custom">
							<label>Kode Pos <span class="required">*</span></label>
							<input name="kodepos" id="kodepos" value="{{ old('kodepos') }}" autocomplete="off" type="number" class="form-control" required>
							<!-- <p class="pull-right">Maximal 5 karakter</p> -->
						</div>
						<br class="clear">
						<div class="form-register">
							<div class="form-group form-group-custom">
								<label>Nama Lembaga <span class="required">*</span></label>
								<input type="text" name="nama" id="nama" class="form-control" required="" autocomplete="false" value="{{ old('nama') }}">
							</div>
							
							<div class="row m-t-50">
								<div class="col-sm-6">
									<div class="form-group form-group-custom">
										<label>No. Telepon </label>
										<div class="row">
											<div class="col-xs-6">
												<select class="form-control" id="kode_no_telepon" style="border-bottom: 1px solid#002BAF;">
													@foreach($kode_phone['list_number'] as $row)
														@if($row['dial_code'] == '+62')
														<option value="{{$row['dial_code']}}" selected="">{{$row['name']}} ({{$row['dial_code']}})</option>
														@endif
													@endforeach
												</select>
											</div>
											<div class="col-xs-6">
												<input name="tlpn" id="tlpn" value="{{ old('tlpn') }}" autocomplete="off" type="number" class="form-control" >
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-custom">
										<label>No. Telepon Seluler</label>
										<div class="row">
											<div class="col-xs-6">
												<select class="form-control" id="kode_no_seluler" style="border-bottom: 1px solid#002BAF;">
													@foreach($kode_phone['list_number'] as $row)
														@if($row['dial_code'] == '+62')
														<option value="{{$row['dial_code']}}" selected="">{{$row['name']}} ({{$row['dial_code']}})</option>
														@endif
													@endforeach
												</select>
											</div>
											<div class="col-xs-6">
												<input name="no_hp" id="no_hp" value="{{ old('no_hp') }}" autocomplete="off" type="number" class="form-control">
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-6 m-t-30" style="display: none;">
									<div class="form-group form-group-custom">
										<label for="no_telp">Foto TBM <span class="required">*</span></label>
										<label class="file-upload" id="foto-tbm">
											<div class="center-text-file-upload"><i class="fas fa-camera fa-3x fa-camera-custom"></i><br><small class="img-upload">Unggah Foto</small></div>
											<input type="file" name="image" id="image" class="hidden" onchange="readURL(this);">
										</label>
									</div>
								</div>

								<div class="col-sm-6 m-t-30" style="display: none;">
									<div class="form-group form-group-custom">
										<label for="no_telp">Lokasi <span class="required">*</span></label>
										<input id="searchInput" class="input-controls" type="text" placeholder="Enter a location">
										<div class="map" id="map" style="width: 100%; height: 300px;"></div>
										<div class="form_area">
											<input type="text" name="location" id="location">
											<input type='hidden' name="latitude" value="{{old('latitude')}}" id="lat" />
											<input type='hidden' name="longitude" value="{{old('longitude')}}" id="lng"/>
										</div>
									</div>
								</div>
								<div class="col-sm-12 m-t-30">
									<center><button class="btn btn-default menu-login blue" type="button" id="button-lanjut">Lanjut</button></center>
								</div>
							</div>
						</div>
					</div>
				</form>
				<form id="formRegTBM-2" action="{{action("FrontController@postRegisterTbm")}}" method="post" enctype="multipart/form-data" onsubmit="return form2_onsubmit()">
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" name="provinsi" value="" id="hidden-prov">
					<input type="hidden" name="kota" value="" id="hidden-kota">
					<input type="hidden" name="password" value="" id="hidden-password">
					<input type="hidden" name="email" value="" id="hidden-email">
					<input type="hidden" name="kode_no_seluler" value="" id="hidden-kode_no_seluler">
					<input type="hidden" name="kode_no_telepon" value="" id="hidden-kode_no_telepon">
					<div id="clone"	class="hidden">
						
					</div>
					<div id="step-2">
						<br class="clear">
						<div class="form-register">
							<div class="form-group form-group-custom">
								<label>Ketua TBM <span class="required">*</span></label>
								<input  name="nama_ketua" id="nama_ketua" value="{{ old('nama_ketua') }}" autocomplete="off" type="text" class="form-control" required>
							</div>
							<div class="row m-t-30">
								<div class="col-sm-6">
									<div class="form-group form-group-custom">
										<label>Tempat Lahir <span class="required">*</span></label>
										<input name="tempat_lahir_pengelola" id="tempat_lahir_pengelola" value="{{ old('tempat_lahir_pengelola') }}" autocomplete="off" type="text" class="form-control" required>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-custom">
										<label>Tanggal Lahir <span class="required">*</span></label>
										@if(old('tanggal_lahir_pengelola'))
										<input type='text' class='form-control notfocus datepicker' name="tanggal_lahir_pengelola" id="tanggal_lahir_pengelola" value='{{old('tanggal_lahir_pengelola')}}'/>
										@else
										<input type='text' class='form-control notfocus datepicker' name="tanggal_lahir_pengelola" id="tanggal_lahir_pengelola" value='{{date('Y-m-d')}}'/>
										@endif
									</div>
								</div>
							</div>
							<div class="form-group form-group-custom">
								<label>Jalan <span class="required">*</span></label>
								<input name="alamat_pengelola" id="alamat_pengelola"  value="{{ old('alamat_pengelola') }}" autocomplete="off" type="text" class="form-control" required>
							</div>
							<div class="form-group form-group-custom">
								<label>Email <span class="required">*</span></label>
								<input name="email_pengelola" id="email_pengelola"  value="{{ old('email_pengelola') }}" autocomplete="off" type="text" class="form-control" required >
							</div>
							<div class="row m-t-50">
								<div class="col-sm-6">
									<div class="form-group form-group-custom">
										<label>No. Telepon </label>
										<div class="row">
											<div class="col-xs-6">
												<select class="form-control" id="kode_tlpn_pengelola" name="kode_tlpn_pengelola" style="border-bottom: 1px solid#002BAF;">
													<option value="">Pilih kode </option>
													@foreach($kode_phone['list_number'] as $row)
														<option value="{{$row['dial_code']}}" <?php if($row['dial_code'] == $no_replace){ echo "selected"; } ?>>{{$row['name']}} ({{$row['dial_code']}})</option>
													@endforeach
												</select>
											</div>
											<div class="col-xs-6">
												<input name="tlpn_pengelola" id="tlpn_pengelola" value="{{ old('tlpn_pengelola') }}" autocomplete="off" type="number" class="form-control" >
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-group-custom">
										<label>Kodepos Pengelola <span class="required">*</span></label>
										<input name="kodepos_pengelola" id="kodepos_pengelola" value="{{ old('kodepos_pengelola') }}" autocomplete="off" type="number" class="form-control" required >
									</div>
								</div>

								<div class="col-sm-12">
									<input type="checkbox" name="setuju" required="" id="checkbox-sejutu"> <label for="checkbox-sejutu">Syarat dan ketentuan berlaku data yang diisi adalah Benar.</label>
								</div>

								<div class="col-sm-12 m-t-30">
									<center><button class="btn btn-default menu-login grey sm-default" type="button" onclick="DoStepBefore()">Sebelumnya</button> <button class="btn btn-default menu-login white" type="submit">Daftar</button></center>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@push('js')
<!--BOOTSTRAP DATEPICKER-->	
<script src="{{asset('/vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<link rel="stylesheet" href="{{asset('/vendor/crudbooster/assets/adminlte/plugins/datepicker/datepicker3.css')}}">
<!--BOOTSTRAP DATERANGEPICKER-->
<script src="{{asset('/vendor/crudbooster/assets/adminlte/plugins/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('/vendor/crudbooster/assets/adminlte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<link rel="stylesheet" href="{{asset('/vendor/crudbooster/assets/adminlte/plugins/daterangepicker/daterangepicker-bs3.css')}}">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{asset('/vendor/crudbooster/assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css')}}">  	  	
<script src="{{asset('/vendor/crudbooster/assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('js/validasi.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/additional-methods.js"></script>
<!-- list tbm ajax -->
<script type="text/javascript">
	$(function() {
		$("#kategori_spm").change(function() {
			var id = $(this).find("option:selected").attr('data-id');

			$.get("{{action('FrontController@getSpnf')}}?id_master_spm="+id,function(resp) {
				if(resp.api_message === 0){
					$("#kategori_spnf").prop('disabled', true);
					$("#form-kategori_spnf").hide();
				}else{
					$("#kategori_spnf").prop('disabled', false);
					$("#form-kategori_spnf").show();
					var opt = "<option value=''>** Pilih SPNF **</option>";
					$.each(resp,function(i,obj) {
						opt += "<option data-id="+obj.id+" value='"+obj.name+"'>"+obj.name+"</option>";
					})
					$("#kategori_spnf").html(opt);
				}

			})

			if (id == 2) {
				$("#lembaga_naungan").prop('disabled', true);
				$('#nama_lembaga_naungan').hide();
			}else{
				$("#lembaga_naungan").prop('disabled', false);
				$('#nama_lembaga_naungan').show();
			}
		})
	})
</script>
<script type="text/javascript">
  jQuery('.validatedForm').validate({
      rules: {
          "kodepos": {
              maxlength: 5
          },
          "rt": {
              maxlength: 3
          },
          "rw": {
              maxlength: 3
          },
          "password": {
              minlength: 8
          }
          
      }
  });
  $('#button-lanjut').click(function () {
  	  if ($("#provinsi").val() == '') {
  	  	swal('Data belum lengkap silahkan cek kembali');
  	  	$("#provinsi").focus();
  	  	return false
  	  }
  	  if ($("#kota").val() == '') {
  	  	swal('Data belum lengkap silahkan cek kembali');
  	  	$("#kota").focus();
  	  	return false
  	  }
  	  if ($("#kode_no_seluler").val() == '') {
  	  	swal('Data belum lengkap silahkan cek kembali');
  	  	$("#kode_no_seluler").focus();
  	  	return false
  	  }
  	  if ($("#kode_no_telepon").val() == '') {
  	  	swal('Data belum lengkap silahkan cek kembali');
  	  	$("#kode_no_telepon").focus();
  	  	return false
  	  }
      console.log($('.validatedForm').valid());
      if ($('.validatedForm').valid() == true) {
      	
      	var provinsinya = $( "#provinsi option:selected" ).val();
      	var kotanya = $( "#kota option:selected" ).val();
      	var password = $( "#password" ).val();
      	var email = $( "#email" ).val();

      	var kode_no_seluler = $( "#kode_no_seluler option:selected" ).val();
      	var kode_no_telepon = $( "#kode_no_telepon option:selected" ).val();

      	$('#hidden-kode_no_seluler').val(kode_no_seluler);
      	$('#hidden-kode_no_telepon').val(kode_no_telepon);

      	$('#hidden-prov').val(provinsinya);
      	$('#hidden-kota').val(kotanya);
      	$('#hidden-password').val(password);
      	$('#hidden-email').val(email);

      	$( "#step-1" ).clone().prependTo( "#clone" );
      	$('#step-1').hide();
		$('#step-2').show();
		document.body.scrollTop = 0;
    	document.documentElement.scrollTop = 0;
      }
  });
  function form2_onsubmit(){
    if (!EntryCheck()) return false; 

    $('#form2 :input').not(':submit').clone().hide().appendTo('#form1');

    return true;
  }
</script>
<script type="text/javascript">
	function DoStepBefore(){
		$( "#clone" ).empty();
		$('#step-1').show();
		$('#step-2').hide();
		document.body.scrollTop = 0;
    	document.documentElement.scrollTop = 0;
	}
</script>
<script type="text/javascript">
	function readURLSecond(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
          document.getElementById('foto-tbm-ktp').style.backgroundImage = "url(" + e.target.result + ")";
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script type="text/javascript">
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
          document.getElementById('foto-tbm').style.backgroundImage = "url(" + e.target.result + ")";
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script type="text/javascript">
	$(function() {		
		
		$('input[type=text]').first().not(".notfocus").focus();


		if($("#tanggal").length > 0) {
			date_time("tanggal");
		}
		
		if($(".datepicker").length > 0) {
			//$('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
			$('.datepicker').daterangepicker({					
				singleDatePicker: true,
				showDropdowns: true,
				minDate:'1945-08-17',
				format:'YYYY-MM-DD'
			})
		}

		if($(".datetimepicker").length > 0) {
			$(".datetimepicker").daterangepicker({
				singleDatePicker: true,
				showDropdowns: true,
				timePicker:true,
				timePicker12Hour: false,
				timePickerIncrement: 5,
				timePickerSeconds: true,
				autoApply: true,
				format:'YYYY-MM-DD HH:mm:ss'
			})
		}

		//Timepicker
		if($(".timepicker").length > 0) {
			$(".timepicker").timepicker({
				showInputs: true,
				showSeconds: true,
				showMeridian:false
			});	
		}

		$(document).on('click',".ajax-button",function() {
			$("body").css("cursor", "progress");
			var title = $(this).attr('title');
			show_alert_floating('Please wait while loading '+title+'...');
			var u = $(this).attr('href');
			$(this).addClass('disabled');
			$.get(u,function(resp) {
				$("body").css("cursor", "default");
				var htm = $(resp).find('#content_section').html();
				$("#content_section").html(htm);		
				hide_alert_floating();			
			});
			return false;
		})
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
<script>
	/* script */
	function initialize() {
		@if(old('latitude') && old('longitude'))
		  var latlng = new google.maps.LatLng({{old('latitude')}},{{old('longitude')}});
	    @else 
	      var latlng = new google.maps.LatLng(-7.0157404,110.4171283);
	    @endif
	    var map = new google.maps.Map(document.getElementById('map'), {
	      center: latlng,
	      zoom: 13
	    });
	    var marker = new google.maps.Marker({
	      map: map,
	      position: latlng,
	      draggable: true,
	      anchorPoint: new google.maps.Point(0, -29)
	   });
	    var input = document.getElementById('searchInput');
	    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	    var geocoder = new google.maps.Geocoder();
	    var autocomplete = new google.maps.places.Autocomplete(input);
	    autocomplete.bindTo('bounds', map);
	    var infowindow = new google.maps.InfoWindow();   
	    autocomplete.addListener('place_changed', function() {
	        infowindow.close();
	        marker.setVisible(false);
	        var place = autocomplete.getPlace();
	        if (!place.geometry) {
	            window.alert("Autocomplete's returned place contains no geometry");
	            return;
	        }
	  
	        // If the place has a geometry, then present it on a map.
	        if (place.geometry.viewport) {
	            map.fitBounds(place.geometry.viewport);
	        } else {
	            map.setCenter(place.geometry.location);
	            map.setZoom(17);
	        }
	       
	        marker.setPosition(place.geometry.location);
	        marker.setVisible(true);          
	    
	        bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
	        infowindow.setContent(place.formatted_address);
	        infowindow.open(map, marker);
	       
	    });
	    // this function will work on marker move event into map 
	    google.maps.event.addListener(marker, 'dragend', function() {
	        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
	        if (status == google.maps.GeocoderStatus.OK) {
	          if (results[0]) {        
	              bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
	              infowindow.setContent(results[0].formatted_address);
	              infowindow.open(map, marker);
	          }
	        }
	        });
	    });
	}
	function bindDataToForm(address,lat,lng){
	   document.getElementById('location').value = address;
	   document.getElementById('lat').value = lat;
	   document.getElementById('lng').value = lng;
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endpush
<!-- Modal -->
<div id="modal-register" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body custom-modal">
				<h4 class="modal-title">DAFTAR <span id="rename-register"></span></h4>
				<small>Silahkan pilih kategori TBM terlebih dahulu</small>
				<form action="{{url('register')}}" method="GET">
				<div class="form-modal">
						<div class="col-md-12">
							<div class="form-group form-group-custom">
								<label>Kategori TBM</label>
								<select class="form-control" id="kategori_spm" required="" name="kategori_spm">
									<option value="">*Select</option>
									@foreach($master_spm as $row)
									<option data-id="{{$row->id}}" value="{{$row->name}}" <?php if(Request::get('kategori_spm') == $row->name){ echo "Selected" ; } ?>>{{$row->name}}</option>
									@endforeach
								</select>
								<!-- <hr class="border border-no-padding"> -->
							</div>
							<div class="form-group form-group-custom" id="form-kategori_spnf">
								<label>Kategori SPNF</label>
								<select class="form-control" id="kategori_spnf" required="" name="kategori_spnf">
									<option value="">*Select</option>
									@foreach($master_spnf as $row)
									<option value="{{$row->name}}" <?php if(Request::get('kategori_spnf') == $row->name){ echo "Selected" ; } ?>>{{$row->name}}</option>
									@endforeach
								</select>
								<!-- <hr class="border border-no-padding"> -->
							</div>
							<div class="form-group form-group-custom" id="nama_lembaga_naungan">
								<label>Nama Lembaga Naungan</label>
								<input type="text" name="nama_lembaga_naungan" class="form-control form-control-custom" id="lembaga_naungan" value="{{Request::get('nama_lembaga_naungan')}}">
							</div>
						</div>
				</div>
				<button class="btn menu-login blue" type="submit">Lanjut</button>
				</form>

			</div>
		</div>

	</div>
</div>
@endsection