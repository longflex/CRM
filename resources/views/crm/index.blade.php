@extends('layouts.ivr.panel')
@section('breadcrumb')
@endsection
@section('title', trans('laralum.ivr_title'))
@section('content')
<div class="ui doubling stackable two column grid container">
   <div class="ivr_page_content">
  <div class="col-md-12">
  
  <h2>Build With Programmable Voice</h2>
  
  <p>Choose a use case to build a production ready solution.</p>
  
  
  <div class="col-md-4 padding_none select_option_ivr">
 <select class="inp select-style" onchange="show()" id="mySelect" name="mySelect">
	 <option value="IVR">IVR</option>
	   	</select>
  </div>
  
  
  <!--ivr-image-area-->
  <div class="col-md-12 padding_none">
  <div class="ivr_image_area">
   <img src="{{ asset(Laralum::publicPath() .'/images/ivr.jpg') }}"  class="img-responsive" />
 
  </div>
  </div>
 <!--ivr-image-area-->

<!--Useful Resources-->  
<div class="col-md-12 padding_none ivr_useful_resources">
<h3>Useful Resources</h3>

Read about EnML, the EventNuts Markup Language. <br /><br />
Helper Library: in your language of choice. <br /><br />
EnMLbin: a place to host and test EnML.<br /><br />
Developer Center: a tracking system of any errors your app produces. <br /><br />
Upgrade your account to remove the "Trial" message from your phone number.
  </div>
 <!--Useful Resources-->
 
 <!--get-number-->
 <div class="col-md-12 padding_none">
 <div class="ivr-boxes">
 <h3>1. Get a Number</h3>
 <p>In order to make calls or send messages through the EventNuts API, you need to get a EventNuts phone number.</p> <br />
 <button class="ui teal submit button">Get your first number</button>
 </div>
 </div>
 <!--get-number-->
 
  <!--Confirm Your Programming Language-->
 <div class="col-md-12 padding_none">
 <div class="ivr-boxes">
 <h3>2. Confirm Your Programming Language</h3>
 
 <div class="row">
 <div class="col-md-4">
 <select class="inp select-style" onchange="show()" id="mySelect" name="mySelect">
 <option value="PHP">PHP</option>
 <option value="C#">C#</option>
 <option value="JAVA">JAVA</option>
 <option value="Node.js">Node.js</option>
 <option value="Python">Python</option>
 <option value="Ruby">Ruby</option>
 </select>
 </div>
 </div> <br />
 
 <button class="ui teal submit button">Confirm</button> <br /><br />
 
 <p>Not a developer? You might want to check out these EventNuts-powered contact center and help desk providers. <a href="#">Learn more</a></p>
 
 </div>
 </div>
 <!--Confirm Your Programming Language-->
 
 
  <!--Allow a customer-->
 <div class="col-md-12 padding_none">
 <div class="ivr-boxes">
 <h3>3. Allow a customer to call your EventNuts Phone Number</h3> <br />
 <p>A. Use this simple Quick Start guide  to set up your EventNuts phone number to receive calls. You'll learn some basic EnML  (that's the EventNuts Markup Language) like <Say> and <Record> which will come in handy later.</p> 
 
  <p>Check any errors with the debugger  and see example EnML using the API Explorer.</p>
 
 </div>
 </div>
 <!--Allow a customer-->
 
 
   <!--Write your phone-->
 <div class="col-md-12 padding_none">
 <div class="ivr-boxes">
 <h3>4. Write your phone tree in EnML</h3> 
 <p>The most important thing to understand here is that every time your customer presses a button on their dial pad, your application will need to serve up a new EnML document with instructions to EventNuts on how to handle that 'action'.</p> <br />
 
  <p>A. Write a phone tree with EnML. Start the tutorial</p>
  
  <p>B. Learn how to screen callers and allow them to leave a voicemail if an agent is busy. Learn more</p>
 
 </div>
 </div>
 <!--Write your phone-->
 
    <!--Pro Tip #1: Connect a caller to an agent-->
 <div class="col-md-12 padding_none">
 <div class="ivr-boxes">
 <h3>Pro Tip #1: Connect a caller to an agent</h3> 
 <p>There are several options for how to handle this scenario:</p> <br />
 
  <p>A. < Dial >  someone directly. This is probably best if you have just one main business line or are using the IVR to direct callers to a particular department.</p>
  
  <p>B. Add the call to a queue using < Enqueue >.</p>
 
 </div>
 </div>
 <!--Pro Tip #1: Connect a caller to an agent-->
 
     <!--Pro Tip #2: Considerations for production scale-->
 <div class="col-md-12 padding_none">
 <div class="ivr-boxes">
 <h3>Pro Tip #1: Connect a caller to an agent</h3> 
 <br />
 
  <p>A. EventNuts can pass metadata about the caller and the call to an agent to add context to their conversation. Use the EventNuts REST API  to pass data to your own system.</p>
  
  <p>B. Post-call speech analytics work far better if each channel of the call is recorded separately. Enable dual-channel recording using the RecordingChannels  parameter and choose a speech analytics technology from the marketplace.</p>
  
  <p>EventNuts's Task Router  makes it easy to build advanced contact center routing and can hook into any existing contact center solution.</p>
 
 </div>
 </div>
 <!--Pro Tip #2: Considerations for production scale-->
 
  
  </div>
  </div>
  
    </div>
  
 


<style>
.menu-margin {
    background: #fff;
}

.page-content {
    padding-top: 0 !important;
}
</style>
 
@endsection
