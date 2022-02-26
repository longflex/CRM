<?php $nav_mainerror = 'active'; ?>
@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      
      <!-- Icon Cards-->
      <div class="row">
        
        
        <div class="col-md-2">        </div>
        
        <div class="col-md-10">
        
        <div class="main-heading">
        <h3>Error Codes</h3>
        </div>
        
        <!--1section-->
        <div class="row">
        <div class="form-group col-md-8">
        <h4 class="sub_heading">Missing parameters:</h4>
       
           <table class="table table-bordered">
          <thead class="thead-default">
                                <tr class="">
                                    <th width="20%">Error code</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>101</td>
                                    <td>Missing mobile no.</td>
                                </tr>
                                <tr>
                                    <td>102</td>
                                    <td>Missing message</td>
                                </tr>
                                <tr>
                                    <td>103</td>
                                    <td>Missing sender ID</td>
                                </tr>
                                <tr>
                                    <td>104</td>
                                    <td>Missing username</td>
                                </tr>
                                <tr>
                                    <td>105</td>
                                    <td>Missing password</td>
                                </tr>
                                <tr>
                                    <td>106</td>
                                    <td>Missing Authentication Key</td>
                                </tr>
                                <tr>
                                    <td>107</td>
                                    <td>Missing Route</td>
                                </tr>
                            </tbody>
                        </table>
        </div>
        </div>
        <!--1section-->
        
        <!--1section-->
        <div class="row">
        <div class="form-group col-md-8">
        <h4 class="sub_heading">Invalid parameters:</h4>
       
         <table class="table table-bordered">
          <thead class="thead-default">
                                <tr class="">
                                    <th width="20%">Error code</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>202</td>
                                    <td>Invalid mobile number. You must have entered either less than 10 digits or there is an alphabetic character in the mobile number field in API.</td>
                                </tr>
                                <tr>
                                    <td>203</td>
                                    <td>Invalid sender ID. Your sender ID must be 6 characters, alphabetic.</td>
                                </tr>
                                <tr>
                                    <td>207</td>
                                    <td>Invalid authentication key. Crosscheck your authentication key from your account’s API section.</td>
                                </tr>
                                <tr>
                                    <td>208</td>
                                    <td>IP is blacklisted. We are getting SMS submission requests other than your whitelisted IP list. </td>
                                </tr>
                            </tbody>
                        </table>
        </div>
        </div>
        <!--1section-->
        
         <!--1section-->
        <div class="row">
        <div class="form-group col-md-8">
        <h4 class="sub_heading">Error codes:</h4>
       
         <table class="table table-bordered">
          <thead class="thead-default">
                                <tr class="">
                                    <th width="20%">Error code</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>205</td>
                                    <td>This route is dedicated for high traffic. You should try with minimum 20 mobile numbers in each request</td>
                                </tr>
                                <tr>
                                    <td>209</td>
                                    <td>Default Route for dialplan not found</td>
                                </tr>
                                <tr>
                                    <td>210</td>
                                    <td>Route could not be determined</td>
                                </tr>
                                <tr>
                                    <td>301</td>
                                    <td>Insufficient balance to send SMS</td>
                                </tr>
                                <tr>
                                    <td>302</td>
                                    <td>Expired user account. You need to contact your account manager.</td>
                                </tr>
                                <tr>
                                    <td>303</td>
                                    <td>Banned user account</td>
                                </tr>
                                <tr>
                                    <td>306</td>
                                    <td>This route is currently unavailable. You can send SMS from this route only between 9 AM - 9 PM.</td>
                                </tr>
                                <tr>
                                    <td>307</td>
                                    <td>Incorrect scheduled time</td>
                                </tr>
                                <tr>
                                    <td>308</td>
                                    <td>Campaign name cannot be greater than 32 characters</td>
                                </tr>
                                <tr>
                                    <td>309</td>
                                    <td>Selected group(s) does not belong to you</td>
                                </tr>
                                <tr>
                                    <td>310</td>
                                    <td>SMS is too long. System paused this request automatically.</td>
                                </tr>
                                <tr>
                                    <td>311</td>
                                    <td>Request discarded because same request was generated twice within 10 seconds</td>
                                </tr>
                                <tr>
                                    <td>418</td>
                                    <td>IP is not whitelisted</td>
                                </tr>
                                <tr>
                                    <td>505</td>
                                    <td>Your account is a demo account. Please contact support for details</td>
                                </tr>
                                <tr>
                                    <td>506</td>
                                    <td> Small campaign limit exceeded.
                                        (only 20 campaigns of less than 100 SMS in 24 hours can be sent, exceeding it will show the error)</td>
                                </tr>
                            </tbody>
                        </table>
        </div>
        </div>
        <!--1section-->
        
        
             <!--1section-->
        <div class="row">
        <div class="form-group col-md-8">
        <h4 class="sub_heading">System errors:</h4>
       
        <table class="table table-bordered">
          <thead class="thead-default">
                                <tr class="">
                                    <th width="20%">Error code</th>
                                    <th class="bdrRwit">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>001</td>
                                    <td>Unable to connect database</td>
                                </tr>
                                <tr>
                                    <td>002</td>
                                    <td>Unable to select database</td>
                                </tr>
                                <tr>
                                    <td>601</td>
                                    <td>Internal error.Please contact support for details</td>
                                </tr>
                            </tbody>
                        </table>
        </div>
        </div>
        <!--1section-->
        </div>
      </div>
      <!-- Area Chart Example-->
      
      
      <!-- Example DataTables Card-->
    </div>
    
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>    </a>
    
    

  </div>
@endsection
