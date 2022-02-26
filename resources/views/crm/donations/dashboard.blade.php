@extends('layouts.crm.panel')
@section('title', trans('laralum.donation_dashboard_title'))
@section('icon', "mobile")
@section('subtitle', trans('laralum.donation_dashboard_title'))
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
			<h3 class="mt-15 rmb-20">{{ trans('laralum.donation_dashboard_title') }}</h3>
		</div>
		<div class="col-md-7 text-right rmb-20">		
			<form class="form-inline">
			  <div class="form-group w-auto mb-0 mr-5">
				<div id="reportrange" class="btn btn-primary" style="cursor:pointer;padding:5px 10px;width:auto;display:inline-block;">
					<i class="fas fa-calendar-check"></i>&nbsp;
					<span></span>&nbsp;&nbsp;<i class="fas fa-angle-down"></i>&nbsp;&nbsp;<img id="dash_loader" style="display:none;" src="{{ asset('crm_public/images/dash_filter_loader.png') }}"/>
				</div>
			  </div>
			   <a href="{{ route('Crm::donations') }}" class="btn btn-primary mr-5"><i class="fas fa-eye"></i> <span class="r-none">{{ trans('laralum.view_donation_title') }}</span></a>
			   <a href="{{ route('Crm::donation_create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> <span class="r-none">{{ trans('laralum.add_donation_title') }}</span></a>
			</form>			
		</div>
	</div>
	<div class="column row">
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-1">
			<a href="{{ route('Crm::donations', ['donation_type' => 1]) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Sponsor</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-user-tie"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">
					<p class="card-title" id="sponsor">{{ $sponser }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
  	</div>
	
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-2">
			<a href="{{ route('Crm::donations', ['donation_type' => 2]) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Land Donation</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-monument"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="land_donation">{{ $land }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
  	</div>
	
	<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
  	   <div class="ui very padded segment new-dashboard-list bg-color-3">
			<a href="{{ route('Crm::donations') }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category" id="total_call_made">Total Donations</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-sort-amount-up"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="total_donation">{{ $total }}</p>
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
					<p class="card-category">Today’s Donations</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-sort-amount-down"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					 <p class="card-title" id="today_donation">{{ $todays }}</p>
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
							$title = trans('laralum.donation_graph_donation_type_wise');
							$labels = [];
							$data = [];
							$colors = [];
							foreach(Laralum::getDonationType() as $type){
								array_push($labels, $type[1]);
								if(Laralum::loggedInUser()->reseller_id==0){
								  array_push($data, App\Donation::where('client_id', Laralum::loggedInUser()->id)->where('donation_type', $type[0])->sum('amount'));
								}else{
								  array_push($data, App\Donation::where('created_by', Laralum::loggedInUser()->id)->where('donation_type', $type[0])->sum('amount'));
								}
								array_push($colors, $type[2]);
							}
						?>
						{!! Laralum::pieChart($title, $labels, $data, $colors) !!}
					</div>
				</div>
				
				<div class="col-md-6 rmb-20 mb-30">
					<div class="ui very padded segment p-25 card-1">
						{!! Laralum::widget('payment_modes') !!}				
					</div>
				</div>
				<br>
				<div class="col-md-12 rmb-20">
					<div class="ui very padded segment p-25 card-2">
						{!! Laralum::widget('latest_donation_graph') !!}
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-3 col-sm-12 col-xs-12 rmb-20">
			<div class="ui very padded segment new-dashboard-list bg-color-1 card-1 col-xs-12">
			<a href="{{ route('Crm::donations', ['payment_mode' => 'CASH']) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Cash</p>
				</div>
				<div class="col-xs-4">
					<i class="far fa-money-bill-alt"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">				
					<p class="card-title" id="cash_amount">{{ $cash }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
		
		<div class="ui very padded segment new-dashboard-list bg-color-2 card-2 col-xs-12">
			<a href="{{ route('Crm::donations', ['payment_mode' => 'CARD']) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Cards</p>
				</div>
				<div class="col-xs-4">
					<i class="far fa-credit-card"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="card_amount">{{ $card }}</p>
					</div>
				</div>
			</div>
			</a>
		</div>
		
		<div class="ui very padded segment new-dashboard-list bg-color-3 card-3 col-xs-12">
			<a href="{{ route('Crm::donations', ['payment_mode' => 'CHEQUE']) }}">
			<div class="row">
				<div class="col-xs-12">
					<p class="card-category">Cheque</p>
				</div>
				<div class="col-xs-4">
					<i class="fas fa-money-check"></i>
				</div>
				<div class="col-xs-8">
					<div class="numbers">					
					<p class="card-title" id="cheque_amount">{{ $cheque }}</p>
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
					url: '{{ route("Crm::donations_dashboard_filter") }}',
					type: 'post',
					data: formData,
					dataType: 'json',
					success: function (data) {
						 $("#dash_loader").css('display','none');
						 if(data.status=='success'){				
							$("#sponsor").html(data.sponser);
							$("#land_donation").html(data.land);
							$("#total_donation").html(data.total);
							$("#today_donation").html(data.todays);							
							$("#cash_amount").html(data.card);							
							$("#card_amount").html(data.cash);							
							$("#cheque_amount").html(data.cheque);							
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