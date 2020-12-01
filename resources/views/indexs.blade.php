@extends('layouts')
@section('content')
<?php 
  $get_first = DB::Table('slider')->orderby('id','desc')->first(); 
  $i = 0;
?> 
<div class="bg-white"> 

  <div class="box-container" id="box-container">
    <div class="headline-end owl-carousel owl-theme ">
      @foreach ($slider as $item)

        <div class="headline-end-item item" style="background-image:url('{{ $item->image }}');"> 
          {{-- <div class="rounded" style="background-image:url(https://any.ge/assets/images/favicon-32x32.png);"></div>
          <span>Content<span>  --}}
        </div>

        {{-- @if($item->id == $get_first->id)
        @else
        @endif --}}
      @endforeach
    </div>

    <div class="container m-t-20">
      @foreach($artikel_terkini as $item)
          <div class="col-lg-4 m-t-20">
            <a href="{{url('artikel/'.$item->slug)}}" class="text-muted" style="text-decoration:none"> 
              <div class="card">
                <img src="{{asset($item->image)}}" alt="{{str_limit($item->title,30)}}"  >
                <div class="content">
                  <h4><b>{{str_limit($item->title,30)}}</b></h4> 
                  <small>{{date('d M Y',strtotime($item->created_at))}}</small>
                  <p>{{str_limit(strip_tags($item->content),62)}} Baca Selengkapnya <i class="fa fa-arrow-circle-right p-t-10"></i></p> 
                </div>
              </div>
            </a>
          </div> 
        @endforeach
    </div>
  </div>
  
  <div class="container m-t-40">
    <img src="{{asset('img/mekanisme-donasi.png')}}" alt="" width="100%">
  </div>

  <div class="container m-t-40">
    <img src="{{asset('img/mekanisme-tbm.png')}}" alt="" width="100%">
    <div class="m-t-20">
      <div class="col-lg-6 text-center">
        <a href="{{url('#')}}"><button class="btn btn-default menu-login yellow">Daftar sebagai TBM</button></a>
      </div>
      <div class="col-lg-6 text-center">
        <a href="{{url('#')}}"><button class="btn btn-default menu-login yellow">Daftar sebagai Donatur</button></a>
      </div>
    </div>
  </div>

  <div class="container m-t-40"> 

    <div class="col-lg-6 m-t-40">
      <div class="overlays">
        <img   src="https://images.unsplash.com/photo-1593642634367-d91a135587b5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80" class="overlays-d" >
        <div class="text">
          <h3>Tentang Donasi Buku</h3>
          <p class="text-daftar">Donasi buku adalah sebuah program untuk mempertemukan para donator dengan pengelola Taman Bacaan Masyarakat (TBM). Program donasi buku hadir dalam format aplikasi donasibuku.kemdikbud.go.id  dan laman donasibuku.kemdikbud.go.id serta akun media sosial donasibuku.kemdikbud. 
          </p>
          <br><a href="{{url('tentangdonasi')}}"><button class="btn btn-default menu-login yellow">Lihat Selengkapnya</button></a>
        </div>
      </div>
    </div>
     
    <div class="col-lg-6 m-b-40 m-t-40" >
      <div class="overlays">
        <img src="https://images.unsplash.com/photo-1593642634367-d91a135587b5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80" class="overlays-d" >
        <div class="text">
          <h3>Tentang Direktorat PMPK</h3>
          <p class="text-daftar">Direktorat Pendidikan Masyarakat dan Pendidikan Khusus merupakan unit organisasi Direktorat Jenderal Pendidikan Anak Usia Dini, Pendidikan Dasar,dan Pendidikan Menengah </p>
          <br><a href="{{url('tentangpmpk')}}"><button class="btn btn-default menu-login yellow">Lihat Selengkapnya</button></a>
        </div>
      </div>
    </div>
  </div>
  
   

 
</div>
@push('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"  ></script> 
<script type="text/javascript">
  $('.owl-carousel').owlCarousel({ 
    center: true,
    items:1,
    loop:true,
    margin:15,
	  stagePadding: 40,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:false
  });
</script>

<script>
$(document).ready(function(){
  // Add scrollspy to <body>
  $('body').scrollspy({target: ".navbar", offset: 50});   

  // Add smooth scrolling on all links inside the navbar
  $("#myNavbar a").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top-100
      }, 800, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    }  // End if
  });

  $("#register-menu a").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top-100
      }, 800, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    }  // End if
  });
});
</script>
@endpush
@endsection