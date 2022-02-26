<?php $nav_ios = 'active'; ?>
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
        <h3>HTTP SEND SMS API Using iOS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code:</h4>
        
     <pre class=" language-java p-15"><code class=" language-java"><span class="token comment" spellcheck="true">//Create Objects</span>
NSMutableData <span class="token operator">*</span> responseData<span class="token punctuation">;</span>
NSURLConnection <span class="token operator">*</span> connection<span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">// In your viewDidLoad method add this lines</span>
<span class="token operator">-</span><span class="token punctuation">(</span><span class="token keyword keyword-void">void</span><span class="token punctuation">)</span>viewDidLoad
<span class="token punctuation">{</span>
    <span class="token punctuation">[</span><span class="token keyword keyword-super">super</span> viewDidLoad<span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Your authentication key</span>
    NSString <span class="token operator">*</span> authkey <span class="token operator">=</span> @<span class="token string">"YourAuthKey"</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Multiple mobiles numbers separated by comma</span>
    NSString <span class="token operator">*</span> mobiles <span class="token operator">=</span> @<span class="token string">"9999999"</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Sender ID,While using route4 sender id should be 6 characters long.</span>
    NSString <span class="token operator">*</span> senderId <span class="token operator">=</span> @<span class="token string">"102234"</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//Your message to send, Add URL encoding here.</span>
    NSString <span class="token operator">*</span> message <span class="token operator">=</span> @<span class="token string">"Test message"</span><span class="token punctuation">;</span>
    <span class="token comment" spellcheck="true">//define route</span>
    NSString <span class="token operator">*</span> route <span class="token operator">=</span> @<span class="token string">"default"</span><span class="token punctuation">;</span>

    <span class="token comment" spellcheck="true">// Prepare your url to send sms with this parameters.</span>
    NSString <span class="token operator">*</span> url <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">[</span>NSString stringWithFormat<span class="token operator">:</span>@<span class="token string">"https://eventnuts.com/api/sendhttp.php?authkey=%@&amp;mobiles=%@&amp;message=%@&amp;sender=%@&amp;route=%@"</span><span class="token punctuation">,</span> authkey<span class="token punctuation">,</span> mobiles<span class="token punctuation">,</span> message<span class="token punctuation">,</span> senderId<span class="token punctuation">,</span> route<span class="token punctuation">]</span> stringByAddingPercentEscapesUsingEncoding<span class="token operator">:</span>NSUTF8StringEncoding<span class="token punctuation">]</span><span class="token punctuation">;</span>
    NSURLRequest <span class="token operator">*</span> request <span class="token operator">=</span> <span class="token punctuation">[</span>NSURLRequest requestWithURL<span class="token operator">:</span><span class="token punctuation">[</span>NSURL URLWithString<span class="token operator">:</span>url<span class="token punctuation">]</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
    connection <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">[</span>NSURLConnection alloc<span class="token punctuation">]</span> initWithRequest<span class="token operator">:</span>request delegate<span class="token operator">:</span>self<span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>

<span class="token comment" spellcheck="true">// implement URLConnection Delegate Methods as follow</span>
<span class="token operator">-</span><span class="token punctuation">(</span><span class="token keyword keyword-void">void</span><span class="token punctuation">)</span> connection<span class="token operator">:</span><span class="token punctuation">(</span>NSURLConnection <span class="token operator">*</span><span class="token punctuation">)</span>connection didReceiveResponse<span class="token operator">:</span><span class="token punctuation">(</span>NSURLResponse <span class="token operator">*</span><span class="token punctuation">)</span>response
<span class="token punctuation">{</span>
	<span class="token comment" spellcheck="true">//Get response data</span>
    responseData <span class="token operator">=</span> <span class="token punctuation">[</span>NSMutableData data<span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>

<span class="token operator">-</span><span class="token punctuation">(</span><span class="token keyword keyword-void">void</span><span class="token punctuation">)</span> connection<span class="token operator">:</span><span class="token punctuation">(</span>NSURLConnection <span class="token operator">*</span><span class="token punctuation">)</span>connection didReceiveData<span class="token operator">:</span><span class="token punctuation">(</span>NSData <span class="token operator">*</span><span class="token punctuation">)</span>data
<span class="token punctuation">{</span>
	<span class="token punctuation">[</span>responseData appendData<span class="token operator">:</span>data<span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>

<span class="token operator">-</span><span class="token punctuation">(</span><span class="token keyword keyword-void">void</span><span class="token punctuation">)</span> connection<span class="token operator">:</span><span class="token punctuation">(</span>NSURLConnection <span class="token operator">*</span><span class="token punctuation">)</span>connection didFailWithError<span class="token operator">:</span><span class="token punctuation">(</span>NSError <span class="token operator">*</span><span class="token punctuation">)</span>error
<span class="token punctuation">{</span>
    UIAlertView <span class="token operator">*</span>alert <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">[</span>UIAlertView alloc<span class="token punctuation">]</span> initWithTitle<span class="token operator">:</span>@<span class="token string">"Error"</span> message<span class="token operator">:</span>error<span class="token punctuation">.</span>localizedDescription delegate<span class="token operator">:</span>self cancelButtonTitle<span class="token operator">:</span>nil otherButtonTitles<span class="token operator">:</span>@<span class="token string">"OK"</span><span class="token punctuation">,</span> nil<span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">[</span>alert show<span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>

<span class="token operator">-</span><span class="token punctuation">(</span><span class="token keyword keyword-void">void</span><span class="token punctuation">)</span> connectionDidFinishLoading<span class="token operator">:</span><span class="token punctuation">(</span>NSURLConnection <span class="token operator">*</span><span class="token punctuation">)</span>connection
<span class="token punctuation">{</span>
    <span class="token comment" spellcheck="true">// Get response data in NSString.</span>
    NSString <span class="token operator">*</span> responceStr <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token punctuation">[</span>NSString alloc<span class="token punctuation">]</span> initWithData<span class="token operator">:</span>responseData encoding<span class="token operator">:</span>NSUTF8StringEncoding<span class="token punctuation">]</span><span class="token punctuation">;</span>
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
