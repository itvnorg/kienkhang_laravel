@extends('portal.master')

@section('content')
<div class="container detail">
	<div class="col-md-12 wrapper-content">
		<!-- BEGIN: Breadcrumb -->
		<nav aria-label="breadcrumb">
		  	<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home"></i></a></li>
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