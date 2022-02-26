<?php $nav_javaxml = 'active'; ?>
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
<span class="token keyword keyword-import">import</span> java<span class="token punctuation">.</span>net<span class="token punctuation">.</span>HttpURLConnection<span class="token punctuation">;</span>

<span class="token keyword keyword-class">class</span> <span class="token class-name">Functions</span>
<span class="token punctuation">{</span>

	<span class="token keyword keyword-public">public</span> <span class="token keyword keyword-static">static</span> String <span class="token function">hitUrl</span><span class="token punctuation">(</span>String urlToHit<span class="token punctuation">,</span> String param<span class="token punctuation">)</span>
    	<span class="token punctuation">{</span>
        	<span class="token keyword keyword-try">try</span>
        	<span class="token punctuation">{</span>
                URL url <span class="token operator">=</span> <span class="token keyword keyword-new">new</span> <span class="token class-name">URL</span><span class="token punctuation">(</span>urlToHit<span class="token punctuation">)</span><span class="token punctuation">;</span>
                HttpURLConnection http <span class="token operator">=</span> <span class="token punctuation">(</span>HttpURLConnection<span class="token punctuation">)</span>url<span class="token punctuation">.</span><span class="token function">openConnection</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                http<span class="token punctuation">.</span><span class="token function">setDoOutput</span><span class="token punctuation">(</span><span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                http<span class="token punctuation">.</span><span class="token function">setDoInput</span><span class="token punctuation">(</span><span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                http<span class="token punctuation">.</span><span class="token function">setRequestMethod</span><span class="token punctuation">(</span><span class="token string">"POST"</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

                DataOutputStream wr <span class="token operator">=</span> <span class="token keyword keyword-new">new</span> <span class="token class-name">DataOutputStream</span><span class="token punctuation">(</span>http<span class="token punctuation">.</span><span class="token function">getOutputStream</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                wr<span class="token punctuation">.</span><span class="token function">writeBytes</span><span class="token punctuation">(</span>param<span class="token punctuation">)</span><span class="token punctuation">;</span>
                <span class="token comment" spellcheck="true">// use wr.write(param.getBytes("UTF-8")); for unicode message's instead of wr.writeBytes(param);</span>

                wr<span class="token punctuation">.</span><span class="token function">flush</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                wr<span class="token punctuation">.</span><span class="token function">close</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                http<span class="token punctuation">.</span><span class="token function">disconnect</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>


                BufferedReader in <span class="token operator">=</span> <span class="token keyword keyword-new">new</span> <span class="token class-name">BufferedReader</span><span class="token punctuation">(</span><span class="token keyword keyword-new">new</span> <span class="token class-name">InputStreamReader</span><span class="token punctuation">(</span>http<span class="token punctuation">.</span><span class="token function">getInputStream</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                String inputLine<span class="token punctuation">;</span>
                <span class="token keyword keyword-if">if</span> <span class="token punctuation">(</span><span class="token punctuation">(</span>inputLine <span class="token operator">=</span> in<span class="token punctuation">.</span><span class="token function">readLine</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token operator">!=</span> null<span class="token punctuation">)</span>
                <span class="token punctuation">{</span>
                        in<span class="token punctuation">.</span><span class="token function">close</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                        <span class="token keyword keyword-return">return</span> inputLine<span class="token punctuation">;</span>
                <span class="token punctuation">}</span>
                <span class="token keyword keyword-else">else</span>
                <span class="token punctuation">{</span>
                        in<span class="token punctuation">.</span><span class="token function">close</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                        <span class="token keyword keyword-return">return</span> <span class="token string">"-1"</span><span class="token punctuation">;</span>
                <span class="token punctuation">}</span>

            <span class="token punctuation">}</span>
            <span class="token keyword keyword-catch">catch</span><span class="token punctuation">(</span>Exception e<span class="token punctuation">)</span>
            <span class="token punctuation">{</span>
                System<span class="token punctuation">.</span>out<span class="token punctuation">.</span><span class="token function">println</span><span class="token punctuation">(</span><span class="token string">"Exception Caught..!!!"</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                e<span class="token punctuation">.</span><span class="token function">printStackTrace</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
                <span class="token keyword keyword-return">return</span> <span class="token string">"-2"</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span>
        <span class="token punctuation">}</span>
<span class="token punctuation">}</span>

<span class="token keyword keyword-public">public</span> <span class="token keyword keyword-class">class</span> <span class="token class-name">HitXmlData</span>
<span class="token punctuation">{</span>
	<span class="token keyword keyword-public">public</span> <span class="token keyword keyword-static">static</span> <span class="token keyword keyword-void">void</span> <span class="token function">main</span><span class="token punctuation">(</span>String<span class="token punctuation">[</span><span class="token punctuation">]</span> args<span class="token punctuation">)</span>
	<span class="token punctuation">{</span>
    		String strUrl <span class="token operator">=</span> <span class="token string">"https://eventnuts.com/api/postsms.php"</span><span class="token punctuation">;</span>
    		String xmlData <span class="token operator">=</span> "data<span class="token operator">=</span>
                                    <span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
                                        <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>YOURAUTHKEY<span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
                                        <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span><span class="token keyword keyword-default">default</span><span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
                                        <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">'message1 testing'</span> FROM<span class="token operator">=</span><span class="token string">'AAAAAA'</span><span class="token operator">&gt;</span>
                                            <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">'9999999990'</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
                                        <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
                                    <span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span>"

		String output <span class="token operator">=</span> Functions<span class="token punctuation">.</span><span class="token function">hitUrl</span><span class="token punctuation">(</span>strUrl<span class="token punctuation">,</span> xmlData<span class="token punctuation">)</span><span class="token punctuation">;</span>
		System<span class="token punctuation">.</span>out<span class="token punctuation">.</span><span class="token function">println</span><span class="token punctuation">(</span><span class="token string">"Output is: "</span><span class="token operator">+</span>output<span class="token punctuation">)</span><span class="token punctuation">;</span>

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
      <i class="fa fa-angle-up"></i></a>
  </div>
@endsection
