@extends('portal.master')

@section('content')
<div class="container detail">
	<div class="col-md-12 wrapper-content">
		<!-- BEGIN: Breadcrumb -->
		<nav aria-label="breadcrumb">
		  	<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home"></i></a></li>
			    <li class="breadcrumb-item active" aria-current="page">{{$titlePage}}</li>
		  	</ol>
		</nav>
		<!-- END: Breadcrumb -->
		
		<!-- BEGIN: Main Content -->
		<div class="row">
			<!-- BEGIN: Left Content -->
			<div class="col-md-9 col-xs-12">
	            <div class="list-products">
	                @foreach($products as $item)
	                    @include('portal.includes.product_item')
	                @endforeach
	            </div>
	            {!! $products->appends(Input::except('page'))->render() !!}
			</div>
			<!-- END: Left Content -->

			<!-- BEGIN: Right Content -->
			<div class="col-md-3 col-xs-12">
				<div class="block">
                    <div class="left-menu" id="search-section">
                        <div class="title">
                            <i class="glyphicon glyphicon-th-list"></i> CÔNG CỤ TÌM KIẾM
                        </div>
                        @include('portal.includes.search_section')
                    </div>
                </div>
			</div>
			<!-- END: Right Content -->
		</div>
		

		<!-- END: Main Content -->
	</div>
	
</div>
@endsection

@section('js')
@endsection

@section('css')
@endsection