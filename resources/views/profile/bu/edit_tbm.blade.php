@include('header')
<!--BOOTSTRAP DATEPICKER-->	
<script src="{{asset('/vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<link rel="stylesheet" href="{{asset('/vendor/crudbooster/assets/adminlte/plugins/datepicker/datepicker3.css')}}">
<!--BOOTSTRAP DATERANGEPICKER-->
<script src="http://crocodic.net/indiscub/public/vendor/crudbooster/assets/adminlte/plugins/daterangepicker/moment.min.js"></script>
<script src="http://crocodic.net/indiscub/public/vendor/crudbooster/assets/adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" href="http://crocodic.net/indiscub/public/vendor/crudbooster/assets/adminlte/plugins/daterangepicker/daterangepicker-bs3.css">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="http://crocodic.net/indiscub/public/vendor/crudbooster/assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">  	  	
<script src="http://crocodic.net/indiscub/public/vendor/crudbooster/assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>

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
<div class="wrapper-on-page">
	<div class="container">
		<div class="wrapper">
			<div class="edit-profile-form">
				<div class="title">
					<div class="title-bg">EDIT PROFILE</div>
				</div>

				<div class="form">
					<form id="formEditTBM" action="{{action("FrontController@postUpdateTbm")}}" method="post" enctype="multipart/form-data">	
		      			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

						<div class="wrap-detail">
							<div class="row">
								<div class="col-md-9">
									@if ( Session::get('message') != '' )
										<div class='alert alert-warning mt-20'>
											{{ Session::get('message') }}
										</div>	
									@endif
								</div>
								<div class="col-md-3">
									<div class="image">
										<img src="{{asset($tbm->image)}}">
									</div>								     
	      							<div class="input-group wrapper-input-file">
						                <label>
						                    <span>
						                        Ubah Foto
						                    </span>
						                    <input type="file" name="image" id="image" multiple>
						                </label>
						            </div>
								</div>
							</div>

			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Nama Lembaga</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="text" name="nama" id="nama" placeholder="Nama Lembaga" class="form-control" value="{{$tbm->nama}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Email</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="email" readonly="readonly" name="email" id="email" placeholder="Email" class="form-control" value="{{$tbm->email}}" />
			      				</div>
			      			</div>
			      			<?php 
								$range_year = range(date('Y')-50,date('Y')+10);
			      			?>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Tahun Berdiri</label>
			      				</div>
			      				<div class="col-md-4">
			      					<select name="tahun_berdiri" id="tahun_berdiri" class="form-control" >
			      						@foreach($range_year as $item)
			      							<option value="{{$item}}" <?php echo ($item == $tbm->tahun_berdiri)?'selected="selected"':''?>>{{$item}}</option>
			      						@endforeach
			      					</select>
			      				</div>
			      				<div class="col-md-2">
			      					<label>No Ijin Oprasional</label>
			      				</div>
			      				<div class="col-md-4">
			      					<input type="text" name="no_izin" id="no_izin" placeholder="No Ijin Oprasional" class="form-control" value="{{$tbm->no_izin}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Provinsi</label>
			      				</div>
			      				<div class="col-md-4">
			      					<!-- <input type="text" name="provinsi" id="provinsi" placeholder="Provinsi" class="form-control" value="{{$tbm->provinsi}}" /> -->
			      					<select class="form-control" name="provinsi" onchange="ajakKota(this.value)">
		      							<option value="">Pilih Provinsi</option>
			      						@foreach($propinsi as $item)
		      								<option value="{{$item->id}}" {{($item->id == $tbm->provinsi)?'selected="selected"':''}}>{{$item->propinsi}}</option>
			      						@endforeach
			      					</select>
			      				</div>
			      				<div class="col-md-2">
			      					<label>Kab / Kota</label>
			      				</div>
			      				<div class="col-md-4">
			      					<!-- <input type="text" name="kota" id="kota" placeholder="Kab / Kota" class="form-control" value="{{$tbm->kota}}" /> -->
			      					<select class="form-control" name="kota" id="kota">
		      							<option value="{{$tbm->kota}}">{{show_value($tbm->kota,'kabupaten','kabupaten')}}</option>
			      					</select>
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Alamat</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="text" name="alamat" id="alamat" placeholder="alamat" class="form-control" value="{{$tbm->alamat}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Kode Pos</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="text" name="kodepos" id="kodepos" placeholder="Kode Pos" class="form-control" value="{{$tbm->kodepos}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>No Telepon</label>
			      				</div>
			      				<div class="col-md-4">
			      					<input type="text" name="tlpn" id="tlpn" placeholder="No Telepon" class="form-control" value="{{$tbm->tlpn}}" />
			      				</div>
			      				<div class="col-md-2">
			      					<label>No Handphone</label>
			      				</div>
			      				<div class="col-md-4">
			      					<input type="text" name="no_hp" id="no_hp" placeholder="No Handphone" class="form-control" value="{{$tbm->no_hp}}" />
			      				</div>
			      			</div>
						</div>
		      			<div class="wrap-pengelola">
		      				<div class="legend-pengelola">
			      				<div class="title">PENGELOLA</div>
			      				<div class="border-tbm">
			      					<span></span>
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Nama Ketua Lembaga</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="text" name="nama_ketua" id="nama_ketua" placeholder="Nama Ketua Pengelola" class="form-control" value="{{$tbm->nama_ketua}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Tempat Lahir</label>
			      				</div>
			      				<div class="col-md-4">
			      					<input type="text" name="tempat_lahir_pengelola" id="tempat_lahir_pengelola" placeholder="Tempat Lahir" class="form-control" value="{{$tbm->tempat_lahir_pengelola}}" />
			      				</div>
			      				<div class="col-md-2">
			      					<label>Tanggal Lahir</label>
			      				</div>
			      				<div class="col-md-4">
			      					<div class="input-group">
										<span class="input-group-addon"><i class='fa fa-calendar'></i></span>
										<input type='text' class='form-control notfocus datepicker' name="tanggal_lahir_pengelola" id="tanggal_lahir_pengelola" value='{{$tbm->tanggal_lahir_pengelola}}'/>
									</div>
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Alamat</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="text" name="alamat_pengelola" id="alamat_pengelola" placeholder="Alamat" class="form-control" value="{{$tbm->alamat_pengelola}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
		      						<label>No Handphone</label>
			      				</div>
			      				<div class="col-md-4">
			      					<input type="text" name="tlpn_pengelola" id="tlpn_pengelola" placeholder="No Telepon" class="form-control" value="{{$tbm->tlpn_pengelola}}" />
			      				</div>
			      				<div class="col-md-2">
			      					<label>Kode Pos</label>
			      				</div>
			      				<div class="col-md-4">
			      					<input type="text" name="kodepos_pengelola" id="kodepos_pengelola" placeholder="Kode Pos" class="form-control" value="{{$tbm->kodepos}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Email</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="email" name="email_pengelola" id="email_pengelola" placeholder="Email" class="form-control" value="{{$tbm->email_pengelola}}" />
			      				</div>
			      			</div>
			      			<div class="row hidden">
			      				<div class="col-md-2">
			      					<label>Dokumen Penunjang TBM</label>
			      					<div id="btnAddDok">
			      						<button type="button" onClick="addDokumen(1)">Tambah Dokumen</button>
			      					</div>
			      				</div>
			      				<div class="col-md-10">
		      						<div id="dokumenPenunjang" class="row">
		      							@foreach($dokumen as $item)
										<div class="col-md-4 item">
											<?php 

												$extension = asset($item->upload);
												$extension = pathinfo($extension);
												$extension = $extension['extension'];
												$array_extImage = array("png", "jpg", "jpeg", "gif","tiff","PNG", "JPG", "JPEG", "GIF","TIFF");

											?>
											@if(in_array($extension, $array_extImage))
												<div class="wrap-upload">
													<div class="upload">
														<img src="{{asset($item->upload)}}">
													</div>
												</div>
												<div class="caption">
													<a href="{{url('/delete-tbm-dokumen/'.$item->id)}}">Hapus</a>
												</div>
											@else
												<div class="upload file p-5">
													{{substr($item->upload, 48)}}
												</div>
												<div class="caption">
													<a href="{{url('/delete-tbm-dokumen/'.$item->id)}}">Hapus</a>
												</div>
											@endif
										</div>
										@endforeach
			      						<div class="col-md-4 item">
			      							<div class="input-group wrapper-input-file">
								                <label>
								                    <span>
								                        UPLOAD FILE 
								                    </span>
								                    <input type="file" name="upload[]" id="upload" multiple>
								                </label>
								            </div>
			      						</div>
			      					</div>
			      				</div>
			      			</div>

			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Foto KTP Pengelola</label>
			      				</div>
			      				<div class="col-md-10"> 
									<div class="row">
										<div class="col-md-4">
					      					<div class="wrap-upload">
												<div class="upload">
													<?php $foto_ktp = DB::table('tbm_dokumen')->where('id_tbm',$tbm->id)->where('desc','KTP Pengelola')->first(); ?>
													<img src="{{asset($foto_ktp->upload)}}">
												</div>
											</div>     
			      							<div class="mt-10 input-group wrapper-input-file">
								                <label>
								                    <span>
								                        UPLOAD FILE 
								                    </span>
								                    <input type="file" name="image_ktp_pengelola" id="image_ktp_pengelola" multiple>
								                </label>
								            </div>							            
										</div>
									</div>
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Ijin Oprasional</label>
			      				</div>
			      				<div class="col-md-10"> 
									<div class="row">
										<div class="col-md-4">
					      					<div class="wrap-upload">
												<div class="upload">
													<?php $foto_ktp = DB::table('tbm_dokumen')->where('id_tbm',$tbm->id)->where('desc','Izin Oprasional')->first(); ?>
													<img src="{{asset($foto_ktp->upload)}}">
												</div>
											</div>     
			      							<div class="mt-10 input-group wrapper-input-file">
								                <label>
								                    <span>
								                        UPLOAD FILE 
								                    </span>
								                    <input type="file" name="image_izin_oprasional" id="image_izin_oprasional" multiple>
								                </label>
								            </div>							            
										</div>
									</div>
			      				</div>
			      			</div>

		      			</div>
		      			<div class="wrap-map">
		      				<div class="legend-pengelola">
			      				<div class="title">Lokasi</div>
			      				<div class="border-tbm">
			      					<span></span>
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-12">
			      					<!-- map here -->

								    <div class="map">
								    	<style>

									      #map {
									        height: 300px;
									      }
									      .controls {
									        margin-top: 10px;
									        border: 1px solid transparent;
									        border-radius: 2px 0 0 2px;
									        box-sizing: border-box;
									        -moz-box-sizing: border-box;
									        height: 32px;
									        outline: none;
									        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
									      }

									      #pac-input {
									        background-color: #fff;
									        font-family: Roboto;
									        font-size: 15px;
									        font-weight: 300;
									        margin-left: 12px;
									        padding: 0 11px 0 13px;
									        text-overflow: ellipsis;
									        width: 300px;
									      }

									      #pac-input:focus {
									        border-color: #4d90fe;
									      }

									      .pac-container {
									        font-family: Roboto;
									      }

									      #type-selector {
									        color: #fff;
									        background-color: #4d90fe;
									        padding: 5px 11px 0px 11px;
									      }

									      #type-selector label {
									        font-family: Roboto;
									        font-size: 13px;
									        font-weight: 300;
									      }
									    </style>
				                		<div class='form-group peta header-group-0 '>
											<input id="pac-input" class="controls" autofocus type="text"
										        placeholder="Enter a location">
										    <div id="map"></div>
										</div>
				                		<script type="text/javascript">
				                		  var geocoder;
									      function initMap() {
									      	geocoder = new google.maps.Geocoder();
									        var map = new google.maps.Map(document.getElementById('map'), {
									          @if($tbm->latitude && $tbm->longitude)
									          center: {lat: {{$tbm->latitude}}, lng: {{$tbm->longitude}} },
									          @else 
									          center: {lat: -7.0157404, lng: 110.4171283},
									          @endif
									          zoom: 15
									        });

									        @if($tbm->latitude && $tbm->longitude)
									        var marker = new google.maps.Marker({
									          position: {lat: {{$tbm->latitude}}, lng: {{$tbm->longitude}} },
									          map: map,
									          title: 'Location Here !'
									        });
									        @endif
									        
									        var input = /** @type    {!HTMLInputElement} */(
									            document.getElementById('pac-input'));

									        var types = document.getElementById('type-selector');
									        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
									        map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

									        var autocomplete = new google.maps.places.Autocomplete(input);
									        autocomplete.bindTo('bounds', map);

									        var infowindow = new google.maps.InfoWindow();
									        var marker = new google.maps.Marker({
									          map: map,
									          draggable:true,
									          anchorPoint: new google.maps.Point(0, -29)
									        });

									        google.maps.event.addListener(marker, 'dragend', function(marker){
									        	

									        	  geocoder.geocode({
												    latLng: marker.latLng
												  }, function(responses) {
												    if (responses && responses.length > 0) {
												      address = responses[0].formatted_address;
												    } else {
												      address = 'Cannot determine address at this location.';
												    }

												    
													console.log(address);

												    infowindow.setContent(address);
												    // infowindow.open(map, marker);
												  });

										        var latLng = marker.latLng; 
										        latitude = latLng.lat();
										        longitude = latLng.lng();
										        						          
										        $("input[name=latitude]").val(latitude);
										        $("input[name=longitude]").val(longitude);								          						          	
										     });

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
									            map.setZoom(17);  // Why 17? Because it looks good.
									          }
									          // marker.setIcon(/** @type    {google.maps.Icon} */({
									          //   url: 'http://maps.google.com/mapfiles/ms/icons/red.png',
									          //   size: new google.maps.Size(71, 71),
									          //   origin: new google.maps.Point(0, 0),
									          //   anchor: new google.maps.Point(17, 34),
									          //   scaledSize: new google.maps.Size(35, 35)
									          // }));
									          marker.setPosition(place.geometry.location);
									          marker.setVisible(true);

									          var address = '';
									          if (place.address_components) {
									            address = [
									              (place.address_components[0] && place.address_components[0].short_name || ''),
									              (place.address_components[1] && place.address_components[1].short_name || ''),
									              (place.address_components[2] && place.address_components[2].short_name || '')
									            ].join(' ');
									          }

									          var latitude = place.geometry.location.lat();
											  var longitude = place.geometry.location.lng(); 

											  					          
									          $("input[name=latitude]").val(latitude);
									          $("input[name=longitude]").val(longitude);

									          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
									          infowindow.open(map, marker);
									        });

									        function setupClickListener(id, types) {
									          var radioButton = document.getElementById(id);
									          radioButton.addEventListener('click', function() {
									            autocomplete.setTypes(types);
									          });
									        }

									        setupClickListener('changetype-all', []);
									        setupClickListener('changetype-address', ['address']);
									        setupClickListener('changetype-establishment', ['establishment']);
									        setupClickListener('changetype-geocode', ['geocode']);
									      }
									    </script>		        					    
									    <script src="https://maps.googleapis.com/maps/api/js?key={{get_setting('google_api_key')}}&libraries=places&callback=initMap"
							        async defer></script>            		
				                		<input type='hidden' name="latitude" value="{{$tbm->latitude}}"/>
										<input type='hidden' name="longitude" value="{{$tbm->longitude}}"/>
								    </div>
			      				</div>
			      			</div>
		      			</div>
		      			<div class="wrap-sandi">
		      				<div class="legend-pengelola">
			      				<div class="title">Ubah Sandi</div>
			      				<div class="border-tbm">
			      					<span></span>
			      				</div>
			      				<p class="tbm-help">Bila tidak merubah kata sandi harap kosongi semua fill di bawah</p>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Sandi Lama</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="password" name="old_password" id="old_password" placeholder="Sandi Lama" class="form-control" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Sandi Baru</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="password" name="new_password" id="new_password" placeholder="Sandi Baru" class="form-control"  />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Konfirmasi Sandi Baru</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="password" name="conf_password" id="conf_password" placeholder="Konfirmasi Sandi Baru" class="form-control"/>
			      				</div>
			      			</div>
		      			</div>
	      				<div class="border-tbm">
	      					<span></span>
	      				</div>
	      				<div class="ta-center">
	      					<input type="submit" value="Update Profile" class="tbm-btn" />
	      				</div>
		      		</form>
				</div>
			</div>
		</div>
	</div>
</div>



<script type="text/javascript">
	

		function addDokumen(no){
			var number    = 1;
			var container = document.getElementById("dokumenPenunjang");
            for (i=0;i<number;i++){

                var collegediv = document.getElementById('dokumenPenunjang');


			    var coloumn = document.createElement('div');
			        coloumn.setAttribute('class','col-md-4 item');
			        coloumn.setAttribute('id','upload'+no);

			    var input_group = document.createElement('div');
			        input_group.setAttribute('class','input-group wrapper-input-file');

			    var label = document.createElement('label');
			    var span = document.createElement('span');

			    var txt = document.createTextNode("UPLOAD FILE");

			    var dokumen = document.createElement('input');
			        dokumen.type = 'file';
			        dokumen.setAttribute('name', 'upload[]');
			        dokumen.setAttribute('id','uploadTxt'+no);	
			        dokumen.setAttribute('multiple','');

			    //  Attach elements
			    span.appendChild( txt );
			    label.appendChild( span );
			    label.appendChild( dokumen );
			    input_group.appendChild( label );
			    coloumn.appendChild( input_group );	  


			    var deleteBtn = document.createElement('a');
			        deleteBtn.setAttribute('onClick', 'deleteUpload('+no+')');
			        deleteBtn.setAttribute('href', 'javascript:void(0);');
			        deleteBtn.setAttribute('id', 'btnDell-'+no);
			    var txtDel = document.createTextNode("Hapus");

			    deleteBtn.appendChild( txtDel );	  
			    coloumn.appendChild( deleteBtn );	  

			   
			    collegediv.appendChild( coloumn );

			    var noPlusOne = no + 1;

			    document.getElementById('btnAddDok').innerHTML = '<button type="button" onClick="addDokumen('+noPlusOne+')">Tambah Dokumen</button>';
            }
        }

        function deleteUpload(no){
        	document.getElementById("upload"+no).remove();
        }
</script>
@include('footer')