@extends('layouts.crm.panel')
@section('breadcrumb')
   <div class="ui breadcrumb">
        <a class="section" href="{{ route('Crm::leads') }}">{{ trans('laralum.leads_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.edit_lead') }}</div>
    </div>
@endsection
@section('title', trans('laralum.edit_lead'))
@section('icon', "edit")
@section('subtitle', trans('laralum.lead_edit_subtitle', ['name' => $lead->name]))
@section('content')
<div class="ui one column doubling stackable grid container">
    <div class="three wide column"></div>
	<div class="ui very padded segment">
    <div class="fifteen wide column">      
	<form class="ui form" action="{{ route('Crm::lead_update', [$lead->id]) }}" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
       
			<div class="col-md-12">
				<h3 class="form-heading">Account Details</h3>
			</div>
			<div class="col-md-4">
				<div class="form-group ">
					<label>Account Type</label>
					<select class="form-control custom-select" name="account_type" id="account_type">
						<option value="">Please select..</option>
						<option value="Permanent" {{ $lead->account_type == 'Permanent' ? 'selected': '' }}>Permanent</option>
						<option value="Temporary" {{ $lead->account_type == 'Temporary' ? 'selected': '' }}>Temporary</option>
					</select>
									
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group ">
					<label>Department</label>
					<select class="form-control custom-select" name="department" id="department">
						<option value="">Please select..</option>
						<option value="Donation" {{ $lead->department == 'Donation' ? 'selected': '' }}>Donation</option>
						<option value="Appointment" {{ $lead->department == 'Appointment' ? 'selected': '' }}>Appointment</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group ">
					<label>Lead Source</label>
					<input type="text" class="form-control" id="lead_source" name="lead_source" value="{{ old('lead_source', isset($lead) ? $lead->lead_source : '') }}" />
				</div>
			</div>
			
			<div class="col-md-12">
				<hr>
			</div>
			
			<div class="col-md-12">
				<h3 class="form-heading">Personal Details</h3>
			</div>
			
			<div class="col-md-2 text-center">
			     @if($lead->profile_photo)
				<img src="{{ asset('crm/leads') }}/{{ $lead->profile_photo }}" alt="" class="img-thumbnail mx-auto d-block img-fluid" id="selected_pic" />
				@else
				<img src="{{ asset('crm_public/images/select-profile.jpg') }}" alt="" class="img-thumbnail mx-auto d-block img-fluid" id="selected_pic">
				@endif
				
				<div class="select-pic-btns">
				<a class="btn btn-sm btn-primary" id="profile_img_btn" onclick="$('.dimmer').removeClass('dimmer')">Select Picture</a>
				<input name="hidden_profile_photo" value="{{ $lead->profile_photo }}" type="hidden" />
				<input id="profile_img" name="profile_photo" type="file">	
				<p class="help-block">Max Size: 2 MB</p>
				</div>
			</div>
			
			<div class="col-md-10">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group ">
							<label>Name <span class="red-txt">*</span></label>
							<input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($lead) ? $lead->name : '') }}">
							<input type="hidden" class="form-control" id="client_id" name="client_id" value="1">
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group ">
							<label>Gender</label>
							<select class="form-control custom-select" id="gender" name="gender">
								<option value="Male" {{ old('gender', $lead->gender == 'Male' ? 'selected': '') }}>Male</option>
								<option value="Female" {{ old('gender', $lead->gender == 'Female' ? 'selected': '') }}>Female</option>
							</select>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>Date of Birth</label>
							<input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob', isset($lead) ? $lead->date_of_birth : '') }}" />
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							<label>Date of Joining</label>
							<input type="date" class="form-control" id="doj" name="doj" value="{{ old('doj', isset($lead) ? $lead->date_of_joining : '') }}" />
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-md-12">
				<hr>
			</div>
			
			<div class="col-md-12">
				<h3 class="form-heading">Contact Details</h3>
			</div>
			
			<div class="col-md-4">
				<div class="form-group ">
				<label>Email <span class="red-txt">*</span></label>
				<input type="email" class="form-control" id="email" name="email" value="{{ old('email', isset($lead) ? $lead->email : '') }}" />         
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group ">
				<label>Mobile <span class="red-txt">*</span></label>
				<input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', isset($lead) ? $lead->mobile : '') }}" />
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label>Address</label>
					<input type="text" class="form-control" id="address" name="address" value="{{ old('address', isset($lead) ? $lead->address : '') }}" />
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label>State</label>
					<select class="form-control custom-select" id="state" name="state">
						<option value="">Please select</option>
						@foreach($get_state as $state)
						 <option value="{{ $state->StCode }}" {{ old('state', $lead->state == $state->StCode ? 'selected': '') }}>{{ $state->StateName }}</option>
						@endforeach
						 
					</select>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label>District</label>
					<select class="form-control custom-select" id="district" name="district">
						<option>Select District</option>
						@foreach($get_district as $district)
						<option value="{{ $district->DistCode }}" {{ old('district', $lead->district == $district->DistCode ? 'selected': '') }}>{{ $district->DistrictName }}</option>
					   @endforeach
					</select>
			</div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label>Pincode</label>
					<input type="text" class="form-control" id="pincode" name="pincode" value="{{ old('pincode', isset($lead) ? $lead->pincode : '') }}" />
				</div>
			</div>
			@if (count($family_members) > 0)
			<div class="col-md-12">
				<hr />
			</div>
			
			<div class="col-md-12">
				<h3 class="form-heading">Family Details</h3>
			</div>
		 @foreach($family_members as $member) 
		  <div class="col-md-12">
		  <div class="fieldmore row">
			<div class="add-inp-div">
				<div class="form-group">
					<label>Name</label>
					<input type="text" class="form-control" name="family_member_name[]" value="{{ $member->member_relation_name }}" />
				</div>
			</div>
			
			<div class="add-inp-div">
				<div class="form-group">
					<label>Relationship</label>
					<input type="text" class="form-control" name="family_member_relation[]" value="{{ $member->member_relation }}" />
				</div>
			</div>
			
			<div class="add-inp-div">
				<div class="form-group">
					<label>Date of Birth</label>
					<input type="date" class="form-control" name="family_member_dob[]" value="{{ $member->member_relation_dob }}" />
				</div>
			</div>
			
			<div class="add-inp-div">
				<div class="form-group">
					<label>Mobile</label>
					<input type="text" class="form-control" name="family_member_mobile[]" value="{{ $member->member_relation_mobile }}" />
				</div>
			</div>
			   @if($loop->last)
				<div class="add-btn-div">
					<a href="javascript:void(0);" class="btn btn-sm btn-primary family-add-btn addMore" onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-plus"></i></a>
				</div>
			  @endif
		   </div>
		   </div>
		   @endforeach
		   @endif
			<div class="col-md-12 text-right mb-30 mt-30">
				<button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
			</div>
		
		
		
	</form>
     </div>
    </div>
    <div class="three wide column"></div>
</div>
<!-- copy of input fields group -->
<div class="fieldmoreCopy row" style="display: none;">

<div class="add-inp-div">
<div class="form-group">
<label>Name</label>
<input type="text" class="form-control" name="family_member_name[]" />
</div>
</div>

<div class="add-inp-div">
<div class="form-group">
<label>Relationship</label>
<input type="text" class="form-control" name="family_member_relation[]" />
</div>
</div>

<div class="add-inp-div">
<div class="form-group">
<label>Date of Birth</label>
<input type="date" class="form-control" name="family_member_dob[]" />
</div>
</div>

<div class="add-inp-div">
<div class="form-group">
<label>Mobile</label>
<input type="text" class="form-control" name="family_member_mobile[]" />
</div>
</div>

<div class="add-btn-div">
<a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove" onclick="$('.dimmer').removeClass('dimmer')"><i class="fa fa-minus"></i></a>
</div> 
</div>
@endsection
@section('js')
<script>
<!--for image selection---->
$('#profile_img_btn').bind("click" , function () {
        $('#profile_img').click();
 });

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$('#selected_pic').attr('src', e.target.result);
		}
		
		reader.readAsDataURL(input.files[0]);
	}
  }
    
$("#profile_img").change(function(){
	readURL(this);
});
<!---for fetch district---->
$('#state').change(function(){
  var stateID = $(this).val();
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
                $("#district").empty();
                $("#district").append('<option>Please select</option>');
                $.each(res,function(key,value){
                    $("#district").append('<option value="'+key+'">'+value+'</option>');
                });
           
            }else{
               $("#district").empty();
            }
           }
        });
    }else{
        $("#state").empty();
        $("#city").empty();
    }      
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
</script>
@endsection