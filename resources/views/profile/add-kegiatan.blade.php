<div class="col-sm-8">
	<h2 class="pull-left">Kegiatan TBM</h2>
	<hr class="clear">
	<form method="post" action="{{action("FrontController@postAddKegiatan")}}" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}" />
		<div class="m-t-40">
			<div class="form-group form-group-custom">
				<label>Nama Kegiatan</label>
				<input name="title" class="form-control form-control-custom" autocomplete="off" type="text"  required />
			</div>
			<div class="m-t-30">
				<div class="form-group form-group-custom">
					<label for="no_telp">Foto Kegiatan  | <span class="danger">Maksimal ukuran gambar 2Mb</span> </label>
					<label class="file-upload" id="foto-tbm" style="">
						<div class="center-text-file-upload" style="padding-top:20%"><i class="fas fa-camera fa-3x fa-camera-custom"></i><br><small class="img-upload">Unggah Foto</small></div>
						<input type="file" name="image" id="image" class="hidden" onchange="readURL(this);">
					</label>
				</div>
			</div>
			<div class="m-t-30">
				<div class="form-group form-group-custom">
					<label for="no_telp">Keterangan Kegiatan</label>
					<textarea name="content" id="editor1" rows="10" cols="80"></textarea>
				</div>
			</div>
			<div class="m-t-30">
		    	<a href="{{url('profile/kegiatan')}}" class="btn-default menu-login grey sm-default">Kembali</a>
		    	<button class="btn btn-default menu-login white" type="submit">Simpan</button>
		    </div>
		</div>
	</form>
</div>
@push('js')
<script src="https://cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script type="text/javascript">
	function readURL(input) {
		var FileSize = input.files[0].size / 1024 / 1024; // in MB
        if (FileSize > 2) {
            swal('Gambar maksimal 2 MB');
           $(input).val(''); //for clearing with Jquery
        } else {
        	if (input.files && input.files[0]) {
	            var reader = new FileReader();

	            reader.onload = function (e) {
	          document.getElementById('foto-tbm').style.backgroundImage = "url(" + e.target.result + ")";
	            };

	            reader.readAsDataURL(input.files[0]);
	        }
        }
    }
</script>
<script type="text/javascript">
	// Replace the <textarea id="editor1"> with a CKEditor
	// instance, using default configuration.
	CKEDITOR.editorConfig = function (config) {
	    config.language = 'en';
	    config.uiColor = '#F7B42C';
	    config.height = 300;
	    config.toolbarCanCollapse = true;

	};
	CKEDITOR.replace('editor1');
</script>
@endpush