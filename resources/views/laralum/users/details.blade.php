@extends('layouts.admin.panel')
@section('breadcrumb')
 <div class="ui breadcrumb">
	<a class="section" href="{{ route('Laralum::users') }}">{{ trans('laralum.user_manager') }}</a>
	<i class="right angle icon divider"></i>
	<div class="active section">{{ $users->name }}</div>
</div>  
@endsection
@section('title', trans('laralum.client_manager'))
@section('content')
<div class="ui one column doubling stackable grid container mb-30">
<div class="column">
 <div class="ui very padded segment">  
   <div class="twelve wide column padding_t_l">
      <div class="ui very padded segment padding_1rem user-detail-page-design padding_user_profile">
       
       <!--top_user_profile-->
       <div class="top_user_profile">
       <!--top_user_profile_left-->
       <div class="top_user_profile_left">
       
       <div class="top_user_profile_left_slider">
       <div class="left_arrow">
	   @isset($previous)
	   <a href="{{ route('Laralum::user_details',['id' => $previous, 'name' => $previousName ]) }}"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
	   @else
		<a href="javascript:void(0)" style="cursor: default;"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
        @endif	
	   </div>
       <div class="middel_area">
         <h3>{{ $users->name }}</h3>
         <p>{{ $users->email }}</p>
         <small>{{ date("jS F, Y", strtotime($users->created_at)) }}</small>
       </div>
       <div class="right_arrow">
	   @isset($next)
	   <a href="{{ route('Laralum::user_details',['id' => $next, 'name' => $nextName ] ) }}"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
	   @else
	   <a href="javascript:void(0)" style="cursor: default;"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
       @endif
	   </div>
       </div>
       
       </div>
       <!--top_user_profile_left-->
       
       <!--top_user_profile_right-->
       <div class="top_user_profile_right">
	    @if($users->id != Laralum::loggedInUser()->id)
        <a href="{{ route('Laralum::switch_start',['id' => $users->id]) }}" class="ui {{ Laralum::settings()->button_color }} button">Login as</a>
        @endif
       <!--radio-btn-->
       <strong class="custom-radio2">
		<span><input id="Enable" class="rad" name="status" value="1" type="radio" @if($users->active==1) checked="checked" disabled @endif />
		  <label for="Enable">Enable</label></span>
		<input id="user_id"  value="{{ $users->id }}" type="hidden">	
		<span><input id="Disable" class="rad" name="status" value="0" type="radio" @if($users->active==0) checked="checked" disabled @endif>
		<label for="Disable">Disable</label></span>
			
		  </strong>
       <!--radio-btn-->
       </div>
       <!--top_user_profile_right-->
       
       </div>
       <!--top_user_profile-->
       
       
       <!--tab_user_profile-->
       <div class="tab_user_profile">
       
       <div class="col-md-6">
       <!--new-tab-area-->
<div class=""> 
 <ul class="nav nav-tabs">
    <li class="active">
		<a data-toggle="tab" href="#Fund">
			<i class="fa fa-usd" aria-hidden="true"></i>
			<span>Fund</span>
		</a> 
	</li>
	<li>
		<a data-toggle="tab" href="#Settings">
			<i class="fa fa-cog" aria-hidden="true"></i>
			<span>Settings</span>
		</a> 
	</li>
	<li>
		<a data-toggle="tab" href="#Security">
			<i class="fa fa-lock" aria-hidden="true"></i>
			<span>Security</span>
		</a> 
	</li>
  </ul>
  
  <div class="tab-content">
    <div id="Fund" class="tab-pane fade in active">
     
    <form class="form form-inline form-multiline" id="frmFund" name="frmFund" role="form">
      <input id="user_id"  value="{{ $users->id }}" type="hidden">
		<div class="form-group">
		  <label for="InputFieldA">Select Route:</label>
		 <select class="inp select-style" id="route">
			 <option value="">Select Route</option>
			 <option value="1">Promotional</option>
			 <option value="4">Transactional</option>
		 </select>
		</div>

		 <div class="form-group">
		  <label for="InputFieldA">No. of credits:</label>
		  <input type="text" class="inp" id="credit" placeholder=""/>
		</div>

		 <div class="form-group">
		  <label for="InputFieldA">Price per credit:</label>
		  <input type="text" class="inp" id="price" placeholder=""/>
		</div>

		 <div class="form-group">
		  <label for="InputFieldA">Description:</label>
		  <textarea class="inp_txt" id="description"></textarea>
		</div>

		 <div class="form-group">
		  <label for="InputFieldA">Net Amount:</label>
		  <span id="showAmnt">0</span>
		</div>

		<div class="form-group margin_b_0">
		  <label for="InputFieldA">&nbsp;</label>
		  <button type="submit" id="credit"  class="ui teal submit button action">+ Add Balance</button>
		  <button type="submit" id="debit"   class="ui teal submit button red action">- Reduce Balance</button>
		</div>
    
  </form>
     
    </div>
     <div id="Settings" class="tab-pane fade">
     
     
    <form class="form-horizontal" role="form">
			<!--change-password-->
			<!--div class="form-group">
			 <div class="col-md-6">
			  <label for="InputFieldA">Change Password</label>
			 <input type="text" class="inp" id="InputFieldA" placeholder="">
			</div>
			
			<div class="col-md-6">
			<label for="InputFieldA" class="display-block">&nbsp;</label>
			<input type="submit" class="ui teal button" value="Change" />
			</div>
			</div-->
			<!--change-password-->
			
			 <!--Status-->
			<div class="form-group">
			 <div class="col-md-6">
			  <label for="InputFieldA">User Role</label>
			 <select class="inp select-style" id="role_id">
			  @foreach($roles as $role)
				 <option value="{{ $role->id }}" @if($role_id==$role->id) selected="selected" @endif>{{ $role->name }}</option>
			  @endforeach
			 </select>
			</div>
			
			<div class="col-md-6">
			<label for="InputFieldA" class="display-block">&nbsp;</label>
			<input type="submit" id="changeRole" class="ui teal button" value="Change" />
			<span  class="ajaxloaders" style="visibility:hidden;"><img src="{{ asset(Laralum::publicPath() . '/images/ajax-loader.gif') }}"/></span>
			</div>
			</div>
			<!--Status-->
			
			<!--divider-->
			<hr />
			<!--divider-->
			
			<!--openid-->
			<div class="form-group">
			 <div class="col-md-6">
			  <label for="InputFieldA">Open ID access</label>
			 <select class="inp select-style" id="openid">
			     <option value="0" @if($users->is_openid_access==0) selected="selected" @endif>No</option>
				 <option value="1" @if($users->is_openid_access==1) selected="selected" @endif>Yes</option>
				 
			 </select>
			</div>
			
			<div class="col-md-6">
			<label for="InputFieldA" class="display-block">&nbsp;</label>
			<input type="button" id="openidAccess" class="ui teal button" value="Change" />
			<span  class="ajaxloader" style="visibility:hidden;"><img src="{{ asset(Laralum::publicPath() . '/images/ajax-loader.gif') }}"/></span>
			</div>
			</div>
			<!--openid-->
			
			 <!--user-expiry-->
			<div class="form-group">
			 <div class="col-md-6">
			  <label for="InputFieldA">Change Expiry</label>
			 <input type="text" class="inp" id="InputFieldA" placeholder="N/A">
			</div>
			
			<div class="col-md-6">
			<label for="InputFieldA" class="display-block">&nbsp;</label>
			<input type="submit" class="ui teal button" value="Update" />
			<input type="submit" class="ui teal button button1" value="Remove Expiry" />
			</div>
			</div>
		   <!--user-expiry-->
			
			<!--divider-->
			<hr />
			<!--divider-->
		
			<div class="row user-setting">
			<div class="col-md-12">
			<h4>General Information</h4>
			<p>This information will only be usde for invoicing and desgning custom features for alike users.</p>
			</div>
			
			<!--first-name-->
			<div class="col-md-6">
			<div class="form-group">
			<label>Full Name</label>
			 <input type="text" class="inp" id="fullname" value="{{ $users->name }}" placeholder="">
			 <input type="hidden" class="inp" id="uid" value="{{ $users->id }}" placeholder="">
			</div>
			</div>
			<!--first-name-->
			
			<!--Industry-->
			<div class="col-md-6">
			<div class="form-group">
			<label>Industry</label>
			  <select class="inp select-style" id="industry">
				 <option value="">Select Industry</option>
				 @foreach($industries as $industry)
				  <option value="{{ $industry }}" @if($users->industry==$industry) selected="selected" @endif>{{ $industry }}</option>
				 @endforeach
			 </select>
			</div>
			</div>
			<!--Industry-->
			
			
			
			<!--City-->
			<div class="col-md-6">
			<div class="form-group">
			<label>City</label>
			 <input type="text" class="inp" id="city" value="{{ isset($users->city) ? $users->city : '' }}" placeholder="">
			</div>
			</div>
			<!--City-->
			
			<!--User-name-->
			<div class="col-md-6">
			<div class="form-group">
			<label>User Name</label>
			 <input type="text" class="inp" id="username" placeholder="" value="{{ $users->email }}" disabled>
			</div>
			</div>
			<!--User-name-->
			
			<!--Zipcode-->
			<div class="col-md-6">
			<div class="form-group">
			<label>Zipcode </label>
			 <input type="text" class="inp" value="{{ isset($users->zip) ? $users->zip : '' }}" id="zipcode" placeholder="">
			</div>
			</div>
			<!--Zipcode-->
			
			<!--Mobile-->
			<div class="col-md-6">
			<div class="form-group">
			<label>Mobile No.</label>
			 <input type="text" class="inp" id="mobile" value="{{ isset($users->mobile) ? $users->mobile : '' }}" placeholder="">
			</div>
			</div>
			<!--Mobile-->
			
			<!--Country-->
			<div class="col-md-6">
			<div class="form-group">
			<label>Country</label>
			  <select class="inp select-style" id="country">
				 <option value="">Select Country</option>
				 @foreach($countries as $key=>$val)
				  <option value="{{ $key }}" @if($users->country_code==$key) selected="selected" @endif>{{ $val }}</option>
				 @endforeach
			 </select>
			</div>
			</div>
			<!--Country-->
			
			<!--Email-->
			<div class="col-md-6">
			<div class="form-group">
			<label>Email</label>
			 <input type="text" class="inp" id="email" placeholder="" value="{{ $users->email }}" disabled>
			</div>
			</div>
			<!--Email-->
			
		  
			
			<!--Company-->
			<div class="col-md-6">
			<div class="form-group">
			<label>Company</label>
			 <input type="text" class="inp" id="company" value="{{ isset($users->company) ? $users->company : '' }}" placeholder="">
			</div>
			</div>
			<!--Company-->
			
			  <!--Address-->
			<div class="col-md-6">
			<div class="form-group">
			<label>Address</label>
			 <textarea class="inp_txt" id="address" placeholder="">{{ isset($users->address) ? $users->address : '' }}</textarea>
			</div>
			</div>
			<!--Address-->
			
			<!--Update-->
			<div class="col-md-12">
			<div class="form-group">
			 <input type="submit" class="ui teal button" id="updateprofile" value="Update">
			</div>
			</div>
			<!--Update-->
			
			</div>
    
    </form>
     
    </div>
      <div id="Security" class="tab-pane fade">
      <h3>Second Section</h3>
      <p>Sed dignissim lacinia nunc. Curabitur tortor. Pellentesque nibh. Aenean quam. In scelerisque sem at dolor. Maecenas mattis. Sed convallis tristique sem. Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel, suscipit quis, luctus non, massa. Fusce ac turpis quis ligula lacinia aliquet. Mauris ipsum. Nulla metus metus, ullamcorper vel, tincidunt sed, euismod in, nibh. </p>
    
    </div>
  </div><!--tab-content-->
</div>
<!--new-tab-area-->
       </div>
       
       <div class="col-md-3">
       <h3>Current Balance</h3>
       
       <!--01-->
       <div class="top_user_profile_right_pro">
       	<span>Promotional Route</span>
		<strong> {{{ isset($balance->promotional) ? $balance->promotional : 0 }}}</strong>
		<span>Text</span>
       </div>
       <!--01-->
       
        <!--02-->
       <div class="top_user_profile_right_tran">
       	<span>Transactional Route</span>
		<strong>{{{ isset($balance->transactional) ? $balance->transactional : 0 }}}</strong>
		<span>Text</span>
       </div>
       <!--02-->
       
        <!--03-->
       <div class="top_user_profile_right_pro">
       	<span>OTP Route</span>
		<strong>{{{ isset($balance->otp) ? $balance->otp : 0 }}}</strong>
		<span>Text</span>
       </div>
       <!--03-->
        <!--02-->
       <div class="top_user_profile_right_tran">
       	<span>Keyword</span>
		<strong>{{{ isset($balance->Keyword) ? $balance->Keyword : 0 }}}</strong>
		<span>Longcode</span>
       </div>
       <!--02-->
	   
	   
         <!--03-->
       <div class="top_user_profile_right_pro">
       	<span>Inbox</span>
		<strong>{{{ isset($balance->Inbox) ? $balance->Inbox : 0 }}}</strong>
		<span>Longcode</span>
       </div>
       <!--03-->
      
       
       </div><!--col-md-3-->
	   
	   <div class="col-md-3">
        <div class="ui very padded segment padding_none group_list_send_sms">
            
         <h3>My Balance</h3>
            
        <!--01-->
       <div class="top_user_profile_right_gray">
       	<span>Promotional Route</span>
		<strong>{{ $adminBalance->promotional }}</strong>
		<span>Text</span>
       </div>
       <!--01--> 
       
         <!--01-->
       <div class="top_user_profile_right_gray">
       	<span>Transactional Route</span>
		<strong>{{ $adminBalance->transactional }}</strong>
		<span>Text</span>
       </div>
       <!--01--> 
       
         <!--01-->
       <div class="top_user_profile_right_gray">
       	<span>OTP Route</span>
		<strong>{{ $adminBalance->otp }}</strong>
		<span>Text</span>
       </div>
       <!--01--> 
       
         <!--01-->
       <div class="top_user_profile_right_gray">
       	<span>Keyword</span>
		<strong>{{ $adminBalance->Keyword }}</strong>
		<span>Longcode</span>
       </div>
       <!--01--> 
          <!--01-->
       <div class="top_user_profile_right_gray">
       	<span>Inbox</span>
		<strong>{{ $adminBalance->Inbox }}</strong>
		<span>Longcode</span>
       </div>
       <!--01-->     
          
       </div>
    </div>  <!--col-md-3-->
	   
       
       </div>
       <!--tab_user_profile-->
       
       
       
        </div>
		
    </div>
        
</div>
</div>
</div>
<script src="{{ asset(Laralum::publicPath() .'/js/profile-script.js') }}"></script>
<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection