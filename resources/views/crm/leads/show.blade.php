@extends('layouts.crm.newLayout')
@section('title', $lead->name)
@section('icon', "phone")
@section('subtitle', $lead->email)
@section('content')
<?php
use \App\Http\Controllers\Crm\MembersController;
?>
<link href="{{ asset(Laralum::publicPath() .'/css/custom-crm.css') }}" type="text/css" rel="stylesheet" />
<!--sidebar-area-start--->
<div class="sidebar-area">
<div class="row breadcrumb-area">
	<div class="col-xs-6 p-0">
		<a href="{{ route('Crm::leads') }}" class="btn sidebar-breadcrumb-btn"><span class="fas fa-angle-left" aria-hidden="true"></span> Leads <i class="fa fa-users" aria-hidden="true"></i></a>
	</div>
	<div class="col-xs-6 p-0 sidebar-breadcrumb-action">
		 <div class="dropdown">
			<strong class="dropdown-toggle" type="button" data-toggle="dropdown">Actions
			<span class="caret"></span></strong>
			<ul class="dropdown-menu">
			  @if(Laralum::hasPermission('laralum.member.edit'))
			   <li><a href="{{ route('Crm::lead_edit', ['id' => $lead->id]) }}">Edit Lead</a></li>
			  @endif			  
			  @if(Laralum::hasPermission('laralum.member.delete'))
			    <li><a href="{{ route('Crm::lead_delete', ['id' => $lead->id]) }}">{{ trans('laralum.delete_lead') }}</a></li>
			  @endif			 
			</ul>
		  </div>
	</div>
</div>
<div class="profile_img_btn">

@if($lead->profile_photo)
<img src="{{ asset('crm/leads') }}/{{ $lead->profile_photo }}" id="profile_pic"
	data-src="{{ asset('crm/leads') }}/{{ $lead->profile_photo }}"
	class="img-fluid profile-view-img" />
@else
<img src="{{ asset('crm_public/images/empty-image.jpg') }}" id="profile_pic"
	data-src="{{ asset('crm_public/images/empty-image.jpg') }}"
	class="img-fluid profile-view-img" />
@endif
</div>
<input id="profile_img" name="profile_photo" type="file" class="center"
	value="{{old('profile_photo')}}">


<div class="name">
	<div></div>
	<div>
		<h4 class="profile-view-name">{{ $lead->name ?? '' }}</h4>
	</div>
	<div class="input"><input type="text" data-type="name" class="form-control"
			value="{{ $lead->name ?? '' }}" name="data">
	</div>
	<div class="icon_fixed"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"
				aria-hidden="true"></i></a></div>
	<div style="display: none"><a href="javascript:void(0);"><i class="fa fa-floppy-o"
				aria-hidden="true"></i></a></div>

</div>

<!---->
<div class="sidebar-btn-action">
<a href="javascript:void(0);"  data-toggle="modal" data-target="#SMSModal" title="MESSAGES">
	<i class="fas fa-comment-alt"></i>
</a>

<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="APPOINTMENTS">
	<i class="far fa-calendar-check"></i>
</a>

<a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="CALLS">
	<i class="fas fa-phone"></i>
</a>

<a href="javascript:void(0);" id="addDonationPopup" data-id="{{$lead->id}}" data-toggle="modal" data-target="#AddDonation" title="DONATIONS">
	<i class="fas fa-donate"></i>
</a>

<a href="javascript:void(0);" id="addNotePopup" data-id="{{$lead->id}}" data-toggle="modal" data-target="#AddNote" title="Prayer Requests">
	<i class="far fa-question-circle"></i>
</a>

</div>
<!---->


<table class="table personal-detail-table">
	@if(!empty($lead->member_id))
	<tr class="member_id">
		<td><i class="fa fa-id-card"></i></td>
		<td><span>{{ $lead->member_id ?? '' }}</span></td>
	</tr>
	@endif
	@if(!empty($lead->email))
	<tr class="email">
		<td><i class="fa fa-at"></i></td>
		<td><span>{{ $lead->email ?? '' }}</span></td>
		<td style="display: none"><input type="text" data-type="email" class="form-control"
				value=" {{ $lead->email ?? '' }}" name="data">
		</td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"
					aria-hidden="true"></i></a></td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-floppy-o"
					aria-hidden="true"></i></a></td>

	</tr>
	@endif

	<tr class="mobile_phone">
		<td><i class="fa fa-phone"></i></td>
		<td><span>{{ $lead->mobile ?? '' }}</span></td>
		<td style="display: none"><input type="text" data-type="mobile" class="form-control "
				value="{{ $lead->mobile ?? '' }}" name="data">
		</td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"
					aria-hidden="true"></i></a></td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-floppy-o"
					aria-hidden="true"></i></a></td>
	</tr>
	@if(!empty($lead->gender))
	<tr class="gender">
		<td>{!! $lead->gender == 'Male' ? '<i class="fa fa-male"></i>' : '<i
				class="fa fa-female"></i>' !!}</td>
		<td><span>{{ $lead->gender ?? '' }}</span></td>
		<td style="display: none">
			<select class="form-control custom-select" id="gender" name="gender" data-type="gender">
				<option value="Male" {{ (old('gender',$lead->gender) == "Male" ? 'selected': '') }}>
					Male</option>
				<option value="Female"
					{{ (old('gender',$lead->gender) == "Female" ? 'selected': '') }}>Female
				</option>
			</select>
		</td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"
					aria-hidden="true"></i></a></td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-floppy-o"
					aria-hidden="true"></i></a></td>
	</tr>
	@endif

	@if(!empty($lead->blood_group))
	<tr class="blood_group">
		<td><i class="fa fa-medkit"></i></td>
		<td><span>{{ $lead->blood_group ?? '' }}</span></td>
		<td style="display: none">
			<select class="form-control custom-select" id="bldgrp" name="bldgrp"
				data-type="blood_group">
				<option value="A+"
					{{ (old('bldgrp',$lead->blood_group) == "A+" ? 'selected': '') }}>A+</option>
				<option value="B+"
					{{ (old('bldgrp',$lead->blood_group) == "B+" ? 'selected': '') }}>B+</option>
				<option value="O+"
					{{ (old('bldgrp',$lead->blood_group) == "O+" ? 'selected': '') }}>O+</option>
				<option value="O-"
					{{ (old('bldgrp',$lead->blood_group) == "O-" ? 'selected': '') }}>O-</option>
				<option value="A-"
					{{ (old('bldgrp',$lead->blood_group) == "A-" ? 'selected': '') }}>A-</option>
				<option value="B-"
					{{ (old('bldgrp',$lead->blood_group) == "B+" ? 'selected': '') }}>B-</option>
				<option value="AB+"
					{{ (old('bldgrp',$lead->blood_group) == "AB+" ? 'selected': '') }}>AB+</option>
				<option value="AB-"
					{{ (old('bldgrp',$lead->blood_group) == "AB-" ? 'selected': '') }}>AB-</option>
			</select>
		</td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"
					aria-hidden="true"></i></a></td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-floppy-o"
					aria-hidden="true"></i></a></td>
	</tr>
	@endif
	@if(!empty($lead->date_of_birth) and $lead->date_of_birth!='0000-00-00')
	<tr class="dob">
		<td><i class="fa fa-birthday-cake"></i></td>
		<td><span>{{ date("jS F, Y", strtotime($lead->date_of_birth)) }}</span></td>
		<td style="display: none"><input type="date" data-type="date_of_birth"
				value="{{ $lead->date_of_birth ?? '' }}" name="data">
		</td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"
					aria-hidden="true"></i></a></td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-floppy-o"
					aria-hidden="true"></i></a></td>
	</tr>
	@endif
	@if(!empty($lead->date_of_joining) and $lead->date_of_birth!='0000-00-00')
	<tr class="doj">
		<td><i class="fa fa-briefcase"></i></td>
		<td><span>{{ date("jS F, Y", strtotime($lead->date_of_joining)) }}</span></td>
		<td style="display: none"><input type="date" data-type="date_of_joining"
				value="{{ $lead->date_of_joining ?? '' }}" name="data">
		</td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"
					aria-hidden="true"></i></a></td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-floppy-o"
					aria-hidden="true"></i></a></td>
	</tr>
	@endif
	@if(!empty($lead->married_status))
	<tr class="married_status">
		<td><i class="fa fa-medkit"></i></td>
		<td><span>{{ $lead->married_status ?? '' }}</span></td>
		<td style="display: none">
			<select class="form-control custom-select" id="married_status" name="married_status"
				data-type="married_status">
				<option value="Single"
					{{ (old('married_status',$lead->married_status) == "Single" ? 'selected': '') }}>
					Single</option>
				<option value="Married"
					{{ (old('married_status',$lead->married_status) == "Married" ? 'selected': '') }}>
					Married
				</option>
			</select>
		</td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-pencil-square-o"
					aria-hidden="true"></i></a></td>
		<td style="display: none"><a href="javascript:void(0);"><i class="fa fa-floppy-o"
					aria-hidden="true"></i></a></td>
	</tr>
	@endif
</table>
</div>
<!--sidebar-area-end--->


<div class="ui one column doubling stackable grid container-fluid" id="lead_id" data-id="{{$lead->id}}">
	<div class="column">
		@if(Laralum::loggedInUser()->su || Laralum::loggedInUser()->isReseller)
		@if(!Laralum::loggedInUser()->RAZOR_KEY)
		<div class="card col-md-12" style="margin-bottom: 20px; padding: 15px 0 15px 0px;">
			<div class="col-md-12">
				<h4><i class="fa fa-credit-card" aria-hidden="true"></i> Get paid faster with online payment gateways
				</h4>
				<p>Setup a payment gateway and start acepting payments online.
				<a href="{{ route('console::profile') }}#Payments" id="donationForm">
				   <span id="hide_donation_text">Set up Now</span>
				</a>
				</p>
			</div>
		</div>
		@endif
		@endif
		<div class="ui very padded segment">
			<!--profile-area--start-->
			<div class="row profile-page">
				
				<div class="col-md-12 profile-ver-divider profile-view-tab">
					{{-- (Request::query('page') === null || Request::query('page') == 'home') --}}
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" id="myTab">
						<li class="active">
							<a class="ripple" data-toggle="tab" href="#Profile"
								onclick="$('.dimmer').removeClass('dimmer')">
								<span>ACTIVITY</span>
							</a>
						</li>
						@if(Laralum::hasPermission('laralum.member.calllogs'))
						<li>
							<a class="ripple" data-toggle="tab" href="#Logs"
								onclick="$('.dimmer').removeClass('dimmer')">
								<span>CALL LOGS</span>
							</a>
						</li>
						@endif
						@if(Laralum::hasPermission('laralum.member.viewsms'))
						<li>
							<a class="ripple" data-toggle="tab" href="#Messages"
								onclick="$('.dimmer').removeClass('dimmer')">
								<span>MESSAGES</span>
							</a>
						</li>
						@endif
						@if(Laralum::hasPermission('laralum.appointments.list'))
						<li>
							<a class="ripple" data-toggle="tab" href="#Appointments"
								onclick="$('.dimmer').removeClass('dimmer')">
								<span>APPOINTMENTS</span>
							</a>
						</li>
						@endif
						
						@if(Laralum::hasPermission('laralum.donation.list'))
						<li>
							<a class="ripple" data-toggle="tab" href="#Donations"
								onclick="$('.dimmer').removeClass('dimmer')">
								<span>DONATIONS</span>
							</a>
						</li>
						@endif
						@if(Laralum::hasPermission('laralum.member.list_prayer'))
						<li>
							<a class="ripple" data-toggle="tab" href="#Issues" onclick="$('.dimmer').removeClass('dimmer')">
								<span>PRAYER REQUEST</span>
							</a>
						</li>
						@endif
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane fade in active" id="Profile">
						</div>

						<div class="tab-pane fade" id="Logs">
							<div class="row">
								<div class="col-md-12 text-right"> 
									<a href="#" class="btn btn-lg btn-primary btn-theme" data-toggle="modal" data-target="#LogCall" style="margin-bottom: 10px;"><i class="fa fa-phone"></i>&nbsp;Log Call</a>	
								</div>
								<div class="clearfix"></div>
								<div class="col-md-12"> 
									<!--p>Upcoming</p-->
									@if (count($manual_call_logs) > 0)
									@foreach($manual_call_logs as $calllog)
									<div class="panel panel-default call-log-list">
										<div class="panel-body">
											<div class="col-md-1 left-icon p-0">
												<i class="fa fa-phone" aria-hidden="true"></i>
											</div>
											<div class="col-md-11 p-0">
												<div class="row">
													<div class="col-md-6 log-list-top">
														<p><b>Logged call</b></p>
													</div>
													<div class="col-md-6 log-list-top log-action">
													<a href="javascript:void(0);" onclick="deleteManualCallLog({{ $calllog->id }})"><i class="fas fa-trash-alt"></i></a>
													<span title="CREATED AT" data-toggle="popover" data-placement="top" data-content="{{ $calllog->created_at }}">{{ $calllog->created_at }}</span>
													</div>
													<div class="col-md-12">
														<textarea class="form-control log-inp-txt" placeholder="Add description">{{ $calllog->description }}</textarea>
													</div>
													<div class="col-md-12">
													<div class="call-details">
														<div class="row">
															<div class="col-md-3">
															<div class="form-group">
																<label>Contacted</label>
																<select data-selectron-search="false" id="logged_member_id" name="logged_member_id">
																	<option value="{{ $lead->id }}" selected>{{ $lead->name ?? '' }}</option>
																</select>
															</div>
															</div>
															<div class="col-md-3">
															<div class="form-group">
																<label>Outcome</label>
																<select data-selectron-search="false" id="logged_outcome" name="logged_outcome">
																	<option value="busy" {{ (old('outcome',$calllog->outcome) == "busy" ? 'selected': '') }}>Busy</option>
																	<option value="connected" {{ (old('outcome',$calllog->outcome) == "connected" ? 'selected': '') }}>Connected</option>
																	<option value="left_live_message" {{ (old('outcome',$calllog->outcome) == "left_live_message" ? 'selected': '') }}>Left live message</option>
																	<option value="left_voicemail" {{ (old('outcome',$calllog->outcome) == "left_voicemail" ? 'selected': '') }}>Left voicemail</option>
																	<option value="no_answer" {{ (old('outcome',$calllog->outcome) == "no_answer" ? 'selected': '') }}>No answer</option>
																	<option value="wrong_answer" {{ (old('outcome',$calllog->outcome) == "wrong_answer" ? 'selected': '') }}>Wrong number</option>
																</select>
															</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label>Date</label>
																	<input type="date" class="inp-date-time" value="{{ $calllog->date }}" />
																</div>
															</div>
															<div class="col-md-3">
																<div class="form-group">
																	<label>Time</label>
																	<input type="time" class="inp-date-time without_ampm" value="{{ $calllog->duration }}" />
																</div>
															</div>
														</div>
													</div>
													</div>
													
													
													<div class="col-md-12">
														<div class="row">
															<div class="col-md-6">
																<div class="media">
																  <div class="media-left">
																	<img id="avatar-div" class="" src="{{ asset(Laralum::publicPath() .'/images/avatar.jpg') }}">
																  </div>
																  <div class="media-body">
																	<p><b>{{ Laralum::loggedInUser()->name }}</b> logged a call</p>
																  </div>
																</div>
															</div>
															<div class="col-md-6 text-right">
																<!--button type="submit" class="btn btn-primary btn-sm font-10">Update</button-->
															</div>
														</div>
													</div>
													
												</div>
											</div>
										</div>
									</div>
									
								  @endforeach
								  @else
								  <div class="col-md-12">
									<div class="ui negative icon message">
										<i class="frown icon"></i>
										<div class="content">
											<div class="header">
												{{ trans('laralum.missing_title') }}
											</div>
											<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "log call"]) }}</p>
										</div>
									</div>
								  </div>
								 @endif
								</div>
							</div>
						</div>

						<div class="tab-pane fade" id="Messages">
							<div class="row">
								@if (count($msg_list) > 0)
								<div class="col-md-12">
									<table class="ui four column table">
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
												<td align="left"><a href="javascript:void(0);" class="yellow-txt"
														data-html="true" data-toggle="popover" data-trigger="focus"
														data-placement="top"
														data-content="<div class='media'><a href='javascript:void(0);' class='pull-left'><img src='{{ asset('crm_public/images/empty-image.jpg') }}' class='img-fluid profile-popover-img' /></a><div class='media-body'><P class='ml-2 mb-0'>{{ $msg->sender }}</p><P class='ml-2 mb-0'><i class='fas fa-mobile-alt yellow-txt'></i>&nbsp;{{ $msg->sender_mobile }}</p><p class='badge badge-info ml-2'>{{ $msg->sender_role }}</p></div></div>">{{ $msg->sender }}</a>
												</td>
												<td align="left">{{ substr($msg->message, 0,  25) }} <a
														href="javascript:void(0);" class="yellow-txt"
														data-toggle="popover" data-trigger="focus" data-placement="top"
														data-content="{{ $msg->message }}"><i
															class="fa fa-ellipsis-h"></i></a></td>
												<td class="d-text-center">
													{{ date('g:i A, F d Y', strtotime($msg->created_at) ) }}</td>
												<td class="d-text-center"><span>{{$msg->status}}</span></td>
											</tr>
											@endforeach
										</tbody>
									</table>
									{{$msg_list->appends(['messages' => $msg_list->currentPage()])->links()}}
								</div>

								@else
								<div class="col-md-12">
									<div class="ui negative icon message">
										<i class="frown icon"></i>
										<div class="content">
											<div class="header">
												{{ trans('laralum.missing_title') }}
											</div>
											<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "message"]) }}</p>
										</div>
									</div>
								</div>
								@endif
							</div>

						</div>
						<!--appointment-area-->
						<div class="tab-pane fade" id="Appointments">
							<div class="row">
								@if (count($appointments) > 0)
								<div class="col-md-12">
									<table class="ui four column table">
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
												<td class="left">{{ $appointment->service_request }}</td>
												<td class="d-text-center">
													{{ date('d/m/Y', strtotime($appointment->apt_date)) }}</td>
												<td class="d-text-center">
													{{  date("g:i A", strtotime($appointment->time_slot)) }}</td>
												<td class="d-text-center">
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
								<div class="col-md-12">
									<div class="ui negative icon message">
										<i class="frown icon"></i>
										<div class="content">
											<div class="header">
												{{ trans('laralum.missing_title') }}
											</div>
											<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "appointment"]) }}
											</p>
										</div>
									</div>
								</div>
								@endif
							</div>
						</div>
						<!--appointment-area-->
						<!--donation-area-->
						<div class="tab-pane fade" id="Donations">
							@if(Laralum::hasPermission('laralum.donation.create'))
							<button type="button" style="margin-bottom: 10px" class="btn btn-lg btn-primary btn-theme pull-right" id="addDonationPopup" data-id="{{$lead->id}}" data-toggle="modal" data-target="#AddDonation">
							<i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; ADD
							</button>
							
							<a href="{{ route('Crm::donation_export', ['member_id' => $memberId]) }}" class="btn btn-lg btn-primary btn-theme pull-right"
								id="ImportShow" onclick="$('.dimmer').removeClass('dimmer')">
								<i class="fas fa-upload icon_m"></i><span>{{ trans('laralum.export') }}</span>
							</a>
							@endif
							<div class="row">
								<div class="col-md-12">
									<table class="ui four column table" id="donationTable" width="100%">
										<thead>
											<tr>
												<th>Receipt No</th>
												<th>Donation Type</th>
												<th>Amount</th>
												<th>Mode</th>
												<th>Status</th>
												<th>Date</th>
												@if(Laralum::hasPermission('laralum.donation.view'))
												<th>Actions</th>
												@endif
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
						<!--donation-area-->
						<!--issues-area-->
						<div class="tab-pane fade" id="Issues">
							@if(Laralum::hasPermission('laralum.member.add_prayer'))
							<button type="button" class="btn btn-lg btn-primary btn-theme pull-right" id="addNotePopup" data-id="{{$lead->id}}" data-toggle="modal" data-target="#AddNote">
			                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; ADD
		                    </button>
							@endif
							<div class="row">	
							<div class="col-md-12">
								<table class="ui four column table" id="issuesTable" width='100%'>
									<thead>
									 <tr>
										<th>Request</th>
										<th>Date</th>
										<th>Taken by</th>
										<th>Status</th>
										<th>Action</th>
									 </tr>
									</thead>										
								</table>									
							</div>								
						  </div>
						</div>
						<!--issues-area-->
					</div>
				</div>
			</div>
			<!--profile-area--end-->
		</div>
		<div class="four wide column"></div>
	</div>
</div>

<!--right-sidebar-area-start-->
<a href="javascript:void(0)" class="right-sidebar-opener">
	<i class="fas fa-angle-double-left"></i>
</a>
<div class="right-sidebar-area">
	<div class="row">
		<div class="col-md-12 mb-20">
			<h3 class="tab-headding">Account Details</h3>
		</div>
		<div class="col-md-12 mb-20">
			@if(auth()->user()->ivr_access==1 && Laralum::hasPermission('laralum.member.makecall'))
			<a type="button" class="btn btn-lg btn-primary btn-theme" onclick="callFunction()">
				<input type="hidden" id="member_mobile_number" value="{{ $lead->mobile }}">
				<input type="hidden" id="caller_unique_id"
					value="{{ auth()->user()->ivr_uuid }}">
				<i class="fa fa-phone"></i>&nbsp;
				<span id="call">Call</span>
				<span id="calling" style="display: none;">
					<img src="{{ asset('crm_public/images/calling.png') }}"
						class="loading-img" />
				</span>
			</a>
			@endif
			@if(Laralum::hasPermission('laralum.member.sendsms'))
			<button type="button" class="btn btn-lg btn-primary btn-theme" data-toggle="modal"
				data-target="#SMSModal">
				<i class="fa fa-comment"></i>&nbsp; Send SMS
			</button>
			@endif
			@if(!$lead->mobile_verified)
			<button type="button" id="verify_mobile" class="btn btn-lg btn-primary btn-theme"
				data-mobile="{{$lead->mobile}}">
				<i class="fa fa-phone"></i>&nbsp; Verify Number
			</button>
			@endif
			<div class="alert alert-success mt-2" id="calling_success_msg" style="display:none">
			</div>
			<div class="alert alert-danger mt-2" id="calling_error_msg" style="display:none">
			</div>
		
		</div>
		
		<!--payment-method-->
		@if(Laralum::loggedInUser()->su || Laralum::loggedInUser()->isReseller)
			@if(!Laralum::loggedInUser()->RAZOR_KEY)
			<div class="card col-md-12" style="margin-bottom: 20px; padding: 15px 0 15px 0px;">
				<div class="col-md-12">
					<h4><i class="fa fa-credit-card" aria-hidden="true"></i> Get paid faster with online payment gateways
					</h4>
					<p>Setup a payment gateway and start acepting payments online.
						<a href="{{ route('console::profile') }}#Payments" id="donationForm"><span id="hide_donation_text">Set up Now</span></a>
					</p>
				</div>
			</div>
			@endif
		@endif
		<!--payment-method-->
		
		@if(!empty($lead->account_type))
		<div class="col-md-12">
			<table class="table sidebar-table">
				<tr>
					<th width="40%">Account Type</th>
					<td width="60%">{{ $lead->account_type ?? '' }}</td>
				</tr>
			</table>
		</div>
		@endif
		@if(!empty($lead->department))
		<div class="col-md-12">
			<table class="table sidebar-table">
				<tr>
					<th width="40%">Department</th>
					<td width="60%">{{ $lead->department}}</td>
				</tr>
			</table>
		</div>
		@endif
		@if(!empty($lead->member_type))
		<div class="col-md-12">
			<table class="table sidebar-table">
				<tr>
					<th width="40%">Member Type</th>
					<td width="60%">
					@foreach(unserialize($lead->member_type) as $type)
						<p>{{ $type}}</p>
						@endforeach
					</td>
				</tr>
			</table>
			
		</div>
		@endif
		@if(!empty($lead->lead_source))
		<div class="col-md-12">
		<table class="table sidebar-table">
			<tr>
				<th width="40%">Lead Source</th>
				<td width="60%">{{ $lead->lead_source ?? '' }}</td>
			</tr>
		</table>
		</div>
		@endif

	</div>
	<!--Personal details-->
	<div class="row">
		<div class="col-md-12">
			<hr />
		</div>
		<div class="col-md-12">
			<h3 class="tab-headding mb-20">Personal Details</h3>
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
			<img src="{{ asset('crm/leads') }}/{{ $lead->id_proof }}" alt=""
				class="img-thumbnail mx-auto d-block img-fluid" id="selected_proof">
		</div>
		@endif
		<div class="col-md-12 mt-10">
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
					<option
						{{ old('sms_language', $lead->sms_language == 'English' ? 'selected': '') }}>
						English</option>
					<option
						{{ old('sms_language', $lead->sms_language == 'Telugu' ? 'selected': '') }}>
						Telugu</option>
				</select>
			</div>
		</div>
		@else
		<div class="col-md-12" style="display: none" id="sms_languages">
			<div class="form-group">
				<label>Sms Language</label>
				<select class="form-control custom-select" id='sms_lang' name="sms_language">
					<option
						{{ old('sms_language', $lead->sms_language == 'English' ? 'selected': '') }}>
						English</option>
					<option
						{{ old('sms_language', $lead->sms_language == 'Telugu' ? 'selected': '') }}>
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
	<div class="row">
	<div class="col-md-12">
		<hr />
	</div>
	<div class="col-md-12">
		<h3 class="tab-headding mb-20">Address Details</h3>
	</div>

	<?php
	if(MembersController::is_serialized($lead->address)){
	?>								
	@if ($lead->address!=null && $lead->address!='' && unserialize($lead->address)!=null &&
	unserialize($lead->address)[0]!='')
	<div class="col-md-12">
		<div class="mat_card">
			<div class="max">
				@foreach(unserialize($lead->address) as $key => $address)
				<div class="" onclick="makePermanent(this)" data_id="{{$key}}"
					data_values="{{($lead->address_type)}}"
					style="{{unserialize($lead->address_type)[$key]=='permanent'?"border: 1px solid #f9ba48":"border:none "}}">
					<span class="badge badge-info" style="float: right;
						margin: 10px 10px 10px 0;
					">{{unserialize($lead->address_type)[$key]=='permanent'?"Permanent":"Temporary"}}</span>
					
					<table class="table sidebar-table mb-0">
						<tr>
							<th>Address</th>
							<td>{{ $address ?? '' }}</td>
						</tr>
						<tr>
							<th>District</th>
							<td>{{ $district[$key]->DistrictName ?? '' }}</td>
						</tr>
						<tr>
							<th>State</th>
							<td>{{ $state[$key]->StateName ?? '' }}</td>
						</tr>
						@if(!empty($countries[$key]))
						<tr>
							<th>Country</th>
							<td>{{ $countries[$key]->country_name ?? '' }}</td>
						</tr>
						@else 
						@endif
					</table>
				
				</div>
				@endforeach
			</div>
		</div>
	</div>
	@else
	<div class="col-md-12 text-center">
		<b>DATA NOT FOUND.</b>
	</div>
	@endif
	<?php
	}else{

	if ($lead->address!=null && $lead->address!='')
	{
		?>
		<div class="col-md-12">
			<div class="mat_card">
				<div class="max">
					<div class="add_card" onclick="makePermanent(this)" data_id=""
						data_values="{{($lead->address_type)}}"
						style="border: 2px solid #008000">
						<span class="badge badge-info" style="float: right;
							margin-bottom: 20px;
						">permanent</span>
						
						<table class="table sidebar-table">
							<tr>
								<th>Address</th>
								<td>{{ $lead->address ?? '' }}</td>
							</tr>
							<tr>
								<th>District</th>
								<td>{{ $lead->district ?? '' }}</td>
							</tr>
							<tr>
								<th>State</th>
								<td>{{ $lead->state ?? '' }}</td>
							</tr>
							@if(!empty($countries))
							<tr>
								<th>Country</th>
								<td>{{ $lead->countries ?? '' }}</td>
							</tr>
							@else
							@endif
						</table>
						
					</div>
				</div>
			</div>
		</div>

		<?php
		}else{
		?>
			<div class="col-md-12 text-center">
				<b>DATA NOT FOUND.</b>
			</div>
			<?php
			}
	}
	?>
	</div>
	<!--address-details-->
	<!--family-details-->
	@if (count($family_member) > 0)
	<div class="row">
		<div class="col-md-12">
			<hr />
		</div>
		<div class="col-md-12">
			<h3 class="tab-headding mb-20">Family Details</h3>
		</div>
		
		<div class="col-md-12">
		
		@foreach($family_member as $key => $members)
		<div class="card sidebar-family-card mt-15">
		<div class="card-body">
			<table class="table sidebar-table mb-0">
				<tr>
					<th width="10%"><i class="fas fa-user"></i></th>
					<td width="90%">{{ $members->member_relation_name ?? '' }}</td>
				</tr>
				<tr>
					<th><i class="fas fa-heart"></i></th>
					<td>{{ $members->member_relation ?? '' }}</td>
				</tr>
				<tr>
					<th><i class="fas fa-calendar"></i></th>
					<td>{{ ($members->member_relation_dob != '1970-01-01' && $members->member_relation_dob != '0000-00-00') ? date("jS F, Y", strtotime($members->member_relation_dob)) : ''}}</td>
				</tr>
				<tr>
					<th><i class="fas fa-phone"></i></th>
					<td>{{ $members->member_relation_mobile ?? '' }}</td>
				</tr>
			</table>
		</div>
		</div>
		@endforeach
		</div>
	</div>
	@endif
	<!--family-details-->

</div>
<!--right-sidebar-area-end-->
<!-- edit-note-popup -->
<div id="EditNote" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Note</h4>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data" id="update_note_form" action="javascript:void(0)">
					{{ csrf_field() }}
					<input type="hidden" id="issues_id" name="issues_id" />
					<div class="form-group">
						<select class="form-control custom-select" id="update_status" name="update_status">
							<option value="">Select status</option>
							<option value="1">Resolved</option>
							<option value="2">Pending</option>
						</select>
						<small id="show_update_status_error" style="color:#FF0000;display:none;">Please select
							status</small>
					</div>
					<div class="form-group">
						<textarea placeholder="Write note here.." class="form-control" id="update_issues"
							name="update_issues"></textarea>
						<small id="show_update_issue_error" style="color:#FF0000;display:none;">Please enter
							note</small>
					</div>
					<div class="text-right">
						<button type="submit" id="editNoteForm" class="ui teal submit button"><span
								id="hide_update_note_text">UPDATE</span>&nbsp;
							<span class="editNoteForm" style="display:none;"><img
									src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
						</button>
					</div>
				</form>
			</div>

		</div>

	</div>
</div>
<!--edit-note-popup-->
<!-- add-note-popup-->
<div id="AddNote" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Request</h4>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data" id="save_note_form" action="javascript:void(0)">
					{{ csrf_field() }}
					<input type="hidden" id="member_issue_id" name="member_issue_id" />
					<div class="form-group">
						<input type="text" class="form-control" id="request_add" name="prayer_request"
							style="display: none">
						<select class="form-control custom-select" name="issues" id="issues_dropdown">
							<option value="">Please select..</option>
							@foreach($prayer_requests as $request)
							<option value="{{ $request->prayer_request }}">
								{{ $request->prayer_request }}
							</option>
							@endforeach
							<option value="add">Add Value</option>
						</select>
						<small id="show_issue_error" style="color:#FF0000;display:none;">Please enter
							Request</small>
					</div>
					<div class="text-right">
						<button type="submit" id="noteForm" class="ui teal submit button"><span
								id="hide_note_text">SAVE</span>&nbsp;
							<span class="noteForm" style="display:none;"><img
									src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- add-note-popup -->


<!-- add-Donation-popup-->
<div id="AddDonation" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Donation</h4>
			</div>
			<div class="modal-body">
			<form class="ui form" action="javascript:void(0)" method="POST" enctype="multipart/form-data"
				id="upload_donation_form">
				{{ csrf_field() }}
				<input type="hidden" id="lead_id" name="lead_id" value="{{$lead->id}}"/>
				<div class="lead_data" style="display:none;">
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Donation Type<span style="color:red;">*</span></label>
							<select id="member_type_id" name="donation_type" class="form-control custom-select">
								<option value="">Please select..</option>
								@foreach($membertypes as $type)
								<option value="{{ $type->type }}"
									{{ (old('donation_type') == $type->type ? 'selected': '') }}>
									{{ $type->type }}
								</option>
								@endforeach
								<option value="add">Add Value</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Donation Purpose<span style="color:red;">*</span></label>
							<select id="donation_purpose" name="donation_purpose"
								class="form-control custom-select">
								<option value="">Please select..</option>
								@foreach($donation_purposes as $purpose)
								<option value="{{ $purpose->purpose }}"
									{{ (old('donation_purpose') == $purpose->purpose ? 'selected': '') }}>
									{{ $purpose->purpose }}
								</option>
								@endforeach
								<option value="add">Add Value</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Payment Type<span style="color:red;">*</span></label>
							<select id="payment_type" name="payment_type" class="form-control custom-select"
								onchange="stateChange(this)">
								<option value="">Please select..</option>
								<option value="single" {{ (old('payment_type') == 'single' ? 'selected': '') }}>
									Single</option>
								<option value="recurring"
									{{ (old('payment_type') == 'recurring' ? 'selected': '') }}>Recurring</option>
							</select>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Payment Mode<span style="color:red;">*</span></label>
							<select id="payment_mode" name="payment_mode" class="form-control custom-select">
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
							<label>Payment Status<span style="color:red;">*</span></label>
							<select id="payment_status" name="payment_status" class="form-control custom-select">
								<option value="">Please select..</option>
								<option value="0">Not Paid</option>
								<option value="1">Paid</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group ">
							<label>Location</label>
							<select class="form-control custom-select" name="location" id="location">
								<option value="">Please select..</option>
								@foreach($branches as $branch)
								<option value="{{ $branch->branch }}"
									{{ (old('location') == $branch->branch ? 'selected': '') }}>
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
							<label>Amount<span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="amount"
								placeholder="Please enter the amount" name="amount" />
						</div>
					</div>


					<div class="col-md-6 period" style="display: none">
						<div class="form-group">
							<label>Payment Period<span style="color:red;">*</span></label>
							<select id="payment_period" name="payment_period" class="form-control custom-select">
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
							<label>Payment Start Date<span style="color:red;">*</span></label>
							<input type="date" class="form-control" id="start_date" name="payment_start_date"
								value="{{old('start_date')}}">
						</div>
					</div>
					<div class="col-md-6 end" style="display: none">
						<div class="form-group">
							<label>Payment End Date<span style="color:red;">*</span></label>
							<input type="date" class="form-control" id="end_date" name="payment_end_date"
								value="{{old('end_date')}}">
						</div>
					</div>
					<div class="col-md-6" id="reference_no_field" style="display:none">
						<div class="form-group">
							<label>Reference No.<span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="reference_no" name="reference_no"
								placeholder="Please enter the reference no" />
						</div>
					</div>
					<div class="col-md-6" id="bank_name_field" style="display:none">
						<div class="form-group">
							<label>Bank<span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="bank_name" name="bank_name"
								placeholder="Please enter the bank name" />
						</div>
					</div>

					<div class="col-md-6" id="cheque_number_field" style="display:none">
						<div class="form-group">
							<label>Cheque Number<span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="cheque_number" name="cheque_number"
								placeholder="Please enter the check no." />
						</div>
					</div>

					<div class="col-md-6" id="branch_name_field" style="display:none">
						<div class="form-group">
							<label>Branch<span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="branch_name" name="branch_name"
								placeholder="Please enter the branch name" />
						</div>
					</div>

					<div class="col-md-6" id="cheque_date_field" style="display:none">
						<div class="form-group">
							<label>Cheque Issue Date<span style="color:red;">*</span></label>
							<input type="date" class="form-control" id="cheque_date" name="cheque_date"
								placeholder="Please select the cheque issue date" />
						</div>
					</div>
					<div class="col-md-6" id="payment_method_field" style="display:none">
						<div class="form-group">
							<label>Payment Method<span style="color:red;">*</span></label>
							<input type="text" class="form-control" id="payment_method" name="payment_method"
								placeholder="Please enter the method name" />
						</div>
					</div>
				</div>
				<div class=" text-right mb-30 mt-30">
					<button type="submit" id="donationForm"
						class="ui {{ Laralum::settings()->button_color }} submit button"><span
							id="hide_donation_text">{{ trans('laralum.save') }}</span>&nbsp;
						<span class="donationForm" style="display:none;"><img
								src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
					</button>
				</div>
				<div class="history_data" style="display:none;">
				</div>

			</form>
			</div>
		</div>
	</div>
</div>
<!-- add-Donation-popup -->
@endsection
@section('js')
<script src="{{ asset('crm_public/js/member-script.js') }}" type="text/javascript"></script>
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
			data: {uuid:caller_uuid,mobile:member_num},
			success: function (data) {			
				if(data.status=='success'){
					 $('#call').css('display', 'inline-block');
		             $('#calling').css('display', 'none');
					 $('#calling_success_msg').html(data.message);
					 $('#calling_success_msg').show();
				}else {				
					$('#call').css('display', 'inline-block');
		             $('#calling').css('display', 'none');
					 $('#calling_error_msg').html(data.message);
					 $('#calling_error_msg').show();
				}
			}
		})
		                   
   }
/*send message*/
$('#send_message').click(function () {
    $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})       
	var msg = $("#msg_str").val();
	if(msg==''){
		$("#show_msg_str_error").show();
	}else{
		$("#show_msg_str_error").hide();
	}
	var sender = $("#sender_id").val();
	var receiver = $("#receiver_id").val();		
	var receiver_mobile = $("#receiver_mobile").val();		
	$('#send_message').html('SENDING..');
	$.ajax({
		type: 'post',
		url: "{{ route('Crm::send_message') }}",
		data: {sender:sender,receiver:receiver,receiver_mobile:receiver_mobile,msg:msg},
		success: function (data) {			
			if(data.status=='success'){
				 $('#send_message').html('SEND');
				 $('#msg_str').val('');
				 $('#SMSModal').modal('hide');
				 $('#calling_success_msg').html(data.message);
				 $('#calling_success_msg').show();
				 setTimeout(function(){							
				    location.reload();
				}, 3000);
			}else {				
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
function deleteManualCallLog(id){	
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
					data: {id:id},
					success: function (data) {			
						if(data.status=='success'){
							 location.reload();
						}else {				
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
$('.profile_img_btn').hover(function()
{
	$('#profile_pic').attr('src',"{{ asset('crm_public/images/select-profile.jpg') }}");
}, function()
{ 
	$('#profile_pic').attr('src',$('#profile_pic').attr('data-src'));

});

$('.mobile_phone,.gender,.dob,.doj,.email,.name,.married_status,.blood_group').hover(function()
{
	 // Mouse Over Callback
	 var edit_btn =$(this).children().eq(3);
	 var save_btn =$(this).children().eq(4);
	 var edit_input =$(this).children().eq(2);
	 var value =$(this).children().eq(1);
 if(save_btn.is(":hidden"))
	 edit_btn.show(200);

	 edit_btn.click(function(){
		edit_input.show();
		save_btn.show();
		value.hide();
		edit_btn.hide();
		
		save_btn.click(function () {
          
			var values = edit_input.children().eq(0).val();
			var type = edit_input.children().eq(0).attr("data-type");

			
			if(values==''){
				swal('Warning!', 'It can not be empty!', 'warning')
				return false;
			}
			
			updateData(values,type);
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
	
}, function()
{ 
	var element =$(this).children().eq(3);
	 element.hide(200);
});


$("#sms_lang").change(function(){		
	updateData($(this).val(),'sms_language');
});
$('#call').change(function () {
	 updateData(this.checked?1:0,'call_required');
});
 $('#sms').change(function () {
	 if(this.checked)
	 $('#sms_languages').show();
	 else
	 $('#sms_languages').hide();
	updateData(this.checked?1:0,'sms_required');
});

$('.profile_img_btn').bind("click"
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
	$('#profile_pic').attr('src',
	e.target.result);
	}
	reader.readAsDataURL(input.files[0]);
	}
	}
	$("#profile_img").change(function(){
		if(Math.floor($("#profile_img")[0].files[0].size/1000)>2048)	{
			swal('Error!', 'File must not be greater than 2 mb!', 'error')
			return;
		}	
		updateData($("#profile_img")[0].files[0],'profile_photo');
		readURL(this);
	});
	

	function makePermanent(object){
		var id=$('#lead_id').attr("data-id");
		var fd = new FormData();
		fd.append('index',$(object).attr('data_id'));
		fd.append('id',id);
		fd.append('values',$(object).attr('data_values'));
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
			success: function (data) {			
				if(data.status=='success'){
					
					location.reload();
				}
			}
		});
	}
	function updateData(value,type) {
		var id=$('#lead_id').attr("data-id");

		var fd = new FormData();
		fd.append('data',value);
		fd.append('editType',type);
		fd.append('id',id);
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		}) 
		$.ajax({
			type: 'post',
			url: "{{ route('Crm::inline_update') }}",
			processData: false,
			contentType: false,
			data: fd,
			success: function (data) {			
				if(data.status=='success'){
					if(type=='profile_photo'){
						var name={!! json_encode(url('/').'/crm/leads/') !!}+data.profile_image;
						$('#profile_pic').attr('data-src',name);
					}
					
					// location.reload();
				}else {				
					swal({ title: "Error!", text: "Mobile number has already been taken!", type: "error" }, function(){ location.reload(); });
				}
			}
		})
	}
	

/*delete message*/
var maxchars = 250;
$('textarea').keyup(function () {
    var tlength = $(this).val().length;
    $(this).val($(this).val().substring(0, maxchars));
    var tlength = $(this).val().length;
    remain = maxchars - parseInt(tlength);
	if(remain<=10){	
		$(".text-remain").css("color", "red");
	}else{
		$(".text-remain").css("color", "");
	}
    $('#rchars').text(remain);
});

$(document).on('click','#addNotePopup',function(e) {
	var id=$('#lead_id').attr("data-id");
	$('#member_issue_id').val(id);
});
</script>
<script>
	$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
<script>
	$(document).on('click','#editNoteButton',function(e) {
	$('#issues_id').val($(this).attr('data-id'))
	$("#EditNote #update_status option[value="+$(this).attr('data-status')+"]").attr('selected', 'selected');
	$('#update_issues').val($(this).attr('data-text'))
});

//request otp
$('#verify_mobile').click(function () {
	
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})       
	
	var sender =$('#lead_id').attr("data-id");
	var receiver_mobile = $(this).attr('data-mobile');
	var my_url = APP_URL+'/crm/admin/send_otp';

	$('#receiver_mobile').val(receiver_mobile);

	$.ajax({
		type: 'post',
		url: my_url,
		data: {sender:sender,receiver_mobile:receiver_mobile},
		success: function (data) {			
			if(data.status=='success'){
				$('#EnterOTP').modal('show');		    

				//  setTimeout(function(){							
				//     location.reload();
				// }, 3000);
			}else {				
				$('#verify_label').html('Resend');
			}
		}
	});

	
});
//verify_otp
$('#otp_form').submit(function(e) {
	e.preventDefault();		
	var otp = $('#otp').val();
	if(otp==''){
	  $('#show_otp_error').show();
	  return false;
	}
	var formData = new FormData(this); 
	var type = "POST"; 
	var my_url = APP_URL+'/crm/admin/verify_otp';

	$.ajaxSetup({
	   headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	 }
	})			    
	$.ajax({
		type: type,
		url: my_url,
		data: formData,
		processData: false,
		contentType: false,
		dataType: 'json',
		success: function (data) {
			if(data.status=='success'){
				$('#EnterOTP').modal('hide');		    
			swal({ title: "Success!", text: "The Otp has been verified!", type: "success" }, function(){ location.reload(); });			    				
		
				}else {				
					$('#show_otp_error').show();
			$('#show_otp_error').text("Worng Otp");				}
			},
		error: function (data) {
			$('#show_otp_error').show();
			$('#show_otp_error').text("Worng Otp");

			console.log('Error:', data);
		}
	});
	 
});	

</script>
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

	<!-- Otp modal start-->
		<div id="EnterOTP" class="modal fade" role="dialog">
			<div class="modal-dialog modal-sm">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close"
							data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Verify Otp</h4>
					</div>
					<form method="POST" enctype="multipart/form-data" id="otp_form"
						action="javascript:void(0)">
						<div class="modal-body">
							<div class="form-group">
								<label>Enter OTP</label>
								<input type="number" name="otp" id="otp"
									class="form-control" />
								<small id="show_otp_error"
									style="color:#FF0000;display:none;">Please enter
									OTP</small>

								<input type="hidden" name="receiver_mobile"
									placeholder="Enter Otp" id="receiver_mobile"
									class="form-control" />
							</div>
							<div class="form-group">
								<button type="submit" id="editMemberForm"
									class="ui teal submit button"><span
										id="hidebutext">Verify</span>&nbsp;
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--sms-modal-start-->
		<div class="modal" id="SMSModal">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					<!-- Modal Header -->
					<div class="modal-header">
						<button type="button" class="close"
							data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-comment"></i>&nbsp;SEND SMS
						</h4>

					</div>
					<div class="modal-body">
						<form>
							<div class="form-group">
								<div class="text-left text-remain" id="rtext"><small><span
											id="rchars">250</span> Character(s)
										Remaining</small></div>
								<textarea class="form-control" rows="3" id="msg_str"
									placeholder="Type a message"></textarea>
								<div class="text-left" id="show_msg_str_error"
									style="color:red;display:none;">This field is required.
								</div>
								<input type="hidden" id="receiver_mobile"
									value="{{ $lead->mobile }}" />
								<input type="hidden" id="receiver_id"
									value="{{ $lead->id }}" />
								<input type="hidden" id="sender_id"
									value="{{ auth()->user()->id }}" />
							</div>
							<div class="text-right">
								<button type="button"
									class="btn btn-sm btn-primary text-uppercase"
									id="send_message">SEND</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!--sms-modal-end-->

<script src="{{ asset('crm_public/js/donation-script.js') }}" type="text/javascript"></script>
<script src="{{ asset(Laralum::publicPath() .'/js/datatables.min.js') }}" type="text/javascript"></script>
<link href="{{ asset(Laralum::publicPath() .'/css/datatables.min.css') }}" type="text/css" rel="stylesheet" />
<script type="text/javascript">
$(document).ready(function() {
   $('#issuesTable').DataTable({
	   language: {
		 sLengthMenu: "_MENU_",
		  paginate: {
			  next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
			  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'  
			}
        },
		  
		"searching": false,
		"columnDefs": [
              { "orderable": false, "targets": [4] }   
         ],
		 
         processing: true,
         serverSide: true,
         ajax: "{{ route('Crm::get_member_prayer_request', ['id' => $lead->id]) }}",
         columns: [
            { data: 'issue' },
            { data: 'created_at' },
            { data: 'created_by' },
            { data: 'status' },
            { data: 'action' },
         ]
      });
	  
	$('#donationTable').DataTable({
	   language: {
		 search: "_INPUT_",
		 searchPlaceholder: "Search...",
		 sLengthMenu: "_MENU_",
		  paginate: {
			  next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
			  previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'  
			}
        },
		"columnDefs": [
              { "orderable": false, "targets": [6] }   
         ],
		 
         processing: true,
         serverSide: true,
         ajax: "{{ route('Crm::get_member_donation', ['id' => $lead->id]) }}",
         columns: [
            { data: 'receipt_number' },
            { data: 'payment_type' },
            { data: 'amount' },
            { data: 'payment_mode' },
            { data: 'payment_status' },
            { data: 'created_at' },
            { data: 'action' },
         ]
      });
  });
</script>
<script>
$(document).ready(function() {
  	$('.dimmer').removeClass('dimmer');
	//Call checkdonationstatus function
	checkdonationstatus();
	//setInterval(checkdonationstatus, 5000);
});
</script>
<script type="text/javascript">
	/**
		 *@author {Previous devloper}
		 *@updatedBy {Paras}
		 *@description {Function to handle payment method field selection}
	*/
	$(function () {
        $("#payment_mode").change(function () {
            if ($(this).val() == "CHEQUE") {
                $("#cheque_date_field").show();
                $("#bank_name_field").show();
                $("#cheque_number_field").show();
                $("#branch_name_field").show();
				$(".payment-status").show();
				$("#reference_no_field").hide();
				$("#payment_method_field").hide();
			} 
			else if($(this).val() == "OTHER"){
				$("#payment_method_field").show();     
				$(".payment-status").show();  
				$("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();   
				$("#reference_no_field").hide();     
			}
			else if ($(this).val() == "QRCODE") {
                $("#reference_no_field").show();  
				$(".payment-status").show();   
				$("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();  
				$("#payment_method_field").hide();         
            }
			else if ($(this).val() == "CASH") {
				$(".payment-status").show();  
				$("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();   
				$("#reference_no_field").hide();   
				$("#payment_method_field").hide();      
            }
			else if ($(this).val() == "CARD") {
				$(".payment-status").show();  
				$("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();  
				$("#reference_no_field").hide();  
				$("#payment_method_field").hide();        
            }
			else {
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
var value=object.value;
if(value=='recurring'){
	$('.start').show();
	$('.end').show();
	$('.period').show();
}
else{
	$('.start').hide();
	$('.end').hide();
	$('.period').hide();
}
}

$(document).on('change', '#member_type_id', function(e) {
	//Selected value
	var inputValue = $(this).val();
		//Ajax for calling php function
			if ('add' == inputValue){
			$("#detail_type").val(1);
		$("#AddDetails").modal("show");
	}
});
$('#location').change(function(){
		//Selected value
		var inputValue = $(this).val();
		//Ajax for calling php function
		 if ('add' == inputValue){
			$("#detail_type").val(4);
	  $("#AddDetails").modal("show");
  }
});

$('#donation_purpose').change(function(){
		//Selected value
		var inputValue = $(this).val();
		//Ajax for calling php function
		 if ('add' == inputValue){
			$("#detail_type").val(2);
	  $("#AddDetails").modal("show");
  }
});

$(document).on('submit', '#add_detail', function (e) {
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
		else if($('#detail_type').val()==2){
			my_url=APP_URL + '/console/manage/insertDonationpurpose';
			formData.append('purpose',detail);
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
					text: "Data has been submited!",
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

//Our checkdonationstatus function.
function checkdonationstatus(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	
	my_url = APP_URL + '/crm/admin/checkdonationstatusbylead/{{$lead->id}}';
	console.log(my_url);
	var type = "GET";
	$.ajax({
		type: type,
		url: my_url,
		dataType: 'json',
		success: function (data) {
			$.each(data, function( index, value ) {
				if(value.payment_status){
					$("#donation-"+value.id).html('<span class="badge badge-success">Paid</span>');
				}else{
					$("#donation-"+value.id).html('<span class="badge badge-danger">Pending</span>');
				}				
			});
			setTimeout(checkdonationstatus, 5000)
		},
		error: function (data) {
			//swal('Error!', data, 'error')
		}
	});
}

/*send Payment link SMS*/
$('#send_payment_link_sms').click(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	}); 
	var donation_id = $(this).attr('data-id');
	$.ajax({
		type: 'post',
		url: "{{ route('Crm::send_payment_link_sms') }}",
		data: {donation_id:donation_id},
		success: function (data) {							
			swal({
				title: "Success!",
				text: data.message,
				type: "success"
			}, function () {
				//ocation.reload();
			});			
		}
	})	
});

/*Update donation status to piad*/
$('#update_payment_status_paid').click(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	}); 
	var donation_id = $(this).attr('data-id');
	$.ajax({
		type: 'post',
		url: "{{ route('Crm::updateDonationPaymentDetail') }}",
		data: {donation_id:donation_id},
		success: function (data) {							
			swal({
				title: "Success!",
				text: data.message,
				type: "success"
			}, function () {
				//ocation.reload();
			});			
		}
	})	
});
</script>

<script>
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});
</script>

<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
});
</script>
<script src="{{ asset(Laralum::publicPath() .'/js/selectron.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$('#logged_member_id').selectron();
	$('#logged_outcome').selectron();
	$('#outcome').selectron();
	$('#member_id').selectron();

	$(".right-sidebar-opener").click(function(){
	  $(".right-sidebar-area").toggleClass("active");
	  $(".right-sidebar-opener").toggleClass("show");
	});

	$(".right-sidebar-opener").click(function(){
	  $(".profile-view-tab").toggleClass("middle-area-short");
	});

	$('.right-sidebar-opener').click(function() {
		$("i", this).toggleClass("fa-angle-double-left fa-angle-double-right");
	});
</script>
<!-- Modal -->
<div id="LogCall" class="modal fade" role="dialog">
 <div class="modal-dialog moda-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;Log Call</h4>
      </div>
	<form method="POST" enctype="multipart/form-data" id="manual_call_log_frm" action="javascript:void(0)">
	   {{ csrf_field() }}
        <div class="modal-body">
        <div class="row">
        <div class="col-md-12">
		  <div class="call-details">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Contacted</label>
						<select data-selectron-search="false" id="member_id" name="member_id">
							<option value="{{ $lead->id }}" selected>{{ $lead->name ?? '' }}</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
				    <label>Outcome</label>
					<select data-selectron-search="false" id="outcome" name="outcome">
						<option value="busy">Busy</option>
						<option value="connected">Connected</option>
						<option value="left_live_message">Left live message</option>
						<option value="left_voicemail">Left voicemail</option>
						<option value="no_answer">No answer</option>
						<option value="wrong_answer">Wrong number</option>
					</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Date</label>
						<input type="date" class="inp-date-time" id="log_date" name="log_date" />
						<span id="log_date_error" style="color:red;display:none;">Please Choose Date...</span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Time</label>
						<input type="time" class="inp-date-time" id="log_duration" name="log_duration" />
						<span id="log_duration_error" style="color:red;display:none;">Please enter duration.</span>
					</div>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<textarea class="form-control log-inp-txt" placeholder="Add description" id="log_description" name="log_description"></textarea>
				<span id="log_description_error" style="color:red;display:none;">Please add description.</span>
			</div>
			<div class="form-group text-right">
				<button type="submit" id="addCallLogForm" class="ui teal submit button"><span id="hidecalllogext">Log Activity</span>&nbsp;
				<span class="addCallLogForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
			</button>
		 </div>
		</div>
      </div>
      </div>
     </form>
    </div>
  </div>
</div>
<style>
.card {
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
	transition: 0.3s;
	border-radius: 5px;

	padding: 5px;
	background-color: white;
}

.card:hover {
	box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

.col-md-3.qualification {
	margin-bottom: 35px;
}

.page-content
{
	padding-top: 0;
}

.menu-pusher
{	
	padding-left: 350px !important;
	background-color:#F6FFFF;
}


.ui.segment
{
	background: transparent;
}

.tab-content {
    background: transparent;
}

.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover
{
	background-color: transparent;
}
 .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20px; }
  .toggle.ios .toggle-handle { border-radius: 20px; }
  
  div.dataTables_wrapper div.dataTables_processing {
    background: #26476c !important;
    color: #fff !important;
}

table.dataTable thead .sorting_asc::after, table.dataTable thead .sorting_desc::after {
    color: #f9ba48;
}

</style>
@endsection