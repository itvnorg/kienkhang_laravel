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
			'url' => '/admin/users/'.$data->id,
			'method' => 'PUT',
			'class' => 'form-horizontal',
			'files' => 'true'
			])
		}}
		{{Form::hidden('id',$data->id)}}
  	<div class="box-body">

  		<!-- BEGIN: Email -->
    	<div class="form-group required">
    		{{Form::label('email', 'Email', ['class' => 'control-label col-sm-2'])}}
      		<div class="col-sm-9">
      			{{Form::email('email', NULL, [
			   'class' => 'form-control',
			   'placeholder' => 'Email'
			   ])
		   	}}
      		</div>
    	</div>
  		<!-- END: Email -->

      <!-- BEGIN: Password -->
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <a href="javascript:;" onclick="showGroupPassword();">Change password</a>
        </div>
      </div>
    	<div class="group-password hidden">
        <div class="form-group ">
          {{Form::label('new_password', 'New Password', ['class' => 'control-label col-sm-2'])}}
            <div class="col-sm-9">
              <div class="input-group">
                {{Form::password('new_password', [
                  'class' => 'form-control',
                  'placeholder' => 'New Password'
                  ])
                }}
                <!-- Button show password -->
                <div class="input-group-addon" id="show_password">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </div> 
              </div>           
            </div>
        </div>
        <!-- END: Password -->

        <!-- BEGIN: Confirm Password -->
        <div class="form-group">
          {{Form::label('confirm_password', 'Confirm Password', ['class' => 'control-label col-sm-2'])}}
            <div class="col-sm-9">
              <div class="input-group">
                {{Form::password('new_password_confirmation', [
                  'class' => 'form-control',
                  'placeholder' => 'Confirm Password',
                  'id' => 'new_password_confirmation'
                  ])
                }}
                <!-- Button show password -->
                <div class="input-group-addon" id="show_password_confirm">
                  <i class="fa fa-eye" aria-hidden="true"></i>
                </div>
              </div>
            </div>
        </div>
        <!-- END: Confirm Password --> 
      </div>

      <!-- BEGIN: Avatar -->
      <div class="form-group">
        {{Form::label('avatar', 'Avatar', ['class' => 'control-label col-sm-2'])}}
          <div class="col-sm-9">
            <input type='file' accept="image/*" class="input-file" name="avatar" onchange="readURL(this);" />
            @if($data->avatar != '')
            <img id="avatar-image" src="{{asset($path_photo.$data->avatar)}}" alt="your avatar" />
            @else
            <img id="avatar-image" src="{{ asset('images/default_avatar_male.jpg') }}" alt="your avatar" />
            @endif
          </div>
      </div>
      <!-- END: Avatar -->

       <!-- BEGIN: Skype -->
      <div class="form-group">
        {{Form::label('skype', 'Skype', ['class' => 'control-label col-sm-2'])}}
          <div class="col-sm-9">
            {{Form::text('skype', NULL, [
         'class' => 'form-control',
         'placeholder' => 'skype'
         ])
        }}
          </div>
      </div>
      <!-- END: Skype -->

      <div class="hr">
        <span class="text "> Authorization </span>
      </div>
      <!-- BEGIN: Role -->
      <div class="form-group required">
        {{Form::label('role[]', 'Role', ['class' => 'control-label col-sm-2', 'data-toggle'=>'tooltip', 'title'=>'Hold Shift to select multi items'])}}
          <div class="col-sm-9">
            {{ Form::select('role[]', $roles, $rolesOfUser,[
                'class' => 'form-control',
                'multiple' => 'multiple'
              ]) 
            }}
          </div>
      </div>
      <!-- END: Role -->

      <div class="hr">
        <span class="text "> Personal Info </span>
      </div>

  		<!-- BEGIN: First Name -->
    	<div class="form-group required">
    		{{Form::label('first_name', 'First Name', ['class' => 'control-label col-sm-2'])}}
      		<div class="col-sm-9">
      			{{Form::text('first_name', NULL, [
			   'class' => 'form-control',
			   'placeholder' => 'First Name'
			   ])
		   	}}
      		</div>
    	</div>
  		<!-- END: First Name -->

  		<!-- BEGIN: Last Name -->
    	<div class="form-group required">
    		{{Form::label('last_name', 'Last Name', ['class' => 'control-label col-sm-2'])}}
      		<div class="col-sm-9">
      			{{Form::text('last_name', NULL, [
			   'class' => 'form-control',
			   'placeholder' => 'Last Name'
			   ])
		   	}}
      		</div>
    	</div>
  		<!-- END: Last Name -->

		<!-- BEGIN: Gender -->
		<div class="form-group">
			{{Form::label('gender', 'Gender', ['class' => 'control-label col-md-2'])}}
			<div class="col-md-6">
				<div class="radio">
                	<label>
						{{Form::radio('gender', MALE, true, [
							])
						}}Male
					</label>
              	</div>
				<div class="radio">
                	<label>
						{{Form::radio('gender', FEMALE, NULL, [
							])
						}}Female
					</label>
				</div>
			</div>
		</div>
		<!-- END: Gender -->

      	<!-- BEGIN: Phone -->
  		<div class="form-group">
			{{Form::label('phone', 'Phone', ['class' => 'control-label col-sm-2'])}}
      		<div class="col-sm-9">
        		{{Form::text('phone', NULL, [
     				'class' => 'form-control',
     				'placeholder' => 'Phone'
     			])
    		}}
      		</div>
      </div>
      <!-- END: Phone -->

      <!-- BEGIN: Address -->
      <div class="form-group">
        {{Form::label('address', 'Address', ['class' => 'control-label col-sm-2'])}}
          <div class="col-sm-9">
            {{Form::text('address', NULL, [
         'class' => 'form-control',
         'placeholder' => 'Address 1'
         ])
        }}
          </div>
      </div>
      <!-- END: Address -->

      

      </div>
      <!-- /.box-body -->
    	<div class="box-footer">
    		<a href="{{route('admin.users.index')}}" class="btn btn-default">@lang('admin.cancle')</a>
      	<button type="submit" class="btn btn-primary pull-right">@lang('admin.save')</button>
    	</div>
      <!-- /.box-footer -->
  	</div>
@stop

@section('js')
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#avatar-image').attr('src', e.target.result);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }

  $('#show_password').hover(function functionName() {
    //Change the attribute to text
      $('#new_password').attr('type', 'text');
      $('#show_password .fa').removeClass('fa-eye').addClass('fa-eye-slash');
    }, function () {
      //Change the attribute back to password
      $('#new_password').attr('type', 'password');
      $('#show_password .fa').removeClass('fa-eye-slash').addClass('fa-eye');
    }
  );

  $('#show_password_confirm').hover(function functionName() {
    //Change the attribute to text
      $('#new_password_confirmation').attr('type', 'text');
      $('#show_password_confirm .fa').removeClass('fa-eye').addClass('fa-eye-slash');
    }, function () {
      //Change the attribute back to password
      $('#new_password_confirmation').attr('type', 'password');
      $('#show_password_confirm .fa').removeClass('fa-eye-slash').addClass('fa fa-eye');
    }
  );

  function showGroupPassword(){
    if ($('.group-password').hasClass('hidden')) {
      $('.group-password').removeClass('hidden');
    }
  }
</script>
@stop