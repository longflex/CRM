@extends('hyper.layout.master')
@section('title', "Organization Profile")
@section('content')
<style>
    
.hidden {
    display: none !important;
}
.side-bar > li{
    width: 100%;
}
.side-bar-profile{
    max-height: 100vh;
    overflow-y: auto;
}
</style>
<!-- start page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('console::profile') }}"><i class="uil-home-alt"></i>Console</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
            <h4 class="page-title">Organization Profile</h4>
        </div>
    </div>
</div>     
<!-- end page title --> 
<!-- start page content -->
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <div data-simplebar class="side-bar-profile">
                    <ul class="nav side-bar nav-tabs mb-3" id="myTab">
                        <li class="nav-item">
                            <a  href="#Organization" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-none d-md-block"><i class="uil-sitemap mr-1"></i>ORGANIZATION</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Genaral" id="Genaral_tabss" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                <span class="d-none d-md-block"><i class="uil-bright mr-1"></i>GENERAL</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#BranchTab" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-none d-md-block"><i class="uil-grid mr-1"></i>BRANCH</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Department" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-none d-md-block"><i class=" uil-gold mr-1"></i>DEPARTMENTS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Roles" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                <span class="d-none d-md-block"><i class="uil-bag mr-1"></i>ROLES</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="#Staff" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-none d-md-block"><i class="uil-users-alt mr-1"></i>STAFF</span>
                            </a>
                        </li> -->
                        <li class="nav-item">
                            <a href="#Donation" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-none d-md-block"><i class="uil-money-stack mr-1"></i>DONATION</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Member" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                <span class="d-none d-md-block"><i class=" uil-user-plus mr-1"></i>MEMBERS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Payments" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-none d-md-block"><i class=" uil-bill mr-1"></i>PAYMENTS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#TimeSlot" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-none d-md-block"><i class=" uil-clock-three mr-1"></i>TIME SLOT</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#ChangePassword" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                <span class="d-none d-md-block"><i class=" uil-unlock mr-1"></i>CHANGE PASSWORD</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#PrayerRequest" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-none d-md-block"><i class=" uil-question-circle mr-1"></i>PRAYER REQUESTS</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Sms" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <span class="d-none d-md-block"><i class=" uil-comment-dots mr-1"></i>SMS</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div> 
        </div>            
    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div id="Genaral" class="tab-pane fade">
                        <div class="mt-2">
                            <h3>General</h3><hr>
                            <form class="form-horizontal" method="POST" enctype="multipart/form-data"
                                id="upload_general_form" action="javascript:void(0)">
                                <div class="form-group">
                                    <label>Email/Username</label>
                                    <input type="text" class="form-control" id="user_name" id="user_name" value="{{ ($datas->email) ? $datas->email : '' }}" disabled placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Mobile No.</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ ($datas->mobile) ? $datas->mobile : '' }}" disabled placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" value="{{ ($datas->name) ? $datas->name : '' }}" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Alternate Email</label>
                                    <input type="text" class="form-control" id="altemail" name="altemail" value="{{ ($datas->alt_email) ? $datas->alt_email : 'N/A' }}" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Alternate Mobile</label>
                                    <input type="text" class="form-control" placeholder="" id="altcontact" name="altcontact" value="{{ ($datas->alt_mobile) ? $datas->alt_mobile : 'N/A' }}">
                                </div>

                                <div class="form-group">
                                    <label>Account Expiry</label>
                                    <input type="text" class="form-control" placeholder="" id="expiry" value="{{ ($datas->expiry_date) ? $datas->expiry_date : 'N/A' }}">
                                </div>
                                <button type="submit" id="generalForm" class="btn btn-sm btn-primary ml-1">Save</button>
                            </form>
                        </div>
                    </div>
                    <!--SMS-->
                    <div id ="Sms" class="tab-pane fade">
                        <h3>Sms Templates</h3><hr>
                        <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update_sms_data" action="javascript:void(0)">
                            <table class="table table-bordered table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Template</th>
                                        <th>Period</th>
                                        <th>Template Variable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($templates as $template)
                                    <tr>
                                        <td><p class="bg-warning rounded">{{ $template->name }}</p></td>
                                        <td style="width: 10%">
                                            <label class="switch">
                                                <input name="status_{{ $template->id }}" type="checkbox"
                                                    {{$template->status?'checked':""}}>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>

                                        <td>
                                            <div class="form-group">
                                                <textarea class="form-control" id="example-textarea" rows="5" name="template_{{ $template->id }}" placeholder="Type payment sms reminder here..">@if($template->template!=null && $template->template!='')
                                                {{$template->template}}
                                                @else
                                                Dear $NAME, Your $MONTH month EMI of $PRICE is pending. Kindly make payment with the given link <br>$PAYMENT_LINK<br>Thanks
                                                @endif</textarea>
                                            </div>
                                        </td>
                                        <td>
                                        @if($template->id==4 || $template->id==5)
                                        <div class="form-group">
                                            <select class="form-control"
                                                name="period_{{ $template->id }}">
                                                <option>Select</option>
                                                <option
                                                    {{ old('sms_period', $template->period == 'Daily' ? 'selected': '') }}>
                                                    Daily</option>
                                                <option
                                                    {{ old('sms_period', $template->period == 'Weekly' ? 'selected': '') }}>
                                                    Weekly</option>
                                                <option
                                                    {{ old('sms_period', $template->period == 'Alternative' ? 'selected': '') }}>
                                                    Alternative</option>
                                            </select>
                                        </div>
                                        @else N.A.
                                        @endif
                                    </td>
                                    <td>
                                        <p class="bg-warning rounded">Note:
                                            {NAME} => Member name<br>
                                            {MONTH} => EMI Month<br>
                                            {DAY} => EMI Due date date<br>
                                            {PRICE} => EMI Amount <br>
                                        </p>
                                    </td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex flex-row-reverse">
                                <button type="submit" id="SaveSMSfields" class="btn btn-sm btn-primary mt-2 mb-2 mr-3">Update</button>
                            </div>
                        </form> 
                    </div>
                    <!-- Change Password-->
                    <div id="ChangePassword" class="tab-pane fade">
                        <div class="mt-2">
                            <h3>Change Password</h3><hr>
                            <form class="form-horizontal" method="POST" id="change_password_form"
                                    action="javascript:void(0)">
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input class="form-control" type="password" placeholder="" id="current_password">
                                </div>

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input id="new_password" class="form-control" type="password" placeholder="">
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input id="confirm_password" class="form-control" type="password" placeholder="">
                                </div>

                                <button type="submit" id="changePassForm" class="btn btn-sm btn-primary ml-1">Update</button>
                            </form>
                        </div>
                    </div>
                    <!--Time Slot-->
                    <div id="TimeSlot" class="tab-pane fade">
                        <h3>Time Slot</h3><hr>

                        <!-- Edit-Time-Slot-Modal-start-->
                        <div id="EditTimeSlot" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-top">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">Edit Time Slot</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form id="update_timeslot_form" action="javascript:void(0)" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="edit_timeslot_id" id="edit_timeslot_id" class="form-control" />
                                            <div class="form-group">
                                                <label>Date *</label>
                                                <input class="form-control" type="date" name="edit_timeslot_date" id="edit_timeslot_date">
                                            </div>
                                            <div class="form-group">
                                                <label>Time *</label>
                                                <input type="time" name="edit_timeslot_time" id="edit_timeslot_time" class="form-control" />
                                            </div>
                                         
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <button type="submit" id="editTimeSlotForm" class="btn btn-primary">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- EditBranch Modal end -->
                        <div class ="row">
                            <div class="col-8">
                                <div class="card">
                                    <div class="card-body">
                                        @if (count($apt_time_slots) > 0)
                                            <table class="table table-centered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($apt_time_slots as $timeslot)
                                                    <tr id="timeslot{{$timeslot->id}}">
                                                        <td>{{ $timeslot->name }}</td>
                                                        <td>{{ date('d/m/Y', strtotime($timeslot->slot_date)) }}</td>
                                                        <td>{{  date("g:i A", strtotime($timeslot->slot_time)) }}</td>
                                                        <td>
                                                            @if($timeslot->status=='Available')
                                                            <span>{{ $timeslot->status }}</span>
                                                            @else
                                                            <span>{{ $timeslot->status }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="javascript:void(0);" id="editTimeSlot"
                                                                class="btn-table" data-toggle="modal"
                                                                data-target="#EditTimeSlot" data-id="{{$timeslot->id}}"
                                                                data-date="{{$timeslot->slot_date}}"
                                                                data-time="{{$timeslot->slot_time}}"><i class="uil-edit"></i></a>
                                                            <a href="javascript:void(0);" id="deleteData"
                                                                data-id="{{$timeslot->id}}" data-type="timeslot"
                                                                class="btn-table"><i class="uil-trash"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        {{ $apt_time_slots->fragment('TimeSlot')->links() }}
                                        @else
                                        <div class="p-2 bg-warning rounded">
                                                <h5>{{ trans('laralum.missing_title') }}</h5>
                                                <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "time slot"]) }}<p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="upload_time_slot_form" action="javascript:void(0)">
                                            <div class="form-group">
                                                <label>Staff *</label>
                                                <select class="form-control" id="apt_staff" name="apt_staff">
                                                    <option value="">Select staff</option>
                                                    @foreach($apt_staffs as $apt_staff)
                                                        <option value="{{ $apt_staff->id }}">{{ $apt_staff->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Date *</label>
                                                <input class="form-control" type="date" name="slot_date" id="slot_date">
                                            </div>

                                            <div class="form-group">
                                                <label>Time *</label>
                                                <div class="fieldmore">
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <div class="form-group">
                                                                <input class="form-control" type="time" name="slot_time[]" id="slot_time">
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary addMore"><i class="uil-plus" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="timeSlotForm" class="btn btn-primary"><span
                                                        id="hidetstext">SAVE</span>&nbsp;
                                                    <span class="timeSlotForm" style="display:none;"></span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Payments-->
                    <div id ="Payments" class= "tab-pane fade">
                        <h3>Payments</h3><hr>
                        <!-- Bank Modal -->
                        <div id="AddBanks" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-top">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">Bank Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form id="upload_bank_form" action="javascript:void(0)" method="POST">
                                        <div class="modal-body">
                                            <span class="text-center red" id="bank_error_text" style="display:none;">All
                                                fields are required.</span>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Account Number&nbsp;<span
                                                                style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" id="account_no"
                                                            name="account_no" />
                                                        <input type="hidden" id="details_id" name="details_id" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Account Holder Name&nbsp;<span
                                                                style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" id="account_holder_name"
                                                            name="account_holder_name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Bank Name&nbsp;<span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" id="bank_name"
                                                            name="bank_name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Branch&nbsp;<span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" id="bank_branch"
                                                            name="bank_branch" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>IFSC Code&nbsp;<span style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" id="ifsc_code"
                                                            name="ifsc_code" />
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" id="bankForm"
                                                            class="ui teal submit button"><span
                                                                id="hidebanktext">SAVE</span>&nbsp;
                                                            <span class="bankForm" style="display:none;"><img
                                                                    src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                                                        </button>
                                                    </div>
                                                </div> -->
                                            </div>
                                         
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <button type="submit" id="bankForm" class="btn btn-primary">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- RazorPay Modal -->
                        <div id="AddRazorPay" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-top">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">RazorPay Details</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form id="upload_razorpay_form" action="javascript:void(0)" method="POST">
                                        <div class="modal-body">
                                            <span class="text-center red" id="razorpay_error_text"
                                                style="display:none;">All
                                                fields are required.</span>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>RazorPay Key&nbsp;<span
                                                                style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" id="razorpay_key"
                                                            name="razorpay_key" />
                                                        <input type="hidden" id="razorpay_details_id"
                                                            name="details_id" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>RazorPay SecretKey&nbsp;<span
                                                                style="color:red;">*</span></label>
                                                        <input type="text" class="form-control" id="razorpay_secret_key"
                                                            name="razorpay_secrey_key" />
                                                    </div>
                                                </div>
                                            </div>
                                         
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <button type="submit" id="razorPayForm" class="btn btn-primary">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-row-reverse">
                            <a href="#" class="btn btn-sm btn-primary teal submit button" id="addBankDetails" data-toggle="modal" data-target="#AddBanks"><i class="uil-plus-circle"></i>&nbsp;Add Bank
                            </a>
                            @if(!Laralum::loggedInUser()->RAZOR_KEY)
                            <a href="#" class="btn btn-sm btn-primary teal submit button" id="addRazorPayDetails" data-toggle="modal" data-target="#AddRazorPay"><i class="uil-plus-circle"></i>&nbsp;Add RazorPay
                            </a>
                            @endif
                        </div>  
                        <div class="card"> 
                            <div class="card-body">
                                @if(count($bank_details)>0)
                                <table class="table table-bordered table-centered mb-3">
                                    <thead>
                                        <tr>
                                            <td>Name.</td>
                                            <td>Account No.</td>
                                            <td>Bank</td>
                                            <td>Branch</td>
                                            <td>IFSC Code</td>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bank_details as $details)
                                        <tr>
                                            <td>{{ $details->ac_name }}</td>
                                            <td>{{ $details->ac_number }}</td>
                                            <td>{{ $details->bank }}</td>
                                            <td>{{ $details->address }}</td>
                                            <td>{{ $details->ifsc_code }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" id="editBankDetails"
                                                    class="" data-toggle="modal"
                                                    data-target="#AddBanks" data-id="{{$details->id}}"
                                                    data-name="{{ $details->ac_name }}"
                                                    data-account="{{ $details->ac_number }}"
                                                    data-bank="{{ $details->bank }}"
                                                    data-branch="{{ $details->address }}"
                                                    data-ifsc="{{ $details->ifsc_code }}"><i class="uil-edit"></i></a>
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
                                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "bank details"]) }}
                                        </p>
                                    </div>
                                </div>
                                @endif
                                @if(Laralum::loggedInUser()->RAZOR_KEY)
                                <table class="ui table">
                                    <thead>
                                        <tr class="table_heading">
                                            <th>RazorPay Key.</th>
                                            <th>RazorPay Secret Key.</th>
                                            <th>&nbsp</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ Laralum::loggedInUser()->RAZOR_KEY }}</td>
                                            <td>{{ Laralum::loggedInUser()->RAZOR_SECRET }}</td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" id="editRazorPayDetails"
                                                    class="" data-toggle="modal"
                                                    data-target="#AddRazorPay"
                                                    data-key="{{ Laralum::loggedInUser()->RAZOR_KEY }}"
                                                    data-secret="{{ Laralum::loggedInUser()->RAZOR_SECRET }}"><i class="uil-edit"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @else
                                <div class="ui negative icon message">
                                    <i class="frown icon"></i>
                                    <div class="content">
                                        <div class="header">
                                            {{ trans('laralum.missing_title') }}
                                        </div>
                                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "Razor payment details"]) }}
                                        </p>
                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <!--Member-->
                    <div id="Member" class="tab-pane fade">
                        <h3>Member</h3><hr>
                            <!-- EditSource Modal start-->
                            <div id="EditSource" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-top">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Edit Source </h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data" id="update_member_source_form"
                                            action="javascript:void(0)">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="simpleinput">Source</label>
                                                    <input type="text" name="editSource" id="edit-source" class="form-control" />
                                                    <input type="hidden" name="type" value="2" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                <button type="submit" id="editMemberForm" class="btn btn-primary">UPDATE</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- EditSource Modal end -->
                            <!-- EditAccountType Modal start-->
                            <div id="EditAccountType" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-top">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Edit Account type</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data" id="update_member_account_form"
                                            action="javascript:void(0)">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="simpleinput">Account type</label>
                                                    <input type="text" name="editAccountType" id="edit-account-type"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                <button type="submit" id="editMemberForm" class="btn btn-primary">UPDATE</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- EditAccountType Modal end -->
                            <!--Edit Member Type Modal-->
                            <div id="EditMemberType" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-top">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="topModalLabel">Edit Member type</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <form method="POST" enctype="multipart/form-data" id="update_member_type_form"
                                            action="javascript:void(0)">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="simpleinput">Member type</label>
                                                    <input type="text" name="editMemberType" id="edit-member-type"
                                                        class="form-control" />
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                <button type="submit" id="editMemberForm" class="btn btn-primary">UPDATE</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--end Edit Member Type Modal-->
                        <div class ="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        @if (count($sources) > 0 or count($membertypes) > 0 or count($accounttypes) > 0)
                                        @if(count($accounttypes) > 0)
                                        <table class="table table-bordered table-centered mb-1">
                                            <thead>
                                                <tr>
                                                    <th>Account type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($accounttypes as $account)
                                                <tr>
                                                    <td>{{ $account->type }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);" id="editaccountType" class="" data-toggle="modal" data-target="#EditAccountType"
                                                        data-accountid="{{$account->id}}" data-val="{{$account->type}}"><i class="uil-edit" aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);" id="deleteData" data-id="{{$account->id}}"
                                                                data-type="account_type" class=""><i class="uil-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        @if(count($membertypes) > 0)
                                        <table class="table table-bordered table-centered mb-1">
                                            <thead>
                                                <tr>
                                                    <th>Member type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($membertypes as $member)
                                                <tr>
                                                    <td>{{ $member->type }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);" id="editmemberType" class="" data-toggle="modal" data-target="#EditMemberType" 
                                                        data-memberid="{{$member->id}}" data-val="{{$member->type}}"><i class="uil-edit" aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);"  id="deleteData" data-id="{{$member->id}}"
                                                                data-type="member_type" class=""><i class="uil-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        @if(count($sources) > 0)
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Sources Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($sources as $source)
                                                <tr>
                                                    <td>{{ $source->source }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);" id="editmemberSource" class="" data-toggle="modal" data-target="#EditSource"
                                                        data-sourceid="{{$source->id}}" data-val="{{$source->source}}"><i class="uil-edit" aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);" id="deleteData" class="" data-id="{{$source->id}}" data-type="source"><i class="uil-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                        @else
                                        <div class="container">
                                            <i class=""></i>
                                            <div class="content">
                                                <h3>
                                                    {{ trans('laralum.missing_title') }}
                                                </h3>
                                                <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "Member Detail"]) }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <label>Account Type *</label>
                                        <form class="form-horizontal" method="POST" id="upload_member_form"
                                        action="javascript:void(0)">
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Enter Account Type" id="account_type" name="account_type">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" href="javascript:void(0);" id="saveAccountType" class="btn btn-sm btn-primary" ><i class="uil-plus-circle"></i></button>
                                            </div>
                                        </div>
                                        </form>

                                        <label>Member Type *</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Enter Member Type" id="member_type" name="member_type"">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <a href="javascript:void(0);" id="saveMemberType" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#" data-requestid="8" data-request="test"><i class="uil-plus-circle"></i></a>
                                            </div>
                                        </div>

                                        <label>Source *</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Enter Source" id="source" name="source">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <a href="javascript:void(0);" id="saveSource" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#" data-requestid="8" data-request="test"><i class="uil-plus-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Donation-->
                    <div id="Donation" class="tab-pane fade">
                        <h3>Donation</h3><hr>
                        <!-- <div id="EditDonationType" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Donation Type</h4>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_donation_type_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Donation type</label>
                                                <input type="text" name="editDonationType" id="edit-donation-type"
                                                    class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="edit_donation_type_form"
                                                    class="ui teal submit button"><span
                                                        id="hidebutext">UPDATE</span>&nbsp;
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                        <div id="EditDonationPurpose" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-top">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">Edit Donation Purpose</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_donation_purpose_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="simpleinput">Donation Purpose</label>
                                                <input type="text" name="editDonationPurpose" id="edit-donation-purpose" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <button type="submit" id="edit_donation_purpose_form" class="btn btn-primary">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="EditDonationPurpose" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Donation Purpose</h4>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_donation_purpose_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Donation Purpose</label>
                                                <input type="text" name="editDonationPurpose" id="edit-donation-purpose"
                                                    class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="edit_donation_purpose_form"
                                                    class="ui teal submit button"><span
                                                        id="hidebutext">UPDATE</span>&nbsp;
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div id="EditSource" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-top">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">Edit Source</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_member_source_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="simpleinput">Source</label>
                                                <input type="text" name="editSource" id="edit-source" class="form-control" />
                                                <input type="hidden" name="type" value="2" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <button type="submit" id="editMemberForm" class="btn btn-primary">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div id="EditSource" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Source</h4>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_member_source_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Source</label>
                                                <input type="text" name="editSource" id="edit-source"
                                                    class="form-control" />
                                                <input type="hidden" name="type" value="2" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="editMemberForm"
                                                    class="ui teal submit button"><span
                                                        id="hidebutext">UPDATE</span>&nbsp;
                                                    <span class="editMemberForm" style="display:none;"><img
                                                            src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                        <div class ="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        @if (count($donationpurposes) > 0)
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="60%">Donation Purpose</th>
                                                    <th class="text-center" width="40%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($donationpurposes as $purpose)
                                                <tr id="member_type{{$purpose->id}}">
                                                    <td>{{ $purpose->purpose }}</td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0);" id="editdonationPurpose"
                                                            data-purposeid="{{$purpose->id}}" data-val="{{$purpose->purpose}}"
                                                            data-toggle="modal" data-target="#EditDonationPurpose"><i class="uil-edit"></i></a>
                                                        <a href="javascript:void(0);" id="deleteData" data-id="{{$purpose->id}}" data-type="donation_purpose"><i class="uil-trash"></i></a>

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
                                                <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "Donation Detail"]) }}
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="form-horizontal" method="POST" id="upload_member_form" action="javascript:void(0)">
                                            <div class="form-group">
                                                <label>Donation Purpose</label>
                                                <input type="text" class="form-control"  placeholder="Enter Purpose" id="purpose" name="purpose">
                                            </div>
                                            <button type="submit" id="savePurpose" class="btn btn-sm btn-primary ml-1">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Roles-->
                    <div id ="Roles" class="tab-pane fade">
                        <h3>Role Management</h3><hr>
                        
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('console::roles_create') }}" class="btn btn-sm btn-primary mt-1 mb-2 float-right"><i class="uil-plus-circle"></i>Create Role</a>
                                <table class="table table-bordered table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>User</th>
                                            <th>Permissions</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        <?php
                                        //echo "<pre>";print_r($role->users);
                                        ?>
                                        <tr>
                                            <td>
                                                @if($role->id==2)
                                                <div class="text">{{ $role->name }}</div>
                                                @else
                                                <a class="text" data-fancybox="data-fancybox" data-type="iframe"
                                                    href="{{ route('console::role_staff', ['id' => $role->id]) }}">
                                                    {{ $role->name }}
                                                </a>
                                                @endif
                                            </td>
                                            <td>
                                                <?php
                                                if(Laralum::loggedInUser()->id == 1){
                                                    echo trans('laralum.roles_users', ['number' => $role->id==2?count($role->users)+1:count($role->users)]);
                                                }else{
                                                    echo trans('laralum.roles_users', ['number' => count($role->RoleByUserId(Laralum::loggedInUser()->id))]);
                                                }
                                                ?>
                                            </td>
                                            <td>{{ trans('laralum.roles_permissions', ['number' =>$role->id==2?count($permissions):count($role->permissions)]) }}
                                            </td>
                                            <td>
                                                @if ($role->id!=2)
                                                <a href="{{ route('console::roles_edit', ['id' => $role->id]) }}" title="Edit Role"><i class="uil-edit font-20"></i> </a>
                                                <a href="{{ route('console::roles_permissions', ['id' => $role->id]) }}" title="Edit Permission"><i class="uil-auto-flash font-20"></i> </a> 
                                                <a href="{{ route('console::roles_delete', ['id' => $role->id]) }}" title="Delete Role"><i class="uil-trash font-20"></i></a>        
                                                @else
                                                <a href="javascript:void(0)" title="Lock"><i class="uil-lock font-20"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--Department-->
                    <div id="Department" class="tab-pane fade">
                        <h3>Department</h3><hr>
                        <div  class="row " >
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- EditDepartments Modal start-->
                                        <div id="EditDepartments" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-top">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="topModalLabel">Edit Department</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    </div>
                                                    <form method="POST" enctype="multipart/form-data" id="update_department_form"
                                                        action="javascript:void(0)">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="simpleinput">Department</label>
                                                                <input type="text" name="editdepartment" id="edit-department" class="form-control">
                                                                <input type="hidden" id="edit-department-id" name="editdepartmentid"
                                                                    class="form-control" />
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                            <button type="submit" id="editDepartmentForm" class="btn btn-primary">UPDATE</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div id="EditDepartments" class="modal fade" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Edit Department</h4>
                                                    </div>
                                                    <form method="POST" enctype="multipart/form-data" id="update_department_form"
                                                        action="javascript:void(0)">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Department</label>
                                                                <input type="text" class="form-control" id="edit-department"
                                                                    name="editdepartment" />
                                                                <input type="hidden" id="edit-department-id" name="editdepartmentid" />
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" id="editDepartmentForm"
                                                                    class="ui teal submit button"><span
                                                                        id="hidedutext">UPDATE</span>&nbsp;
                                                                    <span class="editDepartmentForm" style="display:none;"><img
                                                                            src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div> -->
                                        <!-- EditDepartments Modal end -->
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="60%">Department</th>
                                                    <th class="text-center" width="40%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($departments as $department)
                                                    <tr id="department{{$department->id}}">
                                                        <td>{{ $department->department }}</td>
                                                        <td class="text-center">
                                                            <a href="javascript:void(0);" id="editDepartment" data-toggle="modal"
                                                                data-target="#EditDepartments"
                                                                data-departmentid="{{$department->id}}"
                                                                data-department="{{$department->department}}"><i class="uil-edit"></i></a>
                                                            <a href="javascript:void(0);" id="deleteData"
                                                                data-id="{{$department->id}}" data-type="department"><i class="uil-trash"></i></a>      
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="form-horizontal" method="POST" id="upload_department_form" action="javascript:void(0)">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <input type="text" class="form-control" placeholder="Enter Department" id="department" name="department">
                                            </div>
                                            <button type="submit" id="departmentForm" class="btn btn-sm btn-primary ml-1">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--Branch-->
                    <div id="BranchTab" class="tab-pane fade">
                        <h3>Branch</h3><hr>
                        <!-- EditBranch Modal start-->
                        <div id="EditBranch" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-top">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">Edit Branch</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_branch_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="simpleinput">Branch</label>
                                                <input type="text" name="editbranch" id="edit-branch" class="form-control">
                                                <input type="hidden" name="editbranchid" id="edit-branch-id"
                                                    class="form-control" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <button type="submit" id="editBranchForm" class="btn btn-primary">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- <div id="EditBranch" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Edit Branch</h4>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_branch_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Branch</label>
                                                <input type="text" name="editbranch" id="edit-branch"
                                                    class="form-control" />
                                                <input type="hidden" name="editbranchid" id="edit-branch-id"
                                                    class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="editBranchForm"
                                                    class="ui teal submit button"><span
                                                        id="hidebutext">UPDATE</span>&nbsp;
                                                    <span class="editBranchForm" style="display:none;"><img
                                                            src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                        <!-- EditBranch Modal end -->
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        @if (count($branches) > 0)
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="60%">Branch</th>
                                                    <th class="text-center" width="40%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($branches as $branch)
                                                <tr id="branch{{$branch->id}}">
                                                    <td>{{ $branch->branch }}</td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0);" id="editBranch" data-branchid="{{$branch->id}}" data-branch="{{$branch->branch}}" data-toggle="modal" data-target="#EditBranch"><i class="uil-edit"></i></a>
                                                        <a href="javascript:void(0);" id="deleteData" data-id="{{$branch->id}}"
                                                            data-type="branch"><i class="uil-trash"></i></a>
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
                                                <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "branch"]) }}</p>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form class="form-horizontal" method="POST" id="upload_branch_form" action="javascript:void(0)">
                                            <div class="form-group">
                                                <label>Branch</label>
                                                <input type="text" class="form-control" placeholder="Enter Branch" id="branch"
                                                            name="branch">
                                            </div>
                                            <button type="submit" id="branchForm" class="btn btn-sm btn-primary ml-1">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Prayer Request-->
                    <div id="PrayerRequest" class= "tab-pane fade" >
                        <h3>Prayer Request</h3><hr>
                        <!--Edit Prayer Request Modal-->
                        <div id="EditRequests" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-top">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="topModalLabel">Edit Prayer Request</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_request_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="simpleinput">Request</label>
                                                <input type="text" class="form-control" id="edit-request" name="editrequest" />
                                                <input type="hidden" id="edit-request-id" name="editrequestid" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                            <button type="submit" id="editRequestForm" class="btn btn-primary">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="modal fade" id="EditRequests" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="mySmallModalLabel">Edit Prayer Request</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form method="POST" enctype="multipart/form-data" id="update_request_form"
                                        action="javascript:void(0)">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Request</label>
                                                <input type="text" class="form-control" id="edit-request"
                                                    name="editrequest" />
                                                <input type="hidden" id="edit-request-id" name="editrequestid" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="editRequestForm"
                                                    class="btn btn-info"><span
                                                        id="hidedutext">UPDATE</span>
                                                        <span class="editRequestForm" style="display:none;">
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->
                        <div class="row " >
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body">
                                     @if(count($requests) > 0)
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Prayer Request</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($requests as $request)
                                                <tr id="request{{$request->id}}">
                                                    <td>{{ $request->prayer_request }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);" id="editRequests" class=""  data-toggle="modal"
                                                                data-target="#EditRequests" data-requestid="{{$request->id}}"
                                                                data-request="{{ $request->prayer_request }}"><i class="uil-edit" aria-hidden="true"></i></a>
                                                        <a href="javascript:void(0);" id="deleteData" data-id="{{$request->id}}"
                                                                data-type="request" class=""><i class="uil-trash" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                     @else
                                        <div class="container">
                                            <i class=""></i>
                                            <div class="content">
                                                <div class="header">
                                                    {{ trans('laralum.missing_title') }}
                                                </div>
                                                <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "prayer request"]) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class= "card">
                                    <div class="card-body">
                                        <form class="form" method="POST" id="upload_request_form"
                                                    action="javascript:void(0)">
                                            <div class="form-group">
                                                <label>Prayer Request</label>
                                                <input type="text" class="form-control" data-provide="typeahead" id="request"
                                                                name="prayer_request" placeholder="Enter Request">
                                            </div>
                                            <button type="submit" id="requestForm" class="btn btn-sm btn-primary ml-1">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--Organation-->
                    <div id="Organization" class="tab-pane show active">
                        <div  class="card">
                            <div class="card-body">
                                <h3>Organization Profile</h3><hr>
                                <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="upload_organization_form" action="javascript:void(0)">
                                    <div class="text-center">
                                        @if(isset($org_profile) && !empty($org_profile->organization_logo))
                                        <img id="logoimage" src="{{ asset('console_public/data/organization') }}/{{ $org_profile->organization_logo }}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                                        @else
                                        <img id="logoimage" src="{{ asset('console_public/images/defalut-image-logo.jpg') }}" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                                        @endif
                                        <!-- <a class="btn btn-sm btn-primary" id="profile_img_btn" onclick="$('.dimmer').removeClass('dimmer')">Choose Logo</a> -->
                                        <input id="logoimgselector" name="org_logo" type="file"
                                            class="hidden" />
                                        <input name="org_logo_hidden" type="hidden"
                                            value="{{ isset($org_profile) ? $org_profile->organization_logo : '' }}" />

                                        <div class="mt-2">
                                            <a class="btn btn-sm btn-primary" id="profile_img_btn" onclick="$('.dimmer').removeClass('dimmer')">Choose Logo</a>
                                            <!-- <button type="button" class="btn btn-sm btn-primary">Change Logo</button> -->
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div>
                                            <div class="form-group">
                                                <label>Organization Name *</label>
                                                <input type="text" class="form-control" data-provide="typeahead" name="organization_name" id="organization_name" placeholder="Organization Name" value="{{ isset($org_profile) && !empty($org_profile->organization_name) ? $org_profile->organization_name : '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label>Company ID *</label>
                                                <input id="company_id" name="company_id" value="{{ isset($org_profile) && !empty($org_profile->company_id) ?$org_profile->company_id: "" }}" class="form-control" type="text" placeholder="Company Id">
                                            </div>
                                            <div class="form-group">
                                                <label for="example-select">Industry *</label>
                                                <select class="form-control select2" id="industry" name="industry" data-toggle="select2" data-placeholder="Please select..">
                                                    <option>Select Industry</option>
                                                    @foreach($industries as $key=>$val)
                                                    <option value="{{ $key }}" @if( isset($org_profile) && $org_profile->
                                                        industry==$key) selected="selected" @endif>{{ $val }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Business Location *</label>
                                                <input type="text" class="form-control" placeholder="Business Location" name="business_location" id="business_location" value="{{ isset($org_profile) && !empty($org_profile->business_location) ? $org_profile->business_location : '' }}">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-textarea">Company Address</label>
                                                <textarea class="form-control" placeholder="Address Line 1" id="address1" name="address1" rows="1">{{ isset($org_profile) && !empty($org_profile->company_address_line1) ? $org_profile->company_address_line1 : '' }}</textarea>
                                                <textarea class="form-control" placeholder="Address Line 2" id="address2"name="address2" rows="1">{{ isset($org_profile) && !empty($org_profile->company_address_line2) ? $org_profile->company_address_line2 : '' }}</textarea>
                                            </div>
                                            <button type="submit" id="organizationForm" class="btn btn-sm btn-primary ml-1">Save</button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> 
                    </div><!--Organation End-->
                </div>
            </div>
        </div>
    </div>
</div>    



<!-- copy of input fields group -->
<div class="fieldmoreCopy" style="display: none;">
    <div class="row">
        <div class="col-9">
            <div class="form-group">
                <input class="form-control" id="example-time" type="time" name="time">
            </div>
        </div>
        <div class="col-3">
            <a href="javascript:void(0);" id="editBranch" class="btn btn-danger btn-plus remove"><i class="uil-minus" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
<!-- copy of input fields group -->
@endsection
@section('extrascripts')
<script>
   
$(document).ready(function() {
    function onHashChange() {
        var hash = window.location.hash;
        if (hash) {
            // using ES6 template string syntax
            $(`[data-toggle="tab"][href="${hash}"]`).trigger('click');
        }
    }
    window.addEventListener('hashchange', onHashChange, false);
    onHashChange();
});

$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
}); 

$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
<script>   
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#logoimage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
$("#logoimgselector").change(function(){
    readURL(this);
});

</script>
<script>
$('#profile_img_btn').bind("click" , function () {
    $('#logoimgselector').click();
 });
$(document).on('click','#editBranch',function(e) {
    $('#edit-branch').val($(this).attr('data-branch'))
    $('#edit-branch-id').val($(this).attr('data-branchid'))
});
$(document).on('click','#editDepartment',function(e) {
    $('#edit-department').val($(this).attr('data-department'))
    $('#edit-department-id').val($(this).attr('data-departmentid'))
});
$(document).on('click','#editmemberSource',function(e) {
    $('#edit-source').val($(this).attr('data-val'))
});
$(document).on('click','#editmemberType',function(e) {
    $('#edit-member-type').val($(this).attr('data-val'))
});
$(document).on('click','#editdonationType',function(e) {
    $('#edit-donation-type').val($(this).attr('data-val'))
});
$(document).on('click','#editdonationPurpose',function(e) {
    $('#edit-donation-purpose').val($(this).attr('data-val'))
});
$(document).on('click','#editaccountType',function(e) {
    $('#edit-account-type').val($(this).attr('data-val'))
});

$(document).on('click','#editBankDetails',function(e) {
    $('#details_id').val($(this).attr('data-id'))
    $('#account_holder_name').val($(this).attr('data-name'))
    $('#account_no').val($(this).attr('data-account'))
    $('#bank_name').val($(this).attr('data-bank'))
    $('#bank_branch').val($(this).attr('data-branch'))
    $('#ifsc_code').val($(this).attr('data-ifsc'))
});
$(document).on('click','#editRazorPayDetails',function(e) {
    $('#razorpay_key').val($(this).attr('data-key'))
    $('#razorpay_secret_key').val($(this).attr('data-secret'))
});

$("#send_msg_after_duedate").on('change', function() {
    if ($(this).is(':checked'))
        $("#sms_period").show();
    else {
        $("#sms_period").hide();
    }
});
//faruk

$(document).on('click','#editRequests',function(e) {
    $('#edit-request').val($(this).attr('data-request'))
    $('#edit-request-id').val($(this).attr('data-requestid'))
});

$(document).on('click','#editTimeSlot',function(e) {
    $('#edit_timeslot_id').val($(this).attr('data-id'))
    $('#edit_timeslot_date').val($(this).attr('data-date'))
    $('#edit_timeslot_time').val($(this).attr('data-time'))
});

$(document).on('click','#editRequests',function(e) {
    $('#edit-request').val($(this).attr('data-request'))
    $('#edit-request-id').val($(this).attr('data-requestid'))
});

$(document).ready(function(){
    //group add limit
    var maxGroup = 15;
    //add more fields group
    $(".addMore").click(function(){
        if($('body').find('.fieldmore').length < maxGroup){
            var fieldHTML = '<div class="fieldmore">'+$(".fieldmoreCopy").html()+'</div>';
            $('body').find('.fieldmore:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });
    
    //remove fields group
    $("body").on("click",".remove",function(){ 
        $(this).parents(".fieldmore").remove();
    });
    
    
});

//delete branch & department and remove it from list
$(document).on('click','#deleteData',function(e) {
    e.preventDefault();
    var id=$(this).attr('data-id');
    var dtype=$(this).attr('data-type');
    var APP_URL="{{route('console::console')}}";
    var url = APP_URL+'/manage/delDepartmentBranchData';    
    var type = "POST"; 
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    var formData = {
          id: id,
        dtype: dtype,
    }
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You want to delete this data !!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {    
                $.ajax({
                    type: type,
                    url: url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        location.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your data not deleted !',
                'error'
            )
        }
    });
    
});


</script>
<script>
$(document).ready(function () {
    var APP_URL="{{route('console::console')}}";
    //Organization profile form script

    $('#upload_organization_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var organization_name = $('#organization_name').val();
        var company_id = $('#company_id').val();
        var industry = $('#industry').val();
        var business_location = $('#business_location').val();
        
        if (organization_name == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("Error","Please enter organization name!","top-center","red","error");
            return false;
        }
        if (industry == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("Error","Please select industry!","top-center","red","error");
            return false;
        }
        if (business_location == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("Error","Please enter business location!","top-center","red","error");
            return false;
        }
        if (company_id == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("Error","Please enter company id!","top-center","red","error");
            return false;
        }
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/organizationData';
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        //alert(business_location);return;
        //$("#hideorgtext").css('display', 'none');
        //$(".organizationForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                //$(".organizationForm").css('display', 'none');
                //$("#hideorgtext").css('display', 'inline-block');
                $.NotificationApp.send("Success","The organization profile has been updated!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                console.log('Error:', data);
            }
        });
    });

    // general form

    $('#upload_general_form').submit(function (e) {//alert(11);return;
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/generalData';
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        //$("#hidegeneraltext").css('display', 'none');
        //$(".generalForm").css('display', 'inline-block');
        var hash="#Genaral";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                //$(".generalForm").css('display', 'none');
                //$("#hidegeneraltext").css('display', 'inline-block');
                $.NotificationApp.send("Success","The general information has been updated!","top-center","green","success");

                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                console.log('Error:', data);
            }
        });

    });

    //Branch form script    
    $('#upload_branch_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var branch = $('#branch').val();
        if (branch == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("Error","Please enter branch name!","top-center","red","error");
            //swal('Warning!', 'Please enter branch name!', 'warning')
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/branchData';
        var type = "POST";
        //$("#hidebrtext").css('display', 'none');
        //$(".branchForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                //$(".branchForm").css('display', 'none');
                //$("#hidebrtext").css('display', 'inline-block');
                $.NotificationApp.send("Success","The branch " + branch + " has been created!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("Error",data,"top-center","red","error");
                //swal('Error!', data, 'error')
            }
        });

    });

    $('#update_branch_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var editbranch = $('#edit-branch').val();
        if (editbranch == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("Error",'Please enter branch name!',"top-center","red","error");
            //swal('Warning!', 'Please enter branch name!', 'warning')
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/updateBranchData';
        var type = "POST";
        //$("#hidebutext").css('display', 'none');
        //$(".editBranchForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#EditBranch').modal('hide');
                $.NotificationApp.send("Success","The branch has been updated!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("Error",data,"top-center","red","error");
                //swal('Error!', data, 'error')
            }
        });

    });

    //Department form script    
    $('#upload_department_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var department = $('#department').val();
        if (department == '') {
            $.NotificationApp.send("Error",'Please enter department name!',"top-center","red","error");
            //swal('Warning!', 'Please enter department name!', 'warning')
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/departmentData';
        var type = "POST";
        //$("#hidedpttext").css('display', 'none');
        //$(".departmentForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $.NotificationApp.send("Success","The department " + department + " has been created!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $.NotificationApp.send("Error",data,"top-center","red","error");
                //swal('Error!', data, 'error')
            }
        });

    });


    $('#update_department_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var editdepartment = $('#edit-department').val();
        if (editdepartment == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("Error","Please enter department name!","top-center","red","error");
            //swal('Warning!', 'Please enter department name!', 'warning')
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/updateDepartmentData';
        var type = "POST";
        //$("#hidedutext").css('display', 'none');
        //$(".editDepartmentForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#EditDepartments').modal('hide');
                $.NotificationApp.send("Success","The department has been updated!","top-center","green","success");
                //$(".editDepartmentForm").css('display', 'none');
                //$("#hidedutext").css('display', 'inline-block');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("Error",data,"top-center","red","error");
                //swal('Error!', data, 'error')
            }
        });

    });

    $('#update_donation_purpose_form').submit(function (e) {

        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var donation_type = $('#edit-donation-purpose').val();
        var id = $('#editdonationPurpose').attr('data-purposeid');

        if (donation_type == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("Error",'Please enter Donation Purpose!',"top-center","red","error");
            //swal('Warning!', 'Please enter Donation Purpose!', 'warning')
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        formData.append('type', 1);
        formData.append('id', id)
        var my_url = APP_URL + '/manage/updateDonationData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#EditDonationPurpose').modal('hide');
                $.NotificationApp.send("Success","The data has been updated!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("Error",data,"top-center","red","error");
                //swal('Error!', data, 'error')
            }
        });

    });

    $(document).on('click', '#savePurpose', function (e) {
        e.preventDefault();
        //  e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var data = $('#purpose').val();
        if (data == '') {
            $.NotificationApp.send("Error",'Please enter donation type',"top-center","red","error");
            //swal('Warning!', 'Please enter donation type', 'warning')
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var my_url = APP_URL + '/manage/donationData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: JSON.stringify({
                data: data,
                type: 1
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("Success","The Donation details has been submited!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("Error",data,"top-center","red","error");
                //swal('Error!', data, 'error')
            }
        });
    });

///faruk

    //Edit Source Type
    $('#update_member_source_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var source = $('#edit-source').val();
        var id = $('#editmemberSource').attr('data-sourceid');
        if (source == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please enter Source!','top-center','red', 'warning');
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        formData.append('type', 2);
        formData.append('id', id);
        var my_url = APP_URL + '/manage/updateMemberData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#EditSource').modal('hide');
                $.NotificationApp.send('Success!', 'The data has been updated!','top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Warning!', data,'top-center','red', 'warning');
            }
        });

    });
    //Edit Account Type
    $('#update_member_account_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var account_type = $('#edit-account-type').val();
        var id = $('#editaccountType').attr('data-accountid');

        if (account_type == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please enter Account Type!','top-center','red', 'warning');
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        formData.append('type', 0);
        formData.append('id', id)
        var my_url = APP_URL + '/manage/updateMemberData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#EditAccountType').modal('hide');
                $.NotificationApp.send('Success!', 'The data has been updated!','top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Warning!',data,'top-center','red', 'warning');
            }
        });

    });
    // Edit Member Type
    $('#update_member_type_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var memberType = $('#edit-member-type').val();
        var id = $('#editmemberType').attr('data-memberid');

        if (memberType == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please enter Member Type!','top-center','red', 'warning');
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        formData.append('type', 1);
        formData.append('id', id)

        var my_url = APP_URL + '/manage/updateMemberData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#EditMemberType').modal('hide');
                $.NotificationApp.send('Success!', 'The data has been updated!','top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Warning!', data,'top-center','red', 'warning');
            }
        });

    });

    //time slot script  
    $('#upload_time_slot_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var staff = $('#apt_staff').val();
        var slot_date = $('#slot_date').val();
        var slot_time = $('#slot_time').val();
        if (staff == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please select staff!','top-center','red', 'warning');
            return false;
        }
        if (slot_date == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please select date!','top-center','red', 'warning');
            return false;
        }
        if (slot_time == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please enter time!','top-center','red', 'warning');
            return false;
        }

        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/timeSlotData';
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        //$("#hidetstext").css('display', 'none');
        //$(".timeSlotForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $(".timeSlotForm").css('display', 'none');
                $("#hidetstext").css('display', 'inline-block');
                $.NotificationApp.send('Success!', 'The time slot has been created!','top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Warning!', 'Something went wrong...!','top-center','red', 'warning');
            }
        });

    });

    //change password form script
    $('#change_password_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var current_password = $('#current_password').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        if (current_password == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please enter current password!','top-center','red', 'warning');
            return false;
        }
        if (new_password == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please enter new password!','top-center','red', 'warning');
            return false;
        }
        if (confirm_password == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Please enter confirm password!','top-center','red', 'warning');
            return false;
        }
        if (new_password != confirm_password) {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send('Warning!', 'Password did not mached!','top-center','red', 'warning');
            return false;
        }
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/changePassword';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $("#hidecptext").css('display', 'none');
        $(".changePassForm").css('display', 'inline-block');
        $.ajax({
            type:"POST",
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $(".changePassForm").css('display', 'none');
                $("#hidecptext").css('display', 'inline-block');
                if (data.status == 'password_changed') {
                    $.NotificationApp.send('Success!', 'The password has been changed!','top-center','green', 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 3500);
                } else if (data.status == 'incurrect_password') {

                    $.NotificationApp.send('Warning!', 'The current password is incorrect!','top-center','red', 'warning');
                    setTimeout(function(){
                        location.reload();
                    }, 3500);
                } else {
                    $.NotificationApp.send('Error!', 'Something went wrong, please try later!','top-center','red', 'error');
                    setTimeout(function(){
                        location.reload();
                    }, 3500);
                }

            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Error!', 'Something went wrong, please try later!','top-center','red', 'error');
            }
        });

    });

    //Prayer Request Upload
    $('#upload_request_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", false );
        var request = $('#request').val();
        // if (department == '') {
        //  swal('Warning!', 'Please enter request!', 'warning')
        //  return false;
        // }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/requestData';
        var type = "POST";
        $("#hidedpttext").css('display', 'none');
        $(".requestForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $(".requestForm").css('display', 'none');
                $("#hidedpttext").css('display', 'inline-block');
                // swal({
                //  title: "Success!",
                //  text: "The request " + request + " has been created!",
                //  type: "success"
                // }, function () {
                //  location.reload();
                // });
                $.NotificationApp.send("Success","The request has been created!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                // swal('Error!', data, 'error')
                $.NotificationApp.send("Error","Something Went wrong...","top-center","red","error");
            }
        });

    });

    $('#update_request_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var editrequest = $('#edit-request').val();
        if (editrequest == '') {
            $( ".btn" ).prop( "disabled", false );
            swal('Warning!', 'Please enter request name!', 'warning')
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/updateRequestData';
        var type = "POST";
        $(".editRequestForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#EditRequests').modal('hide');
                $(".editRequestForm").css('display', 'none');
                // swal({
                //  title: "Success!",
                //  text: "The request has been updated!",
                //  type: "success"
                // }, function () {
                //  location.reload();
                // });
                $.NotificationApp.send("Success","The request has been update!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                // swal('Error!', data, 'error')
                $.NotificationApp.send("error","Something Went wrong...","top-center","red","error");
            }
        });

    });

    //Bank details form script

    $('#upload_bank_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var account_no = $('#account_no').val();
        var account_holder_name = $('#account_holder_name').val();
        var bank_name = $('#bank_name').val();
        var bank_branch = $('#bank_branch').val();
        var ifsc_code = $('#ifsc_code').val();
        if (account_no == '' || account_holder_name == '' || bank_name == '' || bank_branch == '' || ifsc_code == '') {
            $( ".btn" ).prop( "disabled", false );
            $('#bank_error_text').show();
            return false;
        }

        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/bankDetailsData';
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        //$("#hidebanktext").css('display', 'none');
        //$(".bankForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#AddBanks').modal('hide');
                //$(".bankForm").css('display', 'none');
                //$("#hidebanktext").css('display', 'inline-block');
                $.NotificationApp.send('Success!', 'The bank details has been created!','top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Warning!',data,'top-center','red', 'warning');
                console.log('Error:', data);
            }
        });

    });

    $('#upload_razorpay_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var razorpay_key = $('#razorpay_key').val();
        var razorpay_secret_key = $('#razorpay_secret_key').val();
        if (razorpay_secret_key == '' || razorpay_key == '') {
            $( ".btn" ).prop( "disabled", false );
            $('#razorpay_error_text').show();
            return false;
        }

        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/razorPayData';
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        //$("#hiderazorPaytext").css('display', 'none');
        //$(".razorPayForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#AddRazorPay').modal('hide');
                //$(".razorPayForm").css('display', 'none');
                //$("#hiderazorPaytext").css('display', 'inline-block');
                $.NotificationApp.send('Success!', 'The RazorPay details has been created!','top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Warning!',data,'top-center','red', 'warning');
                console.log('Error:', data);
            }
        });

    });
    //sms templates script  
    $('#update_sms_data').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var formData = new FormData(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
    

        $.ajax({
            type: 'post',
            url: APP_URL + '/manage/update_sms_fields_data',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Success!', data.message,'top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            }
        })
    });

    $(document).on('click', '#saveMemberType', function (e) {
        e.preventDefault();
        //  e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var member_type = $('#member_type').val();
        if (member_type == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("error","Please enter member type","top-center","red","error");
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var my_url = APP_URL + '/manage/memberData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: JSON.stringify({
                member_type: member_type,
                type: 1
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Success!', "The Member details has been submited!",'top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);

            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("error",data,"top-center","red","error");
                swal('Error!', data, 'error')
            }
        });
    });

    $(document).on('click', '#saveSource', function (e) {
        e.preventDefault();
        //  e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var source = $('#source').val();
        if (source == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("error","Please enter source!","top-center","red","error");
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var my_url = APP_URL + '/manage/memberData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: JSON.stringify({
                source: source,
                type: 2
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Success!', "The Member details has been submited!",'top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
               
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("error",data,"top-center","red","error");
            }
        });
    });
    
    $(document).on('click', '#saveAccountType', function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var account_type = $('#account_type').val();
        if (account_type == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("error","Please enter account type!","top-center","red","error");
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }

        })
        // var formData =new FormData(this);
        var my_url = APP_URL + '/manage/memberData';
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: JSON.stringify({
                account_type: account_type,
                type: 0
            }),
            contentType: 'application/json',
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send('Success!', 'The Member details has been submited!','top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
        
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                console.log(data);
                $.NotificationApp.send("error",data,"top-center","red","error");
            }
        });
    });

    //update time slot script   
    $('#update_timeslot_form').submit(function (e) {
        e.preventDefault();
        $( ".btn" ).prop( "disabled", true );
        var update_slot_date = $('#edit_timeslot_date').val();
        var update_slot_time = $('#edit_timeslot_time').val();
        if (update_slot_date == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("error","Please enter slot date!","top-center","red","error");
           // swal('Warning!', 'Please enter slot date!', 'warning')
            return false;
        }
        if (update_slot_time == '') {
            $( ".btn" ).prop( "disabled", false );
            $.NotificationApp.send("error","Please enter slot time!","top-center","red","error");
            //swal('Warning!', 'Please enter slot time!', 'warning')
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/updateTimeSlotData';
        var type = "POST";
        //$("#hideetstext").css('display', 'none');
        //$(".editTimeSlotForm").css('display', 'inline-block');
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $('#EditTimeSlot').modal('hide');
                $.NotificationApp.send('Success!', 'The slot has been updated!','top-center','green', 'success');
                setTimeout(function(){
                    location.reload();
                }, 3500);
            },
            error: function (data) {
                $( ".btn" ).prop( "disabled", false );
                $.NotificationApp.send("error",data,"top-center","red","error");
                //swal('Error!', data, 'error')
            }
        });

    });


});    
</script>


@endsection