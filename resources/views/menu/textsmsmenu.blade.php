<div class="left-stick-menu">
       <ul>
       <li><a href="{{ route('api::text-sms') }}" class="{{ $nav_sendsms or '' }}">Send SMS</a>
       
       <ul class="left-sub-menu">
       <li><a href="#encodeyourapi">Encoding API</a></li>
       <li><a href="#SendSMSonMultipleNo">Send SMS on Multiple No.</a></li>
       <li><a href="#SendScheduleSMS">Send Schedule SMS</a></li>
       <li><a href="#SendUnicodeSMS">Send Unicode SMS</a></li>
       <li><a href="#ScheduleUnicodeSMS">Schedule Unicode SMS</a></li>
       <li><a href="#SendGroupSMS">Send Group SMS</a></li>
       </ul>
       
       </li>
       <li><a href="{{ route('api::xml-send-sms') }}" class="{{ $nav_xmlsendsms or '' }}">XML Send SMS</a>
       
       <ul class="left-sub-menu">
       <li><a href="#ValidateXML">Validate XML</a></li>
       <li><a href="#XMLSendSMS">XML Send SMS</a></li>
       <li><a href="#XMLScheduleSMS">XML Schedule SMS</a></li>
       <li><a href="#XMLFlashSMS">XML Flash SMS</a></li>
       <li><a href="#XMLUnicodeSMS">XML Unicode SMS</a></li>
       </ul>
       
       </li>
        <li><a href="{{ route('api::error-code') }}" class="{{ $nav_error or '' }}">Error Code</a></li>
        <li><a href="{{ route('api::delivery-report') }}" class="{{ $nav_report or '' }}" >Delivery Report</a></li>
       </ul>       
       </div>	