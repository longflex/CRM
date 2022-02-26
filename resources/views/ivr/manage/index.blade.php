@extends('layouts.ivr.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
  <div class="active section">Settings</div>
</div>
@endsection
@section('title', "Settings")
@section('content')
<div class="ui one column doubling stackable grid container mb-30">
<div class="column">
 <div class="ui very padded segment">
<div class="col-md-12">
<ul class="nav nav-tabs">
  <li class="active"><a class="ripple" data-toggle="tab" href="#kyc"><i class="fa fa-cog" aria-hidden="true"></i><span>KYC</span></a></li>
  &nbsp;&nbsp;<li><a class="ripple" data-toggle="tab" href="#payment"><i class="fa fa-credit-card-alt" aria-hidden="true"></i><span>PLAN & PAYMENT</span></a></li>
  &nbsp;&nbsp;<li><a class="ripple" data-toggle="tab" href="#staff"><i class="fa fa-users" aria-hidden="true"></i><span>STAFF</span></a></li> 
</ul>

<div class="tab-content">
  <!--kyc-form-->
<div id="kyc" class="tab-pane fade in active">  
<form role="form" id="kyc_creation_form" method="POST" enctype="multipart/form-data" action="javascript:void(0)">
	<div class="row">
		<div class="col-md-12">
			<h3 class="sub-heading mb-15">Business Profile</h3>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Business Type</label>
				<select class="form-control custom-select" id="business_type" name="business_type">
				<option>Select Business Type</option>
				@foreach($industries as $key=>$val)
				 <option value="{{ $key }}" @if(isset($kyc_info) && $kyc_info->business_type==$key) selected="selected" @endif >{{ $val }}</option>
				@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Business Name <small>(For Billing)</small></label>
				<input type="text" placeholder="Enter business name" class="form-control" id="business_name" name="business_name" value="{{ isset($kyc_info) && !empty($kyc_info->business_name) ? $kyc_info->business_name : '' }}" />
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Business PAN</label>
				<input type="text" class="form-control" placeholder="Enter valid PAN number" id="business_pan" name="business_pan" value="{{ isset($kyc_info) && !empty($kyc_info->business_pan) ? $kyc_info->business_pan : '' }}" />
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>GST State</label>
				<select class="form-control custom-select" id="gst_state" name="gst_state">
					<option>Select Your State</option>
					@foreach($get_state as $state)
					  <option value="{{ $state->StCode }}" @if(isset($kyc_info) && $kyc_info->gst_state==$state->StCode) selected="selected" @endif>{{ $state->StateName }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>GSTIN</label>
				<input type="text" class="form-control" placeholder="Enter valid GSTIN" id="gstin" name="gstin" value="{{ isset($kyc_info) && !empty($kyc_info->gstin) ? $kyc_info->gstin : '' }}" />
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<label>Billing Address</label>
			<textarea class="form-control input-txt" placeholder="Enter billing address.." id="billing_address" name="billing_address">{{ isset($kyc_info) && !empty($kyc_info->billing_address) ? $kyc_info->billing_address : '' }}</textarea>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Country</label>
						<select class="form-control custom-select" id="billing_country" name="billing_country">
							<option>Select country</option>
							@foreach($get_countries as $country)
							  <option value="{{ $country->id }}" @if(isset($kyc_info) && $kyc_info->billing_country==$country->id) selected="selected" @endif>{{ $country->country_name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>State</label>
						 <select class="form-control custom-select" id="billing_state" name="billing_state">
							<option value="">Select state</option>
							@foreach($get_state as $state)
							  <option value="{{ $state->StCode }}" @if(isset($kyc_info) && $kyc_info->billing_state==$state->StCode) selected="selected" @endif>{{ $state->StateName }}</option>
							@endforeach
						</select>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="form-group">
						<label>City</label>
						 <select class="form-control custom-select" id="billing_city" name="billing_city">
						 <option value="">Select city</option>
						  @foreach($get_city as $city)
							 <option value="{{ $city->DistCode }}" @if(isset($kyc_info) && $kyc_info->billing_city==$city->DistCode) selected="selected" @endif>{{ $city->DistrictName }}</option>
						  @endforeach
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Pincode</label>
						<input type="text" class="form-control" placeholder="Enter pincode" id="billing_pincode" name="billing_pincode" value="{{ isset($kyc_info) && !empty($kyc_info->billing_pincode) ? $kyc_info->billing_pincode : '' }}" />
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row mt-20">
		<div class="col-md-12">
			<h3 class="mb-15">Primary Contact Info</h3>
		</div>
		
		<div class="col-md-3">
			<div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" placeholder="Enter name" id="primary_contact_name" name="primary_contact_name" value="{{ isset($kyc_info) && !empty($kyc_info->primary_contact_name) ? $kyc_info->primary_contact_name : '' }}" />
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Email</label>
				<input type="email" class="form-control" placeholder="Enter valid email" id="primary_contact_email" name="primary_contact_email" value="{{ isset($kyc_info) && !empty($kyc_info->primary_contact_email) ? $kyc_info->primary_contact_email : '' }}" />
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Mobile</label>
				<input type="text" class="form-control" placeholder="Enter valid mobile no." id="primary_contact_mobile" name="primary_contact_mobile" value="{{ isset($kyc_info) && !empty($kyc_info->primary_contact_mobile) ? $kyc_info->primary_contact_mobile : '' }}" />
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Designation</label>
				<select class="form-control custom-select" id="designation_country" name="designation_country" >
					<option value="">Select Your Country</option>
					@foreach($get_countries as $country)
					  <option value="{{ $country->id }}" @if(isset($kyc_info) && $kyc_info->designation_country==$country->id) selected="selected" @endif>{{ $country->country_name }}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	
	<div class="row mt-20">
		<div class="col-md-12">
			<h3 class="mb-15">KYC Verification</h3>
		</div>
		
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3 kyc-img-area">
					<div class="form-group">
						<p><b>Photo Identification</b><br><small>{{ isset($kyc_info) && !empty($kyc_info->kyc_id_proof_type) ? $kyc_info->kyc_id_proof_type : 'N/A' }}</small></p>
						<div class="kyc-img-main">
							<img src="{{ asset('ivr_public/data/id_proof') }}/{{ isset($kyc_info) && !empty($kyc_info->id_proof_doc) ? $kyc_info->id_proof_doc : '' }}" class="img-responsive">
							@if($kyc_info->id_proof_status==2)
							<span class="red">Rejected</span>
						    @elseif($kyc_info->id_proof_status==1)
							<span class="green">Approved</span>
							@else
							<span class="yellow">Pending</span>
						    @endif
						</div>
					</div>
				</div>
				
				<div class="col-md-3 kyc-img-area">
					<div class="form-group">
						<p><b>Billing Address</b><br><small>{{ isset($kyc_info) && !empty($kyc_info->kyc_address_proof_type) ? $kyc_info->kyc_address_proof_type : 'N/A' }}</small></p>
						<div class="kyc-img-main">
							<img src="{{ asset('ivr_public/data/address_proof') }}/{{ isset($kyc_info) && !empty($kyc_info->address_proof_doc) ? $kyc_info->address_proof_doc : '' }}" class="img-responsive">
							@if($kyc_info->address_proof_status==2)
							<span class="red">Rejected</span>
						    @elseif($kyc_info->address_proof_status==1)
							<span class="green">Approved</span>
							@else
							<span class="yellow">Pending</span>
						    @endif
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="form-group">
				<div class="radio">
				  <label>
					<input type="radio" name="verification_type" id="optionsRadios1" value="Aadhaar-based" {{ ($kyc_info->verification_type=="Aadhaar-based")? "checked" : "" }} />
					Aadhaar-based esign <small>(Instant verification)</small>
				  </label>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<div class="radio">
				  <label>
					<input type="radio" name="verification_type" id="optionsRadios2" value="Documents-based" {{ ($kyc_info->verification_type=="Documents-based")? "checked" : "" }} />
					Documents-based verification <small>(Takes 2-3 working days). Only .png, .jpg, .pdf, .doc, .docx file accepted.</small>
				  </label>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row mt-20">
		<div class="col-md-2">
			<div class="form-group">
				<label>Identification</label>
			</div>
		</div>
		<div class="col-md-3">
			<select class="form-control custom-select" id="kyc_id_proof_type" name="kyc_id_proof_type" >
				<option value="">---Select ID Proof---</option>
				<option value="Passport" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Passport') selected="selected" @endif>Passport</option>
				<option value="PAN Card" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='PAN Card') selected="selected" @endif>PAN Card</option>
				<option value="Voter ID" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Voter ID') selected="selected" @endif>Voter ID</option>
				<option value="Driving License" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Driving License') selected="selected" @endif>Driving License</option>
				<option value="Government Photo ID Cards" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Government Photo ID Cards') selected="selected" @endif>Government Photo ID Cards</option>
				<option value="Photo Bank ATM Card" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Photo Bank ATM Card') selected="selected" @endif>Photo Bank ATM Card</option>
				<option value="Photo Credit Card" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Photo Credit Card') selected="selected" @endif>Photo Credit Card</option>
				<option value="Pensioner Photo Card" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Pensioner Photo Card') selected="selected" @endif>Pensioner Photo Card</option>
				<option value="Freedom Fighter Photo Card" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Freedom Fighter Photo Card') selected="selected" @endif>Freedom Fighter Photo Card</option>
				<option value="Kissan Photo Passbook" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Kissan Photo Passbook') selected="selected" @endif>Kissan Photo Passbook</option>
				<option value="Marriage certificate with photograph" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='Marriage certificate with photograph') selected="selected" @endif>Marriage certificate with photograph</option>
				<option value="CGHS/ ECHS Photo Card" @if(isset($kyc_info) && $kyc_info->kyc_id_proof_type=='CGHS/ ECHS Photo Card') selected="selected" @endif>CGHS/ ECHS Photo Card</option>
			</select>
		</div>
		<div class="col-md-3">
			<div class="upload-btn-wrapper">
				<button class="btn">+ Add Files</button>
				<input type="file" name="id_proof" id="id_proof" onChange="validateFile(this.value)" />
				<input type="hidden" name="id_proof_hidden" id="id_proof_hidden" value="{{ isset($kyc_info) && !empty($kyc_info->id_proof_doc) ? $kyc_info->id_proof_doc : '' }}" />
			</div>
		</div>
	</div>
	
	<div class="row mt-20">
		<div class="col-md-2">
			<div class="form-group">
				<label>Billing Address</label>
			</div>
		</div>
		<div class="col-md-3">
			<select class="form-control custom-select" id="kyc_address_proof_type" name="kyc_address_proof_type">
				<option value="">---Select Billing Address Proof---</option>
				<option value="Passport" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Passport') selected="selected" @endif>Passport</option>
				<option value="Bank Statement/ Passbook" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Bank Statement/ Passbook') selected="selected" @endif>Bank Statement/ Passbook</option>
				<option value="Post Office Account Statement/ Passbook" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Post Office Account Statement/ Passbook') selected="selected" @endif>Post Office Account Statement/ Passbook</option>
				<option value="Ration Card" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Ration Card') selected="selected" @endif>Ration Card</option>
				<option value="Voter ID" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Voter ID') selected="selected" @endif>Voter ID</option>
				<option value="Driving License" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Driving License') selected="selected" @endif>Driving License</option>
				<option value="Electricity Bill (not older than 3 months)" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Electricity Bill (not older than 3 months)') selected="selected" @endif>Electricity Bill (not older than 3 months)</option>
				<option value="Water Bill (not older than 3 months)" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Water Bill (not older than 3 months)') selected="selected" @endif>Water Bill (not older than 3 months)</option>
				<option value="Telephone Landline Bill (not older than 3 months)" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Telephone Landline Bill (not older than 3 months)') selected="selected" @endif>Telephone Landline Bill (not older than 3 months)</option>
				<option value="Property Tax Receipt (not older than 1 year)" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Property Tax Receipt (not older than 1 year)') selected="selected" @endif>Property Tax Receipt (not older than 1 year)</option>
				<option value="Credit Card Statement (not older than 3 months)" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Credit Card Statement (not older than 3 months)') selected="selected" @endif>Credit Card Statement (not older than 3 months)</option>
				<option value="Insurance Policy" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Insurance Policy') selected="selected" @endif>Insurance Policy</option>
				<option value="Arms License" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Arms License') selected="selected" @endif>Arms License</option>
				<option value="Freedom Fighter Card" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Freedom Fighter Card') selected="selected" @endif>Freedom Fighter Card</option>
				<option value="Kissan Passbook" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Kissan Passbook') selected="selected" @endif>Kissan Passbook</option>
				<option value="Gas Connection Bill (not older than 3 months)" @if(isset($kyc_info) && $kyc_info->kyc_address_proof_type=='Gas Connection Bill (not older than 3 months)') selected="selected" @endif>Gas Connection Bill (not older than 3 months)</option>
			</select>
		</div>
		<div class="col-md-3">
			<div class="upload-btn-wrapper">
				<button class="btn">+ Add Files</button>
				<input type="file" name="address_proof" id="address_proof" />
				<input type="hidden" name="address_proof_hidden" id="address_proof_hidden" value="{{ isset($kyc_info) && !empty($kyc_info->address_proof_doc) ? $kyc_info->address_proof_doc : '' }}" />
			</div>
		</div>
	</div>
	
	<ul class="list-inline pull-right">
		<li>
		<button type="submit" class="btn btn-primary">
		<span id="hidekyctext">Update</span>&nbsp;
		<span class="kycForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
		</button>
		</li>
	</ul>
	</form>
</div>
<!--kyc-form-->

 <!--plan-&-payment-->
 <div id="payment" class="tab-pane fade">
 <div class="row">
 <center>Plan & Payment</center>
 </div>
 </div>
<!--plan-&-payment-->
  
<!--IVR-Staff-->
<div id="staff" class="tab-pane fade">   
<div class="row">
<div class="col-md-12">
@if(count($staffs)>0)
<table class="ui table">
<thead>
<tr class="table_heading">
	<th width="25%">Name</th>
	<th width="15%">Phone</th>
	<th width="15%">Role</th>
	<th width="15%">Department</th>
	<th width="15%">&nbsp;&nbsp;</th>
</tr>
</thead>
<tbody>
@foreach($staffs as $staff)
<tr role="row" class="odd">
	<td>
	<div class="media">
		<div class="media-left">
			<img id="avatar-div" class="ui avatar image" src="{{ asset(Laralum::publicPath() .'/images/avatar.jpg') }}">
		</div>
		<div class="media-body">
			<div class="text">
				<a href="javascript:void(0);">{{ $staff->name }}</a>
				<br>
				<a href="javascript:void(0);">{{ $staff->email }}</a>
			</div>
		</div>
	</div>
	</td>
	<td>{{ $staff->mobile }}</td>
	<td>{{ $staff->role }}</td>
	<td>{{ $staff->department }}</td>
	<td class="text-center">
		<a data-fancybox="data-fancybox" data-type="iframe" href="{{ route('console::staff_profile', ['id' => $staff->id]) }}" class="btn btn-sm btn-primary btn-table"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
		<a href="javascript:void(0);" id="deleteData" data-id="{{$staff->id}}" data-type="staff" class="btn btn-sm btn-primary btn-table btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
		<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "staff"]) }}</p>
	</div>
</div>
@endif
</div>
</div>  
</div>
<!--IVR-Staff--> 
</div>
</div>    
</div>
</div>
</div>

<script src="{{ asset(Laralum::publicPath() .'/js/kyc-script.js') }}"></script>
<script>
$(document).ready(function() {
$('#billing_state').on('change', function() {
	var state_id = this.value;
	$("#billing_city").html('');
	$.ajax({
		url:"{{ route('Ivr::get-cities-by-state') }}",
		type: "POST",
		data: {
		state_id: state_id,
		_token: '{{csrf_token()}}'
		},
		success: function(result){
				$.each(result,function(key,value){
				     $("#billing_city").append('<option value="'+key+'">'+value+'</option>');
				});
			}
	   });
   });
});
</script>

<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
<script>
	$(document).ready(function() {
    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle='tab']", function(event) {
        location.hash = this.getAttribute("href");
    });
});
$(window).on("popstate", function() {
    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
    $("a[href='" + anchor + "']").tab("show");
});
</script>
@endsection

