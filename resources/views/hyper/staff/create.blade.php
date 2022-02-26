@extends('hyper.layout.master')
@section('title', "Staff Create")
@section('content')
<div class="px-2">
    <!-- start page title  -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::staff') }}"><i class="uil-home-alt"></i> staff</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Staff Create</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <!-- <h4 class="header-title mb-3">Staff Create</h4> -->
                    <div id="rootwizard">
                        <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                            <li class="nav-item" data-target-form="#Personal_details">
                                <a href="#personal_details" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-home-account"></i>
                                    <span class="d-none d-sm-inline">PERSONAL DETAILS</span>
                                </a>
                            </li>
                            
                            <li class="nav-item" data-target-form="#Work_details">
                                <a href="#work_details" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-book-account-outline"></i>
                                    <span class="d-none d-sm-inline">WORK</span>
                                </a>
                            </li>
                            <li class="nav-item" data-target-form="#Family_details">
                                <a href="#family_details" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-account-circle"></i>
                                    <span class="d-none d-sm-inline">FAMILY DETAILS</span>
                                </a>
                            </li>
                            <li class="nav-item" data-target-form="#Salary_details">
                                <a href="#salary_details" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-cog"></i>
                                    <span class="d-none d-sm-inline">SALARY DETAILS</span>
                                </a>
                            </li>
                            <li class="nav-item" data-target-form="#Payment_info">
                                <a href="#payment_info" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                    <i class="mdi mdi-phone-log"></i>
                                    <span class="d-none d-sm-inline">PAYMENT INFO</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content mb-0 b-0">
                            <div class="tab-pane" id="personal_details">
                                <form id="Personal_details" method="post" action="#" class="form-horizontal">
                                    {{csrf_field()}}
                                    <input name="step" value="1" type="hidden"/>
                                    <input type="hidden" id="add_id_personal_details" name="add_id" value="">
                                    <input type="hidden" name="form_name" value="staff_update_personal_details">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Name <span class="red-txt">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" required value="{{old('name')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Password <span class="red-txt">*</span></label>
                                                <input type="password" class="form-control" minlength="6" id="password" name="password" required value="{{old('password')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Confirm Password <span class="red-txt">*</span></label>
                                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="6" required value="{{old('confirm_password')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Nick Name</label>
                                                <input type="text" class="form-control" id="nick_name" name="nick_name" value="{{old('nick_name')}}">
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>PAN card number</label>
                                                <input type="text" class="form-control" id="pan_no" name="pan_no" value="{{old('pan_no')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Adhar card number</label>
                                                <input type="text" class="form-control" id="adhar_no" name="adhar_no" value="{{old('adhar_no')}}">
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Tags</label>
                                                <input type="text" class="form-control" id="tags" name="tags" value="{{old('tags')}}"> 
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Gender</label>
                                                <select class="form-control custom-select" id="gender" name="gender">
                                                    <option value="Male" {{ (old('gender') == "Male" ? 'selected': '') }}>Male</option>
                                                    <option value="Female" {{ (old('gender') == "Female" ? 'selected': '') }}>Female
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Marital Status</label>
                                                <select class="form-control custom-select" id="marriedstatus" name="marriedstatus">
                                                    <option value="Single" {{ (old('marriedstatus') == "Single" ? 'selected': '') }}>Single
                                                    </option>
                                                    <option value="Married" {{ (old('marriedstatus') == "Married" ? 'selected': '') }}>
                                                        Married</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date of birth</label>
                                                <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="text" class="form-control" id="age" name="age" value="{{old('age')}}" disabled="disabled">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Father's Name</label>
                                                <input type="text" class="form-control" id="father_name" name="father_name" value="{{ old('father_name') }}">
                                    
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
                                            </div>
                                        </div> 
                                        <div class="col-md-8">
                                            <label>Tags</label>
                                            <div class="input-group mb-3">
                                                <input id="tag" type="text" class="form-control" placeholder="Add tag description" >
                                                <div class="input-group-append">
                                                    <button onclick="add_more_inclusions()" class="btn btn-sm btn-primary" type="button"><i class="uil-plus-circle"></i> Tag</button>
                                                </div>
                                            </div>
                                           <div id="more_inclusions" class="row"> 
                                           </div>
                                        </div>
                                    </div>
                                    
   
                                    <div class="numbermore row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email <span class="red-txt">*</span> </label>
                                                <input type="email" class="form-control" id="email" name="email" required value="{{old('email')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div style="display: inline-block; width: 100%;">
                                                    <div id="verify_mobile" style="display: none;float: right;">
                                                        <button class="btn btn-danger" type="button" id="verify_label">Verify</button>
                                                    </div>
                                                    <label>Mobile <span class="red-txt">*</span></label>
                                                </div>
                                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{old('mobile')}}">
                                                    <input type="number" class="form-control" id="otp" name="otp" value="" placeholder="Enter Otp" style="display: none; margin-top: 10px">
                                                    <input type="hidden" id="sender_id" value="{{ auth()->user()->id }}" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <label>Alternate Number</label>
                                                        <input type="text" class="form-control" name="alt_mobile[]" />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="add-btn-div mb-2">
                                                        <button class="btn btn-sm btn-primary family-add-btn addAlternate" type="button"><i class="uil-plus-circle"></i></button>    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="alternetcontainer"></div>

                                    <div class="education_fieldmore row">
                                        <div class="add1-inp-div">
                                            <div class="form-group">
                                                <label>School Name</label>
                                                <input type="text" class="form-control" name="edu_school_name[]" value="{{old('edu_school_name')}}">
                                            </div>
                                        </div>

                                        <div class="add1-inp-div">
                                            <div class="form-group">
                                                <label>Degree/Diploma</label>
                                                <input type="text" class="form-control" name="edu_degree[]" value="{{old('edu_degree')}}">
                                            </div>
                                        </div>



                                        <div class="add1-inp-div">
                                            <div class="form-group">
                                                <label>Field(s) of Study</label>
                                                <input type="text" class="form-control" name="edu_branch[]" value="{{old('edu_branch')}}">
                                            </div>
                                        </div>

                                        <div class="add1-inp-div">
                                            <div class="form-group">
                                                <label>Date of Completion</label>
                                                <input type="date" class="form-control" name="edu_completion_date[]" value="{{old('edu_completion_date')}}">
                                            </div>
                                        </div>
                                            
                                        <div class="add1-inp-div">
                                            <div class="form-group">
                                                <label>Additional Notes</label>
                                                <input type="text" class="form-control" name="edu_add_note[]" value="{{old('edu_add_note')}}">
                                            </div>
                                        </div>
                                        <div class="add1-inp-div">
                                            <div class="form-group">
                                                <label>Interests</label>
                                                <input type="text" class="form-control" name="edu_interest[]" value="{{old('edu_interest')}}">
                                            </div>
                                        </div>

                                        <div class="add-btn-div">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMoreEducation"
                                                onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" id="staff_share" name="staff_share" value="1">
                                                <label for="staff_share"> Employee is a Director/person with substantial interest in the company.<a href="javascript:void(0);" title="'substantial interest in the company' means that employee is banificial owner of shares and carries at least 20% of voting power.This detail will help us fill out Form 12BA for this employee"><i class="uil-info-circle font-20"></i></a></label>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" id="portal_access" name="portal_access" value="1">
                                                <label for="portal_access"> Enable Portal Access</label><br>
                                                <p>The employee will be able to view payslips, submit their IT declaration and create reimbursement claims through the employee portal.</p>
                                            </div>
                                            <!-- <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="portal_access" name="portal_access">
                                                <label class="custom-control-label" for="customCheck5">Enable Portal Access</label><br>
                                                <p>The employee will be able to view payslips, submit their IT declaration and create reimbursement claims through the employee portal.</p>
                                            </div> -->
                                        </div>
                                        <div class="col-md-12">
                                            <h4>Statutory Components</h4>
                                            <p>Enable the necessary benefits and tax applicable for this employee.</p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" id="employee_provident_fund" name="provident_fund" value="1" checked>
                                                <label for="employee_provident_fund"> Employees' Provident Fund</label><br>
                                            </div>
                                            <!-- <div class="custom-control">
                                                <input type="checkbox" class="form-control" id="employee_provident_fund" name="employee_provident_fund" checked>
                                                <label class="custom-control-label">Employees' Provident Fund</label><br>
                                            </div> -->
                                            <div class="row" id="employee_provident_fund_fields">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>PF Account Number </label>
                                                        <input type="text" class="form-control" id="pf_ac_no" name="pf_ac_no" value="{{old('pf_ac_no')}}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label>UAN</label>
                                                        <input type="text" class="form-control" id="uan" name="uan" value="{{old('uan')}}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="checkbox" id="pension_scheme" name="pension_scheme" value="1">
                                                        <label for="pension_scheme"> Contribute to Employee Pension Scheme<a href="javascript:void(0);" title="Employees enrolled as EPF members on or before September 1, 2014, and employees enrolled after September 1, 2014 receiving less than ₹15,000 will have to contribute to the Employee Pension Scheme mandatorily. Employees receiving more than ₹15,000 need not contribute to EPS and their entire PF contribution will go into their Provident Fund account."><i class="uil-info-circle font-20"></i></a></label><br>
                                                    </div>
                                                    <!-- <div class="custom-control custom-checkbox custom-control-inline">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck3" name="pension_scheme" checked>
                                                        <label class="custom-control-label" for="customCheck3">Contribute to Employee Pension Scheme <a href="javascript:void(0);" title="Employees enrolled as EPF members on or before September 1, 2014, and employees enrolled after September 1, 2014 receiving less than ₹15,000 will have to contribute to the Employee Pension Scheme mandatorily. Employees receiving more than ₹15,000 need not contribute to EPS and their entire PF contribution will go into their Provident Fund account."><i class="uil-info-circle font-20"></i></a></label><br>
                                                    </div>   staff_share work_email dob father_name portal_access employee_provident_fund pf_ac_no uan pension_scheme professional_tax -->
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="checkbox" id="professional_tax" name="professional_tax" value="1">
                                                <label for="professional_tax"> Professional Tax</label><br>
                                            </div>
                                            <!-- <div class="custom-control custom-checkbox custom-control-inline">
                                                <input type="checkbox" class="custom-control-input" id="customCheck3" name="professional_tax" checked>
                                                <label class="custom-control-label" for="customCheck3">Professional Tax </label><br>
                                            </div> -->
                                        </div>
                                        <ul class="list-inline wizard mb-0">
                                            <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Save and Continue</a></li>
                                        </ul>
                                    </div>
                                    
                                </form>
                            </div>

                            <div class="tab-pane" id="work_details">
                                <form id="Work_details" method="post" action="#" class="form-horizontal">    
                                    {{csrf_field()}}
                                    <input name="step" value="2" type="hidden"/>
                                    <input type="hidden" id="add_id_work_details" name="add_id" value="">
                                    <input type="hidden" name="form_name" value="staff_update_work_details">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="example-email">Work Email</label>
                                                <input type="email" id="work_email" name="work_email" class="form-control" placeholder="Email" data-container="body" title="" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="You cannot change this Email address later on, as this will be used to send payslips and also for employees to sign in to their portal, where they can view/download their payslips." data-original-title="">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <select class="form-control select2" name="department" id="department" data-toggle="select2" data-placeholder="Please select..">
                                                    <option value="">Please select..</option>    
                                                    @if(!empty($departments))
                                                    @foreach($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ (old('department') == $department->id ? 'selected': '') }}>
                                                        {{ $department->department }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                    <option value="add">Add Value</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Location <span class="red-txt">*</span></label>
                                                <input type="text" class="form-control" id="location" name="location" value="{{old('location')}}">
                                    
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Work Location</label>
                                                <select class="form-control select2" id="location" name="location" data-toggle="select2" data-placeholder="Please select..">
                                                    <option value="">Please select..</option>
                                                    @if(!empty($work_locations))
                                                    @foreach($work_locations as $work_location)
                                                    <option value="{{ $work_location->work_location }}"
                                                        {{ (old('location') == $work_location->work_location ? 'selected': '')}}>
                                                        {{ $work_location->work_location }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                    <option value="add">Add Value</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Reporting To</label>
                                                <select class="form-control select2" name="reporting_to" id="reporting_to" data-toggle="select2" data-placeholder="Please select..">
                                                    <option value="">Please select..</option>
                                                    @if(!empty($work_locations))
                                                    @foreach($users as $user_list)
                                                    <option value="{{ $user_list->id }}" {{ (old('reporting_to') == $user_list->id ? 'selected': '') }}>{{ $user_list->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Experience</label>
                                                <input type="text" class="form-control" id="experience" name="experience" value="{{old('experience')}}">
                                    
                                            </div>
                                        </div>



                                    <!-- </div>
                                    <div class="row">  -->

                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Work Title</label>
                                                <select class="form-control select2" name="work_title" id="work_title" data-toggle="select2" data-placeholder="Please select..">
                                                    <option value="">Please select..</option>
                                                    @if(!empty($designations))
                                                    @foreach($designations as $designation)
                                                    <option value="{{ $designation->designation }}"
                                                        {{ (old('work_title') == $designation->designation ? 'selected': '') }}>
                                                        {{ $designation->designation }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                    <option value="add">Add Value</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Source of hire</label>
                                                <select class="form-control select2" name="hire_source" id="hire_source" data-toggle="select2" data-placeholder="Please select..">
                                                    <option value="">Please select..</option>
                                                    @if(!empty($work_locations))
                                                    @foreach($hire_sources as $source)
                                                    <option value="{{ $source->id }}"
                                                        {{ (old('hire_source') == $source->id ? 'selected': '') }}>
                                                        {{ $source->hire_source }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                    <option value="add">Add Value</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Date of Joining</label>
                                                <input type="date" class="form-control" id="joining_date" name="joining_date" value="{{old('joining_date')}}">
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="row"> -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Seating Location <span class="red-txt"></span></label>
                                                <input type="text" class="form-control" id="seating_location" name="seating_location" value="{{old('seating_location')}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Staff status</label>
                                                <select class="form-control select2" name="work_status" id="work_status" data-toggle="select2" data-placeholder="Please select..">
                                                    <option value="">Please select..</option>
                                                    @if(!empty($staffstatus))
                                                    @foreach($staffstatus as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ (old('work_status') == $status->id ? 'selected': '') }}>
                                                        {{ $status->status }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                    <option value="add">Add Value</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label>Staff type</label>
                                                <select class="form-control select2" name="staff_type" id="staff_type" data-toggle="select2" data-placeholder="Please select..">
                                                    <option value="">Please select..</option>
                                                    @if(!empty($stafftypes))
                                                    @foreach($stafftypes as $types)
                                                    <option value="{{ $types->id }}"
                                                        {{ (old('staff_type') == $types->id ? 'selected': '') }}>
                                                        {{ $types->type }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                    <option value="add">Add Value</option>                      
                                                </select>
                                            </div>
                                        </div>
                                    <!-- </div>
                                    <div class="row"> -->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Work phone</label>
                                                <input type="text" class="form-control" id="work_phone" name="work_phone" value="{{old('work_phone')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Extension</label>
                                                <input type="text" class="form-control" id="extension" name="extension" value="{{old('extension')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Role</label>
                                                <select class="form-control custom-select" name="work_role" id="work_role">
                                                    <option value="">Please select..</option>
                                                    @if(!empty($roles))
                                                    @foreach($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ (old('work_role') == $role->id ? 'selected': '') }}>
                                                        {{ $role->name }}
                                                    </option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Job Description</label>
                                                <input type="text" class="form-control" id="job_desc" name="job_desc" value="{{old('job_desc')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>AboutMe</label>
                                                <input type="text" class="form-control" id="about_me" name="about_me" value="{{old('about_me')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label>Ask me about/Expertise</label>
                                                <input type="text" class="form-control" id="expertise" name="expertise" value="{{old('expertise')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div>
                                                <label>Date of exit</label>
                                                <input type="date" class="form-control" id="exit_date" name="exit_date" value="{{old('exit_date')}}">
                                            </div>
                                        </div>

                                    </div> 
                                    <!-- <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Experience</label>
                                                <input type="text" class="form-control" id="experience" name="experience" value="{{old('experience')}}">
                                    
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="work_fieldmore row">
                                        <div class="add2-inp-div">
                                            <div class="form-group">
                                                <label>Previous Company Name</label>
                                                <input type="text" class="form-control" name="exp_company_name[]" value="{{old('exp_company_name')}}">
                                            </div>
                                        </div>

                                        <div class="add2-inp-div">
                                            <div class="form-group">
                                                <label>Job Title</label>
                                                <input type="text" class="form-control" name="exp_job_title[]" value="{{old('exp_job_title')}}">
                                            </div>
                                        </div>
                                        
                                        <div class="add2-inp-div">
                                            <div class="form-group">
                                                <label>From Date</label>
                                                <input type="date" class="form-control" name="exp_from_date[]" value="{{old('exp_from_date')}}">
                                            </div>
                                        </div>
                                        <div class="add2-inp-div">
                                            <div class="form-group">
                                                <label>To Date</label>
                                                <input type="date" class="form-control" name="exp_to_date[]" value="{{old('exp_to_date')}}">
                                            </div>
                                        </div>
                                        <div class="add2-inp-div">
                                            <div class="form-group">
                                                <label>Job Description</label>
                                                <input type="text" class="form-control" name="exp_job_desc[]" value="{{old('exp_job_desc')}}">
                                            </div>
                                        </div>

                                        <div class="add-btn-div">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMoreWork"
                                                onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                                        </div>
                                        <ul class="list-inline wizard mb-0">
                                            <li class="previous list-inline-item"><a href="#" class="btn btn-outline-primary">Previous</a>
                                            </li>
                                            <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Submit</a></li>
                                        </ul>
                                    </div>
                                    

                                     

                                    
                                </form>
                            </div>
                            <div class="tab-pane mb-3" id="family_details">
                                <form class="form-horizontal" id="Family_details" method="POST" action="#">
                                    <input name="step" value="6" type="hidden"/>
                                    <input type="hidden" id="add_id_family_details" name="add_id" value="">
                                    <input type="hidden" name="form_name" value="staff_update_family_details">
                                    <div class="fieldmore row">
                                        <div class="addfamily-inp-div">
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="staff_relation_name[]" value="{{old('staff_relation_name')}}">
                                            </div>
                                        </div>

                                        <div class="addfamily-inp-div">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <input type="text" class="form-control" name="staff_relation[]" value="{{old('staff_relation')}}">
                                            </div>
                                        </div>

                                        <div class="addfamily-inp-div">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input type="date" class="form-control" name="staff_relation_dob[]" value="{{old('staff_relation_dob')}}">
                                            </div>
                                        </div>

                                        <div class="addfamily-inp-div">
                                            <div class="form-group">
                                                <label>Mobile</label>
                                                <input type="text" class="form-control" name="staff_relation_mobile[]" value="{{old('staff_relation_mobile')}}">
                                            </div>
                                        </div>

                                        <div class="add-btn-div">
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMore"
                                                onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                                        </div>
                                        <ul class="list-inline wizard mb-0">
                                            <li class="previous list-inline-item"><a href="#" class="btn btn-outline-primary">Previous</a>
                                            </li>
                                            <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Next</a></li>
                                        </ul>
                                    </div>

                                    
                                </form>
                            </div>
                            <div class="tab-pane container-fluid" id="salary_details">
                                <form class="form-horizontal" id="Salary_details" method="POST" action="#" >
                                    <input name="step" value="4" type="hidden"/>
                                    <input type="hidden" id="add_id_salary_details" name="add_id" value="">
                                    <input type="hidden" name="form_name" value="staff_update_salary_details">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="mt-1">Annual CTC * </p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" id="anual_ctc_value" type="number" value="0" data-bts-prefix="₹" name="anual_ctc">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mt-1">per year </p>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="col-md-3 center">
                                            <center><p>Salary Components</p></center>
                                        </div>
                                        <div class="col-md-3 center">
                                            <center><p>Calculation Type</p></center>
                                        </div>
                                        <div class="col-md-3 center">
                                            <center><p>Amount Monthly</p></center>
                                        </div>
                                        <div class="col-md-3 center">
                                            <center><p>Amount Annually</p></center>
                                        </div>
                                        </hr>
                                    </div>
                                    <h4>Earnings</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Basic</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input class="text-right" data-toggle="touchspin" value="40" type="text" id="basic_ctc_percentage" data-step="0.1" data-decimals="2" data-bts-postfix="% of CTC" name="basic_ctc_percentage">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" id="monthly_basic_pay" value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="anual_basic_pay">0</p>
                                            </div>
                                        </div>
                                    </div>   

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>House Rent Allowance</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input class="text-right" data-toggle="touchspin" value="40" id="hra_percentage" type="text" data-step="0.1" data-decimals="2" data-bts-postfix="% of CTC" name="hra_percentage">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" id="hra_monthly"  value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="hra_anualy">0</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Special Allowance</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input class="text-right" data-toggle="touchspin" value="20" id="special_allowance_percentage" type="text" data-step="0.1" data-decimals="2" data-bts-postfix="% of CTC" name="special_allowance_percentage">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" id="special_allowance_monthly"  value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="special_allowance_anualy">0</p>
                                            </div>
                                        </div>
                                    </div>  

                                    <!-- <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Conveyance Allowance</p>                                                
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Fixed amount</p> 
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p>0</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Children Education Allowance</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Fixed amount</p> 
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p>0</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Transport Allowance</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Fixed amount</p> 
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p>0</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Travelling Allowance</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <p>Fixed amount</p> 
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p>0</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Fixed Allowance<a href="javascript:void(0);" title="Fixed Allowance is the resudual component of salary that is left after allocations are made for all other components."><i class="uil-info-circle font-20"></i></a></p> 
                                                <p>Monthly CTC - Sum of all other components</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Fixed amount</p> 
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p>System Calculated</p> 
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p>System Calculated</p> 
                                            </div>
                                        </div>
                                    </div> -->
                                    <h4>Deductions</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>EPF - Employer Contribution</p>
                                                <!-- <p>EPS contribution is not enabled</p> -->
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <!-- <p>12.00% of PF Wages </p>  -->
                                                <input class="text-right" data-toggle="touchspin" value="12" id="pf_percentage" type="text" data-step="0.1" data-decimals="2" data-bts-postfix="% of CTC" name="pf_percentage">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" id="pf_monthly"  value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="pf_anualy">0</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>ESI - Employer Contribution</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <input class="text-right" data-toggle="touchspin" value="0.75" id="esi_percentage" type="text" data-step="0.05" data-decimals="2" data-bts-postfix="% of CTC" name="esi_percentage">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" id="esi_monthly"  value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="esi_anualy">0</p>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>PT</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <input class="text-right" data-toggle="touchspin" value="0" id="pt_percentage" type="text" data-step="0.05" data-decimals="2" data-bts-postfix="% of CTC" name="pt_percentage">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" id="pt_monthly"  value="0" disabled="disabled">    
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="pt_anualy">0</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <p>Advance</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group ">
                                                <input class="text-right" data-toggle="touchspin" value="0" id="advance_percentage" type="text" data-step="0.05" data-decimals="2" data-bts-postfix="% of CTC" name="advance_percentage">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <input class="text-right" data-toggle="" type="text" id="advance_monthly"  value="0" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="advance_anualy">0</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <p>System Calculated Components' Total <a href="#">Preview</a></p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p>0</p> 
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p>0</p> 
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group ">
                                                <p>Cost to Company</p>                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="monthly_cost_company">0</p> 
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group text-right">
                                                <p id="anual_cost_company">0</p> 
                                            </div>
                                        </div>
                                        <ul class="list-inline wizard mb-0">
                                            <li class="previous list-inline-item"><a href="#" class="btn btn-outline-primary">Previous</a>
                                            </li>
                                            <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Submit</a></li>
                                        </ul>
                                    </div>
                                    
                                </form>
                            </div>
                            <div class="tab-pane" id="payment_info">
                                <form class="form-horizontal" id="Payment_info" method="POST" action="#">
                                    <input name="step" value="5" type="hidden"/>
                                    <input type="hidden" id="add_id_payment_info" name="add_id" value="">
                                    <input type="hidden" name="form_name" id="staff_update_payment_info" value="staff_update_payment_info"> 
                                    <!--  -->
                                    <input type="hidden" id="direct_diposit_option" name="direct_diposit" value="0">
                                    <input type="hidden" id="manual_diposit_option" name="manual_diposit" value="0">
                                    <input type="hidden" id="cheque_diposit_option" name="cheque_diposit" value="0">
                                    <h4>How would you like to pay this employee?<span class="red-txt">*</span></h4>

                                    <div class="row">
                                        <!-- <div class="col-md-12">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <a href="javascript:void(0);" onclick="payment_type_manage(1)"  class="mark_check">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <i class="dripicons-enter font-30"></i>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <p>Direct Deposit (Automated Process)</p>
                                                            <p>Initiate payment in Cleverstack Payroll once the pay run is approved</p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <i class="uil-check-circle font-30"></i>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-12" id="direct_payment" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Account Holder Name <span class="red-txt">*</span></label>
                                                                <input type="text" class="form-control" id="direct_ac_holder_name" name="direct_ac_holder_name" value="{{old('direct_ac_holder_name')}}" required>
                                                            </div>    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Bank Name <span class="red-txt">*</span></label>
                                                                <input type="text" class="form-control" id="direct_bank_name" name="direct_bank_name" value="{{old('direct_bank_name')}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Account Number <span class="red-txt">*</span></label>
                                                                <input type="text" class="form-control" id="direct_ac_no" name="direct_ac_no" value="{{old('direct_ac_no')}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Re-enter Account Number <span class="red-txt">*</span></label>
                                                                <input type="text" class="form-control" id="direct_confirm_ac_no" name="direct_confirm_ac_no" value="{{old('direct_confirm_ac_no')}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>IFSC <span class="red-txt">*</span></label>
                                                                <input type="text" class="form-control" id="direct_ifsc" name="direct_ifsc" value="{{old('direct_ifsc')}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Account Type <span class="red-txt">*</span></label><br>
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" id="customRadio3" name="direct_ac_type" class="custom-control-input">
                                                                    <label class="custom-control-label" for="customRadio3">Current</label>
                                                                </div>
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" id="customRadio4" name="direct_ac_type" checked class="custom-control-input">
                                                                    <label class="custom-control-label" for="customRadio4">Savings </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div> -->
                                        <div class="col-md-12">
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <a href="javascript:void(0);" class="mark_check">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <i class="dripicons-home font-30"></i>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <p>Bank Transfer (Manual Process)</p>
                                                            <p>Download Bank Advice and process the payment through your bank's website</p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <i class="uil-check-circle manual_color font-30" onclick="payment_type_manage(1)"></i>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-12" id="bank_payment" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Account Holder Name <span class="red-txt">*</span></label>
                                                                <input type="text" class="form-control" id="manual_ac_holder_name" name="ac_holder_name" value="{{old('ac_holder_name')}}">
                                                            </div>    
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Bank Name <span class="red-txt">*</span></label>
                                                                <input type="text" class="form-control" id="manual_bank_name" name="bank_name" value="{{old('bank_name')}}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Account Number <span class="red-txt">*</span></label>
                                                                <input type="password" class="form-control" id="manual_ac_no" name="ac_no" value="{{old('manual_ac_no')}}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Re-enter Account Number <span class="red-txt">*</span></label>
                                                                <input type="text" class="form-control" id="manual_confirm_ac_no" name="manual_confirm_ac_no" value="{{old('manual_confirm_ac_no')}}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>IFSC <span class="red-txt">*</span></label>
                                                                <input type="password" class="form-control" id="manual_ifsc" name="ifsc" value="{{old('manual_ifsc')}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Account Type <span class="red-txt">*</span></label><br>
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" id="customRadio3" name="ac_type" class="custom-control-input" value="Current">
                                                                    <label class="custom-control-label" for="customRadio3">Current</label>
                                                                </div>
                                                                <div class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" id="customRadio4" name="ac_type" checked class="custom-control-input" value="Savings">
                                                                    <label class="custom-control-label" for="customRadio4">Savings</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <a href="javascript:void(0);" class="mark_check">
                                                    <div class="row">
                                                        <div class="col-md-2"> 
                                                            <i class="uil-money-stack font-30"></i>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <p>Cheque</p>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <i class="uil-check-circle check_color font-30" onclick="payment_type_manage(2)"></i>
                                                        </div>
                                                    </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <ul class="list-inline wizard mb-0">
                                            <li class="previous list-inline-item"><a href="#" class="btn btn-outline-primary">Previous</a>
                                            </li>
                                            <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Submit</a></li>
                                        </ul>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- copy of input fields group -->
<div class="numberCopy" style="display: none;">
    <div class="row">
        <div class="col-10">
            <div class="form-group">
                <label>Alternate Number</label>
                <input type="text" class="form-control" name="alt_mobile[]" />
            </div>
        </div>
        <div class="col-2">
            <div class="addnum-btn-div">
                <button class="btn btn-sm btn-danger family-add-btn remove_alt" type="button"><i class="uil-minus-circle"></i></button>    
            </div>
        </div>
    </div>
</div>


<!-- copy of experience input fields group -->

<div class="work_fieldmoreCopy row"  style="display: none;">
    <div class="add2-inp-div">
        <div class="form-group">
            <label>Previous Company Name</label>
            <input type="text" class="form-control" name="exp_company_name[]">
        </div>
    </div>

    <div class="add2-inp-div">
        <div class="form-group">
            <label>Job Title</label>
            <input type="text" class="form-control" name="exp_job_title[]">
        </div>
    </div>
    
    <div class="add2-inp-div">
        <div class="form-group">
            <label>From Date</label>
            <input type="date" class="form-control" name="exp_from_date[]">
        </div>
    </div>
    <div class="add2-inp-div">
        <div class="form-group">
            <label>To Date</label>
            <input type="date" class="form-control" name="exp_to_date[]">
        </div>
    </div>
    <div class="add2-inp-div">
        <div class="form-group">
            <label>Job Description</label>
            <input type="text" class="form-control" name="exp_job_desc[]">
        </div>
    </div>

    <div class="add-btn-div">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>
<!-- copy of experience input fields group -->

<!-- copy of education input fields group -->
<div class="education_fieldmoreCopy row"  style="display: none;">
    <div class="add1-inp-div">
        <div class="form-group">
            <label>School Name</label>
            <input type="text" class="form-control" name="edu_school_name[]">
        </div>
    </div>

    <div class="add1-inp-div">
        <div class="form-group">
            <label>Degree/Diploma</label>
            <input type="text" class="form-control" name="edu_degree[]">
        </div>
    </div>



    <div class="add1-inp-div">
        <div class="form-group">
            <label>Field(s) of Study</label>
            <input type="text" class="form-control" name="edu_branch[]">
        </div>
    </div>

    <div class="add1-inp-div">
        <div class="form-group">
            <label>Date of Completion</label>
            <input type="date" class="form-control" name="edu_completion_date[]">
        </div>
    </div>
        
    <div class="add1-inp-div">
        <div class="form-group">
            <label>Additional Notes</label>
            <input type="text" class="form-control" name="edu_add_note[]">
        </div>
    </div>
    <div class="add1-inp-div">
        <div class="form-group">
            <label>Interests</label>
            <input type="text" class="form-control" name="edu_interest[]">
        </div>
    </div>

    <div class="add-btn-div">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>
<!-- copy of education input fields group -->


<!-- copy of input fields group -->
<div class="fieldmoreCopy row" style="display: none;">

    <div class="addfamily-inp-div">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="staff_relation_name[]">
        </div>
    </div>

    <div class="addfamily-inp-div">
        <div class="form-group">
            <label>Relationship</label>
            <input type="text" class="form-control" name="staff_relation[]">
        </div>
    </div>

    <div class="addfamily-inp-div">
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" class="form-control" name="staff_relation_dob[]">
        </div>
    </div>

    <div class="addfamily-inp-div">
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" class="form-control" name="staff_relation_mobile[]">
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
    $(document).ready(function () { 
        $("#anual_ctc_value").on('change',function(){
            update_salary_calculations();
        })
        $("#basic_ctc_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#hra_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#special_allowance_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#pf_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#esi_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#advance_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#pt_percentage").on('change',function(){
            update_salary_calculations();
        })
         
    });
    function update_salary_calculations(){
        var anual_ctc = $("#anual_ctc_value").val();
        var basic_percentage = $('#basic_ctc_percentage').val(); 
        var hra_percentage = $('#hra_percentage').val();
        var special_allowance_percentage = $('#special_allowance_percentage').val();

        var pf_percentage = $('#pf_percentage').val();
        var esi_percentage = $('#esi_percentage').val();
        var advance_percentage = $('#advance_percentage').val();
        var pt_percentage = $('#pt_percentage').val();

        var basic_anual_pay = (anual_ctc * basic_percentage)/(100);
        var basic_monthly_pay = (basic_anual_pay)/(12);

        var hra_anual_pay = (anual_ctc * hra_percentage)/(100);
        var hra_monthly_pay = (hra_anual_pay)/(12);

        var special_allowance_anualy = (anual_ctc * special_allowance_percentage)/(100);
        var special_allowance_monthly = (special_allowance_anualy)/(12);


        var pf_anualy = (anual_ctc * pf_percentage)/(100);
        var pf_monthly = (pf_anualy)/(12);

        var esi_anualy = (anual_ctc * esi_percentage)/(100);
        var esi_monthly = (esi_anualy)/(12);

        var advance_anualy = (anual_ctc * advance_percentage)/(100);
        var advance_monthly = (advance_anualy)/(12);

        var pt_anual_pay = (anual_ctc * pt_percentage)/(100);
        var pt_monthly_pay = (pt_anual_pay)/(12);


        $('#pt_monthly').val((pt_monthly_pay).toFixed(2)); 
        $('#pt_anualy').text((pt_anual_pay).toFixed(2));

        $('#pf_monthly').val((pf_monthly).toFixed(2)); 
        $('#pf_anualy').text((pf_anualy).toFixed(2));

        $('#esi_monthly').val((esi_monthly).toFixed(2)); 
        $('#esi_anualy').text((esi_anualy).toFixed(2));

        $('#advance_monthly').val((advance_monthly).toFixed(2)); 
        $('#advance_anualy').text((advance_anualy).toFixed(2));


        $('#monthly_basic_pay').val((basic_monthly_pay).toFixed(2)); 
        $('#anual_basic_pay').text((basic_anual_pay).toFixed(2)); 
      
        $('#hra_monthly').val((hra_monthly_pay).toFixed(2)); 
        $('#hra_anualy').text((hra_anual_pay).toFixed(2)); 

        $('#special_allowance_monthly').val((special_allowance_monthly).toFixed(2)); 
        $('#special_allowance_anualy').text((special_allowance_anualy).toFixed(2)); 

        var monthly_cost_company = (basic_monthly_pay + hra_monthly_pay + special_allowance_monthly) - (pf_monthly + esi_monthly + advance_monthly + pt_monthly_pay);
        var anual_cost_company = (basic_anual_pay + hra_anual_pay + special_allowance_anualy) - (pf_anualy + esi_anualy + advance_anualy + pt_anual_pay);
        $('#monthly_cost_company').text((monthly_cost_company).toFixed(2)); 
        $('#anual_cost_company').text((anual_cost_company).toFixed(2));
    }
    


//$(document).ready(function () {  
   var inclusion_count = 0;
   function add_more_inclusions(){
         var resultHtml = "";                  
     
        var tag = $('#tag').val();

         resultHtml+='<div class="bullet inclusion-box-'+inclusion_count+'">';
         resultHtml+= tag+' <i onclick="remove_inclusion('+inclusion_count+')" style="cursor: pointer;font-size: 17px;margin-left: 5px;" class="uil-times"></i>';
         resultHtml+='<input type="hidden" name="tags[]" value="'+tag+'" >';
         resultHtml+='</div>';
        $('#more_inclusions').append(resultHtml);
        inclusion_count++;
        $('#tag').val("");
    }


    function remove_inclusion(sl){
        $('.inclusion-box-'+sl).remove();
    }


   function remove_inclusions(sl){
        $('.inclusion-boxs-'+sl).remove();
    }

//}); 
$('#dob').change(function () {
    var dob=$('#dob').val();
    //var Today = new Date();
    if(dob == ''){
        alert('Please select date of birth.');
    }else{
        dobDate = new Date(dob);
        nowDate = new Date();
        
        var diff = nowDate.getTime() - dobDate.getTime();
        
        var ageDate = new Date(diff); // miliseconds from epoch
        var age = Math.abs(ageDate.getUTCFullYear() - 1970);
        
        //$('.msg').text(age+ ' Years');
    }
    $('#age').val(age);
});

    function payment_type_manage(check){
        if(check == 1){
            $('#manual_diposit_option').val(1);
            $('#cheque_diposit_option').val(0);
            $('#bank_payment').show();
            $(".manual_color").css("color", "blue");
            $(".check_color").css("color", "black");
        }else if(check == 2){
            $('#manual_diposit_option').val(0);
            $('#cheque_diposit_option').val(1);
            $('#bank_payment').hide();
            $(".manual_color").css("color", "black");
            $(".check_color").css("color", "blue");
        }
    }
    $(document).ready(function () {  
        // $('#direct_ac_no').bind("cut copy paste",function(e) {
        //     e.preventDefault();
        // });
        // $('#direct_confirm_ac_no').bind("cut copy paste",function(e) {
        //     e.preventDefault();
        // });
        $('#manual_ac_no').bind("cut copy paste",function(e) {
            e.preventDefault();
        });
        $('#manual_confirm_ac_no').bind("cut copy paste",function(e) {
            e.preventDefault();
        });
        //employee_provident_fund
        if($("#employee_provident_fund").prop('checked')){
            $('#employee_provident_fund_fields').show();
        }else{
            $('#employee_provident_fund_fields').hide();
        }
        $("#employee_provident_fund").click(function(){
            if($("#employee_provident_fund").prop('checked')){
                $('#employee_provident_fund_fields').show();
            }else{
                $('#employee_provident_fund_fields').hide();
            }
        });

    $('#rootwizard').bootstrapWizard({
        tabClass: 'nav nav-pills',
        'onNext': function(tab, navigation, index) {
            alert('next');
        }
    });
    $(".next").click(function() {
             
    });
    $('#Personal_details').submit(function (e) {
            e.preventDefault();

            var name = $('#name').val();
            var password = $('#password').val();
            var confirm_password = $('#confirm_password').val();
            
            //var email = $('#email').val();
            //var mobile = $('#mobile').val();
            if (name == '') {//&& email == ''
                // swal('Warning!', 'All fields are ', 'warning');
                $.NotificationApp.send("Warning!","Name field is required.","top-center","red","warning");
                return false;
            }
            if (password != confirm_password) {//&& email == ''
                // swal('Warning!', 'All fields are ', 'warning');
                $.NotificationApp.send("Warning!","Password and confirm password should same.","top-center","red","warning");
                return false;
            }
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var formData=new FormData(this);
            
             my_url = "{{ route('Crm::save_staff') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    if(data.status==true){
                        $('#add_id_work_details').val(data.id);

                        $.NotificationApp.send("Success","Staff has been created successfully!","top-center","green","success");
                        // setTimeout(function(){
                        //     //location.href = "{{ route('Crm::staff') }}";
                        // }, 3500);
                    }else if(data.status==false){
                        $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                    }
                    
                }, error: function (data) {
                    $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                    // setTimeout(function(){
                    //     //location.reload();
                    // }, 3500);
                },
            });
    });
    $('#Work_details').submit(function (e) {
        e.preventDefault();

        // //var name = $('#name').val();
        // var email = $('#email').val();
        // //var mobile = $('#mobile').val();
        // if (email == '') {//&& email == ''
        //     // swal('Warning!', 'All fields are required', 'warning');
        //     $.NotificationApp.send("Warning!","Email field is required.","top-center","red","warning");
        //     return false;
        // }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        var formData=new FormData(this);
        
         my_url = "{{ route('Crm::save_staff') }}";
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.status==true){
                    $('#add_id_family_details').val(data.id);

                    $.NotificationApp.send("Success","Staff has been created successfully!","top-center","green","success");
                    // setTimeout(function(){
                    //     //location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }else if(data.status==false){
                    $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                }
                
            }, error: function (data) {
                $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                // setTimeout(function(){
                //     //location.reload();
                // }, 3500);
            },
        });
    });
    $('#Family_details').submit(function (e) {
        e.preventDefault();

        // //var name = $('#name').val();
        // var email = $('#email').val();
        // //var mobile = $('#mobile').val();
        // if (email == '') {//&& email == ''
        //     // swal('Warning!', 'All fields are required', 'warning');
        //     $.NotificationApp.send("Warning!","Email field is required.","top-center","red","warning");
        //     return false;
        // }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        var formData=new FormData(this);
        
         my_url = "{{ route('Crm::save_staff') }}";
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.status==true){
                    $('#add_id_salary_details').val(data.id);
                    
                    $.NotificationApp.send("Success","Staff has been created successfully!","top-center","green","success");
                    
                }else if(data.status==false){
                    $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                }
                
            }, error: function (data) {
                $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                // setTimeout(function(){
                //     //location.reload();
                // }, 3500);
            },
        });
    });
    $('#Salary_details').submit(function (e) {
        e.preventDefault();
        //var pt = parseInt($('#pt').text());
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        var formData=new FormData(this);
        //formData.append('pt', pt);
         my_url = "{{ route('Crm::save_staff') }}";
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if(data.status==true){
                    $('#add_id_payment_info').val(data.id);

                    $.NotificationApp.send("Success","Staff has been created successfully!","top-center","green","success");
                    // setTimeout(function(){
                    //     //location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }else if(data.status==false){
                    $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                }
                
            }, error: function (data) {
                $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                // setTimeout(function(){
                //     //location.reload();
                // }, 3500);
            },
        });
    });

    $('#Payment_info').submit(function (e) {
        e.preventDefault(); 

        var staff_update_payment_info = $('#staff_update_payment_info').val();
        var add_id_payment_info = $('#add_id_payment_info').val();

        var manual_diposit_option = $('#manual_diposit_option').val();
        var cheque_diposit_option = $('#cheque_diposit_option').val();

        var manual_ac_holder_name = $('#manual_ac_holder_name').val();
        var manual_bank_name = $('#manual_bank_name').val();
        var manual_ac_no = $('#manual_ac_no').val();
        var manual_confirm_ac_no = $('#manual_confirm_ac_no').val();
        var manual_ifsc = $('#manual_ifsc').val();
        var ac_type = $('input[name="ac_type"]:checked').val();
        if(manual_diposit_option == 1 ){
            if(manual_ac_holder_name == "" || manual_bank_name == "" || manual_ac_no == "" || manual_confirm_ac_no == "" || manual_ifsc == ""){
                $.NotificationApp.send("Warning!","All fields are required.","top-center","red","warning");
                return false;
            }
            if(manual_ac_no != manual_confirm_ac_no){
                $.NotificationApp.send("Warning!","Account Number and Re-enter Account Number should be same.","top-center","red","warning");
                return false;
            }         
        }
            
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        var formData=new FormData(this);
        
         my_url = "{{ route('Crm::save_staff') }}";
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: {manual_diposit : manual_diposit_option, cheque_diposit : cheque_diposit_option, ac_holder_name : manual_ac_holder_name, bank_name : manual_bank_name, ac_no : manual_ac_no, ifsc : manual_ifsc, ac_type : ac_type, form_name : staff_update_payment_info, add_id : add_id_payment_info},
            //processData: false,
            //contentType: false,
            success: function (data) {
                if(data.status==true){
                    //$('#add_id_education').val(data.id);

                    $.NotificationApp.send("Success","Staff has been created successfully!","top-center","green","success");
                    setTimeout(function(){
                        location.href = "{{ route('Crm::staff') }}";
                    }, 3500);
                }else if(data.status==false){
                    $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                }
                
            }, error: function (data) {
                $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                // setTimeout(function(){
                //     //location.reload();
                // }, 3500);
            },
        });
    });


    







});    
</script>
<script>

    $(document).ready(function(){
        
    //group add limit
    var maxGroup = 3;


    //add more fields group
    $(".addMoreWork").click(function(){
        if($('body').find('.work_fieldmore').length < maxGroup){
            var fieldHTML = '<div class="work_fieldmore row">'+$(".work_fieldmoreCopy").html()+'</div>';
            $('body').find('.work_fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });

    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".work_fieldmore").remove();
    });

    //add more fields group
    $(".addMoreEducation").click(function(){
        if($('body').find('.education_fieldmore').length < maxGroup){
            var fieldHTML = '<div class="education_fieldmore row">'+$(".education_fieldmoreCopy").html()+'</div>';
            $('body').find('.education_fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });

    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".education_fieldmore").remove();
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
    //add AlternateNumbers
    $(".addAlternate").click(function(){
        if($('body').find('.numbermore').length < maxGroup){
            var fieldHTML = '<div class="col-md-4 numbermore">'+$(".numberCopy").html()+'</div>';
            //$('body').find('.numbermore:last').after(fieldHTML);
            $('#alternetcontainer').append(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' numbers are allowed.');
        }
    });
    
    $('#mobile').on('input',function(e){
        var value=$(this).val();
        if(value.length>=10){
            $('#verify_mobile').show();
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
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldmore").remove();
    });
     //remove address group
     $("body").on("click","#remove_address",function(){ 
        $(this).parents(".addressmore").remove();
    });
    $("body").on("click",".remove_alt",function(){ 
        $(this).parents(".numbermore").remove();
    });

    $('#account_type_id').change(function(){
            //Selected value
            $("#detail_type").val('');
            $("#detail").val('');
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
    $('#work_title').change(function(){
            //Selected value
            $("#detail_type").val('');
            $("#detail").val('');
            var inputValue = $(this).val();
            //Ajax for calling php function
                if ('add' == inputValue){
                $("#detail_type").val(0);
            $("#AddDetails").modal("show");
        }
    });
    $('#hire_source').change(function(){
                //Selected value
        $("#detail_type").val('');
        $("#detail").val('');
        var inputValue = $(this).val();
            //Ajax for calling php function
        if ('add' == inputValue){
            $("#detail_type").val(1);
            $("#AddDetails").modal("show");
        }
    });
    $('#staff_type').change(function(){
                //Selected value
        $("#detail_type").val('');
        $("#detail").val('');
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue){
            $("#detail_type").val(2);
            $("#AddDetails").modal("show");
        }
    });

    $('#department').change(function(){//alert('sfsdfsddf');return;
            //Selected value
        $("#detail_type").val('');
        $("#detail").val('');
        var inputValue = $(this).val();
        //Ajax for calling php function
         if ('add' == inputValue){
            $("#detail_type").val(3);
            $("#AddDetails").modal("show");
          }
    });
    $('#work_status').change(function(){
                //Selected value
        $("#detail_type").val('');
        $("#detail").val('');
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue){
            $("#detail_type").val(4);
            $("#AddDetails").modal("show");
        }
    });
    $('#location').change(function(){
                //Selected value
        $("#detail_type").val('');
        $("#detail").val('');        
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue){
            $("#detail_type").val(5);
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
            $.NotificationApp.send("Error","Please enter value","top-center","red","error");
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
        if($('#detail_type').val()== 0){
            my_url=APP_URL + '/manage/designationAdd';
            formData.append('designation',detail);
        }
        else if($('#detail_type').val()== 1){
            my_url=APP_URL + '/manage/hireOfSource';
            formData.append('source_hire',detail);
        }
        else if($('#detail_type').val()== 2){
            my_url=APP_URL + '/manage/staffTypeAdd';
            formData.append('staff_type',detail);
        }
        else if($('#detail_type').val()==3){
            my_url=APP_URL + '/manage/departmentData';
            formData.append('department',detail);
        }else if($('#detail_type').val()== 4){
            my_url=APP_URL + '/manage/workStatusAdd';
            formData.append('work_status',detail);
        }
        else if($('#detail_type').val()== 5){
            my_url=APP_URL + '/manage/workLocationAdd';
            formData.append('work_location',detail);
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
                    if(data.status==true){
                        if($('#detail_type').val()==0){
                            $('#work_title').val(null).trigger('change');
                            $("#work_title option:last").before("<option value="+addText+">"+addText+"</option>");
                        }else if($('#detail_type').val()==1){
                            $('#hire_source').val(null).trigger('change');
                            $("#hire_source option:last").before("<option value="+addText+">"+addText+"</option>");
                        }else if($('#detail_type').val()==2){
                            $('#staff_type').val(null).trigger('change');
                            $("#staff_type option:last").before("<option value="+addText+">"+addText+"</option>");
                        }else if($('#detail_type').val()==3){
                            $('#department').val(null).trigger('change');
                            $("#department option:last").before("<option value="+addText+">"+addText+"</option>");
                        }else if($('#detail_type').val()==4){
                            $('#work_status').val(null).trigger('change');
                            $("#work_status option:last").before("<option value="+addText+">"+addText+"</option>");
                        }else if($('#detail_type').val()==5){
                            $('#location').val(null).trigger('change');
                            $("#location option:last").before("<option value="+addText+">"+addText+"</option>");
                        }  
                    }


                   // if($('#detail_type').val()==0){
                   //  $('#account_type_id').val(null).trigger('change');
                   //  $("#account_type_id option:last").before("<option value="+addText+">"+addText+"</option>");
                   //  }else if($('#detail_type').val()==3){
                   //      $('#department').val(null).trigger('change');
                   //      $("#department option:last").before("<option value="+addText+">"+addText+"</option>");
                   //  }else if($('#detail_type').val()==1){
                   //      $('#member_type_id').val(null).trigger('change');
                   //      $("#member_type_id option:last").before("<option value="+addText+">"+addText+"</option>");
                   //  }else if($('#detail_type').val()==2){
                   //      $('#source_id').val(null).trigger('change');
                   //      $("#source_id option:last").before("<option value="+addText+">"+addText+"</option>");
                   //  } 
                }
            },
            error: function (data) {
                $.NotificationApp.send("Error",data,"top-center","red","error");
            }
        });
    });
    
    
});
</script>
@endsection