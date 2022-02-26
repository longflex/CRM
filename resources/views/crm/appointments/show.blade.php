@extends('layouts.crm.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('Crm::appointments') }}">{{  trans('laralum.appointments_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.appointment_edit_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.appointment_edit_title'))
@section('icon', "plus")
@section('subtitle', trans('laralum.appointment_edit_subtitle'))
@section('content')
<div class="ui one column doubling stackable grid container">
    <div class="three wide column"></div>
	<div class="ui very padded segment">
    <div class="fifteen wide column">      
		 
	<div class="col-md-12">
		<h3 class="form-heading">
		Member Details
		@if($appointment->status=='Pending')
		<span class="badge badge-info pull-right">{{ $appointment->status }}</span>
		@else
		<span class="badge badge-success pull-right">{{ $appointment->status }}</span>	
		@endif
		</h3>
	</div>
	<div class="col-md-12">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group ">
				<label><span style="color:#f9ba48;"><i class="fa fa-user" aria-hidden="true"></i></span>&nbsp;Name</label></br>
				<span>{{ $appointment->name }}</span>										
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="form-group ">
				<label><span style="color:#f9ba48;"><i class="fa fa-envelope" aria-hidden="true"></i></span>&nbsp;Email</label></br>
				<span>{{ $appointment->email }}</span>	
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="form-group ">
				<label><span style="color:#f9ba48;"><i class="fa fa-mobile" aria-hidden="true"></i></span>&nbsp;Phone No.</label></br>
				<span>{{ $appointment->mobile }}</span>
			</div>
		</div>
								
		<div class="col-md-6">
			<div class="form-group ">
				<label><span style="color:#f9ba48;"><i class="fa fa-map-marker" aria-hidden="true"></i></span>&nbsp;Address</label></br>
				<span>{{ $appointment->address }}</span>
			</div>
		</div>
	</div>
	</div>
	<form class="ui form" action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="update_appointment_form">
		{{ csrf_field() }}	
		   <input type="hidden" class="form-control" id="apt_id" name="apt_id" value="{{ $appointment->id }}" />
			<div class="lead_data" style="display:none;">			
            </div>			
			<div class="col-md-12">
				<hr>
			</div>			
			<div class="col-md-12">
				<h3 class="form-heading">Appointment details</h3>
			</div>
            <div class="col-md-12">
				<div class="row">
					<div class="col-md-8">
					<div class="form-group">
					<label>Service Request<span style="color:red;">*</span></label>															
					<textarea class="form-control" id="service_request" placeholder="Write service request.." name="service_request" rows="3" />{{ $appointment->service_request }}</textarea>																						
					</div>
					</div>	
				</div>
				<div class="row">
                     <div class="col-md-4">
					 <div class="form-group">
						<label>Whom to meet?<span style="color:red;">*</span></label>															
						<select id="whom_to_meet" name="whom_to_meet" class="form-control custom-select">
						<option value="">Please select..</option>
						 @foreach($apt_staffs as $staff) 
							 <option value="{{ $staff->id }}" @if($appointment->whom_to_meet==$staff->id) selected @endif >{{ $staff->name }}</option>
						 @endforeach
						</select>									
					</div>													
					</div>					
					<div class="col-md-4">
					 <div class="form-group">
						<label>Date<span style="color:red;">*</span></label>															
						<input type="date" class="form-control" id="apt_date" name="apt_date" value="{{ $appointment->apt_date }}" />							
						</div>													
					</div>
								
									
				</div>
				
				<div class="row">
					<div class="col-md-8">
						<label>Time Slots<span style="color:red;">*</span></label>	
						<div class="panel panel-default light-blue">
							<div class="panel-body" id="slots_list">
							@foreach($time_slots as $slots)		 
							 <div class="time-slot-col plr-5" data-toggle="tooltip" title="{{ $slots->status }}">
								<div class="custom-radio-time">
									<input type="radio" name="time_slot" @if($appointment->time_slot==$slots->slot_time) checked @endif value="{{ $slots->slot_time }}" id="r{{ $slots->id }}" {!! ($slots->status == 'Booked') ? 'disabled' : '' !!} />
									<label for="r{{ $slots->id }}">{{ date("g:i", strtotime($slots->slot_time)) }}<span>{{ date("A", strtotime($slots->slot_time)) }}</span></label>
								</div>
							 </div>
							 @endforeach
							<span class="slots_loader" style="display:none;"><img src="{{ asset('/crm_public/images/slots_loader.png') }}"></span>															
							</div>
						</div>
					</div>
				</div>								
			</div>							
		  <div class="col-md-12 text-right mb-30 mt-30">
			<button type="submit" id="aptUpdateForm" class="ui {{ Laralum::settings()->button_color }} submit button"><span id="hideaptutext">{{ trans('laralum.save') }}</span>&nbsp;
			<span class="aptUpdateForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
			</button>
	    </div>				
	 </form>
     </div>
    </div>
    <div class="three wide column"></div>
</div>
<script src="{{ asset('crm_public/js/appointment-script.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection