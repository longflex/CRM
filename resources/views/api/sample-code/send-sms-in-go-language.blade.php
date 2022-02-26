<?php $nav_golang = 'active'; ?>
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
        <h3>Go Sample Code Send SMS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code:</h4>
        
      <pre class="language-java p-15"><code class=" language-java"><span class="token keyword keyword-package">package</span> main

<span class="token keyword keyword-import">import</span> <span class="token punctuation">(</span>
<span class="token string">"fmt"</span>
<span class="token string">"strings"</span>
<span class="token string">"net/url"</span>
<span class="token string">"net/http"</span>
<span class="token string">"io/ioutil"</span>
<span class="token punctuation">)</span>

func <span class="token function">main</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>

message <span class="token operator">:</span><span class="token operator">=</span> <span class="token string">"Hi hello ho &amp; #42 *&amp;23 w are you...."</span>


urlToPost <span class="token operator">:</span><span class="token operator">=</span> <span class="token string">"https://eventnuts.com/api/sendhttp.php"</span>


form <span class="token operator">:</span><span class="token operator">=</span> url<span class="token punctuation">.</span>Values<span class="token punctuation">{</span><span class="token punctuation">}</span>
form<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span><span class="token string">"authkey"</span><span class="token punctuation">,</span> <span class="token string">"You AuthKey"</span><span class="token punctuation">)</span>
form<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span><span class="token string">"mobiles"</span><span class="token punctuation">,</span> <span class="token string">"9999999999"</span><span class="token punctuation">)</span>
form<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span><span class="token string">"message"</span><span class="token punctuation">,</span> message<span class="token punctuation">)</span>
form<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span><span class="token string">"sender"</span><span class="token punctuation">,</span> <span class="token string">"ALERTS"</span><span class="token punctuation">)</span>
form<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span><span class="token string">"route"</span><span class="token punctuation">,</span> <span class="token string">"4"</span><span class="token punctuation">)</span>

fmt<span class="token punctuation">.</span><span class="token function">Println</span><span class="token punctuation">(</span>form<span class="token punctuation">.</span><span class="token function">Encode</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>

req<span class="token punctuation">,</span> _ <span class="token operator">:</span><span class="token operator">=</span> http<span class="token punctuation">.</span><span class="token function">NewRequest</span><span class="token punctuation">(</span><span class="token string">"POST"</span><span class="token punctuation">,</span> urlToPost<span class="token punctuation">,</span> strings<span class="token punctuation">.</span><span class="token function">NewReader</span><span class="token punctuation">(</span>form<span class="token punctuation">.</span><span class="token function">Encode</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">)</span>

req<span class="token punctuation">.</span>Header<span class="token punctuation">.</span><span class="token function">Add</span><span class="token punctuation">(</span><span class="token string">"Content-Type"</span><span class="token punctuation">,</span> <span class="token string">"application/x-www-form-urlencoded"</span><span class="token punctuation">)</span>

res<span class="token punctuation">,</span> _ <span class="token operator">:</span><span class="token operator">=</span> http<span class="token punctuation">.</span>DefaultClient<span class="token punctuation">.</span><span class="token function">Do</span><span class="token punctuation">(</span>req<span class="token punctuation">)</span>

defer res<span class="token punctuation">.</span>Body<span class="token punctuation">.</span><span class="token function">Close</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
body<span class="token punctuation">,</span> _ <span class="token operator">:</span><span class="token operator">=</span> ioutil<span class="token punctuation">.</span><span class="token function">ReadAll</span><span class="token punctuation">(</span>res<span class="token punctuation">.</span>Body<span class="token punctuation">)</span>

fmt<span class="token punctuation">.</span><span class="token function">Println</span><span class="token punctuation">(</span>res<span class="token punctuation">)</span>
fmt<span class="token punctuation">.</span><span class="token function">Println</span><span class="token punctuation">(</span><span class="token function">string</span><span class="token punctuation">(</span>body<span class="token punctuation">)</span><span class="token punctuation">)</span>

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
