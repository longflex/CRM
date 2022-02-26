@extends('layouts.crm.panel')
@section('title', trans('laralum.vehicle_dashboard_title'))
@section('icon', "mobile")
@section('subtitle', trans('laralum.vehicle_dashboard_title'))
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
			<h3 class="mt-15 rmb-20">{{ trans('laralum.vehicle_dashboard_title') }}</h3>
		</div>
		<div class="col-md-7 text-right rmb-20">		
			<form class="form-inline">
			  <div class="form-group w-auto mb-0 mr-5">
				<div id="reportrange" class="btn btn-primary" style="cursor:pointer;padding:5px 10px;width:auto;display:inline-block;">
					<i class="fas fa-calendar-check"></i>&nbsp;
					<span></span>&nbsp;&nbsp;<i class="fas fa-angle-down"></i>&nbsp;&nbsp;<img id="dash_loader" style="display:none;" src="{{ asset('crm_public/images/dash_filter_loader.png') }}"/>
				</div>
			  </div>
			   <a href="{{ route('Crm::vehicles') }}" class="btn btn-primary mr-5"><i class="fas fa-eye"></i> <span class="r-none">{{ trans('laralum.view_vehicle_title') }}</span></a>
			   <a href="{{ route('Crm::vehicle_create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <span class="r-none">{{ trans('laralum.add_vehicle_title') }}</span></a>
			</form>			
		</div>
	</div>
	<div class="column row">
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-1">
			<a href="{{ route('Crm::vehicles', ['vehicle_type' => 1]) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Two Wheeler</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-motorcycle"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">
					<p class="card-title" id="two_wheeler">{{ $two_wheeler }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
  	</div>
	
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-2">
			<a href="{{ route('Crm::vehicles', ['vehicle_type' => 2]) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Four Wheeler</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-car"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="four_wheeler">{{ $four_wheeler }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
  	</div>
	
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-3">
			<a href="{{ route('Crm::vehicles') }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category" id="total_call_made">Total Vehicles</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-sort-amount-up"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="total_vehicles">{{ $total }}</p>
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
					<p class="card-category">Today’s Vehicles</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-sort-amount-down"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					 <p class="card-title" id="today_vehicles">{{ $todays }}</p>
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
							$title = trans('laralum.vehicle_graph_fuel_type_wise');
							$labels = [];
							$data = [];
							$colors = [];
							foreach(Laralum::getFuelType() as $type){
								array_push($labels, $type[1]);
								if(Laralum::loggedInUser()->reseller_id==0){
								  array_push($data, count(App\Vehicle::where('client_id', Laralum::loggedInUser()->id)->where('fuel_type', $type[0])->get()));
								}else{
								  array_push($data, count(App\Vehicle::where('created_by', Laralum::loggedInUser()->id)->where('fuel_type', $type[0])->get()));
								}
								array_push($colors, $type[2]);
							}
						?>
						{!! Laralum::pieChart($title, $labels, $data, $colors) !!}
					</div>
				</div>
				
				<div class="col-md-6 rmb-20 mb-30">
					<div class="ui very padded segment p-25 card-1">
						{!! Laralum::widget('vehicle_type_graph') !!}				
					</div>
				</div>
				<br>
				<div class="col-md-12 rmb-20">
					<div class="ui very padded segment p-25 card-2">
						{!! Laralum::widget('latest_vehicles_graph') !!}
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
			<div class="ui very padded segment new-dashboard-list bg-color-1 card-1 col-xs-12">
			<a href="{{ route('Crm::vehicles', ['fuel_type' => 1]) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Deisel</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-gas-pump"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">				
					<p class="card-title" id="deisel">{{ $deisel }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
		
		<div class="ui very padded segment new-dashboard-list bg-color-2 card-2 col-xs-12">
			<a href="{{ route('Crm::vehicles', ['fuel_type' => 2]) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Petrol</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-gas-pump"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="petrol">{{ $petrol }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
		
		<div class="ui very padded segment new-dashboard-list bg-color-3 card-3 col-xs-12">
			<a href="{{ route('Crm::vehicles', ['fuel_type' => 3]) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Gas</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-gas-pump"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="gas">{{ $gas }}</p>
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
					url: '{{ route("Crm::vehicles_dashboard_filter") }}',
					type: 'post',
					data: formData,
					dataType: 'json',
					success: function (data) {
						 $("#dash_loader").css('display','none');
						 if(data.status=='success'){				
							$("#two_wheeler").html(data.two_wheeler);
							$("#four_wheeler").html(data.four_wheeler);
							$("#total_vehicles").html(data.total);						
							$("#deisel").html(data.deisel);							
							$("#petrol").html(data.petrol);							
							$("#gas").html(data.gas);							
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