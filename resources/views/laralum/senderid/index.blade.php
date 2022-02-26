@extends('layouts.admin.panel')
@section('breadcrumb')
     <div class="ui breadcrumb">
        <div class="active section">{{  trans('laralum.senders_list') }}</div>
    </div>
@endsection
@section('title', trans('laralum.senders_list'))
@section('content')
<style>
.ui.five.column.table td {
    width: 0 !important;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
  		<div class="ui very padded segment">
		    <div class="row">
		      <div class="col-md-12 text-right">
				   <a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')" data-toggle="modal" data-target="#AddSender" class="res_ex ui {{ Laralum::settings()->button_color }} button">
					<i class="fas fa-plus icon_m" aria-hidden="true"></i><span>ADD</span>
				   </a>
			   </div>			   
		    </div>
		   
			@if(count($senders) > 0)
  			<table class="ui five column table">
  			  <thead>
  			    <tr>				 
                  <th>Sender</th>
                  <th>Service</th>
				  <th>Requested On</th>
				  <th>Approved On</th>
				  <th>Status</th>
				  <th>Action</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                  @foreach($senders as $sender)
					<tr>								
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
                              {{ date('d/m/Y', strtotime($sender->assign_date)) }}
                           </div>
						</td>
						<td>
                          <div class="text">
						    {{ $sender->approval_date ? date('d/m/Y', strtotime($sender->approval_date)) : '' }}                           
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
						  <td align="center" width="12%">
                          <div class="text"> 
                             <a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')" id="editSender" class="btn btn-sm btn-primary btn-table" data-toggle="modal" data-target="#EditSender" data-id="{{$sender->id}}" data-name="{{$sender->sender_name}}" data-service="{{$sender->service}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>						  
			                 <a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')" id="deleteSender" data-id="{{$sender->id}}" class="btn btn-sm btn-primary btn-table btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                           </div>
                        </td>
					</tr>
				@endforeach
  			  </tbody>
  			</table>
			{{ $senders->links() }}
			@else
			<div class="ui negative icon message">
				<i class="frown icon"></i>
				<div class="content">
					<div class="header">
						{{ trans('laralum.missing_title') }}
					</div>
					<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "sender ID"]) }}</p>
				</div>
			</div>
            @endif
  		</div>		
        <br>
  	</div>
  </div>
<!-- add-sender-popup-->
<div id="AddSender" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Request for sender id approval</h4>
      </div>
      <div class="modal-body">
	    <div id="validation-errors"></div>
        <form method="POST" enctype="multipart/form-data" id="save_sender_form" action="javascript:void(0)">
		    {{ csrf_field() }}
            <div class="form-group">
				<select class="form-control custom-select" name="service" id="service">
					<option value="Promotional">Promotional</option>
					<option value="Transactional">Transactional</option>
				</select>
				<small id="show_service_error" style="color:#FF0000;display:none;">Please enter 6 digit sender name</small>
			</div>			
			<div class="form-group">
				<input type="text" id="sender_name" class="form-control" name="sender_name" placeholder="Sender name" value="">
				<small id="show_sender_name_error" style="color:#FF0000;display:none;">Please enter 6 digit sender name</small>
			</div>			
			<div class="text-right">
			<button type="submit" id="senderForm" class="ui teal submit button"><span id="hide_sender_text">SAVE</span>&nbsp;
			<span class="senderForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
			</button>
			</div>
		</form>
      </div>     
    </div>
  </div>
</div>
<!-- add-sender-popup -->
<!-- edit-sender-popup-->
<div id="EditSender" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Sender</h4>
      </div>
      <div class="modal-body">
	    <div id="validation-error"></div>
        <form method="POST" enctype="multipart/form-data" id="edit_sender_form" action="javascript:void(0)">
		    {{ csrf_field() }}	
			<input type="hidden" id="sender_id" name="sender_id" />
			<div class="form-group">
				<select class="form-control custom-select" name="edit_service" id="edit_service">
					<option value="Promotional">Promotional</option>
					<option value="Transactional">Transactional</option>
				</select>
				<small id="show_edit_service_error" style="color:#FF0000;display:none;">Please enter 6 digit sender name</small>
			</div>			
			<div class="form-group">
				<input type="text" id="edit_sender_name" class="form-control" name="edit_sender_name" placeholder="Sender name" value="">
				<small id="show_edit_sender_name_error" style="color:#FF0000;display:none;">Please enter 6 digit sender name</small>
			</div>		
			<div class="text-right">
			<button type="submit" id="editSenderForm" class="ui teal submit button"><span id="hide_edit_sender_text">UPDATE</span>&nbsp;
			<span class="editSenderForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
			</button>
			</div>
		</form>
      </div>     
    </div>
  </div>
</div>
<!-- Edit-sender-popup -->
@endsection
@section('js')
<script src="{{ asset(Laralum::publicPath() .'/js/sender-script.js') }}"></script>
<script>
$(document).on('click','#editSender',function(e) {
	$('#sender_id').val($(this).attr('data-id'));
	$("#EditSender #edit_service option[value="+$(this).attr('data-service')+"]").attr('selected', 'selected');
	$('#edit_sender_name').val($(this).attr('data-name'));
});

//delete Contact
$(document).on('click','#deleteSender',function(e) {
    e.preventDefault();
    var id=$(this).attr('data-id');	
	var url = APP_URL+'/sms/admin/senderid/delete';
	var type = "POST"; 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	var formData = {
		  id: id,
	}
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this data!",
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
				title: 'Confirmed!',
				text: 'The sender ID has been deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: type,
					url: url,
					data: formData,
					dataType: 'json',
					success: function (data) {
						location.reload();
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			});
			
		} else {
			swal("Cancelled", "Your data is safe :)", "error");
		}
	});
	
});
</script>
@endsection