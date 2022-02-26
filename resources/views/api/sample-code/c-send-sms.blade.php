<?php $nav_csharp = 'active'; ?>
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
        <h3>HTTP Send SMS API using C#</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code:</h4>
        
      <pre class=" language-c p-15"><code class=" language-c"><span class="token comment" spellcheck="true">//Your authentication key</span>
string authKey <span class="token operator">=</span> <span class="token string">"YourAuthKey"</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">//Multiple mobiles numbers separated by comma</span>
string mobileNumber <span class="token operator">=</span> <span class="token string">"9999999"</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">//Sender ID,While using route4 sender id should be 6 characters long.</span>
string senderId <span class="token operator">=</span> <span class="token string">"102234"</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">//Your message to send, Add URL encoding here.</span>
string message <span class="token operator">=</span> HttpUtility<span class="token punctuation">.</span><span class="token function">UrlEncode</span><span class="token punctuation">(</span><span class="token string">"Test message"</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Prepare you post parameters</span>
StringBuilder sbPostData <span class="token operator">=</span> new <span class="token function">StringBuilder</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
sbPostData<span class="token punctuation">.</span><span class="token function">AppendFormat</span><span class="token punctuation">(</span><span class="token string">"authkey={0}"</span><span class="token punctuation">,</span> authKey<span class="token punctuation">)</span><span class="token punctuation">;</span>
sbPostData<span class="token punctuation">.</span><span class="token function">AppendFormat</span><span class="token punctuation">(</span><span class="token string">"&amp;mobiles={0}"</span><span class="token punctuation">,</span> mobileNumber<span class="token punctuation">)</span><span class="token punctuation">;</span>
sbPostData<span class="token punctuation">.</span><span class="token function">AppendFormat</span><span class="token punctuation">(</span><span class="token string">"&amp;message={0}"</span><span class="token punctuation">,</span> message<span class="token punctuation">)</span><span class="token punctuation">;</span>
sbPostData<span class="token punctuation">.</span><span class="token function">AppendFormat</span><span class="token punctuation">(</span><span class="token string">"&amp;sender={0}"</span><span class="token punctuation">,</span> senderId<span class="token punctuation">)</span><span class="token punctuation">;</span>
sbPostData<span class="token punctuation">.</span><span class="token function">AppendFormat</span><span class="token punctuation">(</span><span class="token string">"&amp;route={0}"</span><span class="token punctuation">,</span> <span class="token string">"default"</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

try
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">//Call Send SMS API</span>
    string sendSMSUri <span class="token operator">=</span> <span class="token string">"https://eventnuts.com/api/sendhttp.php"</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Create HTTPWebrequest</span>
    HttpWebRequest httpWReq <span class="token operator">=</span> <span class="token punctuation">(</span>HttpWebRequest<span class="token punctuation">)</span>WebRequest<span class="token punctuation">.</span><span class="token function">Create</span><span class="token punctuation">(</span>sendSMSUri<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Prepare and Add URL Encoded data</span>
    UTF8Encoding encoding <span class="token operator">=</span> new <span class="token function">UTF8Encoding</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    byte<span class="token punctuation">[</span><span class="token punctuation">]</span> data <span class="token operator">=</span> encoding<span class="token punctuation">.</span><span class="token function">GetBytes</span><span class="token punctuation">(</span>sbPostData<span class="token punctuation">.</span><span class="token function">ToString</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Specify post method</span>
    httpWReq<span class="token punctuation">.</span>Method <span class="token operator">=</span> <span class="token string">"POST"</span><span class="token punctuation">;</span>
    httpWReq<span class="token punctuation">.</span>ContentType <span class="token operator">=</span> <span class="token string">"application/x-www-form-urlencoded"</span><span class="token punctuation">;</span>
    httpWReq<span class="token punctuation">.</span>ContentLength <span class="token operator">=</span> data<span class="token punctuation">.</span>Length<span class="token punctuation">;</span>
    using <span class="token punctuation">(</span>Stream stream <span class="token operator">=</span> httpWReq<span class="token punctuation">.</span><span class="token function">GetRequestStream</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
    	stream<span class="token punctuation">.</span><span class="token function">Write</span><span class="token punctuation">(</span>data<span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">,</span> data<span class="token punctuation">.</span>Length<span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
    <span class="token comment" spellcheck="true">//Get the response</span>
    HttpWebResponse response <span class="token operator">=</span> <span class="token punctuation">(</span>HttpWebResponse<span class="token punctuation">)</span>httpWReq<span class="token punctuation">.</span><span class="token function">GetResponse</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    StreamReader reader <span class="token operator">=</span> new <span class="token function">StreamReader</span><span class="token punctuation">(</span>response<span class="token punctuation">.</span><span class="token function">GetResponseStream</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    string responseString <span class="token operator">=</span> reader<span class="token punctuation">.</span><span class="token function">ReadToEnd</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">//Close the response</span>
    reader<span class="token punctuation">.</span><span class="token function">Close</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    response<span class="token punctuation">.</span><span class="token function">Close</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
catch <span class="token punctuation">(</span>SystemException ex<span class="token punctuation">)</span>
<span class="token punctuation">{</span>
	MessageBox<span class="token punctuation">.</span><span class="token function">Show</span><span class="token punctuation">(</span>ex<span class="token punctuation">.</span>Message<span class="token punctuation">.</span><span class="token function">ToString</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span></code></pre>
        
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