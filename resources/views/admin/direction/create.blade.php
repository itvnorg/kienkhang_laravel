@extends('admin.master')

@section('css')
@endsection

@section('content')
<div class="col-md-12 box box-info">
	@include('admin.includes.alert_message')

	{{Form::open([
		'url' => route('admin.directions.store'),
		'class' => 'form-horizontal',
		'files' => 'true'
		])
	}}
	<div class="box-body">

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
		<a href="{{route('admin.directions.index')}}" class="btn btn-default">@lang('admin.cancle')</a>
		<button type="submit" class="btn btn-primary pull-right">@lang('admin.save')</button>
	</div>
	<!-- /.box-footer -->
</div>
@endsection

@section('js')
@endsection