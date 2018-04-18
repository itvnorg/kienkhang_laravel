@extends('admin.master')

@section('css')
@endsection

@section('content')
<div class="col-md-12 box box-info">
	@include('admin.includes.alert_message')

	{{Form::model($data, [
		'url' => route('admin.wards.index').'/'.$data->id,
		'method' => 'PUT',
		'class' => 'form-horizontal',
		'files' => 'true'
		])
	}}
	{{Form::hidden('id',$data->id)}}
    {{Form::hidden('lat')}}
    {{Form::hidden('lng')}}
	<div class="col-md-6">
		<div class="box-body">

			<!-- BEGIN: District -->
			<div class="form-group">
				{{Form::label('district_id', 'District', ['class' => 'control-label col-sm-2 required'])}}
				<div class="col-sm-9">
					{{Form::select('district_id', $parent, null, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.district')])
						])
					}}
				</div>
			</div>
			<!-- END: District -->

			<!-- BEGIN: Name -->
			<div class="form-group">
				{{Form::label('name', trans('admin.name'), ['class' => 'control-label col-sm-2 required'])}}
				<div class="col-sm-9">
					{{Form::text('name', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.name')])
						])
					}}
				</div>
			</div>
			<!-- END: Name -->

			<!-- BEGIN: Type -->
			<div class="form-group">
				{{Form::label('type', trans('admin.type'), ['class' => 'control-label col-md-2 required'])}}
				<div class="col-md-6">
					<div class="radio">
	                	<label>
							{{Form::radio('type', WARD, true, [
								])
							}}Ward
						</label>
	              	</div>
					<div class="radio">
	                	<label>
							{{Form::radio('type', DISTRICT, NULL, [
								])
							}}District
						</label>
					</div>
				</div>
			</div>
			<!-- END: Type -->

			<!-- BEGIN: Description -->
			<div class="form-group">
				{{Form::label('description', trans('admin.description'), ['class' => 'control-label col-sm-2'])}}
				<div class="col-sm-9">
					{{Form::textarea('description', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.description')])
						])
					}}
				</div>
			</div>
			<!-- END: Description -->

			<!-- BEGIN: Index -->
			<div class="form-group">
				{{Form::label('index', trans('admin.index'), ['class' => 'control-label col-sm-2'])}}
				<div class="col-md-2 col-sm-4 col-xs-6">
					{{Form::text('index', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.index')])
						])
					}}
				</div>
			</div>
			<!-- END: Index -->

		</div>
		<!-- /.box-body -->

		<div class="box-footer">
			<a href="{{route('admin.wards.index')}}" class="btn btn-default">@lang('admin.cancle')</a>
			<button type="submit" class="btn btn-primary pull-right">@lang('admin.save')</button>
		</div>
		<!-- /.box-footer -->
	</div>
	<div class="col-md-6">
		<div class="wrap-map" style="padding:3px; border:1px solid #ddd">
          	<div id="map" style="width:100%; height:600px;"></div>
      	</div>
	</div>
</div>
@endsection

@section('js')
<!-- Google Map -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDkbVE5JeOi0aj5WBM3NOlEbC3p1V1lyMo&libraries=places&language=vi"></script>
<script src="{{asset('js/geocomplete.js')}}"></script>

<script type="text/javascript">
$(document).ready(function(){
    $(function(){

        var options = {
            map: "#map",
            location: $("input[name='name']").val(),
            markerOptions: {
                draggable: true
            }
        };

        $("input[name='name']").geocomplete(options)
            .bind("geocode:result", function(event, result){
                $("input[name=lat]").val(result.geometry.location.lat());
                $("input[name=lng]").val(result.geometry.location.lng());
            });
        $("input[name='name']").bind("geocode:dragged", function(event, latLng){
            $("input[name=lat]").val(latLng.lat());
            $("input[name=lng]").val(latLng.lng());
        });

    });
})
</script>
@endsection