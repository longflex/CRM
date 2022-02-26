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
				<h3 class="form-heading">Create plan form Razorpay Payment</h3>
			</div>
			
			

			<form class="ui form" action="/crm/admin/payments/razorpaycreateplan" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}

                <div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
                        		<strong>Plan Name</strong>
                        		<input type="text" name="name"  id="name" class="form-control" placeholder="Name">
                    		</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<strong>Description</strong>
                        		<input type="text" name="description" class="form-control" placeholder="Description">
                    		</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<strong>Period</strong>
								<select id="period" name="period" class="form-control custom-select">
									<option value="">Please select..</option>
									<option value="daily" selected="">daily</option>
									<option value="weekly">weekly</option>
									<option value="monthly">monthly</option>
									<option value="yearly">yearly</option>
								</select>
                    		</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<strong>Amount</strong>
                        		<input type="text" name="amount" id="amount" class="form-control" placeholder="Amount">
                    		</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 text-right mb-30 mt-30">
					<button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button"><span
							id="">Create Plan</span>&nbsp;
					</button>
				</div>
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