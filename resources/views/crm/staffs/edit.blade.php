@extends('layouts.crm.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
	<a class="section" href="{{ route('Crm::leads') }}">{{ trans('laralum.leads_title') }}</a>
	<i class="right angle icon divider"></i>
	<div class="active section">{{ trans('laralum.edit_lead') }}</div>
</div>
@endsection
@section('title', trans('laralum.edit_lead'))
@section('icon', "edit")
@section('subtitle', trans('laralum.lead_edit_subtitle', ['name' => $lead->name]))
@section('content')
<div class="ui one column doubling stackable grid container">
	<div class="three wide column"></div>
	<div class="ui very padded segment">
		<div class="fifteen wide column">
			<form class="ui form" action="{{ route('Crm::lead_update', [$lead->id]) }}" method="POST"
				enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="col-md-12">
					<h3 class="form-heading">Account Details</h3>
				</div>
				<div class="col-md-4">
					<div class="form-group ">
						<label>Account Type</label>

						<select class="form-control custom-select" name="account_type" id="account_type_id">
							<option value="">Please select..</option>
							@foreach($accounttypes as $type)
							<option value="{{ $type->type }}"
								{{ old('account_type',$lead->account_type == $type->type ? 'selected': '' )}}>
								{{ $type->type }}
							</option>
							@endforeach
							<option value="add">Add Value</option>
						</select>

					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group ">
						<label>Department</label>
						<select class="form-control custom-select" name="department" id="department">
							<option value="">Please select..</option>
							@foreach($departments as $department)
							<option value="{{ $department->department }}"
								{{ (old('department',$lead->department) == $department->department ? 'selected': '') }}>
								{{ $department->department }}
							</option>
							@endforeach
							<option value="add">Add Value</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group ">
						<label>Member Type</label>
						<select multiple="multiple" class="form-control custom-select" name="member_type[]"
							id="member_type_id">
							@foreach($membertypes as $type)
							<option value="{{ $type->type }}"
								{{ old('member_type',$lead->member_type == $type->type ? 'selected': '') }}>
								{{ $type->type }}
							</option>
							@endforeach
							<option value="add">Add Value</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group ">
						<label>Lead Source</label>
						<select class="form-control custom-select" name="lead_source" id="source_id">
							<option value="">Please select..</option>
							@foreach($sources as $source)
							<option value="{{ $source->source }}"
								{{ old('lead_source',$lead->lead_source == $source->source ? 'selected': '') }}>
								{{ $source->source }}
							</option>
							@endforeach
							<option value="add">Add Value</option>
						</select>
					</div>
				</div>


				<div class="col-md-12">
					<hr>
				</div>

				<div class="col-md-12">
					<h3 class="form-heading">Personal Details</h3>
				</div>

				<div class="col-md-2 text-center">
					@if($lead->profile_photo)
					<img src="{{ asset('crm/leads') }}/{{ $lead->profile_photo }}" alt=""
						class="img-thumbnail mx-auto d-block img-fluid" id="selected_pic" />
					@else
					<img src="{{ asset('crm_public/images/select-profile.jpg') }}" alt=""
						class="img-thumbnail mx-auto d-block img-fluid" id="selected_pic">
					@endif

					<div class="select-pic-btns">
						<a class="btn btn-sm btn-primary" id="profile_img_btn"
							onclick="$('.dimmer').removeClass('dimmer')">Select Picture</a>
						<input name="hidden_profile_photo" value="{{ $lead->profile_photo }}" type="hidden" />
						<input id="profile_img" name="profile_photo" type="file">
						<p class="help-block">Max Size: 2 MB</p>
					</div>
				</div>

				<div class="col-md-10">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group ">
								<label>Name <span class="red-txt">*</span></label>
								<input type="text" class="form-control" id="name" name="name"
									value="{{ old('name', isset($lead) ? $lead->name : '') }}">
								<input type="hidden" class="form-control" id="client_id" name="client_id" value="1">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group ">
								<label>Gender</label>
								<select class="form-control custom-select" id="gender" name="gender">
									<option value="Male" {{ old('gender', $lead->gender == 'Male' ? 'selected': '') }}>
										Male</option>
									<option value="Female"
										{{ old('gender', $lead->gender == 'Female' ? 'selected': '') }}>Female</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group ">
								<label>BloodGroup</label>
								<select class="form-control custom-select" id="bldgrp" name="bldgrp">
									<option value="A+" {{ old('bldgrp',$lead->blood_group == "A+" ? 'selected': '') }}>
										A+</option>
									<option value="B+" {{ old('bldgrp',$lead->blood_group == "B+" ? 'selected': '') }}>
										B+</option>
									<option value="O+" {{ old('bldgrp',$lead->blood_group== "O+" ? 'selected': '') }}>O+
									</option>
									<option value="O-" {{ old('bldgrp',$lead->blood_group == "O-" ? 'selected': '') }}>
										O-</option>
									<option value="A-" {{ old('bldgrp',$lead->blood_group == "A-" ? 'selected': '') }}>
										A-</option>
									<option value="B-" {{ old('bldgrp',$lead->blood_group == "B+" ? 'selected': '') }}>
										B-</option>
									<option value="AB+"
										{{old ('bldgrp',$lead->blood_group == "AB+" ? 'selected': '') }}>AB+
									</option>
									<option value="AB-"
										{{ old('bldgrp',$lead->blood_group == "AB-" ? 'selected': '') }}>AB-
									</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group ">
								<label>Married Status</label>
								<select class="form-control custom-select" id="marriedstatus" name="marriedstatus">
									<option value="Single"
										{{ old('marriedstatus',$lead->married_status == "Single" ? 'selected': '') }}>
										Single</option>
									<option value="Married"
										{{ old('marriedstatus',$lead->married_status == "Married" ? 'selected': '') }}>
										Married</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Date of Birth</label>
								<input type="date" class="form-control" id="dob" name="dob"
									value="{{ old('dob', isset($lead) ? $lead->date_of_birth : '') }}" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Date of Joining</label>
								<input type="date" class="form-control" id="doj" name="doj"
									value="{{ old('doj', isset($lead) ? $lead->date_of_joining : '') }}" />
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<hr>
				</div>

				<div class="col-md-12">
					<h3 class="form-heading">Contact Details</h3>
				</div>
				<div class="numbermore">

					<div class="col-md-4">
						<div class="form-group ">
							<label>Email </label>
							<input type="email" class="form-control" id="email" name="email"
								value="{{ old('email', isset($lead) ? $lead->email : '') }}" />
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<div style="display: inline-block; 
							width: 100%;">
								<div id="verify_mobile" style="display: none;float: right;">
									<a href="javascript:void(0);" class="red-txt" id="verify_label"
										onclick="$('.dimmer').removeClass('dimmer')">Verify</i></a>
								</div>
								<label>Mobile <span class="red-txt">*</span></label>
							</div>
							<input type="text" class="form-control" id="mobile" name="mobile"
								value="{{old('mobile',$lead->mobile)}}" data-old="{{$lead->mobile}}">
							<input type="number" class="form-control" id="otp" name="otp" value=""
								placeholder="Enter Otp" style="display: none; margin-top: 10px">
							<input type="hidden" id="sender_id" value="{{ auth()->user()->id }}" />

						</div>
					</div>
					@if ($lead->alt_numbers!=null && $lead->alt_numbers!=''&& unserialize($lead->alt_numbers)!=null)
					@foreach(unserialize($lead->alt_numbers) as $key=> $number)
					<div class="add-inp-div">
						<div class="form-group">
							<label>Alternate Number</label>
							<input type="text" class="form-control" name="alt_number[]"
								value="{{old('alt_number[]',$number)}}" />
						</div>
					</div>
					@if($key==0)
					<div class="add-btn-div">
						<a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addAlternate"
							onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-plus"></i></a>
					</div>
					@else
					<div class="add-btn-div">
						<a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove_alt"
							onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-minus"></i></a>
					</div>
					@endif
					@endforeach
					@else
					<div class="add-inp-div">
						<div class="form-group">
							<label>Alternate Number</label>
							<input type="text" class="form-control" name="alt_number[]" />
						</div>
					</div>

					<div class="add-btn-div">
						<a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addAlternate"
							onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-plus"></i></a>
					</div>
					@endif
				</div>
				<div class="col-md-12">
					<hr />
				</div>
				@if ($lead->address!=null && $lead->address!=''&& count(unserialize($lead->address)) >0)
				@foreach (unserialize($lead->address) as $key=> $address)
				<div class="addressmore">
					<div class="address_title">
						<input type="hidden" class="form-control" id="address_type" name="address_type[]"
							value="{{unserialize($lead->address_type)[$key]}}">
						<h3 class="header_title">
							{{unserialize($lead->address_type)[$key]=='permanent'?"Permanent Address":"Temporary Address"}}
						</h3>
					</div>
					<div class="row1">
						<div class="col-md-10">

							<div class="address4">
								<div class="form-group1">
									<label>Address</label>
									<input type="text" class="form-control" id="address" name="address[]"
										value="{{old('address[]',$address)}}">
								</div>
							</div>
							<div class="address4">
								<div class="form-group1">
									<label>Country</label>
									<select class="form-control custom-select" id="country" name="country[]">
										<option value="">Please select</option>
										@foreach($get_countries as $country)
										<option value="{{ old('country[]',$country->country_code) }}"
											{{ (old('country',unserialize($lead->country)[$key]) == $country->country_code ? 'selected': '') }}>
											{{ $country->country_name}}
										</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="address4">
								<div class="form-group1">
									<label>State</label>
									<select class="form-control custom-select" id="state_{{$key+1}}" name="state[]"
										onchange="stateChange(this)">
										<option value="">Please select</option>
										@foreach($get_state as $state)
										<option value="{{ $state->StCode }}"
											{{ (old('state[]',unserialize($lead->state)[$key]) == $state->StCode ? 'selected': '') }}>
											{{ $state->StateName }}
										</option>
										@endforeach

									</select>
								</div>
							</div>

							<div class="address4">
								<div class="form-group1">
									<label>District</label>
									<select class="form-control custom-select" id="district_{{$key+1}}" name="district[]">
										@foreach($get_district as $district)
										@if($district->StCode==unserialize($lead->state)[$key]))
										<option value="{{ $district->DistCode }}"
											{{ old('district', unserialize($lead->district)[$key] == $district->DistCode ? 'selected': '') }}>
											{{ $district->DistrictName }}</option>
										@endif
										@endforeach

									</select>
								</div>
							</div>

							<div class="address4">
								<div class="form-group1">
									<label>Pincode</label>
									<input type="text" class="form-control" id="pincode" name="pincode[]"
										value="{{unserialize($lead->pincode)[$key]}}">
								</div>
							</div>
						</div>
						@if($key==0)
						<div class="btn_add">
							<a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addAddress"
								onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-plus"></i></a>
						</div>
						@else
						<div class="btn_add">
							<a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove_address"
								onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-minus"></i></a>
						</div>
						@endif
					</div>

				</div>
				@endforeach
				@else
				<div class="addressmore">
					<div class="address_title">
						<input type="hidden" class="form-control" id="address_type" name="address_type[]"
							value="permanent">
						<h3 class="header_title">Permanent Address</h3>
					</div>

					<div class="row1">
						<div class="col-md-10">

							<div class="address_4">
								<div class="form-group1">
									<label>Address</label>
									<input type="text" class="form-control" id="address" name="address[]" value="">
								</div>
							</div>
							<div class="address_4">
								<div class="form-group1">
									<label>Country</label>
									<select class="form-control custom-select" id="country" name="country[]">
										<option value="">Please select</option>
										@foreach($get_countries as $country)
										<option value="{{ $country->country_code }}">{{ $country->country_name}}
										</option>
										@endforeach

									</select>
								</div>
							</div>
							<div class="address_4">
								<div class="form-group1">
									<label>State</label>
									<select class="form-control custom-select" id="state_1" name="state[]"
										onchange="stateChange(this)">
										<option value="">Please select</option>
										@foreach($get_state as $state)
										<option value="{{ $state->StCode }}"
											{{ (old('state') == $state->StCode ? 'selected': '') }}>
											{{ $state->StateName }}
										</option>
										@endforeach

									</select>
								</div>
							</div>

							<div class="address_4">
								<div class="form-group1">
									<label>District</label>
									<select class="form-control custom-select" id="district_1" name="district[]">
										<option>Select District</option>
									</select>
								</div>
							</div>

							<div class="address_4">
								<div class="form-group1">
									<label>Pincode</label>
									<input type="text" class="form-control" id="pincode" name="pincode[]" value="">
								</div>
							</div>
						</div>
						<div class="btn_add">
							<a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addAddress"
								id='add' onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-plus"></i></a>
						</div>
					</div>
				</div>
				@endif
				<div class="col-md-12">
					<hr>
				</div>
				<div class="col-md-12">
					<h3 class="form-heading">Additional Details</h3>
				</div>

				<div class="col-md-2 text-center">
					@if($lead->id_proof)
					<img src="{{ asset('crm/leads') }}/{{ $lead->id_proof }}" alt=""
						class="img-thumbnail mx-auto d-block img-fluid" id="selected_proof" />
					@else
					<img src="{{ asset('crm_public/images/select-profile.jpg') }}" alt=""
						class="img-thumbnail mx-auto d-block img-fluid" id="selected_proof">
					@endif

					<div class="select-pic-btns">
						<a class="btn btn-sm btn-primary" id="id_proof_btn"
							onclick="$('.dimmer').removeClass('dimmer')">Select IdProof</a>
						<input name="hidden_id_proof" value="{{ $lead->id_proof }}" type="hidden" />

						<input id="id_proof" name="id_proof" type="file" style="display: none;">
						<p class="help-block">Max Size: 2 MB</p>
					</div>
				</div>

				<div class="col-md-10">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group ">
								<label>Qualification</label>
								<input type="text" class="form-control" id="qualification" name="qualification"
									value="{{old("qualification",$lead->qualification)}}">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group ">
								<label>Branch</label>
								<select class="form-control custom-select" name="branch" id="branch">
									<option value="">Please select..</option>
									@foreach($branches as $branch)
									<option value="{{ $branch->branch }}"
										{{ (old('branch') == $branch->branch ? 'selected': '') }}>
										{{ $branch->branch }}
									</option>
									@endforeach
									<option value="add">Add Value</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group ">
								<label>Profession</label>
								<input type="text" class="form-control" id="profession" name="profession"
									value="{{old("profession",$lead->profession)}}">
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-2">
							<div class="form-group ">
								<label>Sms Requred</label>
								<input type="checkbox" id="sms" name="sms" value=true
									{{$lead->sms_required?'checked':""}}>
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group ">
								<label>Call Requred</label>
								<input type="checkbox" id="call" name="call" value=true
									{{$lead->call_required?'checked':""}}>
							</div>
						</div>
						@if($lead->sms_required)
						<div class="col-md-4" style="display: block" id="sms_language">
							<div class="form-group">
								<label>Sms Language</label>
								<select class="form-control custom-select" name="sms_language">
									<option
										{{ old('sms_language', $lead->sms_language == 'English' ? 'selected': '') }}>
										English</option>
									<option {{ old('sms_language', $lead->sms_language == 'Telugu' ? 'selected': '') }}>
										Telugu</option>
								</select>
							</div>
						</div>
						@else
						<div class="col-md-4" style="display: none" id="sms_language">
							<div class="form-group">
								<label>Sms Language</label>
								<select class="form-control custom-select" name="sms_language">
									<option
										{{ old('sms_language', $lead->sms_language == 'English' ? 'selected': '') }}>
										English</option>
									<option {{ old('sms_language', $lead->sms_language == 'Telugu' ? 'selected': '') }}>
										Telugu</option>
								</select>
							</div>
						</div>
						@endif

					</div>
				</div>

				<div class="col-md-12">
					<hr>
				</div>
				<div class="col-md-12">
					<h3 class="form-heading">Family Details</h3>
				</div>
				@if(count($family_members)>0)
				@foreach($family_members as $key=> $member)
				<div class="col-md-12">
					<div class="fieldmore row">
						<div class="add-inp-div">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" name="family_member_name[]"
									value="{{ $member->member_relation_name }}" />
							</div>
						</div>

						<div class="add-inp-div">
							<div class="form-group">
								<label>Relationship</label>
								<input type="text" class="form-control" name="family_member_relation[]"
									value="{{ $member->member_relation }}" />
							</div>
						</div>

						<div class="add-inp-div">
							<div class="form-group">
								<label>Date of Birth</label>
								<input type="date" class="form-control" name="family_member_dob[]"
									value="{{ $member->member_relation_dob }}" />
							</div>
						</div>

						<div class="add-inp-div">
							<div class="form-group">
								<label>Mobile</label>
								<input type="text" class="form-control" name="family_member_mobile[]"
									value="{{ $member->member_relation_mobile }}" />
							</div>
						</div>
						@if($key==0)
						<div class="add-btn-div">
							<a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMore"
								onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-plus"></i></a>
						</div>
						@else
						<div class="add-btn-div">
							<a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
								onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-minus"></i></a>
						</div>
						@endif
					</div>
				</div>
				@endforeach
				@else
				<div class="col-md-12">
					<div class="fieldmore row">
						<div class="add-inp-div">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control" name="family_member_name[]" value="" />
							</div>
						</div>

						<div class="add-inp-div">
							<div class="form-group">
								<label>Relationship</label>
								<input type="text" class="form-control" name="family_member_relation[]" value="" />
							</div>
						</div>

						<div class="add-inp-div">
							<div class="form-group">
								<label>Date of Birth</label>
								<input type="date" class="form-control" name="family_member_dob[]" value="" />
							</div>
						</div>

						<div class="add-inp-div">
							<div class="form-group">
								<label>Mobile</label>
								<input type="text" class="form-control" name="family_member_mobile[]" value="" />
							</div>
						</div>
						<div class="add-btn-div">
							<a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMore"
								onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-plus"></i></a>
						</div>

					</div>
				</div>
				@endif
				<div class="col-md-12 text-right mb-30 mt-30">
					<button type="submit"
						class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
				</div>



			</form>
		</div>
	</div>
	<div class="three wide column"></div>
</div>

<!-- Add Details Modal start-->
<div id="AddDetails" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Detail</h4>
			</div>
			<form method="POST" enctype="multipart/form-data" id="add_detail" action="javascript:void(0)">
				<div class="modal-body">
					<div class="form-group">
						<label>Add Detail</label>
						<input type="text" name="detail" id="detail" class="form-control" />
						<input type="hidden" name="type" id="detail_type" class="form-control" />
					</div>
					<div class="form-group">
						<button type="submit" id="editMemberForm" class="ui teal submit button"><span
								id="hidebutext">Add</span>&nbsp;
							<span class="editMemberForm" style="display:none;"><img
									src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<!-- copy of input fields group -->
<div class="numberCopy row" style="display: none;">
	<div class="add-inp-div">
		<div class="form-group">
			<label>Alternate Number</label>
			<input type="text" class="form-control" name="alt_number[]" />
		</div>
	</div>

	<div class="add-btn-div">
		<a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove_alt"
			onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-minus"></i></a>
	</div>
</div>
<!-- copy of input fields group -->
<div class="fieldmoreCopy row" style="display: none;">

	<div class="add-inp-div">
		<div class="form-group">
			<label>Name</label>
			<input type="text" class="form-control" name="family_member_name[]" />
		</div>
	</div>

	<div class="add-inp-div">
		<div class="form-group">
			<label>Relationship</label>
			<input type="text" class="form-control" name="family_member_relation[]" />
		</div>
	</div>

	<div class="add-inp-div">
		<div class="form-group">
			<label>Date of Birth</label>
			<input type="date" class="form-control" name="family_member_dob[]" />
		</div>
	</div>

	<div class="add-inp-div">
		<div class="form-group">
			<label>Mobile</label>
			<input type="text" class="form-control" name="family_member_mobile[]" />
		</div>
	</div>

	<div class="add-btn-div">
		<a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
			onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-minus"></i></a>
	</div>
</div>
@endsection
@section('js')
<script>
	<!--for image selection--
	-->
	$('#profile_img_btn').bind("click"
	,
	function
	()
	{
	$('#profile_img').click();
	});
	function
	readURL(input)
	{
	if
	(input.files
	&&
	input.files[0])
	{
	var
	reader
	=
	new
	FileReader();
	reader.onload
	=
	function
	(e)
	{
	$('#selected_pic').attr('src',
	e.target.result);
	}
	reader.readAsDataURL(input.files[0]);
	}
	}
	$("#profile_img").change(function(){
	readURL(this);
	});

<!--for idproof selection--
	-->
$('#id_proof_btn').bind("click"
,
function
()
{
$('#id_proof').click();
});
function
readProofURL(input)
{
if
(input.files
&&
input.files[0])
{
var
reader
=
new
FileReader();
reader.onload
=
function
(e)
{
$('#selected_proof').attr('src',
e.target.result);
}
reader.readAsDataURL(input.files[0]);
}
}
$("#id_proof").change(function(){
readProofURL(this);
});
<!---for fetch district---->
function stateChange(object) {
var id=object.id.split('_').pop();
var stateID = object.value;
if(stateID=='')
{
alert('Please select state');
return false;
}
var token = $("input[name='_token']").val();
if(stateID){
$.ajax({
method: "POST",
url:"{{ route('Crm::get_district') }}",
data: {state_id:stateID, _token:token},
success:function(res){
if(res){
var district=$('#district_'+id);
district.empty();
district.append('<option value="">Please select</option>');
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
	$(document).ready(function(){
    //group add limit
    var maxGroup = 3;
    
    //add more fields group
    $(".addMore").click(function(){
        if($('body').find('.fieldmore').length < maxGroup){
            var fieldHTML = '<div class="fieldmore row">'+$(".fieldmoreCopy").html()+'</div>';
            $('body').find('.fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    
     //add more address group
	 $(".addAddress").click(function(){
		 var length=$('body').find('.addressmore').length;
        if($('body').find('.addressmore').length < maxGroup){
			var clone = $(".addressmore:last").clone();
			clone.find("#state_"+length).attr("id","state_"+(length+1));
			clone.find("#district_"+length).attr("id","district_"+(length+1));
            if($('body').find('.addressmore').length == 1){
				length=$('body').find('.addressmore').length;
				clone.find("#state_"+length-1).attr("id","state_"+(length+1));
				clone.find("#district_"+length-1).attr("id","district_"+(length+1));
				var btn=clone.find(".addAddress");
				
				btn.html('<i class="fa fa-minus"></i>')
				btn.addClass('btn-danger').removeClass('btn-primary');
				btn.addClass('remove_address').removeClass('addAddress');
			}
				var address_type=clone.find('#address_type');
				address_type.val('temp');
				var type=clone.find('.header_title');
				type.text('Temporary Address')
            $('body').find('.addressmore:last').after(clone);
        }else{
            alert('Maximum '+maxGroup+' address are allowed.');
        }
    });
    //add AlternateNumbers
    $(".addAlternate").click(function(){
		if($('body').find('.numbermore').length < maxGroup){
            var fieldHTML = '<div class="numbermore">'+$(".numberCopy").html()+'</div>';
            $('body').find('.numbermore:last').after(fieldHTML);
		}else{
            alert('Maximum '+maxGroup+' numbers are allowed.');
        }
	});
	
	$('#mobile').on('input',function(e){
		var value=$(this).val();
		if(value.length>=10 && value!=$(this).attr('data-old')){
			$('#verify_mobile').show();
		}
    });
	/*send otp*/
$('#verify_mobile').click(function () {
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
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldmore").remove();
    });
	 //remove address group
	 $("body").on("click",".remove_address",function(){ 
        $(this).parents(".addressmore").remove();
	});
	$("body").on("click",".remove_alt",function(){ 
        $(this).parents(".numbermore").remove();
	});
	$('#account_type_id').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
					$("#detail_type").val(0);
              $("#AddDetails").modal("show");
          }
	});
	$('#sms').change(function () {
		if(this.checked)
		$('#sms_language').show();
		else
		$('#sms_language').hide();
 	});
	$('#department').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
					$("#detail_type").val(3);
              $("#AddDetails").modal("show");
          }
	});
	$('#member_type_id').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
					$("#detail_type").val(1);
              $("#AddDetails").modal("show");
          }
	});
	$('#branch').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
					$("#detail_type").val(4);
              $("#AddDetails").modal("show");
          }
	});
	$('#source_id').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
					$("#detail_type").val(2);
              $("#AddDetails").modal("show");
          }
	});
	$('#add_detail').submit(function (e) {
		e.preventDefault();
		// 	e.preventDefault();
		$("#AddDetails").modal("hide");

		var detail = $('#detail').val();
		if (detail == '') {
			swal('Warning!', 'Please enter value', 'warning');
			return false;
		}

		var type = "POST";
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		var formData=new FormData(this);
		var my_url='';
		
		if($('#detail_type').val()==3){
			my_url=APP_URL + '/console/manage/departmentData';
			formData.append('department',detail);
		}
		else if($('#detail_type').val()==4){
			my_url=APP_URL + '/console/manage/branchData';
			formData.append('branch',detail);
		}
		else
		 my_url = APP_URL + '/console/manage/memberData';
		var type = "POST";
		$.ajax({
			type: type,
			url: my_url,
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function (data) {
				swal({
					title: "Success!",
					text: "Account details has been submited!",
					type: "success"
				}, function () {
					location.reload();
				});
			},
			error: function (data) {
				swal('Error!', data, 'error')
			}
		});
	});
	
});
</script>
@endsection