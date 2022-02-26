@extends('layouts.crm.panel')
@section('title', trans('laralum.appointments_dashboard_title'))
@section('icon', "mobile")
@section('subtitle', trans('laralum.appointments_dashboard_title'))
@section('content')
<style>
.ui.grid>.row
{
 display: table !important;
}
</style>
  <div class="ui one column doubling stackable grid container mb-20">
  	<div class="column row pb-0 rmb-20">
		<div class="col-md-5">
			<h3 class="mt-15 rmb-20">{{ trans('laralum.appointments_dashboard_title') }}</h3>
		</div>
		<div class="col-md-7 text-right rmb-20">		
			<form class="form-inline">
			  <div class="form-group w-auto mb-0 mr-5">
				<div id="reportrange" class="btn btn-primary" style="cursor:pointer;padding:5px 10px;width:auto;display:inline-block;">
					<i class="fas fa-calendar-check"></i>&nbsp;
					<span></span>&nbsp;&nbsp;<i class="fas fa-angle-down"></i>&nbsp;&nbsp;<img id="dash_loader" style="display:none;" src="{{ asset('crm_public/images/dash_filter_loader.png') }}"/>
				</div>
			  </div>
			   <a href="{{ route('Crm::appointments') }}" class="btn btn-primary mr-5"><i class="fas fa-eye"></i> <span class="r-none">{{ trans('laralum.view_appointments') }}</span></a>
			   <a href="{{ route('Crm::appointments_create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <span class="r-none">{{ trans('laralum.add_appointment') }}</span></a>
			</form>			
		</div>
	</div>
	<div class="column row">
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-1">
			<a href="{{ route('Crm::appointments', ['status' => 'Completed']) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Completed appointments</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-calendar-check"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">
					<p class="card-title" id="completed_appointment">{{ $completed_appointment }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
  	</div>
	
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-2">
			<a href="{{ route('Crm::appointments', ['status' => 'Pending']) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Pending Appointments</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-calendar-times"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="pending_appointment">{{ $pending_appointment }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
  	</div>
	
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-3">
			<a href="{{ route('Crm::appointments') }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category" id="total_call_made">Total Appointments</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-calendar-alt"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="total_appointment">{{ $total_appointment }}</p>
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
					<p class="card-category">Today’s Appointments</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-calendar-plus"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					 <p class="card-title" id="today_appointment">{{ $today_appointment }}</p>
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
				<div class="col-md-6 rmb-20 mb-30">
					<div class="ui very padded segment p-25 card-3">
						<?php
							$title = trans('laralum.appointments_graph_status_wise');
							$labels = [];
							$data = [];
							$colors = [];
							foreach(Laralum::getAptStatus() as $status){
								array_push($labels, $status[1]);
								if(Laralum::loggedInUser()->reseller_id==0){
								  array_push($data, count(App\Appointment::where('client_id', Laralum::loggedInUser()->id)->where('status', $status[0])->get()));
								}else{
								  array_push($data, count(App\Appointment::where('created_by', Laralum::loggedInUser()->id)->where('status', $status[0])->get()));
								}
								array_push($colors, $status[2]);
							}
						?>
						{!! Laralum::pieChart($title, $labels, $data, $colors) !!}
					</div>
				</div>
				
				<div class="col-md-6 rmb-20 mb-30">
					<div class="ui very padded segment p-25 card-1">
						 <?php
							$appointment_per_status['labels'] = [];
							$appointment_per_status['data'] = [];
							$appointment_per_status['colors'] = [];
							
							foreach(Laralum::getAptStatusNew() as $newstatus) {
								array_push($appointment_per_status['labels'], $newstatus[1]);
								if(Laralum::loggedInUser()->reseller_id==0){
								  array_push($appointment_per_status['data'], count(App\Appointment::where('client_id', Laralum::loggedInUser()->id)->where('status', $newstatus[0])->get()));
								}else{
								  array_push($appointment_per_status['data'], count(App\Appointment::where('created_by', Laralum::loggedInUser()->id)->where('status', $newstatus[0])->get()));
								}
								array_push($appointment_per_status['colors'], $newstatus[2]);
							}
							$appointment_per_status['element_label'] = trans('laralum.apt_count');
							$appointment_per_status['title'] = trans('laralum.appointments_graph_status_wise');
						?>
						{!! Laralum::barChart($appointment_per_status['title'], $appointment_per_status['element_label'], $appointment_per_status['labels'], $appointment_per_status['data'], $appointment_per_status['colors']) !!}				
					</div>
				</div>
				<br>
				<div class="col-md-12 rmb-20">
					<div class="ui very padded segment p-25 card-2">
						{!! Laralum::widget('latest_appointment_graph') !!}
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
			<div class="ui very padded segment new-dashboard-list bg-color-1 card-1 col-xs-12">
			<a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Average Bookings</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-adjust"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">				
					<p class="card-title" id="average_booking">{{ $average_booking }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
		
		<div class="ui very padded segment new-dashboard-list bg-color-2 card-2 col-xs-12">
			<a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">New Customers</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-user-plus"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="new_customer">{{ $newcustomer }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
		
		<div class="ui very padded segment new-dashboard-list bg-color-3 card-3 col-xs-12">
			<a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Recurring Appointments</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-recycle"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="recurring_appointments">{{ $returncustomer }}</p>
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
					url: '{{ route("Crm::apt_dashboard_filter") }}',
					type: 'post',
					data: formData,
					dataType: 'json',
					success: function (data) {
						 $("#dash_loader").css('display','none');
						 if(data.status=='success'){				
							$("#completed_appointment").html(data.completed_appointment);
							$("#pending_appointment").html(data.pending_appointment);
							$("#total_appointment").html(data.total_appointment);
							$("#today_appointment").html(data.today_appointment);							
							$("#average_booking").html(data.average_booking);							
							$("#new_customer").html(data.newcustomer);							
							$("#recurring_appointments").html(data.returncustomer);							
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