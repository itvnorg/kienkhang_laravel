<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$settings['site_name']}} | {{$titlePage}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Global CSS -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Bootstrap File Input -->
  <link rel="stylesheet" href="{{asset('vendor/bootstrap-fileinput/css/fileinput.min.css')}}">
  {{Html::style('plugins/owl.carousel/owl-carousel/owl.carousel.min.css')}}
  {{Html::style('plugins/owl.carousel/owl-carousel/owl.carousel.css')}}
  {{Html::style('plugins/owl.carousel/owl-carousel/owl.theme.default.css')}}
  {{Html::style('plugins/owl.carousel/owl-carousel/owl.theme.default.min.css')}}
  {{Html::style('/plugins/wowjs/animate.css')}}

  @yield('css')
  
  {{Html::style('css/portal/layout.css')}}
  {{Html::style('css/portal/color.css')}}
  <!-- Page CSS -->
  @yield('page_css')
</head>
<body>
  @include('portal.includes.header')

  <div class="main-container">
        
    @if(Route::currentRouteName() == 'home')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="block">
                    <div class="left-menu" id="search-section">
                        <div class="title">
                            <i class="glyphicon glyphicon-th-list"></i> CÔNG CỤ TÌM KIẾM
                        </div>
                        @include('portal.includes.search_section')
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                @include('portal.includes.slide')
            </div>
        </div>
    </div>
    @endif
    @yield('content')
  </div>
  @include('portal.includes.footer')


  <!-- Global JS -->
  <!-- jQuery 3 -->
  <script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <!-- Bootstrap File Input -->
  <script src="{{asset('vendor/bootstrap-fileinput/js/fileinput.min.js')}}"></script>
  <!-- Font Awesome -->
  <script src="{{asset('bower_components/font-awesome/fontawesome-all.js')}}"></script>
  {{HTML::script('plugins/wowjs/wow.min.js')}}

  {{HTML::script('plugins/owl.carousel/owl-carousel/owl.carousel.js')}}
  {{HTML::script('plugins/owl.carousel/owl-carousel/owl.carousel.min.js')}}

  {{HTML::script('plugins/flexslider/jquery.flexslider.js')}}

  {{Html::script('js/portal/layout.js')}}

  <!-- Page JS -->
  @yield('js')
</body>
</html>