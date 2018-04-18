@extends('portal.master')
@section('content')
<div class="container mg-bt-20">
    <div class="col-md-12 wrapper-content">
		<div class="row" style="margin-top: 20px">
			<div class="col-md-9" id="products">
		        <div class="row box-posts clearfix">
		            <div class="tt">
		                <span class="line">Nhà đất bán</span>
		            </div>
		            <div class="content" style="border: 1px solid #ccc; padding:10px">
		                @foreach($products as $item)
		                    @include('portal.includes.product_item')
		                @endforeach
		            </div>
		        </div>
		    </div>
            <div class="col-md-3">
                <div class="clearfix">
                    <div class="col-md-12 apply-mail">
                        <p class="line">Đăng ký nhận tin nóng, tin mới đến email của bạn</p>
                        <p class="line"><i class="far fa-envelope"></i></p>
                        <div class="group-input">
                            <input type="text" name="email">
                            <button class="btn btn-default">Đăng ký</button>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<div class="" style="background: url('{{asset('images/bg-da.png')}}') no-repeat center;background-size: cover">
    <div class="container">
        <div class="center-tt" style="color:#fff">MUA BÁN NỔI BẬT<span class="l-bt"></span></div>
        <div class="clearfix list-brands list-center owl-carousel owl-theme">
            @foreach($hot_products as $item)
            <div class="item">
                <a href="{{ route('portal.products.show', [$item->category->url_rewrite, $item->url_rewrite]) }}" title="{{$item->url_rewrite}}">
                    <div class="b-img">
                        <img src="{{ route( 'img.resize', [ $item->photo->photo.'?w=360&h=262&fit=crop' ] ) }}" class="img-responsive" onerror="imgError(this);" />
                    </div>
                    <h3>{{$item->title}}</h3>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection