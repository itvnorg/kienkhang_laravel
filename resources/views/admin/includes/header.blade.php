<header class="main-header">

  <!-- Logo -->
  <a href="#" class="logo">
    @if($settings['site_is_use_logo'] == TRUE)
    <span class="logo-mini"><img src="{{ $settings['site_logo_mobile'] }}"></span>
    <span class="logo-lg"><img src="{{ $settings['site_logo'] }}"></span>
    @else
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>{{$settings["site_name_mobile"]}}</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>{{$settings["site_name_short"]}}</b></span>
    @endif
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="c-section-title text-center" style="height: 50px;">
      <h3 style="margin: 0; color: #FFF; line-height: 50px;">{{$titlePage}}</h3>
    </div>
  </nav>
</header>