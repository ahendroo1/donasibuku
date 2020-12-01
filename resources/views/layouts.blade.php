<?php 
  $twitter = get_setting('twitter');
  $google_plus = get_setting('google-plus');
  $youtube = get_setting('youtube');
  $instagram = get_setting('instagram');
  $facebook = get_setting('facebook');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="{{$description}}"">
  <meta name="author" content="{{get_setting('appname')}}">
  <link rel="icon" href="">
  <meta name="keywords" content="{{$keywords}}">
  <meta name="copyright" content="&copy;Coyright {{get_setting('appname')}}" />
  <link href="{{asset(get_setting('favicon'))}}" rel="shortcut icon">

  <title>{{$page_title}}</title>

  <!-- Bootstrap core CSS -->
  <link href="{{asset('assets/dist/css/bootstrap.min.css')}}" rel="stylesheet"> 
  {{-- <link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'> --}}
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places"></script>
  <!-- own css -->
  <link href="{{asset('sandbox.css')}}" rel="stylesheet">
  
  <link href="{{asset('assets/dist/css/drawer.css')}}" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" /> 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"  />
 
  <link rel="stylesheet" href="{{asset('assets/css/end.css')}}">
  
  @stack('css')

<!-- Global site tag (gtag.js) - Google Analytics -->
{{-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-173380783-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-173380783-1');
</script> --}}
 


</head>

<body class="drawer drawer--left drawer--navbarTopGutter ">

 <!-- Static navbar -->
 {{-- <nav class="navbar navbar-default navbar-custom-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="no-telp"><a ><i class="fas fa-phone icon-custom"></i><span class="text-for-icon no-telp"> {{get_setting('no-telepon')}}</span></a></li>
        <li ><a ><i class="fas fa-mobile-alt icon-custom"></i><span class="text-for-icon no-telp"> 085711855885</span></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{$facebook}}" target="_blank"><i class="fab fa-facebook icon-custom facebook-bg"></i></a></li>
        <li><a href="{{$twitter}}" target="_blank"><i class="fab fa-twitter icon-custom twitter-bg"></i></a></li>
        <li><a href="{{$youtube}}" target="_blank"><i class="fab fa-youtube icon-custom google-bg"></i></a></li>
        <li><a href="{{$instagram}}" target="_blank"><i class="fab fa-instagram icon-custom instagram-bg"></i></a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div><!--/.container -->
</nav> --}}

<div class="top-menu" id="main-menu">
 <div class="container">
  <div class="row">
   <div class="col-xs-3"><a href="{{url('')}}"><img src="{{asset('assets/icon/ic_logo_header.png')}}" width="80px" class="img-responsive logo-header"></a></div>
   <div class="col-xs-9">
    <ul class="nav navbar-nav m-t-20">
        
     <li class="menu-nav"><a href="{{url('/tentang')}}">Tentang Kami <div class="menu-line {{($active=='tentang')?'active':''}}"></div></a></li>
     <li class="menu-nav"><a href="{{url('/tentangtbm')}}">Tentang TBM <div class="menu-line {{($active=='tentangtbm')?'active':''}}"></div></a></li>
     <li class="menu-nav"><a href="{{url('/donatur')}}">Donatur <div class="menu-line {{($active=='donatur')?'active':''}}"></div></a></li>
     <li class="menu-nav"><a href="{{url('/artikel')}}">Berita <div class="menu-line {{($active=='article')?'active':''}}"></div></a></li>
     {{-- <li class="menu-nav"><a href="{{url('/tbm')}}">Daftar TBM <div class="menu-line {{($active=='tbm')?'active':''}}"></div></a></li> --}}
     <li class="menu-nav"><a href="{{url('/fli2020')}}">FLI 2020 <div class="menu-line {{($active=='fli2020')?'active':''}}"></div></a></li>

   </ul>
   <div class="nav navbar-nav navbar-right m-t-10 " id="myNavbar">
    @if(Session::get('ss_type_pengguna'))
      <a href="{{url('/profile')}}" class="btn btn-default menu-login blue">Profile</a> 
    @else
      <a href="{{url('login/donatur')}}" class="btn btn-end-primary">Masuk</a>
    @endif 
   </div>
 </div>
</div>
</div>
</div>

<header class="drawer-navbar drawer-navbar--fixed" role="banner" id="mobile-menu">
  <div class="drawer-container ">
    <div class="drawer-navbar-header p-l-40">

      @if(Session::get('ss_type_pengguna'))
        <a href="{{url('/profile')}}" class="login-floating btn btn-end-primary">Profil</a>
      @else
        <a href="{{url('/login')}}" class="login-floating btn btn-end-primary">Masuk</a>
      @endif

      <a class="drawer-brand" href="{{url('')}}"><img src="{{asset('assets/icon/ic_logo_header.png')}}" class="img-responsive"></a>
      <button type="button" class="drawer-toggle drawer-hamburger">
        <span class="sr-only">toggle navigation</span>
        <span class="drawer-hamburger-icon"></span>
      </button>
    </div>

    <nav class="drawer-nav" role="navigation">
      <ul class="drawer-menu">
        <li><a class="drawer-menu-item" href="{{url('/tentang')}}">Tentang Kami <div class="menu-line {{($active=='tentang')?'active':''}}"></div></a></li>
        <li><a class="drawer-menu-item" href="{{url('/tentangtbm')}}">Tentang TBM <div class="menu-line {{($active=='tentangtbm')?'active':''}}"></div></a></li>
        <li><a class="drawer-menu-item" href="{{url('/donatur')}}">Donatur <div class="menu-line {{($active=='donatur')?'active':''}}"></div></a></li>
        <li><a class="drawer-menu-item" href="{{url('/artikel')}}">Berita <div class="menu-line {{($active=='article')?'active':''}}"></div></a></li>
        <li><a class="drawer-menu-item" href="{{url('/fli2020')}}">FLI 2020 <div class="menu-line {{($active=='fli2020')?'active':''}}"></div></a></li>
      </ul>
    </nav>

  </div>
</header>

<!-- content -->
@yield('content')
<?php $footer = DB::table('link_terkait')->orderby('id','desc')->get(); ?>
<div class="clear"></div>
<div class="footer m-t-40">	
 <div class="container">
    <div class="content-footer">
       <div class="col-md-5">
        <div class="title-footer"><h3>Link Terkait</h3></div>
        <div class="col-sm-12"><li><a href="{{url('https://www.kemdikbud.go.id/')}}">Kemdikbud</a></li></div>
        <div class="col-sm-12"><li><a href="{{url('https://pmpk.kemdikbud.go.id/')}}">Direktorat PMPK</a></li></div>
        <div class="col-sm-12"><li><a href="{{url('https://paud-dikmas.kemdikbud.go.id/')}}">Direktorat PAUD, Dikdas dan Dikmen</a></li></div>
        <div class="col-sm-12"><li><a href="{{url('http://forumtbm.or.id/')}}">Forum TBM</a></li></div>
        <div class="col-sm-12"><li><a href="{{url('/artikel')}}">Berita Terkini</a></li></div>
      </div>
      <div class="col-md-3">
        <div class="title-footer"><h3>BANTUAN</h3></div>
        <div class="row">
          <div class="col-sm-12"><li><a href="{{url('page/cara-daftar')}}">CARA DAFTAR</a></li></div>
          <div class="col-sm-12"><li><a href="{{url('page/cara-menambahkan-kebutuhan-buku')}}">CARA MENAMBAHKAN KEBUTUHAN BUKU</a></li></div>
          <div class="col-sm-12"><li><a href="{{url('unduh')}}">UNDUH DOKUMEN PENGEMBANGAN BUDAYA BACA</a></li></div>
        </div>
      </div>
      <div class="col-md-4 kontak-kami">
        <div class="title-footer"><h3>Kontak kami</h3></div>
        <form method="post" action="{{action("FrontController@postSendEmail")}}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <div class="form-group">
            <label for="pesan" class="m-l-10">Email</label>
            <input name="email" autocomplete="off" type="email" class="form-control" required />
            <hr class="border border-no-padding m-tb-0">
          </div>
          <fieldset class="form-group m-t-30">
            <label for="pesan" class="m-l-10">Pesan</label>
            <textarea class="form-control" rows="3" name="pesan" required=""></textarea>
            <hr class="border border-no-padding m-tb-0">
          </fieldset>
          <div class="form-group">
            <button class="btn menu-login blue">Kirim</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


  <!-- footer -->
  <div class="footer-login">
    <div class="col-sm-4"><span class="text-footer-login hidden">Hotline : {{get_setting('no-telepon')}}</span></div>
    <div class="col-sm-4"><span class="icon-footer-login"><a href="{{$facebook}}" target="_blank"><i class="fab fa-facebook icon-custom facebook-bg"></i></a></span>
        <span class="icon-footer-login"><a href="{{$twitter}}" target="_blank"><i class="fab fa-twitter icon-custom twitter-bg"></i></a></span>
        <span class="icon-footer-login"><a href="{{$youtube}}" target="_blank"><i class="fab fa-youtube icon-custom google-bg"></i></a></span>
        <span class="icon-footer-login"><a href="{{$instagram}}" target="_blank"><i class="fab fa-instagram icon-custom instagram-bg"></i></a></span>
    </div>
    <div class="col-sm-4 ">
      <span class="text-footer-login"><i class="fas fa-mobile-alt icon-custom"></i> donasibuku@kemdikbud.go.id </span>
    </div>
  </div>

  <!-- Modal -->
  <div id="modal-register" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body custom-modal">
          <h4 class="modal-title">DAFTAR <span id="rename-register"></span></h4>
          <small>Silahkan pilih kategori TBM terlebih dahulu</small>
          <div class="form-modal">
            <div class="col-md-12">
              <div class="form-group form-group-custom">
                <label>Kategori</label>
                <select class="form-control" id="kategori">
                  <option value="">*Select</option>
                  <option value="TBM">TBM</option>
                </select>
                <hr class="border border-no-padding">
              </div>
              <div class="form-group form-group-custom">
                <label>Kategori SPM</label>
                <select class="form-control" id="kategori">
                  <option value="">*Select</option>
                  <option value="TBM">TBM</option>
                </select>
                <hr class="border border-no-padding">
              </div>
              <div class="form-group form-group-custom">
                <label>Kategori SPNF</label>
                <select class="form-control" id="kategori">
                  <option value="">*Select</option>
                  <option value="TBM">TBM</option>
                </select>
                <hr class="border border-no-padding">
              </div>
            </div>
          </div>

          <button class="btn menu-login blue">Lanjut</button>

        </div>
      </div>

    </div>
  </div>



    <!-- Bootstrap core JavaScript
      ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{asset('assets/js/vendor/jquery.min.js')}}"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iScroll/5.2.0/iscroll.js"></script>
    <script src="{{asset('assets/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/drawer.min.js')}}" charset="utf-8"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('js/wow.js')}}"></script>
    <script>
      $(document).ready(function(){       
        var scroll_pos = 0;
        $(document).scroll(function() { 
          scroll_pos = $(this).scrollTop();
          if(scroll_pos > 155) {
            $( "#main-menu" ).addClass( "fixed-menu wow animated slideInDown" );
            $( "#box-container" ).addClass("m-t-100");
          } else {
            $( "#main-menu" ).removeClass( "fixed-menu wow animated slideInDown" );
            $( "#box-container" ).removeClass("m-t-100");
          }
        });
      });

      $(document).ready(function() {
        $('.drawer').drawer();
      });
      wow = new WOW({
        animateClass: 'animated',
        offset:       100,
        callback:     function(box) {
          // console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
        }
      });
      wow.init();
    </script>
 

    @if ( Session::get('message') != '' )
      <script type="text/javascript">
        swal("{!! Session::get('message') !!}");
      </script>
    @endif
    @stack('js')
</body>
</html>
