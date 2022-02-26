@extends('layouts.crm.panel')

@section('breadcrumb')
<div class="ui breadcrumb">
	<a class="section" href="{{ route('Crm::appointments') }}">{{  trans('laralum.donation_title') }}</a>
	<i class="right angle icon divider"></i>
	<div class="active section">{{ trans('laralum.donation_create_title') }}</div>
</div>
@endsection
@section('title', trans('laralum.donation_create_title'))
@section('icon', "plus")
@section('subtitle', trans('laralum.donation_create_subtitle'))
@section('content')
<div class="ui one column doubling stackable grid container">
	@if(!Laralum::loggedInUser()->RAZOR_KEY)
	<div class="card col-md-12">
		<div class="row ">
			<i class="fa fa-credit-card" aria-hidden="true"></i>
		</div>
		<div class="col-md-9">
			<h4>Get paid faster with online payment gateways</h4>
			<div class="row">
				<p class="col-md-5">Setup a payment gateway and start acepting payments online.</p>
				<a href="{{ route('console::profile') }}" id="donationForm"><span id="hide_donation_text">Set up
						Now</span>
				</a>
			</div>
		</div>
	</div>
	@endif
	<div class="three wide column"></div>
	<div class="ui very padded segment">
		<div class="fifteen wide column">

			<div class="col-md-12">
				<h3 class="form-heading">Member Details</h3>
			</div>
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-5">
						<div class="form-group">
							<input type="text" class="form-control search-inp" id="search_from_leads"
								name="search_from_leads"
								placeholder="Search member by 'Email' or 'Phone' or 'Member ID'" />
							<span class="search_loader" style="display:none;"><img
									src="{{ asset('/crm_public/images/search_loader.png') }}"></span>
						</div>
						<span id="search_text_error" style="color:red;display:none;">Please Enter 'Email' or 'Phone
							No. or Member ID'</span>
					</div>
				</div>
			</div>
			<form class="ui form" action="javascript:void(0)" method="POST" enctype="multipart/form-data"
				id="upload_donation_form">
				{{ csrf_field() }}
				<div class="lead_data" style="display:none;">
				</div>
				<div class="col-md-12">
					<hr>
				</div>
				<div class="col-md-12">
					<h3 class="form-heading">Donation Details</h3>
				</div>
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Donation Type<span style="color:red;">*</span></label>
								<select id="member_type_id" name="donation_type" class="form-control custom-select">
									<option value="">Please select..</option>
									@foreach($membertypes as $type)
									<option value="{{ $type->type }}"
										{{ (old('donation_type') == $type->type ? 'selected': '') }}>
										{{ $type->type }}
									</option>
									@endforeach
									<option value="add">Add Value</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Donation Purpose<span style="color:red;">*</span></label>
								<select id="donation_purpose" name="donation_purpose"
									class="form-control custom-select">
									<option value="">Please select..</option>
									@foreach($donation_purposes as $purpose)
									<option value="{{ $purpose->purpose }}"
										{{ (old('donation_purpose') == $purpose->purpose ? 'selected': '') }}>
										{{ $purpose->purpose }}
									</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Payment Type<span style="color:red;">*</span></label>
								<select id="payment_type" name="payment_type" class="form-control custom-select"
									onchange="stateChange(this)">
									<option value="">Please select..</option>
									<option value="single" {{ (old('payment_type') == 'single' ? 'selected': '') }}>
										Single</option>
									<option value="recurring"
										{{ (old('payment_type') == 'recurring' ? 'selected': '') }}>Recurring</option>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label>Payment Mode<span style="color:red;">*</span></label>
								<select id="payment_mode" name="payment_mode" class="form-control custom-select">
									<option value="">Please select..</option>
									<option value="CASH" selected="">Cash</option>
									<option value="CARD">Card</option>
									<option value="CHEQUE">Cheque</option>
									@if($razorKey)
									<option value="Razorpay">Razorpay</option>
									@endif
									{{-- <option value="GOOGLEPAY">GooglePay</option> --}}
									{{-- <option value="PHONEPAY">PhonePay</option> --}}
									<option value="QRCODE">QR code</option>
									<option value="OTHER">Other</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Payment Status<span style="color:red;">*</span></label>
								<select id="payment_status" name="payment_status" class="form-control custom-select">
									<option value="">Please select..</option>
									<option value="0">Not Paid</option>
									<option value="1">Paid</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group ">
								<label>Location</label>
								<select class="form-control custom-select" name="location" id="location">
									<option value="">Please select..</option>
									@foreach($branches as $branch)
									<option value="{{ $branch->branch }}"
										{{ (old('location') == $branch->branch ? 'selected': '') }}>
										{{ $branch->branch }}
									</option>
									@endforeach
									<option value="add">Add Value</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Amount<span style="color:red;">*</span></label>
								<input type="text" class="form-control" id="amount"
									placeholder="Please enter the amount" name="amount" />
							</div>
						</div>


						<div class="col-md-4 period" style="display: none">
							<div class="form-group">
								<label>Payment Period<span style="color:red;">*</span></label>
								<select id="payment_period" name="payment_period" class="form-control custom-select">
									<option value="">Please select..</option>
									<option value="daily">daily</option>
									<option value="weekly">weekly</option>
									<option value="monthly">monthly</option>
									<option value="yearly">yearly</option>
								</select>
							</div>
						</div>

						<div class="col-md-4 start" style="display: none">
							<div class="form-group">
								<label>Payment Start Date<span style="color:red;">*</span></label>
								<input type="date" class="form-control" id="start_date" name="payment_start_date"
									value="{{old('start_date')}}">
							</div>
						</div>
						<div class="col-md-4 end" style="display: none">
							<div class="form-group">
								<label>Payment End Date<span style="color:red;">*</span></label>
								<input type="date" class="form-control" id="end_date" name="payment_end_date"
									value="{{old('end_date')}}">
							</div>
						</div>
						<div class="col-md-4" id="reference_no_field" style="display:none">
							<div class="form-group">
								<label>Reference No.<span style="color:red;">*</span></label>
								<input type="text" class="form-control" id="reference_no" name="reference_no"
									placeholder="Please enter the reference no" />
							</div>
						</div>
						<div class="col-md-4" id="bank_name_field" style="display:none">
							<div class="form-group">
								<label>Bank<span style="color:red;">*</span></label>
								<input type="text" class="form-control" id="bank_name" name="bank_name"
									placeholder="Please enter the bank name" />
							</div>
						</div>

						<div class="col-md-4" id="cheque_number_field" style="display:none">
							<div class="form-group">
								<label>Cheque Number<span style="color:red;">*</span></label>
								<input type="text" class="form-control" id="cheque_number" name="cheque_number"
									placeholder="Please enter the check no." />
							</div>
						</div>

						<div class="col-md-4" id="branch_name_field" style="display:none">
							<div class="form-group">
								<label>Branch<span style="color:red;">*</span></label>
								<input type="text" class="form-control" id="branch_name" name="branch_name"
									placeholder="Please enter the branch name" />
							</div>
						</div>

						<div class="col-md-4" id="cheque_date_field" style="display:none">
							<div class="form-group">
								<label>Cheque Issue Date<span style="color:red;">*</span></label>
								<input type="date" class="form-control" id="cheque_date" name="cheque_date"
									placeholder="Please select the cheque issue date" />
							</div>
						</div>
						<div class="col-md-4" id="payment_method_field" style="display:none">
							<div class="form-group">
								<label>Payment Method<span style="color:red;">*</span></label>
								<input type="text" class="form-control" id="payment_method" name="payment_method"
									placeholder="Please enter the method name" />
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 text-right mb-30 mt-30">
					<button type="submit" id="donationForm"
						class="ui {{ Laralum::settings()->button_color }} submit button"><span
							id="hide_donation_text">{{ trans('laralum.save') }}</span>&nbsp;
						<span class="donationForm" style="display:none;"><img
								src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
					</button>
				</div>
				<div class="history_data" style="display:none;">
				</div>

			</form>
		</div>
	</div>
	<div class="three wide column"></div>
</div>


<!-- Add Details Modal start-->
<div id="AddDetails" class="modal fade" role="dialog">
	<div class="modal-dialog modal-sm">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Detail</h4>
			</div>
			<form method="POST" enctype="multipart/form-data" id="add_detail" action="javascript:void(0)">
				<div class="modal-body">
					<div class="form-group">
						<label>Add Detail</label>
						<input type="text" name="detail" id="detail" class="form-control" />
						<input type="hidden" name="type" id="detail_type" class="form-control" />
					</div>
					<div class="form-group">
						<button type="submit" id="editMemberForm" class="ui teal submit button"><span
								id="hidebutext">Add</span>&nbsp;
							<span class="editMemberForm" style="display:none;"><img
									src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="{{ asset('crm_public/js/donation-script.js') }}" type="text/javascript"></script>
<script>
	$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
<script type="text/javascript">
	/**
		 *@author {Previous devloper}
		 *@updatedBy {Paras}
		 *@description {Function to handle payment method field selection}
	*/
	$(function () {
        $("#payment_mode").change(function () {
            if ($(this).val() == "CHEQUE") {
                $("#cheque_date_field").show();
                $("#bank_name_field").show();
                $("#cheque_number_field").show();
                $("#branch_name_field").show();
			} 
			else if($(this).val() == "OTHER"){
				$("#payment_method_field").show();               
			}
			else if ($(this).val() == "QRCODE") {
                $("#reference_no_field").show();               
            }
			else {
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
				$("#branch_name_field").hide();
				$("#payment_method_field").hide();
				$("#reference_no_field").hide();
            }
        });		
		
	});
	
function stateChange(object) {
var value=object.value;
if(value=='recurring'){
	$('.start').show();
	$('.end').show();
	$('.period').show();
}
else{
	$('.start').hide();
	$('.end').hide();
	$('.period').hide();
}
}

$(document).on('change', '#member_type_id', function(e) {
	//Selected value
	var inputValue = $(this).val();
		//Ajax for calling php function
			if ('add' == inputValue){
			$("#detail_type").val(1);
		$("#AddDetails").modal("show");
	}
});
$('#location').change(function(){
		//Selected value
		var inputValue = $(this).val();
		//Ajax for calling php function
		 if ('add' == inputValue){
			$("#detail_type").val(4);
	  $("#AddDetails").modal("show");
  }
});
$(document).on('submit', '#add_detail', function (e) {
		e.preventDefault();
		// 	e.preventDefault();
		$("#AddDetails").modal("hide");

		var detail = $('#detail').val();
		if (detail == '') {
			swal('Warning!', 'Please enter value', 'warning');
			return false;
		}

		var type = "POST";
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		var formData=new FormData(this);
		var my_url='';
		
		if($('#detail_type').val()==3){
			my_url=APP_URL + '/console/manage/departmentData';
			formData.append('department',detail);
		}
		else if($('#detail_type').val()==4){
			my_url=APP_URL + '/console/manage/branchData';
			formData.append('branch',detail);
		}
		else
		 my_url = APP_URL + '/console/manage/memberData';
		var type = "POST";
		$.ajax({
			type: type,
			url: my_url,
			data: formData,
			processData: false,
			contentType: false,
			dataType: 'json',
			success: function (data) {
				swal({
					title: "Success!",
					text: "Data has been submited!",
					type: "success"
				}, function () {
					location.reload();
				});
			},
			error: function (data) {
				swal('Error!', data, 'error')
			}
		});
	});
</script>
<style>
	.card {
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
		transition: 0.3s;
		border-radius: 5px;

		padding: 5px;
		background-color: white;
	}

	.card:hover {
		box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
	}
</style>
@endsection