<div id="footer-nav-bar">
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<ul class="top-nav">
					@if(isset($menu_footer))
						@foreach($menu_footer as $item)
							<li><a href="{{$item['url']}}">{{$item['title']}}</a></li>
						@endforeach
					@endif
					<li><a href="{{route('portal.pages.contact')}}">Liên hệ</a></li>
					<div class="clearfix"></div>
				</ul>
			</div>
		</div>
	</div>
</div>
<footer class="mg-bt-20">
	<div class="container">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3 org-contact">
					<h4>Liên hệ với chúng tôi</h4>
				</div>
				<div class="col-md-6 org-info">
					<h3>{{$settings['company_name_full']}}</h3>
					<p class="line">Địa chỉ: {{$settings['company_address']}}</p>
					<p class="line">Email: {{$settings['company_email']}}</p>
					<p class="line">Hotline: {{$settings['company_hot_line']}}</p>
					<p class="line">{{$settings['site_copyright']}}</p>
				</div>
			</div>
		</div>
	</div>
</footer>