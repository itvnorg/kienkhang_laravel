@extends('portal.master_mail')

@section('content')
    Hi Admin,<br/>
    Bạn vừa nhận được thông tin liên hệ.<br/>
    Email: {{$email}} <br/>
    Họ tên: {{$name}} <br/>
    Điện thoại: {{$phone}} <br/> 
    Công Ty: {{$address}} <br/>
    Tiêu Đề: {{$subject}} <br/>
    Nội dung: {{$content}} <br/>
@stop