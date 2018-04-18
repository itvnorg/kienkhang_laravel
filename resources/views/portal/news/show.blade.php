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
			<!-- BEGIN: Content -->
			<div class="col-md-12">

	            <div class="content">
	                {!!html_entity_decode($data->content)!!}
	            </div>

				@if(count($data->relates) > 0)
				<div class="related">
					<h3 class="section-title">Các {{$data->category->name}} liên quan</h3>
					<ul class="list-group">
						@foreach($data->relates as $item)
					  		<li class="list-group-item"><a href="{{ route('portal.news.show', [$item->category->url_rewrite, $item->url_rewrite]) }}" title="{{$item->url_rewrite}}">{{$item->title}}</a></li>
					  	@endforeach
					</ul>				
				</div>
			  	@endif	

			</div>
			<!-- END: Content -->
		</div>
		

		<!-- END: Main Content -->
	</div>
	
</div>
@endsection

@section('js')
@endsection

@section('css')
@endsection