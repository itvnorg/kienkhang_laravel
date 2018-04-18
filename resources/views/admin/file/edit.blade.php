@extends('admin.master')

@section('css')
@endsection

@section('content')
<div class="col-md-12 box box-info">
	@include('admin.includes.alert_message')

	{{Form::model($data, [
		'url' => route('admin.files.index').'/'.$data->id,
		'method' => 'PUT',
		'class' => 'form-horizontal',
		'files' => 'true'
		])
	}}
	{{Form::hidden('id',$data->id)}}
    {{Form::hidden('lat')}}
    {{Form::hidden('lng')}}
	<div class="box-body">

	      	<!-- BEGIN: File Type -->
	      	<div class="form-group">
		        {{Form::label('file_type', trans('admin.file_type'), ['class' => 'control-label col-sm-3'])}}
		        <div class="col-md-9">
	          		{{Form::select('file_type', $file_type, null, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.file_type')])
						])
	           		}}
	        	</div>
	      	</div>
	      	<!-- END: File Type -->

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

	      	<!-- BEGIN: File -->
	      	<div class="form-group">
	        	{{Form::label('file', trans('admin.file'), ['class' => 'control-label col-sm-3'])}}
	      		<div class="col-sm-9">
            		<label>{{$data->file_name}}</label>
	        		<input type='file' class="input-file" name="file" />
	      		</div>
	  		</div>
	      	<!-- END: File -->

			<!-- BEGIN: Status -->
			<div class="form-group">
				{{Form::label('status', trans('admin.status'), ['class' => 'control-label col-sm-3 required'])}}
				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="radio">
                  		<label>
				            {{Form::radio('status', ACTIVE, true, [
				              ])
				            }}Active
          				</label>
                	</div>
        			<div class="radio">
                  		<label>
				            {{Form::radio('status', INACTIVE, NULL, [
				              ])
				            }}In Active
          				</label>
        			</div>
				</div>
			</div>
			<!-- END: Status -->

			<!-- BEGIN: Index -->
			<div class="form-group">
				{{Form::label('index', trans('admin.index'), ['class' => 'control-label col-sm-3'])}}
				<div class="col-md-4 col-sm-6 col-xs-12">
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
		<a href="{{route('admin.files.index')}}" class="btn btn-default">@lang('admin.cancle')</a>
		<button type="submit" class="btn btn-primary pull-right">@lang('admin.save')</button>
	</div>
	<!-- /.box-footer -->
</div>
@endsection

@section('js')
@endsection