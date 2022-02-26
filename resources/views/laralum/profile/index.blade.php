@extends('layouts.admin.panel') 
@section('breadcrumb')
@endsection
@section('title', trans('laralum.profile_manager'))
@section('content')
<div class="ui one column doubling stackable grid container mb-30">
<div class="column">
 <div class="ui very padded segment">
<div class="col-md-12">
<ul class="nav nav-tabs">
  <li class="active"><a class="ripple" data-toggle="tab" href="#General"><i class="fa fa-cog" aria-hidden="true"></i><span>GENERAL</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#Biling"><i class="fa fa-credit-card" aria-hidden="true"></i><span>BILLING</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#Account"><i class="fa fa-user" aria-hidden="true"></i><span>ACCOUNT</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#ChangePaasword"><i class="fa fa-unlock-alt" aria-hidden="true"></i><span>CHANGE PASSWORD</span></a></li>
  <li><a class="ripple" data-toggle="tab" href="#UserSubscription"><i class="fa fa-th" aria-hidden="true"></i><span>USER SUBSCRIPTION</span></a></li>
</ul>

<div class="tab-content">
  <!--General-->
  <div id="General" class="tab-pane fade in active">  
  <div class="row">
  <div class="col-md-6"> 
          <form class="form-horizontal">
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">User Name:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="user_name" value="{{ ($datas->email) ? $datas->email : '' }}" disabled>
						
					</div>
				</div>
				<!--01-->                              
                <!--02-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Mobile No.:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="mobile" value="{{ ($datas->mobile) ? $datas->mobile : '' }}" disabled>
						
					</div>
				</div>
				<!--02-->
                
                <!--03-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Full Name:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="fullname" value="{{ ($datas->name) ? $datas->name : '' }}">
						
					</div>
				</div>
				<!--03-->
                
                
                <!--05-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Email:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="altemail" value="{{ ($datas->alt_email) ? $datas->alt_email : 'N/A' }}">
						
                        <!--a href="#">Wish to receive notifications on multiple  email addresses?</a-->
                        
					</div>
				</div>
				<!--05-->
                
                <!--06-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Alternate Contact:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="altcontact" value="{{ ($datas->alt_mobile) ? $datas->alt_mobile : 'N/A' }}">
						
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
					<button type="button" id="generalForm" class="ui teal submit button">Update</button>
					<span  class="generalForm" style="visibility:hidden;"><img src="{{ asset(Laralum::publicPath() . '/images/ajax-loader.gif') }}"/></span>
					</div>
				</div>
				<!--08-->		
	  </form>  
  </div>
  </div>  
  </div>
 <!--General-->
 
 <!--Biling-->
 <div id="Biling" class="tab-pane fade">
 <div class="row">
 <div class="col-md-6"> 
           <form class="form-horizontal">				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Company:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="company" value="{{ ($datas->company) ? $datas->company : 'N/A' }}" />
						
					</div>
				</div>
				<!--01-->
                
                
                <!--02-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Address:</label>
					<div class="col-sm-8 res_float_none">
						<textarea class="inp_txt" placeholder="" id="address">{{ ($datas->address) ? $datas->address : 'N/A' }}</textarea>
						
					</div>
				</div>
				<!--02-->
                
                <!--03-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">City:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="city" value="{{ ($datas->city) ? $datas->city : 'N/A' }}" />
						
					</div>
				</div>
				<!--03-->
                
                <!--04-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Zipcode:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="zipcode" value="{{ ($datas->zip) ? $datas->zip : 'N/A' }}" />
						
					</div>
				</div>
				<!--04-->
                
                <!--05-->
				<!--div class="form-group">
					<label class="control-label col-sm-4 res_float_none">State:</label>
					<div class="col-sm-8 res_float_none">
						<select id="" class="inp">
                        <option>Select State</option>
                        <option>Maharashtra</option>
                        </select>
                        
					</div>
				</div-->
				<!--05-->
                
                <!--06-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Country:</label>
					<div class="col-sm-8 res_float_none">
						<select id="country" class="inp select-style">
                           <option>Select Country</option>
						   @foreach($countries as $key=>$val) 
                             <option value="{{ $key }}" @if($datas->country_code==$key) selected="selected" @endif>{{ $val }}</option>
						   @endforeach
                        </select>
						
					</div>
				</div>
				<!--06-->
                
                <!--07-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">GST No.:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="gstno" value="{{ ($datas->gst_no) ? $datas->gst_no : 'N/A' }}" />
                        
                        <span>If you don't provide GST number you will unable to claim input/output tax.</span>
						
					</div>
				</div>
				<!--07-->
                
                <!--08-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">&nbsp;</label>
					<div class="col-sm-8 res_float_none">
					<button type="button" id="billingForm" class="ui teal submit button">Update</button>
					<span  class="billingForm" style="visibility:hidden;"><img src="{{ asset(Laralum::publicPath() . '/images/ajax-loader.gif') }}"/></span>
					</div>
				</div>
				<!--08-->               
	</form> 
  </div>
  </div>
   
  </div>
  <!--Biling-->
  
   <!--Account-->
  <div id="Account" class="tab-pane fade">   
  <div class="row">
  <div class="col-md-6"> 
  <form class="form-horizontal">
                
                <!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Default Sender ID:</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="" id="defaultSenderID" value="{{ ($datas->default_senderid) ? $datas->default_senderid : 'N/A' }}" />
						
					</div>
				</div>
				<!--01-->
                
                <!--02-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Industry:</label>
					<div class="col-sm-8 res_float_none">
						<select id="industry" class="inp select-style">
                        <option value="">Select Industry</option>
                         @foreach($industries as $key=>$val) 
                             <option value="{{ $key }}" @if($datas->industry==$key) selected="selected" @endif>{{ $val }}</option>
						 @endforeach
                        </select>
                        
					</div>
				</div>
				<!--02-->
                
                <!--03-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Time Zone:</label>
					<div class="col-sm-8 res_float_none">
					<select id="timeZone" class="inp select-style">
                        <option>Select Time Zone</option>
                        <?php foreach(Laralum::getTimeZone() as $t) { ?>
						  <option value="<?php print $t['zone'] ?>" <?php if($t['zone']=='Asia/Kolkata'){  echo "selected='selected'" ;} ?>>
							<?php print $t['diff_from_GMT'] . ' - ' . $t['zone'] ?>
						  </option>
						<?php } ?>
                       </select>
						
					</div>
				</div>
				<!--03-->
                
             
                
                <!--04-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">&nbsp;</label>
					<div class="col-sm-8 res_float_none">
					<button type="button" id="accountForm" class="ui teal submit button">Update</button>
					<span  class="accountForm" style="visibility:hidden;"><img src="{{ asset(Laralum::publicPath() . '/images/ajax-loader.gif') }}"/></span>
					</div>
				</div>
				<!--04-->
                
	</form>  
  </div>
  </div>  
  </div>
 <!--Account-->
 
 <!--ChangePaasword-->
  <div id="ChangePaasword" class="tab-pane fade">
  <div class="row">
  <div class="col-md-6"> 
            <form class="form-horizontal">               
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
					<button type="button" id="changePassForm" class="ui teal submit button">Save Changes</button>
					<span  class="changePassForm" style="visibility:hidden;"><img src="{{ asset(Laralum::publicPath() . '/images/ajax-loader.gif') }}"/></span>
					</div>
				</div>
				<!--04-->
                
	    </form>
  
  </div>
  </div> 
  </div>
<!--ChangePaasword-->
  
<!--UserSubscription-->
 <div id="UserSubscription" class="tab-pane fade">
 <div class="row">
 <div class="col-md-6">
 <table class="table table-bordered">
    <thead>
      <tr class="table_heading">
        <th width="70%">Registered Numbers</th>
       
        <th width="30%">Action</th>
      </tr>
    </thead>
    <tbody>
      <!--tr>
        <td></td>
        <td></td>
      </tr-->
     
    </tbody>
  </table>
<!--04-->
<div class="form-group">
	<div class="res_float_none">
	<button type="submit" class="ui teal submit button">Add New Number</button>
	</div>
</div>
<!--04--> 
 </div>
 </div>
</div>
 <!--UserSubscription-->  
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
@endsection

<style>
.loadinggif {
    background:url('{{ asset(Laralum::publicPath() .'/images/ajax-loader.gif') }}') no-repeat right center;
}
</style>
