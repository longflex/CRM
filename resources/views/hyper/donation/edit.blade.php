@extends('hyper.layout.master')
@section('title', "Edit Donation")
@section('content')

<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations') }}"><i class="uil-home-alt"></i>Donation</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations_report') }}">Donation Report</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Donation</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="edit_donation_form" action="javascript:void(0)" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}	
                        <input type="hidden" name="donation_id" value="{{ $donation->id }}"/>
                        <h4 class="text-left mb-3">Account Details</h4>
                        <hr>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Donation Type *</label>
                                    <select class="form-control select2" id="donation_type" name="donation_type" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        @foreach($membertypes as $key => $type)
                                        <option value="{{ $key }}"
                                            {{ ($donation->donation_type) == $key ? 'selected': '' }}>
                                            {{ $type->type }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Payment Mode *</label>
                                    <select class="form-control select2" id="payment_mode" name="payment_mode" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        <option value="CASH" {{ $donation->payment_mode=='CASH' ? 'selected' : '' }}>Cash</option>
                                        <option value="CARD" {{ $donation->payment_mode=='CARD' ? 'selected' : '' }}>Card</option>
                                        <option value="CHEQUE" {{ $donation->payment_mode=='CHEQUE' ? 'selected' : '' }}>Cheque</option>
                                        <option value="QRCODE" {{ $donation->payment_mode=='QRCODE' ? 'selected' : '' }}>QR code</option>
                                    </select>
                                </div>
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Amount*</label>
                                    <input type="text" class="form-control" id="amount" placeholder="Please enter the amount" name="amount" value="{{ isset($donation) ? $donation->amount : '' }}" />    
                                </div>
                            </div>
                            <div class="col-md-4" id="reference_no_field" style="display:none">
                                <div class="form-group">
                                   <label>Reference No.<span style="color:red;">*</span></label>															
                                   <input type="text" value="{{ isset($donation) ? $donation->reference_no : '' }}" class="form-control" id="reference_no" name="reference_no" placeholder="Please enter the reference no" />								
                               </div>													
                            </div>
                            <div class="col-md-4" id="bank_name_field" style="display:none">
                                <div class="form-group">
                                   <label>Bank<span style="color:red;">*</span></label>															
                                   <input type="text" class="form-control" value="{{ isset($donation) ? $donation->bank_name : '' }}" id="bank_name" name="bank_name" placeholder="Please enter the bank name" />								
                               </div>													
                            </div>
                            <div class="col-md-4" id="cheque_number_field" style="display:none">
                                <div class="form-group">
                                   <label>Cheque Number<span style="color:red;">*</span></label>															
                                   <input type="text" class="form-control" value="{{ isset($donation) ? $donation->cheque_number : '' }}" id="cheque_number" name="cheque_number" placeholder="Please enter the check no." />								
                               </div>													
                            </div>
                            <div class="col-md-4" id="branch_name_field" style="display:none">
                                <div class="form-group">
                                   <label>Branch<span style="color:red;">*</span></label>															
                                   <input type="text" class="form-control" value="{{ isset($donation) ? $donation->bank_branch : '' }}" id="branch_name" name="branch_name" placeholder="Please enter the branch name" />								
                               </div>													
                            </div>
                            <div class="col-md-4" id="cheque_date_field" style="display:none">
                                <div class="form-group">
                                   <label>Cheque Issue Date<span style="color:red;">*</span></label>															
                                   <input type="date" class="form-control" value="{{ isset($donation) ? $donation->cheque_date : '' }}" id="cheque_date" name="cheque_date" placeholder="Please select the cheque issue date" />							
                                </div>													
                            </div>
                        </div>
                        <div class="col-lg-3 mt-2 float-right">
                            <button type="submit" id="donationUpdateForm" class="btn btn-block btn-primary">{{ trans('laralum.submit') }}</button>
                        </div>                         
                    </form>


                </div>
            </div>
        </div>
    </div>
</div> 





@endsection
@section('extrascripts')
{{-- <script src="{{ asset('crm_public/js/donation-script.js') }}" type="text/javascript"></script> --}}
<script>
//Update Donation form scripts
$('#edit_donation_form').submit(function(e) {
	    e.preventDefault();		
		//doantion var
		var donation_type = $('#donation_type').val();
		var payment_mode = $('#payment_mode').val();
		var amount = $('#amount').val();
		var reference_no = $('#reference_no').val();
		var bank_name = $('#bank_name').val();
		var cheque_number = $('#cheque_number').val();
		var branch_name = $('#branch_name').val();
		var cheque_date = $('#cheque_date').val();
		
		if(payment_mode=="CHEQUE"){			
		    if(donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
			   $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
			  return false;
			}
		}else if(payment_mode=="QRCODE"){
			if(amount=='' || reference_no==''){
			   $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
			  return false;
			}
		}else{
			if(amount==''){
			   $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
			  return false;
			}
		}
											
		var formData = new FormData(this); 
		//var my_url = "";
		var type = "POST"; 
		$.ajaxSetup({
		   headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		 }
		})
		$("#hide_udonation_text").css('display','none');
	    $(".donationUpdateForm").css('display','inline-block');			    
		$.ajax({
			type: type,
			url: "{{route('Crm::donation_update')}}",
			data: formData,
			processData: false,
            contentType: false,
			dataType: 'json',
			success: function (data) {
				$(".donationUpdateForm").css('display','none');
				$("#hide_udonation_text").css('display','inline-block');
				 $.NotificationApp.send("Success","The donation has been created!","top-center","green","success");
				setTimeout(function(){
					window.location.href = "{{route('Crm::donations')}}";
				}, 3500);			    			    				
			},
			error: function (data) {
				console.log('Error:', data);
			}
		});
		 
	});



$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@if($donation->payment_mode=='CHEQUE')
	<script type="text/javascript">
	  $("#cheque_date_field").show();
	  $("#bank_name_field").show();
	  $("#cheque_number_field").show();
	  $("#branch_name_field").show();
	</script>
@endif
@if($donation->payment_mode=='QRCODE')
	<script type="text/javascript">
	  $("#reference_no_field").show();
	</script>
@endif
<script type="text/javascript">
    $(function () {
        $("#payment_mode").change(function () {
            if ($(this).val() == "CHEQUE") {
                $("#cheque_date_field").show();
                $("#bank_name_field").show();
                $("#cheque_number_field").show();
                $("#branch_name_field").show();
            } else {
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
            }
			
			if ($(this).val() == "QRCODE") {
                $("#reference_no_field").show();               
            } else {
                $("#reference_no_field").hide();
                
            }
        });		
		
    });
</script>
@endsection    