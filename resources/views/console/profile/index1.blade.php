@extends('layouts.console.panel') 
@section('breadcrumb')
<div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.profile_manager') }}</div>
</div>
@endsection
@section('title', trans('laralum.profile_manager'))
@section('content')
<div class="ui one column doubling stackable grid container mb-30">
<div class="column">
 <div class="ui very padded segment">
<div class="col-md-12">
<ul class="nav nav-tabs">
  <li class="active"><a class="ripple" data-toggle="tab" href="#OrganizationProfile"><i class="fa fa-sitemap" aria-hidden="true"></i><span>ORGANIZATION</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#General"><i class="fa fa-cog" aria-hidden="true"></i><span>GENERAL</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#Branches"><i class="fa fa-building" aria-hidden="true"></i><span>BRANCH</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#Departments"><i class="fa fa-object-group" aria-hidden="true"></i><span>DEPARTMENTS</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#Staff"><i class="fa fa-users" aria-hidden="true"></i><span>STAFF</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#Roles"><i class="fa fa-briefcase" aria-hidden="true"></i><span>ROLES</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#Payments"><i class="fa fa-credit-card" aria-hidden="true"></i><span>PAYMENTS</span></a></li>
   <li><a class="ripple" data-toggle="tab" href="#ChangePaasword"><i class="fa fa-unlock-alt" aria-hidden="true"></i><span>CHANGE PASSWORD</span></a></li>
</ul>

<div class="tab-content">
  
<!--OrganizationProfile start-->
<div id="OrganizationProfile" class="tab-pane in active">
 <div class="col-md-8">   
    <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="upload_organization_form" action="javascript:void(0)" >	
		<!--01-->
		<div class="form-group">
			<label class="control-label col-sm-4 res_float_none">Your Logo:</label>
			<div class="col-sm-8 res_float_none">
			<div class="row">
			<div class="col-sm-5 res_float_none">
			@if(isset($org_profile) && !empty($org_profile->organization_logo))
			<img id="logoimage" src="{{ asset('console_public/data/organization') }}/{{ $org_profile->organization_logo }}" alt="" class="img-responsive" />						
			@else
			<img id="logoimage" src="{{ asset('console_public/images/defalut-image-logo.jpg') }}" alt="" class="img-responsive" />
			@endif												
			<a class="btn btn-sm btn-primary" id="profile_img_btn" onclick="$('.dimmer').removeClass('dimmer')">Choose Logo</a>														
			<input id="logoimgselector" name="org_logo" type="file" class="hidden" />																			
			<input name="org_logo_hidden" type="hidden" value="{{ isset($org_profile) ? $org_profile->organization_logo : '' }}" />																			
			</div>
			<div class="col-sm-4 res_float_none blue-txt">
				 <small>Text</small>
			</div>
			
			</div>
			</div>
		</div>
		<!--01-->
		
		<!--02-->
		<div class="form-group">
			<label class="control-label col-sm-4 res_float_none">Organization Name&nbsp;<span style="color:red;">*</span>:</label>
			<div class="col-sm-8 res_float_none">
				<input type="text" class="inp" placeholder="Organization Name" id="organization_name" name="organization_name" value="{{ isset($org_profile) && !empty($org_profile->organization_name) ? $org_profile->organization_name : '' }}" />						
			</div>
		</div>
		<!--02-->
		
		<!--03-->
		<div class="form-group">
			<label class="control-label col-sm-4 res_float_none">Industry&nbsp;<span style="color:red;">*</span>:</label>
			<div class="col-sm-8 res_float_none">
				<select id="industry" name="industry" class="inp select-style">
				<option value="">Select Industry</option>
				 @foreach($industries as $key=>$val) 
					 <option value="{{ $key }}" @if( isset($org_profile) && $org_profile->industry==$key) selected="selected" @endif>{{ $val }}</option>
				 @endforeach
				</select>						
			</div>
		</div>
		<!--03-->
		
		<!--04-->
		<div class="form-group">
			<label class="control-label col-sm-4 res_float_none">Business Location&nbsp;<span style="color:red;">*</span>:</label>
			<div class="col-sm-8 res_float_none">
				<input type="text" class="inp" placeholder="Business Location" name="business_location" id="business_location" value="{{ isset($org_profile) && !empty($org_profile->business_location) ? $org_profile->business_location : '' }}" />
			</div>
		</div>
		<!--04-->
										
		<!--06-->
		<div class="form-group">
			<label class="control-label col-sm-4 res_float_none">Company Address:</label>
			<div class="col-sm-8 res_float_none">
				<div class="mb-15">
					<input type="text" class="inp" placeholder="Address Line 1" id="address1" name="address1" value="{{ isset($org_profile) && !empty($org_profile->company_address_line1) ? $org_profile->company_address_line1 : '' }}" />
				</div>
				<div class="mb-15">
					<input type="text" class="inp" placeholder="Address Line 2" id="address2" name="address2" value="{{ isset($org_profile) && !empty($org_profile->company_address_line2) ? $org_profile->company_address_line2 : '' }}" />
				</div>
			</div>
		</div>
		<!--06-->		
		<!--04-->
		<div class="form-group">
			<label class="control-label col-sm-4 res_float_none">&nbsp;</label>
			<div class="col-sm-8 res_float_none">
			<button type="submit" id="organizationForm" class="ui teal submit button"><span id="hideorgtext">SAVE</span>&nbsp;
			<span class="organizationForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
			</button>
			</div>
		</div>
		<!--04-->               
	</form>  
  </div>
</div>
<!--OrganizationProfile end-->

 <!--General-->
<div id="General" class="tab-pane fade in active">  
<div class="row">
 <div class="col-md-6"> 
  <form class="form-horizontal" method="POST" enctype="multipart/form-data" id="upload_general_form" action="javascript:void(0)">
	<!--01-->
	<div class="form-group">
		<label class="control-label col-sm-4 res_float_none">Email/Username:</label>
		<div class="col-sm-8 res_float_none">
			<input type="text" class="inp" placeholder="" id="user_name" id="user_name" value="{{ ($datas->email) ? $datas->email : '' }}" disabled />			
		</div>
	</div>
	<!--01-->                              
	<!--02-->
	<div class="form-group">
		<label class="control-label col-sm-4 res_float_none">Mobile No.:</label>
		<div class="col-sm-8 res_float_none">
			<input type="text" class="inp" placeholder="" id="mobile" name="mobile" value="{{ ($datas->mobile) ? $datas->mobile : '' }}" disabled />			
		</div>
	</div>
	<!--02-->
	
	<!--03-->
	<div class="form-group">
		<label class="control-label col-sm-4 res_float_none">Full Name:</label>
		<div class="col-sm-8 res_float_none">
			<input type="text" class="inp" placeholder="" id="fullname" name="fullname" value="{{ ($datas->name) ? $datas->name : '' }}" />
			
		</div>
	</div>
	<!--03-->
	
	
	<!--05-->
	<div class="form-group">
		<label class="control-label col-sm-4 res_float_none">Alternate Email:</label>
		<div class="col-sm-8 res_float_none">
			<input type="text" class="inp" placeholder="" id="altemail" name="altemail" value="{{ ($datas->alt_email) ? $datas->alt_email : 'N/A' }}">
			
			<!--a href="#">Wish to receive notifications on multiple  email addresses?</a-->
			
		</div>
	</div>
	<!--05-->
	
	<!--06-->
	<div class="form-group">
		<label class="control-label col-sm-4 res_float_none">Alternate Mobile:</label>
		<div class="col-sm-8 res_float_none">
			<input type="text" class="inp" placeholder="" id="altcontact" name="altcontact" value="{{ ($datas->alt_mobile) ? $datas->alt_mobile : 'N/A' }}">
			
		</div>
	</div>
	<!--06-->
	
	<!--07-->
	<div class="form-group">
		<label class="control-label col-sm-4 res_float_none">Account Expiry:</label>
		<div class="col-sm-8 res_float_none">
			<input type="text" class="inp" placeholder="" id="expiry" value="{{ ($datas->expiry_date) ? $datas->expiry_date : 'N/A' }}">
			
		</div>
	</div>
	<!--07-->	
	<!--08-->
	<div class="form-group">
	<label class="control-label col-sm-4 res_float_none">&nbsp;</label>
	<div class="col-sm-8 res_float_none">
	<button type="submit" id="generalForm" class="ui teal submit button"><span id="hidegeneraltext">SAVE</span>&nbsp;
	<span class="generalForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
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
	  <form method="POST" enctype="multipart/form-data" id="update_branch_form" action="javascript:void(0)" >
		  <div class="modal-body">
			<div class="form-group">
				<label>Branch</label>
				<input type="text" name="editbranch" id="edit-branch" class="form-control" />
				<input type="hidden" name="editbranchid" id="edit-branch-id" class="form-control" />
			</div>
			<div class="form-group">
			<button type="submit" id="editBranchForm" class="ui teal submit button"><span id="hidebutext">UPDATE</span>&nbsp;
			<span class="editBranchForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
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
			<a href="javascript:void(0);" id="editBranch" class="btn btn-sm btn-primary btn-table" data-branchid="{{$branch->id}}" data-branch="{{$branch->branch}}" data-toggle="modal" data-target="#EditBranch"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
			<a href="javascript:void(0);" id="deleteData" data-id="{{$branch->id}}" data-type="branch" class="btn btn-sm btn-primary btn-table btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
 <form class="form-horizontal" method="POST" id="upload_branch_form" action="javascript:void(0)" >              
	<!--01-->
	<div class="form-group">		
	<div class="col-sm-12 res_float_none">
		<label class="res_float_none mb-5">Branch&nbsp;<span style="color:red;">*</span></label>
		<input type="text" class="inp" placeholder="Enter Branch" id="branch" name="branch">			
	</div>
	</div>
	<!--01-->	
	<!--04-->
	<div class="form-group">		
		<div class="col-sm-12 res_float_none">
		<button type="submit" id="branchForm" class="ui teal submit button"><span id="hidebrtext">SAVE</span>&nbsp;
		<span class="branchForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
		</button>
		</div>
	</div>
	<!--04-->                
</form>  
</div> 
</div>
</div>
<!--Branches end--> 
 
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
	  <form method="POST" enctype="multipart/form-data" id="update_department_form" action="javascript:void(0)" >
		  <div class="modal-body">
			<div class="form-group">
				<label>Department</label>
				<input type="text" class="form-control" id="edit-department" name="editdepartment"/>
				<input type="hidden" id="edit-department-id" name="editdepartmentid"/>
			</div>
			<div class="form-group">
				<button type="submit" id="editDepartmentForm" class="ui teal submit button"><span id="hidedutext">UPDATE</span>&nbsp;
				<span class="editDepartmentForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
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
			<a href="javascript:void(0);" id="editDepartment" class="btn btn-sm btn-primary btn-table" data-toggle="modal" data-target="#EditDepartments" data-departmentid="{{$department->id}}" data-department="{{$department->department}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
			<a href="javascript:void(0);" id="deleteData" data-id="{{$department->id}}" data-type="department" class="btn btn-sm btn-primary btn-table btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
<form class="form-horizontal" method="POST" id="upload_department_form" action="javascript:void(0)" >                
	<!--01-->
	<div class="form-group">		
		<div class="col-sm-12 res_float_none">
			<label class="res_float_none mb-5">Department:</label>
			<input type="text" class="inp" placeholder="Enter Department" id="department" name="department" />			
		</div>
	</div>
	<!--01-->
	
	<!--04-->
	<div class="form-group">		
		<div class="col-sm-12 res_float_none">
		<button type="submit" id="departmentForm" class="ui teal submit button"><span id="hidedpttext">SAVE</span>&nbsp;
		<span class="departmentForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader.png') }}"></span>
		</button>
		</div>
	</div>
	<!--04-->               
	</form>  
  </div> 
 </div>
</div>
<!--Departments end--> 
 
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
	 <form method="POST" enctype="multipart/form-data" id="staff_create_form" action="javascript:void(0)" >
      <div class="modal-body">
	    <span class="text-center red" id="staff_error_text" style="display:none;">All fields are required.</span>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Name&nbsp;<span style="color:red;">*</span></label>
					<input type="text" class="form-control" id="staff_name" name="staff_name" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Email&nbsp;<span style="color:red;">*</span></label>
					<input type="email" class="form-control" id="staff_email" name="staff_email" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Phone No.&nbsp;<span style="color:red;">*</span></label>
					<input type="text" class="form-control" id="staff_phone" name="staff_phone" />
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>Password&nbsp;<span style="color:red;">*</span></label>
					<input type="password" class="form-control" id="staff_password" name="staff_password" />
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>Branch&nbsp;<span style="color:red;">*</span></label>
					<select id="staff_branch" name="staff_branch" class="form-control select-style">
                        <option value="">Select branch</option>
                         @foreach($branches as $branch) 
                             <option value="{{ $branch->id }}">{{ $branch->branch }}</option>
						 @endforeach
                    </select>
				</div>
			</div>
			
			<div class="col-md-6">
				<div class="form-group">
					<label>Department&nbsp;<span style="color:red;">*</span></label>
					<select id="staff_department" name="staff_department" class="form-control select-style">
                        <option value="">Select department</option>
                         @foreach($departments as $department) 
                             <option value="{{ $department->id }}">{{ $department->department }}</option>
						 @endforeach
                    </select>
				</div>
			</div>
			
			<div class="col-md-12">
				<div class="form-group">
					<label>Role&nbsp;<span style="color:red;">*</span></label>
					<select id="staff_role" name="staff_role" class="form-control select-style">
                        <option value="">Select role</option>
                         @foreach($roles as $role) 
                             <option value="{{ $role->id }}">{{ $role->name }}</option>
						 @endforeach
                    </select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
                    <button type="submit" id="addStaffForm" class="ui teal submit button"><span id="hidestafftext">SAVE</span>&nbsp;
					<span class="addStaffForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
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
	<a href="#" class="ui teal submit button" data-toggle="modal" data-target="#StaffCreation">
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
		<img id="avatar-div" class="ui avatar image" src="{{ asset(Laralum::publicPath() .'/images/avatar.jpg') }}"> 
	</div>
	<div class="media-body">
	<div class="text">	
	<a data-fancybox="data-fancybox" data-type="iframe" href="{{ route('console::staff_profile', ['id' => $staff->id]) }}">{{ $staff->name }}</a>	
	<br/>
	<a data-fancybox="data-fancybox" data-type="iframe" href="{{ route('console::staff_profile', ['id' => $staff->id]) }}">{{ $staff->email }}</a>
	</div>
	</div>
	</div>	
  </td>
  <td>{{ $staff->mobile }}</td>
  <td>{{ $staff->role }}</td>
  <td>{{ $staff->department }}</td>
  <td class="text-center">
  @if( $staff->ivr_extension==0)
	<a data-fancybox="data-fancybox" data-type="iframe" href="{{ route('console::staff_profile', ['id' => $staff->id]) }}"><small>Click to assign extension</small></a>
  @else
    {{ $staff->ivr_extension }}
  @endif
  </td>
  <td class="text-center">
	<a data-fancybox="data-fancybox" data-type="iframe" href="{{ route('console::staff_profile', ['id' => $staff->id]) }}" class="btn btn-sm btn-primary btn-table"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
	<a href="javascript:void(0);" id="deleteData" data-id="{{$staff->id}}" data-type="staff" class="btn btn-sm btn-primary btn-table btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
	<div class="col-md-12">
		<table class="ui table">
			<thead>
			<tr class="table_heading">
			<th width="20%">Role Name</th>
			<th width="80%">Description</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			<td>Role</td>
			<td>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit, 
				sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
			</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
<!--Roles end--> 
 
<!--Payments start-->
<div id="Payments" class="tab-pane fade p-0">	
<!-- Modal -->
<div id="AddBanks" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Bank Details</h4>
  </div>
 <form method="POST" id="upload_bank_form" action="javascript:void(0)" > 
  <div class="modal-body">
   <span class="text-center red" id="bank_error_text" style="display:none;">All fields are required.</span>
  <div class="row">
	   <div class="col-md-12">
			<div class="form-group">
				<label>Account Number&nbsp;<span style="color:red;">*</span></label>
				<input type="text" class="form-control" id="account_no" name="account_no" />
				<input type="hidden"  id="details_id" name="details_id" />
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Account Holder Name&nbsp;<span style="color:red;">*</span></label>
				<input type="text" class="form-control" id="account_holder_name" name="account_holder_name" />
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Bank Name&nbsp;<span style="color:red;">*</span></label>
				<input type="text" class="form-control" id="bank_name" name="bank_name" />
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Branch&nbsp;<span style="color:red;">*</span></label>
				<input type="text" class="form-control" id="bank_branch" name="bank_branch" />
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>IFSC Code&nbsp;<span style="color:red;">*</span></label>
				<input type="text" class="form-control" id="ifsc_code" name="ifsc_code" />
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
                <button type="submit" id="bankForm" class="ui teal submit button"><span id="hidebanktext">SAVE</span>&nbsp;
				<span class="bankForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
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
	<a href="#" class="ui teal submit button" id="addBankDetails" data-toggle="modal" data-target="#AddBanks">
		<i class="fa fa-plus-square-o" aria-hidden="true"></i>&nbsp;Add
	</a>
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
				<a href="javascript:void(0);" id="editBankDetails" class="btn btn-sm btn-primary btn-table" data-toggle="modal" data-target="#AddBanks" data-id="{{$details->id}}" data-name="{{ $details->ac_name }}" data-account="{{ $details->ac_number }}" data-bank="{{ $details->bank }}" data-branch="{{ $details->address }}" data-ifsc="{{ $details->ifsc_code }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
				<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "bank details"]) }}</p>
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
<form class="form-horizontal" method="POST" id="change_password_form" action="javascript:void(0)" >              
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
		<button type="submit" id="changePassForm" class="ui teal submit button"><span id="hidecptext">UPDATE</span>&nbsp;
		<span class="changePassForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
		</button>						
		</div>
	</div>
	<!--04-->                
	</form> 
  </div>
 </div> 
</div>
<!--ChangePaasword-->
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
$('#AddBanks').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
})
$(document).on('click','#editDepartment',function(e) {
	$('#edit-department').val($(this).attr('data-department'))
	$('#edit-department-id').val($(this).attr('data-departmentid'))
});
$(document).on('click','#editBankDetails',function(e) {
	$('#details_id').val($(this).attr('data-id'))
	$('#account_holder_name').val($(this).attr('data-name'))
	$('#account_no').val($(this).attr('data-account'))
	$('#bank_name').val($(this).attr('data-bank'))
	$('#bank_branch').val($(this).attr('data-branch'))
	$('#ifsc_code').val($(this).attr('data-ifsc'))
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
				text: 'Data deleted successfully!',
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

@endsection

<style>
.loadinggif {
    background:url('{{ asset(Laralum::publicPath() .'/images/ajax-loader.gif') }}') no-repeat right center;
}
</style>
