<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="_token" content="{{ csrf_token() }}">
	<link href="{{ asset(Laralum::publicPath() .'/font-awesome/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet" />        
   <link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('console_public/css/sb-admin.css') }}" rel="stylesheet">
	<link href="{{ asset(Laralum::publicPath() .'/css/custom.css') }}" type="text/css" rel="stylesheet" />  
	{!! Laralum::includeAssets('laralum_header') !!}
	<style>
body {
    margin: 0;
    max-width: 900px;
    padding: 0;
    padding: 20px;
	
}

.expand {
    background: rgba(0, 0, 0, .05);
}

.btn-primary
{
	background:#000068;
	border-color:#000068;
	font-size: 16px;
}

.btn-primary:hover
{
	background:#EC1228;
	border-color:#EC1228;
}

.mb-15
{
	margin-bottom: 15px !important;
}

.heading
{
	border-bottom: 1px #26476c solid;
margin: 20px 0 25px 0 !important;
padding-bottom: 12px;
color: #26476;
}

.fancybox-close-small{
    right: 15px !important;
    top: 0 !important;
    color: #26476c !important;
}

</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">			
			<div class="col-md-12">
				<h3 class="heading">Edit Staff - {{ $staff->name }}</h3>
			</div>
		<div class="col-sm-6">				
	    <span class="text-center red" id="staff_error_text" style="display:none;">All fields are required.</span>
	<form method="POST" enctype="multipart/form-data" id="staff_edit_form" action="javascript:void(0)" >
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Name&nbsp;<span style="color:red;">*</span></label>
					<input type="text" class="form-control" value="{{ $staff->name }}" id="staff_name" name="staff_name" />
					<input type="hidden" class="form-control" value="{{ $staff->id }}" id="staff_id" name="staff_id" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Email&nbsp;<span style="color:red;">*</span></label>
					<input type="email" class="form-control" value="{{ $staff->email }}" id="staff_email" name="staff_email" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Phone No.&nbsp;<span style="color:red;">*</span></label>
					<input type="text" class="form-control" value="{{ $staff->mobile }}" id="staff_phone" name="staff_phone" />
				</div>
			</div>
            <!--div class="col-md-6">
				<div class="form-group">
					<label>Role&nbsp;<span style="color:red;">*</span></label>
					<select id="staff_branch" name="staff_branch" class="form-control select-style">
                        <option value="">Select role</option>
                         @foreach($roles as $role) 
                             <option value="{{ $role->id }}" @if( isset($staff) && $staff->role_id==$role->id) selected="selected" @endif>{{ $role->name }}</option>
						 @endforeach
                    </select>
				</div>
			</div-->			
			<div class="col-md-6">
				<div class="form-group">
					<label>Branch&nbsp;<span style="color:red;">*</span></label>
					<select id="staff_branch" name="staff_branch" class="form-control select-style">
                        <option value="">Select branch</option>
                         @foreach($branches as $branch) 
                             <option value="{{ $branch->id }}" @if( isset($staff) && $staff->branch==$branch->id) selected="selected" @endif>{{ $branch->branch }}</option>
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
                             <option value="{{ $department->id }}" @if( isset($staff) && $staff->department==$department->id) selected="selected" @endif>{{ $department->department }}</option>
						 @endforeach
                    </select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>Role&nbsp;<span style="color:red;">*</span></label>
					<select id="staff_role" name="staff_role" class="form-control select-style">
                        <option value="">Select Role</option>
                         @foreach($roles as $role) 
                             <option value="{{ $role->id }}" @if( isset($staff) && $staff->role_id==$role->id) selected="selected" @endif>{{ $role->name }}</option>
						 @endforeach
                    </select>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label>For appointment meet?&nbsp;<span style="color:red;">*</span></label>
					<select id="appointment_meet" name="appointment_meet" class="form-control select-style">
                        <option value="">Please select</option>                        
                        <option value="1" @if( isset($staff) && $staff->isAptMeet==1) selected="selected" @endif>Yes</option>
                        <option value="0" @if( isset($staff) && $staff->isAptMeet==0) selected="selected" @endif>No</option>						 
                    </select>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
				
                    <button type="submit" id="editStaffForm" class="ui teal submit button"><span id="hideeditstafftext">SAVE</span>&nbsp;
					<span class="editStaffForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
					</button>										
				</div>
			</div>
		</div>
      </form>
		</div>
			@if($staff->ivr_access==1)
		<!--is-ivr-access--->
		<div class="col-sm-6">
		<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label>IVR Access&nbsp;<span style="color:red;">*</span></label>
				<select class="form-control select-style" disabled>
					<option value="1" selected>Yes</option>					 
				</select>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<label>Extension number&nbsp;<span style="color:red;">*</span>
				<i class="fa fa-info-circle modal-form-info" data-toggle="tooltip" data-placement="right" title="Extension number for the user (usually between 11 to 99, should be a number not assigned as an extension to another User)."></i>
				</label>
				<input type="text" class="form-control" value="{{ $staff->ivr_extension }}" placeholder="Enter ext between 11 to 99" disabled />
	
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<button type="submit" id="ivrAccess" class="ui teal submit button" disabled><span id="ivrAccessText">SAVE</span>&nbsp;
				<span class="ivrAccess" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
				</button>										
			</div>
		</div>
		</div>
		</div>	
		<!--is-ivr-access--->
		@else
		<div class="col-sm-6">
		<form method="POST" enctype="multipart/form-data" id="ivr_permission_form" action="javascript:void(0)" >
		<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<label>IVR Access&nbsp;<span style="color:red;">*</span></label>
				<select id="ivr_access" name="ivr_access" class="form-control select-style">
					<option value="1">Yes</option>					 
					<option value="0" selected>No</option>
				</select>
			</div>
		</div>
		<div class="col-sm-12" id="ext_div">
			<div class="form-group">
				<label>Extension number&nbsp;<span style="color:red;">*</span>
				<i class="fa fa-info-circle modal-form-info" data-toggle="tooltip" data-placement="right" title="Extension number for the user (usually between 11 to 99, should be a number not assigned as an extension to another User)."></i>
				</label>
				<input type="text" class="form-control"  id="ext_no" name="ext_no" placeholder="Enter ext between 11 to 99"/>
				<input type="hidden" class="form-control"  value="{{ $staff->id }}" name="access_user_id" id="access_user_id"/>
				<input type="hidden" class="form-control"  value="{{ $staff->mobile }}" name="access_user_mobile" id="access_user_mobile"/>
				<input type="hidden" class="form-control"  value="{{ $staff->name }}" name="access_user_name" id="access_user_name"/>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-group">
				<button type="submit" id="ivrAccess" class="ui teal submit button"><span id="ivrAccessText">SAVE</span>&nbsp;
				<span class="ivrAccess" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
				</button>										
			</div>
		</div>
		</div>
		</form>
		</div>
       @endif		
	</div>
</div>
<script type="text/javascript">
      var APP_URL = {!! json_encode(url('/')) !!};	
    </script>
<script src="{{ asset(Laralum::publicPath() .'/js/jquery-3.0.0.min.js') }}"></script>	  
<script>
//Department form script	
	$('#staff_edit_form').submit(function(e) {
		e.preventDefault();		
		var staff_name = $('#staff_name').val();
		var staff_email = $('#staff_email').val();
		var staff_phone = $('#staff_phone').val();
		var staff_branch = $('#staff_branch').val();
		var staff_role = $('#staff_role').val();
		var staff_department = $('#staff_department').val();
				
		if(staff_name=='' || staff_email=='' || staff_phone=='' || staff_branch=='' || staff_department==''|| staff_role==''){
		  $('#staff_error_text').show();
		  return false;
		}	
		
		var type = "POST"; 
		 $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		var formData = new FormData(this); 
		var my_url = APP_URL+'/console/manage/updateStaffData';
		var type = "POST";	
		$("#hideeditstafftext").css('display','none');
	    $(".editStaffForm").css('display','inline-block');
		$.ajax({
			type: type,
			url: my_url,
			data: formData,
			processData: false,
            contentType: false,
			dataType: 'json',
			success: function (data) {
				$(".editStaffForm").css('display','none');
				$("#hideeditstafftext").css('display','inline-block');										    				
                swal({ title: "Success!", text: "Staff data updated successfully!", type: "success" }, function(){ location.reload(); });				
			},
			error: function (data) {				
				swal('Error!',data,'error')
			}
		});
		 
	});
	
//Department form script	
	$('#ivr_permission_form').submit(function(e) {
		e.preventDefault();		
		var ext_no = $('#ext_no').val();
		
		if(ext_no==''){
			swal('Warning!','Please enter extension number for the staff (usually between 11 to 99, should be a number not assigned as an extension to another User)','warning')
			return false;
		}				
		
		var type = "POST"; 
		 $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		var formData = new FormData(this); 
		var my_url = APP_URL+'/console/manage/callingAccess';
		var type = "POST";	
		$("#ivrAccessText").css('display','none');
	    $(".ivrAccess").css('display','inline-block');
		$.ajax({
			type: type,
			url: my_url,
			data: formData,
			processData: false,
            contentType: false,
			dataType: 'json',
			success: function (data) {				
               if(data.status=='success'){				   
					$(".ivrAccess").css('display','none');
					$("#ivrAccessText").css('display','inline-block');
					swal({ title: "Success!", text: data.message, type: "success" }, function(){ location.reload(); });
					
				}else if(data.status=='error'){					
					$(".ivrAccess").css('display','none');
					$("#ivrAccessText").css('display','inline-block');		
                	swal({ title: "Error!", text: data.message, type: "error" }, function(){ location.reload(); });	
				}else{
				   swal({ title: "Error!", text: "Something went wrong, please try again!", type: "error" }, function(){ location.reload(); });	
					
				}					
			},
			error: function (data) {				
				swal('Error!',data,'error')
			}
		});
		 
	});
		
</script>
<script>
$(function() {
	$('#ext_div').hide();
    $('#ivr_access').change(function(){
        if($('#ivr_access').val() == 1) {
            $('#ext_div').show(); 
        } else {
            $('#ext_div').hide(); 
        } 
    });
});	
</script>
<script>
$(".fancybox").fancybox({
	onClosed: function () { 
		parent.location.reload(false);
	}
});
</script>
</body>
</html>