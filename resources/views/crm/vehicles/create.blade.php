@extends('layouts.crm.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('Crm::vehicles') }}">{{  trans('laralum.vehicle_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.vehicle_create_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.vehicle_create_title'))
@section('icon', "plus")
@section('subtitle', trans('laralum.vehicle_create_subtitle'))
@section('content')
<div class="ui one column doubling stackable grid container">
<div class="three wide column"></div>
<div class="ui very padded segment">
<div class="fifteen wide column">      
<form class="ui form" action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="upload_vehicle_form">
	{{ csrf_field() }}
	<!--form--1-->
	<div class="row">	
		<div class="col-md-3">
			 <div class="form-group">
				 <label>Vehicle type<span style="color:red;"></span></label>
				 <select id="vehicle_type" name="vehicle_type" class="inp-form custom-select">
					  <option value="">Please select</option>
					  <option value="1" selected="selected">Two Wheeler</option>
					  <option value="2">Four Wheeler (non transport)</option>
					  <option value="3">Light commercial vehicle</option>
					  <option value="4">Heavy Commercial</option>
				 </select>
			 </div>
		 </div>
		 <div class="col-md-3">
			 <div class="form-group">
			    <label for="vehicle_name">Vehicle Name<span style="color:red;"></span></label>
			    <input class="inp-form" id="vehicle_name" placeholder="Vehicle Name" name="vehicle_name" type="text">		 
			 </div>		 
		 </div>
		 <div class="col-md-3">
			 <div class="form-group">
			   <label for="branch">Branch<span style="color:red;"></span></label>
			   <input class="inp-form" id="branch" placeholder="Branch Name" name="branch" type="text">		
			</div>		 
		 </div>

		 <div class="col-md-3" id="hidepurpose" style="display:none;">
		    <div class="form-group">
			 <label for="purpose">Purpose<span style="color:red;"></span></label>
			 <input class="inp-form" id="purpose" placeholder="Purpose.." name="purpose" type="text">		 
		   </div>		 
		 </div>	 
	</div>
<!--form--1-->			
<div class="col-md-12">
<hr />
</div>				
<!--vehicle-details-form-->
<div class="row"> 	 	 
<div class="col-md-12">
<h3 class="form-heading">Vehicle Details</h3>
</div>
		<div class="col-md-3">
		  <div class="form-group">
			<label for="reg_no">Reg No<span style="color:red;"></span></label>
			<input class="inp-form" id="reg_no" placeholder="Reg No." name="reg_no" type="text">
		  </div>	
		</div>	

		<div class="col-md-3">
		  <div class="form-group">
			<label for="engine_no">Engine No<span style="color:red;"></span></label>
			<input class="inp-form" id="engine_no" placeholder="Engine No" name="engine_no" type="text">
		  </div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="model_no">Model No<span style="color:red;"></span></label>
				<input class="inp-form" id="model_no" placeholder="Model No" name="model_no" type="text">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="fuel_type">Fuel Type<span style="color:red;"></span></label>
				<select id="fuel_type" name="fuel_type" class="custom-select">
					<option value="">Please select</option>
					<option value="1">Deisel</option>
					<option value="2">Petrol</option>
					<option value="3">Gas</option>	  
				</select>
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="km_drive">KM Drive<span style="color:red;"></span></label>
				<input class="inp-form" id="km_drive" placeholder="KM Drive" name="km_drive" type="text">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="last_service">Last Service<span style="color:red;"></span></label>
				<input class="inp-form" id="last_service" placeholder="Last Service" name="last_service" type="date">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="next_service">Next Service<span style="color:red;"></span></label>
				<input class="inp-form" id="next_service" placeholder="Next Service" name="next_service" type="date">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="next_service_km">Next Service KM<span style="color:red;"></span></label>
				<input class="inp-form" id="next_service_km" placeholder="Next Service KM" name="next_service_km" type="text">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="insurance_no">Insurance No<span style="color:red;"></span></label>
				<input class="inp-form" id="insurance_no" placeholder="Insurance No." name="insurance_no" type="text">
			</div>
		</div>

		<div class="col-md-3">
			<div class="form-group">
				<label for="insurance_date">Insurance Exp Date<span style="color:red;"></span></label>
				<input class="inp-form" id="insurance_date" placeholder="Insurance Date" name="insurance_date" type="date">
			</div>
		</div>

		<div class="col-md-3" id="roadtaxexp" style="display:none;">
			<div class="form-group">
				<label for="road_tax_expiry">Road Tax Expiry<span style="color:red;"></span></label>
				<input class="inp-form" id="road_tax_expiry" placeholder="Road Tax Expiry" name="road_tax_expiry" type="date">
			</div>
		</div>

		<div class="col-md-3" id="chassisno" style="display:none;">
			<div class="form-group">
				<label for="chassis_no">Chassis No<span style="color:red;"></span></label>
				<input class="inp-form" id="chassis_no" placeholder="Chassis No." name="chassis_no" type="text">
			</div>
		</div>

		<div class="col-md-3" id="fitnessfield" style="display:none;">
			<div class="form-group">
				<label for="fitness">Fitness Exp Date<span style="color:red;"></span></label>
				<input class="inp-form" id="fitness" placeholder="Fitness Exp Date" name="fitness" type="date">
			</div>	 
		</div>	 

		<div class="col-md-3">
			<div class="form-group">
				<label for="pollution">Pollution Exp<span style="color:red;"></span></label>
				<input class="inp-form" id="pollution" placeholder="Pollution Exp" name="pollution" type="date">
			</div>
		</div>

		<div class="col-md-3" id="roadtaxno" style="display:none;">
			<div class="form-group">
				<label for="road_tax_no">Road TAX No<span style="color:red;"></span></label>
				<input class="inp-form" id="road_tax_no" placeholder="Road TAX No" name="road_tax_no" type="text">
			</div>
		</div>

		<div class="col-md-3" id="permitfield" style="display:none;">
			<div class="form-group">
				<label for="permit">Permit Exp Date<span style="color:red;"></span></label>
				<input class="inp-form" id="permit" placeholder="Permit Exp Date" name="permit" type="date">
			</div>
		</div>
 </div>  
<!--vehicle-details-form-->								
<div class="col-md-12 text-right mb-30 mt-30">
<button type="submit" id="vehicleForm" class="ui {{ Laralum::settings()->button_color }} submit button"><span id="hide_vehicles_text">{{ trans('laralum.save') }}</span>&nbsp;
<span class="vehicleForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
</button>
</div>				
</form>
</div>
</div>
<div class="three wide column"></div>
</div>
<script src="{{ asset('crm_public/js/vehicles-script.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
<script type="text/javascript">
$('#vehicle_type').on('change', function () {
    if(this.value === "2" || this.value === "3" || this.value === "4"){
        $("#chassisno").show();       
    } else {
        $("#chassisno").hide();
    }
	
	if(this.value === "3" || this.value === "4"){
        $("#roadtaxno").show();
        $("#roadtaxexp").show();
        $("#fitnessfield").show();
        $("#permitfield").show();		
        $("#hidepurpose").show();		
    } else {
        $("#roadtaxno").hide();
        $("#roadtaxexp").hide();
        $("#fitnessfield").hide();
        $("#permitfield").hide();		
        $("#hidepurpose").hide();		
    }
});
</script>
@endsection