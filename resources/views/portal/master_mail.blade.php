<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from www.codecovers.eu/materialadmin/pages/locked by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 11 Mar 2015 10:17:32 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <title>{{$settings['site_name']}}</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <meta name="description" content="Short explanation about this website">
    <!-- END META -->
</head>
<body>
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2"  style=" margin-top: 20px; font-family: Tahoma; font-size: 14px; line-height: 19px; ">
            <div style=" border: solid 1px #666; border-radius: 5px">
                <div style="overflow: hidden; border-bottom: solid 1px #666; padding: 20px; padding-bottom: 10px; ">
                    <ul style="float: right; margin: 0; margin-top: 3px; display: inline-table">
                        <li style="display: inline; margin: 0"><a href="{{route('home')}}" style="text-decoration: none">Trang chủ</a></li>
                        <li style="display: inline; padding: 0 4px; color: #a9a9a9; margin-left: 0">|</li>
                        <li style="display: inline; margin: 0"><a href="{{route('portal.pages.contact')}}" style="text-decoration: none">Liên hệ</a></li>
                    </ul>
                </div>
                <div style="padding: 0 20px; overflow: hidden; padding-bottom: 20px">
                    @yield('content')
                    <h3>{{$settings['site_name']}}</h3>
                    <address>Địa chỉ: {{$settings['company_address']}}</address>
                    <address>Điện thoại: {{$settings['company_phone']}} </address>
                </div>
            </div>
            <p>

            </p>
        </div>
    </div>
</body>
</html>