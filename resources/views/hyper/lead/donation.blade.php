
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Donation Type *</label>
            <select id="incoming_member_type_id" name="incoming_donation_type" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                <option value="">Please select..</option>
                @foreach($membertypes as $type)
                <option value="{{ $type->type }}" {{ (old('donation_type') == $type->type ? 'selected': '') }}>
                    {{ $type->type }}
                </option>
                @endforeach
                <option value="add">Add Value</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Donation Purpose</label>
            <select id="incoming_donation_purpose" name="incoming_donation_purpose" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                <option value="">Please select..</option>
                @foreach($donation_purposes as $purpose)
                <option value="{{ $purpose->id }}" {{ (old('donation_purpose') == $purpose->id ? 'selected': '') }}>
                    {{ $purpose->purpose }}
                </option>
                @endforeach
                <option value="add">Add Value</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>When Will Donate</label>
            <select id="incoming_donation_decision" name="incoming_donation_decision" class="form-control select2" onchange="incoming_decisionChange(this)" data-toggle="select2" data-placeholder="Please select..">
                <option value="">Please select..</option>
                <option value="0" {{ (old('donation_decision') == 0 ? 'selected': '') }}>Now</option>
                <option value="1" {{ (old('donation_decision') == 1 ? 'selected': '') }}>Will Donate</option>
                <option value="2" {{ (old('donation_decision') == '2' ? 'selected': '') }}>Already Donate</option>
            </select>
        </div>
    </div>
    <div class="col-md-4" id="incoming_will_donate_type_div" style="display: none;">
        <div class="form-group">
            <label>Willing To Donate</label>
            <select id="incoming_donation_decision_type" name="incoming_donation_decision_type" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                <option value="">Please select..</option>
                <option value="As soon As Possible" {{ (old('donation_decision') == 'As soon As Possible' ? 'selected': '') }}>
                    As soon As Possible</option>
                <option value="This Week" {{ (old('donation_decision') == 'This Week' ? 'selected': '') }}>This Week</option>
                <option value="This Year" {{ (old('donation_decision') == 'This Year' ? 'selected': '') }}>This Year</option>
                <option value="Next Year" {{ (old('donation_decision') == 'Next Year' ? 'selected': '') }}>Next Year</option>
                <option value="online" {{ (old('donation_decision') == "online" ? 'selected': '') }}>online</option>
                <option value="Jan" {{ (old('donation_decision') == "Jan" ? 'selected': '') }}>Jan</option>
                <option value="Feb" {{ (old('donation_decision') == "Feb" ? 'selected': '') }}>Feb</option>
                <option value="Mar" {{ (old('donation_decision') == "Mar" ? 'selected': '') }}>Mar</option>
                <option value="Apr" {{ (old('donation_decision') == "Apr" ? 'selected': '') }}>Apr</option>
                <option value="May" {{ (old('donation_decision') == "May" ? 'selected': '') }}>May</option>
                <option value="Jun" {{ (old('donation_decision') == "Jun" ? 'selected': '') }}>Jun</option>
                <option value="July" {{ (old('donation_decision') == "July" ? 'selected': '') }}>July</option>
                <option value="Aug" {{ (old('donation_decision') == "Aug" ? 'selected': '') }}>Aug</option>
                <option value="Sep" {{ (old('donation_decision') == "Sep" ? 'selected': '') }}>Sep</option>
                <option value="Oct" {{ (old('donation_decision') == "Oct" ? 'selected': '') }}>Oct</option>
                <option value="Nov" {{ (old('donation_decision') == "Nov" ? 'selected': '') }}>Nov</option>
                <option value="Dec" {{ (old('donation_decision') == "Dec" ? 'selected': '') }}>Dec</option>
            </select>
        </div>
    </div>


    <div class="col-lg-4" id="incoming_donation_date_div" style="display: none;">
        <div class="form-group">
            <label for="donation_date">Donation Date</label>
            <input type="text" readonly class="form-control" id="incoming_donation_date" name="incoming_donation_date">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Payment Type</label>
            <select id="incoming_payment_type" name="incoming_payment_type" class="form-control select2" onchange="incoming_stateChange(this)" data-toggle="select2" data-placeholder="Please select..">
                <option value="">Please select..</option>
                <option value="single" {{ (old('payment_type') == 'single' ? 'selected': '') }}>
                    Single</option>
                <option value="recurring" {{ (old('payment_type') == 'recurring' ? 'selected': '') }}>Recurring</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Payment Mode</label>
            <select id="incoming_payment_mode" name="incoming_payment_mode" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                <option value="">Please select..</option>
                <option value="CASH">Cash</option>
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
    <div class="col-md-4 incoming_payment-status" style="display: none">
        <div class="form-group">
            <label>Payment Status</label>
            <select id="incoming_payment_status" name="incoming_payment_status" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                <option value="">Please select..</option>
                <option value="0">Not Paid</option>
                <option value="1">Paid</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group ">
            <label>Location</label>
            <select class="form-control select2" name="incoming_location" id="incoming_location" data-toggle="select2" data-placeholder="Please select..">
                <option value="">Please select..</option>
                @foreach($branches as $branch)
                <option value="{{ $branch->branch }}" {{ (old('location') == $branch->branch ? 'selected': '') }}>
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
            <label>Amount *</label>
            <input type="text" class="form-control" id="incoming_amount" placeholder="Please enter the amount" name="incoming_amount" />
        </div>
    </div>
    <div class="col-md-4 incoming_period" style="display: none">
        <div class="form-group">
            <label>Payment Period</label>
            <select id="incoming_payment_period" name="incoming_payment_period" class="form-control select2">
                <option value="">Please select..</option>
                <option value="daily">daily</option>
                <option value="weekly">weekly</option>
                <option value="monthly">monthly</option>
                <option value="yearly">yearly</option>
            </select>
        </div>
    </div>
    <div class="col-md-4 incoming_start" style="display: none">
        <div class="form-group">
            <label>Payment Start Date</label>
            <input type="text" class="form-control" readonly id="incoming_start_date" name="incoming_payment_start_date" value="{{old('start_date')}}" />
        </div>
    </div>
    <div class="col-md-4 incoming_end" style="display: none">
        <div class="form-group">
            <label>Payment End Date</label>
            <input type="text" class="form-control" readonly id="incoming_end_date" name="incoming_payment_end_date" value="{{old('end_date')}}" />
        </div>
    </div>
    <div class="col-md-4" id="incoming_reference_no_field" style="display:none">
        <div class="form-group">
            <label>Reference No. *</label>
            <input type="text" class="form-control" id="incoming_reference_no" name="incoming_reference_no" placeholder="Please enter the reference no" />
        </div>
    </div>
    <div class="col-md-4" id="incoming_bank_name_field" style="display:none">
        <div class="form-group">
            <label>Bank *</label>
            <input type="text" class="form-control" id="incoming_bank_name" name="incoming_bank_name" placeholder="Please enter the bank name" />
        </div>
    </div>
    <div class="col-md-4" id="incoming_cheque_number_field" style="display:none">
        <div class="form-group">
            <label>Cheque Number *</label>
            <input type="text" class="form-control" id="incoming_cheque_number" name="incoming_cheque_number" placeholder="Please enter the check no." />
        </div>
    </div>
    <div class="col-md-4" id="incoming_branch_name_field" style="display:none">
        <div class="form-group">
            <label>Branch *</label>
            <input type="text" class="form-control" id="incoming_branch_name" name="incoming_branch_name" placeholder="Please enter the branch name" />
        </div>
    </div>
    <div class="col-md-4" id="incoming_cheque_date_field" style="display:none">
        <div class="form-group">
            <label>Cheque Issue Date</label>
            <input type="text" class="form-control" readonly id="incoming_cheque_date" name="incoming_cheque_date" placeholder="Please select the cheque issue date" />
        </div>
    </div>
    <div class="col-md-4" id="incoming_payment_method_field" style="display:none">
        <div class="form-group">
            <label>Payment Method</label>
            <input type="text" class="form-control" id="incoming_payment_method" name="incoming_payment_method" placeholder="Please enter the method name" />
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Gift Issued</label>
            <select id="incoming_gift_issued" name="incoming_gift_issued" class="form-control select2">
                <option value="">Please select..</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
    </div>
</div>
  
<script>
$(function() {
    $("#incoming_payment_mode").change(function() {
        if ($(this).val() == "CHEQUE") {
            $("#incoming_cheque_date_field").show();
            $("#incoming_bank_name_field").show();
            $("#incoming_cheque_number_field").show();
            $("#incoming_branch_name_field").show();
            $(".incoming_payment-status").show();
            $("#incoming_reference_no_field").hide();
            $("#incoming_payment_method_field").hide();
        } else if ($(this).val() == "OTHER") {
            $("#incoming_payment_method_field").show();
            $(".incoming_payment-status").show();
            $("#incoming_cheque_date_field").hide();
            $("#incoming_bank_name_field").hide();
            $("#incoming_cheque_number_field").hide();
            $("#incoming_branch_name_field").hide();
            $("#incoming_reference_no_field").hide();
        } else if ($(this).val() == "QRCODE") {
            $("#incoming_reference_no_field").show();
            $(".incoming_payment-status").show();
            $("#incoming_cheque_date_field").hide();
            $("#incoming_bank_name_field").hide();
            $("#incoming_cheque_number_field").hide();
            $("#incoming_branch_name_field").hide();
            $("#incoming_payment_method_field").hide();
        } else if ($(this).val() == "CASH") {
            $(".incoming_payment-status").show();
            $("#incoming_cheque_date_field").hide();
            $("#incoming_bank_name_field").hide();
            $("#incoming_cheque_number_field").hide();
            $("#incoming_branch_name_field").hide();
            $("#incoming_reference_no_field").hide();
            $("#incoming_payment_method_field").hide();
        } else if ($(this).val() == "CARD") {
            $(".incoming_payment-status").show();
            $("#incoming_cheque_date_field").hide();
            $("#incoming_bank_name_field").hide();
            $("#incoming_cheque_number_field").hide();
            $("#incoming_branch_name_field").hide();
            $("#incoming_reference_no_field").hide();
            $("#incoming_payment_method_field").hide();
        } else {
            $("#incoming_cheque_date_field").hide();
            $("#incoming_bank_name_field").hide();
            $("#incoming_cheque_number_field").hide();
            $("#incoming_branch_name_field").hide();
            $("#incoming_payment_method_field").hide();
            $("#incoming_reference_no_field").hide();
            $(".incoming_payment-status").hide();
        }
    });

}); 

function incoming_stateChange(object) {
    var value = object.value;
    if (value == 'recurring') {
        $('.incoming_start').show();
        $('.incoming_end').show();
        $('.incoming_period').show();
    } else {
        $('.incoming_start').hide();
        $('.incoming_end').hide();
        $('.incoming_period').hide();
    }
}
$(function() {
  $('input[name="incoming_payment_start_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: true,
    drops: ('up'),
    //showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="incoming_payment_start_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});

$(function() {
  $('input[name="incoming_payment_end_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: true,
    drops: ('up'),
    //showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="incoming_payment_end_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});


$(function() {
  $('input[name="incoming_cheque_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: true,
    drops: ('up'),
    //showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="incoming_cheque_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});
$(function() {
  $('input[name="incoming_donation_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: true,
    drops: ('up'),
    //showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="incoming_donation_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
}); 


$(document).on('change', '#incoming_member_type_id', function(e) {
    var inputValue = $(this).val();
    if ('add' == inputValue) {
        $("#incoming_detail_type").val(1);
        $("#callDetails").modal("hide");
        $("#incoming_AddDetails").modal("show");
    }
});
$('#incoming_location').change(function() {
    var inputValue = $(this).val();
    if ('add' == inputValue) {
        $("#incoming_detail_type").val(4);
        $("#callDetails").modal("hide");
        $("#incoming_AddDetails").modal("show");
    }
});
$('#incoming_donation_purpose').change(function() {
    var inputValue = $(this).val();
    if ('add' == inputValue) {
        $("#incoming_detail_type").val(2);
        $("#callDetails").modal("hide");
        $("#incoming_AddDetails").modal("show");
    }
});
$('#incoming_call_purpose').change(function() {
    var inputValue = $(this).val();
    if ('add' == inputValue) {
        $("#incoming_detail_type").val(5);
        $("#callDetails").modal("hide");
        $("#incoming_AddDetails").modal("show");
    }
});   
</script>
