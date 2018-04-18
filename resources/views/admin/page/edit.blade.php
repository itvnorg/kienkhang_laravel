@extends('admin.master')

@section('css')
@endsection

@section('content')
<div class="col-md-12 box box-info">
	@include('admin.includes.alert_message')

	{{Form::model($data, [
		'url' => route('admin.pages.index').'/'.$data->id,
		'method' => 'PUT',
		'class' => 'form-horizontal',
		'files' => 'true'
		])
	}}
	{{Form::hidden('id',$data->id)}}
	<div class="box-body">

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

			<!-- BEGIN: Status -->
			<div class="form-group">
				{{Form::label('status', trans('admin.status'), ['class' => 'control-label col-sm-3 required'])}}
				<div class="col-md-4 col-sm-6 col-xs-12">
					{{Form::text('status', NULL, [
						'class' => 'form-control',
						'placeholder' => trans('admin.obj_input', ['obj' => trans('admin.status')])
						])
					}}
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
		<a href="{{route('admin.pages.index')}}" class="btn btn-default">@lang('admin.cancle')</a>
		<button type="submit" class="btn btn-primary pull-right">@lang('admin.save')</button>
	</div>
	<!-- /.box-footer -->
</div>
@endsection

@section('js')
<script src="{{asset('bower_components/ckeditor/ckeditor.js')}}"></script>
<script>
  $(function () {
    CKEDITOR.replace('content');
  });
</script>
@endsection