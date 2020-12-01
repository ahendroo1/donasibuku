<div class="col-sm-8">
  <h2>Pemberitahuan</h2>
  <hr class="clear">
  <div class="box-donasi">
    @if(count($pemberitahuan) == 0)
    <center>
        <div style="font-size: 50px;">Maaf </div>
        <h4>Anda tidak memiliki pemberitahuan saat ini.</h4>
      </center>
    @endif
    @foreach($pemberitahuan as $item)
      <?php
        if ($item->type_info == 1) {
          $get_donasi_item = DB::table('donasi_item')->where('id',$item->content)->first();
          $get_donatur = DB::table('donatur')->where('id',$item->id_donatur)->first(); 
          $kategori = DB::table('kategori_buku')->where('id',$get_donasi_item->id_kategori_buku)->first(); 
        }else{
          $get_donasi = DB::table('donasi')->where('id',$item->id_donasi)->first();
        }
        $get_command = DB::table('tbm_notice')->where('type_info',2)->where('id_donasi',$item->id_donasi)->orderby('id','desc')->take(1)->get();
      ?>
      @if($item->type_info == 1)
      <div class="list-buku">
          <div class="title-buku">
            <div class="pull-left">
              <h4>No Donasi : {{$item->no_donasi}}</h4>
            </div>
            <div class="pull-right">
              <a href="{{url('profile/ubah-kebutuhan/'.$get_donasi_item->id)}}?page={{g('page')}}" class="btn btn-default custom-menu white">Tambah judul buku</a>
            </div>
          </div>
          <table class="table table-no-border">
            <tr>
              <td style="width: 180px;">Kategori</td>
              <td>: {{$kategori->nama}}</td>
            </tr>
            <tr>
              <td>Donatur</td>
              <td>: {{$get_donatur->nama}}</td>
            </tr>
            @foreach($get_command as $row)
            <tr>
              <td>Komentar dari Donatur</td>
              <td>: <span style="color: #ef442e;">{{$row->content}}</span></td>
            </tr>
            @endforeach
          </table>
      </div>
      @endif
    @endforeach
    <center>@include('pagination.default', ['paginator' => $pemberitahuan])</center>
  </div>
</div>