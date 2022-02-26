<div class="row">
@php
    $call_sources = ($calls) ? $calls->call_source: '';
    $call_source = ($call_sources == '1') ? 'Incoming': 'Outgoing';
@endphp
    <div class="col-md-10"><strong style="font-size: 18px;">Mobile: {{$mobile}}  <span style="margin-left: 20px;"> Call Type: {{$call_source}} </span></strong></div>
</div>
<div class="row">
    <div class="col-md-2 modal-box1">
        <form id="incoming_call_lead_details_save">@csrf
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="description">Mobile *</label>
                    <input class="form-control" readonly value="{{$mobile}}" name="incoming_mobile"
                        id="incoming_mobile"></input>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="description">Name *</label>
                    <input class="form-control" {{($lead) ? 'readonly': ''}} value="{{($lead) ? $lead->name: ''}}"
                        name="incoming_name" id="incoming_name"></input>
                </div>
            </div>
            @if(!$lead)
            <div class="col-lg-12">
                <center><button type="submit" id="" class="btn btn-success btn-sm">SAVE</button></center>
            </div>
            @endif
        </form>
    </div>
    <div class="col-md-6 modal-box">
        <form id="incoming_call_details_save">@csrf

            <input type="hidden" id="incoming_member_id" name="member_id" value="{{($lead) ? $lead->id: ''}}" />
            <input type="hidden" id="incoming_manual_callLog_id" name="incoming_manual_callLog_id"
                value="{{($calls) ? $calls->id: ''}}" />
            <input type="hidden" id="call_sourse" name="call_sourse"
                value="{{($calls) ? $calls->call_source: ''}}" />
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="create_at">Call Purpose</label>
                        <select {{($lead) ? '': 'disabled'}}  class="form-control select2" name="incoming_call_purpose" id="incoming_call_purpose"
                            onchange="incoming_call_purpose_change(this.value)" data-toggle="select2"
                            data-placeholder="Please select..">
                            <option value="">Please select..</option>
                            <option value="Add Donation">Add Donation</option>
                            <option value="Add Prayer Request">Add Prayer Request</option>
                            <option value="Will Donate">Will Donate</option>
                        </select>
                    </div>
                </div>

                <div class="col-lg-12" id="incoming_add_donation_div">

                </div>
                <div class="col-lg-12" id="incoming_add_prayer_request_div">

                </div>
                @if($calls)
                <div class="col-lg-12">
                    <center><button type="submit" id="" class="btn btn-success btn-sm">SAVE</button></center>
                </div>
                @endif
            </div>
        </form>
    </div>
    <div class="col-md-3 modal-box1">
        <?php $found_data=0;?>
        <label for="description">Recent calls</label>
        <div data-simplebar style="height: 400px;">
            <div class="col-lg-12" id="recent_calls_div">
                <div class="table-responsive">
                    <table class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Purpose</th>
                        </thead>
                        <tbody>
                            @forelse($recent_calls as $key => $value)
                            <tr>
                                <td>{{$value->call_type}}</td>
                                <td>{{$value->duration}}</td>
                                <td>{{$value->call_purpose}}</td>
                            </tr>
                            @empty
                            <?php $found_data=1;?>
                            @endforelse


                        </tbody>
                    </table>
                </div>
                <div>
                    <?php if($found_data==1){?>
                    <center>
                        <p>No Data Found</p>
                    </center>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>    
</div>



<style>
.modal-box {
    width: 500px;
    border: 2px solid #e1e1e1;
    padding: 10px;
    margin: 10px;
}

.modal-box1 {
    width: 300px;
    border: 2px solid #e1e1e1;
    padding: 10px;
    margin: 10px;
}
</style>

<script>
function incoming_call_purpose_change(purpose) {
    //alert(purpose);
    if (purpose == "Add Donation" || purpose == "Will Donate") {
        $.ajax({
            type: "GET",
            url: "{{ route('Crm::incoming_donation_form') }}",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $("#incoming_add_donation_div").html(data);
                $("#incoming_add_prayer_request_div").html('');
            },
            error: function(data) {},
        });

    } else if (purpose == "Add Prayer Request") {
        $.ajax({
            type: "GET",
            url: "{{ route('Crm::incoming_prayer_form') }}",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $("#incoming_add_prayer_request_div").html(data);
                $("#incoming_add_donation_div").html('');
            },
            error: function(data) {},
        });
    } else if (purpose == "Will Donate") {
        $('#incoming_add_donation_div').show();
        //$('#incoming_add_donation_div').hide();
    } else {
        $('#incoming_add_donation_div').hide();
        //$('#will_donate_type_div').show();
    }

}

function incoming_decisionChange(object) {
    var value = object.value;
    if (value == 0) {
        $('#incoming_donation_date_div').hide();
        $('#incoming_will_donate_type_div').hide();
    } else if (value == 2) {
        $('#incoming_donation_date_div').hide();
        $('#incoming_will_donate_type_div').hide();
    } else {
        $('#incoming_donation_date_div').show();
        $('#incoming_will_donate_type_div').show();
    }
}


$("#incoming_call_details_save").submit(function(event) {
    event.preventDefault();
    $(".btn").prop("disabled", true);
    var incoming_call_purpose = $('#incoming_call_purpose').val();
    var incoming_manual_callLog_id = $('#incoming_manual_callLog_id').val();

    if (incoming_call_purpose == "Add Donation" || incoming_call_purpose == "Will Donate") {
        //console.log('fjkfsadhjkfshdfkjfsadh');return;


        var donation_type = $('#incoming_donation_type').val();
        var payment_mode = $('#incoming_payment_mode').val();
        var amount = $('#incoming_amount').val();
        var reference_no = $('#incoming_reference_no').val();
        var bank_name = $('#incoming_bank_name').val();
        var cheque_number = $('#incoming_cheque_number').val();
        var branch_name = $('#incoming_branch_name').val();
        var cheque_date = $('#incoming_cheque_date').val();
        var donation_purpose = $('#incoming_donation_purpose').val();
        var searched_member_id = $('#searched_member_id').val();
        if (searched_member_id == "") {
            if (payment_mode == "CHEQUE") {
                if (donation_type == '' || amount == '' || bank_name == '' || cheque_number == '' ||
                    branch_name == '' || cheque_date == '') {
                    $.NotificationApp.send("Error", "All (*) mark fields are mandatory.", "top-center", "red",
                        "error");
                    $(".btn").prop("disabled", false);
                    return false;
                }
            } else if (payment_mode == "QRCODE") {
                if (amount == '' || reference_no == '') {
                    $.NotificationApp.send("Error", "All (*) mark fields are mandatory.", "top-center", "red",
                        "error");
                    $(".btn").prop("disabled", false);
                    return false;
                }
            } else {
                if (amount == '') {
                    $.NotificationApp.send("Error", "All (*) mark fields are mandatory.", "top-center", "red",
                        "error");
                    $(".btn").prop("disabled", false);
                    return false;
                }
            }
        } else {
            if (payment_mode == "CHEQUE") {
                if (donation_type == '' || amount == '' || bank_name == '' || cheque_number == '' ||
                    branch_name == '' || cheque_date == '') {
                    $.NotificationApp.send("Error", "All (*) mark fields are mandatory.", "top-center", "red",
                        "error");
                    $(".btn").prop("disabled", false);
                    return false;
                }
            } else if (payment_mode == "QRCODE") {
                if (amount == '' || reference_no == '') {
                    $.NotificationApp.send("Error", "All (*) mark fields are mandatory", "top-center", "red",
                        "error");
                    $(".btn").prop("disabled", false);
                    return false;
                }
            }
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $("#hide_donation_text").css('display', 'none');
        $(".donationForm").css('display', 'inline-block');
        var formData = new FormData(this);
        $.ajax({
                type: 'POST',
                url: "{{route('Crm::incoming_call_donation_store')}}",
                data: formData,
                dataType: 'json',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                dataType: 'json',
            })
            .done(function(data) {
                if (data.status == false) {
                    $.NotificationApp.send("Error", data.message, "top-center", "red", "error");
                    setTimeout(function() {}, 3500);
                }
                if (data.status == true) {

                    $(".donationForm").css('display', 'none');
                    $("#hide_donation_text").css('display', 'inline-block');
                    $.NotificationApp.send("Success", "The donation has been created!", "top-center",
                        "green", "success");
                    setTimeout(function() {}, 3500);
                    //$('#callDetails').modal('hide');

                    $('#incoming_member_type_id').val(null).trigger('change');
                    $('#incoming_donation_purpose').val(null).trigger('change');
                    $('#incoming_donation_decision').val(null).trigger('change');
                    $('#incoming_donation_decision_type').val(null).trigger('change');
                    $('#incoming_payment_mode').val(null).trigger('change');
                    $('#incoming_payment_status').val(null).trigger('change');
                    $('#incoming_location').val(null).trigger('change');
                    $('#incoming_gift_issued').val(null).trigger('change');
                    $('#incoming_payment_type').val(null).trigger('change');
                    $('#incoming_payment_period').val(null).trigger('change');
                    $('#incoming_donation_date').val('');
                    $('#incoming_amount').val('');
                    $('#incoming_start_date').val('');
                    $('#incoming_end_date').val('');
                    $('#incoming_reference_no').val('');
                    $('#incoming_bank_name').val('');
                    $('#incoming_cheque_number').val('');
                    $('#incoming_branch_name').val('');
                    $('#incoming_cheque_date').val('');
                    $('#incoming_payment_method').val('');

                }
                $(".btn").prop("disabled", false);
            })
            .fail(function(data) {
                $.NotificationApp.send("Error", data.message, "top-center", "red", "error");
                setTimeout(function() {}, 3500);
                $(".btn").prop("disabled", false);
            });

    } else if (incoming_call_purpose == "Add Prayer Request") {

        $.ajax({
            type: "POST",
            url: "{{ route('Crm::incoming.prayer.request') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'member_id': $("#incoming_member_id").val(),
                'issue': $("#incoming_issue").val(),
                'follow_up_date': $("#incoming_follow_up_date").val(),
                'description': $("#incoming_description").val(),
                'call_sourse': $("#call_sourse").val(),
                'call_purpose': incoming_call_purpose,
                'incoming_manual_callLog_id': incoming_manual_callLog_id,

            },

            success: function(data) {
                $(".btn").prop("disabled", false);
                //$('#callDetails').modal('toggle');
                $.NotificationApp.send("Success", "Prayer Request Created Successfully.",
                    "top-center", "green", "success");
                setTimeout(function() {}, 3500);

            },
            error: function(data) {
                $.NotificationApp.send("Error", "Prayer Request Not Created.", "top-center", "red",
                    "error");
                setTimeout(function() {}, 3500);
                $(".btn").prop("disabled", false);
            },

        });


    }

})

$("#incoming_call_lead_details_save").submit(function(event) {
    event.preventDefault();
    $(".btn").prop("disabled", true);
    var incoming_mobile = $('#incoming_mobile').val();
    var incoming_name = $('#incoming_name').val();

    $.ajax({
        type: "POST",
        url: "{{ route('Crm::incoming.lead.create') }}",
        data: {
            '_token': "{{ csrf_token() }}",
            'mobile': incoming_mobile,
            'name': incoming_name,

        },

        success: function(data) {
            $(".btn").prop("disabled", false);
            $('#incoming_member_id').val(data.lead_id);
            $("#incoming_call_purpose").prop("disabled", false);
            
            //$('#callDetails').modal('toggle');
            $.NotificationApp.send("Success", "Lead Created Successfully.", "top-center", "green",
                "success");
            setTimeout(function() {}, 3500);

        },
        error: function(data) {
            $.NotificationApp.send("Error", "Lead Not Created.", "top-center", "red", "error");
            setTimeout(function() {}, 3500);
            $(".btn").prop("disabled", false);
        },

    });


})
</script>