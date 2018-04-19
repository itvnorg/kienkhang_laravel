<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>{{$settings['site_name']}} - {{$titlePage}}</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>
	<!-- Turn off animate -->
	<link rel="stylesheet" href="{{asset('css/auth/style.css')}}">
	<link rel="stylesheet" href="{{asset('css/auth/custom.css')}}">
	<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{asset('plugins/jquery-validation-1.17.0/dist/jquery.validate.min.js')}}"></script>
</head>

<body>
	<div class="container">
		<form id="i-login-form" action="{{route('password.update.submit')}}" method="POST">
			<input type="hidden" name="id" id="id" value="{{ $id }}" />
			<input type="hidden" name="code" id="code" value="{{ $code }}" />
			<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			<div class="top">
				<h1 id="title" class="hidden"><span id="logo">Working <span>Management</span></span></h1>
			</div>
			<div class="login-box animated fadeInUp">
				<div class="box-header">
					<h2>{{$titlePage}}</h2>
				</div>
				<label for="password">Password</label>
				<br/>
				<input type="password" id="password" name="password" required>
				<br/>
				<label for="password_confirmation">Password Confirm</label>
				<br/>
				<input type="password" id="password_confirmation" name="password_confirmation" required>
				<br/>
				<button type="submit">Update Password</button>
				<br/>
			</div>
		</form>
	</div>
</body>

<script src="{{asset('bower_components/sweetalert2/sweetalert2.all.js')}}"></script>

<script>
	$(document).ready(function () {
		// $('#logo').addClass('animated fadeInDown');
		$("input:text:visible:first").focus();
	});
	$('#password_confirmation').focus(function() {
		$('label[for="password_confirmation"]').addClass('selected');
	});
	$('#password_confirmation').blur(function() {
		$('label[for="password_confirmation"]').removeClass('selected');
	});
	$('#password').focus(function() {
		$('label[for="password"]').addClass('selected');
	});
	$('#password').blur(function() {
		$('label[for="password"]').removeClass('selected');
	});

	$("#i-login-form").validate({
			rules: {
				password: {
					required: true,
					minlength: 5
				},
				password_confirmation: {
					equalTo: "#password"
				}
			},
			messages: {
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				password_confirmation: {
					equalTo: "Password confirmation must be same with password"
				}
			}
		});
</script>
@include('auth.includes.alert_message')

</html>