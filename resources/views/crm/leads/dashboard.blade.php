@extends('layouts.crm.newLayout')
@section('title', "Leads Dashboard")
@section('icon', "mobile")
@section('subtitle', trans('laralum.leads_dashboard_title'))
@section('content')

<div class="ui one column doubling stackable grid container mb-20 p-0" style="background: #fff;">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-1 left-dashboard-area">
					<!--1-->
					<a href="#" class="dash-item-list-a">
					<div class="media dash-item-list">
						<img src="{{ asset('/crm_public/images/incoming-calls.png') }}" class="media-object" width="30px;">
						<h4 class="text-right">0</h4>
					</div>
					</a>
					<!--1-->
					
					<!--1-->
					<a href="#" class="dash-item-list-a">
					<div class="media dash-item-list">
						<img src="{{ asset('/crm_public/images/outgoing-calls.png') }}" class="media-object" width="30px;">
						<h4 class="text-right">0</h4>
					</div>
					</a>
					<!--1-->
					
					<!--1-->
					<a href="#" class="dash-item-list-a">
					<div class="media dash-item-list">
						<img src="{{ asset('/crm_public/images/miss-call.png') }}" class="media-object" width="30px;">
						<h4 class="text-right">0</h4>
					</div>
					</a>
					<!--1-->
					
					<!--1-->
					<a href="#" class="dash-item-list-a">
					<div class="media dash-item-list">
						<img src="{{ asset('/crm_public/images/disconnected-call.png') }}" class="media-object" width="30px;">
						<h4 class="text-right">0</h4>
					</div>
					</a>
					<!--1-->
				</div>
				<!--middle-area-start-->
				<div class="col-lg-10 dash-middle-area full-width-tabs">				
					<ul class="nav nav-tabs">
					<li class="take-all-space-you-can"><a data-toggle="tab" href="#Activity">ACTIVITY</a></li>
					<li class="active take-all-space-you-can"><a data-toggle="tab" href="#Leads">LEADS</a></li>
					<li class="take-all-space-you-can"><a data-toggle="tab" href="#Calls">CALLS</a></li>
					<li class="take-all-space-you-can"><a data-toggle="tab" href="#Tasks">TASKS</a></li>
					</ul>

					<div class="tab-content">
						<div id="Activity" class="tab-pane fade">
							<p>Coming soon..</p>
						</div>
						<div id="Leads" class="tab-pane fade in active">
							<div id="LOADMSG"></div>

							<!-- <button type="button" class="btn btn-primary" id="STARTCALL" style="float:right;">Start Calling <i class="fas fa-phone"></i></button> -->
							
							<div class="form-inline mb-15">
							<!--<div class="form-group">
								<label for="exampleInputName2">Filter activity: &nbsp;&nbsp;&nbsp;</label>
							</div>-->
							<div class="form-group w-auto mb-0 mr-5">
								<div id="reportrange" class="btn btn-primary" style="cursor:pointer;padding:5px 10px;width:auto;display:inline-block;">
								<i class="fas fa-calendar-check"></i>&nbsp;
								<span></span>&nbsp;&nbsp;<i class="fas fa-angle-down"></i>&nbsp;&nbsp;<img id="dash_loader" style="display:none;" src="{{ asset('/crm_public/images/dash_filter_loader.png') }}" />
								</div>
							</div>
							<div class="form-group">
								<select class="btn btn-primary custom-select-lead">
									<option value="">All Members</option>
								</select>
							</div>
							@if(Laralum::hasPermission('laralum.member.create'))
								<a href="{{ route('Crm::leads_create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i>
								<span class="r-none">Add</span></a>
							@endif
							<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#AddMember" onclick="$('.dimmer').removeClass('dimmer')"><i class="fas fa-plus-circle"></i>
								<span class="r-none">Quick Add</span></a>
							</div>
							<div class="table-responsive">
								<table class="ui five column table" id="memberTable">
									<thead>
										<tr>
											<th>Name</th>
											<th>Member ID</th>
											<th>Phone</th>
											<th>Created Date</th>
										</tr>
									</thead>
								</table>
							</div>
					</div>
					<div id="Calls" class="tab-pane fade">
						<p>Coming soon..</p>
					</div>
					<div id="Tasks" class="tab-pane fade">
						<p>Coming soon..</p>
					</div>
					</div>
					
				</div>
				<!--middle-area-end-->
				<!--right-area-start-->
				<div class="col-lg-1 right-dashboard-area">
					<!--1-->
					<a href="#" class="dash-item-list-a">
					<div class="media dash-item-list">
						<img src="{{ asset('/crm_public/images/church-icon.png') }}" class="media-object" width="30px;">
						<h4 class="text-right">0</h4>
					</div>
					</a>
					<!--1-->
					<!--1-->
					<a href="#" class="dash-item-list-a">
					<div class="media dash-item-list">
						<img src="{{ asset('/crm_public/images/team-icon.png') }}" class="media-object"width="30px;">
						<h4 class="text-right">{{ $total_members }}</h4>
					</div>
					</a>
					<!--1-->
					<!--1-->
					<a href="#" class="dash-item-list-a">
					<div class="media dash-item-list">
						<img src="{{ asset('/crm_public/images/close-icon.png') }}" class="media-object"width="30px;">
						<h4 class="text-right">0</h4>
					</div>
					</a>
					<!--1-->
					<!--1-->
					<a href="#" class="dash-item-list-a">
					<div class="media dash-item-list">
						<img src="{{ asset('/crm_public/images/group-icon.png') }}" class="media-object" width="30px;">
						<h4 class="text-right">0</h4>
					</div>
					</a>
					<!--1-->
					
				</div>
				<!--right-area-end-->
		
			</div>
		</div>
	</div>
</div>
	<!-- add-member-popup-->
		<div id="AddMember" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Quick Add Lead</h4>
					</div>
					<div class="modal-body">
						<form method="POST" enctype="multipart/form-data" action="{{ route('Crm::save_lead') }}">
							{{ csrf_field() }}
							<div class="form-group">
								<input type="hidden" class="form-control" id="member_id" name="member_id"
									value="{{ $company }}">
								<label>Member Type</label>
								<select multiple="multiple" class="form-control custom-select" name="member_type[]"
									id="member_type_id">
									@foreach($membertypes as $type)
									<option value="{{ $type->type }}"
										{{ (old('member_type[]') == $type->type ? 'selected': '') }}>
										{{ $type->type }}
									</option>
									@endforeach
								</select>
								<label>Name <span class="red-txt">*</span></label>
								<input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
								<label>Mobile <span class="red-txt">*</span></label>
								<input type="text" class="form-control" id="mobile" name="mobile"
									value="{{old('mobile')}}">
							</div>
							<div class="text-right">
								<button type="submit" class="ui teal submit button"><span
										id="hide_note_text">SAVE</span>&nbsp;
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	<!-- add-member-popup -->
@endsection
@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- Script -->
<script type="text/javascript">
	$(function() {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		  var value = $('#reportrange span').html();		
		 $.ajaxSetup({
			headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			 }
		  })
			
			   var formData = {
					data: value,
				}
				$("#dash_loader").css('display','inline-block');
				$.ajax({
					url: '{{ route("Crm::dashboard_filter") }}',
					type: 'get',
					data: formData,
					dataType: 'json',
					success: function (data) {
						 $("#dash_loader").css('display','none');
						 if(data.status=='success'){				
							$("#total_members").html(data.total_issues);
							$("#total_issues").html(data.total_issues);
							$("#resolved_issue").html(data.resolved_issues);
							$("#pending_issue").html(data.pending_issues);							
						  }
						  
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
		
		
		
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           
        }
    }, cb);

    cb(start, end);

	});
 	$('.dimmer').removeClass('dimmer');
</script>
<script src="{{ asset(Laralum::publicPath() .'/js/datatables.min.js') }}" type="text/javascript"></script>
<link href="{{ asset(Laralum::publicPath() .'/css/datatables.min.css') }}" type="text/css" rel="stylesheet" />
<script>
	$(document).ready(function() {
		$.fn.dataTable.ext.errMode = 'throw';
		// Leads dashboard DataTable
		$('#memberTable').DataTable({
			language: {
				search: "_INPUT_",
				searchPlaceholder: "Search...",
				sLengthMenu: "_MENU_"
			},
			
			processing: true,
			serverSide: true,
			ajax: "{{ route('Crm::get_leads') }}",
			columns: [
				{ data: 'name' },
				{ data: 'member_id' },
				{ data: 'mobile' },
				{ data: 'created_at' },
			]
		});

		
	});

</script>
@endsection