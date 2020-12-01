<?php 
  $new_article   = DB::table('artikel')->orderBy('id','DESC')->take(7)->get();
  $toko_buku = DB::table('toko_buku')->orderBy('id','DESC')->take(4)->get();
  $list_kategori = DB::table('master_kategori')->orderBy('name','asc')->get();
?>

<div class="box-side-berita">
  <h4>BERITA TERBARU</h4>
  <div class="center-line"></div>
  @foreach($new_article as $item)
  <a href="{{url('artikel/'.$item->slug)}}">
    <div class="side-berita">
      <div class="row">
        <div class="col-xs-5"><img src="{{asset($item->image)}}?w=125&h=110" class="img-responsive"></div>
        <div class="col-xs-7"><h5>{{str_limit($item->title,50)}}</h5><small>{{date('d M Y',strtotime($item->created_at))}}</small></div>
      </div>
    </div>
  </a>
  @endforeach
</div>
<div class="box-side-berita">
  <h4>KATEGORI</h4>
  <div class="center-line"></div> 
    <a href="{{url('artikel')}}" class="btn btn-end-primary btn-sm m-t-10">SEMUA KATEGORI</a>
    @foreach($list_kategori as $row)
    <a href="{{url('artikel')}}?kategori={{$row->id}}" class="btn btn-end-primary btn-sm m-t-10">{{$row->name}}</a> 
    @endforeach 
</div>