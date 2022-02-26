@extends('hyper.layout.master')
@section('title', "Payment Details")
@section('content')
<?php //echo $id;die;?>
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations') }}"><i class="uil-home-alt"></i>Donation</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations_report') }}">Donation Report</a></li>
                        <li class="breadcrumb-item active">Payment Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Donation Payment Details</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
 
                    <div class="col-lg-12 table-responsive">
                        <table class="table w-100 dt-responsive nowrap" id="donationDetailDataTable">
                            <thead>
                                <tr>
                                    <th>No</th> 
                                    <th>Due Date</th>
                                    <th>Emi Amount</th>
                                    <th>Payment Mode</th>
                                    <th>Location</th>
                                    <th>Payment Status</th>
                                    <th>Payment Date</th>
                                    @if(Laralum::hasPermission('laralum.donation.view'))
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
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
@section('extrascripts')

<script>
    $(document).ready(function() {
        $('#donationDetailDataTable').DataTable().destroy();
        let table = $('#donationDetailDataTable');
        let id = '{{ $id }}';
        table.DataTable({
			serverSide: true,
            responsive: true,
            processing: true,
            ajax: {
                url: "{{ route('Crm::get.lead.donation.detail') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
            },
            columns: [
                {data: "no", name: 'recurring_payments.id'},
                {data: "due_date", name: 'recurring_payments.due_date'},
                {data: "emi_amount", name: 'recurring_payments.emi_amount'},
                {data: "payment_mode", name: 'donations.payment_mode'},
                {data: "location", name: 'donations.location'},
                {data: "payment_status", name: 'donations.payment_status'},
                {data: "payment_date", name: 'recurring_payments.paid_date'},
                {data: "action", sortable: false, searchable : false},
            ]
        });
    });
	$('.update_payment_status_paid').click(function(){alert('ok');die;

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

	function update_payment_status_paid(id){

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
	$.ajax({
				type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url:  "{{route('Crm::updatePaymentDetail')}}",
				data:{value:1,id:id} ,
				dataType: 'json', // what type of data do we expect back from the server
				encode: true
			})
			// using the done promise callback
			.done(function(data) {
				if(data.status==false){
					$.NotificationApp.send("Error",data.message,"top-center","red","error");
					setTimeout(function(){
						//location.reload();
					}, 3500);
				
				}

				if(data.status==true){
					
					$.NotificationApp.send("Success",data.message,"top-center","green","success");
					setTimeout(function(){
						location.reload();
						//var url = "{{route('Crm::leads')}}";
						//location.href=url;
					}, 3500);
				}

			})
			// using the fail promise callback
			.fail(function(data) {
				$.NotificationApp.send("Error",data.message,"top-center","red","error");
				setTimeout(function(){
					//location.reload();
				}, 3500);
			});

            
    }
	/*send Emi Payment link SMS*/
	// $('.send_emi_payment_link_sms').click(function () {
	// 	$.ajaxSetup({
	// 		headers: {
	// 			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	// 		}
	// 	}); 
	// 	var emi_id = $(this).attr('data-id');
	// 	$.ajax({
	// 		type: 'post',
	// 		url: "{{ route('Crm::send_emi_payment_link_sms') }}",
	// 		data: {emi_id:emi_id},
	// 		success: function (data) {		
	// 			//console.log(data);					
	// 			swal({
	// 				title: "Success!",
	// 				text: data.message,
	// 				type: "success"
	// 			}, function () {
	// 				location.reload();
	// 			});	
	// 			//location.reload();		
	// 		}
	// 	})	
	// });
	function send_emi_payment_link_sms(id){

		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		$.ajax({
					type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
					url:  "{{route('Crm::send_emi_payment_link_sms')}}",
					data:{emi_id:id} ,
					dataType: 'json', // what type of data do we expect back from the server
					encode: true
				})
				// using the done promise callback
				.done(function(data) {
					if(data.status==false){
						$.NotificationApp.send("Error",data.message,"top-center","red","error");
						setTimeout(function(){
							//location.reload();
						}, 3500);
					
					}

					if(data.status==true){
						
						$.NotificationApp.send("Success",data.message,"top-center","green","success");
						setTimeout(function(){
							location.reload();
							//var url = "{{route('Crm::leads')}}";
							//location.href=url;
						}, 3500);
					}

				})
				// using the fail promise callback
				.fail(function(data) {
					$.NotificationApp.send("Error",data.message,"top-center","red","error");
					setTimeout(function(){
						//location.reload();
					}, 3500);
				});

				
		}
</script>

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