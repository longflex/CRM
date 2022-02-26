<?php $nav_window8 = 'active'; ?>
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
        <h3>HTTP Send SMS API Using Windows Phone 8 - C#</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code:</h4>
        
     <pre class=" language-c p-15"><code class=" language-c">try
<span class="token punctuation">{</span>
    string strResult <span class="token operator">=</span> <span class="token string">""</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Prepare you post parameters</span>
    var postValues <span class="token operator">=</span> new List<span class="token operator">&lt;</span>KeyValuePair<span class="token operator">&lt;</span>string<span class="token punctuation">,</span> string<span class="token operator">&gt;&gt;</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Your authentication key</span>
    postValues<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span>new KeyValuePair<span class="token operator">&lt;</span>string<span class="token punctuation">,</span> string<span class="token operator">&gt;</span><span class="token punctuation">(</span><span class="token string">"authkey"</span><span class="token punctuation">,</span> <span class="token string">"YourAuthKey"</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Multiple mobiles numbers separated by comma</span>
    postValues<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span>new KeyValuePair<span class="token operator">&lt;</span>string<span class="token punctuation">,</span> string<span class="token operator">&gt;</span><span class="token punctuation">(</span><span class="token string">"mobiles"</span><span class="token punctuation">,</span> <span class="token string">"9999999"</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Sender ID,While using route4 sender id should be 6 characters long.</span>
    postValues<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span>new KeyValuePair<span class="token operator">&lt;</span>string<span class="token punctuation">,</span> string<span class="token operator">&gt;</span><span class="token punctuation">(</span><span class="token string">"sender"</span><span class="token punctuation">,</span> <span class="token string">"102234"</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Your message to send, Add URL encoding here.</span>
    string message <span class="token operator">=</span> HttpUtility<span class="token punctuation">.</span><span class="token function">UrlEncode</span><span class="token punctuation">(</span><span class="token string">"Test message"</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    postValues<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span>new KeyValuePair<span class="token operator">&lt;</span>string<span class="token punctuation">,</span> string<span class="token operator">&gt;</span><span class="token punctuation">(</span><span class="token string">"message"</span><span class="token punctuation">,</span> message<span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Select route</span>
    postValues<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span>new KeyValuePair<span class="token operator">&lt;</span>string<span class="token punctuation">,</span> string<span class="token operator">&gt;</span><span class="token punctuation">(</span><span class="token string">"route"</span><span class="token punctuation">,</span><span class="token string">"default"</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">//Prepare API to send SMS</span>
    Uri requesturl <span class="token operator">=</span> new <span class="token function">Uri</span><span class="token punctuation">(</span><span class="token string">"https://eventnuts.com/api/sendhttp.php"</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//create httpclient request</span>
    var httpClient <span class="token operator">=</span> new <span class="token function">HttpClient</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    var httpContent <span class="token operator">=</span> new <span class="token function">HttpRequestMessage</span><span class="token punctuation">(</span>HttpMethod<span class="token punctuation">.</span>Post<span class="token punctuation">,</span> requesturl<span class="token punctuation">)</span><span class="token punctuation">;</span>
    httpContent<span class="token punctuation">.</span>Headers<span class="token punctuation">.</span>ExpectContinue <span class="token operator">=</span> false<span class="token punctuation">;</span>
    httpContent<span class="token punctuation">.</span>Content <span class="token operator">=</span> new <span class="token function">FormUrlEncodedContent</span><span class="token punctuation">(</span>postValues<span class="token punctuation">)</span><span class="token punctuation">;</span>
    HttpResponseMessage response <span class="token operator">=</span> await httpClient<span class="token punctuation">.</span><span class="token function">SendAsync</span><span class="token punctuation">(</span>httpContent<span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">//Get response</span>
    var result <span class="token operator">=</span> await response<span class="token punctuation">.</span>Content<span class="token punctuation">.</span><span class="token function">ReadAsStringAsync</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    strResult <span class="token operator">=</span> result<span class="token punctuation">.</span><span class="token function">ToString</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    response<span class="token punctuation">.</span><span class="token function">Dispose</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    httpClient<span class="token punctuation">.</span><span class="token function">Dispose</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    httpContent<span class="token punctuation">.</span><span class="token function">Dispose</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>
catch <span class="token punctuation">(</span>Exception ex<span class="token punctuation">)</span>
<span class="token punctuation">{</span>
	throw ex<span class="token punctuation">;</span>
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