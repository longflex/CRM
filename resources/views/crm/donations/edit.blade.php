@extends('layouts.crm.panel')
@section('breadcrumb')
   <div class="ui breadcrumb">
        <a class="section" href="{{ route('Crm::donations') }}">{{ trans('laralum.donation_edit_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.donation_edit_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.donation_edit_title'))
@section('icon', "edit")
@section('subtitle', trans('laralum.donation_edit_subtitle'))
@section('content')
<div class="ui one column doubling stackable grid container">
    <div class="three wide column"></div>
	<div class="ui very padded segment">
    <div class="fifteen wide column">      
	<form class="ui form" action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="edit_donation_form">
		   {{ csrf_field() }}	
            <input type="hidden" name="donation_id" value="{{ $donation->id }}"/>		
			<div class="col-md-12">
				<h3 class="form-heading">{{ trans('laralum.donation_edit_title') }}</h3>
			</div>		
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-4">
					<div class="form-group">
					<label>Donation Type<span style="color:red;">*</span></label>															
					<select id="donation_type" name="donation_type" class="form-control custom-select">
						@foreach($membertypes as $key => $type)
						<option value="{{ $key }}"
							{{ ($donation->donation_type) == $key ? 'selected': '' }}>
							{{ $type->type }}
						</option>
						@endforeach
					</select>																					
					</div>
					</div>
                     <div class="col-md-4">
					<div class="form-group">
					<label>Payment Mode<span style="color:red;">*</span></label>															
					<select id="payment_mode" name="payment_mode" class="form-control custom-select">
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
                     <div class="col-md-4">
					 <div class="form-group">
						<label>Amount<span style="color:red;">*</span></label>															
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
			</div>						
		<div class="col-md-12 text-right mb-30 mt-30">
		<button type="submit" id="donationUpdateForm" class="ui {{ Laralum::settings()->button_color }} submit button"><span id="hide_udonation_text">{{ trans('laralum.save') }}</span>&nbsp;
		<span class="donationUpdateForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
		</button>
	  </div>				
	</form>
     </div>
    </div>
    <div class="three wide column"></div>
</div>
@endsection
@section('js')
<script src="{{ asset('crm_public/js/donation-script.js') }}" type="text/javascript"></script>
<script>
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