@extends('layouts.admin.panel') 
@section('breadcrumb')
@endsection
@section('title', trans('laralum.delivery_manager'))




@section('content')





<div class="ui doubling stackable two column grid container">
    

<div class="col-md-12 margin_top_20">
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#SMSPricing">SMS Pricing</a></li>
  <li><a data-toggle="tab" href="#OnlinePayment">Online Payment</a></li>
  <li><a data-toggle="tab" href="#BankDetails">Bank Details</a></li>
  <li><a data-toggle="tab" href="#Default">Default</a></li>
  <li><a data-toggle="tab" href="#Notifications">Notifications</a></li>
  <li><a data-toggle="tab" href="#Domainlogin">Domain login </a></li>
</ul>

<div class="tab-content">

  <!--SMSPricing-->
  <div id="SMSPricing" class="tab-pane fade in active">
  
  <div class="row">
  <div class="col-md-6">
 
 <p>Text SMS pricing for your website</p>
 
 <div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th>Quantity</th>
        <th>Promotional Route</th>
        <th>Transactional Route</th>
        <th>OTP Route</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>5000000</td>
        <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
         <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
           <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
      </tr>
     <tr>
        <td>5000000</td>
        <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
        <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
        <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
      </tr>
      
      <tr>
        <td>5000000</td>
        <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
       <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
       <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
      </tr>
     
      <tr>
        <td>5000000</td>
        <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
      <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
      <th><input type="text" class="inp width_100" id="" name="" value="" placeholder=""></th>
      </tr>
    </tbody>
  </table>
 </div>
 
 
  </div>
  </div>
  
   
  </div>
 <!--SMSPricing-->
 
 <!--OnlinePayment-->
  <div id="OnlinePayment" class="tab-pane fade">
   
   <!--online-payment-->
   <div class="row or-divider">

   <div class="col-md-5">
   
   <h4 class="setting_head">You can choose one of these options to receive payment.</h4>
   
   <div class="alert alert-info">
  To enable any of these option in payment gateway, please fill your resitered IDs.
	</div>
	
	<!--form-->
	<form class="form-horizontal">
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Stripe public key</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="Stripe public key" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Stripe secret key</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="Stripe secret key" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">PayPal</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="PayPal" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">CCAvenue</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="CCAvenue" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">CCAvenue Secret</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="CCAvenue Secret" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Key</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="Key" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">EBS</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="EBS" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">EBS Secret Key</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="EBS Secret Key" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">PayUMoney key</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="PayUMoney key" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">PayUMoney Sait</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="PayUMoney Sait" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Instamojo API Key</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="Instamojo API Key" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Instamojo Auth Token</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="Instamojo Auth Token" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Razorpay key Secret</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="Razorpay key Secret" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Tax</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="Tax" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none"></label>
					<div class="col-sm-8 res_float_none">
						<button type="submit" class="ui teal submit button">Update Details</button>
					</div>
				</div>
				<!--01-->
				
				
				
				
				
	</form>
	<!--form-->
	
   
   </div><!--col-md-5-->
   
   <!--or-divider-->
   <div class="col-md-1 sep">
             <span class="sepText">
                      OR
                  </span>
				  
          </div>
		  
		<div class="col-md-1 res_show">
		<div class="res_or_divider">
		<h2 class="background"><span>OR</span></h2>
		</div>
		</div>
		
   <!--or-divider-->
   <div class="col-md-5">
   
	<h4 class="setting_head">&nbsp;</h4>
   
    <div class="alert alert-info">
	Submit tje button text you want to display and URL where you want to redirect the user.
	</div>
	
	<!--form-->
	<form class="form-horizontal">
				
				<!--01-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">URL</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="URL" id="txtFromDate">
						
					</div>
				</div>
				<!--01-->
				
				<!--02-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none">Button Text</label>
					<div class="col-sm-8 res_float_none">
						<input type="text" class="inp" placeholder="Button Text" id="txtFromDate">
						
					</div>
				</div>
				<!--02-->
				
				<!--03-->
				<div class="form-group">
					<label class="control-label col-sm-4 res_float_none"></label>
					<div class="col-sm-8 res_float_none">
						<button type="submit" class="ui teal submit button">Submit</button>
					</div>
				</div>
				<!--03-->
				
				
	</form>
   
   
   </div>
  
  </div>
   <!--online-payment-->
   
   
  </div>
  <!--OnlinePayment-->
  
   <!--BankDetails-->
  <div id="BankDetails" class="tab-pane fade">
   
   <div class="row">
   
   <div class="col-md-5">
    
    <!--alert-->
    <div class="alert alert-info">
	Enter bank detail can add detail of max.5 banks which will be displayed on your website
	</div>
   <!--alert-->
   
   <form>
   
   <div class="form-group">
   <input type="text" id="" name="" class="inp" placeholder="Bank name" />
   </div>
   
   <div class="form-group row">
   <div class="col-md-6 res_margin_bottom">
   <input type="text" id="" name="" class="inp" placeholder="IFCS Code" />
   </div>
   
   <div class="col-md-6">
   <input type="text" id="" name="" class="inp" placeholder="Account Number" />
   </div>
   
    </div>
   
    <div class="form-group">
   <input type="text" id="" name="" class="inp" placeholder="Account name" />
   </div>
   
    <div class="form-group">
   <textarea class="inp_txt" id="" placeholder="Branch address"></textarea>
   </div>
   
    <div class="form-group">
  <button type="submit" class="ui teal submit button">Add Details</button>
   </div>
  
   </form>
   
   </div><!--col-md-5-->
   
   
   <!--table-->
   <div class="col-md-12">
   <div class="table-responsive">
   
    <table class="table table-bordered">
    <thead>
      <tr class="table_heading">
        <th>Bank</th>
        <th class="text-center">IFSC Code</th>
        <th class="text-center">A/c No.</th>
        <th>A/c Name</th>
        <th>Address</th>
        <th class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>ICICI Bank</td>
        <td align="center">ICICI20145</td>
        <td align="center">14574510145</td>
        <td>Technodreams solutions pvt ltd</td>
         <td>kavuri Hills Branch, Hyderabad</td>
        <td align="center">
        <a href="#" class="ui teal button red">Delete</a>
        </td>
      </tr>
      <tr>
        <td>ICICI Bank</td>
        <td align="center">ICICI20145</td>
        <td align="center">14574510145</td>
        <td>Technodreams solutions pvt ltd</td>
         <td>kavuri Hills Branch, Hyderabad</td>
        <td align="center">
        <a href="#" class="ui teal button red">Delete</a>
        </td>
      

      </tr>
    </tbody>
  </table>
   
   </div>
   </div>
   <!--table-->
   
   
   </div><!--row-->
   
  </div>
 <!--BankDetails-->
 
 <!--Default-->
  <div id="Default" class="tab-pane fade">
  
  
   <!--Default-experiy-->
    <div class="row">
  <div class="col-md-4 your-client-setting">
  
   <!--default-expiry-->
   <div class="panel panel-default">
    <div class="panel-heading">Default Expiry</div>
    <div class="panel-body">
 
  
  <div class="form-inline form-group">
  <input type="text" class="inp width_70" /> &nbsp; Month
  </div>
  
  <div class="alert alert-info margin_b_0">
 For no expiry, leave it blank.
</div>
   
    </div>
  </div>
  <!--default-expiry-->
  
   <!--sign-up-sms-->
   <div class="panel panel-default">
    <div class="panel-heading">Signup SMS</div>
    <div class="panel-body">
  <div class="form-group">
  <input type="text" class="inp" />
  </div>
  
   <div class="form-group">
  <textarea class="inp_txt"></textarea>
  </div>
  
  <div class="alert alert-info margin_b_0">
 For no expiry, leave it blank.
</div>
   
    </div>
  </div>
  <!--sign-up-sms-->
  
  </div>
  
  <div class="col-md-4 your-client-setting">
  
  <!--demo-balance-->
   <div class="panel panel-default">
    <div class="panel-heading">Demo Balance</div>
    <div class="panel-body">
 
  
  <div class="form-inline form-group">
  <input type="text" class="inp width_70" />
  </div>
  
  <div class="alert alert-info margin_b_0">
 It should be in between 1-100.
</div>
   
    </div>
  </div>
  <!--demo-balance-->
  
     <!--sign-up-mail-->
   <div class="panel panel-default">
    <div class="panel-heading">Signup mail</div>
    <div class="panel-body">
  <div class="form-group">
  <input type="text" class="inp" />
  </div>
  
   <div class="form-group">
  <textarea class="inp_txt"></textarea>
  </div>
  
  <div class="alert alert-info margin_b_0">
 For no expiry, leave it blank.
</div>
   
    </div>
  </div>
  <!--sign-up-mail-->
  
  </div>
  
  
  <div class="col-md-8">
   <div class="alert alert-info">
Dynamic variables for: <br />
First name, Usename, Password, Surrent URL are ##fname##, ##username##, ##password##

Msxlenght:<br />
message: <strong>306</strong> char<br />
senderid: <strong>14</strong> char	
</div>
  </div>
  
  <div class="col-md-12">
  <button type="submit" class="ui teal submit button">Update</button>
  </div>
  
   </div><!--row-->
  <!--your-domain-setting-->
  
  
  </div>
  <!--Default-->
  
   <!--Notofications-->
  <div id="Notifications" class="tab-pane fade">
  
  
   <!--signup-->
    <div class="row">
  <div class="col-md-6 your-client-setting">
   <div class="panel panel-default">
    <div class="panel-heading">Signup</div>
    <div class="panel-body">

  
   <div class="checkbox">
    <label>
      <input type="checkbox" id="" name="DomainSetting"> Yes, I want Email notifacation. ( sujay@mesms.in )
    </label>
  </div>
  
   
    </div>
  </div>
  </div>
   </div><!--row-->
  <!--signup-->
  
  
  </div>
 <!--Notofications-->
 
  <!--Domainlogin-->
  <div id="Domainlogin" class="tab-pane fade">
 
  <!--your-client-setting-->
  <div class="row">
  <div class="col-md-6 your-client-setting">
   <div class="panel panel-default">
    <div class="panel-heading">Your client setting</div>
    <div class="panel-body">
  
   <div class="radio">
    <label>
      <input type="radio" id="" name="ClientSetting"> Users can login into any domain.
    </label>
  </div>
  
   <div class="radio">
    <label>
      <input type="radio" name="ClientSetting"> User will not login on any other reseller's website.
    </label>
  </div>
    </div>
  </div>
  </div>
  </div><!--row-->
  <!--your-client-setting-->
  
    <!--your-domain-setting-->
    <div class="row">
  <div class="col-md-6 your-client-setting">
   <div class="panel panel-default">
   <div class="panel-heading">Your domain setting</div>
    <div class="panel-body">
  
  
   <div class="radio">
    <label>
      <input type="radio" id="" name="DomainSetting"> Allow your & Other reseller'd users to login to your white labeled website.
    </label>
  </div>
  
   <div class="radio">
    <label>
      <input type="radio" name="DomainSetting"> Allow only your users to login on your white labeled website.
    </label>
  </div>
    </div>
  </div>
  </div>
   </div><!--row-->
  <!--your-domain-setting-->
  
  <div class="row">
  <div class="col-md-3">
   <button type="submit" class="ui teal submit button">Domain Login</button>
   </div>
  </div>
  
  
  </div>
 <!--Domainlogin-->
 
  
</div>
</div>   
    

    
    

    

    

    
    
</div>
<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection


<style>
.menu-margin 
{
    background: #fff;
}

.page-content 
{
    padding-top: 0 !important;
}

.content-title
{
	padding:0 !important;
}

</style>
