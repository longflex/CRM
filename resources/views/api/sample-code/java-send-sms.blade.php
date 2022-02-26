<?php $nav_java = 'active'; ?>
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
        <h3>Java Sample Code Send SMS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code:</h4>
        
      <pre class=" language-java"><code class=" language-java"><span class="token keyword keyword-import">import</span> java<span class="token punctuation">.</span>io<span class="token punctuation">.</span>*<span class="token punctuation">;</span>
<span class="token keyword keyword-import">import</span> java<span class="token punctuation">.</span>net<span class="token punctuation">.</span>URL<span class="token punctuation">;</span>
<span class="token keyword keyword-import">import</span> java<span class="token punctuation">.</span>net<span class="token punctuation">.</span>URLConnection<span class="token punctuation">;</span>
<span class="token keyword keyword-import">import</span> java<span class="token punctuation">.</span>net<span class="token punctuation">.</span>URLEncoder<span class="token punctuation">;</span>


<span class="token keyword keyword-public">public</span> <span class="token keyword keyword-class">class</span> <span class="token class-name">SendSms</span><span class="token punctuation">{</span>

        <span class="token keyword keyword-public">public</span> <span class="token keyword keyword-static">static</span> <span class="token keyword keyword-void">void</span> <span class="token function">main</span><span class="token punctuation">(</span>String<span class="token punctuation">[</span><span class="token punctuation">]</span> args<span class="token punctuation">)</span>
    	<span class="token punctuation">{</span>
            <span class="token comment" spellcheck="true">//Your authentication key</span>
            String authkey <span class="token operator">=</span> <span class="token string">"YourAuthKey"</span><span class="token punctuation">;</span>
            <span class="token comment" spellcheck="true">//Multiple mobiles numbers separated by comma</span>
            String mobiles <span class="token operator">=</span> <span class="token string">"9999999"</span><span class="token punctuation">;</span>
            <span class="token comment" spellcheck="true">//Sender ID,While using route4 sender id should be 6 characters long.</span>
            String senderId <span class="token operator">=</span> <span class="token string">"102234"</span><span class="token punctuation">;</span>
            <span class="token comment" spellcheck="true">//Your message to send, Add URL encoding here.</span>
            String message <span class="token operator">=</span> <span class="token string">"Test message"</span><span class="token punctuation">;</span>
            <span class="token comment" spellcheck="true">//define route</span>
            String route<span class="token operator">=</span><span class="token string">"default"</span><span class="token punctuation">;</span>

            <span class="token comment" spellcheck="true">//Prepare Url</span>
            URLConnection myURLConnection<span class="token operator">=</span>null<span class="token punctuation">;</span>
            URL myURL<span class="token operator">=</span>null<span class="token punctuation">;</span>
            BufferedReader reader<span class="token operator">=</span>null<span class="token punctuation">;</span>

            <span class="token comment" spellcheck="true">//encoding message</span>
            String encoded_message<span class="token operator">=</span>URLEncoder<span class="token punctuation">.</span><span class="token function">encode</span><span class="token punctuation">(</span>message<span class="token punctuation">)</span><span class="token punctuation">;</span>

            <span class="token comment" spellcheck="true">//Send SMS API</span>
            String mainUrl<span class="token operator">=</span><span class="token string">"https://eventnuts.com/api/sendhttp.php?"</span><span class="token punctuation">;</span>

            <span class="token comment" spellcheck="true">//Prepare parameter string</span>
            StringBuilder sbPostData<span class="token operator">=</span> <span class="token keyword keyword-new">new</span> <span class="token class-name">StringBuilder</span><span class="token punctuation">(</span>mainUrl<span class="token punctuation">)</span><span class="token punctuation">;</span>
            sbPostData<span class="token punctuation">.</span><span class="token function">append</span><span class="token punctuation">(</span><span class="token string">"authkey="</span><span class="token operator">+</span>authkey<span class="token punctuation">)</span><span class="token punctuation">;</span>
            sbPostData<span class="token punctuation">.</span><span class="token function">append</span><span class="token punctuation">(</span><span class="token string">"&amp;mobiles="</span><span class="token operator">+</span>mobiles<span class="token punctuation">)</span><span class="token punctuation">;</span>
            sbPostData<span class="token punctuation">.</span><span class="token function">append</span><span class="token punctuation">(</span><span class="token string">"&amp;message="</span><span class="token operator">+</span>encoded_message<span class="token punctuation">)</span><span class="token punctuation">;</span>
            sbPostData<span class="token punctuation">.</span><span class="token function">append</span><span class="token punctuation">(</span><span class="token string">"&amp;route="</span><span class="token operator">+</span>route<span class="token punctuation">)</span><span class="token punctuation">;</span>
            sbPostData<span class="token punctuation">.</span><span class="token function">append</span><span class="token punctuation">(</span><span class="token string">"&amp;sender="</span><span class="token operator">+</span>senderId<span class="token punctuation">)</span><span class="token punctuation">;</span>

            <span class="token comment" spellcheck="true">//final string</span>
            mainUrl <span class="token operator">=</span> sbPostData<span class="token punctuation">.</span><span class="token function">toString</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token keyword keyword-try">try</span>
            <span class="token punctuation">{</span>
                <span class="token comment" spellcheck="true">//prepare connection</span>
                myURL <span class="token operator">=</span> <span class="token keyword keyword-new">new</span> <span class="token class-name">URL</span><span class="token punctuation">(</span>mainUrl<span class="token punctuation">)</span><span class="token punctuation">;</span>
                myURLConnection <span class="token operator">=</span> myURL<span class="token punctuation">.</span><span class="token function">openConnection</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                myURLConnection<span class="token punctuation">.</span><span class="token function">connect</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                reader<span class="token operator">=</span> <span class="token keyword keyword-new">new</span> <span class="token class-name">BufferedReader</span><span class="token punctuation">(</span><span class="token keyword keyword-new">new</span> <span class="token class-name">InputStreamReader</span><span class="token punctuation">(</span>myURLConnection<span class="token punctuation">.</span><span class="token function">getInputStream</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                <span class="token comment" spellcheck="true">//reading response</span>
                String response<span class="token punctuation">;</span>
                <span class="token keyword keyword-while">while</span> <span class="token punctuation">(</span><span class="token punctuation">(</span>response <span class="token operator">=</span> reader<span class="token punctuation">.</span><span class="token function">readLine</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token operator">!=</span> null<span class="token punctuation">)</span>
                <span class="token comment" spellcheck="true">//print response</span>
                System<span class="token punctuation">.</span>out<span class="token punctuation">.</span><span class="token function">println</span><span class="token punctuation">(</span>response<span class="token punctuation">)</span><span class="token punctuation">;</span>

                <span class="token comment" spellcheck="true">//finally close connection</span>
                reader<span class="token punctuation">.</span><span class="token function">close</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span>
            <span class="token keyword keyword-catch">catch</span> <span class="token punctuation">(</span><span class="token class-name">IOException</span> e<span class="token punctuation">)</span>
            <span class="token punctuation">{</span>
                    e<span class="token punctuation">.</span><span class="token function">printStackTrace</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span>
        <span class="token punctuation">}</span>
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
