@extends('portal.master')

@section('content')
<div class="container detail">
	<div class="col-md-12 wrapper-content">
		<!-- BEGIN: Breadcrumb -->
		<nav aria-label="breadcrumb">
		  	<ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home"></i></a></li>
			    <li class="breadcrumb-item active" aria-current="page">{{$titlePage}}</li>
		  	</ol>
		</nav>
		<!-- END: Breadcrumb -->
		
		<!-- BEGIN: Main Content -->
		<div class="row">
			<!-- BEGIN: Content -->
			<div class="col-md-12">

	            	<div class="row">
		                <div class="col-md-6">
		                    <div class="content info">
		                        <div>
		                            <i class="fas fa-map-marker" aria-hidden="true"></i> {{$settings['company_address']}}
		                        </div>
		                        <div>
		                            <i class="fas fa-phone" aria-hidden="true"></i> {{$settings['company_hot_line']}}

		                        </div>
		                        <div>
		                            <i class="far fa-envelope" aria-hidden="true"></i> Email:{{$settings['company_email']}}
		                        </div>
		                        <div>
		                            <i class="fas fa-globe" aria-hidden="true"></i> {{URL::to('/')}}
		                        </div>
		                        <div id="map" style="height: 300px;padding:5px;border:1px solid #ccc;margin-top: 10px"></div>
		                    </div>
		                </div>
		                <div class="col-md-6">

		                    {{Form::open([
		    						'url' => route('portal.contact.send'),
		    						'class' => 'form-horizontal form-bordered',
		    						'id'    => 'f-send'
		    						])
		    					}}

		                    <div class="form-group l-title">
		                        {{Form::label('email', 'Email', ['class' => 'control-label col-md-3 required'])}}
		                        <div class="col-md-9">
		                            {{Form::text('email', NULL, [
		                                               'class' => 'form-control required email',
		                                               'placeholder' => 'Nhập email của bạn'
		                                               ])
		                               }}
		                        </div>
		                    </div>
		                    <!-- end row-->
		                    <div class="form-group l-title">
		                        {{Form::label('name', 'Họ tên', ['class' => 'control-label col-md-3 required'])}}
		                        <div class="col-md-9">
		                            {{Form::text('name', NULL, [
		                                               'class' => 'form-control required',
		                                               'placeholder' => "Nhập họ tên của bạn...",
		                                               'minlength' => '2',
		                                               ])
		                               }}
		                        </div>
		                    </div>
		                    <!-- end row-->

		                    <div class="form-group l-title">
		                        {{Form::label('address', 'Địa chỉ', ['class' => 'control-label col-md-3 required'])}}
		                        <div class="col-md-9">
		                            {{Form::text('address', NULL, [
		                                               'class' => 'form-control required',
		                                               'placeholder' => "Nhập địa chỉ...",
		                                               'minlength' => '10',
		                                               ])
		                               }}
		                        </div>
		                    </div>
		                    <!-- end row-->

		                    <div class="form-group l-title">
		                        {{Form::label('phone', 'Số điện thoại', ['class' => 'control-label col-md-3 required'])}}
		                        <div class="col-md-9">
		                            {{Form::text('phone', NULL, [
		                                               'class' => 'form-control required number',
		                                               'placeholder' => 'Số điện thoại của bạn là gì?',
		                                               'minlength' => '10'
		                                               ])
		                               }}
		                        </div>
		                    </div>
		                    <!-- end row-->

		                    <div class="form-group l-des">
		                        {{Form::label('content',  'Nội dung', ['class' => 'control-label col-md-3 required'])}}
		                        <div class="col-md-9">
		                            {{Form::textarea('content',NULL, [
		                                                'class' => 'form-control required',
		                                                'minlength' => '10',
		                                                'placeholder' => 'Nội dung...'
		                                                ])
		                            }}
		                        </div>
		                    </div>
		                    <!-- end row-->

		                    <div class="form-group l-des">
		                        <div class="col-md-3"></div>
		                        <div class="col-md-9">
		                            <button type="submit" class="btn btn-c-submit pull-right">Gửi ngay</button>
		                        </div>
		                    </div>

		                    {{Form::close()}}
		                </div>
		            </div>
	            </div>

			</div>
			<!-- END: Content -->
		</div>
		

		<!-- END: Main Content -->
	</div>
	
</div>
@endsection

@section('js')
<!-- Google Map -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDkbVE5JeOi0aj5WBM3NOlEbC3p1V1lyMo&libraries=places&language=vi"></script>
<script src="{{asset('js/geocomplete.js')}}"></script>
<script src="{{asset('plugins/jquery_validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('bower_components/sweetalert2/sweetalert2.all.js')}}"></script>
<script type="text/javascript">
	function initialize() {
        var lat = "{{$settings['lat']}}";
        var lng = "{{$settings['lng']}}";
        var myLatlng = new google.maps.LatLng(lat, lng);
        var mapOptions = {
            zoom: 15,
            center: myLatlng
        };

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        var contentString = "<table><tr><th>{{$settings['company_name_full']}}</th></tr><tr><td>Địa chỉ: {{$settings['company_address']}}</td></tr></table>";

        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: "{{$settings['company_name_full']}}"
        });
        infowindow.open(map, marker);
    }

    google.maps.event.addDomListener(window, 'load', initialize);

    $(document).ready(function(){
        var form = $('#f-send');

        form.validate({
            lang:"vi",
            ignore: ':not(select:hidden, input:visible, textarea:visible)',
            invalidHandler: function(form, validator) {
                if (!validator.numberOfInvalids())
                    return;

                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).parent().offset().top - 60
                }, 500);
            },
            errorPlacement: function(error, element) {
                if(element.parent().next().hasClass('alert-message')){
                    error.appendTo(element.parent().next());
                }

                element.prev().hide();
            },
            success: function(label, input) {
                var name = label.attr('for');
                label.parent().prev().find('input[name='+name+']').prev('i.icon-append').show();
                label.parent().prev().find('input[id='+name+']').prev('i.icon-append').show();
                label.remove();
            }
        });

        form.submit(function(){
            if (form.valid()) {
                $.ajax({
                    url: "{{route('portal.contact.send')}}",
                    data: form.serialize(),
                    beforeSend: function(){
                        form.find("button[type='submit']").prop('disabled', true);
                        form.find("button[type='submit']").html('Loading.. <i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(result) {
                        swal('Thông Báo', result.msg, "success");
                        form.find("button[type='submit']").html('<span class="glyphicon glyphicon-envelope"></span> Gửi ngay');
                        form.find("button[type='submit']").prop('disabled', false);
                        form[0].reset();
                    }
                });
                return false;
            }
        });
    });
</script>
@endsection

@section('css')
@endsection