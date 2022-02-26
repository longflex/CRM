<?php $nav_php = 'active'; ?>
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
<h3>PHP Sample Code Send SMS</h3>
</div>

<!--1section-->
<div class="form-group">
<h4 class="sub_heading">Code:</h4>

<pre class="language-php p-15"><code class=" language-php"><span class="token php"><span class="token delimiter">&lt;?php</span>

<span class="token comment" spellcheck="true">//Your authentication key</span>
<span class="token variable">$authKey</span> <span class="token operator">=</span> <span class="token string">"YourAuthKey"</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Multiple mobiles numbers separated by comma</span>
<span class="token variable">$mobileNumber</span> <span class="token operator">=</span> <span class="token string">"9999999"</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Sender ID,While using route4 sender id should be 6 characters long.</span>
<span class="token variable">$senderId</span> <span class="token operator">=</span> <span class="token string">"102234"</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Your message to send, Add URL encoding here.</span>
<span class="token variable">$message</span> <span class="token operator">=</span> <span class="token function">urlencode</span><span class="token punctuation">(</span><span class="token string">"Test message"</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Define route </span>
<span class="token variable">$route</span> <span class="token operator">=</span> <span class="token string">"default"</span><span class="token punctuation">;</span>
<span class="token comment" spellcheck="true">//Prepare you post parameters</span>
<span class="token variable">$postData</span> <span class="token operator">=</span> <span class="token keyword keyword-array">array</span><span class="token punctuation">(</span>
<span class="token string">'authkey'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$authKey</span><span class="token punctuation">,</span>
<span class="token string">'mobiles'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$mobileNumber</span><span class="token punctuation">,</span>
<span class="token string">'message'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$message</span><span class="token punctuation">,</span>
<span class="token string">'sender'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$senderId</span><span class="token punctuation">,</span>
<span class="token string">'route'</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$route</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//API URL</span>
<span class="token variable">$url</span><span class="token operator">=</span>"https<span class="token punctuation">:</span><span class="token comment" spellcheck="true">//eventnuts.com/api/sendhttp.php";</span>

<span class="token comment" spellcheck="true">// init the resource</span>
<span class="token variable">$ch</span> <span class="token operator">=</span> <span class="token function">curl_init</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token function">curl_setopt_array</span><span class="token punctuation">(</span><span class="token variable">$ch</span><span class="token punctuation">,</span> <span class="token keyword keyword-array">array</span><span class="token punctuation">(</span>
<span class="token constant">CURLOPT_URL</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$url</span><span class="token punctuation">,</span>
<span class="token constant">CURLOPT_RETURNTRANSFER</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">,</span>
<span class="token constant">CURLOPT_POST</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token boolean">true</span><span class="token punctuation">,</span>
<span class="token constant">CURLOPT_POSTFIELDS</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$postData</span>
<span class="token comment" spellcheck="true">//,CURLOPT_FOLLOWLOCATION =&gt; true</span>
<span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>


<span class="token comment" spellcheck="true">//Ignore SSL certificate verification</span>
<span class="token function">curl_setopt</span><span class="token punctuation">(</span><span class="token variable">$ch</span><span class="token punctuation">,</span> <span class="token constant">CURLOPT_SSL_VERIFYHOST</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token function">curl_setopt</span><span class="token punctuation">(</span><span class="token variable">$ch</span><span class="token punctuation">,</span> <span class="token constant">CURLOPT_SSL_VERIFYPEER</span><span class="token punctuation">,</span> <span class="token number">0</span><span class="token punctuation">)</span><span class="token punctuation">;</span>


<span class="token comment" spellcheck="true">//get response</span>
<span class="token variable">$output</span> <span class="token operator">=</span> <span class="token function">curl_exec</span><span class="token punctuation">(</span><span class="token variable">$ch</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment" spellcheck="true">//Print error if any</span>
<span class="token keyword keyword-if">if</span><span class="token punctuation">(</span><span class="token function">curl_errno</span><span class="token punctuation">(</span><span class="token variable">$ch</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
<span class="token keyword keyword-echo">echo</span> <span class="token string">'error:'</span> <span class="token punctuation">.</span> <span class="token function">curl_error</span><span class="token punctuation">(</span><span class="token variable">$ch</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span>

<span class="token function">curl_close</span><span class="token punctuation">(</span><span class="token variable">$ch</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword keyword-echo">echo</span> <span class="token variable">$output</span><span class="token punctuation">;</span>
<span class="token delimiter">?&gt;</span></span></code></pre>

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
<!-- Logout Modal-->



</div>
@endsection
