@extends('hyper.layout.master')
@section('title', "$user->name")
@section('content')
 

<style>
.switch {
  position: relative;
  display: inline-block;
  width: 41px;
  height: 20px;
}

.switch input {display:none;}


.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cccccc;
  -webkit-transition: .4s;
  transition: .4s;
   border-radius: 50px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 15px;
  width: 12px;
  left: 0px;
  bottom: 2px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;

}

input:checked + .slider {
  background-color: #398bf7;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(40px);
  -ms-transform: translateX(40px);
  -moz-transform: translateX(40px);
  transform: translateX(28px);
}

/*------ ADDED CSS ---------*/
.slider:after
{
 content:'';
 color: white;
 display: block;
 position: absolute;
 transform: translate(-50%,-50%);
 top: 50%;
 left: 50%;
 font-size: 10px;
 font-family: Verdana, sans-serif;
}

input:checked + .slider:after
{  
  content:'';
}
</style>

<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::staff') }}"><i class="uil-home-alt"></i> staff</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ !empty($user->name) ? $user->name." 's" : '' }}  Details</h4>
            </div>
        </div>
    </div> 
    <!-- end page title -->
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row" id="user_id" data-id="{{ $user->id }}">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs nav- bordered mb-3">
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <li class="nav-item">
                                    <a href="#Overview" id="Overview-tab" class="nav-link active" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Overview</span></a>
                                </li>
                                @endif
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <li class="nav-item">
                                    <a href="#Salary" id="Salary-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Salary Details</span></a>
                                </li>
                                @endif
                                @if(Laralum::hasPermission('laralum.donation.view'))
                                <li class="nav-item">
                                    <a href="#Payslips" id="Payslips-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Payslips</span></a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content">    
                                <div class="tab-pane tab_status active" id="Overview">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="col-lg-12 col-xl-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="sidebar -area">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <p>Basic Information</p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <a class="btn btn-sm btn-light float-right" href="{{ route('Crm::edit_basic_information', ['id' => $user->id]) }}"><i class="mdi mdi-pencil"></i></a>
                                                                </div>
                                                            </div>

                                                            <h4 class="text-center mt-3">{{ $user->name ?? '' }}</h4>

                                                            <table class="table">

                                                                @if(!empty($user->email))
                                                                <tr class="email">
                                                                    <td><i class="mdi mdi-email"></i></td>
                                                                    <td>{{ $user->email ?? '' }}</td>
                                                                    <td style="display: none"><input type="text" data-type="email" class="form-control" value="{{ $user->email ?? ''}}" name="data"></td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                                                </tr>
                                                                @endif
                                                                <!-- <tr class="mobile_phone">
                                                                    <td><i class="uil-phone"></i></td>
                                                                    <td>{{ $user->mobile ?? '' }}</td>
                                                                    <td style="display: none"><input type="text" data-type="mobile" class="form-control" value="{{ $user->mobile ?? '' }}" name="data">
                                                                    </td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                                                </tr> -->
                                                                @if(!empty($user_detail->gender))
                                                                <tr class="gender">
                                                                    <td>{!! $user_detail->gender == 'Male' ? '<i class="mdi mdi-human-male"></i>' : '<i class="mdi mdi-human-female"></i>' !!}</td>
                                                                    <td>{{ !empty($user_detail->gender) ? $user_detail->gender : '' }}</td>
                                                                    <td style="display: none">
                                                                        <select class="form-control custom-select" id="gender" name="gender" data-type="gender">
                                                                            <option value="Male" {{ (old('gender',$user_detail->gender) == "Male" ? 'selected': '') }}>Male</option>
                                                                            <option value="Female" {{ (old('gender',$user_detail->gender) == "Female" ? 'selected': '') }}>Female</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                                                </tr>
                                                                @endif
 
                                                                @if(!empty($user_detail->joining_date) and $user_detail->joining_date!='0000-00-00')
                                                                <tr class="doj">
                                                                    <td><i class="mdi mdi-calendar-heart"></i></td>
                                                                    <td>{{ date("jS F, Y", strtotime($user_detail->joining_date)) }} (Date of Joining)</td>
                                                                    <td style="display: none"><input type="date" data-type="date_of_joining" value="{{ $user_detail->joining_date ?? '' }}" name="data"></td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                                                </tr>
                                                                @endif
                                                                @if(!empty($user->department_name))
                                                                <tr class="married_status">
                                                                    <td><i class="uil-briefcase"></i></td>
                                                                    <td><span>{{ $user->department_name ?? '' }}</span></td>
                                                                    
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                                                </tr>
                                                                @endif
                                                                @if(!empty($user_detail->location))
                                                                <tr class="married_status">
                                                                    <td><i class="uil-location-point"></i></td>
                                                                    <td><span>{{ $user_detail->location ?? '' }}</span></td>
                                                                    
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                                                </tr>
                                                                @endif

                                                            </table>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <h5>Employees' Provident Fund</h5>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="switch">
                                                                        <input type="checkbox"  id="provident_fund" tabindex="0" {{isset($user_detail) && ($user_detail->provident_fund ==1) ? 'checked' : ''}}  name="provident_fund" >
                                                                        <div class="slider"></div>
                                                                    </label>
                                                                </div>
                                                                @if(isset($user_detail) && ($user_detail->provident_fund ==1))
                                                                <div class="col-md-12">
                                                                    <p>(EPS contribution is enabled)</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>PF Account Number</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>{{isset($user_detail) ? $user_detail->pf_ac_no : ''}}</strong></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>UAN</p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><strong>{{isset($user_detail) ? $user_detail->uan : ''}}</strong></p>
                                                                </div> 
                                                                @endif
                                                                <div class="col-md-9">
                                                                    <p><strong>Professional Tax</strong></p>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="switch">
                                                                        <input type="checkbox" id="professional_tax" tabindex="0" {{isset($user_detail) && ($user_detail->professional_tax ==1) ? 'checked' : ''}}  name="professional_tax" >
                                                                        <div class="slider"></div>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <p>Portal Access</p>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="switch">
                                                                        <input type="checkbox" id="portal_access" tabindex="0" {{isset($user_detail) && ($user_detail->portal_access ==1) ? 'checked' : ''}}  name="portal_access" >
                                                                        <div class="slider"></div>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <hr>



                                                        </div>
                                                    </div>
                                                </div>      
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="col-lg-12 col-xl-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <p>Personal Information</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a class="btn btn-sm btn-light float-right" href="{{ route('Crm::edit_persional_information', ['id' => $user->id]) }}"><i class="mdi mdi-pencil"></i></a>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Date of Birth</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->dob !='') ? $user_detail->dob : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Father's Name</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->father_name !='') ? $user_detail->father_name : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4"> 
                                                                <p>Pan No</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->pan_no !='') ? $user_detail->pan_no : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Work Email</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->work_email !='') ? $user_detail->work_email : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Mobile Number</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user) && ($user->mobile !='') ? $user->mobile : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Residential Address</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user) && ($user->address !='')? $user->address : 'Not Available'}}</p>
                                                            </div>


                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="col-lg-12 col-xl-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <p>Payment Information</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a class="btn btn-sm btn-light float-right" href="{{ route('Crm::edit_payment_information', ['id' => $user->id]) }}"><i class="mdi mdi-pencil"></i></a>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Payment Mode</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>Account Number</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>{{isset($user_detail) && ($user_detail->manual_diposit ==1) ? 'Manual Bank Transfer' : 'Check'}}</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->ac_no !='') ? $user_detail->ac_no : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Account Holder Name</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->ac_holder_name !='') ? $user_detail->ac_holder_name : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Bank Name</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->bank_name !='') ? $user_detail->bank_name : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>IFSC</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->ifsc !='')? $user_detail->ifsc : 'Not Available'}}</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <p>Account Type</p>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <p>{{isset($user_detail) && ($user_detail->ac_type !='')? $user_detail->ac_type : 'Not Available'}}</p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane tab_status" id="Salary">
                                    <?php
                                        if(isset($user_detail)){
                                           $monthly_comp_cost = (($user_detail->anual_ctc)*($user_detail->basic_perc)/(1200)) + (($user_detail->anual_ctc)*($user_detail->hra_perc)/(1200)) + (($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(1200)) - ((($user_detail->anual_ctc)*($user_detail->advance_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->pf_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->esi_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->pt_percentage)/(1200)) );
                                           
                                           $anual_comp_cost = (($user_detail->anual_ctc)*($user_detail->basic_perc)/(100)) + (($user_detail->anual_ctc)*($user_detail->hra_perc)/(100)) + (($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(100)) - ( (($user_detail->anual_ctc)*($user_detail->pf_percentage)/(100)) + (($user_detail->anual_ctc)*($user_detail->esi_percentage)/(100)) + (($user_detail->anual_ctc)*($user_detail->advance_percentage)/(100)) +  (($user_detail->anual_ctc)*($user_detail->pt_percentage)/(100)) );

                                        }else{
                                            $monthly_comp_cost = 0;
                                            $anual_comp_cost = 0;
                                        }       
                                    ?> 
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h3>Salary Details</h3>
                                                </div> 
                                                <div class="col-md-2">
                                                    <!-- <a class="btn btn-sm btn-light" href="{{ route('Crm::edit_salary_information', ['id' => $user->id]) }}"><i class="mdi mdi-pencil"></i></a> -->
                                                </div>  
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <p>Annual CTC</p>
                                                </div> 
                                                <div class="col-md-4" align="right">
                                                    <p>Monthly Income</p>
                                                </div> 
                                                <div class="col-md-4" align="right">
                                                    <!-- <a class="btn btn-sm btn-light" href="{{ route('Crm::edit_basic_information', ['id' => $user->id]) }}">Revise</a> -->
                                                    <a class="btn btn-sm btn-light float-right" href="{{ route('Crm::salary_preview', ['id' => $user->id]) }}"><i class="uil-print"></i></a>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <strong>₹ {{  ( (isset($user_detail) && !empty($user_detail->anual_ctc) ) ? $user_detail->anual_ctc : 0) }}</strong>
                                                </div> 
                                                <div class="col-md-4" align="right">
                                                    <strong>{{round($monthly_comp_cost, 2)}}</strong> 
                                                </div> 
                                                <div class="col-md-4">
                                                </div> 
                                            </div>
                                        </div><br><br>
                                        <div class="col-md-9">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <p>Salary Components</p>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <p>Amount Monthly</p>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <p>Amount Annually</p>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <strong>Earnings</strong>
                                                        </div><br>

                                                        <div class="col-md-4">
                                                            <strong>Basic</strong>
                                                            <p>({{ ((isset($user_detail) && !empty($user_detail->basic_perc) ) ? $user_detail->basic_perc : 0) }}  % of CTC) </p>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong> <p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->basic_perc)/(1200) : 0) }}</p></strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->basic_perc)/(100) : 0) }}</p></strong>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <strong>House Rent Allowance</strong>
                                                            <p>({{ ((isset($user_detail) && !empty($user_detail->hra_perc) ) ? $user_detail->hra_perc : 0) }}  % of CTC) </p>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->hra_perc)/(1200) : 0) }}</p></strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->hra_perc)/(100) : 0) }}</p></strong>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <strong>Special Allowance</strong>
                                                            <p>({{ ((isset($user_detail) && !empty($user_detail->special_allowance_per) ) ? ($user_detail->special_allowance_per) : 0) }}  % of CTC) </p>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(1200) : 0) }}</p></strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p> ₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(100) : 0) }}</p></strong>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <strong>Deductions</strong>
                                                        </div><br>

                                                        <div class="col-md-4">
                                                            <strong>EPF - Employer Contribution</strong>
                                                            <p>({{ ((isset($user_detail) && !empty($user_detail->pf_percentage) ) ? ($user_detail->pf_percentage) : 0) }}  % of CTC) </p>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p> ₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pf_percentage)/(1200) : 0) }}</p></strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p> ₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pf_percentage)/(100) : 0) }}</p></strong>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <strong>ESI - Employer Contribution</strong>
                                                            <p>({{ ((isset($user_detail) && !empty($user_detail->esi_percentage) ) ? ($user_detail->esi_percentage) : 0) }}  % of CTC) </p>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->esi_percentage)/(1200) : 0) }}</p></strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->esi_percentage)/(100) : 0) }}</p></strong>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <strong>PT</strong>
                                                            <p>({{ ((isset($user_detail) && !empty($user_detail->pt_percentage) ) ? ($user_detail->pt_percentage) : 0) }}  % of CTC) </p>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pt_percentage)/(1200) : 0) }}</p></strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pt_percentage)/(100) : 0) }}</p></strong>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <strong>Advance</strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ 0</p></strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong> <p>₹ 0</p></strong>
                                                        </div>

                                                    </div><hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h4>Cost to Company</h4>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong><p>₹ {{$monthly_comp_cost}}</p></strong>
                                                        </div>
                                                        <div class="col-md-4" align="right">
                                                            <strong> <p>₹ {{$anual_comp_cost}}</p></strong>
                                                        </div>
                                                    </div>  
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane tab_status" id="Payslips">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong><h3>Payslips</h3></strong>
                                            <!-- @if(isset($user_detail) && $user_detail->anual_ctc != 0 && $user_detail->anual_ctc != "")
                                            <button class="btn btn-primary" onclick="genratePaylip({{ $user->id}})">Generate Payslip</button>
                                            @else
                                            <p>Summit the salary detail first</p>
                                            @endif -->
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="card">
                                            <div class="card-body">
                                                       
                                                <table class="table table-bordered border-none">
                                                    <tbody>
                                                        <tr>
                                                            <td>Payment Date</td>
                                                            <td>Month</td>
                                                            <td>Payslips</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        
                                                            @foreach($payslips as $payslip)
                                                            <tr style="font-weight:bold">
                                                                <td width="40%" align="left">{{ date("d/m/Y", strtotime($payslip->payment_date)) }}</td>
                                                                <td width="30%">{{ date("F, Y", strtotime($payslip->payment_date)) }}</td>
                                                                <td width="30%" align="left"><a class="btn btn-sm btn-light" href="{{ route('Crm::payslip_preview', ['id' => $payslip->id]) }}">View</a></td>
                                                            </tr>
                                                            @endforeach
                                                  
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page content -->
</div>


<div id="generatePayslip" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-sm btn-light float-right Close" data-dismiss="modal" aria-hidden="true">X</button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="generatePayslipForm" action="javascript:void(0)">
                    <input type="hidden" name="id" value="{{$user->id}}">
                    <div class="form-group">
                        <label>Payment Date</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date">
                    </div>
                    <ul class="list-inline wizard mb-0">
                        <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Submit</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="provident_fund_enable" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title" id="topModalLabel">Update Provident Fund</h4>
                <button type="button" class="close provident_fund_disable_cancel"  aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="update_provident_fund" action="javascript:void(0)">
                <input type="hidden" name="provident_fund" id="provident_fund_check" class="form-control" />
                <input type="hidden" name="user_id" id="pf_user_id" value="{{$user->id}}" class="form-control" />
                <div class="modal-body">
                    <div class="form-group">
                        <label>PF Account Number</label>
                        <input type="text" name="pf_ac_no" id="pf_ac_no" class="form-control"  required="required" />
                    </div>
                    <div class="form-group">
                        <label>UAN</label>
                        <input type="text" name="uan" id="uan" class="form-control" required="required" />
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="pension_scheme" name="pension_scheme" value="1" {{ old('pension_scheme', @$user_detail->pension_scheme == 1 ? 'checked': '') }}>
                        <label for="pension_scheme"> Contribute to Employee Pension Scheme<a href="javascript:void(0);" title="Employees enrolled as EPF members on or before September 1, 2014, and employees enrolled after September 1, 2014 receiving less than ₹15,000 will have to contribute to the Employee Pension Scheme mandatorily. Employees receiving more than ₹15,000 need not contribute to EPS and their entire PF contribution will go into their Provident Fund account."><i class="uil-info-circle font-20"></i></a></label><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light provident_fund_disable_cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary">Enable</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="provident_fund_disable" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="update_provident_fund_disable" action="javascript:void(0)">
                <input type="hidden" name="provident_fund" id="provident_fund_check_disable" class="form-control" />
                <input type="hidden" name="user_id" value="{{$user->id}}" class="form-control" />
                <div class="modal-body">
                    <h5>Are you sure you want to disable Employees' Provident Fund for this employee?</h5>
                    <center>
                        <button type="button" class="btn btn-sm btn-light provident_fund_disable_cancel" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-sm btn-primary">Yes</button>
                    </center>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<div id="professional_tax_disable" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="update_professional_tax_disable" action="javascript:void(0)">
                <input type="hidden" name="professional_tax" id="professional_tax_check_disable" class="form-control" />
                <input type="hidden" name="user_id" value="{{$user->id}}" class="form-control" />
                <div class="modal-body">
                    <h5>Are you sure you want to disable Professional Tax for this employee?</h5>
                    <center>
                        <button type="button" id="professional_tax_disable_cancel" class="btn btn-sm btn-light" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-sm btn-primary">Yes</button>
                    </center>
                    
                </div>
            </form>
        </div>
    </div>
</div>

<div id="portal_access_disable" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data" id="update_portal_access_disable" action="javascript:void(0)">
                <input type="hidden" name="professional_tax" id="portal_access_check_disable" class="form-control" />
                <input type="hidden" name="user_id" value="{{$user->id}}" class="form-control" />
                <div class="modal-body">
                    <h5>Are you sure you want to disable the portal for this employee?</h5>
                    <center>
                        <button type="button" id="portal_access_disable_cancel" class="btn btn-sm btn-light" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-sm btn-primary">Yes</button>
                    </center>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('extrascripts')
<script> 
    function genratePaylip(){
        $('#generatePayslip').modal('show');
    }
    function salary_preview(){
        var id = "{{$user->id}}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        my_url = "";
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: {id:id},
            // processData: false,
            // contentType: false,
            //dataType: 'json',
            success: function (data) {
                
                $("#print_preview").html(data);
                $("#salary_detail_print_preview").modal("show");
            }, error: function (data) {
                //$("#provident_fund_enable").modal("hide");
                $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                setTimeout(function(){
                    //location.reload();
                }, 3500);
            },
        });
    }
    $('#provident_fund').change(function () {
        if ($(this).is(':checked')) {
            $("#provident_fund_enable").modal("show");
            
            $('#provident_fund_check').val(1);
        }
        else {
            $("#provident_fund_disable").modal("show");
            $('#provident_fund_check_disable').val(0);
        }

    });
    $(".provident_fund_disable_cancel").click(function(){
        if($("#provident_fund").is(':checked')){
            $("#provident_fund").prop('checked', false);
            $("#provident_fund_enable").modal("hide");
        }else{
            $("#provident_fund").prop('checked', true);
        }
        
    });

    $("#professional_tax_disable_cancel").click(function(){//alert(111);
        $("#professional_tax").prop('checked', !($("#professional_tax").is(':checked')));
    });
    $("#portal_access_disable_cancel").click(function(){//alert(111);
        $("#portal_access").prop('checked', !($("#portal_access").is(':checked')));
    });

    $(document).ready(function () {
        $('#generatePayslipForm').submit(function (e) {
            e.preventDefault();  
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            var formData=new FormData(this);
            my_url = "{{ route('Crm::generatePayslip') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                //dataType: 'json',
                success: function (data) {
                    $("#provident_fund_enable").modal("hide");
                    $.NotificationApp.send("Success","PF has been updated successfully!","top-center","green","success");
                   
                    // setTimeout(function(){
                    //     location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }, error: function (data) {
                    $("#provident_fund_enable").modal("hide");
                    $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        });
        $('#update_provident_fund').submit(function (e) {
            e.preventDefault();  
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            var formData=new FormData(this);
            my_url = "{{ route('Crm::update_provident_fund') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                //dataType: 'json',
                success: function (data) {
                    $("#provident_fund_enable").modal("hide");
                    $.NotificationApp.send("Success","PF has been updated successfully!","top-center","green","success");
                   
                    // setTimeout(function(){
                    //     location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }, error: function (data) {
                    $("#provident_fund_enable").modal("hide");
                    $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        });
        $('#update_provident_fund_disable').submit(function (e) {
            e.preventDefault();  
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            var formData=new FormData(this);
            my_url = "{{ route('Crm::update_provident_fund') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                //dataType: 'json',
                success: function (data) {
                    $("#provident_fund_disable").modal("hide");
                    $.NotificationApp.send("Success","PF has been updated successfully!","top-center","green","success");
                   
                    // setTimeout(function(){
                    //     location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }, error: function (data) {
                    $("#provident_fund_disable").modal("hide");
                    $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        });

        $('#update_professional_tax_disable').submit(function (e) {
            e.preventDefault();  
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            var formData=new FormData(this);
            my_url = "{{ route('Crm::update_professional_tax') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                //dataType: 'json',
                success: function (data) {
                    $("#professional_tax_disable").modal("hide");
                    $.NotificationApp.send("Success","Professional Tax has been updated successfully!","top-center","green","success");
                   
                    // setTimeout(function(){
                    //     location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }, error: function (data) {
                    $("#professional_tax_disable").modal("hide");
                    $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        });

        $('#update_portal_access_disable').submit(function (e) {
            e.preventDefault();  
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            var formData=new FormData(this);
            my_url = "{{ route('Crm::update_portal_access') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                //dataType: 'json',
                success: function (data) {
                    $("#portal_access_disable").modal("hide");
                    $.NotificationApp.send("Success","Portal Access has been updated successfully!","top-center","green","success");
                   
                    // setTimeout(function(){
                    //     location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }, error: function (data) {
                    $("#portal_access_disable").modal("hide");
                    $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        });

    });
    


    $('#professional_tax').change(function () {

        if ($(this).is(':checked')) {
            var user_id="{{$user->id}}";
            var professional_tax=1;
            var type = "post";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            my_url = "{{ route('Crm::update_professional_tax') }}";
            $.ajax({
                type: type,
                url: my_url,
                data: {user_id:user_id,professional_tax:professional_tax},
                //processData: false,
                //contentType: false,
                dataType: 'json',
                success: function (data) {
                    $.NotificationApp.send("Success","Professional tax has been updated successfully!","top-center","green","success");
                }, error: function (data) {
                    $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        }
        else {
            $("#professional_tax_disable").modal("show");
            $('#professional_tax_check_disable').val(0);
        }

    });

    $('#portal_access').change(function () {

        if ($(this).is(':checked')) {
            var user_id="{{$user->id}}";
            var portal_access=1;
            var type = "post";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            my_url = "{{ route('Crm::update_portal_access') }}";
            $.ajax({
                type: type,
                url: my_url,
                data: {user_id:user_id,portal_access:portal_access},
                //processData: false,
                //contentType: false,
                dataType: 'json',
                success: function (data) {
                    $.NotificationApp.send("Success","Portal access has been updated successfully!","top-center","green","success");
                }, error: function (data) {
                    $.NotificationApp.send("Error","Something is wroung. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        }
        else { 
            $("#portal_access_disable").modal("show");
            $('#portal_access_check_disable').val(0);
        }

    });
</script>


@endsection