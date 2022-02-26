@extends('layouts.admin.panel') 
@section('breadcrumb')
<div class="ui breadcrumb">
        <div class="active section">{{  trans('laralum.delivery_manager') }}</div>
</div> 
@endsection
@section('title', trans('laralum.delivery_manager'))
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="ui one column doubling stackable grid container mb-30">
<div class="column">
 <div class="fifteen wide column padding_t_l">
        
	<div class="ui very padded segment">	
       <!--tab_user_profile-->
       <div class="delivery-report-main-area">
       
       <div class="">
       <!--new-tab-area-->
	<div class=""> 
	 <ul class="nav nav-tabs">
		<li class="active">
			<a data-toggle="tab" href="#Reports">
				<i class="fa fa-line-chart" aria-hidden="true"></i>
				<span>Reports</span>
			</a> 
		</li>
		<li>
			<a data-toggle="tab" href="#Scheduled">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
				<span>Scheduled</span>
			</a> 
		</li>
		<li>
			<a data-toggle="tab" href="#Exports">
				<i class="fa fa-upload" aria-hidden="true"></i>
				<span>Exports</span>
			</a> 
		</li>
		<li>
			<a data-toggle="tab" href="#SendOTP">
				<i class="fa fa-mobile" aria-hidden="true"></i>
				<span>Send OTP</span>
			</a> 
		</li>
		
	  </ul>
  
  <div class="tab-content"> 	
    <!--report-->
    <div id="Reports" class="tab-pane fade in active"> 
    <form method="GET" action="{{ route('Laralum::reports') }}">	
		<div class="form-group">  
			 <input type="text" class="inp delivery_inp" id="search_inst_msg_request_id" name="search_inst_msg_request_id" placeholder="Search by Request ID">       
			 <select class="inp delivery_inp select-style" id="campaign" name="campaign">
			 <option value="">All Campaings</option>
				 @foreach($allcampaign as $campaign)
				  <option value="{{ $campaign->id }}">{{ $campaign->campaign_name }}</option>	  
				 @endforeach
			 </select>
			 
			  <select class="inp delivery_inp select-style" id="platform" name="platform">
				 <option value="">All</option>
				 <option value="panel">Panel</option>
				 <option value="api">API</option>
			 </select>
			 
			 <select class="inp delivery_inp select-style" id="route" name="route">
				 <option value="">All Routes</option>
				 <option value="1">Promotional Route</option>
				 <option value="4">Transactional Route</option>
			 </select>
			 <select name="date_range" class="inp delivery_inp select-style" id="date_range" name="date_range">
				<option value="7" selected="">Last 7 Days</option>
				<option value="14">Last 14 Days</option>
				<option value="30">Last 30 Days</option>
				<option value="60">Last 60 Days</option>
				<option value="90">Last 90 Days</option>
				<option value="custom">Custom Range</option>
			</select>
			<button type="submit" class="ui teal submit button mar_r_15" value="searchInstMsg" name="instMsgSearchButton"><i class="fa fa-search" aria-hidden="true"></i></button>
		</div>
     </form>		
    <div class="form-group">
    <div class="divider"></div>
    </div>   
    <!--big-message-table-->
    <div class="form-group">
     <div class="table-responsive">
	 @if(count($instantMsg) > 0)
            <table class="ui table">
  			  <thead>
  			    <tr class="table_heading">
                  <th width="15%">Sent</th>
                  <th width="15%">Campaign</th>
                   <th width="24%">Message</th>
				   <th width="24%">Request</th>
				   <th width="15%">Details</th>
                  <th width="7%" class="text-center"></th>
  			    </tr>
  			  </thead>
  			  
              <tbody class="read">
			  @foreach($instantMsg as $insMsg)
			  <tr>
                  <td><span data-toggle="tooltip" data-html="true" title="{{ $insMsg->created_at }}">{{ $insMsg->created_at }}</span></td>
                 
                  <td>
                   <span data-toggle="tooltip" data-html="true" title="{{ $insMsg->campagin_id }}">{{ $insMsg->campagin_id }}<span>
                  </td>
                   <td>
                   <a href="{{ route('Laralum::details',['id' => $insMsg->response_id]) }}" class="fancybox fancybox.iframe" >
                   {{ $insMsg->message }}
                   </a>
                   </td>
				   <td>
                  <span data-toggle="tooltip" data-html="true" title="<div class='text-left tooltip-ul'>
				  <ul>
				  <li>By Panel</li>
				  <li>Normal</li>
				  <li>Panel</li>
				  </ul>
				  </div>">
                  @if($insMsg->route==1)Promotional @else Transactional @endif  Route {{ $insMsg->response_id }}
                   </span>
                   </td>
				   <td>
                    <span data-toggle="tooltip" data-html="true" title="<p class='text-left'>Credit: {{ $insMsg->pages }} <br /> Deducted: <?php echo round($insMsg->units) ?></p>">Total <?php echo round($insMsg->units) ?> SMS</span>
                   </td>
                  <td align="center">
				  <a href="{{ route('Laralum::excel-reports', ['id' => $insMsg->response_id]) }}" class="ui teal submit button" data-toggle="tooltip" title="EXPORT CSV FILE"><i class="fas fa-download"></i></a>
				  </td>
  			    </tr>
                @endforeach
                  
              </tbody>
  			</table>
			@else
                <div class="ui negative icon message">
                    <i class="frown icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ trans('laralum.missing_title') }}
                        </div>
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "message"]) }}</p>
                    </div>
                </div>
            @endif
  		</div>
        </div>
    <!--big-message-table-->     
    </div>
    <!--report-->
    
    <!--Scheduled-->
    <div id="Scheduled" class="tab-pane fade">
    <form method="GET" action="{{ route('Laralum::reports') }}">		
      <div class="form-group">    
         <input type="text" class="inp delivery_inp" name="search_sch_msg_request_id" placeholder="Search By Request ID">     	 
         <select class="inp delivery_inp select-style" name="schCampaign">
			 <option value="all">All Campaings</option>
			 @foreach($allcampaign as $campaign)
					<option value="{{ $campaign->id }}">{{ $campaign->campaign_name }}</option>		 
			 @endforeach
		 </select>
		 <button type="submit" class="ui teal submit button mar_r_15" id="schSearchButton"><i class="fa fa-search" aria-hidden="true"></i></button>
      </div>
	 </form>
    
    
    <div class="form-group">
    <div class="divider"></div>
    </div>
    
     <!--big-message-table-->
    <div class="form-group">
     <div class="table-responsive">
	  @if(count($scheduleMsg) > 0)
            <table class="ui table">
  			  <thead>
  			    <tr class="table_heading">
                  <th width="15%">Sent</th>
                  <th width="15%">Campaign</th>
                   <th width="24%">Message</th>
				   <th width="24%">Request</th>
				   <th width="15%">Details</th>
                  <th width="7%" class="text-center">Export</th>
  			    </tr>
  			  </thead>
  			  
              <tbody class="schread">
			  @foreach($scheduleMsg as $schMsg)
			  <tr>
                  <td><span data-toggle="tooltip" data-html="true" title="{{ $schMsg->created_at }}">{{ $schMsg->created_at }}</span></td>
                 
                  <td>
                   <span data-toggle="tooltip" data-html="true" title="{{ $schMsg->campagin_id }}">{{ $schMsg->campagin_id }}<span>
                  </td>
                   <td>
                  <a href="{{ route('Laralum::details',['id' => $schMsg->response_id]) }}" class="fancybox fancybox.iframe" >
                   {{ $schMsg->message }}
                   </a>
                   </td>
				   <td>
                  <span data-toggle="tooltip" data-html="true" title="<div class='text-left tooltip-ul'>
				  <ul>
				  <li>By Panel</li>
				  <li>Normal</li>
				  <li>Panel</li>
				  </ul>
				  </div>">
                  @if($schMsg->route==1)Promotional @else Transactional @endif  Route {{ $schMsg->response_id }}
                   </span>
                   </td>
				   <td>
                   <span data-toggle="tooltip" data-html="true" title="<p class='text-left'>Credit: {{ $schMsg->pages }} <br /> Deducted: <?php echo round($schMsg->units) ?></p>">Total <?php echo round($schMsg->units) ?> SMS</span>
                   </td>
                  <td align="center">
				     <a href="{{ route('Laralum::excel-reports', ['id' => $schMsg->response_id]) }}"  title="Export to CSV file.">Exports</a>
				  </td>
  			    </tr>
                @endforeach
                
                  
              </tbody>
  			</table>
			@else
                <div class="ui negative icon message">
                    <i class="frown icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ trans('laralum.missing_title') }}
                        </div>
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "schedule message"]) }}</p>
                    </div>
                </div>
            @endif
  		</div>
        </div>
    <!--big-message-table-->     
    </div>
    <!--Scheduled-->
    
    <!--Exports-->
    <div id="Exports" class="tab-pane fade">
    <div class="export_m_div">
    <div class="col-md-5">
    <h3>Weekly Report</h3>   
    <table class="ui table" width="100%" >
	 <thead>
		<tr class="table_heading">
		<th class="text-left">Reports</th>
		<th class="text-left">Time</th>
		</tr>
		</thead>
		<tbody>
		<tr><td colspan="100%">No record found</td></tr>
		 </tbody>
	</table>   
    </div>   
    <div class="col-md-5">
    <h3>User Exports</h3>   
    <table class="ui table" width="100%" >
	<thead>
		<tr class="table_heading">
		<th class="text-left">Reports</th>
		<th class="text-left">Time</th>
		</tr>
		</thead>
		<tbody>
		<tr><td colspan="100%">No record found</td></tr>
	</tbody>
	</table>
    
    </div>    
    </div>
    </div>
    <!--Exports-->
    
    <!--SendOTP-->
    <div id="SendOTP" class="tab-pane fade">    
    <form class="form form-inline form-multiline min-height-400" role="form">   
    <div class="form-group">    
     <input type="text" class="inp delivery_inp" id="searchOTP" placeholder="Search">    
     <button type="button" class="ui teal submit button mar_r_15" id="InputFieldA"><i class="fa fa-search" aria-hidden="true"></i></button>    
     <select class="inp delivery_inp select-style">
     <option value="all">All Campaings</option>
	  @foreach($allcampaign as $campaign)
	   <option value="{{ $campaign->id }}">{{ $campaign->campaign_name }}</option>	      
	  @endforeach
     </select>
    
     <select class="inp delivery_inp select-style">
		 <option value="all">All</option>
		 <option value="panel">Panel</option>
		 <option value="api">API</option>
     </select>
     
     <select class="inp delivery_inp select-style">
		 <option value="all">All Routes</option>
		 <option value="1">Promotional Route</option>
		 <option value="4">Transactional Route</option>
     </select>
     <select name="date_range" class="inp delivery_inp select-style">
		<option value="7" selected="">Last 7 Days</option>
		<option value="14">Last 14 Days</option>
		<option value="30">Last 30 Days</option>
		<option value="60">Last 60 Days</option>
		<option value="90">Last 90 Days</option>
		<option value="custom">Custom Range</option>
	</select>     
    </div>   
    <div class="form-group">
    <div class="divider"></div>
    </div>    
    <!--big-message-table-->
    <div class="form-group">
     <div class="table-responsive">
            <table class="ui table">
  			  <thead>
  			    <tr class="table_heading">
                  <th width="15%">Sent</th>
                  <th width="15%">Campaign</th>
                   <th width="24%">Message</th>
				   <th width="24%">Request</th>
				   <th width="15%">Details</th>
                  <th width="7%" class="text-center">Export</th>
  			    </tr>
  			  </thead>
              <tbody>
			  <tr><td colspan="100%">Comming soon...</td></tr>
              </tbody>
  			</table>
  		</div>
        </div>
    <!--big-message-table-->  
  </form>   
 </div>
<!--SendOTP--> 
</div>
</div>
<!--new-tab-area-->
</div>
</div>
<!--tab_user_profile-->
</div>
</div>
</div>
</div>
<script src="{{ asset(Laralum::publicPath() .'/js/report-script.js') }}"></script>
<style>
 .loadinggif {
    background:url('{{ asset(Laralum::publicPath() .'/images/ajax-loader.gif') }}') no-repeat right center;
}
</style>
@endsection

