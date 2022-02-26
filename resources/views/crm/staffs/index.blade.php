@extends('layouts.crm.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
	<div class="active section">{{ trans('laralum.staff_title') }}</div>
</div>
@endsection
@section('title', trans('laralum.staff_title'))
@section('icon', "mobile")
@section('subtitle', trans('laralum.staff_title'))

@section('content')
<div class="ui one column doubling stackable grid container-fluid mb-15">
	<div class="column">
		<div class="ui very segment">
			<div class="row">

				<div class="col-md-12 text-right">
					<div class="col-md-4 text-left">
						<select id="check_action">
							<option>Select Action</option>
							<option>Export Selected</option>
							<option>Delete Selected</option>
							@if(Laralum::hasPermission('laralum.member.sendsms'))
							<option>Send Sms</option>
							@endif
						</select>
						<a class="res_ex ui {{ Laralum::settings()->button_color }} button" id='action_btn'>
							<span>Go</span>
						</a>
						@if(Laralum::hasPermission('laralum.member.create'))
						<a href="#" class="res_ex ui {{ Laralum::settings()->button_color }} button" data-toggle="modal"
							data-target="#AddMember" onclick="$('.dimmer').removeClass('dimmer')">
							<i class="fas fa-plus icon_m" aria-hidden="true"></i><span>Quick Add</span>
						</a>
						@endif
					</div>
					<div class="col-md-3 text-center">
						<input type="text" value="{{ request()->get('search_text') }}" id='search_record' class="search"
							name="search_text" placeholder="Search">
					</div>
					<span>{{count($leads)}} Staff(s) &nbsp &nbsp</span>
					@if(Laralum::hasPermission('laralum.member.create'))
					<a href="{{ route('Crm::members_create') }}"
						class="res_ex ui {{ Laralum::settings()->button_color }} button">
						<i class="fas fa-plus icon_m"
							aria-hidden="true"></i><span>{{ trans('laralum.create_lead') }}</span>
					</a>
					@endif
					<a href="javascript:void(0)" class="res_ex ui {{ Laralum::settings()->button_color }} button"
						id="ImportShow" onclick="$('.dimmer').removeClass('dimmer')">
						<i class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span>
					</a>
					

						

				</div>



			</div>
		
		</div>
	</div>
</div>
<div class="row container-fluid">
	<div class="col-md-3 text-left">
		<div class="ui one column doubling stackable grid container-fluid mb-30">
			<div class="column">
				<div class="ui very segment">
					<div class="row">
						<div class="col-md-12 text-left">
							{{-- <a href="javascript:void(0)" class="res_ex ui {{ Laralum::settings()->button_color }} button"
								id="FilterShow" onclick="$('.dimmer').removeClass('dimmer')">
								<i class="fas fa-filter"></i> <span>Filter</span>
							</a> --}}
							<h4><i class="fas fa-filter"></i> <span>FILTER</span></h4>
							<div class="filter-area" style="display: block;">
								<div class="row">
									<form class="ui form" method="GET" action="{{ route('Crm::members') }}">
										{{-- <div class="col-md-12 mb-15">
											<h4><i class="fas fa-filter"></i> <span>FILTER</span></h4>
										</div> --}}
										<div class="col-md-12 text-left" style="margin-bottom: 10px">
											<div class="col-md-12">
												<label>Date Of Birth</label>
												<input type="hidden" id='from_dob' name="from_dob" value="">
												<input type="hidden" id='to_dob' name="to_dob" value="">
												<div class="form-group w-auto mb-0 mr-5">
													<div id="dobrange" class="btn btn-primary"
														style="cursor:pointer;padding:5px 10px;width:auto;display:inline-block;">
														<i class="fas fa-calendar-check"></i>&nbsp;
														<span></span>&nbsp;&nbsp;<i
															class="fas fa-angle-down"></i>&nbsp;&nbsp;<img id="dash_loader"
															style="display:none;"
															src="{{ asset('crm_public/images/dash_filter_loader.png') }}" />
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<label>Date Of Joining</label>
												<input type="hidden" id='from_date' name="from_date" value="">
												<input type="hidden" id='to_date' name="to_date" value="">
												<div class="form-group w-auto mb-0 mr-5">
		
													<div id="dojrange" class="btn btn-primary"
														style="cursor:pointer;padding:5px 10px;width:auto;display:inline-block;">
														<i class="fas fa-calendar-check"></i>&nbsp;
														<span></span>&nbsp;&nbsp;<i
															class="fas fa-angle-down"></i>&nbsp;&nbsp;<img id="dash_loader"
															style="display:none;"
															src="{{ asset('crm_public/images/dash_filter_loader.png') }}" />
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="account_type"
													id="account_type_id">
													<option value="" selected>All Account Type</option>
													@foreach($accounttypes as $type)
													<option value="{{ $type->type }}"
														{{ (request()->get('account_type') == $type->type ? 'selected': '') }}>
														{{ $type->type }}
													</option>
													@endforeach
												</select>
		
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="member_type"
													id="member_type_id">
													<option value="" selected>All Staff Type</option>
													@foreach($membertypes as $type)
													<option value="{{ $type->type }}"
														{{ (request()->get('member_type') == $type->type ? 'selected': '') }}>
														{{ $type->type }}
													</option>
													@endforeach
												</select>
		
											</div>
										</div>
		
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="issue_status">
													<option value="" selected>All Prayer Requests</option>
													<option value="1" @if(request()->get('issue_status')==1) selected
														@endif>Resloved
													</option>
													<option value="2" @if(request()->get('issue_status')==2) selected
														@endif>Pending
													</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="departments">
													<option value="" selected>All Departments</option>
													@foreach($departments as $department)
													<option value="{{ $department->department }}" @if(request()->
														get('departments')==$department->department) selected
														@endif>{{ $department->department }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="call_type">
													<option value="" selected>All Calls</option>
													<option value="Received" @if(request()->get('call_type')=='Received')
														selected
														@endif>Received</option>
													<option value="Made" @if(request()->get('call_type')=='Made') selected
														@endif>Made
													</option>
												</select>
											</div>
										</div>
		
		
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="lead_source">
													<option value="" selected>All Lead Source</option>
													@foreach($sources as $source)
													<option value="{{ $source->source }}"
														{{ (request()->get('lead_source') == $source->source ? 'selected': '') }}>
														{{ $source->source }}
													</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="gender">
													<option value="" selected>Gender</option>
													<option value="Male"
														{{ (request()->get('gender') == "Male" ? 'selected': '') }}>Male
													</option>
													<option value="Female"
														{{ (request()->get('gender') == "Female" ? 'selected': '') }}>Female
													</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="blood_group">
													<option value="" selected>Blood Group</option>
													</option>
													<option value="A+"
														{{ (request()->get('blood_group')== "A+" ? 'selected': '') }}>A+
													</option>
													<option value="B+"
														{{ (request()->get('blood_group')== "B+" ? 'selected': '') }}>B+
													</option>
													<option value="O+"
														{{ (request()->get('blood_group') == "O+" ? 'selected': '') }}>O+
													</option>
													<option value="O-"
														{{ (request()->get('blood_group')== "O-" ? 'selected': '') }}>O-
													</option>
													<option value="A-"
														{{ (request()->get('blood_group') == "A-" ? 'selected': '') }}>A-
													</option>
													<option value="B-"
														{{ (request()->get('blood_group') == "B+" ? 'selected': '') }}>B-
													</option>
													<option value="AB+"
														{{ (request()->get('blood_group') == "AB+" ? 'selected': '') }}>AB+
													</option>
													<option value="AB-"
														{{ (request()->get('blood_group') == "AB-" ? 'selected': '') }}>AB-
													</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="married_status">
													<option value="" selected>Married Status</option>
													<option value="Single"
														{{ (request()->get('married_status') == "Male" ? 'selected': '') }}>Male
													</option>
													<option value="Married"
														{{ (request()->get('married_status') == "Female" ? 'selected': '') }}>
														Female
													</option>
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="country">
													<option value="" selected>Country</option>
													@foreach($get_countries as $country)
													<option value="{{ $country->country_code }}">{{ $country->country_name}}
														{{ (request()->get('country') == $country->country_code ? 'selected': '') }}
													</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="state" id="state"
													onchange="stateChange(this)">
													<option value="" selected>State</option>
													@foreach($get_state as $state)
													<option value="{{ $state->StCode }}">{{ $state->StateName}}
														{{ (request()->get('state') == $state->StCode ? 'selected': '') }}
													</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group">
												<select class="form-control custom-select" name="district" id='district'>
													<option value="" selected>District</option>
												</select>
											</div>
										</div>
										<div class="col-md-12 text-right">
											<button type="submit" class="res_ex ui teal button">Filter</button>
										</div>
									</form>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>				
	</div>
	<div class="col-md-9 text-right container-fluid">
		<div class="ui one column doubling stackable grid container mb-30">
			<div class="column">
				<div class="ui very segment">
					<div class="row">
						<div class="col-md-12 text-right">


							<!--import-area-->
							<div class="import-area" style="display: none;">
								<div class="row">
									<form class="ui form form-inline" method="POST" enctype="multipart/form-data"
										action="{{ route('Crm::members_import') }}">
										<div class="col-md-12">
											<h4 class="mb-15"><i
													class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span>
											</h4>
										</div>
										{{ csrf_field() }}
										<div class="col-md-6 col-md-offset-6 text-right">
											<div class="form-group">
												<input type="file" name="file" class="form-control" />
												<input type="hidden" value="{{ $client_id }}" name="import_leads_client_id" />
												<input type="submit" name="importSubmit" class="res_ex ui teal button ml-5"
													value="Import">
											</div>
											<div class="mb-15 text-right">
												<a href="{{ url('files/sample-csv-members.csv') }}" download>Download Sample
													File</a>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!--import-area-->



							@if(count($leads) > 0)
							<table class="ui five column table ">
								<thead>
									<tr>
										<th><input type="checkbox" id="selectAll" value=true> Name</th>
										<th>Staff ID</th>
										<th>Email</th>
										<th>Phone</th>
										{{-- <th>Account Type</th>
										<th>Prayer Requests</th> --}}
										<th>{{ trans('laralum.options') }}</th>
									</tr>
								</thead>
								<tbody>
									
									@foreach($leads as $lead)
									<tr>
										<td>
											<div class="text">
												<input type="checkbox" id="{{$lead->id}}" name="sms" value=true>
												@if(Laralum::hasPermission('laralum.member.view'))
												<a
													href="{{ route('Crm::member_details', ['id' => $lead->id]) }}">{{ $lead->name }}</a>
												@else{{ $lead->name }}
												@endif
											</div>
										</td>
										<td>
											<div class="text">
												<span class="badge badge-info">{{ $lead->id }}</span>
											</div>
										</td>
										<td>
											<div class="text">
												{{ $lead->email }}
											</div>
										</td>
										<td>
											<div class="text">
												{{ $lead->mobile }}
											</div>
										</td>
										{{-- <td>
											<div class="text">
												<span class="badge badge-info">{{ $lead->account_type }}</span>
											</div>
										</td> 

										<td>
											<div class="text">
												<a onclick="$('.dimmer').removeClass('dimmer')" data-fancybox="data-fancybox"
													data-type="iframe"
													href="{{ route('Crm::getnote', ['id' => $lead->id, 'status' => '1']) }}">Resolved&nbsp;({{ !empty($lead->count_resolved) ? $lead->count_resolved : 0 }})</a><br>
												<a onclick="$('.dimmer').removeClass('dimmer')" data-fancybox="data-fancybox"
													data-type="iframe"
													href="{{ route('Crm::getnote', ['id' => $lead->id, 'status' => '2']) }}">Pending&nbsp;({{ !empty($lead->count_pending) ? $lead->count_pending : 0}})</a>
											</div>
										</td>--}}
										<td>
											<div
												class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
												<i class="configure icon"></i>
												<div class="menu">
													<div class="header">{{ trans('laralum.editing_options') }}</div>
													<a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')"
														id="addNotePopup" class="item" data-id="{{$lead->id}}"
														data-toggle="modal" data-target="#AddNote">
														<i class="add icon"></i>
														{{ trans('laralum.add_note') }}
													</a>


												</div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody> 
							</table>
							@else
							<div class="ui negative icon message">
								<i class="frown icon"></i>
								<div class="content">
									<div class="header">
										{{ trans('laralum.missing_title') }}
									</div>
									<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "leads"]) }}</p>
								</div>
							</div>
							@endif


						</div>
					</div>
					{!! $leads->links() !!}
				</div>
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
						<h4 class="modal-title">Add Member</h4>
					</div>
					<div class="modal-body">
						<form method="POST" enctype="multipart/form-data" action="{{ route('Crm::save_member') }}">
							{{ csrf_field() }}
							<div class="form-group">
								<input type="hidden" class="form-control" id="member_id" name="member_id"
									value="{{ $company }}">
								<label>Staff Type</label>
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
		<!-- add-note-popup-->
		<div id="AddNote" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add Request</h4>
					</div>
					<div class="modal-body">
						<form method="POST" enctype="multipart/form-data" id="save_note_form"
							action="javascript:void(0)">
							{{ csrf_field() }}
							<input type="hidden" id="member_issue_id" name="member_issue_id" />
							<div class="form-group">
								<input type="text" class="form-control" id="request_add" name="prayer_request"
									style="display: none">
								<select class="form-control custom-select" name="issues" id="issues_dropdown">
									<option value="">Please select..</option>
									@foreach($prayer_requests as $request)
									<option value="{{ $request->prayer_request }}">
										{{ $request->prayer_request }}
									</option>
									@endforeach
									<option value="add">Add Value</option>
								</select>
								<small id="show_issue_error" style="color:#FF0000;display:none;">Please enter
									Request</small>
							</div>
							<div class="text-right">
								<button type="submit" id="noteForm" class="ui teal submit button"><span
										id="hide_note_text">SAVE</span>&nbsp;
									<span class="noteForm" style="display:none;"><img
											src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- add-note-popup -->


		<!-- SendSms-popup-->
		<div id="SendSms" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Sms</h4>
					</div>
					<div class="modal-body">
						<form method="POST" enctype="multipart/form-data" action="{{ route('Crm::sendBulkSms') }}">
							{{ csrf_field() }}
							<div class="form-group">
								<textarea placeholder="Write sms here.." class="form-control" id="issues"
									name="msg"></textarea>
								<input type="hidden" id="sms_ids" name="receiver_ids">
							</div>
							<div class="text-right">
								<button type="submit" id="noteForm" class="ui teal submit button"><span
										id="hide_note_text">SEND SMS</span>&nbsp;

								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- add-message-popup -->
		@endsection
		@section('js')
		<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
		</script>
		<link rel="stylesheet" type="text/css"
			href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
		<script type="text/javascript">
			function getSearchParams(k){
				var p={};
				location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){p[k]=v})
				return k?p[k]:p;
			}
			$(function() {
				var requestDobStart=getSearchParams('from_dob');
				var requestDobEnd=getSearchParams('to_dob');
				var requestDojStart=getSearchParams('from_date');
				var requestDojEnd=getSearchParams('to_date');
				console.log(requestDobStart);
				var start = (requestDojStart!=undefined && requestDojStart!="")?moment(requestDojStart):moment('1970-01-01');
    			var end = (requestDojEnd!=undefined && requestDojEnd!="")?moment(requestDojEnd):moment();
				var dobstart =(requestDobStart!=undefined && requestDobStart!="")?moment(requestDobStart): moment('1970-01-01');
    			var dobend = (requestDobEnd!=undefined && requestDobEnd!="")?moment(requestDobEnd): moment();
				
		function dob(start, end) {
			if(start.format('DD/MM/YYYY') == '01/01/1970') {
           		 $('#dobrange span').html('All Time');
					$("#from_dob").val("");
				$("#to_dob").val("");
			}else {
				$('#dobrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$("#from_dob").val(start.format('YYYY-MM-DD'));
				$("#to_dob").val(end.format('YYYY-MM-DD'));			
			}
			
		}
		function doj(start, end) {
			if(start.format('DD/MM/YYYY') == '01/01/1970') {
           		 $('#dojrange span').html('All Time');
			}else {
				$('#dojrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
				$("#from_date").val(start.format('YYYY-MM-DD'));
				$("#to_date").val(end.format('YYYY-MM-DD'));		
			}
			
		}

		$('#dobrange').daterangepicker({
			startDate: dobstart,
			endDate: dobend,
			ranges: {
				'All': [moment('1970-01-01'), moment()],
				'Today': [moment(), moment()],
			   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			   'This Month': [moment().startOf('month'), moment().endOf('month')],
			   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			   
			}
		}, dob);
		$('#dojrange').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
				'All': [moment('1970-01-01'), moment()],
				'Today': [moment(), moment()],
			   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			   'This Month': [moment().startOf('month'), moment().endOf('month')],
			   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			   
			}
		}, doj);
		dob(dobstart,dobend);
		doj(start,end);
	});
		</script>
		<script>
			$("#FilterShow").click(function(){
  $(".filter-area").slideToggle();
});
$("#ImportShow").click(function(){
  $(".import-area").slideToggle();
});
$('#selectAll').click(function(e){
	
    var table= $(e.target).closest('table');

    $('td input:checkbox',table).prop('checked',this.checked);
	
});
$("#action_btn").click(function(){
	var ids=[];
  $('input[type=checkbox]:checked').each(function(i, val){
	  if(val.id!='selectAll')
	  ids.push(val.id); 
	});
	if(ids.length==0){
		$('.dimmer').removeClass('dimmer');
		swal('Error!', 'Please select staff first!', 'error')
		return;
	}
	if($('#check_action').val()!='Select Action'){
		var url="";
		var body={};
		if($('#check_action').val()=='Delete Selected'){
			url="{{ route('Crm::deleteSelected') }}"
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		$.ajax({
			type: 'get',
			url: url,
			data: {ids},
			success: function (data) {
				location.reload();
			}
		})
		}
		else if($('#check_action').val()=='Export Selected'){
			var query = {
				ids: ids
    		}
			var url = "{{route('Crm::exportSelected')}}?" + $.param(query)

   			window.location = url;
		}
		else{
			$('#sms_ids').val(ids);
			$('#SendSms').modal('show');
		}
		
	}
	else{
		swal('Error!', 'Please select action first!', 'error');
	}
	$('.dimmer').removeClass('dimmer');

});
		</script>

		<script src="{{ asset('crm_public/js/member-script.js') }}" type="text/javascript"></script>
		<script>
			$(document).ready(function () {
		$('.verify_mobile').click(function () {
	if($('#verify_label').text()=='Verified')	{
		return;
	}
    $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})       
	
	var sender = $("#sender_id").val();
	var receiver_mobile = $("#mobile").val();
	if($('#verify_label').text()!='Verify')	{
		if ($('#otp').val() == '') {
			swal('Warning!', 'Please enter Otp!', 'warning')
			return false;
		}
		$('#verify_label').html('Verifying..');
		$.ajax({
		type: 'post',
		url: "{{ route('Crm::verify_otp') }}",
		data: {receiver_mobile:receiver_mobile,otp:$('#otp').val()},
		success: function (data) {			
			if(data.status=='success'){
				 $('#verify_label').html('Verified');
				 $('#otp').hide(); 
				
			}else {				
				$('#verify_label').html('Wrong Otp! Reverify');
			}
		}
	});
	}	
	else{
	$('#verify_label').html('SENDING..');
	$.ajax({
		type: 'post',
		url: "{{ route('Crm::send_otp') }}",
		data: {sender:sender,receiver_mobile:receiver_mobile},
		success: function (data) {			
			if(data.status=='success'){
				 $('#verify_label').html('Verify Otp');
				 $('#otp').show(); 
				//  setTimeout(function(){							
				//     location.reload();
				// }, 3000);
			}else {				
				$('#verify_label').html('Resend');
			}
		}
	});
}
	
});
 $(document).on('keyup', '#search_record', function (event) {
	 if (event.keyCode === 13) {
		var query = {
			search_text: $(this).val()
    		}
			var url = "{{route('Crm::members')}}?" + $.param(query)

   			window.location = url;
		 return;
	 }
		var value = $(this).val();
		var token = $("input[name='_token']").val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		
		$('.filter-lead-form').show()
		$.ajax({
			type: 'get',
			url: "{{ route('Crm::members') }}",
			data: {search_text:value},
			success: function (data) {
				location.reload;
			}
		})
	
	})
});


function stateChange(object) {
var id=object.id;
var stateID = object.value;
if(stateID=='')
{
alert('Please select state');
return false;
}
if(stateID){
	var token = $("input[name='_token']").val();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
$.ajax({
method: "POST",
url:"{{ route('Crm::get_district') }}",
data: {state_id:stateID,_token:token},
success:function(res){
if(res){
var district=$('#district');
district.empty();
district.append('<option>District</option>');
$.each(res,function(key,value){
district.append('<option value="'+key+'">'+value+'</option>');
});

}else{
district.empty();
}
}
});
}else{
$("#state").empty();
$("#city").empty();
}
}
		</script>

		<script>
			$(document).on('click','#addNotePopup',function(e) {
	$('#member_issue_id').val($(this).attr('data-id'))
});
		</script>
		<style>
			.search {
				width: 130px;
				box-sizing: border-box;
				border: 1px solid #ccc;
				border-radius: 4px;
				font-size: 16px;
				background-color: white;
				/* background-image: url('searchicon.png'); */
				background-position: 10px 10px;
				background-repeat: no-repeat;
				padding: 9px 9px 9px 9px;
				-webkit-transition: width 0.4s ease-in-out;
				transition: width 0.4s ease-in-out;
			}

			.search:focus {
				width: 100%;
			}

			.text-center {
				text-align: center !important;
				width: 32%;
			}
		</style>
		@endsection