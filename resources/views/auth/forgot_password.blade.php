<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title>{{$settings['site_name']}} - {{$titlePage}}</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="{{asset('css/auth/style.css')}}">
	<link rel="stylesheet" href="{{asset('css/auth/custom.css')}}">
	<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{asset('plugins/jquery-validation-1.17.0/dist/jquery.validate.min.js')}}"></script>
</head>

<body>
	<div class="container">
		<form id="i-forgot-password-form" action="{{route('password.forgot.submit')}}" method="POST">
			<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
			<div class="top">
				<h1 id="title" class="hidden"><span id="logo">{{$settings["site_name_short"]}}<span></span></h1>
			</div>
			<div class="login-box animated fadeInUp">
				<div class="box-header">
					<h2>Password Recovery</h2>
				</div>
				@if(Session::has('error_invalid'))
				<label class="error" style="margin-top: 0px;">{{Session::get('error_invalid')}}</label>
				@endif
				<label for="username">Email</label>
				<br/>
				<input type="text" id="email" name="email" required>
				<br/>
				<button type="submit">Send</button>
				<br/>
				<a href="{{route('login.view')}}"><p class="small">Back to Login</p></a>
			</div>
		</form>
	</div>
</body>

<script src="{{asset('bower_components/sweetalert2/sweetalert2.all.js')}}"></script>

<script>
	$(document).ready(function () {
		$('#logo').addClass('animated fadeInDown');
		$("input:text:visible:first").focus();
	});
	$('#username').focus(function() {
		$('label[for="username"]').addClass('selected');
	});
	$('#username').blur(function() {
		$('label[for="username"]').removeClass('selected');
	});

	$("#i-forgot-password-form").validate({
		rules: {
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			email: "Please enter a valid email address",
		}
	});
</script>
@include('auth.includes.alert_message')

</html>