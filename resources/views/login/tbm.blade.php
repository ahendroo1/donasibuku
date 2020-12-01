@extends('layouts')
@section('content')
<?php
	if (!empty(Request::get('segmen')) && empty(Request::get('failed'))) {
		if (Request::get('segmen') == 'tbm') {
			$tbm = 'in active';
			$donatur = '';
		}elseif(Request::get('segmen') == 'donatur'){
			$tbm = '';
			$style_regi = "style='display:block'";
			$style_logi = "style='display:none'";
			$donatur = 'in active';
		}
	}elseif (empty(Request::get('segmen')) && !empty(Request::get('failed'))) {
		if (Request::get('failed') == 'tbm') {
			$tbm = 'in active';
			$donatur = '';
		}elseif(Request::get('failed') == 'donatur'){
			$tbm = '';
			$donatur = 'in active';
		}
	}else{
		$tbm = '';
		$donatur = 'in active';
	}
	$instansi = DB::table('instansi')->get();
?>
<div class="box-container bg-login" id="box-container">
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<div class="wrapper-form ">
				  
				<div class="tab-content login ">
                    <div class="box-form">
                        <div id="login-donatur" {!!$style_logi!!}>
                            <center><h3>Masuk TBM</h3></center>
                            <form action="{{action("FrontController@postLoginTbm")}}" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                              <div class="form-group">
                                  <input type="email" class="form-control" required autocomplete="false" name="email">
                                  <label class="form-control-placeholder" for="email">Email</label>
                              </div>
                              <div class="form-group">
                                  <input type="password" id="password" class="form-control" required autocomplete="false" name="password">
                                  <label class="form-control-placeholder" for="password">Password</label>
                              </div>

                              <div class="form-group">
                                  <div class="col-md-5">
                                      <center><button type="submit" class="btn menu-login blue">Masuk</button></center>

                                  </div>
                                  <div class="col-md-2">
                                      <div class="atau">Atau</div>
                                  </div>
                                  <div class="col-md-5">
                                      <button class="btn btn-default menu-login" type="button" onclick="DoRegister('TBM')">Daftar</button>
                                  </div>
                              </div>
                            </form>
                            <div class="col-md-12 lupa-kata">
                                <center><a href="javascript:void(0);" data-toggle="modal" data-target="#modalLupaSandi">Lupa Kata Sandi?</a></center>
                            </div>
                        </div> 
                        
                        <div id="register-donatur" {!!$style_regi!!}> 
                            <center><h3>Daftar Donatur</h3></center>
                            <form method="post" action="{{action("FrontController@postRegisterDonatur")}}" class="validatedForm">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <!-- <div class="form-group">
                                    <label class="form-control-placeholder" for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required autocomplete="false">
                                </div> -->
                                <div class="form-group form-group-custom">
                                    <label>Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" required autocomplete="false">
                                </div>
                                <div class="form-group form-group-custom">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control" required autocomplete="false">
                                </div>
                                <div class="form-group form-group-custom">
                                    <label>Instansi</label>
                                    <select class="form-control border" name="instansi" id="instansi" required="">
                                        <option value="">Pilih Instansi</option>
                                        @foreach($instansi as $row)
                                            <option value="{{$row->name}}" {{($donatur->instansi == $row->name)?'selected="selected"':''}}>{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group form-group-custom">
                                    <label>Password</label>
                                    <input type="password" id="user_password" name="password" class="form-control border m-tb-0" required autocomplete="false">
                                    <p class="custom-minim">Kata Sandi minimal 8 karakter</p>
                                </div>
                                <div class="form-group form-group-custom">
                                    <label>Ulangi Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control border m-tb-0" required autocomplete="false">
                                </div>
                                <div class="m-t-10">
                                    <label>
                                        <input type="checkbox" name="confirm_data" value="1">
                                        Saya menyatakan data yang saya masukan adalah benar.!
                                    </label>
                                </div>

                                <div class="form-group m-t-30">
                                    <div class="col-md-5">
                                        <center>
                                            <button class="btn btn-login blue menu-login" type="submit" id="button-register">Daftar</button>
                                        </center>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="atau">Atau</div>
                                    </div>
                                    <div class="col-md-5">
                                        <center>
                                            <button class="btn btn-default menu-login" type="button" onclick="DoLoginDonatur()">Masuk</button>
                                        </center>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
			</div>
		</div>
	</div>
</div>
@if(Request::get('segmen') == 'tbm')
@push('js')
<script type="text/javascript">
    $(window).on('load',function(){
        $('#modal-register').modal('show');
    });
</script>
@endpush
@endif
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
									<option value="">* Pilih</option>
									@foreach($master_spm as $row)
									<option data-id="{{$row->id}}" value="{{$row->name}}">{{$row->name}}</option>
									@endforeach
								</select>
								<!-- <hr class="border border-no-padding"> -->
							</div>
							<div class="form-group form-group-custom" id="form-kategori_spnf">
								<label>Kategori SPNF</label>
								<select class="form-control" id="kategori_spnf" required="" name="kategori_spnf">
									<option value="">* Pilih</option>
									@foreach($master_spnf as $row)
									<option value="{{$row->name}}">{{$row->name}}</option>
									@endforeach
								</select>
								<!-- <hr class="border border-no-padding"> -->
							</div>
							<div class="form-group form-group-custom" id="nama_lembaga_naungan">
								<label>Nama Lembaga Naungan</label>
								<input type="text" name="nama_lembaga_naungan" class="form-control form-control-custom" id="lembaga_naungan">
							</div>
						</div>
				</div>
				<button class="btn menu-login blue" type="submit">Lanjut</button>
				</form>

			</div>
		</div>

	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalLupaSandi" tabindex="-1" role="dialog" aria-labelledby="modalLupaSandiLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form method="post" action="{{action("FrontController@postLupaSandi")}}">
		    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="modal-body-custom">

				<div class="row">
					<div class="col-md-12">
						<fieldset class="float-label">
							<input name="email" autocomplete="off" type="email" class="form-control" required />
							<label for="email">Email</label>
							<hr class="border border-no-padding m-tb-0">
						</fieldset>
					</div>
				</div>

				<div class="m-t-30">
					<input type="submit" value="KIRIM" class="btn menu-login blue">
				</div>
			</div>
		</form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalLupaSandiDon" tabindex="-1" role="dialog" aria-labelledby="modalLupaSandiDonLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form method="post" action="{{action("FrontController@postLupaSandiDon")}}">
		    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="modal-body-custom">

				<div class="row">
					<div class="col-md-12">
						<fieldset class="float-label">
							<input name="email" autocomplete="off" type="email" class="form-control" required />
							<label for="email">Email</label>
							<hr class="border border-no-padding m-tb-0">
						</fieldset>
					</div>
				</div>

				<div class="m-t-30">
					<input type="submit" value="KIRIM" class="btn menu-login blue">
				</div>
			</div>
		</form>
    </div>
  </div>
</div>
@push('js')
<script src="{{asset('js/validasi.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.11.1/additional-methods.js"></script>
<script type="text/javascript">
  jQuery('.validatedForm').validate({
      rules: {
          "password": {
              minlength: 8
          },
          "password_confirmation": {
              minlength: 8,
              equalTo : "#user_password"
          }
      }
  });
  $('#button-register').click(function () {
      console.log($('.validatedForm').valid());
  });
</script>
<script type="text/javascript">
  function DoRegister(data){
    $('#modal-register').modal('show'); 
    $('#rename-register').html(data);
  }
  $(document).ready(function(){       
    var scroll_pos = 0;
    $(document).scroll(function() { 
      scroll_pos = $(this).scrollTop();
      if(scroll_pos > 170) {
        $( "#main-menu" ).addClass( "fixed-menu wow animated slideInDown" );
        $( "#box-container" ).addClass( "m-t-100" );
      } else {
        $( "#main-menu" ).removeClass( "fixed-menu wow animated slideInDown" );
        $( "#box-container" ).removeClass( "m-t-100" );
      }
    });
  });
  function DoRegisterDonatur(){
    $('#login-donatur').hide();
    $('#register-donatur').show();
  }
  function DoLoginDonatur(){
    $('#login-donatur').show();
    $('#register-donatur').hide();
  }
</script>

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
@endpush
@endsection