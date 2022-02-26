<?php $nav_basicerrorcode = 'active'; ?>
@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      
      <!-- Icon Cards-->
      <div class="row">
        
        
        <div class="col-md-2">
       
       @include('menu.basicmenu') 
        </div>
        
        <div class="col-md-10">
        
        <div class="main-heading">
        <h3>Error Codes</h3>
        </div>
        
        <!--1section-->
        <div class="row">
        <div class="form-group col-md-6">
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
                    <td>104</td>
                    <td>Missing username</td>
              </tr>
              <tr>
                    <td>105</td>
                    <td>Missing password</td>
              </tr>
              </tbody>
        </table>
       
        </div>
        </div>
        <!--1section-->
        
        <!--1section-->
        <div class="row">
        <div class="form-group col-md-6">
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
            <td>207</td>
            <td>Auth key invalid</td>
          </tr>
              </tbody>
		</table>
       
        </div>
        </div>
        <!--1section-->
        
         <!--1section-->
        <div class="row">
        <div class="form-group col-md-6">
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
                    <td>302</td>
                    <td>Expired user account</td>
              </tr>
              <tr>
                    <td>303</td>
                    <td>Banned user account</td>
              </tr>
               
              </tbody>
   	</table>
       
        </div>
        </div>
        <!--1section-->
        
        
             <!--1section-->
        <div class="row">
        <div class="form-group col-md-6">
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
