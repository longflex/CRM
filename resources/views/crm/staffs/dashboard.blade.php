@extends('layouts.crm.panel')
@section('title', trans('laralum.leads_dashboard_title'))
@section('icon', "mobile")
@section('subtitle', trans('laralum.leads_dashboard_title'))
@section('content')
<style>
	.ui.grid>.row {
		display: table !important;
	}
</style>
<div class="ui one column doubling stackable grid container mb-20">
	<div class="column row pb-0 rmb-20">
		<div class="col-md-5">
			<h3 class="mt-15 rmb-20">{{ trans('laralum.leads_dashboard_title') }}</h3>
		</div>
		<div class="col-md-7 text-right rmb-20">

			<form class="form-inline">
				<div class="form-group w-auto mb-0 mr-5">
					<div id="reportrange" class="btn btn-primary"
						style="cursor:pointer;padding:5px 10px;width:auto;display:inline-block;">
						<i class="fas fa-calendar-check"></i>&nbsp;
						<span></span>&nbsp;&nbsp;<i class="fas fa-angle-down"></i>&nbsp;&nbsp;<img id="dash_loader"
							style="display:none;" src="{{ asset('crm_public/images/dash_filter_loader.png') }}" />
					</div>
				</div>
				<a href="{{ route('Crm::staff') }}" class="btn btn-primary mr-5"><i class="fas fa-eye"></i> <span
						class="r-none">{{ trans('laralum.view_staff') }}</span></a>
			</form>
		</div>
	</div>

	<div class="column row">
		<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
			<div class="ui very padded segment new-dashboard-list bg-color-1">
				<a href="{{ route('Crm::leads') }}">
					<div class="row">
						<div class="col-xs-12">
							<p class="card-category">Total Members</p>
						</div>
						<div class="col-xs-4">
							<i class="fas fa-user-tie"></i>
						</div>
						<div class="col-xs-8">
							<div class="numbers">
								<p class="card-title" id="total_members">{{ $total_members }}</p>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
			<div class="ui very padded segment new-dashboard-list bg-color-2">
				<a href="{{ route('Crm::leads', ['today_members' => date('Y-m-d')]) }}">
					<div class="row">
						<div class="col-xs-12">
							<p class="card-category">Registered Today</p>
						</div>
						<div class="col-xs-4">
							<i class="fas fa-user-tie" ></i>
						</div>
						<div class="col-xs-8">
							<div class="numbers">
								<p class="card-title">{{ $today_members }}</p>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
			<div class="ui very padded segment new-dashboard-list bg-color-3">
				<a href="javascript:void(0)" onclick="$('.dimmer').removeClass('dimmer')">
					<div class="row">
						<div class="col-xs-12">
							<p class="card-category" id="total_call_made">Total Calls Made</p>
						</div>
						<div class="col-xs-4">
							<img src="{{ asset('crm_public/images/outgoing-call.png') }}"  />
						</div>
						<div class="col-xs-8">
							<div class="numbers">
								<p class="card-title">0</p>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
			<div class="ui very padded segment new-dashboard-list bg-color-4">
				<a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')">
					<div class="row">
						<div class="col-xs-12">
							<p class="card-category">Calls Received</p>
						</div>
						<div class="col-xs-4">
							<img src="{{ asset('crm_public/images/incoming-call.png') }}"  />
						</div>
						<div class="col-xs-8">
							<div class="numbers">
								<p class="card-title" id="call_received">0</p>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>

	</div>


	<div class="column row">
		<div class="col-md-9 col-xs-12">
			<div class="row">
				<div class="col-md-6 rmb-20 mb-30 pie-c">
					<div class="ui very padded segment p-25 card-3">
						<?php
							$title = trans('laralum.members_graph_per_issue_status');
							$labels = [];
							$data = [];
							$colors = [];
							foreach(Laralum::getIssueType() as $issue){
								array_push($labels, $issue[1]);
								if(Laralum::loggedInUser()->reseller_id==0){
								  array_push($data, count(App\Member_Issue::where('client_id', Laralum::loggedInUser()->id)->where('status', $issue[0])->get()));
								}else{
								  array_push($data, count(App\Member_Issue::where('created_by', Laralum::loggedInUser()->id)->where('status', $issue[0])->get()));
								}
								array_push($colors, $issue[2]);
							}
						?>
						{!! Laralum::pieChart($title, $labels, $data, $colors) !!}
					</div>
				</div>

				<div class="col-md-6 rmb-20 mb-30">
					<div class="ui very padded segment p-25 card-1">
						<?php
							$title = trans('laralum.members_graph_per_account_type');
							$labels = [];
							$data = [];
							$colors = [];
							foreach($account_types as $type){
								array_push($labels, $type->title);
								if(Laralum::loggedInUser()->reseller_id==0){
								  array_push($data, count(App\Lead::where('client_id', Laralum::loggedInUser()->id)->where('account_type', $type->title)->get()));
								}else{
								  array_push($data, count(App\Lead::where('created_by', Laralum::loggedInUser()->id)->where('account_type', $type->title)->get()));
								}
								array_push($colors, $type->color);
							}
						?>
						{!! Laralum::pieChart($title, $labels, $data, $colors) !!}
					</div>
				</div>
				<br>
				<div class="col-md-12 rmb-20">
					<div class="ui very padded segment p-25 card-2">
						{!! Laralum::widget('latest_member_graph') !!}
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
			<div class="ui very padded segment new-dashboard-list bg-color-1 card-1 col-xs-12">
				<a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')">
					<div class="row">
						<div class="col-xs-12">
							<p class="card-category">Total Issues</p>
						</div>
						<div class="col-xs-4">
							<i class="far fa-question-circle"></i>
						</div>
						<div class="col-xs-8">
							<div class="numbers">
								<p class="card-title" id="total_issues">{{ $total_issues }}</p>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="ui very padded segment new-dashboard-list bg-color-2 card-2 col-xs-12">
				<a href="{{ route('Crm::leads', ['issue_status' => 1]) }}">
					<div class="row">
						<div class="col-xs-12">
							<p class="card-category">Issues Resolved</p>
						</div>
						<div class="col-xs-4">
							<i class="fas fa-check-double"></i>
						</div>
						<div class="col-xs-8">
							<div class="numbers">
								<p class="card-title" id="resolved_issue">{{ $resolved_issues }}</p>
							</div>
						</div>
					</div>
				</a>
			</div>

			<div class="ui very padded segment new-dashboard-list bg-color-3 card-3 col-xs-12">
				<a href="{{ route('Crm::leads', ['issue_status' => 2]) }}">
					<div class="row">
						<div class="col-xs-12">
							<p class="card-category">Pending Issues.</p>
						</div>
						<div class="col-xs-4">
							<i class="far fa-question-circle"></i>
						</div>
						<div class="col-xs-8">
							<div class="numbers">
								<p class="card-title" id="pending_issue">{{ $pending_issues }}</p>
							</div>
						</div>
					</div>
				</a>
			</div>

		</div>
	</div>
</div>
@endsection
@section('js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
</script>

@endsection