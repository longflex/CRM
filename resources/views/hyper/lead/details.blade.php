@extends('hyper.layout.master')
@section('title', "$lead->name")
@section('content')
@php
use \App\Http\Controllers\Crm\MembersController;
@endphp

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
                <h4 class="page-title">Staff Details</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-3">
            <div class="col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="sidebar -area">
                            <div class="float-right form-group dropdown">
                                

                                <a href="javascript:void(0);" class="dropdown-toggle arrow-none" role="button" id="vieweditdelete" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical font-20"></i>
                                </a>
                                <div class="dropdown-menu p-0 m-0" aria-labelledby="vieweditdelete">  
                                    <a class="btn btn-info dropdown-item" href="{{ route('Crm::lead_edit', ['id' => $lead->id]) }}">
                                        <i class="mdi mdi-account-edit"></i>&nbsp; Edit
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-warning  dropdown-item" onclick="destroyfunction({{ $lead->id }})">
                                        <i class="mdi mdi-delete"></i>&nbsp; Delete
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-success dropdown-item" onclick="convertedStatusUpdate({{ $lead->id }})">
                                        <i class="mdi mdi-tooltip-check-outline"></i>&nbsp; Converted
                                    </a>
                                </div>
                            </div>



                            <div class="form-group">
                                @if(!empty($lead->profile_photo))
                                <label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
                                        <img id="addUploadFile" class="img-fluid avatar-xl img-thumbnail rounded-circle" width="120" src="{{$lead->profile_photo}}">
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
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">     
                                        <img id="addUploadFile" class="img-fluid avatar-xl img-thumbnail rounded-circle" width="120" src="{{ asset('crm_public/images/select-profile.jpg') }}">

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
                            <h4 class="text-center mt-3">{{ $lead->name ?? '' }}</h4>
                            <div class="form-group">
                                <!-- <input type="text" data-type="name" class="form-control" value="{{ $lead->name ?? '' }}" name="data"> -->
                                <!-- <div class="icon_fixed"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></div> -->
                                <!-- <div style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></div> -->
                            </div>
                            <div class="text-center">
                                <a class="font-24 mx-1" href="javascript:void(0);" data-toggle="modal" data-target="#SMSModal"><i class="uil-comment-lines" data-toggle="tooltip" title="MESSAGES" data-placement="top"></i></a>
                                <a class="font-24 mx-1" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="APPOINTMENTS"><i class="uil-calendar-alt"></i></a>
                                <a class="font-24 mx-1" href="javascript:void(0);" data-toggle="modal" data-target="#LogCall" data-id="{{ $lead->id }}"><i class="uil-phone" data-toggle="tooltip" data-placement="top" title="CALLS"></i></a>
                                <a class="font-24 mx-1" href="javascript:void(0);" onclick="openDonationModal({{$lead->id}})"><i class="uil-usd-circle" data-toggle="tooltip" title="DONATIONS" data-placement="top"></i></a>
                                <a class="font-24 mx-1" href="javascript:void(0);" onclick="openPrayerModal()"  id="addNotePopup" data-id="{{ $lead->id }}" ><i class="uil-question-circle" data-toggle="tooltip" title="PRAYER REQUESTS" data-placement="top"></i></a>
                            </div>
                            <table class="table">
                                @if(!empty($lead->member_id))
                                <tr class="member _id">
                                    <td><i class="mdi mdi-card-account-details-outline"></i></td>
                                    <td>{{ $lead->member_id ?? '' }}</td>
                                </tr>
                                @endif
                                @if(!empty($lead->email))
                                <tr class="em ail">
                                    <td><i class="mdi mdi-email"></i></td>
                                    <td>{{ $lead->email ?? '' }}</td>
                                    <td style="display: none"><input type="text" data-type="email" class="form-control" value="{{ $lead->email ?? ''}}" name="data"></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                </tr>
                                @endif
                                <tr class="mobile _phone">
                                    <td><i class="uil-phone"></i></td>
                                    <td>{{ $lead->mobile ?? '' }}</td>
                                    <td style="display: none"><input type="text" data-type="mobile" class="form-control" value="{{ $lead->mobile ?? '' }}" name="data">
                                    </td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                </tr>
                                @if(!empty($lead->gender))
                                <tr class="ge nder">
                                    <td>{!! $lead->gender == 'Male' ? '<i class="mdi mdi-human-male"></i>' : '<i class="mdi mdi-human-female"></i>' !!}</td>
                                    <td>{{ $lead->gender ?? '' }}</td>
                                    <td style="display: none">
                                        <select class="form-control custom-select" id="gender" name="gender" data-type="gender">
                                            <option value="Male" {{ (old('gender',$lead->gender) == "Male" ? 'selected': '') }}>Male</option>
                                            <option value="Female" {{ (old('gender',$lead->gender) == "Female" ? 'selected': '') }}>Female</option>
                                        </select>
                                    </td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                </tr>
                                @endif
                                @if(!empty($lead->blood_group))
                                <tr class="blood _group">
                                    <td><i class="mdi mdi-blood-bag"></i></td>
                                    <td>{{ $lead->blood_group ?? '' }}</td>
                                    <td style="display: none">
                                        <select class="form-control custom-select" id="bldgrp" name="bldgrp" data-type="blood_group">
                                            <option value="A+" {{ (old('bldgrp',$lead->blood_group) == "A+" ? 'selected': '') }}>A+</option>
                                            <option value="B+" {{ (old('bldgrp',$lead->blood_group) == "B+" ? 'selected': '') }}>B+</option>
                                            <option value="O+" {{ (old('bldgrp',$lead->blood_group) == "O+" ? 'selected': '') }}>O+</option>
                                            <option value="O-" {{ (old('bldgrp',$lead->blood_group) == "O-" ? 'selected': '') }}>O-</option>
                                            <option value="A-" {{ (old('bldgrp',$lead->blood_group) == "A-" ? 'selected': '') }}>A-</option>
                                            <option value="B-" {{ (old('bldgrp',$lead->blood_group) == "B+" ? 'selected': '') }}>B-</option>
                                            <option value="AB+" {{ (old('bldgrp',$lead->blood_group) == "AB+" ? 'selected': '') }}>AB+</option>
                                            <option value="AB-" {{ (old('bldgrp',$lead->blood_group) == "AB-" ? 'selected': '') }}>AB-</option>
                                        </select>
                                    </td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                </tr>
                                @endif
                                @if(!empty($lead->date_of_birth) and $lead->date_of_birth!='0000-00-00')
                                <tr class="d ob">
                                    <td><i class="mdi mdi-cake"></i></td>
                                    <td>{{ date("jS F, Y", strtotime($lead->date_of_birth)) }}</td>
                                    <td style="display: none"><input type="date" data-type="date_of_birth" value="{{ $lead->date_of_birth ?? '' }}" name="data"></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                </tr>
                                @endif
                                @if(!empty($lead->date_of_joining) and $lead->date_of_birth!='0000-00-00')
                                <tr class="d oj">
                                    <td><i class="uil-briefcase"></i></td>
                                    <td>{{ date("jS F, Y", strtotime($lead->date_of_joining)) }}</td>
                                    <td style="display: none"><input type="date" data-type="date_of_joining" value="{{ $lead->date_of_joining ?? '' }}" name="data"></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                </tr>
                                @endif
                                @if(!empty($lead->married_status))
                                <tr class="married _status">
                                    <td><i class="mdi mdi-calendar-heart"></i></td>
                                    <td><span>{{ $lead->married_status ?? '' }}</span></td>
                                    <td style="display: none">
                                        <select class="form-control custom-select" id="married_status" name="married_status" data-type="married_status">
                                            <option value="Single" {{ (old('married_status',$lead->married_status) == "Single" ? 'selected': '') }}>
                                                Single</option>
                                            <option value="Married" {{ (old('married_status',$lead->married_status) == "Married" ? 'selected': '') }}>
                                                Married
                                            </option>
                                        </select>
                                    </td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-pencil-square-o" aria-hidden="true"></i></a></td>
                                    <td style="display: none"><a href="javascript:void(0);"><i class="uil-floppy-o" aria-hidden="true"></i></a></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div class="row" id="lead_id" data-id="{{ $lead->id }}">
                        @if(Laralum::loggedInUser()->su || Laralum::loggedInUser()->isReseller)
                        @if(!Laralum::loggedInUser()->RAZOR_KEY)
                        <div class="col-lg-12">
                            <h4><i class="uil-credit-card" aria-hidden="true"></i> Get paid faster with online payment gateways</h4>
                            <p>Setup a payment gateway and start acepting payments online.
                                <a href="{{ route('console::profile') }}#Payments" id="donationForm"><span id="hide_donation_text">Set up Now</span></a>
                            </p>
                        </div>
                        @endif
                        @endif
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs nav- bordered mb-3">
                                <li class="nav-item">
                                    <a href="#Activitiy" id="Activitiy-tab" data-toggle="tab" aria-expanded="false" class="nav-link"><span class="d-none d-md-block">ACTIVITY</span></a>
                                </li>
                                <!-- laralum.member.calllogs -->
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <li class="nav-item">
                                    <a href="#Logs" id="Logs-tab" class="nav-link active" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">CALL LOGS</span></a>
                                </li>
                                @endif
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <li class="nav-item">
                                    <a href="#Messages" id="Messages-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">MESSAGES</span></a>
                                </li>
                                @endif
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <!-- laralum.appointments.list -->
                                <li class="nav-item">
                                    <a href="#Appointments" id="Appointments-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">APPOINTMENTS</span></a>
                                </li>
                                @endif
                                <!-- 'laralum.donation.list'-->
                                @if(Laralum::hasPermission('laralum.donation.view'))
                                

                                <li class="nav-item">
                                    <a href="#Donations" id="Donations-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">DONATIONS</span></a>
                                </li>
          
                                @endif
                                <!-- laralum.member.list_prayer-->
                                @if(Laralum::hasPermission('laralum.lead.view')) 
                                <li class="nav-item">
                                    <a href="#Request" id="Request-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">PRAYER REQUEST</span></a>
                                </li>
                                @endif
                                <!-- laralum.member.list_prayer -->
                                @if(Laralum::hasPermission('laralum.lead.view')) 
                                <li class="nav-item">
                                    <a href="#Profile" id="Profile-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">PROFILE</span></a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane tab_status" id="Activitiy">
                                    <div class="table-responsive">
                                        <h4 class="text-muted text-center">No Data Found</h4>
                                    </div>
                                </div>
                                
                                <div class="tab-pane tab_status active" id="Logs">
                                    <div class="row">
                                        <div class="col-lg-12 mb-2">
                                            <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#LogCall"><i class="uil-phone mr-1"></i>Log Call</a>
                                        </div>
                                        <div class="col-lg-12">
                                            @if (count($manual_call_logs) > 0)
                                            <div class="col-lg-12 table-responsive">
                                                <table class="table w-100 dt-responsive nowrap" id="manualCallLogTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Attended By</th>
                                                            <th>Created Date</th>
                                                            <th>Description</th>
                                                            <th>Outcome</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                            @else
                                            <div class="col-lg-12">
                                                <i class="uil-phone-times font-24 text-primary"></i>
                                                <h5 class="header">
                                                    {{ trans('laralum.missing_title') }}
                                                </h5>
                                                <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "log call"]) }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane tab_status" id="Messages">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#SMSModal"><i class="uil-comment-lines mr-1"></i>Send SMS</a>
                                        </div>
                                        @if (count($msg_list) > 0)
                                        <div class="col-lg-12">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left" width="20%">Sender</th>
                                                        <th class="text-left">Message</th>
                                                        <th class="d-text-center" width="30%">Time</th>
                                                        <th class="d-text-center" width="10%">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($msg_list as $msg)
                                                    <tr>
                                                        <td class="text-left"><a href="javascript:void(0);" class="yellow-txt" data-html="true" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="<div class='media'><a href='javascript:void(0);' class='pull-left'><img src='{{ asset('crm_public/images/empty-image.jpg') }}' class='img-fluid profile-popover-img' /></a><div class='media-body'><P class='ml-2 mb-0'>{{ $msg->sender }}</p><P class='ml-2 mb-0'><i class='uil-mobile-alt yellow-txt'></i>&nbsp;{{ $msg->sender_mobile }}</p><p class='badge badge-info ml-2'>{{ $msg->sender_role }}</p></div></div>">{{ $msg->sender }}</a>
                                                        </td>
                                                        <td class="text-left">{{ substr($msg->message, 0,  25) }} <a href="javascript:void(0);" class="yellow-txt" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="{{ $msg->message }}"><i class="uil-ellipsis-h"></i></a>
                                                        </td>
                                                        <td class="text-center">{{ date('g:i A, F d Y', strtotime($msg->created_at) ) }}
                                                        </td>
                                                        <td class="text-center">{{ $msg->status }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{$msg_list->appends(['messages' => $msg_list->currentPage()])->links()}}
                                        </div>
                                        @else
                                        <div class="col-lg-12">
                                            <i class="uil-comment-alt-message font-24 text-primary"></i>
                                            <h5 class="header">
                                                {{ trans('laralum.missing_title') }}
                                            </h5>
                                            <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "message"]) }}</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane tab_status" id="Appointments">
                                    <div class="row">
                                        @if (count($appointments) > 0)
                                        <div class="col-lg-12 table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left" width="40%">Service Request</th>
                                                        <th class="d-text-center" width="20%">Date</th>
                                                        <th class="d-text-center" width="20%">Time</th>
                                                        <th class="d-text-center" width="20%">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($appointments as $appointment)
                                                    <tr>
                                                        <td class="text-left">
                                                            {{ $appointment->service_request }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ date('d/m/Y', strtotime($appointment->apt_date)) }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ date("g:i A", strtotime($appointment->time_slot)) }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if($appointment->status=='Pending')
                                                            <span class="badge badge-danger">{{ $appointment->status }}</span>
                                                            @else
                                                            <span class="badge badge-success">{{ $appointment->status }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            {{$appointments->appends(['appointments' => $appointments->currentPage()])->links()}}
                                        </div>
                                        @else
                                        <div class="col-lg-12">
                                            <i class="uil-comment-alt font-24 text-primary"></i>
                                            <h5>
                                                {{ trans('laralum.missing_title') }}
                                            </h5>
                                            <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "appointment"]) }}
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="tab-pane tab_status" id="Donations">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="text-right mb-2">
                                            <!-- <p><strong>Total Amount = </strong></p>  laralum.donation.create -->
                                                @if(Laralum::hasPermission('laralum.lead.view'))
                                                <button type="button" class="btn btn-primary">Total Amount =<span id="total_amount"></span></button>
                                                <button type="button" class="btn btn-primary" onclick="openDonationModal({{$lead->id}})"><i class="uil-plus-circle mr-1" aria-hidden="true"></i>ADD</button>
                                                <a href="{{ route('Crm::donation_export', ['member_id' => $memberId]) }}" class="btn btn-primary" id="ImportShow"><i class="uil-upload mr-1"></i><span>{{ trans('laralum.export') }}</span></a>
                                                @endif
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table dt-responsive nowrap w-100" id="donationDataTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Receipt No</th>
                                                            <th>Donation Type</th>
                                                            <th>Amount</th>
                                                            <th>Mode</th>
                                                            <th>Status</th>
                                                            <th>Donation Date</th>
                                                            <th>Created Date</th>
                                                            <th>Donation Purpose</th>
                                                            @if(Laralum::hasPermission('laralum.lead.view'))
                                                            <th>Actions</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <!-- <p><strong>Total Amount = </strong><span id="total_amount"></span></p> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane tab_status" id="Request">
                                    <div class="row">
                                        <div class="col-lg-12 text-right mb-2"><!-- laralum.member.add_prayer -->
                                            @if(Laralum::hasPermission('laralum.lead.view'))
                                            <button type="button" class="btn btn-primary" id="addNotePopup" data-id="{{ $lead->id }}" onclick="openPrayerModal()"><i class="uil-plus-circle mr-1" aria-hidden="true"></i>ADD</button>
                                            @endif
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="table-responsive">    
                                                <table class="table w-100 dt-responsive nowrap" id="prayerReqDatatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Created At</th>
                                                            <th>Taken By</th>
                                                            <th>Prayer Request</th>
                                                            <th>Follow up Date</th>
                                                            <th>Description</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane tab_status" id="Profile">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Account Details</h4>
                                            </div>
                                            <div class="col-md-12">
                                                @if(auth()->user()->ivr_access==1 && Laralum::hasPermission('laralum.member.makecall'))
                                                <!-- <a type="button" class="btn btn-lg btn-primary btn-theme" onclick="callFunction()">
                                                    <input type="hidden" id="member_mobile_number" value="{{ $lead->mobile }}">
                                                    <input type="hidden" id="caller_unique_id"
                                                        value="{{ auth()->user()->ivr_uuid }}">
                                                    <i class="fa fa-phone"></i>&nbsp;
                                                    <span id="call">Call</span>
                                                    <span id="calling" style="display: none;">
                                                        <img src="{{ asset('crm_public/images/calling.png') }}"
                                                            class="loading-img" />
                                                    </span>
                                                </a> -->
                                                @endif
                                                @if(Laralum::hasPermission('laralum.member.sendsms'))
                                                <!-- <button type="button" class="btn btn-lg btn-primary btn-theme" data-toggle="modal"
                                                    data-target="#SMSModal">
                                                    <i class="fa fa-comment"></i>&nbsp; Send SMS
                                                </button> -->
                                                @endif
                                                @if(!$lead->mobile_verified)
                                                <!-- <button type="button" id="verify_mobile" class="btn btn-lg btn-primary btn-theme"
                                                    data-mobile="{{$lead->mobile}}">
                                                    <i class="fa fa-phone"></i>&nbsp; Verify Number
                                                </button> -->
                                                @endif
                                                <div class="alert alert-success mt-2" id="calling_success_msg" style="display:none">
                                                </div>
                                                <div class="alert alert-danger mt-2" id="calling_error_msg" style="display:none">
                                                </div>
                                            </div>
                                            <!--payment-method-->
                                            @if(Laralum::loggedInUser()->su || Laralum::loggedInUser()->isReseller)
                                            @if(!Laralum::loggedInUser()->RAZOR_KEY)
                                            <div class="col-md-12">
                                                <h5><i class="uil-credit-card" aria-hidden="true"></i> Get paid faster with online payment gateways</h5>
                                                <p>Setup a payment gateway and start acepting payments online.
                                                    <a href="{{ route('console::profile') }}#Payments" id="donationForm"><span id="hide_donation_text">Set up Now</span></a>
                                                </p>
                                            </div>
                                            @endif
                                            @endif
                                            <!--payment-method-->
                                            @if(!empty($lead->account_type))
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <tr>
                                                        <th>Account Type</th>
                                                        <td>{{ $lead->account_type ?? '' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                            @if(!empty($lead->department))
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <tr>
                                                        <th>Department</th>
                                                        <td>{{ $lead->department}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                            @if(!empty($lead->member_type))
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <tr>
                                                        <th>Member Type</th>
                                                        <td>
                                                        {{-- @foreach(unserialize($lead->member_type) as $type)
                                                            <p>{{ $type}}</p>
                                                            @endforeach --}}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                            @if(!empty($lead->lead_source))
                                            <div class="col-md-12">
                                                <table class="table sidebar-table">
                                                    <tr>
                                                        <th>Lead Source</th>
                                                        <td>{{ $lead->lead_source ?? '' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                        </div>
                                        <!--Personal details-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Personal Details</h4>
                                            </div>
                                            @if(!empty($lead->rfid))
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>RFId</label>
                                                    <p>{{ $lead->rfid ?? '' }}</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <!--Personal details-->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                            <div class="col-md-12">
                                                <h3 class="form-heading">Additional Details</h3>
                                            </div>

                                            @if(!empty($lead->id_proof))
                                            <div class="col-md-12 text-center">
                                                <img src="{{ asset('crm/leads') }}/{{ $lead->id_proof }}" alt="" class="img-thumbnail mx-auto d-block img-fluid" id="selected_proof">
                                            </div>
                                            @endif
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Sms Required?</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" id="sms" name="sms" data-size="small" data-style="ios" data-toggle="toggle" data-on="YES" data-off="NO" {{$lead->sms_required?'checked':""}}>
                                                </div>
                                            </div>
                                            @if($lead->sms_required)
                                            <div class="col-md-12" style="display: block" id="sms_languages">
                                                <div class="form-group">
                                                    <label>Sms Language</label>
                                                    <select class="form-control custom-select" id='sms_lang' name="sms_language">
                                                        <option {{ old('sms_language', $lead->sms_language == 'English' ? 'selected': '') }}>
                                                            English</option>
                                                        <option {{ old('sms_language', $lead->sms_language == 'Telugu' ? 'selected': '') }}>
                                                            Telugu</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-md-12" style="display: none" id="sms_languages">
                                                <div class="form-group">
                                                    <label>Sms Language</label>
                                                    <select class="form-control custom-select" id='sms_lang' name="sms_language">
                                                        <option {{ old('sms_language', $lead->sms_language == 'English' ? 'selected': '') }}>
                                                            English</option>
                                                        <option {{ old('sms_language', $lead->sms_language == 'Telugu' ? 'selected': '') }}>
                                                            Telugu</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="col-md-12">
                                                <div class="form-group ">
                                                    <label>Call Required?</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="checkbox" data-size="small" data-toggle="toggle" data-style="ios" data-on="YES" data-off="NO" id="call" name="call" {{$lead->call_required?'checked':""}}>
                                                </div>
                                            </div>

                                            @if(!empty($lead->qualification))
                                            <div class="col-md-12 qualification">
                                                <table class="table sidebar-table">
                                                    <tr>
                                                        <th width="40%">Qualification</th>
                                                        <td width="60%">{{ $lead->qualification ?? '' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                            @if(!empty($lead->branch))
                                            <div class="col-md-12">
                                                <table class="table sidebar-table">
                                                    <tr>
                                                        <th width="40%">Branch</th>
                                                        <td width="60%">{{ $lead->branch ?? '' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif
                                            @if(!empty($lead->profession))
                                            <div class="col-md-12">
                                                <table class="table sidebar-table">
                                                    <tr>
                                                        <th width="40%">Profession</th>
                                                        <td width="60%">{{ $lead->profession ?? '' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            @endif

                                        </div>
                                        <!--address-details-->
                                       
                                        <!--address-details-->
                                        <!--family-details-->
                                        @if (count($family_member) > 0)
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="">Family Details</h4>
                                            </div>
                                            <div class="col-md-12">
                                                @foreach($family_member as $key => $members)
                                                <table class="table">
                                                    <tr>
                                                        <th><i class="uil-user"></i></th>
                                                        <td>{{ $members->member_relation_name ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="uil-heart"></i></th>
                                                        <td>{{ $members->member_relation ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="uil-calendar"></i></th>
                                                        <td>{{ ($members->member_relation_dob != '1970-01-01' && $members->member_relation_dob != '0000-00-00') ? date("jS F, Y", strtotime($members->member_relation_dob)) : ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th><i class="fas fa-phone"></i></th>
                                                        <td>{{ $members->member_relation_mobile ?? '' }}</td>
                                                    </tr>
                                                </table>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                        <!--family-details-->
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


<!-- Log Call Modal -->
<div id="LogCall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel"><i class="uil-phone mr-1" aria-hidden="true"></i>Log Call</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="manual_call_log_frm" action="javascript:void(0)">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Contacted</label>
                                <select class="form-control" data-selectron-search="false" id="member_id" name="member_id" required>
                                    <option value="{{ $lead->id }}" selected>{{ $lead->name ?? '' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Outcome</label>
                                <select class="form-control" data-selectron-search="false" id="outcome" name="outcome" required>
                                    <option value="Busy">Busy</option>
                                    <option value="Connected">Connected</option>
                                    <option value="Left Live Message">Left live message</option>
                                    <option value="Left Voicemail">Left voicemail</option>
                                    <option value="No Answer">No answer</option>
                                    <option value="Wrong Number">Wrong number</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" readonly class="form-control inp- date-time" id="log_date" name="log_date" required />
                                <small id="log_date_error text-danger">Please Choose Date...</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Time</label>
                                <input type="text" readonly class="form-control input-sm" data-toggle='timepicker' data-show-meridian="false" id="log_duration" name="log_duration" required>
                                <!-- <div class="input-group-append">
                                    <span class="input-group-text"><i class="dripicons-clock"></i></span>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control log-inp-txt" placeholder="Add description" id="log_description" name="log_description" required></textarea><small id="log_description_error text-danger">Please add description.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" id="addCallLogForm" class="btn btn-success">Log Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Log Call Modal -->
<div id="LogCall" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel"><i class="uil-phone mr-1" aria-hidden="true"></i>Log Call</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="manual_call_log_frm" action="javascript:void(0)">@csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Contacted</label>
                                <select class="form-control" data-selectron-search="false" id="member _id" name="member_id" required>
                                    <option value="{{ $lead->id }}" selected>{{ $lead->name ?? '' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Outcome</label>
                                <select class="form-control" data-selectron-search="false" id="out come" name="outcome" required>
                                    <option value="busy">Busy</option>
                                    <option value="connected">Connected</option>
                                    <option value="left_live_message">Left live message</option>
                                    <option value="left_voicemail">Left voicemail</option>
                                    <option value="no_answer">No answer</option>
                                    <option value="wrong_answer">Wrong number</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" class="form-control inp- date-time" id="log _date" name="log_date" required />
                                <small id="log_date_error text-danger">Please Choose Date...</small>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Time</label>
                                <input type="time" class="form-control inp -date-time" id="log _duration" name="log_duration" required />
                                <small id="log_duration_error text-danger">Please enter duration.</small>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control log-inp-txt" placeholder="Add description" id="log_ description" name="log_description" required></textarea><small id="log_description_error text-danger">Please add description.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" id="addCallLogForm" class="btn btn-success">Log Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SMS Modal -->
<div id="SMSModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="sendsmsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="sendsmsModalLabel"><i class="uil-comment mr-1"></i>SEND SMS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form> @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="text-left text-remain" id="rtext"><small><span id="rchars">250</span> Character(s) Remaining</small></div>
                        <textarea class="form-control" rows="3" id="msg_str" placeholder="Type a message" required></textarea>
                        <div class="text-left text-danger" id="show_msg_str_error">This field is required.</div>
                        <input type="hidden" id="receiver_mobile" value="{{ $lead->mobile }}" />
                        <input type="hidden" id="receiver_id" value="{{ $lead->id }}" />
                        <input type="hidden" id="sender_id" value="{{ auth()->user()->id }}" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success" id="send_message">SEND</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Details Modal -->
<div id="AddDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addDetailsModalLabel">Add Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="add_detail" action="javascript:void(0)">@csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Add Detail</label>
                        <input type="text" name="detail" id="detail" class="form-control" />
                        <input type="hidden" name="type" id="detail_type" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editMemberForm" class="btn btn-success btn-sm"><span id="hidebutext">Add</span>&nbsp;<span class="editMemberForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Otp modal -->
<div id="EnterOTP" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Verify Otp</h4>
            </div>
            <form method="POST" enctype="multipart/form-data" id="otp_form" action="javascript:void(0)">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Enter OTP</label>
                        <input type="number" name="otp" id="otp" class="form-control" />
                        <small id="show_otp_error" style="color:#FF0000;display:none;">Please enter
                            OTP</small>

                        <input type="hidden" name="receiver_mobile" placeholder="Enter Otp" id="receiver_mobile" class="form-control" />
                    </div>
                    <div class="form-group">
                        <button type="submit" id="editMemberForm" class="ui teal submit button"><span id="hidebutext">Verify</span>&nbsp;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Donation modal -->
<div id="AddDonation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="adddanationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="adddanationModalLabel">Add Donation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="upload_donation_form" action="javascript:void(0)">    
                <div class="modal-body">
                    <input type="hidden" id="lead_id" name="lead_id" value="{{ $lead->id }}" />
                    <div class="lead_data" style="display:none;"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Donation Type<span class="text-danger">*</span></label>
                                <select id="member_type_id" name="donation_type" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    @foreach($membertypes as $type)
                                    <option value="{{ $type->type }}" {{ (old('donation_type') == $type->type ? 'selected': '') }}>
                                        {{ $type->type }}
                                    </option>
                                    @endforeach
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Donation Purpose<span class="text-danger">*</span></label>
                                <select id="donation_purpose" name="donation_purpose" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    @foreach($donation_purposes as $purpose)
                                    <option value="{{ $purpose->id }}" {{ (old('donation_purpose') == $purpose->id ? 'selected': '') }}>
                                        {{ $purpose->purpose }}
                                    </option>
                                    @endforeach
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>When Will Donate</label>
                                <select id="donation_decision" name="donation_decision" class="form-control select2" onchange="decisionChange(this)" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    <option value="0" {{ (old('donation_decision') == 0 ? 'selected': '') }}>
                                        Now</option>
                                    <option value="1" {{ (old('donation_decision') == 1 ? 'selected': '') }}>Will Donate</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6" id="will_donate_type_div" style="display: none;">
                            <div class="form-group">
                                <label>Willing To Donate</label>
                                <select id="donation_decision_type" name="donation_decision_type" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    <option value="As soon As Possible" {{ (old('donation_decision') == 'As soon As Possible' ? 'selected': '') }}>
                                        As soon As Possible</option>
                                    <option value="This Week" {{ (old('donation_decision') == 'This Week' ? 'selected': '') }}>This Week</option>
                                    <option value="This Year" {{ (old('donation_decision') == 'This Year' ? 'selected': '') }}>This Year</option>
                                    <option value="Next Year" {{ (old('donation_decision') == 'Next Year' ? 'selected': '') }}>Next Year</option>
                                    <option value="online" {{ (old('donation_decision') == "online" ? 'selected': '') }}>online</option>
                                    <option value="Jan" {{ (old('donation_decision') == "Jan" ? 'selected': '') }}>Jan</option>
                                    <option value="Feb" {{ (old('donation_decision') == "Feb" ? 'selected': '') }}>Feb</option>
                                    <option value="Mar" {{ (old('donation_decision') == "Mar" ? 'selected': '') }}>Mar</option>
                                    <option value="Apr" {{ (old('donation_decision') == "Apr" ? 'selected': '') }}>Apr</option>
                                    <option value="May" {{ (old('donation_decision') == "May" ? 'selected': '') }}>May</option>
                                    <option value="Jun" {{ (old('donation_decision') == "Jun" ? 'selected': '') }}>Jun</option>
                                    <option value="July" {{ (old('donation_decision') == "July" ? 'selected': '') }}>July</option>
                                    <option value="Aug" {{ (old('donation_decision') == "Aug" ? 'selected': '') }}>Aug</option>
                                    <option value="Sep" {{ (old('donation_decision') == "Sep" ? 'selected': '') }}>Sep</option>
                                    <option value="Oct" {{ (old('donation_decision') == "Oct" ? 'selected': '') }}>Oct</option>
                                    <option value="Nov" {{ (old('donation_decision') == "Nov" ? 'selected': '') }}>Nov</option>
                                    <option value="Dec" {{ (old('donation_decision') == "Dec" ? 'selected': '') }}>Dec</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6" id="donation_date_div" style="display: none;">
                            <div class="form-group">
                                <label for="donation_date">Donation Date</label>
                                <input type="text" readonly class="form-control" id="donation_date" name="donation_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Type<span class="text-danger">*</span></label>
                                <select id="payment_type" name="payment_type" class="form-control select2" onchange="stateChange(this)" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    <option value="single" {{ (old('payment_type') == 'single' ? 'selected': '') }}>
                                        Single</option>
                                    <option value="recurring" {{ (old('payment_type') == 'recurring' ? 'selected': '') }}>Recurring</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Payment Mode<span class="text-danger">*</span></label>
                                <select id="payment_mode" name="payment_mode" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    <option value="CASH">Cash</option>
                                    <option value="CARD">Card</option>
                                    <option value="CHEQUE">Cheque</option>
                                    @if($razorKey)
                                    <option value="Razorpay">Razorpay</option>
                                    @endif
                                    {{-- <option value="GOOGLEPAY">GooglePay</option> --}}
                                    {{-- <option value="PHONEPAY">PhonePay</option> --}}
                                    <option value="QRCODE">QR code</option>
                                    <option value="OTHER">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 payment-status" style="display: none">
                            <div class="form-group">
                                <label>Payment Status<span class="text-danger">*</span></label>
                                <select id="payment_status" name="payment_status" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    <option value="0">Not Paid</option>
                                    <option value="1">Paid</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>Location</label>
                                <select class="form-control select2" name="location" id="location" data-toggle="select2" data-placeholder="Please select..">
                                    <option value="">Please select..</option>
                                    @foreach($branches as $branch)
                                    <option value="{{ $branch->branch }}" {{ (old('location') == $branch->branch ? 'selected': '') }}>
                                        {{ $branch->branch }}
                                    </option>
                                    @endforeach
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="amount" placeholder="Please enter the amount" name="amount" />
                            </div>
                        </div> 
                        <div class="col-md-6 period" style="display: none">
                            <div class="form-group">
                                <label>Payment Period<span class="text-danger">*</span></label>
                                <select id="payment_period" name="payment_period" class="form-control select2">
                                    <option value="">Please select..</option>
                                    <option value="daily">daily</option>
                                    <option value="weekly">weekly</option>
                                    <option value="monthly">monthly</option>
                                    <option value="yearly">yearly</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 start" style="display: none">
                            <div class="form-group">
                                <label>Payment Start Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="payment_start_date" value="{{old('start_date')}}" />
                            </div>
                        </div>
                        <div class="col-md-6 end" style="display: none">
                            <div class="form-group">
                                <label>Payment End Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="payment_end_date" value="{{old('end_date')}}" />
                            </div>
                        </div>
                        <div class="col-md-6" id="reference_no_field" style="display:none">
                            <div class="form-group">
                                <label>Reference No.<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Please enter the reference no" />
                            </div>
                        </div>
                        <div class="col-md-6" id="bank_name_field" style="display:none">
                            <div class="form-group">
                                <label>Bank<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Please enter the bank name" />
                            </div>
                        </div>
                        <div class="col-md-6" id="cheque_number_field" style="display:none">
                            <div class="form-group">
                                <label>Cheque Number<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cheque_number" name="cheque_number" placeholder="Please enter the check no." />
                            </div>
                        </div>
                        <div class="col-md-6" id="branch_name_field" style="display:none">
                            <div class="form-group">
                                <label>Branch<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Please enter the branch name" />
                            </div>
                        </div>
                        <div class="col-md-6" id="cheque_date_field" style="display:none">
                            <div class="form-group">
                                <label>Cheque Issue Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="cheque_date" name="cheque_date" placeholder="Please select the cheque issue date" />
                            </div>
                        </div>
                        <div class="col-md-6" id="payment_method_field" style="display:none">
                            <div class="form-group">
                                <label>Payment Method<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="payment_method" name="payment_method" placeholder="Please enter the method name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Gift Issued</label>
                                <select id="gift_issued" name="gift_issued" class="form-control select2">
                                    <option value="">Please select..</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="submit" id="donationForm" class="btn btn-success"><span id="hide_donation_text">{{ trans('laralum.save') }}</span>&nbsp;<span class="donationForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                        </button> --}}
                        <button type="submit" id="" class="btn btn-success btn-sm">SAVE</button>
                    </div>
                    <div class="history_data" style="display:none;"></div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Add Note modal -->
<div id="AddNote" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addnoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addnoteModalLabel"><i class="uil-question-circle mr-1"></i>Add Request</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form id="prayer_req_save">@csrf
                <div class="modal-body">
                    <input type="hidden" id="member_id" name="member_id" value="{{ $lead->id }}"/>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="follow_up_date">Follow up Date</label>
                                <input type="text" readonly  class="form-control" value="" id="follow_up_date" name="follow_up_date">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="create_at">Prayer Request<span class="text-danger">*</span></label>
                                <select class="form-control select2" name="issue" id="issue"  data-toggle="select2" data-placeholder="Please select.." required>
                                    <option value="">Please select..</option>
                                    @foreach($prayer_requests as $issue)
                                    <option value="{{ $issue->prayer_request }}">{{ $issue->prayer_request }}</option>
                                    @endforeach
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="" class="btn btn-success btn-sm">SAVE</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Prayer Request Edit Note modal -->

<div id="prayerRquestEditModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="topModalLabel">Prayer Request Edit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="editPrayerRequestForm" action="javascript:void(0)">
                <input type="hidden" id="prayerRequestEditId" name="prayerRequestEditId" value=""/>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="follow_up_date">Follow up Date</label>
                                <input type="text" class="form-control" value="" id="edit_follow_up_date" name="edit_follow_up_date">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="create_at">Prayer Request</label>
                                <select class="form-control select2" name="edit_issue" id="edit_issue"  data-toggle="select2" data-placeholder="Please select.." required>
                                    <option value="">Please select..</option>
                                    @foreach($prayer_requests as $issue)
                                    <option value="{{ $issue->prayer_request }}">{{ $issue->prayer_request }}</option>
                                    @endforeach
                                    <option value="add">Add Value</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="edit_description" id="edit_description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" id="editprForm" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Note modal -->
<div id="EditNote" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editnoteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editnoteModalLabel"><i class="uil-question-circle mr-1"></i>Edit Note</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="update_note_form" action="javascript:void(0)">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <input type="hidden" id="issues_id" name="issues_id" />
                    <div class="form-group">
                        <select class="form-control select2" id="update_status" name="update_status">
                            <option value="">Select status</option>
                            <option value="1">Resolved</option>
                            <option value="2">Pending</option>
                        </select>
                        <small id="show_update_status_error text-danger">Please select
                            status</small>
                    </div>
                    <div class="form-group">
                        <textarea placeholder="Write note here.." class="form-control" id="update_issues" name="update_issues"></textarea>
                        <small id="show_update_issue_error text-danger">Please enter note</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editNoteForm" class="btn btn-success btn-sm"><span id="hide_update_note_text">UPDATE</span>&nbsp;<span class="editNoteForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--add Prayer Request Modal-->
<div id="addRequestsModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="topModalLabel">Add Prayer Request Type</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="upload_request_form"
                action="javascript:void(0)">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Prayer Request</label>
                        <input type="text" class="form-control" data-provide="typeahead" id="prayer_request_modal" name="prayer_request" placeholder="Enter Request">
                        <input type="hidden" name="modal_type" id="modal_type">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" id="requestForm" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('extrascripts')

<script>

function openPrayerModal(){
    $('#follow_up_date').val('');
    $('#issue').val(null).trigger('change');
    $('#description').val('');
    $('#AddNote').modal('show');
}
  
function openDonationModal(lead_id){
    $('#member_type_id').val(null).trigger('change');
    $('#donation_purpose').val(null).trigger('change');
    $('#donation_decision').val(null).trigger('change');
    $('#donation_decision_type').val(null).trigger('change');
    $('#payment_mode').val(null).trigger('change');
    $('#payment_status').val(null).trigger('change');
    $('#location').val(null).trigger('change');
    $('#gift_issued').val(null).trigger('change');
    $('#payment_type').val(null).trigger('change');
    $('#payment_period').val(null).trigger('change');
    $('#donation_date').val('');
    $('#amount').val('');
    $('#start_date').val('');
    $('#end_date').val('');
    $('#reference_no').val('');
    $('#bank_name').val('');
    $('#cheque_number').val('');
    $('#branch_name').val('');
    $('#cheque_date').val('');
    $('#payment_method').val('');

    $('#AddDonation').modal('show');
}



$(function() {
  $('input[name="follow_up_date"]').daterangepicker({
    singleDatePicker: true,
    //autoApply: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  // }, function(start, end, label) {
  //   var years = moment().diff(start, 'years');
  //   alert("You are " + years + " years old!");
  });
  $('input[name="follow_up_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});

$(function() {
  $('input[name="log_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="log_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});

$(function() {
  $('input[name="donation_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="donation_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});

$(function() {
  $('input[name="edit_follow_up_date"]').daterangepicker({
    singleDatePicker: true,
    //autoApply: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  // }, function(start, end, label) {
  //   var years = moment().diff(start, 'years');
  //   alert("You are " + years + " years old!");
  });
  $('input[name="edit_follow_up_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});
</script>
<script>
function convertedStatusUpdate(id){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
        $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url:  "{{route('Crm::leadConvertedStatusUpdate')}}",
                    data:{id:id} ,
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true
                })
                // using the done promise callback
                .done(function(data) {
                    if(data.status==false){
                        $.NotificationApp.send("Error",data.message,"top-center","red","error");
                        setTimeout(function(){
                            //location.reload();
                        }, 3500);
                    
                    }

                    if(data.status==true){
                        
                        $.NotificationApp.send("Success",data.message,"top-center","green","success");
                        setTimeout(function(){
                            location.reload();
                            //var url = "{{route('Crm::leads')}}";
                            //location.href=url;
                        }, 3500);
                    }

                })
                // using the fail promise callback
                .fail(function(data) {
                    $.NotificationApp.send("Error",data.message,"top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                });
            
    }    
$("#uploadFile").change(function(){
  event.preventDefault();
  var id="{{$memberId}}";
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
      formData.append("id", id);  
      $.ajax({
      type:'POST',
      url: "{{route('Crm::leads_detail_uploadFile')}}",
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
    
    $('#addedFile').html('<img class="img-fluid avatar-xl img-thumbnail rounded-circle" width="120" src="'+data+'">');
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
</script>
<script>
$("#upload_donation_form").submit(function(event){
    event.preventDefault();
    $( ".btn" ).prop( "disabled", true );
    	var name = $('#name').val();
		var email = $('#email').val();
		var phone = $('#phone').val();
		var address = $('#address').val();
		
		//doantion var
		var donation_type = $('#donation_type').val();
		var payment_mode = $('#payment_mode').val();
		var amount = $('#amount').val();
		var reference_no = $('#reference_no').val();
		var bank_name = $('#bank_name').val();
		var cheque_number = $('#cheque_number').val();
		var branch_name = $('#branch_name').val();
		var cheque_date = $('#cheque_date').val();
		var donation_purpose = $('#donation_purpose').val();
		
		var searched_member_id = $('#searched_member_id').val();
		var donation_decision = $('#donation_decision').val();
		if(searched_member_id==""){
   //          if(payment_mode=="CHEQUE"){			
			// 	if(name=='' || email=='' || phone=='' || address=='' || donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
   //                 //swal('warning!','All (*) mark fields are mandatory.','error')
   //                 $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
			// 	  return false;
			// 	}
			// }else if(payment_mode=="QRCODE"){
			// 	if(name=='' || email=='' || phone=='' || address=='' || amount=='' || reference_no==''){
   //                // swal('warning!','All (*) mark fields are mandatory.','error')
   //                $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
			// 	  return false;
			// 	}
			// }else{
			// 	if(name=='' || email=='' || phone=='' || address=='' || amount==''){
   //                 //swal('warning!','All (*) mark fields are mandatory.','error')
   //                 $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
			// 	  return false;
			// 	}
			// }
        }else{
			if(donation_decision=="Now"){
                if(payment_mode=="CHEQUE"){         
                    if(donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
                       //swal('warning!','All (*) mark fields are mandatory.','error')
                       $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
                       $( ".btn" ).prop( "disabled", false );
                      return false;
                    }
                }else if(payment_mode=="QRCODE"){
                    if(amount=='' || reference_no==''){
                       //swal('warning!','All (*) mark fields are mandatory.','error')
                       $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
                       $( ".btn" ).prop( "disabled", false );
                      return false;
                    }
                }else{
                    // if(amount==''){
                    //    //swal('warning!','All (*) mark fields are mandatory.','error')
                    //    $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
                    //   return false;
                    // }
                }
            }
		}
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $("#hide_donation_text").css('display','none');
    $(".donationForm").css('display','inline-block');
    var formData=new FormData(this);
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url:  "{{route('Crm::donation_store')}}",
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
            setTimeout(function(){
                //location.reload();
            }, 3500);
            $( ".btn" ).prop( "disabled", false );
        }

        if(data.status==true){
            $(".donationForm").css('display','none');
            $("#hide_donation_text").css('display','inline-block');	
            $.NotificationApp.send("Success","The donation has been created!","top-center","green","success");
            setTimeout(function(){
                //location.reload();
                //var url = "{{route('Crm::leads')}}";
                //location.href=url;
            }, 3500);
            $( ".btn" ).prop( "disabled", false );
            $('#AddDonation').modal('hide');
            
            $('#member_type_id').val(null).trigger('change');
            $('#donation_purpose').val(null).trigger('change');
            $('#donation_decision').val(null).trigger('change');
            $('#donation_decision_type').val(null).trigger('change');
            $('#payment_mode').val(null).trigger('change');
            $('#payment_status').val(null).trigger('change');
            $('#location').val(null).trigger('change');
            $('#gift_issued').val(null).trigger('change');
            $('#payment_type').val(null).trigger('change');
            $('#payment_period').val(null).trigger('change');
            $('#donation_date').val('');
            $('#amount').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            $('#reference_no').val('');
            $('#bank_name').val('');
            $('#cheque_number').val('');
            $('#branch_name').val('');
            $('#cheque_date').val('');
            $('#payment_method').val('');

            donationDataTable();  
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

</script>
<script type="text/javascript">
//Donations form scripts
// $('#upload_donation_form').submit(function(e) {
// 	    e.preventDefault();	
// $("#upload_donation_form").submit(function(event){
//     event.preventDefault();alert(4444444);return;
//     $.ajaxSetup({
//         headers: {
//         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//         }
//     })
    	
// 		var name = $('#name').val();
// 		var email = $('#email').val();
// 		var phone = $('#phone').val();
// 		var address = $('#address').val();
		
// 		//doantion var
// 		var donation_type = $('#donation_type').val();
// 		var payment_mode = $('#payment_mode').val();
// 		var amount = $('#amount').val();
// 		var reference_no = $('#reference_no').val();
// 		var bank_name = $('#bank_name').val();
// 		var cheque_number = $('#cheque_number').val();
// 		var branch_name = $('#branch_name').val();
// 		var cheque_date = $('#cheque_date').val();
		
		
// 		var searched_member_id = $('#searched_member_id').val();
		
// 		if(searched_member_id==""){
//             if(payment_mode=="CHEQUE"){			
// 				if(name=='' || email=='' || phone=='' || address=='' || donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
//                    //swal('warning!','All (*) mark fields are mandatory.','error')
//                    $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
// 				  return false;
// 				}
// 			}else if(payment_mode=="QRCODE"){
// 				if(name=='' || email=='' || phone=='' || address=='' || amount=='' || reference_no==''){
//                   // swal('warning!','All (*) mark fields are mandatory.','error')
//                   $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
// 				  return false;
// 				}
// 			}else{
// 				if(name=='' || email=='' || phone=='' || address=='' || amount==''){
//                    //swal('warning!','All (*) mark fields are mandatory.','error')
//                    $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
// 				  return false;
// 				}
// 			}
//         }else{
// 			if(payment_mode=="CHEQUE"){			
// 				if(donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
//                    //swal('warning!','All (*) mark fields are mandatory.','error')
//                    $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
// 				  return false;
// 				}
// 			}else if(payment_mode=="QRCODE"){
// 				if(amount=='' || reference_no==''){
//                    //swal('warning!','All (*) mark fields are mandatory.','error')
//                    $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
// 				  return false;
// 				}
// 			}else{
// 				if(amount==''){
//                    //swal('warning!','All (*) mark fields are mandatory.','error')
//                    $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
// 				  return false;
// 				}
// 			}
// 		}			
// 		var formData = new FormData(this);
// 		var my_url = {{ route('Crm::donation_store') }} ;
// 		var type = "POST"; 
// 		// $.ajaxSetup({
// 		//    headers: {
// 		// 		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
// 		//  }
// 		// })
// 		$("#hide_donation_text").css('display','none');
// 	    $(".donationForm").css('display','inline-block');			    
// 		$.ajax({
// 			type: type,
// 			url: my_url,
// 			data: formData,
// 			processData: false,
//             contentType: false,
// 			success: function (data) {
// 				$(".donationForm").css('display','none');
//                 $("#hide_donation_text").css('display','inline-block');	
//                 $.NotificationApp.send("Success","The donation has been created!","top-center","green","success");		    
// 				//swal({ title: "Success!", text: "The donation has been created!", type: "success" }, function(){ 
// 				   //location.reload();
// 				//});			    				
// 			},
// 			error: function (data) {
// 				console.log('Error:', data);
// 			}
// 		});
		 
// 	});	
function destroyPrayerRequest(id) {
    var dataid = id;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You want to delete this Prayer Request !!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: "{{ route('Crm::destroyPrayerRequest') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id" : dataid
                },
                success: function (data) {
                    $.NotificationApp.send("Success","Prayer Request has been deleted.","top-center","green","success");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                    prayerReqDatatable();
                }, error: function (data) {
                    $.NotificationApp.send("Error","Prayer Request has not been deleted.","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                    prayerReqDatatable();
                },
            });
        } else if ( result.dismiss === Swal.DismissReason.cancel ) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Prayer Request not deleted !',
                'error'
            )
            prayerReqDatatable();
        }
    });
}
$("#editPrayerRequestForm").submit(function(event){
    event.preventDefault();
    $( ".btn" ).prop( "disabled", true );
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    var formData=new FormData(this);
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url:  "{{route('Crm::prayerRequestUpdate')}}",
        data:formData ,
        dataType: 'json', // what type of data do we expect back from the server
        processData: false,
        contentType: false,
        dataType: 'json',
    })
    // using the done promise callback
    .done(function(data) {
        $( ".btn" ).prop( "disabled", false );
        if(data.status==false){
            $.NotificationApp.send("Error",data.message,"top-center","red","error");
            setTimeout(function(){
                //location.reload();
            }, 3500);
            prayerReqDatatable();
        }

        if(data.status==true){
            $( ".btn" ).prop( "disabled", false );
            $('#prayerRquestEditModal').modal('hide'); 
            $.NotificationApp.send("Success",data.message,"top-center","green","success");
            setTimeout(function(){
                //location.reload();
                
            }, 3500);
            prayerReqDatatable();
        }

    })
    // using the fail promise callback
    .fail(function(data) {
        $( ".btn" ).prop( "disabled", false );
        $.NotificationApp.send("Error",data.message,"top-center","red","error");
        setTimeout(function(){
            //location.reload();
        }, 3500);
        prayerReqDatatable();
    });

})

function prayerRquestEditModal(id){
    $('#prayerRequestEditId').val(id);
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url:  "{{route('Crm::prayerRequestEdit')}}",
            data:{id:id} ,
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        // using the done promise callback
        .done(function(data) {
            if(data.status==true){
                //console.log(data);
                $('.optn').removeAttr('selected');
                $('#edit_follow_up_date').val(data.message.follow_up_date);
                //$('#edit_issue').prop('selectedIndex',0);
                //$('#edit_issue [value='+data.message.issue+']').attr('selected', true);
                $('#edit_description').val(data.message.description);
                $('#edit_issue').val(data.message.issue); // Select the option with a value of '1'
                $('#edit_issue').trigger('change'); // Notify any JS components that the value changed
            }
            $('#prayerRquestEditModal').modal('show');               
            })
            
        // using the fail promise callback
        .fail(function(data) {
            console.log(data);
        });
}


function prayerStatusUpdate(id){
  //var checkBoxes=$("#switch1").prop("checked");
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    //if(checkBoxes){
        $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url:  "{{route('Crm::prayer_requestStatusUpdate1')}}",
                    data:{id:id} ,
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true
                })
                // using the done promise callback
                .done(function(data) {
                    if(data.status==false){
                        $.NotificationApp.send("Error",data.message,"top-center","red","error");
                        setTimeout(function(){
                            //location.reload();
                        }, 3500);
                    
                    }

                    if(data.status==true){
                        
                        $.NotificationApp.send("Success",data.message,"top-center","green","success");
                        setTimeout(function(){
                            //location.reload();
                            //var url = "{{route('Crm::leads')}}";
                            //location.href=url;
                        }, 3500);
                        prayerReqDatatable();
                    }

                })
                // using the fail promise callback
                .fail(function(data) {
                    $.NotificationApp.send("Error",data.message,"top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                });

            
    // }else{
    //     $.ajax({
    //                 type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
    //                 url:  "{{route('Crm::prayer_requestStatusUpdate2')}}",
    //                 data:{id:id} ,
    //                 dataType: 'json', // what type of data do we expect back from the server
    //                 encode: true
    //             })
                
    //             // using the done promise callback
    //             .done(function(data) {
    //                 if(data.status==false){
    //                     $.NotificationApp.send("Error",data.message,"top-center","red","error");
    //                     setTimeout(function(){
    //                         //location.reload();
    //                     }, 3500);
                    
    //                 }

    //                 if(data.status==true){
    //                     $.NotificationApp.send("Success",data.message,"top-center","green","success");
    //                     setTimeout(function(){
    //                         //location.reload();
    //                         //var url = "{{route('Crm::leads')}}";
    //                         //location.href=url;
    //                     }, 3500);
    //                     prayerReqDatatable();
    //                 }

    //             })
    //             // using the fail promise callback
    //             .fail(function(data) {
    //                 $.NotificationApp.send("Error",data.message,"top-center","red","error");
    //                 setTimeout(function(){
    //                     //location.reload();
    //                 }, 3500);
    //             });

            
    //     }
    } 
    function destroyfunction(id) {
        var dataid = id;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You want to delete this ??",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('Crm::lead.delete') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id" : dataid
                    },
                    success: function (data) {
                        $.NotificationApp.send("Success","Successfully Deleted.","top-center","green","success");
                        setTimeout(function(){
                            window.location.href = "{{ route('Crm::leads') }}";
                        }, 5000);
                    }, error: function (data) {
                        $.NotificationApp.send("Error","Delete Unsuccessful.","top-center","red","error");
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    },
                });
            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Not deleted !',
                    'error'
                )
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // window.setInterval(function() {
        //     var mobile = "{{ $lead->mobile }}";
        //     $.ajax({
        //         url: "{{ route('incoming.call.log') }}",
        //         type: "GET",
        //         data: { mobile : mobile },
        //         success: function(data) {
        //             if (data.call == true) {
        //                 $('#Showcall').css("display", "block");
        //                 $('#Dialer').css("display", "none");
        //                 $('#CALLEND').data("id", "end");
        //                 $('#CALLEND').removeClass('btn-success');
        //                 $('#CALLEND').addClass('btn-danger');
        //                 $('#CALLING').css("display", "none");
        //                 $('#CALLING').html('<i class="uil-dialpad-alt"></i>');
        //                 $('#CALLING').attr("data-original-title", "Manual Calling");
        //                 $('#CALLEND').attr("data-original-title", "End Call");
        //                 $('#CALLEND').html('<i class="uil-phone-slash"></i>');
        //                 $("#DIS").slideToggle("slow", "linear");
        //                 $('#call-title').html('Incoming Call ... <i class="uil-incoming-call"></i>');
        //                 $('#Dailing').html(data.number);
        //                 // $('#DISMSG').html(arr_response.msg_text);
        //                 // if (arr_response.msg==='success') { 
        //                 //     $('#DISMSG').css("color", "green");
        //                 // }
        //                 // if (arr_response.msg==='error') { 
        //                 //     $('#DISMSG').css("color", "red");
        //                 // }
        //             }
        //         },
        //         error: function(data) {
        //             console(data);
        //         }
        //     });
        // }, 1000);
        $('#prayer_req_save').submit(function( e ) {
            // alert( "submit" );
            $( ".btn" ).prop( "disabled", true );
            var id = $("#member_id").val();
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ route('Crm::prayer.request') }}",
                data: {
                    '_token'        : "{{ csrf_token() }}",
                    'member_id'     : $("#member_id").val(),
                    'issue'         : $("#issue").val(),
                    'follow_up_date': $("#follow_up_date").val(),
                    'description'   : $("#description").val(),
                },
                success: function (data) {
                    $( ".btn" ).prop( "disabled", false );
                    $('#AddNote').modal('toggle');
                    $.NotificationApp.send("Success","Prayer Request Created Successfully.","top-center","green","success");
                    setTimeout(function(){
                        prayerReqDatatable();
                    }, 3500);
                }, error: function (data) {
                    $( ".btn" ).prop( "disabled", false );
                    $.NotificationApp.send("Error","Prayer Request Not Created.","top-center","red","error");
                    prayerReqDatatable();
                },
            });
        });
    });
</script>
<script>
    function callFunction() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        var member_num = $("#member_mobile_number").val();
        var caller_uuid = $("#caller_unique_id").val();
        $('#call').css('display', 'none');
        $('#calling').css('display', 'inline-block');
        $.ajax({
            type: 'post',
            url: "{{ route('Crm::calling') }}",
            data: {
                uuid: caller_uuid,
                mobile: member_num
            },
            success: function(data) {
                if (data.status == 'success') {
                    $('#call').css('display', 'inline-block');
                    $('#calling').css('display', 'none');
                    $('#calling_success_msg').html(data.message);
                    $('#calling_success_msg').show();
                } else {
                    $('#call').css('display', 'inline-block');
                    $('#calling').css('display', 'none');
                    $('#calling_error_msg').html(data.message);
                    $('#calling_error_msg').show();
                }
            }
        })
    }
    /*send message*/
    $('#send_message').click(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var msg = $("#msg_str").val();
        if (msg == '') {
            $("#show_msg_str_error").show();
        } else {
            $("#show_msg_str_error").hide();
        }
        var sender = $("#sender_id").val();
        var receiver = $("#receiver_id").val();
        var receiver_mobile = $("#receiver_mobile").val();
        $('#send_message').html('SENDING..');
        $.ajax({
            type: 'post',
            url: "{{ route('Crm::send_message') }}",
            data: {
                sender: sender,
                receiver: receiver,
                receiver_mobile: receiver_mobile,
                msg: msg
            },
            success: function(data) {
                if (data.status == 'success') {
                    $('#send_message').html('SEND');
                    $('#msg_str').val('');
                    $('#SMSModal').modal('hide');
                    $('#calling_success_msg').html(data.message);
                    $('#calling_success_msg').show();
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    $('#send_message').html('SEND');
                    $('#SMSModal').modal('hide');
                    $('#calling_error_msg').html(data.message);
                    $('#calling_error_msg').show();
                }
            }
        })
    });
    /*send message*/
    /*delete message*/
    function deleteManualCallLog(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this call log!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Confirmed!',
                        text: 'The call log has been successfully deleted!',
                        type: 'success'
                    }, function() {
                        $.ajax({
                            type: 'post',
                            url: "{{ route('Crm::delete_call_log') }}",
                            data: {
                                id: id
                            },
                            success: function(data) {
                                if (data.status == 'success') {
                                    location.reload();
                                } else {
                                    alert(data.message);
                                }
                            }
                        })
                    });
                } else {
                    swal("Cancelled", "Your call log is safe :)", "error");
                }
            });
    }

    //on hover edit option
    $('.profile_img_btn').hover(function() {
        $('#profile_pic').attr('src', "{{ asset('crm_public/images/select-profile.jpg') }}");
    }, function() {
        $('#profile_pic').attr('src', $('#profile_pic').attr('data-src'));

    });

    $('.mobile_phone,.gender,.dob,.doj,.email,.name,.married_status,.blood_group').hover(function() {
        // Mouse Over Callback
        var edit_btn = $(this).children().eq(3);
        var save_btn = $(this).children().eq(4);
        var edit_input = $(this).children().eq(2);
        var value = $(this).children().eq(1);
        if (save_btn.is(":hidden"))
            edit_btn.show(200);

        edit_btn.click(function() {
            edit_input.show();
            save_btn.show();
            value.hide();
            edit_btn.hide();

            save_btn.click(function() {

                var values = edit_input.children().eq(0).val();
                var type = edit_input.children().eq(0).attr("data-type");


                if (values == '') {
                    swal('Warning!', 'It can not be empty!', 'warning')
                    return false;
                }

                updateData(values, type);
                value.show();
                edit_input.hide();
                save_btn.hide();
                value.text(values);

            });
            edit_input.keyup(function(event) {
                if (event.keyCode === 13) {
                    save_btn.click();
                }
            });
        });

    }, function() {
        var element = $(this).children().eq(3);
        element.hide(200);
    });


    $("#sms_lang").change(function() {
        updateData($(this).val(), 'sms_language');
    });
    $('#call').change(function() {
        updateData(this.checked ? 1 : 0, 'call_required');
    });
    $('#sms').change(function() {
        if (this.checked)
            $('#sms_languages').show();
        else
            $('#sms_languages').hide();
        updateData(this.checked ? 1 : 0, 'sms_required');
    });

    $('.profile_img_btn').bind("click",
        function() {
            $('#profile_img').click();
        });

    function readURL(input) {
        if (input.files &&
            input.files[0]) {
            var
                reader =
                new
            FileReader();
            reader.onload =
                function(e) {
                    $('#profile_pic').attr('src',
                        e.target.result);
                }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile_img").change(function() {
        if (Math.floor($("#profile_img")[0].files[0].size / 1000) > 2048) {
            $.NotificationApp.send("Error","File must not be greater than 2 mb!","top-center","red","error")
            return;
        }
        updateData($("#profile_img")[0].files[0], 'profile_photo');
        readURL(this);
        // location.reload();
    });


    function makePermanent(object) {
        var id = $('#lead_id').attr("data-id");
        var fd = new FormData();
        fd.append('index', $(object).attr('data_id'));
        fd.append('id', id);
        fd.append('values', $(object).attr('data_values'));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: 'post',
            url: "{{ route('Crm::switch_address') }}",
            processData: false,
            contentType: false,
            data: fd,
            success: function(data) {
                if (data.status == 'success') {

                    location.reload();
                }
            }
        });
    }

    // function updateData(value, type) {
    //     var id = $('#lead_id').attr("data-id");

    //     var fd = new FormData();
    //     fd.append('data', value);
    //     fd.append('editType', type);
    //     fd.append('id', id);

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     });
    //     $.ajax({
    //         type: 'post',
    //         url: "{{ route('Crm::inline_update') }}",
    //         processData: false,
    //         contentType: false,
    //         data: fd,
    //         success: function(data) {
    //             if (data.status == 'success') {
    //                 if (type == 'profile_photo') {
    //                     var name = {!!json_encode(url('/').'/crm/leads/') !!} + data.profile_image;
    //                     $('#profile_pic').attr('data-src', name);
    //                 }
    //                 // location.reload();
    //             } else {
    //                 swal({
    //                     title: "Error!",
    //                     text: "Mobile number has already been taken!",
    //                     type: "error"
    //                 }, function() {
    //                     location.reload();
    //                 });
    //             }
    //         }
    //     });
    // }


    /*delete message*/
    var maxchars = 250;
    $('textarea').keyup(function() {
        var tlength = $(this).val().length;
        $(this).val($(this).val().substring(0, maxchars));
        var tlength = $(this).val().length;
        remain = maxchars - parseInt(tlength);
        if (remain <= 10) {
            $(".text-remain").css("color", "red");
        } else {
            $(".text-remain").css("color", "");
        }
        $('#rchars').text(remain);
    });

    $(document).on('click', '#addNotePopup', function(e) {
        var id = $('#lead_id').attr("data-id");
        $('#member_issue_id').val(id);
    });
</script>
<script>
    $(document).ready(function() {
        $('.dimmer').removeClass('dimmer');
    });
</script>
<script>
    $(document).on('click', '#editNoteButton', function(e) {
        $('#issues_id').val($(this).attr('data-id'))
        // $("#EditNote #update_status option[value=" + $(this).attr('data-status') + "]").attr('selected', 'selected');
        $('#update_issues').val($(this).attr('data-text'))
    });

    //request otp
    // $('#verify_mobile').click(function() {

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     })
    //     var APP_URL="{{route('console::console')}}";
    //     var sender = $('#lead_id').attr("data-id");
    //     var receiver_mobile = $(this).attr('data-mobile');
    //     var my_url = APP_URL + '/crm/admin/send_otp';

    //     $('#receiver_mobile').val(receiver_mobile);

    //     $.ajax({
    //         type: 'post',
    //         url: my_url,
    //         data: {
    //             sender: sender,
    //             receiver_mobile: receiver_mobile
    //         },
    //         success: function(data) {
    //             if (data.status == 'success') {
    //                 $('#EnterOTP').modal('show');

    //                 //  setTimeout(function(){							
    //                 //     location.reload();
    //                 // }, 3000);
    //             } else {
    //                 $('#verify_label').html('Resend');
    //             }
    //         }
    //     });


    // });
    //verify_otp
    // $('#otp_form').submit(function(e) {
    //     e.preventDefault();
    //     var otp = $('#otp').val();
    //     if (otp == '') {
    //         $('#show_otp_error').show();
    //         return false;
    //     }
    //     var APP_URL="{{route('console::console')}}";
    //     var formData = new FormData(this);
    //     var type = "POST";
    //     var my_url = APP_URL + '/crm/admin/verify_otp';

    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     })
    //     $.ajax({
    //         type: type,
    //         url: my_url,
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         dataType: 'json',
    //         success: function(data) {
    //             if (data.status == 'success') {
    //                 $('#EnterOTP').modal('hide');
    //                 swal({
    //                     title: "Success!",
    //                     text: "The Otp has been verified!",
    //                     type: "success"
    //                 }, function() {
    //                     location.reload();
    //                 });

    //             } else {
    //                 $('#show_otp_error').show();
    //                 $('#show_otp_error').text("Worng Otp");
    //             }
    //         },
    //         error: function(data) {
    //             $('#show_otp_error').show();
    //             $('#show_otp_error').text("Worng Otp");

    //             console.log('Error:', data);
    //         }
    //     });

    // });
</script>
<script>
    $('#Request-tab').on('click', function () {
        prayerReqDatatable();
    });
    function prayerReqDatatable() {
        $('#prayerReqDatatable').DataTable().destroy();
        let table = $('#prayerReqDatatable');
        let id = '{{ $lead->id }}';
        table.DataTable({
            order: [['0', 'desc']],
            serverSide: true,
            responsive: true,
            processing: true,
            ajax: {
                url: "{{ route('Crm::get.lead.prayer.request') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
            },
            columns: [
                {data: "id", name: 'member_issues.id'},
                {data: "created_at", name: 'member_issues.created_at'},
                {data: "name", name: 'users.name'},
                {data: "issue", name: 'member_issues.issue'},
                {data: "follow_up_date", name: 'member_issues.follow_up_date'},
                {data: "description", name: 'member_issues.status'},
                {data: "status", name: 'member_issues.description'},
                {data: "action", sortable: false, searchable : false},
            ]
        });
    }
</script>

<script>
    $('#Donations-tab').on('click', function () {
        donationDataTable();
    });    
    function donationDataTable() {
        $('#donationDataTable').DataTable().destroy();
         totalAmount();
        let table = $('#donationDataTable');
        let id = '{{ $lead->id }}';
        table.DataTable({
            order: [['0', 'desc']],
            serverSide: true,
            responsive: true,
            processing: true,
            ajax: {
                url: "{{ route('Crm::get.lead.donation') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
            },
            columns: [
                {data: "id", name: 'donations.id'},
                {data: "receipt_number", name: 'donations.receipt_number'},
                {data: "donation_type", name: 'donations.donation_type'},
                {data: "amount", name: 'donations.amount'},
                {data: "payment_mode", name: 'donations.payment_mode'},
                {data: "payment_status", name: 'donations.payment_status'},
                {data: "donation_date", name: 'donations.donation_date'},
                {data: "created_at", name: 'donations.created_at'},
                {data: "donation_purpose", name: 'donation_purpose.purpose'},
                {data: "action", sortable: false, searchable : false},
            ]
        });
    }



     function totalAmount(){
        let id = '{{ $lead->id }}';
        //console.log(id);
        $.ajax({
                        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                        url:  "{{route('Crm::totalAmount')}}",
                        data: {
                            id: id,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: 'json', // what type of data do we expect back from the server
                        encode: true
                    })
                    // using the done promise callback
                    .done(function(data) {
                    $('#total_amount').text(data);              
                    })
                        
                    // using the fail promise callback
                    .fail(function(data) {
                        console.log(data);
                    });
    }
</script>
<script>
$(document).ready(function() {
    $('#manual_call_log_frm').submit(function (e) {
            e.preventDefault();
            $("#hidecalllogext").css('display', 'none');
            $(".addCallLogForm").css('display', 'inline-block');
            $.ajax({
                type: "POST",
                url: "{{ route('Crm::add.callLog') }}",
                data: {
                    '_token'          : "{{ csrf_token() }}",
                    'member_id'       : $("#member_id").val(),
                    'outcome'         : $("#outcome").val(),
                    'log_date'        : $("#log_date").val(),
                    'log_duration'    : $("#log_duration").val(),
                    'log_description' : $("#log_description").val(),
                },
                success: function (data) {
                    $("#manual_call_log_frm")[0].reset();
                    $('#LogCall').modal('toggle');
                    $(".addCallLogForm").css('display', 'none');
                    $("#hidecalllogext").css('display', 'inline-block');
                    $.NotificationApp.send("Success","Call Log Created Successfully.","top-center","green","success");
                    callLogsDataTable();
                    setTimeout(function(){
                        //location.reload();
                    }, 1000);
                }, error: function (data) {
                    $.NotificationApp.send("Error","Call Log Not Created.","top-center","red","error");
                    setTimeout(function(){
                       // location.reload();
                    }, 3500);
                    callLogsDataTable();
                },
            });
    });
});
</script>
<!-- <script>
    $(document).ready(function() {
        $('.dimmer').removeClass('dimmer');
        //Call checkdonationstatus function
        //checkdonationstatus();
        //setInterval(checkdonationstatus, 5000);
    });
</script> -->
<script type="text/javascript">
    /**
     *@author {Previous devloper}
     *@updatedBy {Paras}
     *@description {Function to handle payment method field selection}
     */
    $(function() {
        $("#payment_mode").change(function() {
            if ($(this).val() == "CHEQUE") {
                $("#cheque_date_field").show();
                $("#bank_name_field").show();
                $("#cheque_number_field").show();
                $("#branch_name_field").show();
                $(".payment-status").show();
                $("#reference_no_field").hide();
                $("#payment_method_field").hide();
            } else if ($(this).val() == "OTHER") {
                $("#payment_method_field").show();
                $(".payment-status").show();
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#reference_no_field").hide();
            } else if ($(this).val() == "QRCODE") {
                $("#reference_no_field").show();
                $(".payment-status").show();
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#payment_method_field").hide();
            } else if ($(this).val() == "CASH") {
                $(".payment-status").show();
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#reference_no_field").hide();
                $("#payment_method_field").hide();
            } else if ($(this).val() == "CARD") {
                $(".payment-status").show();
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#reference_no_field").hide();
                $("#payment_method_field").hide();
            } else {
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#payment_method_field").hide();
                $("#reference_no_field").hide();
                $(".payment-status").hide();
            }
        });

    });

    function stateChange(object) {
        var value = object.value;
        if (value == 'recurring') {
            $('.start').show();
            $('.end').show();
            $('.period').show();
        } else {
            $('.start').hide();
            $('.end').hide();
            $('.period').hide();
        }
    }
    function decisionChange(object) {
        var value = object.value;
        if (value == 0) {
            $('#donation_date_div').hide();
            $('#will_donate_type_div').hide();
        } else {
            $('#donation_date_div').show();
            $('#will_donate_type_div').show();
        }
    }

    $(document).on('change', '#issue', function(e) {
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue) {
            $('#prayer_request_modal').val('');
            $("#modal_type").val(1);
            $("#AddNote").modal("hide");
            $("#addRequestsModal").modal("show");

        }
    });


    $(document).on('change', '#edit_issue', function(e) {
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue) {
            $('#prayer_request_modal').val('');
            $("#modal_type").val(2);
            $("#prayerRquestEditModal").modal("hide");
            $("#addRequestsModal").modal("show");
        }
    });

    //Prayer Request Upload  addRequestsModal  AddNote edit_issue  prayerRquestEditModal  modal_type
    $('#upload_request_form').submit(function (e) {
        e.preventDefault();
        var APP_URL="{{route('console::console')}}";
        var request = $('#prayer_request_modal').val();
        var modal_type = $('#modal_type').val();
        if (request == '') {
            $.NotificationApp.send("Error","Please enter request!","top-center","red","error");
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = APP_URL + '/manage/requestData';
        var type = "POST";

        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {

                if(modal_type==1){
                    $("#addRequestsModal").modal("hide");
                    $("#AddNote").modal("show");
                    if(data.success==true){
                        $('#issue').val(null).trigger('change');
                        $("#issue option:last").before("<option value="+request+">"+request+"</option>");
                        $('#edit_issue').val(null).trigger('change');
                        $("#edit_issue option:last").before("<option value="+request+">"+request+"</option>");
                    }
                }else if(modal_type==2){
                    $("#addRequestsModal").modal("hide");
                    $("#prayerRquestEditModal").modal("show");
                    if(data.success==true){
                        $('#edit_issue').val(null).trigger('change');
                        $("#edit_issue option:last").before("<option value="+request+">"+request+"</option>");
                        $('#issue').val(null).trigger('change');
                        $("#issue option:last").before("<option value="+request+">"+request+"</option>");
                    }
                }
                $.NotificationApp.send("Success","The request has been created!","top-center","green","success");
            },
            error: function (data) {
                $.NotificationApp.send("Error","Something Went wrong...","top-center","red","error");
            }
        });

    });






    $(document).on('change', '#member_type_id', function(e) {
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue) {
            $("#detail_type").val(1);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });
    $('#location').change(function() {
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue) {
            $("#detail_type").val(4);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });

    $('#donation_purpose').change(function() {
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue) {
            $("#detail_type").val(2);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });

    $(document).on('submit', '#add_detail', function(e) {
        e.preventDefault();
        // 	e.preventDefault();
        $("#AddDetails").modal("hide");

        var detail = $('#detail').val();
        if (detail == '') {
            $.NotificationApp.send("Error",'Please enter value',"top-center","red","error");
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = '';
        var APP_URL="{{route('console::console')}}";
        if ($('#detail_type').val() == 3) {
            my_url = APP_URL + '/manage/departmentData';
            formData.append('department', detail);
        } else if ($('#detail_type').val() == 4) {
            my_url = APP_URL + '/manage/branchData';
            formData.append('branch', detail);
        } else if ($('#detail_type').val() == 2) {
            my_url = APP_URL + '/manage/insertDonationpurpose';
            formData.append('purpose', detail);
        } else
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
            success: function(data) {
                if(data.status==true){
                   if($('#detail_type').val()==1){
                    $('#member_type_id').val(null).trigger('change');
                    $("#member_type_id option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==2){
                        $('#donation_purpose').val(null).trigger('change');
                        $("#donation_purpose option:last").before("<option value="+data.id+">"+addText+"</option>");
                    }else if($('#detail_type').val()==4){
                        $('#location').val(null).trigger('change');
                        $("#location option:last").before("<option value="+addText+">"+addText+"</option>");
                    } 
                }
                $.NotificationApp.send("Success","Data has been submited!","top-center","green","success");
                setTimeout(function(){
                    //location.reload();   
                }, 3500);

                $('#AddDonation').modal('show');
            },
            error: function(data) {
                $.NotificationApp.send("Error",data,"top-center","red","error");
                
            }
        });
    });

    //Our checkdonationstatus function.
    // function checkdonationstatus() {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     })
    //     var APP_URL="{{route('console::console')}}";
    //     my_url = APP_URL + '/crm/admin/checkdonationstatusbylead/{{$lead->id}}';
    //     console.log(my_url);
    //     var type = "GET";
    //     $.ajax({
    //         type: type,
    //         url: my_url,
    //         dataType: 'json',
    //         success: function(data) {
    //             $.each(data, function(index, value) {
    //                 if (value.payment_status) {
    //                     $("#donation-" + value.id).html('<span class="badge badge-success">Paid</span>');
    //                 } else {
    //                     $("#donation-" + value.id).html('<span class="badge badge-danger">Pending</span>');
    //                 }
    //             });
    //             setTimeout(checkdonationstatus, 5000)
    //         },
    //         error: function(data) {
    //             //swal('Error!', data, 'error')
    //         }
    //     });
    // }

    /*send Payment link SMS*/
    function send_payment_link_sms(id){

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url:  "{{route('Crm::send_payment_link_sms')}}",
                    data:{donation_id:id} ,
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true
                })
                // using the done promise callback
                .done(function(data) {
                    if(data.status==false){
                        $.NotificationApp.send("Error",data.message,"top-center","red","error");
                        setTimeout(function(){
                            //location.reload();
                        }, 3500);
                    
                    }

                    if(data.status==true){
                        
                        $.NotificationApp.send("Success",data.message,"top-center","green","success");
                        setTimeout(function(){
                            location.reload();
                            //var url = "{{route('Crm::leads')}}";
                            //location.href=url;
                        }, 3500);
                        donationDataTable();
                    }

                })
                // using the fail promise callback
                .fail(function(data) {
                    $.NotificationApp.send("Error",data.message,"top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                });

                
        }
    // $('#send_payment_link_sms').click(function() {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     });
    //     var donation_id = $(this).attr('data-id');
    //     $.ajax({
    //         type: 'post',
    //         url: "{{ route('Crm::send_payment_link_sms') }}",
    //         data: {
    //             donation_id: donation_id
    //         },
    //         success: function(data) {
    //             swal({
    //                 title: "Success!",
    //                 text: data.message,
    //                 type: "success"
    //             }, function() {
    //                 //ocation.reload();
    //             });
    //         }
    //     })
    // });

    /*Update donation status to piad*/

    function update_payment_status_paid(id){

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url:  "{{route('Crm::updateDonationPaymentDetail')}}",
                    data:{donation_id:id} ,
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true
                })
                // using the done promise callback
                .done(function(data) {
                    if(data.status==false){
                        $.NotificationApp.send("Error",data.message,"top-center","red","error");
                        setTimeout(function(){
                            //location.reload();
                        }, 3500);
                    
                    }

                    if(data.status==true){
                        
                        $.NotificationApp.send("Success",data.message,"top-center","green","success");
                        setTimeout(function(){
                            //location.reload();
                            //var url = "{{route('Crm::leads')}}";
                            //location.href=url;
                        }, 3500);

                        donationDataTable();
                    }

                })
                // using the fail promise callback
                .fail(function(data) {
                    $.NotificationApp.send("Error",data.message,"top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                });

                
        }
    // $('#update_payment_status_paid').click(function() {
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    //         }
    //     });
    //     var donation_id = $(this).attr('data-id');
    //     $.ajax({
    //         type: 'post',
    //         url: "{{ route('Crm::updateDonationPaymentDetail') }}",
    //         data: {
    //             donation_id: donation_id
    //         },
    //         success: function(data) {
    //             swal({
    //                 title: "Success!",
    //                 text: data.message,
    //                 type: "success"
    //             }, function() {
    //                 //ocation.reload();
    //             });
    //         }
    //     })
    // });
</script>

<script>
    $(document).ready(function() {
        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    });
</script>

<script>
    $(document).ready(function() {
        //$('[data-toggle="popover"]').popover();
    });
</script>
<!-- <script src="{{ asset(Laralum::publicPath() .'/js/selectron.js') }}" type="text/javascript"></script> -->
<script type="text/javascript">
    // $('#logged_member_id').selectron();
    // $('#logged_outcome').selectron();
    // $('#outcome').selectron();
    // $('#member_id').selectron();

    // $(".right-sidebar-opener").click(function() {
    //     $(".right-sidebar-area").toggleClass("active");
    //     $(".right-sidebar-opener").toggleClass("show");
    // });

    // $(".right-sidebar-opener").click(function() {
    //     $(".profile-view-tab").toggleClass("middle-area-short");
    // });

    // $('.right-sidebar-opener').click(function() {
    //     $("i", this).toggleClass("fa-angle-double-left fa-angle-double-right");
    // });
</script>
<style>
    /*.card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        border-radius: 5px;

        padding: 5px;
        background-color: white;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .col-lg-3.qualification {
        margin-bottom: 35px;
    }

    .page-content {
        padding-top: 0;
    }

    .menu-pusher {
        padding-left: 350px !important;
        background-color: #F6FFFF;
    }


    .ui.segment {
        background: transparent;
    }

    .tab-content {
        background: transparent;
    }

    .nav-tabs>li.active>a,
    .nav-tabs>li.active>a:focus,
    .nav-tabs>li.active>a:hover {
        background-color: transparent;
    }

    .toggle.ios,
    .toggle-on.ios,
    .toggle-off.ios {
        border-radius: 20px;
    }

    .toggle.ios .toggle-handle {
        border-radius: 20px;
    }

    div.dataTables_wrapper div.dataTables_processing {
        background: #26476c !important;
        color: #fff !important;
    }

    table.dataTable thead .sorting_asc::after,
    table.dataTable thead .sorting_desc::after {
        color: #f9ba48;
    }*/
</style>
<script>
$(document).ready(function() {
    callLogsDataTable();
});
$('#Logs-tab').on('click', function () {
       callLogsDataTable();
});
function callLogsDataTable(){
    $('#manualCallLogTable').DataTable().destroy();
        let table = $('#manualCallLogTable');
        let id = '{{ $lead->id }}';
        table.DataTable({
            order: [['0', 'desc']],
            serverSide: true,
            responsive: true,
            processing: true,
            ajax: {
                url: "{{route('Crm::get.lead.calllog')}}",
                type: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
            },
            columns: [
                {data: "id", name: 'manual_logged_call.id'},
                {"data": "name"},
                {"data": "attended_by"},
                {"data": "created_at"},
                {"data": "description"},
                {"data": "outcome"},
                {"data": "date"},
                {"data": "duration"},
            ]
        });
    
}
</script>
@endsection