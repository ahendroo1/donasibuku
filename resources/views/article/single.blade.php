@extends('layouts')
@section('content')
<!-- content -->
<?php
  $url_post = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div class="bg-white m-t-90">
  <div class="box-container" id="box-container">
     

    <div class="container">
      <div class="col-sm-7">
        <div class="list-berita-page">
          <h3>{{$artikel->title}}</h3>
          @foreach($kategori as $row)
                <?php $kategori_single = DB::Table('master_kategori')->where('id',$row->id_master_kategori)->first(); ?>
                <a class=" btn btn-end-primary" style="padding:5px 10px; font-size:10px;margin:10px 0px;" href="{{url('artikel')}}?kategori={{$kategori_single->id}}">{{$kategori_single->name}}</a>
               <!--  class="btn btn-default custom-menu bg-white" -->
          @endforeach
           <br>
          <small class="small"> <i class="fa fa-calendar" style="padding-right:10px;"></i> {{date('d M Y',strtotime($artikel->created_at))}}</small> 
          <div class="berita-img" style="background-image: url('{{asset($artikel->image)}}');">
            <div class="category-berita">
              
            </div>
          </div>
          <br>
         
         
          <p>{!! $artikel->content !!}</p>
          <div class="m-t-20">
            <h4 class="m-b-20">Bagikan :</h4>

              <a href="javascript:;" class="btn btn-circle shadow" style="padding:20px 25px;margin-right:10px"><i class="fab fa-facebook "></i></a> 
              <a href="javascript:;" class="btn btn-circle shadow text-info" style="padding:20px 25px;margin-right:10px"><i class="fab fa-twitter  "></i></a> 
              <a href="javascript:;" class="btn btn-circle shadow text-danger" style="padding:20px 25px;margin-right:10px"><i class="fab fa-google-plus-g  "></i></a> 
            
          </div>

          <div class="box-next-prev">
            @if($prev > 0)
            <div class="next-prev prev pull-left">
              <div class="title-next-prev">
                <a href="{{url('artikel/'.$prev->slug)}}">
                  Sebelumnya
                  <h4>{{$prev->title}}</h4>
                </a>
              </div>
            </div>
            @endif
            @if($next > 0)
            <div class="next-prev next pull-right">
              <div class="title-next-prev">
                <a href="{{url('artikel/'.$next->slug)}}">
                  Selanjutnya
                  <h4>{{$next->title}}</h4>
                </a>
              </div>
            </div>
            @endif
            <div class="clear"></div>
          </div>
        </div>
      </div>
      <div class="col-sm-4 col-md-offset-1">
        <div class="sidebar">
          <form method="get" action="{{url('artikel')}}">
            <div class="group-search">
              <input type="text" name="q" class="form-control radius" placeholder="Ketik Kemudian Enter" value="{{Request::get('q')}}">
              <i class="fas fa-search icon-search"></i>
            </div>
          </form>
          @include('sidebar_detail')
        </div>
      </div>
    </div>
  </div>
</div>

@push('js')
<script type="text/javascript">
  // Facebook Share
  $('#facebook-share').click(function () {
      url = location.href;
      title = '{{$url_post}}';
      window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(url) + '&t=' + encodeURIComponent(title), 'sharer', 'toolbar=0,status=0,width=626,height=436');
  });
</script>
<script type="text/javascript">
  // google Share
  $('#google-share').click(function () {
      url = location.href;
      title = '{{$url_post}}';
      window.open('https://plus.google.com/share?url=' + encodeURIComponent(url) + '&t=' + encodeURIComponent(title), 'sharer', 'toolbar=0,status=0,width=626,height=436');
  });
</script>
<script type="text/javascript">
  // twitter Share
  $('#twitter-share').click(function () {
      url = location.href;
      title = '{{$url_post}}';
      window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(url) + '&t=' + encodeURIComponent(title), 'sharer', 'toolbar=0,status=0,width=626,height=436');
  });
</script>

@endpush
@endsection