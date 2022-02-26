@extends('layouts.crm.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
	<a class="section" href="{{ route('Crm::payments') }}">{{  trans('laralum.payment_title') }}</a>
	<i class="right angle icon divider"></i>
	<div class="active section">{{ trans('laralum.payment_create_title') }}</div>
</div>
@endsection
@section('title', trans('laralum.payment_create_title'))
@section('icon', "plus")
@section('subtitle', trans('laralum.payment_create_subtitle'))
@section('content')
<div class="ui one column doubling stackable grid container">
	<div class="three wide column"></div>
	<div class="ui very padded segment">
		<div class="fifteen wide column">

			<div class="col-md-12">
				<h3 class="form-heading">Make Payment</h3>
			</div>
			
			<center><h1>Please do not refresh this page...</h1></center>
            <form method="post" action="<?php echo $payment_txn_url ?>" name="f1">
            {{ csrf_field() }}
            <table border="1">
                <tbody>
                <?php
                foreach($paramlist as $name => $value) {
                    echo '<input type="hidden" name="' . $name .'" value="' . $value . '">';
                }
                ?>
                <input type="hidden" name="CHECKSUMHASH" value="<?php echo $checksum ?>">
                </tbody>
            </table>
            <script type="text/javascript">
                document.f1.submit();
            </script>
        	</form>
		</div>
	</div>
	<div class="three wide column"></div>
</div>



<script type="text/javascript">
	//Donations form scripts
    $('#upload_payment_form').submit(function(e) {
	    e.preventDefault();		
		var name = $('#name').val();
		var mobile_no = $('#mobile_no').val();
		var address = $('#Address').val();
		var amount = $('#amount').val();
		if(name=='' || mobile_no=='' || address=='' || amount==''){
			swal('warning!','All (*) mark fields are mandatory.','error')
			return false;
		}		
		var formData = new FormData(this); 
		var my_url = APP_URL+'/crm/admin/payments/create';
		var type = "POST"; 
		$.ajaxSetup({
		   headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		 }
		})
		$("#hide_donation_text").css('display','none');
	    $(".donationForm").css('display','inline-block');			    
		$.ajax({
			type: type,
			url: my_url,
			data: formData,
			processData: false,
            contentType: false,
			success: function (data) {
				$(".donationForm").css('display','none');
				$("#hide_donation_text").css('display','inline-block');			    
				swal({ title: "Success!", text: "The donation has been created!", type: "success" }, function(){ 
				   window.location.href = APP_URL+'/crm/admin/payments';
				});			    				
			},
			error: function (data) {
				console.log('Error:', data);
			}
		});
		 
	});	
</script>
@endsection