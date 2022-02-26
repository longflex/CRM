<?php $nav_validation = 'active'; ?>
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
        <h3>Validation</h3>
        </div>
        
        
        <!--2section-->
        <div class="form-group">
        <h4 class="sub_heading">Sample API</h4>
       
       <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/balance.php?<span class="atv">authkey</span>=YourAuthKey&amp;<span class="atv">type</span>=1</code>       </div>
       
       <div class="alert alert-danger">
  		<strong>ERROR RESPONSES:</strong> returns text SMS balance detail if all parameters are correct or appropriate error message		</div>
       
       <table class="table table-bordered">
                           
           <thead class="thead-default">
                            <tr>
                                <th>Parameter name</th>
                                <th>Value</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody><tr>
                            <td>authkey <span class="red"> *</span></td>
                            <td>alphanumeric</td>
                            <td>Login authentication key (this key is unique for every user)</td>
                        </tr>
                    </tbody>
                        </table>
        </div>
        <!--2section-->
        
        <!--3section-->
        <div class="form-group">
        <h4 class="sub_heading">Need help in generating API?</h4>
        <p>Fill the details below to generate the desired API</p>
        </div>
        <!--3section-->
        
        <!--4section-->
        
<div class="form-group row">
  <label for="example-text-input" class="col-md-2 col-form-label">Authentication key <span class="red">*</span></label>
  <div class="col-md-3">
    <input class="form-control" type="text" id="example-text-input">
  </div>
</div>


<div class="form-group">
  <button type="submit" class="btn btn-api">Generate API</button>
</div>
        
        <!--4section-->
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