@extends('admin.master')

@section('css')
@stop

@section('content')

	<div class="col-md-12 box box-info">
  	@include('admin.includes.alert_message')

		{{Form::model($data, [
			'url' => route('admin.settings.update'),
			'method' => 'PUT',
			'class' => 'form-horizontal',
			'files' => 'true'
			])
		}}
    {{Form::hidden('lat')}}
    {{Form::hidden('lng')}}
		  <div class="col-md-6">
        @foreach($data as $k => $v)

            <div class="form-group">

                <label for="{{$v->key}}" class="control-label col-md-3">{{$v->name}}</label>

                <div class="col-md-9">
                    @if($v->data_type == 'html')
                        <textarea name="{{$v->key}}" class="form-control ckeditor" rows="6">{{$v->value}}</textarea>
                    @elseif($v->data_type == 'json')
                    	<textarea name="{{$v->key}}" class="form-control" rows="6">{{$v->value}}</textarea>
                    @else
                        <input type="text" name="{{$v->key}}" value="{{$v->value}}" class="form-control"/>
                    @endif
                </div>

            </div><!-- end row-->

        @endforeach
     	<!-- /.box-body -->
      	<div class="box-footer">
        	<button type="submit" class="btn btn-primary pull-right">@lang('admin.update', ['name' => trans('admin.setting')])</button>
      	</div>
      	<!-- /.box-footer -->
      </div>

      <div class="col-md-6">
          <div class="wrap-map" style="padding:3px; border:1px solid #ddd">
              <div id="map" style="width:100%; height:600px;"></div>
          </div>
      </div>
	</div>
@stop

@section('js')
<!-- CK Editor -->
<script src="{{asset('bower_components/ckeditor/ckeditor.js')}}"></script>
<!-- Google Map -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDkbVE5JeOi0aj5WBM3NOlEbC3p1V1lyMo&libraries=places&language=vi"></script>
<script src="{{asset('js/geocomplete.js')}}"></script>

<script type="text/javascript">
$(document).ready(function(){
    $(function(){

        var options = {
            map: "#map",
            location: $("input[name='company_address']").val(),
            markerOptions: {
                draggable: true
            }
        };

        $("input[name='company_address']").geocomplete(options)
                .bind("geocode:result", function(event, result){
                    $("input[name=lat]").val(result.geometry.location.lat());
                    $("input[name=lng]").val(result.geometry.location.lng());
                });
        $("input[name='company_address']").bind("geocode:dragged", function(event, latLng){
            $("input[name=lat]").val(latLng.lat());
            $("input[name=lng]").val(latLng.lng());
        });

    });
})
</script>

@stop