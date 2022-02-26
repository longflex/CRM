@extends('layouts.admin.panel')
@section('breadcrumb')
     <div class="ui breadcrumb">
        <div class="active section">{{  trans('laralum.transaction_list') }}</div>
    </div>
@endsection
@section('title', trans('laralum.transaction_list'))
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
  		<div class="ui very padded segment">
        
       
        <div class="row res-m-0">
		<form method="post">
        <div class="transaction_filter">
		 <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
         <div class="col-md-9">
			<div class="form-group">
			  <input type="text" class="inp delivery_inp1" id="daterange" value="{{ $drange }}"  name="daterange" placeholder="From Date - To Date">
			   <select class="inp delivery_inp1 select-style" name="client">
			    <option value="">Select Client</option>			  
				@foreach($users as $user)
				@if($user->su==0)
				<option value="{{ $user->id }}" @if($cid==$user->id) selected='selected' @endif>{{ $user->name }}</option>
				@endif
				@endforeach
			  </select>
			   <button type="submit" class="ui teal submit button">Submit</button>
			</div>
		 </div>
        
        <div class="col-md-3">
        <div class="transaction_filter_export">
        <input type="submit" name="export" value="Export" class="ui teal submit button" />
        </div>
        </div>
        </div>
		</form>
        </div>
        
		    <div class="table-responsive">
			
  			<table class="table1 table-striped table-bordered">
  			  <thead>
  			    <tr class="table-head">
				  <th width="5%">Time</th>
				  <th width="13%">Transfer</th>
                  <th width="27%">Credits</th>
                  <th width="12%">Price</th>
				  <th width="19%">Description</th>
				  <th width="12%">Amount</th>
				  <th width="12%">Type</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                 @foreach($logs as $log)
					<tr id="inlineEdit"> 	
					
						<td>
                          <div class="text">
						  {{ $log->created_at }}
                          </div>
                        </td>
                        <td>
                           <div class="text">
						    @if($log->action=='credit')
							   <span style="margin-top:3px;"  class="approve_btn">Purchase</span>
						    @else
                             <span style="margin-top:3px;"  class="reject_btn">Purchase refund</span>
							 @endif
                           </div>
                        </td>
                        <td>
                           <div class="text">
                             @if($log->action=='credit')
							   <span style="margin-top:3px; color:green;">{{ $log->unit  }}</span>
						    @else
                              <span style="margin-top:3px;color:red;">-&nbsp;{{ $log->unit }}</span>
							 @endif
                           </div>
                        </td>
                        <td>
                          <div class="text">
						  {{ $log->rate }}
                           </div>
                        </td>
                        <td>
                          <div class="text">
                            {{ $log->description }}
                           </div>
						</td>
						 <td>
                          <div class="text">
						   {{ $log->amount }}
                           </div>
						</td>
						 <td>
                          <div class="text">
						   {{ ($log->route==1) ? 'Promotional Route' : 'Transactional Route' }}
                           </div>
						</td>
					</tr>
				@endforeach
  			  </tbody>
  			</table>
			
			
  		</div>
  		</div>
		
        <br>
  	</div>
  </div>

<!--contact-table-only-search-->
 <script src="{{ asset(Laralum::publicPath() .'/daterange/moment.min.js') }}" type="text/javascript"></script>
 <script src="{{ asset(Laralum::publicPath() .'/daterange/daterangepicker.js') }}" type="text/javascript"></script>
 <link href="{{ asset(Laralum::publicPath() .'/daterange/daterangepicker.css') }}" type="text/css" rel="stylesheet">
<script type="text/javascript">
$('#daterange').daterangepicker({
 locale: {
      format: 'YYYY-MM-DD'
    },
	   maxDate: new Date(),
});
</script>
	
<style>
.inp
{
	width:100%;
	height:40px;
	line-height:40px;
	padding-left:7px;
	border:1px #ccc solid;
	border-radius:3px;
}

.inp:focus
{
	border:1px #008c86 solid;
	outline:none;
	text-align:left;
}

</style>
<!--editable-table-->
<!--contact-table-only-search-->
@endsection
