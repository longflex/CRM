<?php $nav_xmlsendsms = 'active'; ?>
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
        <h3>XML Send SMS</h3>
        </div>
        
        <!--1section-->
        <div class="form-group">
         <h4 class="sub_heading">Why XML API</h4>
      		
         <div class="decimal-list-style">
      	 <ul>
         <li>It is not possible for a URL to take too much data in GET method and have to use POST method</li>
         <li>It enables few extra features like sending custom SMS</li>
         <li>Sending 500 SMS will take 5 loop in HTTP API but none in XML, thus saving your resources and ours too</li>
         <li>If you face any issue, take help of our engineers</li>
         </ul>
       	 </div>
       
        </div>
        <!--1section-->
        
        
         <!--1section-->
        <div class="form-group">
        <h4 class="sub_heading">Sample XML format:</h4>
       
       <pre class="language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key <span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span>Template<span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>CAMPAIGN<span class="token operator">&gt;</span>XML API<span class="token operator">&lt;</span><span class="token operator">/</span>CAMPAIGN<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>COUNTRY<span class="token operator">&gt;</span>country code<span class="token operator">&lt;</span><span class="token operator">/</span>COUNTRY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"message1"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number1"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number2"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"hi test message"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number3"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>
       
        </div>
        <!--1section-->
        
        
         <!--section-->
        <div class="form-group">
        <p class="mb-8">Post your request with above format in data variable.</p>
        
        <div class="code_area">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/postsms.php</code>
       </div>
        </div>
        <!--section-->
        
         <!--section-->
        <div class="form-group">
        <h4 class="sub_heading">Sample Output</h4>
        <div class="alert alert-info">5134842646923e183d000075</div>
        
         <div class="alert alert-danger">
         <strong>Note :</strong>
         Output will be request ID which is alphanumeric and contains 24 characters like mentioned above. With this request ID, delivery Report can be viewed. If request not sent sucessfully, you will get the appropriate error message View error codes
         </div>
         
         
         <table class="table table-bordered">
                            <thead class="thead-default">
                            <tr>
                                <th width="25%">XML node name</th>
                                <th width="75%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>AUTHKEY<span class="red"> *</span></td>
                                <td>User authentication key</td>
                            </tr>
                            <tr>
                                <td>TEXT<span class="red"> *</span></td>
                                <td>It contains the URL encoded message content to send</td>
                            </tr>
                            <tr>
                                <td>SENDER<span class="red"> *</span></td>
                                <td>It contains sender ID</td>
                            </tr>
                            <tr>
                                <td>TO<span class="red"> *</span></td>
                                <td>It contain mobile numbers</td>
                            </tr>
                            <tr>
                                <td>SCHEDULE DATE TIME</td>
                                <td>It contains scheduled date and time</td>
                            </tr>
                            <tr>
                                <td>FLASH</td>
                                <td>1 </td>
                            </tr>
                            <tr>
                                <td>UNICODE</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>ROUTE</td>
                                <td>Route name if you have more than one route available in your account</td>
                            </tr>
                            <tr>
                                <td>CAMPAIGN</td>
                                <td>It contains campaign name</td>
                            </tr>
                            <tr>
                                <td>COUNTRY</td>
                                <td>0 for international, 91 for India, 1 for USA</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    
                    <p class="mb-8"> Call API</p>
                    
                     <p class="mb-8">To generate API or to test your XML code, please set the parameters in the text area below</p>
                     
                     
                     <table class="mb-8">
                             <tbody><tr>
                                 <td valign="center">data : </td>
                                 <td>
<textarea style="resize:none" class="span12" id="data" name="data" rows="10" cols="50" placeholder="Write your xml code here">&lt;MESSAGE&gt;
&lt;AUTHKEY&gt;Your auth key&lt;/AUTHKEY&gt;
&lt;SENDER&gt;SenderID&lt;/SENDER&gt;
&lt;ROUTE&gt;Template&lt;/ROUTE&gt;
&lt;CAMPAIGN&gt;campaign name&lt;/CAMPAIGN&gt;
&lt;COUNTRY&gt;country code&lt;/COUNTRY&gt;
&lt;SMS TEXT="message1"&gt;
&lt;ADDRESS TO="number1"&gt;&lt;/ADDRESS&gt;
&lt;/SMS&gt;
&lt;/MESSAGE&gt;
</textarea>
                            <!--<input type="text">-->
                        </td>
                             </tr>
                         </tbody>
                         </table>
         
         <div class="form-group">
  		<button type="submit" class="btn btn-api">Generate API</button>
        <button type="submit" class="btn btn-api">Test your xml code here...</button>
		</div>
        </div>
         <!--section-->
        
        <!--section-->
        <div class="form-group" id="ValidateXML">
        Validate XML
        </div>
        
        <div class="form-group">
        <h4 class="sub_heading">Parameters:</h4>
        <p><strong>Required:</strong> testingXml</p>
        <p><strong>Optional:</strong> none</p>
        </div>
        <!--section-->
        
        
        <!--3section-->
        <div class="form-group">
        <h4 class="sub_heading">Sample API</h4>
        
        <div class="code_area mb-12">
       <span class="label"> Get</span>
       <code>https://eventnuts.com/api/postsms.php</code>
       </div>
       
       
       <pre class="language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key <span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span>Template<span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>CAMPAIGN<span class="token operator">&gt;</span>XML API<span class="token operator">&lt;</span><span class="token operator">/</span>CAMPAIGN<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>COUNTRY<span class="token operator">&gt;</span>country code<span class="token operator">&lt;</span><span class="token operator">/</span>COUNTRY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"message1"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number1"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number2"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"hi test message"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number3"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>
        
        </div>
        <!--3section-->
        
        <!--4section-->
        <div class="form-group">
        <h4 class="sub_heading">Response</h4>  
        
        <p class="mb-8">returns json response with success if all parameters are correct or error with appropriate error message.</p>
        
         <table class="table table-bordered">
                            <thead class="thead-default">
                            <tr>
                                <th width="25%">Response Type</th>
                                <th width="25%">Response Message</th>
				<th width="50%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>success</td>
                                <td>XML code is correct.</td>
				<td>Returns success for validate XML API call.</td>
                            </tr>
                            <tr>
                                <td>error</td>
                                <td>XML code should not be blank.</td>
				<td>Returns error in case of 'testingsXml' parameter is missing or empty.</td>
				 
                            </tr>
                            <tr>
                                <td>error</td>
                                <td>Specific error message.</td>
				<td>Returns error in case of ill constructed XML API and displays appropriate error message.</td>
                            </tr>
                        </tbody>
                    </table>
        
        </div>  
        <!--4section-->
        
        
          <!--3section-->
        <div class="form-group" id="XMLSendSMS">
        <p class="mb-8">Send message on single number</p>
        
       <pre class="language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key <span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span>Template<span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>CAMPAIGN<span class="token operator">&gt;</span>XML API<span class="token operator">&lt;</span><span class="token operator">/</span>CAMPAIGN<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>COUNTRY<span class="token operator">&gt;</span>country code<span class="token operator">&lt;</span><span class="token operator">/</span>COUNTRY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"message1"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number1"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number2"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"hi test message"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number3"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>
        
         <p class="mb-15">To send message on multiple numbers, use <strong>&lt;ADDRESS&gt;</strong>  tag multiple times with different mobile numbers. Above API example can be modified to send single message on two mobile numbers</p>
         
         
         
          <p class="mb-8" id="XMLScheduleSMS">Schedule Message</p>
            <pre class="language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key <span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span>Template<span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>CAMPAIGN<span class="token operator">&gt;</span>XML API<span class="token operator">&lt;</span><span class="token operator">/</span>CAMPAIGN<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>COUNTRY<span class="token operator">&gt;</span>country code<span class="token operator">&lt;</span><span class="token operator">/</span>COUNTRY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"message1"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number1"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number2"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"hi test message"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number3"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>
        
        
         <p class="mb-15">To send schedule message one more tag &lt;<b>SCHEDULEDATETIME</b>&gt; will be added and it will contain scheduled date and time</p>


   <pre class="language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key <span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span>Template<span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>CAMPAIGN<span class="token operator">&gt;</span>XML API<span class="token operator">&lt;</span><span class="token operator">/</span>CAMPAIGN<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>COUNTRY<span class="token operator">&gt;</span>country code<span class="token operator">&lt;</span><span class="token operator">/</span>COUNTRY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"message1"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number1"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number2"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"hi test message"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number3"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>
        
        <p class="mb-15">This API can be used to send different messages on different numbers, simply by adding another &lt;<b>SMS</b>&gt; tag with different message content in <b>TEXT </b> </p>
        
        <p class="mb-8">Sending message using route</p>
        
        
   <pre class="language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key <span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span>Template<span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>CAMPAIGN<span class="token operator">&gt;</span>XML API<span class="token operator">&lt;</span><span class="token operator">/</span>CAMPAIGN<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>COUNTRY<span class="token operator">&gt;</span>country code<span class="token operator">&lt;</span><span class="token operator">/</span>COUNTRY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"message1"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number1"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number2"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"hi test message"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number3"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>

<p class="mb-15">Above API can be used to send SMS using route and it can be done easily by adding one more tag i.e. &lt;<b>ROUTE</b>&gt; tag  and it's value should be either default or template other wise message will be processed from default route</p>

<p class="mb-8" id="XMLFlashSMS">Flash message</p>

  <pre class="language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key <span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span>Template<span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>CAMPAIGN<span class="token operator">&gt;</span>XML API<span class="token operator">&lt;</span><span class="token operator">/</span>CAMPAIGN<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>COUNTRY<span class="token operator">&gt;</span>country code<span class="token operator">&lt;</span><span class="token operator">/</span>COUNTRY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"message1"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number1"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number2"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"hi test message"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number3"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>

<p class="mb-15">To send flash message one more  tag &lt;<b>FLASH</b>&gt; will be added and it will contain 1</p>
        
<p class="mb-8" id="XMLUnicodeSMS">Unicode message</p>

 <pre class="language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key <span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span>Template<span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>CAMPAIGN<span class="token operator">&gt;</span>XML API<span class="token operator">&lt;</span><span class="token operator">/</span>CAMPAIGN<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>COUNTRY<span class="token operator">&gt;</span>country code<span class="token operator">&lt;</span><span class="token operator">/</span>COUNTRY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"message1"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number1"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number2"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"hi test message"</span> <span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"number3"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>
        
 <p class="mb-20">To send unicode message one more  tag &lt;<b>UNICODE</b>&gt; will be added and it will contain 1</p>
        
        </div>
        <!--3section-->
        
        <!--section-->
        <div class="form-group">
        <h4 class="sub_heading">WHAT IS XML</h4>
        <p>
        XML (Extensible Markup Language) is a flexible way to create common information formats and share both the format and the data on Internet. As in HTML,it has it's own predefined tags while what makes XML flexible is that custom tags can be defined and the tags are invented by the author of the XML document.
        </p>
        
        </div>
        <!--section-->
        
        
        
        
           <!--Encode your API-->
      <div class="row">
      <div class="col-md-12">
      
      <div class="encode-your-api">
      
         <div class="form-group">
        <h4 class="sub_heading">Encode your message</h4>
        <p><strong>What is HTML encoding?</strong></p>
        <p class="mb-8">The HTML character encoder converts all applicable characters to their corresponding HTML entities. Certain characters have special significance in HTML and should be converted to their correct HTML entities to preserve their meanings. For example, it is not possible to use the < character as it is used in the HTML syntax to create and close tags. It must be converted to its corresponding &lt; HTML entity to be displayed in the content of an HTML page. HTML entity names are case sensitive.</p>
        
        
         <p><strong>Example:</strong></p>
       
        
        	 <pre class=" language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key<span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span><span class="token keyword keyword-default">default</span><span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"your password is: "</span><span class="token number">0989898</span><span class="token string">" "</span><span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"9999999990"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>
       
       
        <p class="mb-8">In this API the message content "your password is: "0989898" " includes " (double quotes) operator, due to which HTML encoding is necessary, otherwise it will break your XML and an error will be occur</p>
        
          <p class="mb-8"><strong>Encoded API</strong></p>
        
        
        <pre class=" language-java"><code class=" language-java"><span class="token operator">&lt;</span>MESSAGE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>AUTHKEY<span class="token operator">&gt;</span>Authentication Key<span class="token operator">&lt;</span><span class="token operator">/</span>AUTHKEY<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>ROUTE<span class="token operator">&gt;</span><span class="token keyword keyword-default">default</span><span class="token operator">&lt;</span><span class="token operator">/</span>ROUTE<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SENDER<span class="token operator">&gt;</span>SenderID<span class="token operator">&lt;</span><span class="token operator">/</span>SENDER<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span>SMS TEXT<span class="token operator">=</span><span class="token string">"your password is: %200989898%20 "</span><span class="token operator">&gt;</span>
        <span class="token operator">&lt;</span>ADDRESS TO<span class="token operator">=</span><span class="token string">"9999999990"</span><span class="token operator">&gt;</span><span class="token operator">&lt;</span><span class="token operator">/</span>ADDRESS<span class="token operator">&gt;</span>
    <span class="token operator">&lt;</span><span class="token operator">/</span>SMS<span class="token operator">&gt;</span>
<span class="token operator">&lt;</span><span class="token operator">/</span>MESSAGE<span class="token operator">&gt;</span></code></pre>
       
       
        <p class="mb-8">By encoding HTML special characters in API, will not break your XML</p>
        
        
        </div>
      
      </div>
      
      </div>
      </div>
      <!--Encode your API -->
        
      
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
