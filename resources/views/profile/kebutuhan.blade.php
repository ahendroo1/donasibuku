<div class="col-sm-8">
  <h2 class="pull-left">Kebutuhan Buku</h2>
  @if($id_tbm) @else
  <button class="btn btn-default white menu-login custom-menu menu-custom pull-right m-t-10" type="button" onclick="DoAddKebutuhan()">Tambah Kebutuhan</button>
  @endif
  <hr class="clear m-tb-0">
  @if(count($kebutuhan) == 0)
  <center>
      <div style="font-size: 50px;">Maaf </div>
      <h4>TBM yang anda pilih, untuk saat ini tidak memiliki daftar kebutuhan.</h4>
    </center>
  @endif
  @foreach($kebutuhan as $item)
  <?php $get_tbm = DB::table('tbm')->where('id',$item->id_tbm)->first(); ?>
  <div class="list-buku">
    <div class="title-buku">
      <div class="pull-left">
        <h4>{{show_value($item->id_kategori_buku,'kategori_buku','nama')}}</h4>
      </div>
      <div class="pull-right">
        @if(Session::get('ss_type_pengguna') == 'tbm')
        <div class="pull-right">
          <!-- <a href="{{url('profile/ubah-kebutuhan/'.$item->id)}}" class="btn btn-default custom-menu white">Edit</a> -->
          @if(Request::segment(1) != 'tbm')
          <!-- {{url('delete-kebutuhan/'.$item->id)}} -->
          <a href="javascript:;" class="btn btn-default custom-menu red" onclick="DoDelete({{$item->id}})">Hapus</a>
          @endif
        </div>
        @elseif(Session::get('ss_type_pengguna') == 'donatur')
        <div class="pull-right">
          <input type="hidden" name="id_tbm[]" value="{{$get_tbm->id}}" id="id_tbm-{{$get_tbm->id}}{{$item->id}}" disabled="" form="form1">
          <label class="tasks-list-item">
            <input type="checkbox" name="book_id[]" value="{{$item->id}}" class="tasks-list-cb" form="form1" id="checkbox_tbm-{{$get_tbm->id}}{{$item->id}}" onclick="DoEnable({{$get_tbm->id}},{{$item->id}})">
            <span class="tasks-list-mark"></span>
          </label>
        </div>
        @else
        <a href="javascript:;" class="btn btn-default custom-menu white" onclick="DoModalDonasi({{$item->id}})">Donasi</a>
        @endif
      </div>
    </div>
  </div>
  @endforeach
  @if(Session::get('ss_type_pengguna') != 'donatur')
  {!! urldecode(str_replace("/?","?",$kebutuhan->appends(Request::all())->render())) !!}
  @endif
  @if(Session::get('ss_type_pengguna') == 'donatur')
  @if(count($kebutuhan) > 0)
  <h3>Data Pengirim</h3>
  <form method="post" action="{{action("FrontController@postDonasiBuku")}}" enctype="multipart/form-data" id="form1">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <!-- <input type="hidden" name="id_tbm[]" value="{{ $tbm->id }}" /> -->
    <div class="form-group form-group-custom m-t-30">
      <label>Nama Pengirim : </label>
      <input type="text" name="nama_pengirim" form="form1" class="form-control form-control-custom" required="">
    </div>
    <div class="form-group form-group-custom m-t-30">
      <label>Nomor Telepon Pengirim : </label>
      <input type="number" name="no_telp_pengirim" form="form1" class="form-control form-control-custom" required="">
    </div>
    <div class="form-group form-group-custom">
      <label>Masukan Alamat Pengirim : </label>
      <input type="text" name="alamat_pengirim" form="form1" class="form-control form-control-custom" required="">
    </div>
    <div class="m-t-40">
      <button class="btn btn-default menu-login blue">Donasi</button>
    </div>
  </form>
  @endif
  @endif
</div>
<!-- Modal -->
<div id="add-kebutuhan" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <div class="modal-body-custom">
          <form method="post" action="{{action("FrontController@postAddKebutuhan")}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="col-md-12">
              <div class="form-group form-group-custom" style="margin-top: 18px;">
                <input type="hidden" name="id_tbm" value="{{Session::get('ss_tbm_id')}}">
                <label>Kategori</label>
                <select class="form-control" id="kategori" name="id_kategori_buku" required="">
                  <option value="">*Pilih Kategori</option>
                  @foreach($kategori_buku as $item)
                    <?php $check_butuh = DB::table('tbm_req')->where('id_kategori_buku',$item->id)->where('id_tbm',Session::get('ss_tbm_id'))->first(); ?>
                      @if(count($check_butuh) == 0)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                      @endif
                    @endforeach
                </select>
                <hr class="border border-no-padding  m-tb-0">
              </div>
              <button class="btn btn-default custom-menu blue" type="submit">Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>
<script type="text/javascript">
  function DoAddKebutuhan(data){
    $('#add-kebutuhan').modal('show'); 
  }
</script>
<script type="text/javascript">
  function DoModalDonasi(data){
    $('#modal-donasi').modal('show'); 
    $('#id-donasi').html(data);
  }
</script>
<!-- Modal -->
<div id="modal-donasi" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      	<div class="modal-body-custom">
          <div class="col-md-12">
            <h3>Donasi Buku</h3>
            <p>Anda perlu masuk sebagai donatur terlebih dahulu untuk melakukan Donasi Duku, lanjut masuk sebagai Donatur?</p>
            <a href="javascript:;" class="btn btn-default custom-menu white" class="close" data-dismiss="modal">Kembali</a> <a href="{{url('login')}}?segmen=donatur" class="btn btn-default custom-menu blue">Lanjut</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@push('js')
<script type="text/javascript">
  function DoEnable(id,book){
    if ($("#checkbox_tbm-"+id+book).is(':checked')){
      document.getElementById('id_tbm-'+id+book).disabled = false;
    }else{
      document.getElementById('id_tbm-'+id+book).disabled = true;
    }
  }
  function DoDelete(id){
    swal({
      title: "Perhatian",
      text: "Yakin, menghapus Kebutuhan ?",
      icon: "warning",
      // buttons: true,
      buttons : ["Tidak","Hapus"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        location.href = "{{url('delete-kebutuhan')}}/"+id;
      }
    });
  }
</script>
@endpush