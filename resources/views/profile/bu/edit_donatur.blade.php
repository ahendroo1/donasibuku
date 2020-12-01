@include('header')
<div class="wrapper-on-page">
	<div class="container">
		<div class="wrapper">
			<div class="edit-profile-form">
				<div class="title">
					<div class="title-bg">EDIT PROFILE</div>
				</div>

				<div class="form">
					<form id="formEditTBM" action="{{action("FrontController@postUpdateDonatur")}}" method="post" enctype="multipart/form-data">	
		      			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

		      			<div class="wrap-detail mt-100">
							<div class="row">
								<div class="col-md-12">
									@if ( Session::get('message') != '' )
										<div class='alert alert-warning'>
											{{ Session::get('message') }}
										</div>	
									@endif
								</div>
							</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Nama</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="text" name="nama" id="nama" placeholder="Nama" class="form-control" value="{{$donatur->nama}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Instansi</label>
			      				</div>
			      				<div class="col-md-10">
			      					<select name="instansi" id="instansi" class="form-control">
			      						<option value="">Pilih Instansi</option>
			      						<option value="Perusahaan" {{($donatur->instansi == 'Perusahaan')?'selected="selected"':''}}>Perusahaan</option>
			      						<option value="Lembaga" {{($donatur->instansi == 'Lembaga')?'selected="selected"':''}}>Lembaga</option>
			      						<option value="Perorangan" {{($donatur->instansi == 'Perorangan')?'selected="selected"':''}}>Perorangan</option>
			      					</select>
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Alamat</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="text" name="alamat" id="alamat" placeholder="Alamat" class="form-control" value="{{$donatur->alamat}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>No Telepon</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="text" name="tlpn" id="tlpn" placeholder="No Telepon" class="form-control" value="{{$donatur->tlpn}}" />
			      				</div>
			      			</div>
			      			<div class="row">
			      				<div class="col-md-2">
			      					<label>Email</label>
			      				</div>
			      				<div class="col-md-10">
			      					<input type="email" readonly="readonly" id="email" placeholder="email" class="form-control" value="{{$donatur->email}}" />
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