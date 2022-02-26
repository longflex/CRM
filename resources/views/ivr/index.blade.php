@extends('layouts.ivr.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
  <div class="active section">Complete the setup</div>
</div>
@endsection
@section('title', "Complete the setup")
@section('content')
<div class="ui doubling stackable one column grid container-fluid pl-15 pr-15 m-0">
<div class="column">	  	  	  	  
<div class="ui very padded segment">
<div class="row">
		<section>
        <div class="wizard">          
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Users" onclick="$('.dimmer').removeClass('dimmer')">
                            <span class="round-tab">
                                <i class="fas fa-user"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Departments" onclick="$('.dimmer').removeClass('dimmer')">
                            <span class="round-tab">
                                <i class="far fa-building"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Call Flow" onclick="$('.dimmer').removeClass('dimmer')">
                            <span class="round-tab">
                                <i class="fas fa-project-diagram"></i>
                            </span>
                        </a>
                    </li>
					<li role="presentation" class="disabled">
                        <a href="#step4" data-toggle="tab" aria-controls="step3" role="tab" title="KYC Form" onclick="$('.dimmer').removeClass('dimmer')">
                            <span class="round-tab">
                                <i class="fab fa-wpforms"></i>
                            </span>
                        </a>
                    </li>
					<li role="presentation" class="disabled">
                        <a href="#step5" data-toggle="tab" aria-controls="step3" role="tab" title="Number Selection" onclick="$('.dimmer').removeClass('dimmer')">
                            <span class="round-tab">
                                <i class="fas fa-flag"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Plan and Payment" onclick="$('.dimmer').removeClass('dimmer')">
                            <span class="round-tab">
                                <i class="fas fa-money-check-alt"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

           
                <div class="tab-content">
				  <!---agent-creation-form-->
                    <div class="tab-pane active" role="tabpanel" id="step1">
					<form role="form" id="agent_creation_form" method="POST" enctype="multipart/form-data" action="javascript:void(0)">
                        <h3>Create New Agent</h3>
                        <small style="color:red;">All fields are required.</small>
						<div class="alert alert-danger" style="display:none"></div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Full Name&nbsp;<span style="color:red;">*</span></label>
									<input type="text" class="form-control" placeholder="Enter full name" id="full_name" name="full_name" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Mobile No.&nbsp;<span style="color:red;">*</span></label>
									<input type="text" class="form-control" placeholder="Enter mobile number" id="mobile_number" name="mobile_number" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Email&nbsp;<span style="color:red;">*</span></label>
									<input type="text" class="form-control" placeholder="Enter valid email address" id="email" name="email" />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Address&nbsp;<span style="color:red;">*</span></label>
									<textarea class="form-control input-txt" placeholder="Enter address" id="address" name="address"></textarea>
								</div>
							</div>
						</div>
						
						<div class="row mt-20">
							<div class="col-md-12">
								<h3 class="mb-20">Staff Status</h3>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Status Of Staff&nbsp;<span style="color:red;">*</span></label>
									<select class="form-control custom-select" id="staff_status" name="staff_status">
										<option value="">Select status</option>
										<option value="1">Active</option>
										<option value="0">Inactive </option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Role&nbsp;<span style="color:red;">*</span></label>
									<select class="form-control custom-select" id="role" name="role">
									    <option value="">Select role</option>
										@foreach($roles as $role)
										 <option value="{{ $role->id }}">{{ $role->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Working Days&nbsp;<span style="color:red;">*</span></label>
									<div class="custom-radio-days">
									<input type="checkbox" name="working_days[]" value="SUN" id="SUN">
									<label for="SUN">SUN</label>
									
									<input type="checkbox" name="working_days[]" value="MON" id="MON">
									<label for="MON">MON</label>
									
									<input type="checkbox" name="working_days[]" value="TUE" id="TUE">
									<label for="TUE">TUE</label>
									
									<input type="checkbox" name="working_days[]" value="WED" id="WED">
									<label for="WED">WED</label>
									
									<input type="checkbox" name="working_days[]" value="THU" id="THU">
									<label for="THU">THU</label>
									
									<input type="checkbox" name="working_days[]" value="FRI" id="FRI">
									<label for="FRI">FRI</label>
									
									<input type="checkbox" name="working_days[]" value="SAT" id="SAT">
									<label for="SAT">SAT</label>
									</div>	
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Working Hours&nbsp;<span style="color:red;">*</span></label>
									<div class="form-inline">
									  <div class="form-group">
										<input type="time" class="form-control" id="from_time" name="from_time" />
									  </div>
									  <div class="form-group">
										<label for="">To</label>
									  </div>
									  <div class="form-group">
										<input type="time" class="form-control" id="to_time" name="to_time" />
									  </div>
									</div>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Department&nbsp;<span style="color:red;">*</span></label>
									<select class="form-control custom-select" id="department" name="department">
										<option value="">Select department</option>
										@foreach($departments as $department)
										 <option value="{{ $department->id }}">{{ $department->department }}</option>
										@endforeach
									</select>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Allow DID to Staff&nbsp;<span style="color:red;">*</span></label>
									<input type="text" class="form-control" placeholder="Allow DID" name="allow_did" id="allow_did" />
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Password&nbsp;<span style="color:red;">*</span></label>
									<input type="text" class="form-control" placeholder="Enter password." name="staff_password" id="staff_password" />
								</div>
							</div>
							
						</div>
						
                        <ul class="list-inline pull-right mt-20">
                        <li>
						<button type="submit" class="btn btn-primary">
						<span id="hideagenttext">Save</span>&nbsp;
						<span class="agentForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
						</button>
						</li>
                        <li><button type="button" class="btn btn-primary next-step">Next</button></li>
                        </ul>
					</form> 
                    </div>
					<!---agent-creation-form-->
					
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h3>Departments</h3>
                        <p>Group users to departments and define call distribution patterns for call flow. Assign managers for them to view department wise call logs and reports.</p>
                       <form role="form" id="department_creation_form" method="POST" enctype="multipart/form-data" action="javascript:void(0)">            
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Department Name&nbsp;<span style="color:red;">*</span></label>
									<input type="text" class="form-control" placeholder="Enter department name" id="department_name" name="department_name" />
								</div>
							</div>
						</div>
						<ul class="list-inline pull-right">
							<li>
							<button type="submit" class="btn btn-primary">
							<span id="hidedpttext">Save</span>&nbsp;
							<span class="departmentForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
							</button>
							</li>
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-primary next-step">Next</button></li>
                        </ul>
					 </form>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h3>Call Flow</h3>
                        <p>Design call flow to distribute calls to different departments according to business timings. Send your callers to menus, extensions, departments and custom message.</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Next</button></li>
                        </ul>
                    </div>
				<!--kyc-form-->
				<div class="tab-pane" role="tabpanel" id="step4">
					<form role="form" id="kyc_creation_form" method="POST" enctype="multipart/form-data" action="javascript:void(0)">
                        <h3>KYC Form</h3>
                        
						<div class="row">
							<div class="col-md-12">
								<h3 class="sub-heading mb-15">Business Profile</h3>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Business Type</label>
									<select class="form-control custom-select" id="business_type" name="business_type" required>
									<option>Select Business Type</option>
									@foreach($industries as $key=>$val)
									 <option value="{{ $key }}">{{ $val }}</option>
									@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Business Name <small>(For Billing)</small></label>
									<input type="text" placeholder="Enter business name" class="form-control" id="business_name" name="business_name" required />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Business PAN</label>
									<input type="text" class="form-control" placeholder="Enter valid PAN number" id="business_pan" name="business_pan" required />
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>GST State</label>
									<select class="form-control custom-select" id="gst_state" name="gst_state" required>
										<option>Select Your State</option>
										@foreach($get_state as $state)
									      <option value="{{ $state->StCode }}">{{ $state->StateName }}</option>
									    @endforeach
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>GSTIN</label>
									<input type="text" class="form-control" placeholder="Enter valid GSTIN" id="gstin" name="gstin" required />
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<label>Billing Address</label>
								<textarea class="form-control input-txt" placeholder="Enter billing address.." id="billing_address" name="billing_address" required></textarea>
							</div>
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Country</label>
											<select class="form-control custom-select" id="billing_country" name="billing_country" required>
												<option>Select country</option>
												@foreach($get_countries as $country)
												  <option value="{{ $country->id }}" @if($country->id==99) selected="selected" @endif>{{ $country->country_name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>State</label>
										     <select class="form-control custom-select" id="billing_state" name="billing_state" required>
												<option value="">Select state</option>
												@foreach($get_state as $state)
												  <option value="{{ $state->StCode }}">{{ $state->StateName }}</option>
												@endforeach
											</select>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label>City</label>
											 <select class="form-control custom-select" id="billing_city" name="billing_city" required>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Pincode</label>
											<input type="text" class="form-control" placeholder="Enter pincode" id="billing_pincode" name="billing_pincode" required />
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
									<input type="text" class="form-control" placeholder="Enter name" id="primary_contact_name" name="primary_contact_name" required />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" placeholder="Enter valid email" id="primary_contact_email" name="primary_contact_email" required />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Mobile</label>
									<input type="text" class="form-control" placeholder="Enter valid mobile no." id="primary_contact_mobile" name="primary_contact_mobile" required />
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Designation</label>
									<select class="form-control custom-select" id="designation_country" name="designation_country" required >
										<option value="">Select Your Country</option>
										@foreach($get_countries as $country)
										  <option value="{{ $country->id }}" @if($country->id==99) selected="selected" @endif>{{ $country->country_name }}</option>
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
								<div class="form-group">
									<div class="radio">
									  <label>
										<input type="radio" name="verification_type" id="optionsRadios1" value="Aadhaar-based">
										Aadhaar-based esign <small>(Instant verification)</small>
									  </label>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<div class="radio">
									  <label>
										<input type="radio" name="verification_type" id="optionsRadios2" value="Documents-based">
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
									<option value="Passport">Passport</option>
									<option value="PAN Card">PAN Card</option>
									<option value="Voter ID">Voter ID</option>
									<option value="Driving License">Driving License</option>
									<option value="Government Photo ID Cards">Government Photo ID Cards</option>
									<option value="Photo Bank ATM Card">Photo Bank ATM Card</option>
									<option value="Photo Credit Card">Photo Credit Card</option>
									<option value="Pensioner Photo Card">Pensioner Photo Card</option>
									<option value="Freedom Fighter Photo Card">Freedom Fighter Photo Card</option>
									<option value="Kissan Photo Passbook">Kissan Photo Passbook</option>
									<option value="Marriage certificate with photograph">Marriage certificate with photograph</option>
									<option value="CGHS/ ECHS Photo Card">CGHS/ ECHS Photo Card</option>
								</select>
							</div>
							<div class="col-md-3">
								<div class="upload-btn-wrapper">
									<button class="btn">+ Add Files</button>
									<input type="file" name="id_proof" id="id_proof" onChange="validateFile(this.value)" />
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
									<option value="Passport">Passport</option>
									<option value="Bank Statement/ Passbook">Bank Statement/ Passbook</option>
									<option value="Post Office Account Statement/ Passbook">Post Office Account Statement/ Passbook</option>
									<option value="Ration Card">Ration Card</option>
									<option value="Voter ID">Voter ID</option>
									<option value="Driving License">Driving License</option>
									<option value="Electricity Bill (not older than 3 months)">Electricity Bill (not older than 3 months)</option>
									<option value="Water Bill (not older than 3 months)">Water Bill (not older than 3 months)</option>
									<option value="Telephone Landline Bill (not older than 3 months)">Telephone Landline Bill (not older than 3 months)</option>
									<option value="Property Tax Receipt (not older than 1 year)">Property Tax Receipt (not older than 1 year)</option>
									<option value="Credit Card Statement (not older than 3 months)">Credit Card Statement (not older than 3 months)</option>
									<option value="Insurance Policy">Insurance Policy</option>
									<option value="Arms License">Arms License</option>
									<option value="Freedom Fighter Card">Freedom Fighter Card</option>
									<option value="Kissan Passbook">Kissan Passbook</option>
									<option value="Gas Connection Bill (not older than 3 months)">Gas Connection Bill (not older than 3 months)</option>
								</select>
							</div>
							<div class="col-md-3">
								<div class="upload-btn-wrapper">
									<button class="btn">+ Add Files</button>
									<input type="file" name="address_proof" id="address_proof" />
								</div>
							</div>
						</div>
						
						<ul class="list-inline pull-right">
                            <li>
							<button type="submit" class="btn btn-primary">
							<span id="hidekyctext">Submit</span>&nbsp;
							<span class="kycForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
							</button>
							</li>
                            <li><button type="button" class="btn btn-primary prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-primary next-step">Next</button></li>
                        </ul>
						</form>
                    </div>
					<!--kyc-form-->
					<div class="tab-pane" role="tabpanel" id="step5">
                        <h3>Number Selection</h3>
                        <p>Book a number for your business. You can select one from the list displayed.</p>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-default next-step">Next</button></li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Plan and Payment</h3>
                        <p>Select your plan and make payment. You can upgrade or downgrade later.</p>
                        
						<div class="row">
						<div class="priceing-table-main">
			<div class="col-md-3 price-grid">
				<div class="price-block agile">
					<div class="price-gd-top">
						<h4>Basic Plan</h4>
						<h3>$5</h3>
						<h5>1 month</h5>
					</div>
					
					<div class="price-gd-bottom">
						<div class="price-list">
							<ul>
								<li>Nail Cutting</li>
								<li>Hair Coloring</li>
								<li>Spa Therapy</li>
								<li>Body massage</li>
								<li>Manicure</li>
							</ul>
						</div>
						<div class="price-selet pric-sclr1">
							<div class="custom-radio-plan">
								<input type="radio" name="plans" value="Plan1" id="Plan1" >
								<label for="Plan1">Select</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-3 price-grid">
				<div class="price-block agile">
					<div class="price-gd-top">
						<h4>Stay &amp; Dine</h4>
						<h3>$10</h3>
						<h5>5 months</h5>
					</div>
					
					<div class="price-gd-bottom">
						<div class="price-list">
							<ul>
								<li>Hand and Foot massage</li>
								<li>Nail Cutting</li>
								<li>Spa Therapy</li>
								<li>Body massage</li>
								<li>Manicure</li>
							</ul>
						</div>
						<div class="price-selet pric-sclr2">
							<div class="custom-radio-plan">
								<input type="radio" name="plans" value="Plan2" id="Plan2" >
								<label for="Plan2">Select</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-3 price-grid lost">
				<div class="price-block agile">
					<div class="price-gd-top">
						<h4>Inn &amp; Spa</h4>
						<h3>$20</h3>
						<h5>Free for 2 months</h5>
					</div>
					
					<div class="price-gd-bottom">
						<div class="price-list">
							<ul>
								<li>Hand and Foot massage</li>
								<li>Nail Cutting</li>
								<li>Spa Therapy</li>
								<li>Body massage</li>
								<li>Hair Coloring</li>
							</ul>
						</div>
						<div class="price-selet pric-sclr3">
							<div class="custom-radio-plan">
								<input type="radio" name="plans" value="Plan3" id="Plan3" >
								<label for="Plan3">Select</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-3 price-grid wthree lost">
				<div class="price-block agile">
					<div class="price-gd-top">
						<h4>Exclusive</h4>
						<h3>$50</h3>
						<h5>Free for 5 months</h5>
					</div>
					<div class="price-gd-bottom">
						<div class="price-list">
							<ul>
								<li>Nail Cutting</li>
								<li>Hair Coloring</li>
								<li>Spa Therapy</li>
								<li> Hand and Foot massage</li>
								<li>Manicure</li>
							</ul>
						</div>
						<div class="price-selet pric-sclr4">
							<div class="custom-radio-plan">
								<input type="radio" name="plans" value="Plan4" id="Plan4" >
								<label for="Plan4">Select</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
						</div>
						
						<ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default prev-step">Previous</button></li>
                            <li><button type="button" class="btn btn-primary btn-info-full next-step">Submit</button></li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
           
        </div>
    </section>
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
$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
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
 
 <style>
 
/*-- special --*/
.special,#news,.w3_content_agilleinfo_inner,.team-section,.plans-section{
    padding: 25px 0;
}

h3.tittle,h2.ptbl-inner-h-title,h3.ptbl-inner-h-title{
    color: #e83f3f;
    font-size:2.5em;
    margin: 0;
    text-align: center;
    font-weight: 600;
    letter-spacing: 3px;
}

h2.ptbl-inner-h-title,h3.ptbl-inner-h-title{
	margin-bottom:1em;
	text-transform:uppercase;
}
h3.tittle.two {
    color: #fff;
}

.priceing-table-main {
    margin: 1rem 0 2rem 0;
}
.price-list ul {
    padding: 0px;
    list-style: none;
}
.price-gd-top {
    background:#26476c;
    text-align: center;
}
.price-gd-top h4 {
    font-size: 1.8em;
    color: #fff;
    padding: 0.4em 1em;
        background: #f9ba48;
	    font-weight: 300;
}
.price-gd-top h3 {
    padding:0.2em 0em 0.1em 0em;
    font-size:3.5em;
    color: #fff;
	text-align: center;
}
.price-gd-top h5 {
    font-size: 1em;
    color: #fff;
    padding: 0.2em 0em 0.8em 0em;
}
.price-gd-bottom {
    background: #fff;
    text-align: center;
    padding: 1em 0em;
}
.price-gd-top.pric-clr2 h4 {
    background: #d4b906;
}
.price-gd-top.pric-clr2 {
    background: #ecce04
}
.price-selet.pric-sclr2 a {
    background:#ecce04
}
.price-gd-top.pric-clr3 {
	background:#2baf2b;
}
.price-gd-top.pric-clr3 h4 {
       background: #209a20;
}
.price-gd-top.pric-clr4 {
	background:#e83f3f;
}
.price-gd-top.pric-clr4 h4 {
	    background: #d62c2c;
}
.price-selet.pric-sclr4 a {
    background:#e83f3f;
}
.price-selet.pric-sclr3 a {
    background:#2baf2b;
}
.price-list ul li {
	    padding: 0.5em 0em;
    font-size: 0.9em;
    color: #999999;
    border-bottom: 1px dotted #ddd;
}
.price-selet {
    padding: 1em 0em;
    text-align: center;
    background: #fff;
}
.price-selet a {
    font-size: 1.1em;
    color: #fff;
    display: block;
}
.price-selet a {
	font-size: 0.9em;
    color: #ffffff;
    display: inline-block;
    padding: 0.5em 2em;
    background: #00acee;
    text-decoration: none;
	    border-radius: 25px;
		-webkit-border-radius: 25px;
		-o-border-radius: 25px;
}
.price-block {
    box-shadow: 0 8px 17px 2px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.2);
    transition: 0.5s all;
    -webkit-transition: 0.5s all;
    -moz-transition: 0.5s all;
    -o-transition: 0.5s all;
}

.download-div{text-align:center; margin-top:40px; padding:40px 0px; clear:both;}
.download{
	padding:10px 30px;
	background-color:#006699;
	color:#000000;
	font-size:24px;
	text-transform:uppercase;
	text-decoration:none;
	margin-top:2px;
	border-radius:10px;
}

.custom-radio-plan
{
	margin: 0 0 0px 0;
	width: 100%;
	height: auto;
}

.custom-radio-plan label
{
background-color: #26476c;
padding: 10px 30px;
cursor: pointer;
margin: 0px 0 0 0;
border-radius: 3px;
color: #FFFFFF;
font-size: 16px;
}

.custom-radio-plan label:focus
{
background-color:#EE0A5C;
padding: 8px 16px;
cursor:pointer;
margin: 0 5px 10px 0;
border-radius:3px;
color:#FFFFFF;
}

.custom-radio-plan input[type=radio]
{
display:none;
}
.custom-radio-plan input[type=radio]:checked + label
{
background-color:#f9ba48;
color:#FFFFFF;
}

.custom-radio-plan input[type=radio]:focus + checked + label {
  background-color:#f9ba48;
display:none;
}

 </style>
 
 <script>
$("input[name='plans']").click(function() {
      $('.custom-radio-plan label').text('Select');
      if(this.checked){
       $(this).next().text('Selected');
      }
 });
</script>
 
@endsection
