@extends('layouts.admin.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
<a class="section" href="{{ route('console::manage_module') }}">{{ trans('laralum.module_manager') }}</a>
<i class="right angle icon divider"></i>
<div class="active section">{{  trans('laralum.senders_list') }}</div>
</div>
@endsection
@section('title', trans('laralum.senders_list'))
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
  		<div class="ui very padded segment">
		    <div class="row">
					<form class="ui form" method="GET" action="{{ route('console::sender') }}">
						<div class="col-md-12 mb-15">
							<h4><i class="fas fa-filter"></i> <span>FILTER</span></h4>
						</div>
						<div class="col-md-4">
							<div class="form-group">
							 <select id="service_type" name="service_type" class="inp-form custom-select">
							  <option value="" selected="selected">Service Type</option>
							  <option value="Promotional" @if(request()->get('service_type')=='Promotional') selected @endif>Promotional</option>									  
							  <option value="Transactional" @if(request()->get('service_type')=='Transactional') selected @endif>Transactional</option>
							 </select>							  								
							</div>
						</div>						
						<div class="col-md-4">
							<div class="form-group">
								<select id="status" name="status" class="custom-select">
									<option value="" selected="selected">Status</option>
									<option value="Approved" @if(request()->get('status')=='Approved') selected @endif>Approved</option>
									<option value="Rejected" @if(request()->get('status')=='Rejected') selected @endif>Rejected</option>
									<option value="Pending" @if(request()->get('status')=='Pending') selected @endif>Pending</option>	  
								</select>
							</div>
						</div>																		
						<div class="col-md-4">
						<div class="form-group">
							<button type="submit" class="res_ex ui teal button">Filter</button>
						</div>																	
						</div>																	
						
					</form>
				</div>
			@if(count($senders) > 0)
  			<table class="ui five column table">
  			  <thead>
  			    <tr>
				  <th>Client</th>
                  <th>Sender ID</th>
                  <th>Service Type</th>
				  <th>Requested On</th>
				  <th>Status</th>
				  <th>Action</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                  @foreach($senders as $sender)
					<tr>
                        <td>
                           <div class="text">
                            {{ $sender->clientname }}
                           </div>
                        </td>
                        <td>
                           <div class="text">
                              {{ $sender->sender_name }}
                           </div>
                        </td>
                        <td>
                          <div class="text">
                              {{ $sender->service }}
                           </div>
                        </td>
                        <td>
                          <div class="text">
                               {{ $sender->assign_date }}
                           </div>
						</td>
						 <td>
                          <div class="text">
						    @if($sender->status=='Rejected')
                             <span style="margin-top:3px;"  class="reject_btn">{{ $sender->status }}</span>
						    @elseif($sender->status=='Approved')
							<span style="margin-top:3px;"  class="approve_btn">{{ $sender->status }}</span>
                            @else
							<span style="margin-top:3px;"  class="pending_btn">{{ $sender->status }}</span>
						    @endif
                           </div>
						</td>
						 <td>
                          <div class="text">
                                <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
                                <i class="configure icon"></i>
                                <div class="menu">
                                  <div class="header">{{ trans('laralum.action_options') }}</div>
                                  
								  <span  id="{{ $sender->id }}" class="item" onclick="functionApprove(this.id);">
                                   <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                    {{ trans('laralum.approve') }}
                                  </span>
								  
								  <span  id="{{ $sender->id }}" class="item" onclick="functionReject(this.id);">
                                   <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                                     {{ trans('laralum.reject') }}
                                  </span>
								 
                                  
                                </div>
                              </div>
                           </div>
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
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "sender id"]) }}</p>
                    </div>
                </div>
            @endif
  		</div>		
        <br>
  	</div>
  </div>
<script type="text/javascript">
function functionReject(id) { 
	var my_url = "{{ route('console::reject_sender') }}";
	var senderNameID = id;
	var type = "POST"; 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	var formData = {
		senderNameID: senderNameID,
	}
	 swal({
		title: "Are you sure?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, I am sure!',
		cancelButtonText: "No, cancel it!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function(isConfirm) {
		if (isConfirm) {
			swal({
				title: 'Success!',
				text: 'The senderID has been rejected!',
				type: 'success'
			}, function() {
				$.ajax({
					type: type,
					url: my_url,
					data: formData,
					dataType: 'json',
					success: function (data) {
						console.log(data);
					    window.location.reload();
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			});
			
		} else {
			swal("Cancelled", "Your senderID is safe :)", "error");
		}
	});
	
}
function functionApprove(id) { 
	var my_url = "{{ route('console::approve_sender') }}";
	var senderNameID = id;
	var type = "POST"; 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	var formData = {
		senderNameID: senderNameID,
	}
	 swal({
		title: "Are you sure?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, I am sure!',
		cancelButtonText: "No, cancel it!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function(isConfirm) {
		if (isConfirm) {
			swal({
				title: 'Success!',
				text: 'The sender ID has been approved!',
				type: 'success'
			}, function() {
				$.ajax({
					type: type,
					url: my_url,
					data: formData,
					dataType: 'json',
					success: function (data) {
						console.log(data);
					    window.location.reload();
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			});
			
		} else {
			swal("Cancelled", "Your senderID is safe :)", "error");
		}
	});
	
}
</script>	
@endsection
