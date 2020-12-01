<div class="col-sm-8">
  <h2>Riwayat Donasi</h2>
  <hr class="clear">
  <div class="box-donasi">


    @foreach($donasi as $item)
    @if($item->id=="")
    <p>Tidak ada riwayat donasi</p>
    
    @else
    
    <?php $link = url('detail/'.$item->id) ?>
    <a href="{{$link}}">
      <div class="list-buku">
        <div class="title-buku">
          <div class="pull-left">
            <h4>No Donasi : {{$item->no_donasi}}</h4>
          </div>
          <div class="pull-right">
            <p class="f-grey"><small>{{date('d M Y',strtotime($item->tgl_donasi))}}</small></p>
          </div>
        </div>
        <p>Status : {{$item->status}}</p>
        @if(Session::get('ss_tbm_id') == $item->id_tbm && $item->status != 'Donasi Belum Lengkap')
          <?php $check_konf = DB::table('konfirmasi_donasi')->where('id_donasi',$item->id)->first() ?>
          @if($check_konf)
          <a href="javascript:;" class="btn btn-default white btn-block menu-custom">Sudah Dikonfirmasi</a>
          @else
          <a href="{{url('profile/konfirmasi-pembayaran/'.$item->id)}}" class="btn btn-default white btn-block menu-custom">Konfirmasi Pembayaran</a>
          @endif
        @endif
      </div>
    </a>
    @endif
    @endforeach
   
     <center>@include('pagination.default', ['paginator' => $donasi])</center>
  </div>
</div>