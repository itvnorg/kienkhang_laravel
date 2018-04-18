@if(isset($errors))
	@foreach ($errors->all() as $err)
		<div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-warning"></i> Sorry</h4>
            {{$err}}
      	</div>
	@endforeach
@endif

@if(Session::has('error'))
	<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Sorry</h4>
        {{Session::get('error')}}
  	</div>
@endif

@if(Session::has('success'))
	<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Congratulation</h4>
        {{Session::get('success')}}
  	</div>
@endif