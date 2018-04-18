@if(isset($errors))
  <script type="text/javascript">
    var text = '';
  </script>

	@foreach ($errors->all() as $err)
    <script type="text/javascript">
      text = text + '{{$err}} <br/>';
    </script>
	@endforeach
  
  <script type="text/javascript">
    if(text != ''){
      swal({
        title: "Alert!",
        html: text,
        type: "warning",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "OK"
      });
    }
  </script>
@endif

@if(Session::has('error'))
  <script type="text/javascript">
    swal({
      title: "Alert!",
      text: '{{Session::get("error")}}',
      type: "warning",
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "OK"
    });
  </script>
@endif

@if(Session::has('success'))
  <script type="text/javascript">
    swal({
      title: "Announcement",
      text: '{{Session::get("success")}}',
      type: "success",
      confirmButtonText: "OK"
    });
  </script>
@endif