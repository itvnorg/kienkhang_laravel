<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{asset(_upload_user.$user->avatar)}}" class="img-circle" alt="User Image">
        <div class="c-edit-user" style="position: absolute; bottom: 0;">
          <a href="{{route('user.profile.edit')}}">@lang('admin.edit_profile')</a>
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
          <li><a href="{{ route('user.products.index') }}"><i class="fa fa-list"></i>@lang('admin.products')</a></li>
          <li><a href="{{ route('user.products.create') }}"><i class="fa fa-plus"></i>@lang('admin.obj_new', ['obj' => trans('admin.product')])</a></li>
        </ul>
      </li>
      <!-- END: Products -->

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