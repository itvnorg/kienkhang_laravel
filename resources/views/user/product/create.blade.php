@extends('user.master')

@section('css')
@endsection

@section('content')
<div class="col-md-12 box box-info">
	@include('user.includes.alert_message')

	{{Form::open([
		'url' => route('user.products.store'),
		'class' => 'form-horizontal',
		'files' => 'true'
		])
	}}
    {{Form::hidden('lat')}}
    {{Form::hidden('lng')}}
	<div class="col-md-8">
		<div class="box-body">

			<!-- BEGIN: Type -->
			<div class="form-group">
				{{Form::label('type', trans('admin.type'), ['class' => 'control-label col-md-2'])}}
				<div class="col-md-6">
					<div class="radio">
	                	<label>
							{{Form::radio('type', BUY, true, [
								])
							}}Buy
						</label>
	              	</div>
					<div class="radio">
	                	<label>
							{{Form::radio('type', SELL, NULL, [
								])
							}}Sell
						</label>
					</div>
				</div>
			</div>
			<!-- END: Type -->

			<!-- BEGIN: Photos -->
			<div class="form-group">
				{{Form::label('photo', trans('admin.image'),['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					<input id="photo" name="photo[]" type="file" class="file" multiple 
    					data-show-upload="false" data-show-caption="true" data-msg-placeholder="Select {files} for upload...">
				</div>
			</div>
			<!-- END: Photos -->

			<!-- BEGIN: Category ID -->
			<div class="form-group">
				{{Form::label('category_id', trans('admin.category'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::select('category_id', $category, null, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.category')])
						])
					}}
				</div>
			</div>
			<!-- END: Category ID -->

			<!-- BEGIN: Province ID -->
			<div class="form-group">
				{{Form::label('province_id', trans('admin.province'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::select('province_id', $province, null, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.province')])
						])
					}}
				</div>
			</div>
			<!-- END: Province ID -->

			<!-- BEGIN: District ID -->
			<div class="form-group">
				{{Form::label('district_id', trans('admin.district'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::select('district_id', $district, null, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.district')])
						])
					}}
				</div>
			</div>
			<!-- END: District ID -->

			<!-- BEGIN: Ward ID -->
			<div class="form-group">
				{{Form::label('ward_id', trans('admin.ward'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::select('ward_id', $ward, null, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.ward')])
						])
					}}
				</div>
			</div>
			<!-- END: Ward ID -->

			<!-- BEGIN: Title -->
			<div class="form-group">
				{{Form::label('title', trans('admin.title'), ['class' => 'control-label col-sm-3 required'])}}
				<div class="col-sm-9">
					{{Form::text('title', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.title')])
						])
					}}
				</div>
			</div>
			<!-- END: Title -->

			<!-- BEGIN: Address -->
			<div class="form-group">
				{{Form::label('address', trans('admin.address'), ['class' => 'control-label col-sm-3 required'])}}
				<div class="col-sm-9">
					{{Form::text('address', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.address')])
						])
					}}
				</div>
			</div>
			<!-- END: Address -->

			<!-- BEGIN: Price -->
			<div class="form-group">
				{{Form::label('price', trans('admin.price'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::text('price', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.price')])
						])
					}}
				</div>
			</div>
			<!-- END: Price -->

			<!-- BEGIN: Acreage -->
			<div class="form-group">
				{{Form::label('acreage', trans('admin.acreage'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::text('acreage', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.acreage')])
						])
					}}
				</div>
			</div>
			<!-- END: Acreage -->

			<!-- BEGIN: Rooms -->
			<div class="form-group">
				{{Form::label('rooms', trans('admin.rooms'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::text('rooms', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.rooms')])
						])
					}}
				</div>
			</div>
			<!-- END: Rooms -->

			<!-- BEGIN: Direction ID -->
			<div class="form-group">
				{{Form::label('direction_id', trans('admin.direction'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::select('direction_id', $direction, null, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.direction')])
						])
					}}
				</div>
			</div>
			<!-- END: Direction ID -->

			<!-- BEGIN: Description -->
			<div class="form-group">
				{{Form::label('description', trans('admin.description'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::textarea('description', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.description')])
						])
					}}
				</div>
			</div>
			<!-- END: Description -->

			<!-- BEGIN: Content -->
			<div class="form-group">
				{{Form::label('content', trans('admin.content'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-sm-9">
					{{Form::textarea('content', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.content')])
						])
					}}
				</div>
			</div>
			<!-- END: Content -->

		</div>
		<!-- /.box-body -->

		<div class="box-footer">
			<a href="{{route('user.products.index')}}" class="btn btn-default">@lang('admin.cancle')</a>
			<button type="submit" class="btn btn-primary pull-right">@lang('admin.save')</button>
		</div>
		<!-- /.box-footer -->
	</div>
	<div class="col-md-4">
		<div class="wrap-map" style="padding:3px; border:1px solid #ddd">
          	<div id="map" style="width:100%; height:400px;"></div>
      	</div>
	</div>
</div>
@endsection

@section('js')
<!-- Google Map -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDkbVE5JeOi0aj5WBM3NOlEbC3p1V1lyMo&libraries=places&language=vi"></script>
<script src="{{asset('js/geocomplete.js')}}"></script>
<script src="{{asset('bower_components/ckeditor/ckeditor.js')}}"></script>

<script type="text/javascript">
$(document).ready(function(){
	$(function () {
    	CKEDITOR.replace('content');
  	});
  	
    $(function(){

        var options = {
            map: "#map",
            location: $("input[name='address']").val(),
            markerOptions: {
                draggable: true
            }
        };

        $("input[name='address']").geocomplete(options)
            .bind("geocode:result", function(event, result){
                $("input[name=lat]").val(result.geometry.location.lat());
                $("input[name=lng]").val(result.geometry.location.lng());
            });
        $("input[name='address']").bind("geocode:dragged", function(event, latLng){
            $("input[name=lat]").val(latLng.lat());
            $("input[name=lng]").val(latLng.lng());
        });

    });
})
</script>
@endsection