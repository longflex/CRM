@extends('layouts.crm.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('Crm::appointments') }}">{{  trans('laralum.appointments_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.appointment_create_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.appointment_create_title'))
@section('icon', "plus")
@section('subtitle', trans('laralum.appointment_create_subtitle'))
@section('content')
<div class="ui one column doubling stackable grid container">
    <div class="three wide column"></div>
	<div class="ui very padded segment">
    <div class="fifteen wide column">      
		 
	<div class="col-md-12">
		<h3 class="form-heading">Member Details</h3>
	</div>
	<div class="col-md-12">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<input type="text" class="form-control search-inp" id="search_from_leads" name="search_from_leads"  placeholder="Search member by 'Email' or 'Phone' " />
				<span class="search_loader" style="display:none;"><img src="{{ asset('/crm_public/images/search_loader.png') }}"></span>
			</div>
			<span id="search_text_error" style="color:red;display:none;">Please Enter 'Email' or 'Phone No.'</span>
		</div>
	</div>
	</div>
	<form class="ui form" action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="upload_appointment_form">
		{{ csrf_field() }}	
			<div class="lead_data" style="display:none;">			
            </div>			
			<div class="col-md-12">
				<hr>
			</div>			
			<div class="col-md-12">
				<h3 class="form-heading">Appointment Details</h3>
			</div>		
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-8">
					<div class="form-group">
					<label>Service Request<span style="color:red;">*</span></label>															
					<textarea class="form-control" id="service_request" placeholder="Write service request.." name="service_request" rows="3" /></textarea>																						
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
							 <option value="{{ $staff->id }}" >{{ $staff->name }}</option>
						 @endforeach
						</select>									
					</div>													
					</div>					
					<div class="col-md-4">
					 <div class="form-group">
						<label>Date<span style="color:red;">*</span></label>															
						<input type="date" class="form-control" id="apt_date" name="apt_date" />							
						</div>													
					</div>
								
									
				</div>
				
				<div class="row">
					<div class="col-md-8">
						<label>Time Slots<span style="color:red;">*</span></label>	
						<div class="panel panel-default light-blue">
							<div class="panel-body" id="slots_list">
								<span class="slots_loader" style="display:none;"><img src="{{ asset('/crm_public/images/slots_loader.png') }}"></span>
															
							</div>
						</div>
					</div>
				</div>
				
				
			</div>						
		<div class="col-md-12 text-right mb-30 mt-30">
		<button type="submit" id="aptForm" class="ui {{ Laralum::settings()->button_color }} submit button"><span id="hideapttext">{{ trans('laralum.save') }}</span>&nbsp;
		<span class="aptForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
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