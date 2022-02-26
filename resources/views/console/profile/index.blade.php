@extends('layouts.console.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
	<div class="active section">{{ trans('laralum.profile_manager') }}</div>
</div>
@endsection
@section('title', trans('laralum.profile_manager'))
@section('content')
<div class="parent">
	<div class="column">
		<div class="ui very padded segment">
			<div class="col-md-12">
				<ul class="nav nav-tabs">
					<li class="active"><a class="ripple" data-toggle="tab" href="#OrganizationProfile"><i
								class="fa fa-sitemap" aria-hidden="true"></i><span>ORGANIZATION</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#General"><i class="fa fa-cog"
								aria-hidden="true"></i><span>GENERAL</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#Branches"><i class="fa fa-building"
								aria-hidden="true"></i><span>BRANCH</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#Departments"><i class="fa fa-object-group"
								aria-hidden="true"></i><span>DEPARTMENTS</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#Roles"><i class="fa fa-briefcase"
								aria-hidden="true"></i><span>ROLES</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#Staff"><i class="fa fa-users"
								aria-hidden="true"></i><span>STAFF</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#Donation"><i class="fa fa-money"
								aria-hidden="true"></i><span>DONATION</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#Member"><i class="fa fa-users"
								aria-hidden="true"></i><span>Members</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#Payments"><i class="fa fa-credit-card"
								aria-hidden="true"></i><span>PAYMENTS</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#TimeSlot"><i class="fa fa-clock-o"
								aria-hidden="true"></i><span>TIME SLOT</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#ChangePaasword"><i class="fa fa-unlock-alt"
								aria-hidden="true"></i><span>CHANGE PASSWORD</span></a></li>
					<li><a class="ripple" data-toggle="tab" href="#PrayerRequest"><i class="fa fa-question-circle"
								aria-hidden="true"></i><span>Prayer Requests</span></a></li>
					<li>
						<a class="ripple" data-toggle="tab" href="#SMSTab"><i class="fa fa-comment"
								aria-hidden="true"></i>&nbsp;<span>SMS</span></a>
					</li>
				</ul>

				<div class="tab-content">

					<!--OrganizationProfile start-->
					<div id="OrganizationProfile" class="tab-pane in active">
						<div class="col-md-8">
							<form class="form-horizontal" method="POST" enctype="multipart/form-data"
								id="upload_organization_form" action="javascript:void(0)">
								<!--01-->
								<div class="form-group">
									<label class="control-label col-sm-4 res_float_none">Your Logo:</label>
									<div class="col-sm-8 res_float_none">
										<div class="row">
											<div class="col-sm-5 res_float_none">
												@if(isset($org_profile) && !empty($org_profile->organization_logo))
												<img id="logoimage"
													src="{{ asset('console_public/data/organization') }}/{{ $org_profile->organization_logo }}"
													alt="" class="img-responsive" />
												@else
												<img id="logoimage"
													src="{{ asset('console_public/images/defalut-image-logo.jpg') }}"
													alt="" class="img-responsive" />
												@endif
												<a class="btn btn-sm btn-primary" id="profile_img_btn"
													onclick="$('.dimmer').removeClass('dimmer')">Choose Logo</a>
												<input id="logoimgselector" name="org_logo" type="file"
													class="hidden" />
												<input name="org_logo_hidden" type="hidden"
													value="{{ isset($org_profile) ? $org_profile->organization_logo : '' }}" />
											</div>


										</div>
									</div>
								</div>
								<!--01-->

								<!--02-->
								<div class="form-group">
									<label class="control-label col-sm-4 res_float_none">Organization Name&nbsp;<span
											style="color:red;">*</span>:</label>
									<div class="col-sm-8 res_float_none">
										<input type="text" class="inp" placeholder="Organization Name"
											id="organization_name" name="organization_name"
											value="{{ isset($org_profile) && !empty($org_profile->organization_name) ? $org_profile->organization_name : '' }}" />
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-sm-4 res_float_none">Company ID&nbsp;<span
											style="color:red;">*</span>:</label>
									<div class="col-sm-8 res_float_none">
										<input type="text" class="inp" placeholder="Company Id" id="company_id"
											name="company_id"
											value="{{ isset($org_profile) && !empty($org_profile->company_id) ?$org_profile->company_id: "" }}" />
									</div>
								</div>
								<!--02-->

								<!--03-->
								<div class="form-group">
									<label class="control-label col-sm-4 res_float_none">Industry&nbsp;<span
											style="color:red;">*</span>:</label>
									<div class="col-sm-8 res_float_none">
										<select id="industry" name="industry" class="inp select-style">
											<option value="">Select Industry</option>
											@foreach($industries as $key=>$val)
											<option value="{{ $key }}" @if( isset($org_profile) && $org_profile->
												industry==$key) selected="selected" @endif>{{ $val }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<!--03-->

								<!--04-->
								<div class="form-group">
									<label class="control-label col-sm-4 res_float_none">Business Location&nbsp;<span
											style="color:red;">*</span>:</label>
									<div class="col-sm-8 res_float_none">
										<input type="text" class="inp" placeholder="Business Location"
											name="business_location" id="business_location"
											value="{{ isset($org_profile) && !empty($org_profile->business_location) ? $org_profile->business_location : '' }}" />
									</div>
								</div>
								<!--04-->

								<!--06-->
								<div class="form-group">
									<label class="control-label col-sm-4 res_float_none">Company Address:</label>
									<div class="col-sm-8 res_float_none">
										<div class="mb-15">
											<input type="text" class="inp" placeholder="Address Line 1" id="address1"
												name="address1"
												value="{{ isset($org_profile) && !empty($org_profile->company_address_line1) ? $org_profile->company_address_line1 : '' }}" />
										</div>
										<div class="mb-15">
											<input type="text" class="inp" placeholder="Address Line 2" id="address2"
												name="address2"
												value="{{ isset($org_profile) && !empty($org_profile->company_address_line2) ? $org_profile->company_address_line2 : '' }}" />
										</div>
									</div>
								</div>
								<!--06-->
								<!--04-->
								<div class="form-group">
									<label class="control-label col-sm-4 res_float_none">&nbsp;</label>
									<div class="col-sm-8 res_float_none">
										<button type="submit" id="organizationForm" class="ui teal submit button"><span
												id="hideorgtext">SAVE</span>&nbsp;
											<span class="organizationForm" style="display:none;"><img
													src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
										</button>
									</div>
								</div>
								<!--04-->
							</form>
						</div>
					</div>
					<!--OrganizationProfile end-->

					<!--General-->
					<div id="General" class="tab-pane fade">
						<div class="row">
							<div class="col-md-6">
								<form class="form-horizontal" method="POST" enctype="multipart/form-data"
									id="upload_general_form" action="javascript:void(0)">
									<!--01-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">Email/Username:</label>
										<div class="col-sm-8 res_float_none">
											<input type="text" class="inp" placeholder="" id="user_name" id="user_name"
												value="{{ ($datas->email) ? $datas->email : '' }}" disabled />
										</div>
									</div>
									<!--01-->
									<!--02-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">Mobile No.:</label>
										<div class="col-sm-8 res_float_none">
											<input type="text" class="inp" placeholder="" id="mobile" name="mobile"
												value="{{ ($datas->mobile) ? $datas->mobile : '' }}" disabled />
										</div>
									</div>
									<!--02-->

									<!--03-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">Full Name:</label>
										<div class="col-sm-8 res_float_none">
											<input type="text" class="inp" placeholder="" id="fullname" name="fullname"
												value="{{ ($datas->name) ? $datas->name : '' }}" />

										</div>
									</div>
									<!--03-->


									<!--05-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">Alternate Email:</label>
										<div class="col-sm-8 res_float_none">
											<input type="text" class="inp" placeholder="" id="altemail" name="altemail"
												value="{{ ($datas->alt_email) ? $datas->alt_email : 'N/A' }}">

											<!--a href="#">Wish to receive notifications on multiple  email addresses?</a-->

										</div>
									</div>
									<!--05-->

									<!--06-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">Alternate Mobile:</label>
										<div class="col-sm-8 res_float_none">
											<input type="text" class="inp" placeholder="" id="altcontact"
												name="altcontact"
												value="{{ ($datas->alt_mobile) ? $datas->alt_mobile : 'N/A' }}">

										</div>
									</div>
									<!--06-->

									<!--07-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">Account Expiry:</label>
										<div class="col-sm-8 res_float_none">
											<input type="text" class="inp" placeholder="" id="expiry"
												value="{{ ($datas->expiry_date) ? $datas->expiry_date : 'N/A' }}">

										</div>
									</div>
									<!--07-->
									<!--08-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">&nbsp;</label>
										<div class="col-sm-8 res_float_none">
											<button type="submit" id="generalForm" class="ui teal submit button"><span
													id="hidegeneraltext">SAVE</span>&nbsp;
												<span class="generalForm" style="display:none;"><img
														src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
											</button>
										</div>
									</div>
									<!--08-->
								</form>
							</div>
						</div>
					</div>
					<!--General-->

					<!--Branches start-->
					<div id="Branches" class="tab-pane fade">

						<!-- EditBranch Modal start-->
						<div id="EditBranch" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">
								<!-- Modal content-->
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
						</div>
						<!-- EditBranch Modal end -->

						<div class="row">
							<div class="col-md-7">
								@if (count($branches) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
											<th width="60%">Branch</th>
											<th class="text-center" width="40%">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($branches as $branch)
										<tr id="branch{{$branch->id}}">
											<td>{{ $branch->branch }}</td>
											<td class="text-center">
												<a href="javascript:void(0);" id="editBranch"
													class="btn btn-sm btn-primary btn-table"
													data-branchid="{{$branch->id}}" data-branch="{{$branch->branch}}"
													data-toggle="modal" data-target="#EditBranch"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:void(0);" id="deleteData" data-id="{{$branch->id}}"
													data-type="branch"
													class="btn btn-sm btn-primary btn-table btn-danger"><i
														class="fa fa-trash-o" aria-hidden="true"></i></a>
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
							<div class="col-md-5">
								<form class="form-horizontal" method="POST" id="upload_branch_form"
									action="javascript:void(0)">
									<!--01-->
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Branch&nbsp;<span
													style="color:red;">*</span></label>
											<input type="text" class="inp" placeholder="Enter Branch" id="branch"
												name="branch">
										</div>
									</div>
									<!--01-->
									<!--04-->
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<button type="submit" id="branchForm" class="ui teal submit button"><span
													id="hidebrtext">SAVE</span>&nbsp;
												<span class="branchForm" style="display:none;"><img
														src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
											</button>
										</div>
									</div>
									<!--04-->
								</form>
							</div>
						</div>
					</div>
					<!--Branches end-->


					<!--Members start-->
					<div id="Member" class="tab-pane fade">

						<!-- EditAccountType Modal start-->
						<div id="EditAccountType" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Edit Account Type</h4>
									</div>
									<form method="POST" enctype="multipart/form-data" id="update_member_account_form"
										action="javascript:void(0)">
										<div class="modal-body">
											<div class="form-group">
												<label>Acount type</label>
												<input type="text" name="editAccountType" id="edit-account-type"
													class="form-control" />
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
						</div>
						<!-- EditAccountType Modal end -->
						<!-- EditMemberType Modal start-->
						<div id="EditMemberType" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Edit Member Type</h4>
									</div>
									<form method="POST" enctype="multipart/form-data" id="update_member_type_form"
										action="javascript:void(0)">
										<div class="modal-body">
											<div class="form-group">
												<label>Member type</label>
												<input type="text" name="editMemberType" id="edit-member-type"
													class="form-control" />
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
						</div>
						<!-- EditMemberType Modal end -->
						<!-- EditSource Modal start-->
						<div id="EditSource" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">
								<!-- Modal content-->
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
						</div>
						<!-- EditSource Modal end -->

						<div class="row">
							<div class="col-md-7">
								@if (count($sources) > 0 or count($membertypes) > 0 or count($accounttypes) > 0)
								@if(count($accounttypes) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
											<th width="60%">Account type</th>
											<th class="text-center" width="40%">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($accounttypes as $member)
										<tr id="account_type{{$member->id}}">
											<td>{{ $member->type }}</td>
											<td class="text-center">
												<a href="javascript:void(0);" id="editaccountType"
													class="btn btn-sm btn-primary btn-table"
													data-accountid="{{$member->id}}" data-val="{{$member->type}}"
													data-toggle="modal" data-target="#EditAccountType"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:void(0);" id="deleteData" data-id="{{$member->id}}"
													data-type="account_type"
													class="btn btn-sm btn-primary btn-table btn-danger"><i
														class="fa fa-trash-o" aria-hidden="true"></i></a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								@endif
								@if(count($membertypes) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
											<th width="60%">Member type</th>
											<th class="text-center" width="40%">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($membertypes as $member)
										<tr id="member_type{{$member->id}}">
											<td>{{ $member->type }}</td>
											<td class="text-center">
												<a href="javascript:void(0);" id="editmemberType"
													class="btn btn-sm btn-primary btn-table"
													data-memberid="{{$member->id}}" data-val="{{$member->type}}"
													data-toggle="modal" data-target="#EditMemberType"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:void(0);" id="deleteData" data-id="{{$member->id}}"
													data-type="member_type"
													class="btn btn-sm btn-primary btn-table btn-danger"><i
														class="fa fa-trash-o" aria-hidden="true"></i></a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								@endif
								@if(count($sources) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
											<th width="60%">Sources</th>
											<th class="text-center" width="40%">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($sources as $member)
										<tr id="source{{$member->id}}">
											<td>{{ $member->source }}</td>
											<td class="text-center">
												<a href="javascript:void(0);" id="editmemberSource"
													class="btn btn-sm btn-primary btn-table"
													data-sourceid="{{$member->id}}" data-val="{{$member->source}}"
													data-toggle="modal" data-target="#EditSource"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:void(0);" id="deleteData" data-id="{{$member->id}}"
													data-type="source"
													class="btn btn-sm btn-primary btn-table btn-danger"><i
														class="fa fa-trash-o" aria-hidden="true"></i></a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								@endif
								@else
								<div class="ui negative icon message">
									<i class="frown icon"></i>
									<div class="content">
										<div class="header">
											{{ trans('laralum.missing_title') }}
										</div>
										<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "Member Detail"]) }}</p>
									</div>
								</div>
								@endif
							</div>
							<div class="col-md-5">
								<form class="form-horizontal" method="POST" id="upload_member_form"
									action="javascript:void(0)">
									<!--01-->
									<div class="form-group">

										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Account Type&nbsp;<span
													style="color:red;">*</span></label>
											<div class="row">
												<div class="col-sm-9">
													<input type="text" class="inp" placeholder="Enter Account Type"
														id="account_type" name="account_type"></div>
												<div class="col-sm-3" style="align-content: center"
													id="saveAccountType">
													<a href="javascript:void(0);"
														class="btn btn-sm btn-primary btn-table"><i
															class="fa fa-floppy-o" aria-hidden="true"></i></a></div>
											</div>
										</div>

									</div>
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Member Type&nbsp;<span
													style="color:red;">*</span></label>
											<div class="row">
												<div class="col-sm-9">
													<input type="text" class="inp" placeholder="Enter Member Type"
														id="member_type" name="member_type"></div>
												<div class="col-sm-3" style="align-content: center">
													<a href="javascript:void(0);" id="saveMemberType"
														class="btn btn-sm btn-primary btn-table"><i
															class="fa fa-floppy-o" aria-hidden="true"></i></a></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Source&nbsp;<span
													style="color:red;">*</span></label>
											<div class="row">
												<div class="col-sm-9">
													<input type="text" class="inp" placeholder="Enter Source"
														id="source" name="source"></div>
												<div class="col-sm-3" style="align-content: center">
													<a href="javascript:void(0);" id="saveSource"
														class="btn btn-sm btn-primary btn-table"><i
															class="fa fa-floppy-o" aria-hidden="true"></i></a></div>
											</div>
										</div>
									</div>
									<!--01-->
									<!--04-->
								</form>
							</div>
						</div>
					</div>
					<!--Members end-->

					<!--donations start-->
					<div id="Donation" class="tab-pane fade">

						<div id="EditDonationType" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">
								<!-- Modal content-->
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
						</div>
						<div id="EditDonationPurpose" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">
								<!-- Modal content-->
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
						</div>
						<div id="EditSource" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">
								<!-- Modal content-->
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
						</div>

						<div class="row">
							<div class="col-md-7">
								@if (count($donationpurposes) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
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
													class="btn btn-sm btn-primary btn-table"
													data-purposeid="{{$purpose->id}}" data-val="{{$purpose->purpose}}"
													data-toggle="modal" data-target="#EditDonationPurpose"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:void(0);" id="deleteData" data-id="{{$purpose->id}}"
													data-type="donation_purpose"
													class="btn btn-sm btn-primary btn-table btn-danger"><i
														class="fa fa-trash-o" aria-hidden="true"></i></a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								{{-- @if(count($sources) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
											<th width="60%">Sources</th>
											<th class="text-center" width="40%">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($sources as $member)
										<tr id="source{{$member->id}}">
								<td>{{ $member->source }}</td>
								<td class="text-center">
									<a href="javascript:void(0);" id="editmemberSource"
										class="btn btn-sm btn-primary btn-table" data-sourceid="{{$member->id}}"
										data-val="{{$member->source}}" data-toggle="modal" data-target="#EditSource"><i
											class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<a href="javascript:void(0);" id="deleteData" data-id="{{$member->id}}"
										data-type="source" class="btn btn-sm btn-primary btn-table btn-danger"><i
											class="fa fa-trash-o" aria-hidden="true"></i></a>
								</td>
								</tr>
								@endforeach
								</tbody>
								</table>
								@endif --}}
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
							<div class="col-md-5">
								<form class="form-horizontal" method="POST" id="upload_member_form"
									action="javascript:void(0)">

									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Donation Purpose&nbsp;<span
													style="color:red;">*</span></label>
											<div class="row">
												<div class="col-sm-9">
													<input type="text" class="inp" placeholder="Enter Purpose"
														id="purpose" name="purpose"></div>
												<div class="col-sm-3" style="align-content: center">
													<a href="javascript:void(0);" id="savePurpose"
														class="btn btn-sm btn-primary btn-table"><i
															class="fa fa-floppy-o" aria-hidden="true"></i></a></div>
											</div>
										</div>
									</div>
									{{-- <div class="form-group">
										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Payment Mode&nbsp;<span
													style="color:red;">*</span></label>
											<div class="row">
												<div class="col-sm-9">
													<input type="text" class="inp" placeholder="Enter Payment Mode"
														id="paymentMode" name="paymentMode"></div>
												<div class="col-sm-3" style="align-content: center">
													<a href="javascript:void(0);" id="savePaymentMode"
														class="btn btn-sm btn-primary btn-table"><i
															class="fa fa-floppy-o" aria-hidden="true"></i></a></div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Payment type&nbsp;<span
													style="color:red;">*</span></label>
											<div class="row">
												<div class="col-sm-9">
													<input type="text" class="inp" placeholder="Enter Payment Type"
														id="paymentType" name="paymentType"></div>
												<div class="col-sm-3" style="align-content: center">
													<a href="javascript:void(0);" id="savePaymentType"
														class="btn btn-sm btn-primary btn-table"><i
															class="fa fa-floppy-o" aria-hidden="true"></i></a></div>
											</div>
										</div>
									</div> --}}

								</form>
							</div>
						</div>
					</div>
					<!--donations end-->

					<!--time-slot-start-->
					<div id="TimeSlot" class="tab-pane fade">
						<!-- Edit-Time-Slot-Modal-start-->
						<div id="EditTimeSlot" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Edit Time Slot</h4>
									</div>
									<form method="POST" enctype="multipart/form-data" id="update_timeslot_form"
										action="javascript:void(0)">
										<input type="hidden" name="edit_timeslot_id" id="edit_timeslot_id"
											class="form-control" />
										<div class="modal-body">
											<div class="form-group">
												<label>Date&nbsp;<span style="color:red;">*</span></label>
												<input type="date" name="edit_timeslot_date" id="edit_timeslot_date"
													class="form-control" />
											</div>
											<div class="form-group">
												<label>Time&nbsp;<span style="color:red;">*</span></label>
												<input type="time" name="edit_timeslot_time" id="edit_timeslot_time"
													class="form-control" />
											</div>
											<div class="form-group">
												<button type="submit" id="editTimeSlotForm"
													class="ui teal submit button"><span
														id="hideetstext">UPDATE</span>&nbsp;
													<span class="editTimeSlotForm" style="display:none;"><img
															src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- EditBranch Modal end -->

						<div class="row">
							<div class="col-md-8">
								@if (count($apt_time_slots) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
											<th width="20%">Name</th>
											<th width="20%">Date</th>
											<th width="20%">Time</th>
											<th width="20%">Status</th>
											<th class="text-center" width="20%">Action</th>
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
												<span class="badge badge-info-green">{{ $timeslot->status }}</span>
												@else
												<span class="badge badge-info-red">{{ $timeslot->status }}</span>
												@endif
											</td>
											<td class="text-center">
												<a href="javascript:void(0);" id="editTimeSlot"
													class="btn btn-sm btn-primary btn-table" data-toggle="modal"
													data-target="#EditTimeSlot" data-id="{{$timeslot->id}}"
													data-date="{{$timeslot->slot_date}}"
													data-time="{{$timeslot->slot_time}}"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:void(0);" id="deleteData"
													data-id="{{$timeslot->id}}" data-type="timeslot"
													class="btn btn-sm btn-primary btn-table btn-danger"><i
														class="fa fa-trash-o" aria-hidden="true"></i></a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
								{{ $apt_time_slots->fragment('TimeSlot')->links() }}
								@else
								<div class="ui negative icon message">
									<i class="frown icon"></i>
									<div class="content">
										<div class="header">
											{{ trans('laralum.missing_title') }}
										</div>
										<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "time slot"]) }}</p>
									</div>
								</div>
								@endif
							</div>
							<div class="col-md-4">
								<form class="row" method="POST" id="upload_time_slot_form" action="javascript:void(0)">
									<!--01-->
									<div class="col-sm-12">
										<div class="form-group">
											<label class="mb-5">Staff&nbsp;<span style="color:red;">*</span></label>
											<select id="apt_staff" name="apt_staff" class="form-control select-style">
												<option value="">Select staff</option>
												@foreach($apt_staffs as $apt_staff)
												<option value="{{ $apt_staff->id }}">{{ $apt_staff->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<!--01-->
									<!--02-->
									<div class="col-sm-12">
										<div class="form-group">
											<label class="mb-5">Date&nbsp;<span style="color:red;">*</span></label>
											<input type="date" name="slot_date" id="slot_date" class="form-control" />
										</div>
									</div>
									<!--02-->
									<!--03-->
									<div class="col-sm-12">
										<div class="fieldmore row">
											<div class="col-sm-10 pr-5">
												<div class="form-group">
													<label class="mb-5">Time&nbsp;<span
															style="color:red;">*</span></label>
													<input type="time" name="slot_time[]" id="slot_time"
														class="form-control" />
												</div>
											</div>
											<div class="col-sm-2 pl-5">
												<div class="form-group">
													<label class="mb-5 d-block">&nbsp;</label>
													<a href="javascript:void(0);"
														class="btn btn-primary btn-plus addMore"><i class="fa fa-plus"
															aria-hidden="true"></i></a>
												</div>
											</div>
										</div>

									</div>
									<!--03-->
									<!--04-->
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<button type="submit" id="timeSlotForm" class="ui teal submit button"><span
													id="hidetstext">SAVE</span>&nbsp;
												<span class="timeSlotForm" style="display:none;"><img
														src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
											</button>
										</div>
									</div>
									<!--04-->
								</form>
							</div>
						</div>
					</div>
					<!--time-slot-end-->

					<!--Departments start-->
					<div id="Departments" class="tab-pane fade">

						<!-- EditDepartments Modal start-->
						<div id="EditDepartments" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">

								<!-- Modal content-->
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
						</div>
						<!-- EditDepartments Modal end -->

						<div class="row">
							<div class="col-md-7">
								@if (count($departments) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
											<th width="60%">Department</th>
											<th class="text-center" width="40%">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($departments as $department)
										<tr id="department{{$department->id}}">
											<td>{{ $department->department }}</td>
											<td class="text-center">
												<a href="javascript:void(0);" id="editDepartment"
													class="btn btn-sm btn-primary btn-table" data-toggle="modal"
													data-target="#EditDepartments"
													data-departmentid="{{$department->id}}"
													data-department="{{$department->department}}"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:void(0);" id="deleteData"
													data-id="{{$department->id}}" data-type="department"
													class="btn btn-sm btn-primary btn-table btn-danger"><i
														class="fa fa-trash-o" aria-hidden="true"></i></a>
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
										<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "department"]) }}</p>
									</div>
								</div>
								@endif
							</div>
							<div class="col-md-5">
								<form class="form-horizontal" method="POST" id="upload_department_form"
									action="javascript:void(0)">
									<!--01-->
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Department:</label>
											<input type="text" class="inp" placeholder="Enter Department"
												id="department" name="department" />
										</div>
									</div>
									<!--01-->

									<!--04-->
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<button type="submit" id="departmentForm"
												class="ui teal submit button"><span id="hidedpttext">SAVE</span>&nbsp;
												<span class="departmentForm" style="display:none;"><img
														src="{{ asset(Laralum::publicPath() . '/images/loader.png') }}"></span>
											</button>
										</div>
									</div>
									<!--04-->
								</form>
							</div>
						</div>
					</div>
					<!--Departments end-->
					<!--PrayerRequest start-->
					<div id="PrayerRequest" class="tab-pane fade">

						<!-- EditRequest Modal start-->
						<div id="EditRequests" class="modal fade" role="dialog">
							<div class="modal-dialog modal-sm">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Edit Request</h4>
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
													class="ui teal submit button"><span
														id="hidedutext">UPDATE</span>&nbsp;
													<span class="editRequestForm" style="display:none;"><img
															src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
												</button>
											</div>
										</div>
									</form>
								</div>

							</div>
						</div>
						<!-- EditRequest Modal end -->

						<div class="row">
							<div class="col-md-7">
								@if (count($requests) > 0)
								<table class="ui table">
									<thead>
										<tr class="table_heading">
											<th width="60%">Prayer Request</th>
											<th class="text-center" width="40%">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($requests as $request)
										<tr id="request{{$request->id}}">
											<td>{{ $request->prayer_request }}</td>
											<td class="text-center">
												<a href="javascript:void(0);" id="editRequests"
													class="btn btn-sm btn-primary btn-table" data-toggle="modal"
													data-target="#EditRequests" data-requestid="{{$request->id}}"
													data-request="{{$request->prayer_request}}"><i
														class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
												<a href="javascript:void(0);" id="deleteData" data-id="{{$request->id}}"
													data-type="request"
													class="btn btn-sm btn-primary btn-table btn-danger"><i
														class="fa fa-trash-o" aria-hidden="true"></i></a>
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
										<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "prayer request"]) }}
										</p>
									</div>
								</div>
								@endif
							</div>
							<div class="col-md-5">
								<form class="form-horizontal" method="POST" id="upload_request_form"
									action="javascript:void(0)">
									<!--01-->
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<label class="res_float_none mb-5">Prayer Request:</label>
											<input type="text" class="inp" placeholder="Enter Request" id="request"
												name="prayer_request" />
										</div>
									</div>
									<!--01-->

									<!--04-->
									<div class="form-group">
										<div class="col-sm-12 res_float_none">
											<button type="submit" id="requestForm" class="ui teal submit button"><span
													id="hidedpttext">SAVE</span>&nbsp;
												<span class="requestForm" style="display:none;"><img
														src="{{ asset(Laralum::publicPath() . '/images/loader.png') }}"></span>
											</button>
										</div>
									</div>
									<!--04-->
								</form>
							</div>
						</div>
					</div>
					<!--PrayerRequest end-->
					<!--Staff start-->
					<div id="Staff" class="tab-pane fade p-0">
						<!-- Modal -->
						<div id="StaffCreation" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Create Staff</h4>
									</div>
									<form method="POST" enctype="multipart/form-data" id="staff_create_form"
										action="javascript:void(0)">
										<div class="modal-body">
											<span class="text-center red" id="staff_error_text"
												style="display:none;">All fields are required.</span>
											<div class="alert alert-danger" style="display:none"></div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Name&nbsp;<span style="color:red;">*</span></label>
														<input type="text" class="form-control" id="staff_name"
															name="staff_name" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Email&nbsp;<span style="color:red;">*</span></label>
														<input type="email" class="form-control" id="email"
															name="email" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Phone No.&nbsp;<span style="color:red;">*</span></label>
														<input type="text" class="form-control" id="staff_phone"
															name="staff_phone" />
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>Password&nbsp;<span style="color:red;">*</span></label>
														<input type="password" class="form-control" id="staff_password"
															name="staff_password" />
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>Branch&nbsp;<span style="color:red;">*</span></label>
														<select id="staff_branch" name="staff_branch"
															class="form-control select-style">
															<option value="">Select branch</option>
															@foreach($branches as $branch)
															<option value="{{ $branch->id }}">{{ $branch->branch }}
															</option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>Department&nbsp;<span style="color:red;">*</span></label>
														<select id="staff_department" name="staff_department"
															class="form-control select-style">
															<option value="">Select department</option>
															@foreach($departments as $department)
															<option value="{{ $department->id }}">
																{{ $department->department }}</option>
															@endforeach
														</select>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>Role&nbsp;<span style="color:red;">*</span></label>
														<select id="staff_role" name="staff_role"
															class="form-control select-style">
															<option value="">Select role</option>
															@foreach($roles as $role)
															<option value="{{ $role->id }}">{{ $role->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>For appointment meet?&nbsp;<span
																style="color:red;">*</span></label>
														<select id="appointment_meet" name="appointment_meet"
															class="form-control select-style">
															<option value="">Please select</option>
															<option value="1">Yes</option>
															<option value="0" selected>No</option>
														</select>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<button type="submit" id="addStaffForm"
															class="ui teal submit button"><span
																id="hidestafftext">SAVE</span>&nbsp;
															<span class="addStaffForm" style="display:none;"><img
																	src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12 mb-5 text-right">
									<a href="#" class="ui teal submit button" data-toggle="modal"
										data-target="#StaffCreation">
										<i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Add
									</a>
								</div>
								<div class="col-md-12">
									@if(count($staffs)>0)
									<table class="ui table">
										<thead>
											<tr class="table_heading">
												<th width="25%">Name</th>
												<th width="15%">Phone</th>
												<th width="15%">Role</th>
												<th width="15%">Department</th>
												<th width="15%" class="text-center">IVR Ext</th>
												<th width="15%">&nbsp;&nbsp;</th>
											</tr>
										</thead>
										<tbody>
											@foreach($staffs as $staff)
											<tr role="row" class="odd">
												<td>
													<div class="media">
														<div class="media-left">
															<img id="avatar-div" class="ui avatar image"
																src="{{ asset(Laralum::publicPath() .'/images/avatar.jpg') }}">
														</div>
														<div class="media-body">
															<div class="text">
																<a data-fancybox="data-fancybox" data-type="iframe"
																	href="{{ route('console::staff_profile', ['id' => $staff->id]) }}">{{ $staff->name }}</a>
																<br />
																<a data-fancybox="data-fancybox" data-type="iframe"
																	href="{{ route('console::staff_profile', ['id' => $staff->id]) }}">{{ $staff->email }}</a>
															</div>
														</div>
													</div>
												</td>
												<td>{{ $staff->mobile }}</td>
												<td>{{ $staff->role }}</td>
												<td>{{ $staff->department }}</td>
												<td class="text-center">
													@if( $staff->ivr_extension==0)
													<a data-fancybox="data-fancybox" data-type="iframe"
														href="{{ route('console::staff_profile', ['id' => $staff->id]) }}"><small>Click
															to assign extension</small></a>
													@else
													{{ $staff->ivr_extension }}
													@endif
												</td>
												<td class="text-center">
													<a data-fancybox="data-fancybox" data-type="iframe"
														href="{{ route('console::staff_profile', ['id' => $staff->id]) }}"
														class="btn btn-sm btn-primary btn-table"><i
															class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
													<a href="javascript:void(0);" id="deleteData"
														data-id="{{$staff->id}}" data-type="staff"
														class="btn btn-sm btn-primary btn-table btn-danger"><i
															class="fa fa-trash-o" aria-hidden="true"></i></a>
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
					</div>
					<!--Staff end-->

					<!--Roles start-->
					<div id="Roles" class="tab-pane fade">
						<div class="ui one column doubling stackable grid container mb-20">
							<div class="column">
								<a href="{{ route('console::roles_create') }}"
									class="res_ex ui {{ Laralum::settings()->button_color }} button">
									<i class="fa fa-plus icon_m"
										aria-hidden="true"></i><span>{{ trans('laralum.create_role') }}</span></a>
								<div class="ui very padded segment">
									<table class="ui table">
										<thead>
											<tr>
												<th>{{ trans('laralum.name') }}</th>
												<th>{{ trans('laralum.users') }}</th>
												<th>{{ trans('laralum.permissions') }}</th>
												<th>{{ trans('laralum.options') }}</th>
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
													<div
														class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
														<i class="configure icon"></i>
														<div class="menu">
															<div class="header">{{ trans('laralum.editing_options') }}
															</div>
															<a href="{{ route('console::roles_edit', ['id' => $role->id]) }}"
																class="item">
																<i class="edit icon"></i>
																{{ trans('laralum.roles_edit') }}
															</a>
															<a href="{{ route('console::roles_permissions', ['id' => $role->id]) }}"
																class="item">
																<i class="lightning icon"></i>
																{{ trans('laralum.roles_edit_permissions') }}
															</a>
															<div class="header">{{ trans('laralum.advanced_options') }}
															</div>
															<a href="{{ route('console::roles_delete', ['id' => $role->id]) }}"
																class="item">
																<i class="trash bin icon"></i>
																{{ trans('laralum.roles_delete') }}
															</a>
														</div>
													</div>
													@else
													<div
														class="ui disabled {{ Laralum::settings()->button_color }} icon button">
														<i class="lock icon"></i>
													</div>
													@endif
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<br>
							</div>
						</div>
					</div>
					<!--Roles end-->

					<!--Payments start-->
					<div id="Payments" class="tab-pane fade p-0">
						<!-- Bank Modal -->
						<div id="AddBanks" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Bank Details</h4>
									</div>
									<form method="POST" id="upload_bank_form" action="javascript:void(0)">
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
												<div class="col-md-12">
													<div class="form-group">
														<button type="submit" id="bankForm"
															class="ui teal submit button"><span
																id="hidebanktext">SAVE</span>&nbsp;
															<span class="bankForm" style="display:none;"><img
																	src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						<!-- RazorPay Modal -->
						<div id="AddRazorPay" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">RazorPay Details</h4>
									</div>
									<form method="POST" id="upload_razorpay_form" action="javascript:void(0)">
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

												<div class="col-md-12">
													<div class="form-group">
														<button type="submit" id="razorPayForm"
															class="ui teal submit button"><span
																id="hiderazorPaytext">SAVE</span>&nbsp;
															<span class="bankForm" style="display:none;"><img
																	src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
														</button>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						<div class="col-md-12 text-right">
							<a href="#" class="ui teal submit button" id="addBankDetails" data-toggle="modal"
								data-target="#AddBanks">
								<i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;Add Bank
							</a>
							@if(!Laralum::loggedInUser()->RAZOR_KEY)
							<a href="#" class="ui teal submit button" id="addRazorPayDetails" data-toggle="modal"
								data-target="#AddRazorPay">
								<i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;Add RazorPay
							</a>
							@endif
						</div>

						<div class="col-md-12">
							<div class="row mt-5">
								<div class="col-md-12">
									@if(count($bank_details)>0)
									<table class="ui table">
										<thead>
											<tr class="table_heading">
												<th>Name.</th>
												<th>Account No.</th>
												<th>Bank</th>
												<th>Branch</th>
												<th>IFSC Code</th>
												<th>&nbsp</th>
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
														class="btn btn-sm btn-primary btn-table" data-toggle="modal"
														data-target="#AddBanks" data-id="{{$details->id}}"
														data-name="{{ $details->ac_name }}"
														data-account="{{ $details->ac_number }}"
														data-bank="{{ $details->bank }}"
														data-branch="{{ $details->address }}"
														data-ifsc="{{ $details->ifsc_code }}"><i
															class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
														class="btn btn-sm btn-primary btn-table" data-toggle="modal"
														data-target="#AddRazorPay"
														data-key="{{ Laralum::loggedInUser()->RAZOR_KEY }}"
														data-secret="{{ Laralum::loggedInUser()->RAZOR_SECRET }}"><i
															class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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

					</div>
					<!--Payments end-->
					<!--ChangePaasword-->
					<div id="ChangePaasword" class="tab-pane fade">
						<div class="row">
							<div class="col-md-6">
								<form class="form-horizontal" method="POST" id="change_password_form"
									action="javascript:void(0)">
									<!--01-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">Current Password:</label>
										<div class="col-sm-8 res_float_none">
											<input type="password" class="inp" placeholder="" id="current_password" />
										</div>
									</div>
									<!--01-->

									<!--02-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">New Password:</label>
										<div class="col-sm-8 res_float_none">
											<input type="password" class="inp" placeholder="" id="new_password" />
										</div>
									</div>
									<!--02-->

									<!--03-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">Confirm Password:</label>
										<div class="col-sm-8 res_float_none">
											<input type="password" class="inp" placeholder="" id="confirm_password" />
										</div>
									</div>
									<!--03-->

									<!--04-->
									<div class="form-group">
										<label class="control-label col-sm-4 res_float_none">&nbsp;</label>
										<div class="col-sm-8 res_float_none">
											<button type="submit" id="changePassForm"
												class="ui teal submit button"><span id="hidecptext">UPDATE</span>&nbsp;
												<span class="changePassForm" style="display:none;"><img
														src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
											</button>
										</div>
									</div>
									<!--04-->

								</form>

							</div>
						</div>
					</div>
					<!--ChangePaasword-->
					<!-- copy of input fields group -->
					<div class="fieldmoreCopy row" style="display: none;">
						<div class="col-sm-10 pr-5">
							<div class="form-group">
								<input type="time" name="slot_time[]" id="slot_time" class="form-control" />
							</div>
						</div>
						<div class="col-sm-2 pl-5">
							<div class="form-group">

								<a href="javascript:void(0);" id="editBranch" class="btn btn-danger btn-plus remove"><i
										class="fa fa-minus"></i></a>
							</div>
						</div>
					</div>
					<!-- copy of input fields group -->


					<!--SMS-section-area-->
					<div class="tab-pane fade" id="SMSTab">

						<div class="col-md-12">
							<h3 class="form-heading">Sms Templates</h3>
						</div>
						<form class="form-horizontal" method="POST" enctype="multipart/form-data" id="update_sms_data"
							action="javascript:void(0)">
							<table class="ui five column table ">

								<thead>
									<tr>
										<th>Name</th>
										<th>Status</th>
										<th>Template</th>
										<th>Period</th>
										<th>Template Variable</th>
										{{-- <th>Action</th> --}}
									</tr>
								</thead>
								<tbody>

									@foreach($templates as $template)
									<tr>
										<td style="width: 10%">
											<div class="text">
												<span class="badge badge-info">{{ $template->name }}</span>
											</div>
										</td>
										<td style="width: 10%">
											<label class="switch">
												<input name="status_{{ $template->id }}" type="checkbox"
													{{$template->status?'checked':""}}>
												<span class="slider round"></span>
											</label>
										</td>

										<td style="width: 30%">
											<textarea class="reminder_sms" name="template_{{ $template->id }}"
												placeholder="Type payment sms reminder here..">
											@if($template->template!=null && $template->template!='')
											{{$template->template}}
											@else
											Dear $NAME, Your $MONTH month EMI of $PRICE is pending. Kindly make payment with the given link <br>$PAYMENT_LINK<br>Thanks
											@endif
											</textarea>
										</td>
										<td style="width: 10%">
											@if($template->id==4 || $template->id==5)
											<select class="form-control custom-select"
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
											@else N.A.
											@endif
										</td>
										<td style="width: 20%">
											<div class="warning">
												Note: <br>
												{NAME} => Member name<br>
												{MONTH} => EMI Month<br>
												{DAY} => EMI Due date date<br>
												{PRICE} => EMI Amount<br>
											</div>
										</td>


									</tr>
									@endforeach
								</tbody>
							</table>
							<div class="text-right mb-30 mt-30">
								<button type="submit" id="SaveSMSfields"
									class="ui teal submit button">UPDATE&nbsp;</button>
							</div>
						</form>
					</div>
					<!--SMS-section-area-->

				</div>
			</div>
		</div>
	</div>
</div>
<script src="{{ asset(Laralum::publicPath() .'/js/setting-script.js') }}"></script>
<script>
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

$(document).on('click','#editBranch',function(e) {
	$('#edit-branch').val($(this).attr('data-branch'))
	$('#edit-branch-id').val($(this).attr('data-branchid'))
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
$('#AddBanks').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
$(document).on('click','#editDepartment',function(e) {
	$('#edit-department').val($(this).attr('data-department'))
	$('#edit-department-id').val($(this).attr('data-departmentid'))
});
$(document).on('click','#editRequests',function(e) {
	$('#edit-request').val($(this).attr('data-request'))
	$('#edit-request-id').val($(this).attr('data-requestid'))
});
$(document).on('click','#editTimeSlot',function(e) {
	$('#edit_timeslot_id').val($(this).attr('data-id'))
	$('#edit_timeslot_date').val($(this).attr('data-date'))
	$('#edit_timeslot_time').val($(this).attr('data-time'))
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

//delete branch & department and remove it from list
$(document).on('click','#deleteData',function(e) {
    e.preventDefault();
    var id=$(this).attr('data-id');
    var dtype=$(this).attr('data-type');
	var url = APP_URL+'/console/manage/delDepartmentBranchData';	
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
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this data!",
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
				text: 'The data has been deleted!',
				type: 'success'
			}, function() {
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
			});
			
		} else {
			swal("Cancelled", "Your data is safe :)", "error");
		}
	});
	
});
</script>

<script>
	$('#profile_img_btn').bind("click" , function () {
	$('#logoimgselector').click();
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
<script>
	$(document).ready(function(){
    //group add limit
    var maxGroup = 15;
    
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
	
	
});

$("#send_msg_after_duedate").on('change', function() {
  	if ($(this).is(':checked'))
    	$("#sms_period").show();
  	else {
    	$("#sms_period").hide();
  	}
});



</script>
<style>
	.parent {
		margin-left: 10px;
		margin-right: 10px;
	}

	.loadinggif {
		background:url('{{ asset(Laralum::publicPath() .'/images/ajax-loader.gif') }}') no-repeat right center;
	}

	.switch {
		position: relative;
		display: inline-block;
		width: 55px;
		height: 25px;
	}

	.switch input {
		opacity: 0;
		width: 0;
		height: 0;
	}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 17px;
		width: 17px;
		left: 6px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}


	input:checked+.slider {
		background-color: #218838;
	}

	input:focus+.slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked+.slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 50%;
	}

	textarea.reminder_sms {
		width: 100%;
		height: 150px;
	}

	.warning {
		padding: 20px;
		background-color: #ffffcc;
		border-left: 6px solid #f9ba48;
		margin: 15px 0px 15px 0px;
	}
</style>
@endsection
