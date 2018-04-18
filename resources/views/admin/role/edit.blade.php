@extends('admin.master')

@section('css')
<style type="text/css">
  img{
    max-width:180px;
  }

  .input-file{
    padding-bottom: 10px;
  }
</style>
@stop

@section('content')
	<div class="col-md-12 box box-info">
  @include('admin.includes.alert_message')

		{{Form::model($data, [
			'url' => '/admin/roles/'.$data->id,
			'method' => 'PUT',
			'class' => 'form-horizontal',
			'files' => 'true'
			])
		}}
		{{Form::hidden('id',$data->id)}}
  	<div class="box-body">

  		<!-- BEGIN: Slug -->
    	<div class="form-group">
        {{Form::label('slug', 'Slug', ['class' => 'control-label col-sm-2'])}}
          <div class="col-sm-9">
            {{Form::text('slug', NULL, [
             'class' => 'form-control',
             'placeholder' => 'Slug',
             'disabled' => 'true'
             ])
            }}
          </div>
      </div>
  		<!-- END: Slug -->

       <!-- BEGIN: Name -->
      <div class="form-group">
        {{Form::label('name', 'Name', ['class' => 'control-label col-sm-2'])}}
          <div class="col-sm-9">
            {{Form::text('name', NULL, [
             'class' => 'form-control',
             'placeholder' => 'Name',
             'disabled' => 'true'
             ])
            }}
          </div>
      </div>
      <!-- END: Name -->
      <!-- /.box-body -->
      	<div class="box-footer">
      		<a href="{{route('admin.roles.index')}}" class="btn btn-default">Cancel</a>
        	<button type="submit" class="btn btn-primary pull-right">Save</button>
      	</div>
      <!-- /.box-footer -->
  	</div>
@stop

@section('js')
<script type="text/javascript">

</script>
@stop