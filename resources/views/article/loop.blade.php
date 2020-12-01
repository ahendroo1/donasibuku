@extends('layouts')
@section('content')
<!-- content -->
<div class="bg-white">
  <div class="box-container" id="box-container">
    <div class="title-content">
      @if(empty(Request::get('q')))
      <h1>Berita</h1>
      @else
      <h1>Pencarian : <small>" {{Request::get('q')}} "</small></h1>
      @endif
      <div class="center-line"></div>
    </div>
    
    <div class="container">
      <div class="col-lg-8">
        @include('sidebar')
      </div>
      <div class="col-lg-4">
        
        <h4>Pencarian</h4>
        <form method="get" action="{{url('artikel')}}">
          <div class="group-search">
            <input type="text" name="q" class="form-control radius" placeholder="Cari" value="{{Request::get('q')}}">
            <i class="fas fa-search icon-search"></i>
          </div>
        </form>
      </div>

      <div class="col-sm-12">
        @if(count($artikel) == 0)
        <center>
          <div style="font-size: 50px;">Maaf </div>
          <h4>Artikel yang anda maksud tidak ditemukan.</h4>
        </center>
        @endif
        @foreach($artikel as $item)
        <div class="col-lg-6">

          <?php $get_kategori = DB::Table('kategori_artikel')->where('id_artikel',$item->id)->get(); ?>
          <div class="list-berita" onclick="window.location='{{url('artikel/'.$item->slug)}}'">
            <div class="berita-img" style="background-image: url('{{asset($item->image)}}');">
              <div class="category-berita">
              
              </div>
            </div>
            <br>
              @foreach($get_kategori as $row)
                <?php $kategori_single = DB::Table('master_kategori')->where('id',$row->id_master_kategori)->first(); ?>
                <a class="kategori-label" href="{{url('artikel')}}?kategori={{$kategori_single->id}}">{{$kategori_single->name}}</a>
              @endforeach
            <h3>{{$item->title}}</h3>
            <small class="small">{{date('d M Y',strtotime($item->created_at))}}</small><br><br>
            <!-- <p>{!!str_replace("<em>","",str_limit($item->content,100))!!}</p> -->
            <a href="{{url('artikel/'.$item->slug)}}" class="btn btn-default custom-menu white">Selengkapnya</a>
          </div>
        </div>
        @endforeach
        <center>@include('pagination.default', ['paginator' => $artikel])</center> 
         
      </div>
     
    </div>
  </div>
</div>
@endsection

@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"  ></script> 
<script type="text/javascript">
  $('.owl-carousel').owlCarousel({ 
    center: true,
    items:1,
    loop:true,
    margin:15,
	  stagePadding: 40,
  });
</script>
@endpush

