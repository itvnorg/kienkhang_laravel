@extends('admin.master')

@section('css')

@stop

@section('content')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<div class="col-md-12 box box-info">
		<table cellspacing="0" class="table table-bordered table-hover" id="dataTable" width="100%">
			<thead>
			<tr>
				<th class="no-sort">
					<label><input type="checkbox" id="checkAll"/></label>
				</th>
				<th>ID</th>
				<th class="no-sort">Avatar</th>
				<th>Email</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Gender</th>
				<th>Phone</th>
				<th>@lang('admin.address')</th>
				<th>@lang('admin.actions')</th>
			</tr>
			</thead>
		</table>
		<div id="tb-action">
			<select class="sl-action form-control">
				<option data-icon="glyphicon-pushpin"
						value="">Actions</option>
				<option data-icon="glyphicon-remove-circle"
						value="0">@lang('admin.delete')</option>
			</select>			
		</div>
		<div id="tb-search">			
			<div class="input-group pull-right">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="@lang('admin.search')" id="tableTextSearch">
          </div>
		</div>
	</div>
@stop

@section('js')
	<!-- DataTables -->
	<script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
	<script src="{{asset('bower_components/sweetalert2/sweetalert2.all.js')}}"></script>
	
	<script type="text/javascript">
		$.ajaxSetup({
  			headers: {
    			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  			}
		});

		var urlIndex = '{{route("admin.users.index")}}';
		var urlCreate ='{{route("admin.users.create")}}';
		var urlDeleteMulti = '{{route("admin.users.delete")}}';
		var path_photo = '{{asset($path_photo)}}/';
		var path_default_image = '{{asset(_default_images)}}/';
	    var idRows = [];

		editItem = function(id){
			document.location = '/admin/users/' + id + '/edit';
		}

		deleteItem = function(id){
			swal({
                title: "@lang('admin.warning')",
                text: "@lang('admin.delete?')",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "@lang('admin.delete_yes')",
                cancelButtonText: "@lang('admin.no')"}).then((result) => {
                	if (result.value) {
                		goDelete(id);
					} else if (result.dismiss === 'cancel') {
					    // swal(
					    //   	'Cancelled',
					    //   	'Your delete request is Cancelled',
					    //   	'error'
					    // )
					}
                });
		}

		$(".sl-action").change(function(){
			if ($(this).val() == 0) {
				if(idRows.length === 0) {
					swal("@lang('admin.opps')", "@lang('admin.no_choose_row')", "error");
				} else {
                    swal({
                        title: "@lang('admin.warning')",
                        text: "@lang('admin.delete?')",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "@lang('admin.delete_yes')",
                        cancelButtonText: "@lang('admin.no')"}).then((result) => {
	                	if (result.value) {
	                		goDeleteMulti(idRows);
						} else if (result.dismiss === 'cancel') {
						    // swal(
						    //   	'Cancelled',
						    //   	'Your delete request is Cancelled',
						    //   	'error'
						    // )
						}
	                });
				}
			} else {
				window.location = $(this).val();
			}
		});

		$('#dataTable').on('click', 'input[type="checkbox"]', function() {
			idRows = [];
			$('input.checkboxes').each(function(){
				if($(this).is(':checked')){
					idRows.push($(this).val());
				}
			});
			initStatusActions();
		});

		$("#checkAll").click(function(){
    		$('input:checkbox').not(this).prop('checked', this.checked);
		});

	    initStatusActions = function(){
			if(idRows.length === 0) {
				$('.sl-action').hide();
			}else{
				$('.sl-action').show();
			}
	    }

		var dtTable = $('#dataTable').DataTable({
			ajax: urlIndex,
			type: 'get',
        	ordering: false,
    		searching: true,
    		responsive: true,
        	filter: false,
        	paging: true,
        	info: false,
	        columns: [
	            { "data": null, render: function (data, type, row) {
		                text = '<label>';
		                text += '<input type="checkbox" name="id" value="' + data.id + '" class="checkboxes" /></label>';
		                return text; 
	            	}
                },
	            { "data": "id" },
	            { "data": null, render: function (data, type, row) {
	            		if(data.avatar != null){
	            			text = '<img id="avatar-image" src="' + path_photo + data.avatar + '" />';
	            		}else{
	            			text = '<img id="avatar-image" src="' + path_default_image + 'default_avatar_male.jpg" />';
	            		}
		                return text; 
	            	}
            	},
	            { "data": "email" },
	            { "data": "first_name" },
	            { "data": "last_name" },
	            { "data": null, render: function(data, type, row){
	            		if(data.gender == 1){
	            			text = '<i class="fa fa-male" aria-hidden="true"></i>';
	            		}else{
	            			text = '<i class="fa fa-female" aria-hidden="true"></i>';
	            		}
	            		return text;
		            },
		            className: "icon-gender" 
		        },
	            { "data": "phone" },
	            { "data": "address" },
	            { "data": null, render: function (data, type, row) {
	                    text = '<span onclick="editItem('+data.id+')" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></span> ';
	                    text += '<span onclick="deleteItem('+data.id+')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span>';
	                    text = '<div style="">' + text + '</div>';
	                    return text;
                    } 
                }
	        ]
        });

        $('#tableTextSearch').keyup(function(){
      		dtTable.search($(this).val()).draw() ;
		})

		$('#dataTable_filter').remove();
		$('.dataTables_wrapper .row:last .col-sm-5').prepend($('#dataTable_length'));
		$('.dataTables_wrapper .row:first .col-sm-6:first').prepend($('#tb-action'));
		$('.dataTables_wrapper .row:first .col-sm-6:last').prepend($('#tb-search'));
		initStatusActions();

		function goDelete(id){
			$.ajax({
				url: '/admin/users/' + id,
				method: 'DELETE',
				success: function(result) {
					data = $.parseJSON(result);
					if (data.status == 'success') {
						swal({
							title: "@lang('admin.deleted')",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						});
						dtTable.ajax.reload();
					} else {
						swal("System Error!", "error");
					}
				}
			})
		}

		function goDeleteMulti(ids){
			$.ajax({
				url: urlDeleteMulti,
				type: 'POST',
				data: {id:ids},
				success: function(result) {
					data = $.parseJSON(result);
					if (data.status == 'success') {
						swal({
							title: "@lang('admin.deleted')",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						});
						dtTable.ajax.reload();
					} else {
						swal("System Error!", "error");
					}
				}
			})
		}
	</script>
@stop