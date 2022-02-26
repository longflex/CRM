@extends('hyper.layout.master')
@section('title', "Edit Member")
@section('content')

<?php use \App\Http\Controllers\Crm\LeadsController; ?>

<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::members_dashboard') }}"><i class="uil-home-alt"></i> Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Crm::members') }}">List</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Member</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="editForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="edit_id" name="edit_id" value="{{ $id }}">
                        <h4 class="text-left mb-3">Account Details</h4>
                        <hr>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Account Type</label>
                                    <select class="form-control select2" name="account_type" id="account_type_id" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @if(!empty($accounttypes))
                                        @foreach($accounttypes as $type)
                                        <option value="{{ $type->type }}" {{ old('account_type', $lead->account_type == $type->type ? 'selected': '' )}}>
                                            {{ $type->type }}
                                        </option>
                                        @endforeach
                                        @endif
                                        <option value="add">Add Value</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control select2" name="department" id="department" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @if(!empty($departments))
                                        @foreach($departments as $department)
                                        <option value="{{ $department->department }}" {{ old('department', $lead->department == $department->department ? 'selected': '') }}>
                                            {{ $department->department }}
                                        </option>
                                        @endforeach
                                        @endif
                                        <option value="add">Add Value</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Member Type</label>
                                    <select class="select2 form-control select2-multiple" name="member_type[]" id="member_type_id" data-toggle="select2" multiple="multiple" data-placeholder="Please select..">
                                        <option>Please select..</option>

                                        @if ($lead->member_type!=null && $lead->member_type!=''&& json_decode($lead->member_type)!=null)

                                        @foreach(json_decode($lead->member_type) as $key=> $mem_type)
                                        @if(!empty($membertypes))
                                        @foreach($membertypes as $type)
                                        <option value="{{ $type->type }}" {{ old('member_type[]',$mem_type == $type->type ? 'selected': '') }}>
                                            {{ $type->type }}
                                        </option>
                                        @endforeach
                                         @endif
                                        
                                        @endforeach
                                        @else
                                        @if(!empty($membertypes))
                                        @foreach($membertypes as $type)
                                        <option value="{{ $type->type }}"
                                            {{ (old('member_type[]') == $type->type ? 'selected': '') }}>
                                            {{ $type->type }}
                                        </option>
                                        @endforeach
                                        @endif
                                        @endif

                                        <option value="add">Add Value</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group ">
                                    <label>Lead Source</label>
                                    <select class="form-control select2" name="lead_source" id="source_id" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @if(!empty($sources))
                                        @foreach($sources as $source)
                                        <option value="{{ $source->source }}" {{ old('lead_source',$lead->lead_source == $source->source ? 'selected': '') }}>
                                            {{ $source->source }}
                                        </option>
                                        @endforeach
                                        @endif
                                        <option value="add">Add Value</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Lead Status</label>
                                    <select class="form-control select2" id="lead_status" name="lead_status" data-toggle="select2" data-placeholder="Please select..">

                                        <option value="">Please select..</option>
                                        @if(!empty($lead_statuses))
                                        @foreach($lead_statuses as $lead_status)
                                        <option value="{{ $lead_status->lead_status }}"
                                            {{ (old('lead_status',$lead->lead_status == $lead_status->lead_status ? 'selected': '')) }}>
                                            {{ $lead_status->description }}
                                        </option>
                                        @endforeach
                                        @endif
                                        <option value="add">Add Value</option>
                                              
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <label>Preferred Language</label>
                                    <select class="form-control select2" id="preferred_language" name="preferred_language" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @if(!empty($preferred_languages))
                                        @foreach($preferred_languages as $preferred_language)
                                        <option value="{{ $preferred_language->preferred_language }}"
                                            {{ (old('preferred_language',$lead->preferred_language == $preferred_language->preferred_language ? 'selected': '')) }}>
                                            {{ $preferred_language->preferred_language }}
                                        </option>
                                        @endforeach
                                        @endif
                                        <option value="add">Add Value</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Last contacted date</label>
                                    <input type="date" class="form-control" id="last_contacted_date" name="last_contacted_date" value="{{ old('last_contacted_date', isset($lead) ? @$lead->last_contacted_date : '') }}">
                                </div>
                            </div> -->
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Lead Owner</label>
                                    <select class="form-control select2" name="agent" id="agent" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @if(!empty($agents))
                                        @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}"
                                            {{ old('agent', $lead->agent_id == $agent->id ? 'selected': '') }}>
                                            {{ $agent->name }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Lead Response</label>
                                    <select class="form-control select2" name="lead_response" id="lead_response" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @if(!empty($lead_responses))
                                        @foreach($lead_responses as $lead_response)
                                        <option value="{{ $lead_response->lead_response }}" {{ (old('lead_response', $lead->lead_response == $lead_response->lead_response ? 'selected': '')) }}>
                                            {{ $lead_response->lead_response }}
                                        </option>
                                        @endforeach
                                        @endif
                                        <option value="add">Add Value</option> 
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4 class="text-left my-2">Personal Details</h4>
                        <hr>
                        <div class="row">

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center"> 
                                <span id="remove_profile_photo" class="btn btn-sm btn-danger" style="display: none;">Remove</span><br>
                                @if(!empty($lead->profile_photo))
                                <label>
                                    <div style="height: 150px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
                                       <img id="addUploadFile" class="img-thumbnail mx-auto img-fluid" src="{{$lead->profile_photo}}">
                                       <br><br>
                                       <div id="addedFile"></div>
                                       <small>Click on image to change.</small><br>
                                       <small class="text-danger">Profile Photo !!</small>
                                       <small class="text-danger">Max Size: 2 MB</small>
                                       

                                       <input id="uploadFile" type="file" style="display: none;" name="file" value="{{$lead->profile_photo}}">

                                       <input type="hidden" name="profile_photo_path" id="profile_photo_path" value="{{$lead->profile_photo}}">

                                       <div style="display: none;" id="progress-wrp">
                                        <div class="progress-bar"></div>
                                        <div class="status">0%</div>
                                      </div>
                                    </div>
                                    <div id="output"></div>
                                </label>
                                @else

                                <label>
                                    <div style="height: 150px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
                                        <img id="addUploadFile" class="img-thumbnail mx-auto img-fluid" height="150" src="{{ asset('crm_public/images/select-profile.jpg') }}">

                                        <div id="addedFile"></div>

                                        <input id="uploadFile" type="file" style="display: none;" name="file">
                                        <small class="text-danger">Profile Photo !!</small>
                                        <small class="text-danger">Max Size: 2 MB</small>
                                        <input type="hidden" name="profile_photo_path" id="profile_photo_path">

                                        <div style="display: none;" id="progress-wrp">
                                            <div class="progress-bar"></div>
                                            <div class="status">0%</div>
                                        </div>
                                    </div>
                                    <div id="output"></div>
                                </label>

                                @endif
                            </div>
                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label>Member ID <span class="red-txt">*</span></label>
                                            <input type="text" class="form-control" style="text-align:center;" id="member_id" name="member_id" readonly value="{{ old('name', isset($lead) ? $lead->member_id : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Name <span class="red-txt">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', isset($lead) ? $lead->name : '') }}">
                                            <input type="hidden" class="form-control" id="client_id" name="client_id" value="1">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Date of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', isset($lead) ? $lead->date_of_birth : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Date of Joining</label>
                                            <input type="date" class="form-control" id="doj" name="doj" value="{{ old('doj', isset($lead) ? $lead->date_of_joining : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Date of Anniversary</label>
                                            <input type="date" class="form-control" id="date_of_anniversary" name="date_of_anniversary" value="{{ old('date_of_anniversary', isset($lead) ? $lead->date_of_anniversary : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label>RFID</label>
                                            <input type="text" class="form-control" id="rfid" name="rfid" value="{{ old('rfid', isset($lead) ? $lead->rfid : '') }}">
                                            <input type="hidden" class="form-control" id="client_id" name="client_id" value="1">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select class="form-control select2" id="gender" name="gender">
                                            <option value="">Please select..</option>
                                                <option value="Male" {{ old('gender', $lead->gender == 'Male' ? 'selected': '') }}>Male</option>
                                                <option value="Female" {{ old('gender', $lead->gender == 'Female' ? 'selected': '') }}>Female
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label>BloodGroup</label>
                                            <select class="form-control select2" id="bldgrp" name="bldgrp">
                                            <option value="">Please select..</option>
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
                                                <option value="B-" {{ old('bldgrp',$lead->blood_group == "B-" ? 'selected': '') }}>
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
                                    <div class="col-lg-6">
                                        <div class="form-group ">
                                            <label>Married Status</label>
                                            <select class="form-control select2" id="marriedstatus" name="marriedstatus">
                                            <option value="">Please select..</option>
                                                <option value="Single" {{ old('marriedstatus',$lead->married_status == "Single" ? 'selected': '') }}>Single
                                                </option>
                                                <option value="Married" {{ old('marriedstatus',$lead->married_status == "Married" ? 'selected': '') }}>
                                                    Married</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <h4 class="text-left my-2">Contact Details</h4>
                        <hr>
                        <div class="numbermore row">
                            <div class="col-lg-4">
                                <div class="form-group ">
                                    <label>Email </label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', isset($lead) ? $lead->email : '') }}">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div style="display: inline -block; width: 100%;">
                                        <div id="verify_mobile" style="display: none; float: right;">
                                            <a href="javascript:void(0);" class="red-txt" id="verify_label" onclick="$('.dimmer').removeClass('dimmer')">Verify</a>
                                        </div>
                                        <label>Mobile <span class="red-txt">*</span></label>
                                    </div>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{old('mobile', isset($lead) ? $lead->mobile : '')}}" data-old="{{$lead->mobile}}">
                                    <input type="number" class="form-control" id="otp" name="otp" value="" placeholder="Enter Otp" style="display: none; margin-top: 10px">
                                    <input type="hidden" id="sender_id" value="{{ auth()->user()->id }}"/>
                                </div>
                            </div>
                            

                            @if ($lead->alt_numbers!=null && $lead->alt_numbers!='')
                            <?php
                            // $alt_numbers = json_decode($lead->alt_numbers);
                            $alt_numbers = explode(",", $lead->alt_numbers);
                             //print_r($alt_numbers);die;
                             //echo count($alt_numbers));
                            ?>
                            @if(count($alt_numbers) > 0 )
                            @foreach($alt_numbers as $key=> $number)
                            <div class="col-md-3 add-inp-div">
                                <div class="form-group">
                                    <label>Alternate Number</label>
                                    <input type="text" class="form-control" name="alt_number[]" value="{{old('alt_number[]',$number)}}" />
                                </div>
                            </div>
                            @if($key==0)
                            <div class="col-md-1 add-btn-div">
                                <button class="btn btn-sm btn-primary family-add-btn addAlternate" type="button"><i class="uil-plus-circle"></i></button>
                            </div>
                            @else
                            <div class="col-md-1 add-btn-div">
                                <button class="btn btn-sm btn-danger family-add-btn remove_alt" type="button"><i class="uil-minus-circle"></i></button>
                            </div>
                            @endif
                            @endforeach
                            @endif
                            @else
                            <div class="col-md-3 add-inp-div">
                                <div class="form-group">
                                    <label>Alternate Number</label>
                                    <input type="text" class="form-control" name="alt_number[]" />
                                </div>
                            </div>
                            <div class="col-md-1 add-btn-div">
                                <button class="btn btn-sm btn-primary family-add-btn addAlternate" type="button"><i class="uil-plus-circle"></i></button>
                            </div>
                            @endif

                            

                        </div>
                        <div class="clearfix"></div>
                        @if(LeadsController::is_serialized($lead->address))
                        
                        @if ($lead->address!=null && $lead->address!=''&& count(unserialize($lead->address)) >0)

                        @foreach (unserialize($lead->address) as $key=> $address)

                        <div class="addressmore">
                            <div class="address_title">
                                <input type="hidden" class="form-control" id="address_type" name="address_type[]" value="{{unserialize($lead->address_type)[$key]}}">
                                <h3 class="header_title text-center my-2" >
                                    {{unserialize($lead->address_type)[$key]=='permanent'?"Permanent Address":"Temporary Address"}}
                                </h3>
  
                            </div>
                            <div class="address_fieldmore row">
                                <div class="addaddress-inp-div">
                                    <div class="form-group"> 
                                        <label>Address</label>
                                        <input type="text" class="form-control" id="address" name="address[]" value="{{old('address',$address)}}">
                                    </div>
                                </div>

                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control custom-select" id="country" name="country[]">
                                            <option value="">Please select</option>
                                            @if(!empty($get_countries))
                                            @foreach($get_countries as $country)
                                            <option value="{{ old('country[]',$country->country_code) }}" {{ (old('country',(unserialize($lead->country)[$key]!='' ? unserialize($lead->country)[$key] : 'IN')) == $country->country_code ? 'selected': '') }}>
                                            {{ $country->country_name}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control custom-select" id="state_{{$key+1}}" name="state[]"
                                        onchange="stateChange(this)">
                                            <option value="">Please select</option>
                                            @if(!empty($get_state))
                                            @foreach($get_state as $state)
                                            <option value="{{ $state->StCode }}"
                                                {{ (old('state[]',unserialize($lead->state)[$key]) == $state->StCode ? 'selected': '') }}>
                                                {{ $state->StateName }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>District</label>
                                        <select class="form-control custom-select" id="district_{{$key+1}}" name="district[]">
                                            @if(!empty($get_district))
                                            @foreach($get_district as $district)
                                            @if($district->StCode==unserialize($lead->state)[$key]))
                                            <option value="{{ $district->DistCode }}"
                                                {{ old('district', unserialize($lead->district)[$key] == $district->DistCode ? 'selected': '') }}>
                                                {{ $district->DistrictName }}</option>
                                            @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>Pincode</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode[]" value="{{unserialize($lead->pincode)[$key]}}">
                                    </div>
                                </div>
                                @if($key==0)
                                <div class="add-btn-div">
                                    <button class="btn btn-sm btn-primary family-add-btn addAddress" type="button"><i class="uil-plus-circle"></i></button>    
                                </div>
                                @else
                                <div class="add-btn-div">
                                    <button class="btn btn-sm btn-danger family-add-btn remove_address" type="button"><i class="uil-minus-circle"></i></button>    
                                </div>
                                @endif

                            </div>
                        </div>

                        @endforeach

                        @else

                        <div class="addressmore">
                            <div class="address_title">
                                <h3 class="header_title text-center my-2" >Permanent Address</h3>
                                <input type="hidden" class="form-control" id="address_type" name="address_type[]" value="permanent">
                            </div>
                            <div class="address_fieldmore row">
                                <div class="addaddress-inp-div">
                                    <div class="form-group"> 
                                        <label>Address</label>
                                        <input type="text" class="form-control" id="address" name="address[]" value="{{old('address[]')}}">
                                    </div>
                                </div>

                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control custom-select" id="country" name="country[]">
                                            <option value="">Please select</option>
                                            @if(!empty($get_countries))
                                            @foreach($get_countries as $country)
                                            <option value="{{ $country->country_code }}" {{ (old('country','IN') == $country->country_code ? 'selected': '') }}>{{ $country->country_name}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control custom-select" id="state_1" name="state[]"
                                            onchange="stateChange(this)">
                                            <option value="">Please select</option>
                                            @if(!empty($get_state))
                                            @foreach($get_state as $state)
                                            <option value="{{ $state->StCode }}"
                                                {{ (old('state') == $state->StCode ? 'selected': '') }}>{{ $state->StateName }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>District</label>
                                        <select class="form-control custom-select" id="district_1" name="district[]">
                                            <option>Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>Pincode</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode[]" value="{{old('pincode[]')}}">
                                    </div>
                                </div>

                                <div class="add-btn-div">
                                    <button class="btn btn-sm btn-primary family-add-btn addAddress" type="button"><i class="uil-plus-circle"></i></button>    
                                </div>
                            </div>
                        </div>

                        @endif
                        @else

                        <div class="addressmore">
                            <div class="address_title">
                                <h3 class="header_title text-center my-2" >Permanent Address</h3>
                                <input type="hidden" class="form-control" id="address_type" name="address_type[]" value="permanent">
                            </div>
                            <div class="address_fieldmore row">
                                <div class="addaddress-inp-div">
                                    <div class="form-group"> 
                                        <label>Address</label>
                                        <input type="text" class="form-control" id="address" name="address[]" value="{{old('address[]')}}">
                                    </div>
                                </div>

                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control custom-select" id="country" name="country[]">
                                            <option value="">Please select</option>
                                            @if(!empty($get_countries))
                                            @foreach($get_countries as $country)
                                            <option value="{{ $country->country_code }}" {{ (old('country', 'IN') == $country->country_code ? 'selected': '') }}>{{ $country->country_name}}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>State</label>
                                        <select class="form-control custom-select" id="state_1" name="state[]"
                                            onchange="stateChange(this)">
                                            <option value="">Please select</option>
                                            @if(!empty($get_state))
                                            @foreach($get_state as $state)
                                            <option value="{{ $state->StCode }}"
                                                {{ (old('state') == $state->StCode ? 'selected': '') }}>{{ $state->StateName }}
                                            </option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>District</label>
                                        <select class="form-control custom-select" id="district_1" name="district[]">
                                            <option>Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="addaddress1-inp-div">
                                    <div class="form-group">
                                        <label>Pincode</label>
                                        <input type="text" class="form-control" id="pincode" name="pincode[]" value="{{old('pincode[]')}}">
                                    </div>
                                </div>

                                <div class="add-btn-div">
                                    <button class="btn btn-sm btn-primary family-add-btn addAddress" type="button"><i class="uil-plus-circle"></i></button>    
                                </div>
                            </div>
                        </div> 

                        @endif


                        <h4 class="text-left my-2">Additional Details</h4>
                        <hr>
                        <div class="row"> 
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 text-center"> 
                                <!-- <h4>GSTIN Proof</h4> -->
                                <span id="remove_id_proof" class="btn btn-sm btn-danger" style="display: none;">Remove</span><br>
                                @if(!empty($lead->id_proof))
                                <label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
                                       <img id="addUploadFile1" class="img-thumbnail mx-auto img-fluid" src="{{$lead->id_proof}}">
                                       <br><br>
                                       <div id="addedFile1"></div>
                                       <small>Click on image to change.</small><br>
                                       <small class="text-danger">Id Proof !!</small>
                                       <small class="text-danger">Max Size: 2 MB</small>
                                       

                                       <input id="uploadFile1" type="file" style="display: none;" name="file" value="{{$lead->id_proof}}">

                                       <input type="hidden" name="id_proof_path" id="id_proof_path" value="{{$lead->id_proof}}">

                                       <div style="display: none;" id="progress-wrp1">
                                        <div class="progress-bar1"></div>
                                        <div class="status1">0%</div>
                                      </div>
                                    </div>
                                    <div id="output1"></div>
                                </label>
                                @else

                                <label>
                                    <div style="height: 150px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
                                        <img id="addUploadFile1" class="img-thumbnail mx-auto img-fluid" height="150" src="{{ asset('crm_public/images/select-profile.jpg') }}">

                                        <div id="addedFile1"></div>

                                        <input id="uploadFile1" type="file" style="display: none;" name="file">
                                        <small class="text-danger">Id Proof !!</small>
                                        <small class="text-danger">Max Size: 2 MB</small>
                                        <input type="hidden" name="id_proof_path" id="id_proof_path">

                                        <div style="display: none;" id="progress-wrp1">
                                            <div class="progress-bar1"></div>
                                            <div class="status1">0%</div>
                                        </div>
                                    </div>
                                    <div id="output1"></div>
                                </label>

                                @endif 
                            </div>

                            <div class="col-lg-10">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Qualification</label>
                                            <input type="text" class="form-control" id="qualification" name="qualification"
                                                value="{{old('qualification',$lead->qualification)}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Branch</label>
                                            <select class="form-control custom-select" name="branch" id="branch">
                                                <option value="">Please select..</option>
                                                @if(!empty($branches))
                                                @foreach($branches as $branch)
                                                <option value="{{ $branch->branch }}"
                                                    {{ old('branch', $lead->branch == $branch->branch ? 'selected': '') }}>
                                                    {{ $branch->branch }}
                                                </option>
                                                @endforeach
                                                @endif
                                                <option value="add">Add Value</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group ">
                                            <label>Profession</label>
                                            <input type="text" class="form-control" id="profession" name="profession"
                                                value="{{old('profession',$lead->profession)}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group ">
                                            <label>Sms Requred</label>
                                            <input type="checkbox" id="sms" name="sms" value=true {{$lead->sms_required ? 'checked':''}}>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group ">
                                            <label>Call Requred</label>
                                            <input type="checkbox" id="call" name="call" value=true {{$lead->call_required?'checked': ''}}>
                                        </div>
                                    </div>
                                    @if($lead->sms_required)
                                    <div class="col-lg-4" style="display: block;" id="sms_language">
                                        <div class="form-group">
                                            <label>Sms Language</label>
                                            <select class="form-control custom-select"  name="sms_language">
                                                <option
                                                    {{ old('sms_language', $lead->sms_language == 'English' ? 'selected': '') }}>
                                                    English</option>
                                                <option {{ old('sms_language', $lead->sms_language == 'Telugu' ? 'selected': '') }}>
                                                    Telugu</option>
                                            </select>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-lg-4" style="display: none;" id="sms_language">
                                        <div class="form-group">
                                            <label>Sms Language</label>
                                            <select class="form-control custom-select"  name="sms_language">
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
                        </div>


                        <h4 class="text-left my-2">Family Details</h4>
                        <hr>
                        @if(count($family_members)>0)
                        @foreach($family_members as $key=> $member)
                        <div class="fieldmore row">
                            <div class="addfamily-inp-div">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="family_member_name[]" value="{{ $member->member_relation_name }}">
                                </div>
                            </div>

                            <div class="addfamily-inp-div">
                                <div class="form-group">
                                    <label>Relationship</label>
                                    <input type="text" class="form-control" name="family_member_relation[]" value="{{ $member->member_relation }}">
                                </div>
                            </div>
                            <div class="addfamily-inp-div">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" name="family_member_dob[]" value="{{ $member->member_relation_dob }}">
                                </div>
                            </div>

                            <div class="addfamily-inp-div">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control" name="family_member_mobile[]" value="{{ $member->member_relation_mobile }}">
                                </div>
                            </div>

                            <div class="add-btn-div">
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMore"
                                    onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                            </div>
                        </div>
                        @endforeach
                        @else

                        <div class="fieldmore row">
                            <div class="addfamily-inp-div">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="family_member_name[]" value="{{old('family_member_name')}}">
                                </div>
                            </div>

                            <div class="addfamily-inp-div">
                                <div class="form-group">
                                    <label>Relationship</label>
                                    <input type="text" class="form-control" name="family_member_relation[]" value="{{old('family_member_relation')}}">
                                </div>
                            </div>
                            <div class="addfamily-inp-div">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" name="family_member_dob[]" value="{{old('family_member_dob')}}">
                                </div>
                            </div>

                            <div class="addfamily-inp-div">
                                <div class="form-group">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control" name="family_member_mobile[]" value="{{old('family_member_mobile')}}">
                                </div>
                            </div>

                            <div class="add-btn-div">
                                <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMore"
                                    onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                            </div>
                        </div>
                        @endif
                        <div class="col-lg-3 mt-2 float-right">
                            <button type="submit" class="btn btn-block btn-primary">{{ trans('laralum.submit') }}</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>






</div> 





<!-- copy of input fields group -->
<div class="numberCopy" style="display: none;">
    <div class="add-inp-div">
        <div class="form-group">
            <label>Alternate Number</label>
            <input type="text" class="form-control" name="alt_number[]" />
        </div>
    </div>

    <div class="addnum-btn-div">
        <button class="btn btn-sm btn-danger family-add-btn remove_alt" type="button"><i class="uil-minus-circle"></i></button>    
    </div>
</div>

<!-- copy of address input fields group -->
<div class="address_fieldmoreCopy row" style="display: none;">
    <div class="addaddress-inp-div">
        <div class="form-group"> 
            <label>Address</label>
            <input type="text" class="form-control" id="address" name="address[]" value="{{old('exp_company_name')}}">
        </div>
    </div>

    <div class="addaddress1-inp-div">
        <div class="form-group">
            <label>Country</label>
            <select class="form-control custom-select" id="country" name="country[]">
                <option value="">Please select</option>
                @foreach($get_countries as $country)
                <option value="{{ $country->country_code }}" {{ (old('country', 'IN') == $country->country_code ? 'selected': '') }}>{{ $country->country_name}}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="addaddress1-inp-div">
        <div class="form-group">
            <label>State</label>
            <select class="form-control custom-select" id="state_1" name="state[]"
                onchange="stateChange(this)">
                <option value="">Please select</option>
                @foreach($get_state as $state)
                <option value="{{ $state->StCode }}"
                    {{ (old('state') == $state->StCode ? 'selected': '') }}>{{ $state->StateName }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="addaddress1-inp-div">
        <div class="form-group">
            <label>District</label>
            <select class="form-control custom-select" id="district_1" name="district[]">
                <option>Select District</option>
            </select>
        </div>
    </div>
    <div class="addaddress1-inp-div">
        <div class="form-group">
            <label>Pincode</label>
            <input type="text" class="form-control" id="pincode" name="pincode[]" value="{{old('pincode')}}">
        </div>
    </div>

    <div class="add-btn-div">
        <button class="btn btn-sm btn-danger family-add-btn remove" type="button"><i class="uil-minus-circle"></i></button>     
    </div>
</div>

<!-- copy of input fields group -->
<div class="fieldmoreCopy row" style="display: none;">

    <div class="addfamily-inp-div">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="family_member_name[]">
        </div>
    </div>

    <div class="addfamily-inp-div">
        <div class="form-group">
            <label>Relationship</label>
            <input type="text" class="form-control" name="family_member_relation[]">
        </div>
    </div>
    
    <div class="addfamily-inp-div">
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" class="form-control" name="family_member_dob[]">
        </div>
    </div>

    <div class="addfamily-inp-div">
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" class="form-control" name="family_member_mobile[]">
        </div>
    </div>

    <div class="add-btn-div">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>


<!-- Add Details Modal start-->
<div id="AddDetails" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title" id="topModalLabel">Add Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="add_detail" action="javascript:void(0)">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Add Detail</label>
                        <input type="text" name="detail" id="detail" class="form-control" />
                        <input type="hidden" name="type" id="detail_type" class="form-control" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" id="editMemberForm" class="btn btn-primary">Save changes</button>
                        <!-- <span id="hidebutext">Add</span>&nbsp; -->
                        <span class="editMemberForm" style="display:none;"><img
                                    src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@section('extrascripts')

<script>

$("#uploadFile1").change(function(){
  event.preventDefault();
  $('#progress-wrp1').show();
  var file_data = $("#uploadFile1").prop("files")[0];// Getting the properties of file from file field
  var path = $('#uploadFile1').val();
  var res = path.split(".");
  var length =  (res.length)-1;
  var format = res[length]; // Getting the properties of file from file field
  if(format=='jpeg' || format=='jpg' || format=='png' || format=='pdf' || format=='doc' || format=='docs' || format=='docx'){
   // continue .
  }else{
    $.NotificationApp.send("Error","Only jpg, jpeg, png, pdf, doc, docs and docx formats are allowed !","top-center","red","error");
    $('#progress-wrp').hide();
    return;
  }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
      var formData = new FormData();  // Creating object of FormData class
      formData.append("file", file_data);
      formData.append('action_type',"IMAGE");
      formData.append("file_disc", "leads_id_proof");
      formData.append("dir_path", "leads");

      $.ajax({
      type:'POST',
      url: "{{route('Crm::leads_uploadFile')}}",
      data: formData,
      contentType: false,
      cache: false,
      processData:false,
    xhr: function(){
        //upload Progress
        var xhr = $.ajaxSettings.xhr();
        if (xhr.upload) {
            xhr.upload.addEventListener('progress', function(event) {
                var percent = 0;
                var position = event.loaded || event.position;
                var total = event.total;
                if (event.lengthComputable) {
                    percent = Math.ceil(position / total * 100);
                }
                //update progressbar
                $(".progress-bar1").css("width", + percent +"%");
                $( ".status1").text(percent +"%");
            }, true);
        }
        return xhr;
    }
     
    })
.done(function(data) {

  if(data){
    $('#addUploadFile1').hide();
    $('#addedFile1').show();
    $('#remove_id_proof').show();
    
    $('#addedFile1').html('<img class="img-thumbnail mx-auto img-fluid" src="'+data+'">');
     $('#id_proof_path').val(data);
  }

  $('#progress-wrp1').hide();
  $(".progress-bar1").css("width", + 0 +"%");

 })
    // using the fail promise callback
   .fail(function(data) {
        $('#progress-wrp1').hide();
        $(".progress-bar1").css("width", + 0 +"%");
        $.NotificationApp.send("Error","Unable to upload at this moment !","top-center","red","error");
        });
});

$("#remove_id_proof").click(function(){
    var source_path=$('#id_proof_path').val();
    if(source_path !=""){      
  
    $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url:  "{{route('Crm::leads_deleteSourcefile')}}",
            data:{source_path: source_path} ,
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        // using the done promise callback
        .done(function(data) {
        if(data.status==false){
          $.NotificationApp.send("Error","Unable to process the request","top-center","red","error");
        }

         if(data.status==true){
          $('#addUploadFile1').show();
          $('#addedFile1').hide();
          $('#remove_id_proof').hide();
          $('#addedFile1').html('');
          $('#id_proof_path').val('');
        }
        })
        // using the fail promise callback
        .fail(function(data) {
            $.NotificationApp.send("Error","Unable to process the request","top-center","red","error");
          console.log(data);
        });
  }
}); 

$("#uploadFile").change(function(){
  event.preventDefault();
  $('#progress-wrp').show();
  var file_data = $("#uploadFile").prop("files")[0];   // Getting the properties of file from file field
  var path = $('#uploadFile').val();
  var res = path.split(".");
  var length =  (res.length)-1;
  var format = res[length]; // Getting the properties of file from file field
  if(format=='jpeg' || format=='jpg' || format=='png'){
   // continue .
  }else{
    $.NotificationApp.send("Error","Only jpg, jpeg and png formats are allowed !","top-center","red","error");
    $('#progress-wrp').hide();
    return;
  }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
      var formData = new FormData();  // Creating object of FormData class
      formData.append("file", file_data);
      formData.append('action_type',"IMAGE");
      formData.append("file_disc", "leads_profile");
      formData.append("dir_path", "leads");

      $.ajax({
      type:'POST',
      url: "{{route('Crm::leads_uploadFile')}}",
      data: formData,
      contentType: false,
      cache: false,
      processData:false,
    xhr: function(){
        //upload Progress
        var xhr = $.ajaxSettings.xhr();
        if (xhr.upload) {
            xhr.upload.addEventListener('progress', function(event) {
                var percent = 0;
                var position = event.loaded || event.position;
                var total = event.total;
                if (event.lengthComputable) {
                    percent = Math.ceil(position / total * 100);
                }
                //update progressbar
                $(".progress-bar").css("width", + percent +"%");
                $( ".status").text(percent +"%");
            }, true);
        }
        return xhr;
    }
     
    })
.done(function(data) {

  if(data){
    $('#addUploadFile').hide();
    $('#addedFile').show();
    $('#remove_profile_photo').show();
    
    $('#addedFile').html('<img class="img-thumbnail mx-auto img-fluid" src="'+data+'">');
     $('#profile_photo_path').val(data);
  }

  $('#progress-wrp').hide();
  $(".progress-bar").css("width", + 0 +"%");

 })
    // using the fail promise callback
   .fail(function(data) {
        $('#progress-wrp').hide();
        $(".progress-bar").css("width", + 0 +"%");
        $.NotificationApp.send("Error","Unable to upload at this moment !","top-center","red","error");
            return false; 
        });
});

$("#remove_profile_photo").click(function(){

    var source_path=$('#profile_photo_path').val();
    //alert(source_path);return;
    if(source_path !=""){      
  
    $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url:  "{{route('Crm::leads_deleteSourcefile')}}",
            data:{source_path: source_path} ,
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        // using the done promise callback
        .done(function(data) {
        if(data.status==false){
            $.NotificationApp.send("Error","Unable to process the request.","top-center","red","error");
        }

         if(data.status==true){
          $('#addUploadFile').show();
          $('#addedFile').hide();
          $('#remove_profile_photo').hide();
          $('#addedFile').html('');
          $('#profile_photo_path').val('');
        }
        })
        // using the fail promise callback
        .fail(function(data) {
            $.NotificationApp.send("Error","Unable to process the request.","top-center","red","error");
            console.log(data);
            return false;  
          
          
        });
  }
});    

$("#editForm").submit(function(event){
    event.preventDefault();
    $( ".btn" ).prop( "disabled", true );
    //$('#submit-btn').prop('disabled',true);
    var edit_id=$('#edit_id').val();
    var name = $('#name').val();
    var mobile = $('#mobile').val();
    if (name == '' || mobile == '' ) {
        $.NotificationApp.send("Error","Name and mobile fields are required.","top-center","red","error");
        $( ".btn" ).prop( "disabled", false );
        return false;
    }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    var formData=new FormData(this);
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url:  "{{route('Crm::lead_update')}}",
        data:formData ,
        dataType: 'json', // what type of data do we expect back from the server
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        dataType: 'json',
    })
    // using the done promise callback
    .done(function(data) {
        if(data.status==false){
            $.NotificationApp.send("Error",data.message,"top-center","red","error");
            $( ".btn" ).prop( "disabled", false );
            setTimeout(function(){
                //location.reload();
            }, 3500);
        
        }

        if(data.status==true){
            $.NotificationApp.send("Success",data.message,"top-center","green","success");
            $( ".btn" ).prop( "disabled", false );
            setTimeout(function(){
                //location.reload();
                var url = "{{route('Crm::lead_details', '')}}"+"/"+edit_id;
                location.href=url;
            }, 3500);
        }

    })
    // using the fail promise callback
    .fail(function(data) {
        $.NotificationApp.send("Error",data.message,"top-center","red","error");
        $( ".btn" ).prop( "disabled", false );
        setTimeout(function(){
            //location.reload();
        }, 3500);
    });

})

$(document).ready(function(){
        
    //group add limit
    var maxGroup = 3;

    //add AlternateNumbers
    $(".addAlternate").click(function(){
        if($('body').find('.numbermore').length < maxGroup){
            var fieldHTML = '<div class="numbermore">'+$(".numberCopy").html()+'</div>';
            $('body').find('.numbermore:last').after(fieldHTML);
            //$('#alternetcontainer').append(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' numbers are allowed.');
        }
    });
    //remove numbermore group
    $("body").on("click",".remove_alt",function(){ 
        $(this).parents(".numbermore").remove();
    });


    //add more fields group
    $(".addMore").click(function(){
        if($('body').find('.fieldmore').length < maxGroup){
            var fieldHTML = '<div class="fieldmore row">'+$(".fieldmoreCopy").html()+'</div>';
            $('body').find('.fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldmore").remove();
    });
     
    //add more address group
     $(".addAddress").click(function(){
         var length=$('body').find('.addressmore').length;
        if( length< maxGroup){
            var clone = $(".addressmore:last").clone();
            clone.find("#state_"+length).attr("id","state_"+(length+1));
            clone.find("#district_"+length).attr("id","district_"+(length+1));
            var btn=clone.find(".addAddress");
            var type=clone.find('.header_title');
            var address_type=clone.find('#address_type');
            address_type.val('temp');
            type.text('Temporary Address');
            btn.html('<i class="fa fa-minus"></i>');
            btn.addClass('btn-danger').removeClass('btn-primary');
            btn.attr("id","remove_address");
            
            $('body').find('.addressmore:last').after(clone);
        }else{
            alert('Maximum '+maxGroup+' address are allowed.');
        }
    });
    //remove address group
     $("body").on("click","#remove_address",function(){ 
        $(this).parents(".addressmore").remove();
    });


    $('#mobile').on('input',function(e){
        var value=$(this).val();
        if(value.length>=10 && value!=$(this).attr('data-old')){
            $('#verify_mobile').show();
        }
        if(value.length>10){
            $.NotificationApp.send("Error","Mobile no. should not be more than 10 digits.","top-center","red","error");
        }
    });
    /*send otp*/
    $('#verify_mobile').click(function () {
        if($('#verify_label').text()=='Verified')   {
            return;
        }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })       
        
        var sender = $("#sender_id").val();
        var receiver_mobile = $("#mobile").val();
        if($('#verify_label').text()!='Verify') {
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
    $('#branch').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(4);
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
    $('#source_id').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(2);
              $("#AddDetails").modal("show");
          }
    });

    $('#preferred_language').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(6);
              $("#AddDetails").modal("show");
          }
    });
    $('#lead_response').change(function(){
                //Selected value
                var inputValue = $(this).val();
                //Ajax for calling php function
                 if ('add' == inputValue){
                    $("#detail_type").val(7);
              $("#AddDetails").modal("show");
          }
    });

    $('#lead_status').change(function(){
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue){
            $("#detail_type").val(8);
            $("#AddDetails").modal("show");
        }
    });
    var APP_URL="{{route('console::console')}}";

    $('#add_detail').submit(function (e) {
        e.preventDefault();
        //  e.preventDefault();
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
            my_url=APP_URL + '/manage/departmentData';
            formData.append('department',detail);
        }
        else if($('#detail_type').val()==4){
            my_url=APP_URL + '/manage/branchData';
            formData.append('branch',detail);
        }
        else if($('#detail_type').val()==6){
            my_url=APP_URL + '/manage/preferredLanguageData';
            formData.append('preferred_language',detail);
        }
        else if($('#detail_type').val()==7){
            my_url=APP_URL + '/manage/leadResponseData';
            formData.append('lead_response',detail);
        }
        else if($('#detail_type').val()==8){
            my_url=APP_URL + '/manage/leadStatusData';
            formData.append('lead_status',detail);
        }
        else
         my_url = APP_URL + '/manage/memberData';
        var type = "POST";
        var addText=$('#detail').val();
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                if(data.status==true){
                   if($('#detail_type').val()==0){
                    $('#account_type_id').val(null).trigger('change');
                    $("#account_type_id option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==3){
                        $('#department').val(null).trigger('change');
                        $("#department option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==1){
                        $('#member_type_id').val(null).trigger('change');
                        $("#member_type_id option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==2){
                        $('#source_id').val(null).trigger('change');
                        $("#source_id option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==6){
                        $('#preferred_language').val(null).trigger('change');
                        $("#preferred_language option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==7){
                        $('#lead_response').val(null).trigger('change');
                        $("#lead_response option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==8){
                        $('#lead_status').val(null).trigger('change');
                        $("#lead_status option:last").before("<option value="+data.message.lead_status+">"+addText+"</option>");
                    }  
                }
            },
            error: function (data) {
                swal('Error!', data, 'error')
            }
        });
    });

});

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
    console.log(district);
    district.empty();
    district.append('<option>Please select</option>');
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


$(document).ready(function(){
$("#agent").change(function() {
    
    var id = $(this).val();
    if(id!=""){

        $('#lead_status').removeAttr('selected');
        $('#lead_status').val(1); // Select the option with a value of '1'
         $('#lead_status').trigger('change'); // Notify any JS components that the value changed


        
    }
   
 });   });


</script>
@endsection    