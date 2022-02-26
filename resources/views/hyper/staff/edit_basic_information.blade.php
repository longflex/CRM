@extends('hyper.layout.master')
@section('title', "Staff Edit")
@section('content')
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::staff') }}"><i class="uil-home-alt"></i> staff</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ old('name', isset($user) ? $user->name : '') }}</h4>
            </div>
        </div>
    </div>
   
    <!-- end page title --> 
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3>Basic information</h3><hr>
                    <form class="form-horizontal staff_update" id="Personal_details" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Name <span class="red-txt">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', isset($user) ? $user->name : '') }}">
                                    <input type="hidden" name="edit_id" value="{{$id}}">
                                    <input type="hidden" name="form_id" value="1">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Nick Name</label>
                                    <input type="text" class="form-control" id="nick_name" name="nick_name" value="{{ old('nick_name', isset($user_detail) ? $user_detail->nick_name : '') }}">
                        
                                </div>
                            </div>
                            
                            <!-- <div class="col-md-4">
                                <div class="form-group ">
                                    <label>PAN card number</label>
                                    <input type="text" class="form-control" id="pan_no" name="pan_no"  value="{{ old('pan_no', isset($user_detail) ? $user_detail->pan_no : '') }}">
                                
                                </div>
                            </div> -->
                            <!-- <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Adhar card number</label>
                                    <input type="text" class="form-control" id="adhar_no" name="adhar_no" value="{{ old('adhar_no', isset($user_detail) ? $user_detail->adhar_no : '') }}">
                        
                                </div>
                            </div> -->
                            <!-- <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Tags</label>
                                    <input type="text" class="form-control" id="tags" name="tags" value="{{ old('tags', isset($user_detail) ? $user_detail->tags : '') }}">
                                    
                                </div>
                            </div> -->
                              

                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Gender</label>
                                    <select class="form-control custom-select" id="gender" name="gender">
                                        <option value="Male" {{ old('gender', @$user_detail->gender == 'Male' ? 'selected': '') }}>Male</option>
                                        <option value="Female"  {{ old('gender', @$user_detail->gender == 'Female' ? 'selected': '') }}>Female</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Marital Status</label>
                                    <select class="form-control custom-select" id="married_status" name="married_status">
                                        <option value="Single" {{ old('married_status', @$user_detail->married_status == 'Single' ? 'selected': '') }}>Single</option>
                                        <option value="Married"  {{ old('married_status', @$user_detail->married_status == 'Married' ? 'selected': '') }}>Married</option>   
                                    </select>
                                </div>
                            </div> -->
                            
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date of birth</label>
                                    <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Age</label>
                                    <input type="text" class="form-control" id="age" name="age" value="{{ old('age', isset($user_detail) ? $user_detail->age : '') }}" disabled="disabled">
                                </div>
                            </div> -->
                            <!-- <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Father's Name</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name" value="{{ old('father_name', isset($user_detail) ? $user_detail->father_name : '') }}">
                        
                                </div>
                            </div> -->
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', isset($user) ? $user->address : '') }}">
                                </div>
                            </div> -->
                            <!-- <div class="col-md-8">
                                <label> Tags</label>
                                <div class="input-group">
                                    <input id="e_tag" type="text" class="form-control" placeholder="Add tag description" >
                                    <div class="input-group-append">
                                        <button onclick="e_add_more_inclusions()" class="btn btn-sm btn-primary" type="button"><i class="uil-plus-circle"></i> Tag</button>
                                    </div>
                                </div>
                                <div id="e_more_inclusions" class="row">
                                </div>
                            </div> -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date of Joining</label>
                                    <input type="date" class="form-control" id="joining_date" disabled name="joining_date" value="{{ old('joining_date', isset($user_detail) ? $user_detail->joining_date : '') }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Department</label>
                                    <select class="form-control select2" name="department" id="department" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ (($user->department == $department->id) ? 'selected': '') }}>
                                            {{ $department->department }}
                                        </option>
                                        @endforeach
                                        <option value="add">Add Value</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-email">Work Email</label>
                                    <input type="email" id="work_email" name="work_email" class="form-control" value="{{ old('work_email', isset($user_detail) ? $user_detail->work_email : '') }}" placeholder="Email" data-container="body" title="" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="You cannot change this Email address later on, as this will be used to send payslips and also for employees to sign in to their portal, where they can view/download their payslips." data-original-title="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>Work Location</label>
                                    <select class="form-control select2" name="work_location" id="work_location" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @foreach($work_locations as $work_location)
                                        <option value="{{ $work_location->work_location }}"
                                            {{ (old('location', $user_detail->location) == $work_location->work_location ? 'selected': '') }}>
                                            {{ $work_location->work_location }}
                                        </option>
                                        @endforeach
                                        <option value="add">Add Value</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="numbermore">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Email <span class="red-txt">*</span> </label>
                                        <input type="email" class="form-control" id="email" required name="email"
                                            value="{{ old('email', isset($user) ? $user->email : '') }}" />
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
                                            <input type="text" class="form-control" id="mobile" name="mobile" value="{{old('mobile',$user->mobile)}}" data-old="{{$user->mobile}}">
                                            <input type="number" class="form-control" id="otp" name="otp" value="" placeholder="Enter Otp" style="display: none; margin-top: 10px">
                                            <input type="hidden" id="sender_id" value="{{ auth()->user()->id }}" />
                                    </div>
                                </div>

                                @if ($user->alt_mobile!=null && $user->alt_mobile!=''&& json_decode($user->alt_mobile)!=null)
                                    @foreach(json_decode($user->alt_mobile) as $key=> $number)
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label>Alternate Number</label>
                                                    <input type="text" class="form-control" name="alt_mobile[]" value="{{old('alt_mobile[]',$number)}}" />
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                @if($key==0)
                                                <div class="add-btn-div mb-2">
                                                    <button class="btn btn-sm btn-primary family-add-btn addAlternate" type="button"><i class="uil-plus-circle"></i></button>    
                                                </div>
                                                @else
                                                <div class="add-btn-div mb-2">
                                                    <button class="btn btn-sm btn-danger family-add-btn remove_alt" type="button"><i class="uil-minus-circle"></i></button>    
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @else    
                                    <div class="col-md-4">
                                        <div class="row">
                                            
                                            <div class="col-md-10">
                                                <div class="">
                                                    <div class="form-group">
                                                        <label>Alternate Number</label>
                                                        <input type="text" class="form-control" name="alt_mobile[]" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <center>
                                                    <div class="add-btn-div mb-2 float-left">
                                                        <button class="btn btn-sm btn-primary family-add-btn addAlternate" type="button"><i class="uil-plus-circle"></i></button> 
                                                    </div>
                                                </center>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                @endif
                                
                            </div>
                        </div>
                        <div class="row" id="alternetcontainer"></div>
                        
                        @if(count($educations)>0)
                        @foreach($educations as $key=> $education)
                        <!-- <div class="col-md-12">
                            <div class="education_fieldmore row">
                                <div class="add1-inp-div">
                                    <div class="form-group">
                                        <label>School Name</label>
                                        <input type="text" class="form-control" name="edu_school_name[]" value="{{ old('edu_school_name', isset($education) ? $education->edu_school_name : '') }}">
                                    </div>
                                </div>

                                <div class="add1-inp-div">
                                    <div class="form-group">
                                        <label>Degree/Diploma</label>
                                        <input type="text" class="form-control" name="edu_degree[]" value="{{ old('edu_degree', isset($education) ? $education->edu_degree : '') }}">
                                    </div>
                                </div>



                                <div class="add1-inp-div">
                                    <div class="form-group">
                                        <label>Field(s) of Study</label> 
                                        <input type="text" class="form-control" name="edu_branch[]" value="{{ old('edu_branch', isset($education) ? $education->edu_branch : '') }}">
                                    </div>
                                </div>

                                <div class="add1-inp-div">
                                    <div class="form-group">
                                        <label>Date of Completion</label>
                                        <input type="date" class="form-control" name="edu_completion_date[]" value="{{ old('edu_completion_date', isset($education) ? $education->edu_completion_date : '') }}">
                                    </div>
                                </div>
                                    
                                <div class="add1-inp-div">
                                    <div class="form-group">
                                        <label>Additional Notes</label>
                                        <input type="text" class="form-control" name="edu_add_note[]" value="{{ old('edu_add_note', isset($education) ? $education->edu_add_note : '') }}">
                                    </div>
                                </div>
                                <div class="add1-inp-div">
                                    <div class="form-group">
                                        <label>Interests</label>
                                        <input type="text" class="form-control" name="edu_interest[]" value="{{ old('edu_interest', isset($education) ? $education->edu_interest : '') }}">
                                    </div>
                                </div>

                                @if($key==0)
                                <div class="add-btn-div">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMoreEducation"
                                        onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-plus-circle"></i></a>
                                </div>
                                @else
                                <div class="add-btn-div">
                                    <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
                                        onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
                                </div>
                                @endif
                            </div>
                        </div> -->

                        @endforeach
                        @else
                        <!-- <div class="education_fieldmore row">
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
                        </div> -->
                        @endif
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="checkbox" id="staff_share" name="staff_share" value="1" {{ old('staff_share', @$user_detail->staff_share == 1 ? 'checked': '') }}>
                                    <label for="staff_share"> Employee is a Director/person with substantial interest in the company.<a href="javascript:void(0);" title="'substantial interest in the company' means that employee is banificial owner of shares and carries at least 20% of voting power.This detail will help us fill out Form 12BA for this employee"><i class="uil-info-circle font-20"></i></a></label>
                                </div>
                            </div>
                            
                            
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="checkbox" id="portal_access" name="portal_access" value="1"{{ old('portal_access', @$user_detail->portal_access == 1 ? 'checked': '') }}>
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
                                    <input type="checkbox" id="employee_provident_fund" name="provident_fund" value="1" {{ old('provident_fund', isset($user_detail) && (@$user_detail->provident_fund == 1)? 'checked' : '') }}>
                                    <label for="employee_provident_fund"> Employees' Provident Fund</label><br>
                                </div>
                                <!-- <div class="custom-control">
                                    <input type="checkbox" class="form-control" id="employee_provident_fund" name="employee_provident_fund" checked>
                                    <label class="custom-control-label">Employees' Provident Fund</label><br>
                                </div> -->
                                <div class="row" id="employee_provident_fund_fields" style="<?php if($user_detail->provident_fund != 1){echo "display: none;";}?>"> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>PF Account Number </label>
                                            <input type="text" class="form-control" id="pf_ac_no" name="pf_ac_no" value="{{ old('pf_ac_no', isset($user_detail) ? $user_detail->pf_ac_no : '') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label>UAN</label>
                                            <input type="text" class="form-control" id="uan" name="uan" value="{{ old('uan', isset($user_detail) ? $user_detail->uan : '') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="checkbox" id="pension_scheme" name="pension_scheme" value="1" {{ old('pension_scheme', @$user_detail->pension_scheme == 1 ? 'checked': '') }}>
                                            <label for="pension_scheme"> Contribute to Employee Pension Scheme<a href="javascript:void(0);" title="Employees enrolled as EPF members on or before September 1, 2014, and employees enrolled after September 1, 2014 receiving less than ₹15,000 will have to contribute to the Employee Pension Scheme mandatorily. Employees receiving more than ₹15,000 need not contribute to EPS and their entire PF contribution will go into their Provident Fund account."><i class="uil-info-circle font-20"></i></a></label><br>
                                        </div>

                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="checkbox" id="professional_tax" name="professional_tax" value="1" {{ old('professional_tax', @$user_detail->professional_tax == 1 ? 'checked': '') }}>
                                    <label for="professional_tax"> Professional Tax</label><br>
                                </div>
                                <!-- <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="customCheck3" name="professional_tax" checked>
                                    <label class="custom-control-label" for="customCheck3">Professional Tax </label><br>
                                </div> -->
                            </div>
                        </div>
                        <ul class="list-inline wizard mb-0">
                            <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Submit</a></li>
                        </ul>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
            <input type="text" class="form-control" name="exp_company_name[]"/>
        </div>
    </div>

    <div class="add2-inp-div">
        <div class="form-group">
            <label>Job Title</label>
            <input type="text" class="form-control" name="exp_job_title[]"/>
        </div>
    </div>
    
    <div class="add2-inp-div">
        <div class="form-group">
            <label>From Date</label>
            <input type="date" class="form-control" name="exp_from_date[]"/>
        </div>
    </div>
    <div class="add2-inp-div">
        <div class="form-group">
            <label>To Date</label>
            <input type="date" class="form-control" name="exp_to_date[]"/>
        </div>
    </div>
    <div class="add2-inp-div">
        <div class="form-group">
            <label>Job Description</label>
            <input type="text" class="form-control" name="exp_job_desc[]"/>
        </div>
    </div>

    <div class="add-btn-div  mb-2">
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

    <div class="add-btn-div  mb-2">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>
<!-- copy of education input fields group -->


<!-- copy of input fields group -->
<div class="fieldmoreCopy row" style="display: none;">

    <div class="add-inp-div col-3">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="staff_relation_name[]">
        </div>
    </div>

    <div class="add-inp-div col-3">
        <div class="form-group">
            <label>Relationship</label>
            <input type="text" class="form-control" name="staff_relation[]">
        </div>
    </div>

    <div class="add-inp-div col-3">
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" class="form-control" name="staff_relation_dob[]">
        </div>
    </div>

    <div class="add-inp-div col-2">
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" class="form-control" name="staff_relation_mobile[]">
        </div>
    </div>

    <div class="add-btn-div  mb-2 col-1">
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
    $(document).ready(function () {
        set_inclusions();
    });
    var e_inclusion_count = 0;
    function set_inclusions(){
        var id='{{$id}}';//alert(id);return;
        var type = "post";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        my_url = "{{ route('Crm::get_tags_data') }}";
        $.ajax({
            type: type,
            url: my_url,
            data: {id:id},
            //processData: false,
            //contentType: false,
            dataType: 'json',
            success: function (data) {
                //alert();
                $.each(JSON.parse(data.detail),function(key,value){
                  var resultHtml = "";                  

                     resultHtml+='<div class="bullet inclusion-box-'+e_inclusion_count+'">';
                     resultHtml+= value+' <i onclick="e_remove_inclusion('+e_inclusion_count+')" style="cursor: pointer;font-size: 17px;margin-left: 5px;" class="uil-times"></i>';
                     resultHtml+='<input type="hidden" name="tags[]" value="'+value+'" >';
                     resultHtml+='</div>';
                    $('#e_more_inclusions').append(resultHtml);
                    e_inclusion_count++;
                })
            }, error: function (data) {
                // $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                // setTimeout(function(){
                //     //location.reload();
                // }, 3500);
            },
        });
    }

    function e_add_more_inclusions(){
        var resultHtml = "";                  
        var tag = $('#e_tag').val();
        resultHtml+='<div class="bullet inclusion-box-'+e_inclusion_count+'">';
        resultHtml+= tag+' <i onclick="e_remove_inclusion('+e_inclusion_count+')" style="cursor: pointer;font-size: 17px;margin-left: 5px;" class="uil-times"></i>';
        resultHtml+='<input type="hidden" name="tags[]" value="'+tag+'" >';
        resultHtml+='</div>';
        $('#e_more_inclusions').append(resultHtml);
        e_inclusion_count++;
        $('#e_tag').val("");
    }
    function e_remove_inclusion(sl){
        $('.inclusion-box-'+sl).remove();
    }

   function remove_inclusions(sl){
        $('.inclusion-boxs-'+sl).remove();
    }
    $(document).ready(function () {
        $('.staff_update').submit(function (e) {
            e.preventDefault();
            $( ".btn" ).prop( "disabled", true );
            var name = $('#name').val();
            var email = $('#email').val();

            if (name == '' && email == '') {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("Error","Name and email fields are required.","top-center","red","error");
                return false;
            }

            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var formData=new FormData(this);
            
            my_url = "{{ route('Crm::Update_basic_information') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                //dataType: 'json',
                success: function (data) {
                    $( ".btn" ).prop( "disabled", false );
                    $.NotificationApp.send("Success","Staff has been updated successfully!","top-center","green","success");
                    // setTimeout(function(){
                    //     location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }, error: function (data) {
                    $( ".btn" ).prop( "disabled", false );
                    $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        });
    });
    $(document).ready(function(){
        //group add limit
        var maxGroup = 3;

        //add more fields group
        $(".addMoreWork").click(function(){
            if($('body').find('.work_fieldmore').length < maxGroup){
                var fieldHTML = '<div class="work_fieldmore row">'+$(".work_fieldmoreCopy").html()+'</div>';
                $('body').find('.work_fieldmore:last').after(fieldHTML);
            }else{
                Swal.fire(
                    'Maximum',
                    maxGroup +' groups are allowed.',
                    'error'
                    );
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
                Swal.fire(
                    'Maximum',
                    maxGroup +' groups are allowed.',
                    'error'
                    );
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
                Swal.fire(
                    'Maximum',
                    maxGroup +' groups are allowed.',
                    'error'
                    );
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
        // $(".addAlternate").click(function(){
        //     if($('body').find('.numbermore').length < maxGroup){
        //         var fieldHTML = '<div class="numbermore">'+$(".numberCopy").html()+'</div>';
        //         $('body').find('.numbermore:last').after(fieldHTML);
        //         //$('#alternetcontainer').append(fieldHTML);
        //     }else{
        //         Swal.fire(
        //             'Maximum',
        //             'error'
        //             );
        //     }
        // });
        

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
            if(value.length>=10 && value!=$(this).attr('data-old')){
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
        $('#department').change(function(){
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
        $('#work_location').change(function(){
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
        }
        else if($('#detail_type').val()== 4){
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
                        $('#work_location').val(null).trigger('change');
                        $("#work_location option:last").before("<option value="+addText+">"+addText+"</option>");
                    }  
                }
            },
            error: function (data) {
                swal('Error!', data, 'error')
            }
        });
    });


});
</script>
@endsection