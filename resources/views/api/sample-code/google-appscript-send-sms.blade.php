<?php $nav_appscript = 'active'; ?>
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
        <h3>Google Appscript Sample Code Send SMS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code:</h4>
        
      <pre class=" language-php p-15"><code class=" language-php"><span class="token comment" spellcheck="true">//write this code in your .gs file</span>
<span class="token comment" spellcheck="true">//Your authentication key</span>
<span class="token keyword keyword-var">var</span> authKey <span class="token operator">=</span> <span class="token string">"YourAuthKey"</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Multiple mobiles numbers separated by comma</span>
<span class="token keyword keyword-var">var</span> mobileNumber <span class="token operator">=</span> <span class="token string">"9999999"</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Sender ID,While using route4 sender id should be 6 characters long.</span>
<span class="token keyword keyword-var">var</span> senderId <span class="token operator">=</span> <span class="token string">"102234"</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Your message to send, Add URL encoding here.</span>
<span class="token keyword keyword-var">var</span> message <span class="token operator">=</span> <span class="token string">"Test message"</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Define route</span>
<span class="token keyword keyword-var">var</span> route <span class="token operator">=</span> <span class="token string">"default"</span><span class="token punctuation">;</span>


<span class="token keyword keyword-var">var</span> payload <span class="token operator">=</span> <span class="token punctuation">{</span>
        <span class="token string">"authkey"</span><span class="token punctuation">:</span> authKey<span class="token punctuation">,</span>
        <span class="token string">'mobiles'</span> <span class="token punctuation">:</span> mobileNumber<span class="token punctuation">,</span>
        <span class="token string">'message'</span> <span class="token punctuation">:</span> message<span class="token punctuation">,</span>
        <span class="token string">'sender'</span> <span class="token punctuation">:</span> senderId<span class="token punctuation">,</span>
        <span class="token string">'route'</span> <span class="token punctuation">:</span> route
<span class="token punctuation">}</span><span class="token punctuation">;</span>

<span class="token keyword keyword-var">var</span> options <span class="token operator">=</span> <span class="token punctuation">{</span>
    <span class="token string">"method"</span><span class="token punctuation">:</span> <span class="token string">"post"</span><span class="token punctuation">,</span>
    <span class="token string">"payload"</span><span class="token punctuation">:</span> payload
<span class="token punctuation">}</span><span class="token punctuation">;</span>

<span class="token keyword keyword-var">var</span> res <span class="token operator">=</span> UrlFetchApp<span class="token punctuation">.</span><span class="token function">fetch</span><span class="token punctuation">(</span>"https<span class="token punctuation">:</span><span class="token comment" spellcheck="true">//eventnuts.com/api/sendhttp.php?", options);</span>

<span class="token keyword keyword-var">var</span> resAsTxt <span class="token operator">=</span> <span class="token string">''</span> <span class="token operator">+</span> res <span class="token operator">+</span> <span class="token string">''</span><span class="token punctuation">;</span>

Logger<span class="token punctuation">.</span><span class="token function">log</span><span class="token punctuation">(</span>resAsTxt<span class="token punctuation">)</span></code></pre>
        
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
    <!-- Logout Modal-->
   

  </div>
@endsection
