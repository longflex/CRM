@extends('hyper.layout.master')
@section('title', "Donation Create")
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
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
                <h4 class="page-title">Donation Create</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="justify-content-between align-items-center">
                        <div class="app-search">
                            <div class="form-group position-relative">
                                <input type="text" class="form-control search-inp" id="search_from_leads"
                                name="search_from_leads" placeholder="Search member by 'Email' or 'Phone' or 'Member ID'">
                                <span class="mdi mdi-magnify search-icon"></span>
                            </div>
                            <span class="search_loader" style="display:none;"><img src="{{ asset('/crm_public/images/search_loader.png') }}"></span>
                            <span id="search_text_error" style="color:red;display:none;">Please Enter 'Email' or 'Phone
                                No. or Member ID'</span>
                        </div>   
                    </div>
                    <form id="upload_donation_form" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="search_check" name="search_check" value="0">
                        @csrf
                        <div class="lead_data" style="display:none;">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Donation Type *</label>
                                    <select id="member_type_id" name="donation_type" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
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
                                    <select id="donation_purpose" name="donation_purpose" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
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
                                    <select id="donation_decision" name="donation_decision" class="form-control select2" onchange="decisionChange(this)" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        <option value="0" {{ (old('donation_decision') == 0 ? 'selected': '') }}>
                                            Now</option>
                                        <option value="1" {{ (old('donation_decision') == 1 ? 'selected': '') }}>Will Donate</option>
                                        {{-- <option value="2" {{ (old('donation_decision') == 1 ? 'selected': '') }}>Already Donate</option> --}}
                                        <option value="2" {{ (old('donation_decision') == '2' ? 'selected': '') }}>Already Donate</option>
                                    </select>
                                </div>
                            </div>
                            
                            
{{--                         
                            <div class="col-lg-4" id="donation_date_div" style="display: none;">
                                <div class="form-group">
                                    <label for="donation_date">Donation Date</label>
                                    <input type="text" class="form-control" id="donation_date" name="donation_date">
                                </div>
                            </div> --}}
                            {{-- <div class="col-lg-4" id="donation_date_div1" style="display: none;"> --}}
                            <div class="col-md-4" id="will_donate_type_div" style="display: none;">
                            <div class="form-group">
                                <label>Willing To Donate</label>
                                <select id="donation_decision_type" name="donation_decision_type" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
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


                            <div class="col-lg-4" id="donation_date_div" style="display: none;">
                                <div class="form-group">
                                    <label for="donation_date">Donation Date</label>
                                    <input type="text" readonly class="form-control" id="donation_date" name="donation_date">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Payment Type</label>
                                    <select id="payment_type" name="payment_type" class="form-control select2" onchange="stateChange(this)" data-toggle="select2" data-placeholder="Please select..">
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
                                    <select id="payment_mode" name="payment_mode" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
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
                            <div class="col-md-4 payment-status" style="display: none">
                                <div class="form-group">
                                    <label>Payment Status</label>
                                    <select id="payment_status" name="payment_status" class="form-control select2" data-toggle="select2" data-placeholder="Please select..">
                                        <option value="">Please select..</option>
                                        <option value="0">Not Paid</option>
                                        <option value="1">Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <label>Location</label>
                                    <select class="form-control select2" name="location" id="location" data-toggle="select2" data-placeholder="Please select..">
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
                                    <input type="text" class="form-control" id="amount" placeholder="Please enter the amount" name="amount" />
                                </div>
                            </div>
                            <div class="col-md-4 period" style="display: none">
                                <div class="form-group">
                                    <label>Payment Period</label>
                                    <select id="payment_period" name="payment_period" class="form-control select2">
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
                                    <label>Payment Start Date</label>
                                    <input type="text" class="form-control" readonly id="start_date" name="payment_start_date" value="{{old('start_date')}}" />
                                </div>
                            </div>
                            <div class="col-md-4 end" style="display: none">
                                <div class="form-group">
                                    <label>Payment End Date</label>
                                    <input type="text" class="form-control" readonly id="end_date" name="payment_end_date" value="{{old('end_date')}}" />
                                </div>
                            </div>
                            <div class="col-md-4" id="reference_no_field" style="display:none">
                                <div class="form-group">
                                    <label>Reference No. *</label>
                                    <input type="text" class="form-control" id="reference_no" name="reference_no" placeholder="Please enter the reference no" />
                                </div>
                            </div>
                            <div class="col-md-4" id="bank_name_field" style="display:none">
                                <div class="form-group">
                                    <label>Bank *</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Please enter the bank name" />
                                </div>
                            </div>
                            <div class="col-md-4" id="cheque_number_field" style="display:none">
                                <div class="form-group">
                                    <label>Cheque Number *</label>
                                    <input type="text" class="form-control" id="cheque_number" name="cheque_number" placeholder="Please enter the check no." />
                                </div>
                            </div>
                            <div class="col-md-4" id="branch_name_field" style="display:none">
                                <div class="form-group">
                                    <label>Branch *</label>
                                    <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Please enter the branch name" />
                                </div>
                            </div>
                            <div class="col-md-4" id="cheque_date_field" style="display:none">
                                <div class="form-group">
                                    <label>Cheque Issue Date</label>
                                    <input type="text" class="form-control" readonly id="cheque_date" name="cheque_date" placeholder="Please select the cheque issue date" />
                                </div>
                            </div>
                            <div class="col-md-4" id="payment_method_field" style="display:none">
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <input type="text" class="form-control" id="payment_method" name="payment_method" placeholder="Please enter the method name" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gift Issued</label>
                                    <select id="gift_issued" name="gift_issued" class="form-control select2">
                                        <option value="">Please select..</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="save_admin_donation" class="btn btn-success btn-sm">SAVE</button>
                        <div class="history_data" style="display:none;">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Details Modal -->
<div id="AddDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addDetailsModalLabel">Add Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="add_detail" action="javascript:void(0)">@csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Add Detail</label>
                        <input type="text" name="detail" id="detail" class="form-control" />
                        <input type="hidden" name="type" id="detail_type" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editMemberForm" class="btn btn-success btn-sm"><span id="hidebutext">Add</span>&nbsp;<span class="editMemberForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('extrascripts')
<script>
 

$(function() {
  $('input[name="payment_start_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="payment_start_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});

$(function() {
  $('input[name="payment_end_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="payment_end_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});


$(function() {
  $('input[name="cheque_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="cheque_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});
$(function() {
  $('input[name="donation_date"]').daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: false,
    autoApply: false,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10)
  });
  $('input[name="donation_date"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY'));

    });
});


$(document).ready(function() {  
    
    $("#search_from_leads").on("keypress",function (event) {    
        if(event.which == 13){
           let key = $(this).val();    
           if(key==''){
              $("#search_text_error").css("display","block");
              return;
           }        
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
               }
           })   
           var APP_URL="{{route('Crm::dashboard')}}";
          var my_url = APP_URL+'/search_member';      
          if(key && key.length > 3){
           $(".search_loader").css("display","block");
           $.ajax({
               type: "POST",
               url:my_url,
               data: { key: key },
               success : function (response) {
                  $("#search_check").val('1');
                  $("#search_from_leads").val('');
                  $(".search_loader").css("display","none");
                  $('.lead_data').html(response.data);
                  $(".lead_data").css("display","block");   
                  $('.history_data').html(response.history);
                  $(".history_data").css("display","block");               
               }
            });
          }else{
              $("#search_from_leads").empty();
          }
        } 
   });


});

$("#upload_donation_form").submit(function(event){
    event.preventDefault();
    $( ".btn" ).prop( "disabled", true );
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        
        //doantion var
        var donation_type = $('#donation_type').val();
        var payment_mode = $('#payment_mode').val();
        var amount = $('#amount').val();
        var reference_no = $('#reference_no').val();
        var bank_name = $('#bank_name').val();
        var cheque_number = $('#cheque_number').val();
        var branch_name = $('#branch_name').val();
        var cheque_date = $('#cheque_date').val();
        var donation_purpose = $('#donation_purpose').val();
        
        var searched_member_id = $('#searched_member_id').val();
        var search_check = $('#search_check').val();

        var donation_decision = $('#donation_decision').val();
        
        if(searched_member_id==""){
            // if(payment_mode=="CHEQUE"){         
            //     if(name=='' || email=='' || phone=='' || address=='' || donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
            //        //swal('warning!','All (*) mark fields are mandatory.','error')
            //        $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
            //       return false;
            //     }
            // }else if(payment_mode=="QRCODE"){
            //     if(name=='' || email=='' || phone=='' || address=='' || amount=='' || reference_no==''){
            //       // swal('warning!','All (*) mark fields are mandatory.','error')
            //       $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
            //       return false;
            //     }
            // }else{
            //     if(name=='' || email=='' || phone=='' || address=='' || amount==''){
            //        //swal('warning!','All (*) mark fields are mandatory.','error')
            //        $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
            //       return false;
            //     }
            // }
        }else{
            if(search_check=="0"){
                $.NotificationApp.send("Error","Please search member first.","top-center","red","error");
                $( ".btn" ).prop( "disabled", false );
                return false;
            }
            if(donation_decision=="Now"){
                if(payment_mode=="CHEQUE"){         
                    if(donation_type=='' || amount=='' || bank_name=='' || cheque_number=='' || branch_name=='' || cheque_date==''){
                       //swal('warning!','All (*) mark fields are mandatory.','error')
                       $.NotificationApp.send("Error","All (*) mark fields are mandatory.","top-center","red","error");
                       $( ".btn" ).prop( "disabled", false );
                      return false;
                    }
                }else if(payment_mode=="QRCODE"){
                    if(amount=='' || reference_no==''){
                       //swal('warning!','All (*) mark fields are mandatory.','error')
                       $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
                       $( ".btn" ).prop( "disabled", false );
                      return false;
                    }
                }else{
                    if(amount==''){
                       //swal('warning!','All (*) mark fields are mandatory.','error')
                       $.NotificationApp.send("Error","All (*) mark fields are mandatory","top-center","red","error");
                       $( ".btn" ).prop( "disabled", false );
                      return false;
                    }
                }
            }
            
        }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $("#hide_donation_text").css('display','none');
    $(".donationForm").css('display','inline-block');
    var formData=new FormData(this);
    $.ajax({
        type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
        url:  "{{route('Crm::donation_store')}}",
        data:formData ,
        dataType: 'json', // what type of data do we expect back from the server
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        dataType: 'json',
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
            $(".donationForm").css('display','none');
            $("#hide_donation_text").css('display','inline-block'); 
            $.NotificationApp.send("Success","The donation has been created!","top-center","green","success");
            setTimeout(function(){
                //location.reload();
                //var url = "{{route('Crm::leads')}}";
                //location.href=url;
            }, 3500);
            $("#save_admin_donation").attr("disabled", true);
        }

    })
    // using the fail promise callback
    .fail(function(data) {
        $.NotificationApp.send("Error",data.message,"top-center","red","error");
        setTimeout(function(){
            //location.reload();
        }, 3500);
    });

})

</script>

<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
<script>
    $(function() {
        $("#payment_mode").change(function() {
            if ($(this).val() == "CHEQUE") {
                $("#cheque_date_field").show();
                $("#bank_name_field").show();
                $("#cheque_number_field").show();
                $("#branch_name_field").show();
                $(".payment-status").show();
                $("#reference_no_field").hide();
                $("#payment_method_field").hide();
            } else if ($(this).val() == "OTHER") {
                $("#payment_method_field").show();
                $(".payment-status").show();
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#reference_no_field").hide();
            } else if ($(this).val() == "QRCODE") {
                $("#reference_no_field").show();
                $(".payment-status").show();
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#payment_method_field").hide();
            } else if ($(this).val() == "CASH") {
                $(".payment-status").show();
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#reference_no_field").hide();
                $("#payment_method_field").hide();
            } else if ($(this).val() == "CARD") {
                $(".payment-status").show();
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#reference_no_field").hide();
                $("#payment_method_field").hide();
            } else {
                $("#cheque_date_field").hide();
                $("#bank_name_field").hide();
                $("#cheque_number_field").hide();
                $("#branch_name_field").hide();
                $("#payment_method_field").hide();
                $("#reference_no_field").hide();
                $(".payment-status").hide();
            }
        });

    });

    function stateChange(object) {
        var value = object.value;
        if (value == 'recurring') {
            $('.start').show();
            $('.end').show();
            $('.period').show();
        } else {
            $('.start').hide();
            $('.end').hide();
            $('.period').hide();
        }
    }
    function decisionChange(object) {
        var value = object.value;
        if (value == 0) {
            $('#donation_date_div').hide();
            $('#will_donate_type_div').hide();
        }
        else if (value == 2){
            $('#donation_date_div').hide();
            $('#will_donate_type_div').hide();
        }
         else {
            $('#donation_date_div').show();
            $('#will_donate_type_div').show();
        }
    }


// ---------------------------------Close-----------

    //     function decisionChange(object) {
    //     var value = object.value;
    //     if (value == 0) {
    //         $('#donation_date_div').hide();
    //         $('#will_donate_type_div').hide();
    //     } if(value==1) {
    //         $('#donation_date_div').show();
    //         $('#will_donate_type_div').show();
    //     }
    //     if(value== 'Already Donate'){
    //         $('#donation_date_div').show();
    //         $('#payment_status').show();
    //     }
    //     else{
    //         $('#donation_date_div').hide();
    //         $('#payment_status').hide();
    //     }
    // }



// donation_decision

    // function donationdecisionChange(object) {
    //     var value = object.value;
    //     if (value == Already Donate ) {
    //         $('#donation_date_div').hide();
    //         $('#payment_status').hide();
    //     } else {
    //         $('#donation_date_div').show();
    //         $('#payment_status').show();
    //     }
    // }

    // function decisionChange(object) {
    //     var value = object.value;
    //     if (value == 'Now') {
    //         $('#donation_date_div1').hide();
    //     } else {
    //         $('#donation_date_div1').show();
    //     }
    // }

    $(document).on('change', '#member_type_id', function(e) {
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue) {
            $("#detail_type").val(1);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });
    $('#location').change(function() {
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue) {
            $("#detail_type").val(4);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });

    $('#donation_purpose').change(function() {
        //Selected value
        var inputValue = $(this).val();
        //Ajax for calling php function
        if ('add' == inputValue) {
            $("#detail_type").val(2);
            $("#AddDonation").modal("hide");
            $("#AddDetails").modal("show");
        }
    });

    $(document).on('submit', '#add_detail', function(e) {
        e.preventDefault();
        //  e.preventDefault();
        $("#AddDetails").modal("hide");

        var detail = $('#detail').val();
        if (detail == '') {
            $.NotificationApp.send("Error",'Please enter value',"top-center","red","error");
            return false;
        }

        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        var formData = new FormData(this);
        var my_url = '';
        var APP_URL="{{route('console::console')}}";
        if ($('#detail_type').val() == 3) {
            my_url = APP_URL + '/manage/departmentData';
            formData.append('department', detail);
        } else if ($('#detail_type').val() == 4) {
            my_url = APP_URL + '/manage/branchData';
            formData.append('branch', detail);
        } else if ($('#detail_type').val() == 2) {
            my_url = APP_URL + '/manage/insertDonationpurpose';
            formData.append('purpose', detail);
        } else
            my_url = APP_URL + '/manage/memberData';
        var type = "POST";
        var addText=$('#detail').val();
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if(data.status==true){
                   if($('#detail_type').val()==1){
                    $('#member_type_id').val(null).trigger('change');
                    $("#member_type_id option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==2){
                        $('#donation_purpose').val(null).trigger('change');
                        $("#donation_purpose option:last").before("<option value="+data.id+">"+addText+"</option>");
                    }else if($('#detail_type').val()==4){
                        $('#location').val(null).trigger('change');
                        $("#location option:last").before("<option value="+addText+">"+addText+"</option>");
                    } 
                }
                $.NotificationApp.send("Success","Data has been submited!","top-center","green","success");
                setTimeout(function(){
                    //location.reload();   
                }, 3500);

                $('#AddDonation').modal('show');
            },
            error: function(data) {
                $.NotificationApp.send("Error",data,"top-center","red","error");
                
            }
        });
    });
    
    // $("#donation_decision").on("change", function() { 
    //     // console.log("hi");
    //     var selecteditem=$(this).val();
    //     // console.log(selecteditem);
    //     if(selecteditem=='Now'){
    //         $("#filter_by_donation_decision_type").show();
    //     }
    //     else{
    //         $("#filter_by_donation_decision_type").hide();
    //     }
    // });
    // function decisionChange(object) {
    //     var value = object.value;
    //     if (value == 0) {
    //         $('#donation_date_div').hide();
    //         $('#will_donate_type_div').hide();
    //     } else {
    //         $('#donation_date_div').show();
    //         $('#will_donate_type_div').show();
    //     }
    // }

</script>
@endsection