<?php $nav_report = 'active'; ?>
@extends('layouts.master')
@section('content')
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      
      <!-- Icon Cards-->
      <div class="row">
        
        
        <div class="col-md-2">
       
        @include('menu.textsmsmenu') 
        </div>
        
        <div class="col-md-10">
        
        <div class="main-heading">
        <h3>Push DLR</h3>
        </div>
        
        
        <!--section-->
        <div class="form-group mb-25">
        <h4 class="sub_heading">Get instant delivery report as soon as we receive</h4>
        </div>
        <!--section-->
        
        <!--section-->
        <div class="form-group mb-25">
        <h4 class="sub_heading">What is DLR push?</h4>
        <p>We post data (with all details of delivery report) on your web URL</p>
        </div>
        <!--section-->
        
        
         <!--section-->
        <div class="form-group mb-25">
        <h4 class="sub_heading">Benefits over old API</h4>
        
        <div class="decimal-list-style">
        <ul>
        <li>DLR Push improves speed & efficiency of receiving delivery reports</li>
        <li>It reduces server load, and latency in fetching the reports</li>
        </ul>
        </div>
        
        </div>
        <!--section-->
        
        
          <!--section-->
        <div class="form-group mb-25">
        <h4 class="sub_heading">DLR push works as follows:</h4>
        
        <div class="decimal-list-style">
        <ul>
        <li>At first, add your URL to webhooks in your account, it should be an address of the webpage of your application on which you need to receive delivery reports</li>
        <li>Now we start posting the data on this URL as soon as we receive new DLR</li>
        </ul>
        </div>
        
        </div>
        <!--section-->
        
        <!--section-->
        <div class="form-group mb-25">
        <h4 class="sub_heading">What if your server is down for any reason while we posting data?</h4>
        <p>Don’t worry! We will keep trying to post data in the interval of 1 hour</p>
        </div>
        <!--section-->
        
        <!--section-->
        <div class="form-group mb-25">
        <h4 class="sub_heading">Sample PHP code</h4>
        
        <pre class=" language-php"><code class=" language-php"><span class="token php"><span class="token delimiter">&lt;?php</span>


<span class="token variable">$request</span> <span class="token operator">=</span> <span class="token global">$_REQUEST</span><span class="token punctuation">[</span><span class="token string">"data"</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
<span class="token variable">$jsonData</span> <span class="token operator">=</span> <span class="token function">json_decode</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">,</span><span class="token boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$link</span> <span class="token operator">=</span> <span class="token function">mysqli_connect</span><span class="token punctuation">(</span><span class="token string">"myhost"</span><span class="token punctuation">,</span> <span class="token string">"myuser"</span><span class="token punctuation">,</span> <span class="token string">"mypassw"</span><span class="token punctuation">,</span> <span class="token string">"mybd"</span><span class="token punctuation">)</span> <span class="token keyword keyword-or">or</span> <span class="token keyword keyword-die">die</span><span class="token punctuation">(</span><span class="token string">"Error "</span> <span class="token punctuation">.</span> <span class="token function">mysqli_error</span><span class="token punctuation">(</span><span class="token variable">$link</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword keyword-foreach">foreach</span><span class="token punctuation">(</span><span class="token variable">$jsonData</span> <span class="token keyword keyword-as">as</span> <span class="token variable">$key</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$value</span><span class="token punctuation">)</span>
<span class="token punctuation">{</span>
     <span class="token comment" spellcheck="true">// request id</span>
    <span class="token variable">$requestID</span> <span class="token operator">=</span> <span class="token variable">$value</span><span class="token punctuation">[</span><span class="token string">'requestId'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token variable">$userId</span> <span class="token operator">=</span> <span class="token variable">$value</span><span class="token punctuation">[</span><span class="token string">'userId'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token variable">$senderId</span> <span class="token operator">=</span> <span class="token variable">$value</span><span class="token punctuation">[</span><span class="token string">'senderId'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token keyword keyword-foreach">foreach</span><span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">[</span><span class="token string">'report'</span><span class="token punctuation">]</span> <span class="token keyword keyword-as">as</span> <span class="token variable">$key1</span> <span class="token operator">=</span><span class="token operator">&gt;</span> <span class="token variable">$value1</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token comment" spellcheck="true">//detail description of report</span>
        <span class="token variable">$desc</span> <span class="token operator">=</span> <span class="token variable">$value1</span><span class="token punctuation">[</span><span class="token string">'desc'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
        <span class="token comment" spellcheck="true">// status of each number</span>
        <span class="token variable">$status</span> <span class="token operator">=</span> <span class="token variable">$value1</span><span class="token punctuation">[</span><span class="token string">'status'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
        <span class="token comment" spellcheck="true">// destination number</span>
        <span class="token variable">$receiver</span> <span class="token operator">=</span> <span class="token variable">$value1</span><span class="token punctuation">[</span><span class="token string">'number'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
        <span class="token comment" spellcheck="true">//delivery report time</span>
        <span class="token variable">$date</span> <span class="token operator">=</span> <span class="token variable">$value1</span><span class="token punctuation">[</span><span class="token string">'date'</span><span class="token punctuation">]</span><span class="token punctuation">;</span>
        <span class="token variable">$query</span> <span class="token operator">=</span> <span class="token string">"INSERT INTO mytable (request_id,user_id,sender_id,date,receiver,status,description) VALUES ('"</span> <span class="token punctuation">.</span> <span class="token variable">$requestID</span> <span class="token punctuation">.</span> <span class="token string">"','"</span> <span class="token punctuation">.</span> <span class="token variable">$userId</span> <span class="token punctuation">.</span> <span class="token string">"','"</span> <span class="token punctuation">.</span> <span class="token variable">$senderId</span> <span class="token punctuation">.</span> <span class="token string">"','"</span> <span class="token punctuation">.</span> <span class="token variable">$date</span> <span class="token punctuation">.</span> <span class="token string">"','"</span> <span class="token punctuation">.</span> <span class="token variable">$receiver</span> <span class="token punctuation">.</span> <span class="token string">"','"</span> <span class="token punctuation">.</span> <span class="token variable">$status</span> <span class="token punctuation">.</span> <span class="token string">"','"</span> <span class="token punctuation">.</span> <span class="token variable">$desc</span> <span class="token punctuation">.</span> <span class="token string">"')"</span><span class="token punctuation">;</span>
        <span class="token function">mysqli_query</span><span class="token punctuation">(</span><span class="token variable">$link</span><span class="token punctuation">,</span> <span class="token variable">$query</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
    Further you can <span class="token keyword keyword-use">use</span> <span class="token package">above</span> parameters <span class="token keyword keyword-and">and</span> either update your database <span class="token keyword keyword-or">or</span> just display it
    <span class="token keyword keyword-as">as</span> per your need <span class="token punctuation">.</span>
<span class="token delimiter">?&gt;</span></span></code></pre>

<p class="mb-8"><a href="#">Sample code for older version of push URL.</a></p>
        
        </div>
        <!--section-->
        
        
        <!--section-->
        <div class="form-group mb-25">
        <h4 class="sub_heading">Need help in generating API?</h4>
        <p class="mb-15">Fill the URL below to test your PushDLR code</p>
        
        <div class="form-inline mb-15">
  		<div class="form-group">
    	<label>URL <span>*:</span></label>
    	<input type="text" class="form-control mx-sm-3" id="" value="">
    	(Ex. http://yourdomain.com/dlr/pushUrl.php )
  		</div>
		</div>
 <div class="form-group">
        <button type="submit" class="btn btn-api">Generate PushDlr URL</button>
        </div>
        
        </div>
        <!--section-->
        
        
         <!--section-->
        <div class="form-group mb-25">
        <p>We will hit the URL in following format:</p>
        
        <div class="code_area"><span class="label">POST</span><code>

http://yourdomain.com/dlr/pushUrl.php?data=%5B%7B%22requestId%22%3A%22546b384ce51f469a2e8b4567%22%2C%22numbers%22%3A%7B%22911234567890%22%3A%7B%22date%22%3A%222014-11-18%2017%3A45%3A59%22%2C%22status%22%3A1%2C%22desc%22%3A%22DELIVERED%22%7D%7D%7D%5D

</code>
                    </div>
        
        </div>
        <!--section-->
        
        
         <!--section-->
        <div class="form-group mb-25">
        <p>Sample data:</p>
        
        <div class="code_area"><span class="label">POST</span>
                    <pre><br>data=[
      {
          "requestId":"35666a716868323535323239",
          "userId":"38229",
          "report":[
              {
                  "desc":"REJECTED",
                  "status":"16",
                  "number":"91XXXXXXXXXX",
                  "date":"2015-06-10 17:09:32.0"
              }
          ],
          "senderId":"tester"
      },
      {
          "requestId":"35666a716868323535323239",
          "userId":"38229",
          "report":[
              {
                  "desc":"REJECTED",
                  "status":"16",
                  "number":"91XXXXXXXXXX",
                  "date":"2015-06-10 17:09:32.0"
              },
              {
                  "desc":"REJECTED",
                  "status":"16",
                  "number":"91XXXXXXXXXX",
                  "date":"2015-06-10 17:09:32.0"
              }
          ],
          "senderId":"tester"
      }
  ]</pre>

                    </div>
        
        </div>
        <!--section-->
        
        
         <table class="table table-bordered">
          <thead class="thead-default">
                            <tr>
                                <th width="25%">Parameter name</th>
                                <th width="25%">Data type</th>
                                <th width="50%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
<tr>
<td>reqid</td>
<td>varchar</td>
<td>Request ID
(a unique 24 character alphanumeric value for identification of a particular SMS) </td>
</tr>
<tr>
<td>status</td>
<td>numeric</td>
<td>Status of SMS delivery
1=delivered
2=failed
16=rejected</td>
</tr>
<tr>
<td>desc</td>
<td>text</td>
<td>Delivered/Failed/Rejected</td>
</tr>
<tr>
<td>number</td>
<td>numeric (with country code)</td>
<td>Receiver’s Contact Number </td>
</tr>
<tr>
<td>date
(YYMMDDhhmm)</td>
<td>string</td>
<td>Displays the delivery time and date of SMS
YY: year
MM: month
DD: date
hh: hours
mm: minutes</td>
</tr>
                        </tbody>
                    </table>
        
        
      
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