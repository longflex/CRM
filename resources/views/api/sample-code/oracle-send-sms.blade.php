<?php $nav_oracle = 'active'; ?>
@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      
      <!-- Icon Cards-->
      <div class="row">
        
        
        <div class="col-md-2">
       
       @include('menu.samplecodemenu') 
       
        </div>
        
        <div class="col-md-10">
        
        <div class="main-heading">
        <h3>Oracle Sample Code Send SMS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code for creating package body and procedure::</h4>
        
      <pre class=" language-php p-15"><code class=" language-php">set define off<span class="token punctuation">;</span>

<span class="token constant">CREATE</span> <span class="token keyword keyword-OR">OR</span> <span class="token constant">REPLACE</span> <span class="token constant">PACKAGE</span> sms_api <span class="token constant">IS</span>

  <span class="token keyword keyword-FUNCTION">FUNCTION</span> <span class="token function">send_sms</span><span class="token punctuation">(</span>mobiles  <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    message  <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    sender   <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    route    <span class="token constant">IN</span> <span class="token constant">PLS_INTEGER</span><span class="token punctuation">,</span>
                    country  <span class="token constant">IN</span> <span class="token constant">PLS_INTEGER</span><span class="token punctuation">,</span>
                    flash    <span class="token constant">IN</span> <span class="token constant">PLS_INTEGER</span><span class="token punctuation">,</span>
                    unicode  <span class="token constant">IN</span> <span class="token constant">PLS_INTEGER</span><span class="token punctuation">,</span>
                    schtime  <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    campaign <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    response <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span> <span class="token keyword keyword-DEFAULT">DEFAULT</span> <span class="token string">'text'</span><span class="token punctuation">,</span>
                    authkey  <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span> <span class="token keyword keyword-DEFAULT">DEFAULT</span> <span class="token string">'Your auth key'</span><span class="token punctuation">)</span>
    <span class="token keyword keyword-RETURN">RETURN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">;</span>

<span class="token constant">END</span> sms_api<span class="token punctuation">;</span>
<span class="token operator">/</span>

<span class="token constant">CREATE</span> <span class="token keyword keyword-OR">OR</span> <span class="token constant">REPLACE</span> <span class="token constant">PACKAGE</span> <span class="token constant">BODY</span> sms_api <span class="token constant">IS</span>

  <span class="token keyword keyword-FUNCTION">FUNCTION</span> <span class="token function">get_clobFromUrl</span><span class="token punctuation">(</span>p_url <span class="token constant">VARCHAR2</span><span class="token punctuation">)</span> <span class="token keyword keyword-RETURN">RETURN</span> <span class="token constant">CLOB</span> <span class="token constant">IS</span>
    req      utl_http<span class="token punctuation">.</span>req<span class="token punctuation">;</span>
    resp     utl_http<span class="token punctuation">.</span>resp<span class="token punctuation">;</span>
    val      <span class="token function">VARCHAR2</span><span class="token punctuation">(</span><span class="token number">32767</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    l_result <span class="token constant">CLOB</span><span class="token punctuation">;</span>
  <span class="token constant">BEGIN</span>
    req  <span class="token punctuation">:</span><span class="token operator">=</span> utl_http<span class="token punctuation">.</span><span class="token function">begin_request</span><span class="token punctuation">(</span>p_url<span class="token punctuation">)</span><span class="token punctuation">;</span>
    resp <span class="token punctuation">:</span><span class="token operator">=</span> utl_http<span class="token punctuation">.</span><span class="token function">get_response</span><span class="token punctuation">(</span>req<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token constant">LOOP</span>
      utl_http<span class="token punctuation">.</span><span class="token function">read_line</span><span class="token punctuation">(</span>resp<span class="token punctuation">,</span> val<span class="token punctuation">,</span> <span class="token constant">TRUE</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
      l_result <span class="token punctuation">:</span><span class="token operator">=</span> l_result <span class="token operator">||</span> val<span class="token punctuation">;</span>
    <span class="token constant">END</span> <span class="token constant">LOOP</span><span class="token punctuation">;</span>
    utl_http<span class="token punctuation">.</span><span class="token function">end_response</span><span class="token punctuation">(</span>resp<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword keyword-RETURN">RETURN</span> l_result<span class="token punctuation">;</span>
  <span class="token constant">EXCEPTION</span>
    <span class="token constant">WHEN</span> utl_http<span class="token punctuation">.</span>end_of_body <span class="token constant">THEN</span>
      utl_http<span class="token punctuation">.</span><span class="token function">end_response</span><span class="token punctuation">(</span>resp<span class="token punctuation">)</span><span class="token punctuation">;</span>
      <span class="token keyword keyword-RETURN">RETURN</span> l_result<span class="token punctuation">;</span>
    <span class="token constant">WHEN</span> <span class="token constant">OTHERS</span> <span class="token constant">THEN</span>
      utl_http<span class="token punctuation">.</span><span class="token function">end_response</span><span class="token punctuation">(</span>resp<span class="token punctuation">)</span><span class="token punctuation">;</span>
      <span class="token constant">RAISE</span><span class="token punctuation">;</span>
  <span class="token constant">END</span><span class="token punctuation">;</span>

  <span class="token keyword keyword-FUNCTION">FUNCTION</span> <span class="token function">send_sms</span><span class="token punctuation">(</span>mobiles  <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    message  <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    sender   <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    route    <span class="token constant">IN</span> <span class="token constant">PLS_INTEGER</span><span class="token punctuation">,</span>
                    country  <span class="token constant">IN</span> <span class="token constant">PLS_INTEGER</span><span class="token punctuation">,</span>
                    flash    <span class="token constant">IN</span> <span class="token constant">PLS_INTEGER</span><span class="token punctuation">,</span>
                    unicode  <span class="token constant">IN</span> <span class="token constant">PLS_INTEGER</span><span class="token punctuation">,</span>
                    schtime  <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    campaign <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span><span class="token punctuation">,</span>
                    response <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span> <span class="token keyword keyword-DEFAULT">DEFAULT</span> <span class="token string">'text'</span><span class="token punctuation">,</span>
                    authkey  <span class="token constant">IN</span> <span class="token constant">VARCHAR2</span> <span class="token keyword keyword-DEFAULT">DEFAULT</span> <span class="token string">'Your auth key'</span><span class="token punctuation">)</span>
    <span class="token keyword keyword-RETURN">RETURN</span> <span class="token constant">VARCHAR2</span> <span class="token constant">IS</span>
    l_url    <span class="token function">VARCHAR2</span><span class="token punctuation">(</span><span class="token number">32000</span><span class="token punctuation">)</span> <span class="token punctuation">:</span><span class="token operator">=</span> 'https<span class="token punctuation">:</span><span class="token comment" spellcheck="true">//eventnuts.com/api/sendhttp.php';</span>
    l_result <span class="token function">VARCHAR2</span><span class="token punctuation">(</span><span class="token number">32000</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
  <span class="token constant">BEGIN</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'?authkey='</span> <span class="token operator">||</span> authkey<span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;mobiles='</span> <span class="token operator">||</span> mobiles<span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;message='</span> <span class="token operator">||</span> message<span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;sender='</span> <span class="token operator">||</span> sender<span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;route='</span> <span class="token operator">||</span> route<span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;country='</span> <span class="token operator">||</span> country<span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;flash='</span> <span class="token operator">||</span> flash<span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;unicode='</span> <span class="token operator">||</span> unicode<span class="token punctuation">;</span>
    <span class="token keyword keyword-IF">IF</span> schtime <span class="token constant">IS</span> <span class="token constant">NOT</span> <span class="token keyword keyword-NULL">NULL</span> <span class="token constant">THEN</span>
      l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;schtime='</span> <span class="token operator">||</span> schtime<span class="token punctuation">;</span>
    <span class="token constant">END</span> <span class="token keyword keyword-IF">IF</span><span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;response='</span> <span class="token operator">||</span> response<span class="token punctuation">;</span>
    l_url    <span class="token punctuation">:</span><span class="token operator">=</span> l_url <span class="token operator">||</span> <span class="token string">'&amp;campaign='</span> <span class="token operator">||</span> campaign<span class="token punctuation">;</span>
    l_url <span class="token punctuation">:</span><span class="token operator">=</span> utl_url<span class="token punctuation">.</span><span class="token function">escape</span><span class="token punctuation">(</span>l_url<span class="token punctuation">)</span><span class="token punctuation">;</span>
    l_result <span class="token punctuation">:</span><span class="token operator">=</span> <span class="token function">get_clobFromUrl</span><span class="token punctuation">(</span>l_url<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token keyword keyword-RETURN">RETURN</span> l_result<span class="token punctuation">;</span>
  <span class="token constant">END</span><span class="token punctuation">;</span>

<span class="token constant">END</span> sms_api<span class="token punctuation">;</span>
<span class="token operator">/</span></code></pre>
        
        </div>
        <!--1section-->
        
        
         <!--section-->
        <div class="form-group">
         <h4 class="sub_heading">Run:</h4>
         
         <pre class="language-php p-15"><code class=" language-php"><span class="token constant">SELECT</span> sms_api<span class="token punctuation">.</span><span class="token function">send_sms</span><span class="token punctuation">(</span><span class="token string">'mobiles'</span><span class="token punctuation">,</span><span class="token string">'message'</span><span class="token punctuation">,</span><span class="token string">'senderId'</span><span class="token punctuation">,</span>route<span class="token punctuation">,</span>country<span class="token punctuation">,</span>flash<span class="token punctuation">,</span>unicode<span class="token punctuation">,</span>schtime<span class="token punctuation">,</span><span class="token string">'campaign'</span><span class="token punctuation">,</span><span class="token string">'response'</span><span class="token punctuation">,</span><span class="token string">'Your auth key'</span><span class="token punctuation">)</span> <span class="token constant">FROM</span> dual<span class="token punctuation">;</span></code></pre>
         </div>
       <!--section-->
       
       
          <!--section-->
        <div class="form-group">
         <h4 class="sub_heading">Example :</h4>
         <pre class="language-php p-15"><code class=" language-php"><span class="token constant">SELECT</span> sms_api<span class="token punctuation">.</span><span class="token function">send_sms</span><span class="token punctuation">(</span><span class="token string">'5656565656,8767876786'</span><span class="token punctuation">,</span><span class="token string">'this is test msg'</span><span class="token punctuation">,</span><span class="token string">'tester'</span><span class="token punctuation">,</span><span class="token number">4</span><span class="token punctuation">,</span><span class="token number">91</span><span class="token punctuation">,</span><span class="token number">0</span><span class="token punctuation">,</span><span class="token number">0</span><span class="token punctuation">,</span><span class="token keyword keyword-NULL">NULL</span><span class="token punctuation">,</span><span class="token string">'test'</span><span class="token punctuation">,</span><span class="token string">'text'</span><span class="token punctuation">,</span><span class="token string">'Your auth key'</span><span class="token punctuation">)</span> <span class="token constant">FROM</span> dual<span class="token punctuation">;</span></code></pre>
         
         
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
                                    <td>mobiles <span class="red"> *</span></td>
                                    <td>integer</td>
                                    <td>Multiple numbers should be separated by comma (,) Ex : '5656565656,8767876786'</td>
                                </tr>
                                <tr>
                                    <td>message <span class="red"> *</span></td>
                                    <td>varchar</td>
                                    <td>Message content to send</td>
                                </tr>
                                <tr>
                                    <td>senderId <span class="red"> *</span></td>
                                    <td>varchar</td>
                                    <td>Receiver will see this as
                                    <a class="mrT1 " target="_blank" href="#">sender's ID.</a></td>
                                        
                                </tr>
                                <tr>
                                    <td>route <span class="red"> *</span></td>
                                    <td>varchar</td>
                                    <td>If your operator supports multiple routes then give one route name. Eg: route=1 for promotional, route=4 for transactional SMS. </td>
                                </tr>
                                <tr>
                                    <td>country</td>
                                    <td>numeric</td>
                                    <td>0 for international,1 for USA, 
                                    <a class="mrT1 " target="_blank" href="#">91 for India.</a></td>
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
                                    <td>When you want to schedule the SMS to be sent. Time format will be Y-m-d h:i:s</td>
                                </tr>
                                <tr>
                                    <td>campaign</td>
                                    <td>varchar</td>
                                    <td>Campaign name you wish to create.</td>
                                </tr>
                                <tr>
                                    <td>response</td>
                                    <td>varchar</td>
                                    <td>By default you will get response in string format but you want to receive in other format (json,xml) then set this parameter.
                                        for example: &amp;<strong>response=json</strong> or &amp;<strong>response=xml</strong></td>
                                </tr>
                                 <tr>
                                    <td>authkey <span class="red"> *</span></td>
                                    <td>alphanumeric</td>
                                    <td>Login authentication key (this key is unique for every user)</td>
                                </tr>
                            </tbody>
                        </table>
         
         </div>
       <!--section-->
      
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
