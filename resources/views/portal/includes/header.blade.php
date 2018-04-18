<header>
	<div class="container">
		<div class="row">
			<div class="col-md-2 col-sm-3 col-xs-4 left-content">
				<div class="row">
					<div class="col-md-12 logo"><a href="{{route('home')}}"><img src="{{asset(_upload_image).'/'.$settings['site_logo']}}" class="img-responsive"></a></div>
				</div>
			</div>
			<div class="col-md-10 col-sm-9 col-xs-8 right-content">
				<div class="first">
					<p class="line"><i class="far fa-user"></i>{{$settings['admin_name']}}</p>
					<p class="line"><i class="far fa-envelope"></i>{{$settings['admin_email']}}</p>
					<p class="line"><i class="fa fa-phone"></i>{{$settings['admin_phone']}}</p>
				</div>
				<div class="second clearfix">
					<ul class="top-nav">
						<li><a href="{{route('home')}}">Trang chủ</a></li>
						<li><a href="{{route('portal.pages.show', [ 'url_rewrite' => 'gioi-thieu'])}}">Giới thiệu</a></li>
						<li><a href="{{route('portal.pages.contact')}}">Liên hệ</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</header>
<div id="nav-bar">
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<ul class="top-nav">
					@if(isset($menu_header))
						@foreach($menu_header as $item)
							@if(isset($item['sub_item']))
							<li><a href="{{$item['url']}}">{{$item['title']}}</a>
								<ul class="sub-menu">
								@foreach($item['sub_item'] as $sub_item)
									@if(isset($sub_item['sub_item']))
									<li><a href="{{$sub_item['url']}}">{{$sub_item['title']}}</a>
										<span class="pull-right"><i class="fas fa-angle-right"></i></span>
										<ul class="sub-menu-level-2">
										@foreach($sub_item['sub_item'] as $sub_item_2)
											<li><a href="{{$sub_item_2['url']}}">{{$sub_item_2['title']}}</a></li>
										@endforeach
										</ul>
									@else
									<li><a href="{{$sub_item['url']}}">{{$sub_item['title']}}</a>
									@endif
									</li>
								@endforeach
								</ul>
							@else
							<li><a href="{{$item['url']}}">{{$item['title']}}</a>
							@endif
							</li>
						@endforeach
					@endif
					<div class="clearfix"></div>
				</ul>
			</div>
		</div>
	</div>
</div>