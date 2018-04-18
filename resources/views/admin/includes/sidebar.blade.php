<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{asset(_upload_user.$user->avatar)}}" class="img-circle" alt="User Image">
        <div class="c-edit-user" style="position: absolute; bottom: 0;">
          <a href="{{route('admin.profile.edit')}}">@lang('admin.edit_profile')</a>
        </div>
      </div>
      <div class="pull-left info" style="padding-top: 15px;">
        <p>{{$user->first_name .' '. $user->last_name}}</p>
        <!-- Status -->
        <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <!-- Optionally, you can add icons to the links -->

      <!-- BEGIN: Products -->
      <li class="treeview">
        <a href="#"><i class="fa fa-product-hunt"></i> <span>@lang('admin.products')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.products.index') }}"><i class="fa fa-list"></i>@lang('admin.products')</a></li>
          <li><a href="{{ route('admin.products.create') }}"><i class="fa fa-plus"></i>@lang('admin.obj_new', ['obj' => trans('admin.product')])</a></li>
          <li><a href="{{ route('admin.product_categories.index') }}"><i class="fa fa-list"></i>@lang('admin.obj_cat', ['obj' => trans('admin.product')])</a></li>
        </ul>
      </li>
      <!-- END: Products -->

      <!-- BEGIN: Locations -->
      <li class="treeview">
        <a href="#"><i class="fa fa-map-marker"></i> <span>@lang('admin.locations')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.provinces.index') }}"><i class="fa fa-list"></i>@lang('admin.provinces')</a></li>
          <li><a href="{{ route('admin.districts.index') }}"><i class="fa fa-list"></i>@lang('admin.districts')</a></li>
          <li><a href="{{ route('admin.wards.index') }}"><i class="fa fa-list"></i>@lang('admin.wards')</a></li>
        </ul>
      </li>
      <!-- END: Locations -->

      <!-- BEGIN: News -->
      <li class="treeview">
        <a href="#"><i class="fa fa-newspaper-o"></i> <span>@lang('admin.news')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.news.index') }}"><i class="fa fa-list"></i>@lang('admin.news')</a></li>
          <li><a href="{{ route('admin.news.create') }}"><i class="fa fa-plus"></i>@lang('admin.obj_new', ['obj' => trans('admin.news')])</a></li>
          <li><a href="{{ route('admin.news_categories.index') }}"><i class="fa fa-list"></i>@lang('admin.obj_cat', ['obj' => trans('admin.news')])</a></li>
        </ul>
      </li>
      <!-- END: News -->

      <!-- BEGIN: Pages -->
      <li class="treeview">
        <a href="#"><i class="fa fa-file"></i> <span>@lang('admin.pages')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.pages.index') }}"><i class="fa fa-list"></i>@lang('admin.pages')</a></li>
          <li><a href="{{ route('admin.pages.create') }}"><i class="fa fa-plus"></i>@lang('admin.obj_new', ['obj' => trans('admin.page')])</a></li>
        </ul>
      </li>
      <!-- END: Pages -->

      <!-- BEGIN: Files -->
      <li class="treeview">
        <a href="#"><i class="fa fa-file"></i> <span>@lang('admin.files')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.files.index') }}"><i class="fa fa-list"></i>@lang('admin.files')</a></li>
          <li><a href="{{ route('admin.files.create') }}"><i class="fa fa-plus"></i>@lang('admin.obj_new', ['obj' => trans('admin.file')])</a></li>
          <li><a href="{{ route('admin.file_categories.index') }}"><i class="fa fa-list"></i>@lang('admin.obj_cat', ['obj' => trans('admin.file')])</a></li>
        </ul>
      </li>
      <!-- END: Files -->

      <!-- BEGIN: Account -->
      <li class="treeview">
        <a href="#"><i class="fa fa-user"></i> <span>@lang('admin.account')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.users.index') }}">@lang('admin.users')</a></li>
          <li><a href="{{ route('admin.users.create') }}">@lang('admin.obj_new', ['obj' => trans('admin.users')])</a></li>
          <li><a href="{{ route('admin.roles.index') }}">@lang('admin.roles')</a></li>
        </ul>
      </li>
      <!-- END: Account -->

      <!-- BEGIN: Others -->
      <li class="treeview">
        <a href="#"><i class="fa fa-list"></i> <span>@lang('admin.others')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.directions.index') }}"><i class="fa fa-arrows-alt"></i>@lang('admin.directions')</a></li>
        </ul>
      </li>
      <!-- END: Others -->

      <!-- BEGIN: Settings -->
      <li class="treeview">
        <a href="#"><i class="fa fa-cogs"></i> <span>@lang('admin.configuration')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ route('admin.settings.index') }}"><i class="fa fa-cogs"></i>@lang('admin.system')</a></li>
        </ul>
      </li>
      <!-- END: Settings -->

      <li class="c-logout">
        <a href="{{route('logout')}}">
          <i class="fa fa-sign-out"></i> <span>@lang('admin.log_out')</span>
        </a>
      </li>

    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>