@extends('admin.master')

@section('css')
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('admin.includes.alert_message')
<div class="col-md-12 box box-info">
	<table cellspacing="0" class="table table-bordered table-hover" id="dataTable" width="100%">
		<thead>
			<tr>
				<th class="no-sort">
					<label><input type="checkbox" id="checkAll"/></label>
				</th>
				<th>ID</th>
				<th>@lang('admin.title')</th>
				<th>@lang('admin.description')</th>
				<th>@lang('admin.views')</th>
				<th>@lang('admin.status')</th>
				<th>@lang('admin.actions')</th>
			</tr>
		</thead>
	</table>
	<div id="tb-action">
		<select class="sl-action form-control">
			<option data-icon="glyphicon-pushpin"
			value="-1">@lang('admin.actions')</option>
			<option data-icon="glyphicon-remove-circle"
			value="0">@lang('admin.delete')</option>
		</select>			
	</div>
	<form id="tb-search" method="POST" action>			
		<div class="input-group pull-right">
			<span class="input-group-addon"><i class="fa fa-search"></i></span>
			<input type="text" class="form-control" placeholder="@lang('admin.search')" id="tableTextSearch">
		</div>
	</form>
	<div id="tb-limit" class="pull-right">
		<select class="sl-limit form-control">
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="50">50</option>
		</select>
	</div>
	<div id="tb-change-page" class="pull-right">
		<button class="btn btn-default" id="btn-prev-page" onclick="prevPage()">@lang('admin.prev')</button>
		<button id="btn-current-page" class="btn btn-default" disabled=""></button>
		<button class="btn btn-default" id="btn-next-page" onclick="nextPage()">@lang('admin.next')</button>
	</div>
	<div id="tb-length"></div>
</div>
@endsection

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

	var urlIndex = '{{route("admin.news.index")}}';
	var urlCreate ='{{route("admin.news.create")}}';
	var urlDeleteMulti = '{{route("admin.news.delete")}}';
	var idRows = [];
	var searchForm = $('#tb-search');
	var currentPage = 1;
	var totalEntries;
	var limitPerPage = $('.sl-limit').val();

	editItem = function(id){
		document.location = '/admin/news/' + id + '/edit';
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
						text: "@lang('admin.deletes?')",
						type: "warning",
						showCancelButton: true,
						confirmButtonColor: "#DD6B55",
						confirmButtonText: "@lang('admin.delete_yes')",
						cancelButtonText: "@lang('admin.no')"
					}).then((result) => {
						if (result.value) {
							goDeleteMulti(idRows);
						}
					});
				}
        		$(this).find("option:first").attr('selected','selected');
			} else if ($(this).val() == -1) {
				return false;
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

		var dtTable = $('#dataTable').DataTable({
			ajax: {
				url: urlIndex,
				type: 'get',
				dataSrc: function(json){
					totalEntries = json.total;
					var toRecord = (currentPage*limitPerPage > totalEntries) ? totalEntries : currentPage*limitPerPage;
					var fromRecord = ((currentPage-1)*limitPerPage +1);
					setStateChangePage(currentPage, toRecord, totalEntries);
					$('#tb-length').html('Show '+fromRecord+ ' to ' + toRecord +' of '+totalEntries+' entries');
					return json.data;
				},
				data: function(d){
					d.searchString = $('#tableTextSearch').val();
					d.limit = limitPerPage;
					d.offset = (currentPage-1)*limitPerPage;
				}
			},
			ordering: false,
			searching: false,
			responsive: true,
			filter: false,
			paging: false,
			info: false,
			columns: [
				{ 
					"data": null, render: function (data, type, row) {
						text = '<label>';
						text += '<input type="checkbox" name="id" value="' + data.id + '" class="checkboxes" /></label>';
						return text; 
					}
				},
				{ 
					"data": "id" 
				},
				{ 
					"data": "title" 
				},
				{ 
					"data": "description" 
				},
				{ 
					"data": "views" 
				},
				{ 
					"data": null, render: function(data, type, row) {
						text = (data.status == 1) ? 'Active' : 'Inactive';
						return text;
					} 
				},
				{ 
					"data": null, render: function (data, type, row) {
						text = '<span onclick="editItem('+data.id+')" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i></span> ';
						text += '<span onclick="deleteItem('+data.id+')" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></span>';
						text = '<div style="">' + text + '</div>';
						return text;
					} 
				}
			]
		});

		$('.dataTables_wrapper .row:last .col-sm-5').prepend($('#tb-length'));
		$('.dataTables_wrapper .row:last .col-sm-7').prepend($('#tb-limit'));
		$('.dataTables_wrapper .row:last .col-sm-7').prepend($('#tb-change-page'));
		$('.dataTables_wrapper .row:first .col-sm-6:first').prepend($('#tb-action'));
		$('.dataTables_wrapper .row:first .col-sm-6:last').prepend($('#tb-search'));

		function prevPage(){
			if(currentPage >= 2){
				currentPage--;
				dtTable.ajax.reload();
			}
		}

		function nextPage(){
			if(currentPage*limitPerPage < totalEntries){
				currentPage++;
				dtTable.ajax.reload();
			}
		}

		$('.sl-limit').on('change', function(){
			limitPerPage = $('.sl-limit').val();
			dtTable.ajax.reload();
		});

		function goDelete(id){
			$.ajax({
				url: '/admin/news/' + id,
				method: 'DELETE',
				success: function(result) {
					data = $.parseJSON(result);
					if (data.status == 'success') {
						swal({
							title: "@lang('admin.deleted')",
  							text: data.message,
							type: "success",
							timer: 2000,
							showConfirmButton: true
						});
						dtTable.ajax.reload();
					} else {
						swal("@lang('admin.system_error')", data.message);
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
  							text: data.message,
							type: "success",
							timer: 2000,
							showConfirmButton: false
						});
						dtTable.ajax.reload();
					} else {
						swal("@lang('admin.system_error')", data.message);
					}
				}
			})
		}

		function setStateChangePage(currentPage, toRecord, totalEntries){
			$('#btn-current-page').html(currentPage);
			if(currentPage == 1){ 
				$('#btn-prev-page').attr('disabled',true);
			}else{
				$('#btn-prev-page').attr('disabled',false);
			}
			if(toRecord == totalEntries){ 
				$('#btn-next-page').attr('disabled',true); 
			}else{
				$('#btn-next-page').attr('disabled',false);
			}
		}

		searchForm.submit(function(){
			dtTable.ajax.reload();
      		return false;
		});
	</script>
@endsection