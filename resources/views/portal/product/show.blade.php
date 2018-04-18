@extends('portal.master')

@section('content')
<div class="container detail">
	<div class="col-md-12 wrapper-content">
		<!-- BEGIN: Breadcrumb -->
		<nav aria-label="breadcrumb">
		  	<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home"></i></a></li>
			    <li class="breadcrumb-item"><a href="{{ route( 'portal.product_categories.show', [ $data->category->url_rewrite ] ) }}">{{$data->category->name}}</a></li>
			    <li class="breadcrumb-item active" aria-current="page">{{$data->title}}</li>
		  	</ol>
		</nav>
		<!-- END: Breadcrumb -->
		
		<!-- BEGIN: Main Content -->
		<div class="row">
			<!-- BEGIN: Left Content -->
			<div class="col-md-8 col-xs-12">
                <div class="box-pic">
                    <div id="gallery">
                        @foreach($data->images as $item)
                        <img alt="{{$data->url_rewrite}}" src="{{ route( 'img.resize', [ $item->photo.'?w=150&h=110&fit=crop' ] ) }}"
                             data-image="{{asset(_upload_product . $item->photo)}}"
                             data-description="{{$data->title}}">
                        @endforeach
                    </div>
                </div>

	            <div class="content">
	                <h3 class="section-title">Thông tin chi tiết:</h3>
	                {!!html_entity_decode($data->content)!!}
	            </div>

	            <div class="comments"></div>
			</div>
			<!-- END: Left Content -->

			<!-- BEGIN: Right Content -->
			<div class="col-md-4 col-xs-12">
				<h3 class="section-title">{{$data->title}}</h3>
				<div class="detail-info">
					<p><span class="char-bold">Giá:</span>{{($data->price) ? number_to_text_vn($data->price) : 'Liên hệ'}}</p>
					<p><span class="char-bold">Diện tích:</span>{{($data->acreage) ? $data->acreage : ''}}</p>
					<p><span class="char-bold">Hướng nhà:</span>{{($data->direction) ? $data->direction->name : ''}}</p>
					<p><span class="char-bold">Số phòng:</span>{{($data->rooms) ? $data->rooms : ''}}</p>
					<p><span class="char-bold">Địa chỉ:</span>{{($data->address) ? $data->address : ''}}</p>
					<p><span class="char-bold">Người đăng:</span>{{($data->post_by) ? $data->post_by->full_name : ''}}</p>
					<p><span class="char-bold">Lượt xem:</span>{{($data->views) ? $data->views : ''}}</p>
					<p><span class="char-bold">Bản đồ:</span></p>
					<div id="wrap-map" style="margin-bottom:10px;padding:5px;border:1px solid #ccc">
	                    <div id="map" style="height:260px; width:100%;"></div>
	                </div>
				</div>
				<div class="related">
					<h3 class="section-title">Các {{$data->category->name}} liên quan</h3>
					<ul class="list-group">
						@if(count($data->relates) > 0)
							@foreach($data->relates as $item)
						  		<li class="list-group-item"><a href="{{ route('portal.products.show', [$item->category->url_rewrite, $item->url_rewrite]) }}" title="{{$item->url_rewrite}}">{{$item->title}}</a></li>
						  	@endforeach
					  	@else
					  		<li class="list-group-item">Không còn tin liên quan cũ hơn</li>
					  	@endif
					</ul>					

					
				</div>
			</div>
			<!-- END: Right Content -->
		</div>
		

		<!-- END: Main Content -->
	</div>
	
</div>
@endsection

@section('js')
<!-- Unite Gallery -->
<script src="{{asset('plugins/unitegallery/js/unitegallery.min.js')}}"></script>
<script src="{{asset('plugins/unitegallery/themes/compact/ug-theme-compact.js')}}"></script>

<!-- Google Map -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDkbVE5JeOi0aj5WBM3NOlEbC3p1V1lyMo&libraries=places&language=vi"></script>
<script src="{{asset('js/geocomplete.js')}}"></script>
<script type="text/javascript">
	function initialize() {
        var lat = '{{$data->lat}}';
        var lng = '{{$data->lng}}';
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 15,
            center: myLatlng
        };

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        var contentString = "<table><tr><th>{{$data->title}}</th></tr><tr><td>Địa chỉ: {{$data->address}}</td></tr></table>";

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: '{{$data->title}}'
        });
        infowindow.open(map, marker);
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    $(document).ready(function(){
    	$("#gallery").unitegallery({
            gallery_theme: "compact",
            theme_panel_position: "bottom",
            strippanel_enable_handle: false,
            gallery_width:"100%",							//gallery width
            gallery_height:500,
            thumb_width:150,								//thumb width
            thumb_height:100
        });
    });
</script>
@endsection

@section('css')
{{Html::style('plugins/unitegallery/css/unite-gallery.css')}}
@endsection