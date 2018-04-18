@extends('admin.master')

@section('css')
@endsection

@section('content')
<div class="col-md-12 box box-info">
	@include('admin.includes.alert_message')

	{{Form::open([
		'url' => route('admin.news.store'),
		'class' => 'form-horizontal',
		'files' => 'true'
		])
	}}
	<div class="box-body">

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

		<!-- BEGIN: Photos -->
		<div class="form-group">
			{{Form::label('photo', trans('admin.image'),['class' => 'control-label col-sm-3'])}}
			<div class="col-sm-9">
	            <input type='file' accept="image/*" class="input-file" name="photo" onchange="readURL(this);" />
	            <img id="image" src="" alt="@lang('admin.obj_photo', ['obj' => trans('admin.news')])" />
			</div>
		</div>
		<!-- END: Photos -->

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

		<!-- BEGIN: Status -->
		<div class="form-group">
			{{Form::label('status', trans('admin.status'), ['class' => 'control-label col-sm-3 required'])}}
			<div class="col-md-4 col-sm-6 col-xs-12">
				{{Form::select('status', $status, null, [
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
		<a href="{{route('admin.news.index')}}" class="btn btn-default">@lang('admin.cancle')</a>
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
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#image').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection