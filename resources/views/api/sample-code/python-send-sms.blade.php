<?php $nav_python = 'active'; ?>
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
        <h3>Python Sample Code Send SMS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code:</h4>
        
        <pre class="language-python p-15"><code class=" language-python"><span class="token keyword keyword-import">import</span> urllib <span class="token comment" spellcheck="true"># Python URL functions</span>
<span class="token keyword keyword-import">import</span> urllib2 <span class="token comment" spellcheck="true"># Python URL functions</span>

authkey <span class="token operator">=</span> <span class="token string">"YourAuthKey"</span> <span class="token comment" spellcheck="true"># Your authentication key.</span>

mobiles <span class="token operator">=</span> <span class="token string">"9999999999"</span> <span class="token comment" spellcheck="true"># Multiple mobiles numbers separated by comma.</span>

message <span class="token operator">=</span> <span class="token string">"Test message"</span> <span class="token comment" spellcheck="true"># Your message to send.</span>

sender <span class="token operator">=</span> <span class="token string">"112233"</span> <span class="token comment" spellcheck="true"># Sender ID,While using route4 sender id should be 6 characters long.</span>

route <span class="token operator">=</span> <span class="token string">"default"</span> <span class="token comment" spellcheck="true"># Define route</span>

<span class="token comment" spellcheck="true"># Prepare you post parameters</span>
values <span class="token operator">=</span> <span class="token punctuation">{</span>
          <span class="token string">'authkey'</span> <span class="token punctuation">:</span> authkey<span class="token punctuation">,</span>
          <span class="token string">'mobiles'</span> <span class="token punctuation">:</span> mobiles<span class="token punctuation">,</span>
          <span class="token string">'message'</span> <span class="token punctuation">:</span> message<span class="token punctuation">,</span>
          <span class="token string">'sender'</span> <span class="token punctuation">:</span> sender<span class="token punctuation">,</span>
          <span class="token string">'route'</span> <span class="token punctuation">:</span> route
          <span class="token punctuation">}</span>


url <span class="token operator">=</span> <span class="token string">"https://eventnuts.com/api/sendhttp.php"</span> <span class="token comment" spellcheck="true"># API URL</span>

postdata <span class="token operator">=</span> urllib<span class="token punctuation">.</span>urlencode<span class="token punctuation">(</span>values<span class="token punctuation">)</span> <span class="token comment" spellcheck="true"># URL encoding the data here.</span>

req <span class="token operator">=</span> urllib2<span class="token punctuation">.</span>Request<span class="token punctuation">(</span>url<span class="token punctuation">,</span> postdata<span class="token punctuation">)</span>

response <span class="token operator">=</span> urllib2<span class="token punctuation">.</span>urlopen<span class="token punctuation">(</span>req<span class="token punctuation">)</span>

output <span class="token operator">=</span> response<span class="token punctuation">.</span>read<span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token comment" spellcheck="true"># Get Response</span>

<span class="token keyword keyword-print">print</span> output <span class="token comment" spellcheck="true"># Print Response</span></code></pre>
        
        </div>
        <!--1section-->
        
        
       
      
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
