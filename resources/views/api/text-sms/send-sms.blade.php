<?php $nav_sendsms = 'active'; ?>
@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      
      <!-- Icon Cards-->
      <div class="row">
        
        
        <div class="col-md-2">
       
        @include('menu.textsmsmenu')
       
        </div>
        
        <div class="col-md-10">
        
        <div class="main-heading">
        <h3>Send SMS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
        <div class="alert alert-danger">
  		<strong>Note:</strong> If you submit large number of request, always use XML API for better performance
		</div>
        </div>
        <!--1section-->
        
        <!--2section-->
        <div class="form-group">
        <h4 class="sub_heading">Sample API</h4>
       
       <div class="code_area">
       <span class="label"> Get</span>
       <code>
                            https://eventnuts.com/api/sendhttp.php?<span class="atv">authkey</span>=YourAuthKey&amp;<span class="atv">mobiles</span>=919999999990,919999999999&amp;<span class="atv">message</span>=message&amp;<span class="atv">sender</span>=ABCDEF&amp;<span class="atv">route</span>=4&amp;<span class="atv">country</span>=0
                        </code>
       </div>
       
      <table class="table table-bordered">
                            <thead class="thead-default">
                                <tr>
                                    <th width="20%">Parameter name</th>
                                    <th width="20%">Data type</th>
                                    <th width="60%">Description</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>authkey <span class="red"> *</span></td>
                                    <td>alphanumeric</td>
                                    <td>Login authentication key (this key is unique for every user)</td>
                                </tr>
                                <tr>
                                    <td>mobiles <span class="red"> *</span></td>
                                    <td>integer</td>
                                    <td>Keep numbers in international format (with country code), multiple numbers should be separated by comma (,)</td>
                                </tr>
                                <tr>
                                    <td>message <span class="red"> *</span></td>
                                    <td>varchar</td>
                                    <td>Message content to send</td>
                                </tr>
                                <tr>
                                    <td>sender <span class="red"> *</span></td>
                                    <td>varchar</td>
                                    <td>Receiver will see this as
                                                                                    <a class="mrT1 " target="_blank" href="http://help.msg91.com/article/40-what-is-a-sender-id-how-to-select-a-sender-id">sender's ID.</a></td>
                                        
                                </tr>
                                <tr>
                                    <td>route <span class="red"> *</span></td>
                                    <td>varchar</td>
                                    <td>If your operator supports multiple routes then give one route name. Eg: <b>route=1</b> for promotional, <b>route=4</b> for transactional SMS. </td>
                                </tr>
                                <tr>
                                    <td>country</td>
                                    <td>numeric</td>
                                    <td>0 for international,1 for USA,
                                                                                    <a class="mrT1 " target="_blank" href="http://help.msg91.com/article/76-how-to-send-sms-worldwide">91 for India.</a></td>
                                                                        </tr>
                                <tr>
                                    <td>flash</td>
                                    <td>integer (0/1)</td>
                                    <td>flash=1 (for flash SMS)</td>
                                </tr>
                                <tr>
                                    <td>unicode</td>
                                    <td>integer (0/1)</td>
                                    <td>unicode=1 (for unicode SMS)</td>
                                </tr>
                                <tr>
                                    <td>schtime</td>
                                    <td>date and time</td>
                                    <td>When you want to schedule the SMS to be sent. Time format could be of your choice you can use Y-m-d h:i:s (2020-01-01 10:10:00) Or Y/m/d h:i:s (2020/01/01 10:10:00) Or you can send unix timestamp (1577873400)</td>
                                </tr>
                                <tr>
                                    <td>afterminutes</td>
                                    <td>integer</td>
                                    <td>Time in minutes after which you want to send sms.</td>
                                </tr>
                                <tr>
                                    <td>response</td>
                                    <td>varchar</td>
                                    <td>By default you will get response in string format but you want to receive in other format (json,xml) then set this parameter.
                                        for example: &amp;<strong>response=json</strong> or &amp;<strong>response=xml</strong></td>
                                </tr>
                                <tr>
                                    <td>campaign</td>
                                    <td>varchar</td>
                                    <td>Campaign name you wish to create.</td>
                                </tr>
                            </tbody>
                        </table>
        </div>
        <!--2section-->
        
        <!--3section-->
        <div class="form-group">
        <h4 class="sub_heading">Sample Output</h4>
        <div class="alert alert-info">5134842646923e183d000075</div>
        
         <div class="alert alert-danger">
         <strong>Note :</strong>
         Output will be request Id which is alphanumeric and contains 24 character like mentioned above. 
         With this request id, delivery report can be viewed. If request not sent successfully, you will get the appropriate error message.
         </div>
        </div>
        <!--3section-->
       
        <!--3section-->
        <div class="form-group">
        <h4 class="sub_heading">Need help in generating API?</h4>
        <p>Fill the details below to generate the desired API</p>
        </div>
        <!--3section-->
        
        <!--4section-->
        
<div class="form-group row">
  <label for="example-text-input" class="col-lg-2 col-form-label">Authentication key <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="text" id="example-text-input">
  </div>
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Mobiles  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Message   <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Sender ID  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Route  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
  
  <div class="col-md-4">(1 -Promotional 4 - Transactional)</div>
  
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Country code  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Flash  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Unicode  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Schedule Time  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
  
  <div class="col-lg-1 padding_5">
    <select class="form-control">
      	<option value="00">HR</option>
        <option value="0">0</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
                               
    </select>
  </div>
  
  <div class="col-lg-1 padding_5">
    <select class="form-control">
    <option value="00">00</option>
    <option value="15">15</option>
    <option value="30">30</option>
    <option value="45">45</option>
    </select>
  </div>
  
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Response  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
</div>

<div class="form-group row">
  <label for="example-search-input" class="col-lg-2 col-form-label">Campaign  <span class="red">*</span></label>
  <div class="col-lg-3">
    <input class="form-control" type="search" id="example-search-input">
  </div>
</div>

<div class="form-group">
  <button type="submit" class="btn btn-api">Generate API</button>
</div>
        
        <!--4section-->
        
        
        
           <!--Encode your API-->
      <div class="row">
      <div class="col-md-12">
      
      <div class="encode-your-api">
      
         <div class="form-group">
        <h4 class="sub_heading" id="encodeyourapi">Encode your API</h4>
        <p><strong>What is URL encoding?</strong></p>
        <p class="mb-8">URL encoding converts characters into a format that can be send through internet We should use URL encode for all GET parameters 
        because POST parameters are automatically encoded.</p>
        
        
         <p><strong>Why URL encoding?</strong></p>
        <p class="mb-8">URLs often contain characters outside the ASCII set, the URL has to be converted into a valid ASCII format. URLs use some characters for special use in defining their syntax, when these characters are not used in their special role inside a URL, they need to be encoded. URL encoding is done to encode user input</p>
        
         <p><strong>Example:</strong></p>
        
        	 <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999&amp;message=<span class="atv">test &amp; new&amp;mobile</span>&amp;sender=ABCDEF&amp;route=4</code>
       </div>
       
       
        <p class="mb-8">In this api the message content "test & new" includes '&' operator,due to which URL encoding is necessary, otherwise it will break 
        your message content and an incomplete message will be sent</p>
        
         <p class="mb-8"><a href="#"><u>Click here to encode</u></a></p>
        
        
         <p><strong>Example:</strong></p>
        
        	 <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999&amp;message=<span class="atv">test &amp; new&amp;mobile</span>&amp;sender=ABCDEF&amp;route=4</code>
       </div>
       
       
        <p class="mb-8">By encoding message content in api,complete message will be sent</p>
        
        
        </div>
      
      </div>
      
      
      
      <!--section-->
      <div class="form-group mb-15" id="SendSMSonMultipleNo">
        <h4 class="sub_heading">Send message on multiple numbers</h4>
       <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999<span class="atv">,</span>919999999999&amp;message=test+%26+new&amp;sender=ABCDEF&amp;route=4</code>
       </div>
       
       <p class="mb-8">To send message on multiple numbers numbers should be comma separated</p>
       
        </div>
      <!--section-->
      
      
      <!--section-->
      <div class="form-group mb-15">
        <h4 class="sub_heading">Send unicode message</h4>
       <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999<span class="atv">,</span>919999999999&amp;message=test+%26+new&amp;sender=ABCDEF&amp;route=4</code>
       </div>
       
       <p class="mb-8">To send unicode message one more parameter will be added i.e unicode and it's value will be set to 1</p>
       
        </div>
      <!--section-->
      
      
      
      <!--section-->
      <div class="form-group mb-15">
        <h4 class="sub_heading">Send flash message</h4>
       <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999<span class="atv">,</span>919999999999&amp;message=test+%26+new&amp;sender=ABCDEF&amp;route=4</code>
       </div>
       
       <p class="mb-8">To send flash message one more parameter will be added i.e flash and it's value will be set to 1</p>
       
        </div>
      <!--section-->
      
      
      
      <!--section-->
      <div class="form-group mb-15">
        <h4 class="sub_heading">JSON response</h4>
       <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999<span class="atv">,</span>919999999999&amp;message=test+%26+new&amp;sender=ABCDEF&amp;route=4</code>
       </div>
       
       <p class="mb-8">To get response in json format one more parameter will be added i.e response and it's value will be set to json</p>
       
        </div>
      <!--section-->
      
      
      
      <!--section-->
      <div class="form-group mb-15" id="SendScheduleSMS">
        <h4 class="sub_heading">Send schedule message</h4>
       <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999<span class="atv">,</span>919999999999&amp;message=test+%26+new&amp;sender=ABCDEF&amp;route=4</code>
       </div>
       
       <p class="mb-8">To schedule message i.e for future , one parameter will be added i.e schtime and it's value should be equal to that date and time,at which message should be sent. Note: for scheduling, date and time are mandatory.</p>
       
        </div>
      <!--section-->
      
      
      
      <!--section-->
      <div class="form-group mb-15" id="ScheduleUnicodeSMS">
        <h4 class="sub_heading">Schedule unicode message</h4>
       <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999<span class="atv">,</span>919999999999&amp;message=test+%26+new&amp;sender=ABCDEF&amp;route=4</code>
       </div>
        </div>
      <!--section-->
      
      
      
         <!--section-->
      <div class="form-group mb-15" id="SendGroupSMS">
        <h4 class="sub_heading">Send message on group</h4>
       <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/sendhttp.php?authkey=YourAuthKey&amp;mobiles=9999999999<span class="atv">,</span>919999999999&amp;message=test+%26+new&amp;sender=ABCDEF&amp;route=4</code>
       </div>
       
        <p class="mb-8">
        While sending message on group that contains numbers saved by user, parameter to be set is group_id and it's value should be equal to the existing group id 
        </p>
        
        <p class="mb-8">
        To view all groups and it's id's <a href="#">Get group id</a>
        </p>
       
        </div>
      <!--section-->
      
      
      
      </div>
      </div>
      <!--Encode your API -->
        
      
        </div>
        
        
        
        
      </div>
      <!-- Area Chart Example-->
      
      
   
      
      
      <!-- Example DataTables Card-->
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

   
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>    </a>
    
   
   
   
  </div>
@endsection

