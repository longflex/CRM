<?php $nav_vb6 = 'active'; ?>
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
        <h3>vb6 Sample Code Send SMS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Code:</h4>
        
     <pre class=" language-php p-15"><code class=" language-php"><span class="token keyword keyword-Private">Private</span> Sub <span class="token function">Command1_Click</span><span class="token punctuation">(</span><span class="token punctuation">)</span>

    Dim DataToSend <span class="token keyword keyword-As">As</span> String
    Dim objXML <span class="token keyword keyword-As">As</span> Object
    Dim message <span class="token keyword keyword-As">As</span> String
    Dim authKey <span class="token keyword keyword-As">As</span> String
    Dim mobiles <span class="token keyword keyword-As">As</span> String
    Dim sender <span class="token keyword keyword-As">As</span> String
    Dim route <span class="token keyword keyword-As">As</span> String
    Dim <span class="token constant">URL</span> <span class="token keyword keyword-As">As</span> String

'Set these variables
authKey <span class="token operator">=</span> <span class="token string">"Your auth key"</span><span class="token punctuation">;</span>

mobiles  <span class="token operator">=</span> <span class="token string">"9999999999"</span><span class="token punctuation">;</span>

'Sender <span class="token constant">ID</span><span class="token punctuation">,</span><span class="token keyword keyword-While">While</span> using route4 sender id should be <span class="token number">6</span> characters long<span class="token punctuation">.</span>
sender <span class="token operator">=</span> <span class="token string">"TESTIN"</span><span class="token punctuation">;</span>

' this url encode <span class="token keyword keyword-function">function</span> may not work fully functional<span class="token punctuation">.</span>
message <span class="token operator">=</span> <span class="token function">URLEncode</span><span class="token punctuation">(</span><span class="token string">" Your message "</span><span class="token punctuation">)</span>

'Define route
route <span class="token operator">=</span> <span class="token string">"default"</span>
' <span class="token keyword keyword-do">do</span> not <span class="token keyword keyword-use">use</span> <span class="token package">https</span>
<span class="token constant">URL</span> <span class="token operator">=</span> "http<span class="token punctuation">:</span><span class="token comment" spellcheck="true">//eventnuts.com/api/sendhttp.php?"</span>

Set objXML <span class="token operator">=</span> <span class="token function">CreateObject</span><span class="token punctuation">(</span><span class="token string">"Microsoft.XMLHTTP"</span><span class="token punctuation">)</span>
objXML<span class="token punctuation">.</span>Open <span class="token string">"POST"</span><span class="token punctuation">,</span> <span class="token constant">URL</span> <span class="token punctuation">,</span> False
objXML<span class="token punctuation">.</span>setRequestHeader <span class="token string">"Content-Type"</span><span class="token punctuation">,</span> <span class="token string">"application/x-www-form-urlencoded"</span>

objXML<span class="token punctuation">.</span>send <span class="token string">"authkey="</span> <span class="token operator">+</span> authKey <span class="token operator">+</span> <span class="token string">"&amp;mobiles="</span> <span class="token operator">+</span> mobiles <span class="token operator">+</span> <span class="token string">"&amp;message="</span> <span class="token operator">+</span> message <span class="token operator">+</span> <span class="token string">"&amp;sender="</span> <span class="token operator">+</span> sender <span class="token operator">+</span> <span class="token string">"&amp;route="</span> <span class="token operator">+</span> route

 <span class="token keyword keyword-If">If</span> <span class="token function">Len</span><span class="token punctuation">(</span>objXML<span class="token punctuation">.</span>responseText<span class="token punctuation">)</span> <span class="token operator">&gt;</span> <span class="token number">0</span> Then
        MsgBox objXML<span class="token punctuation">.</span>responseText

 End <span class="token keyword keyword-If">If</span>

End Sub

<span class="token keyword keyword-Function">Function</span> <span class="token function">URLEncode</span><span class="token punctuation">(</span>ByVal Text <span class="token keyword keyword-As">As</span> String<span class="token punctuation">)</span> <span class="token keyword keyword-As">As</span> String
    Dim i <span class="token keyword keyword-As">As</span> Integer
    Dim acode <span class="token keyword keyword-As">As</span> Integer
    Dim char <span class="token keyword keyword-As">As</span> String

    URLEncode <span class="token operator">=</span> Text

    <span class="token keyword keyword-For">For</span> i <span class="token operator">=</span> <span class="token function">Len</span><span class="token punctuation">(</span>URLEncode<span class="token punctuation">)</span> To <span class="token number">1</span> Step <span class="token operator">-</span><span class="token number">1</span>
        acode <span class="token operator">=</span> <span class="token function">Asc</span><span class="token punctuation">(</span>Mid$<span class="token punctuation">(</span>URLEncode<span class="token punctuation">,</span> i<span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
        Select <span class="token keyword keyword-Case">Case</span> acode
            <span class="token keyword keyword-Case">Case</span> <span class="token number">48</span> To <span class="token number">57</span><span class="token punctuation">,</span> <span class="token number">65</span> To <span class="token number">90</span><span class="token punctuation">,</span> <span class="token number">97</span> To <span class="token number">122</span>
                <span class="token string">' don'</span>t touch alphanumeric chars
            <span class="token keyword keyword-Case">Case</span> <span class="token number">32</span>
                ' replace space with <span class="token string">"+"</span>
                Mid$<span class="token punctuation">(</span>URLEncode<span class="token punctuation">,</span> i<span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span> <span class="token operator">=</span> <span class="token string">"+"</span>
            <span class="token keyword keyword-Case">Case</span> <span class="token keyword keyword-Else">Else</span>
                ' replace punctuation chars with <span class="token string">"%hex"</span>
                URLEncode <span class="token operator">=</span> Left$<span class="token punctuation">(</span>URLEncode<span class="token punctuation">,</span> i <span class="token operator">-</span> <span class="token number">1</span><span class="token punctuation">)</span> <span class="token operator">&amp;</span> <span class="token string">"%"</span> <span class="token operator">&amp;</span> Hex$<span class="token punctuation">(</span>acode<span class="token punctuation">)</span> <span class="token operator">&amp;</span> Mid$ _
                    <span class="token punctuation">(</span>URLEncode<span class="token punctuation">,</span> i <span class="token operator">+</span> <span class="token number">1</span><span class="token punctuation">)</span>
        End Select
    Next

End <span class="token keyword keyword-Function">Function</span></code></pre>
        
        </div>
        <!--1section-->
        
        
       
      
        </div>
        
        
        
        
      </div>
      <!-- Area Chart Example-->
      
      
   
      
      
      <!-- Example DataTables Card-->
    </div>
    
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>    </a>
    
  </div>
@endsection