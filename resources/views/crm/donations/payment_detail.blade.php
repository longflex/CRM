@extends('layouts.crm.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
	<a class="section" href="{{ url()->previous()}}#Donations">Donations</a>
	<i class="right angle icon divider"></i>
	<div class="active section">{{ trans('laralum.paymen_detail_title') }}</div>
</div>
@endsection
@section('title', trans('laralum.paymen_detail_title'))
@section('icon', "edit")
@section('subtitle', 'Payment Details')
@section('content')
<div class="ui one column doubling stackable grid container">
	<div class="three wide column"></div>
	<div class="ui very padded segment">
		<div class="fifteen wide column">
			<?php
		?>
			<table class="ui five column table ">
				<thead>
					<tr>
						<th>No</th>
						<!-- <th>Date</th> -->
						<th>Due Date</th>
						<th>Emi Amount</th>
						<th>Payment Mode</th>
						<th>Location</th>
						<th>Payment Status</th>
						<th>Payment Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
				//echo "<pre>";print_r($emis);echo "</pre>";
				?>
					@foreach($emis as $key=> $emi)

					<?php
					$due_date   = date('d/m/Y', strtotime($emi->due_date));
					
					?>
					<tr>
						<td>
							<div class="form-group">
								{{$key+1}}
							</div>
						</td>
						<!-- <td>
							<div class="form-group">
								{{ $emi->emi_period}}
							</div>
						</td> -->
						<td>
							<div class="form-group">
								<!-- {{ $emi->emi_period}}  -->
								{{ $due_date }}

							</div>
						</td>
						<td>
							<div class="form-group">
								{{$emi->emi_amount}}
							</div>
						</td>
						<td>
							<div class="form-group">
								{{$emi->payment_mode}}
							</div>
						</td>
						<td>
							<div class="form-group">
								{{$emi->location}}
							</div>
						</td>
						<td>
							@if($emi->emi_status)
							<div class="form-group">
								Paid
							</div>
							@else
							<div class="form-group" id="status-{{$emi->id}}">
								<select class="emi_status" name="status" data-id={{$emi->id}}>
									<option value="0">Not Paid</option>
									<option value="1">Paid</option>
								</select>
							</div>
							@endif
						</td>
						<td>
							<div class="form-group">
								{{$emi->paid_date!="0000-00-00"? date('d/m/Y h:i:s A', strtotime($emi->paid_date)) :'N.A.'}}
							</div>
						</td>

						<td>
							<div
								class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
								<i class="configure icon"></i>
								<div class="menu">
									@if($emi->emi_status)
									<a href="{{ route('Crm::payment_details_print', ['id' => $emi->id]) }}"
										class="item">
										<i class="print icon"></i>&nbsp; Print
									</a>
									@endif
									
									

									@if(!$emi->emi_status && $emi->payment_mode=='CASH')
									<a href="javascript:void(0);" class="item update_payment_status_paid" data-id="{{$emi->id}}">
										<i class="fa fa-check"></i>&nbsp; Mark as Paid
									</a>
									@endif
									
									@if (Laralum::hasPermission('laralum.member.sendsms'))
									<!-- <a href="javascript:void(0);" class="item" data-toggle="modal"
										data-target="#SMSModal">
										<i class="fa fa-comment"></i>&nbsp; Send SMS
									</a> -->
									@if(!$emi->emi_status && $emi->payment_mode=='Razorpay')
									<a href="javascript:void(0);" class="item send_emi_payment_link_sms" data-id="{{$emi->id}}">
										<i class="fa fa-comment"></i>&nbsp; Send Payment Link SMS
									</a>
									@endif
									@endif

								</div>
							</div>
						</td>


					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="three wide column"></div>
</div>

<!--sms-modal-start-->
<div class="modal" id="SMSModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><i class="fa fa-comment"></i>&nbsp;SEND SMS
				</h4>

			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<div class="text-left text-remain" id="rtext"><small><span id="rchars">250</span> Character(s)
								Remaining</small></div>
						<textarea class="form-control" rows="3" id="msg_str" placeholder="Type a message"></textarea>
						<div class="text-left" id="show_msg_str_error" style="color:red;display:none;">This field is
							required.
						</div>
						<input type="hidden" id="receiver_mobile" value="{{ $member->mobile }}" />
					</div>
					<div class="text-right">
						<button type="button" class="btn btn-sm btn-primary text-uppercase"
							id="send_message">SEND</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!--sms-modal-end-->
@endsection
@section('js')
<script type="text/javascript">
	$(document).ready(function() {
	$('.emi_status').change(function(){

		var val = $(this).val();
		var id=$(this).attr('data-id');

		var type = "POST";
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		
		var type = "POST";
		$.ajax({
			type: 'post',
			url: "{{ route('Crm::updatePaymentDetail') }}",
			data: {value:val,id:id},
			async: false,
			success: function (data) {
				swal({
					title: "Success!",
					text: "Data has been submited!",
					type: "success"
				}, function () {
					$('#status-'+data.data).html('<span class="badge badge-success">Paid</span>');
				});
			},
			error: function (data) {
				swal('Error!', data, 'error')
			}
		});  
	});

	$('.update_payment_status_paid').click(function(){

		var id=$(this).attr('data-id');

		var type = "POST";
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})

		var type = "POST";
		$.ajax({
			type: 'post',
			url: "{{ route('Crm::updatePaymentDetail') }}",
			data: {value:1,id:id},
			async: false,
			success: function (data) {
				swal({
					title: "Success!",
					text: "Data has been submited!",
					type: "success"
				}, function () {
					location.reload();
					$('#status-'+data.data).html('<span class="badge badge-success">Paid</span>');
				});
					
			},
			error: function (data) {
				swal('Error!', data, 'error')
			}
		});  
	});


	/*send Emi Payment link SMS*/
	$('.send_emi_payment_link_sms').click(function () {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		}); 
		var emi_id = $(this).attr('data-id');
		$.ajax({
			type: 'post',
			url: "{{ route('Crm::send_emi_payment_link_sms') }}",
			data: {emi_id:emi_id},
			success: function (data) {		
				//console.log(data);					
				swal({
					title: "Success!",
					text: data.message,
					type: "success"
				}, function () {
					location.reload();
				});	
				//location.reload();		
			}
		})	
	});

	/*send message*/
	$('#send_message').click(function () {
		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
				}
			})       
		var msg = $("#msg_str").val();
		if(msg==''){
			$("#show_msg_str_error").show();
		}else{
			$("#show_msg_str_error").hide();
		}	
		var receiver_mobile = $("#receiver_mobile").val();		
		$('#send_message').html('SENDING..');
		$.ajax({
			type: 'post',
			url: "{{ route('Crm::send_message') }}",
			data: {receiver_mobile:receiver_mobile,msg:msg},
			success: function (data) {			
				if(data.status=='success'){
					$('#send_message').html('SEND');
					$('#msg_str').val('');
					$('#SMSModal').modal('hide');
					$('#calling_success_msg').html(data.message);
					$('#calling_success_msg').show();
					setTimeout(function(){							
						location.reload();
					}, 3000);
				}else {				
					$('#send_message').html('SEND');
					$('#SMSModal').modal('hide');
					$('#calling_error_msg').html(data.message);
					$('#calling_error_msg').show();
				}
			}
		})
		
	});
	/*send message*/
});
	
</script>
@endsection