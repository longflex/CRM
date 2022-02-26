@extends('hyper.layout.master')
@section('title', "Staff Edit")
@section('content')
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::staff') }}"><i class="uil-home-alt"></i> staff</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ old('name', isset($user) ? $user->name : '') }}</h4>
            </div>
        </div>
    </div>

    
    <!-- end page title --> 
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Payment Information</h4><hr>
                    <form class="ui form staff_update" id="Payment_info" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="edit_id" value="{{$id}}">
                        <input type="hidden" name="form_id" value="5">
                        @csrf
                        <input type="hidden" id="manual_diposit_option" name="manual_diposit" value="{{ (isset($user_detail) ? $user_detail->manual_diposit: 0) }}">
                        <input type="hidden" id="cheque_diposit_option" name="cheque_diposit" value="{{ (isset($user_detail) ? $user_detail->cheque_diposit: 0) }}">
                        <h4>How would you like to pay this employee?<span class="red-txt">*</span></h4>
                        <?php 
                            $payment_status_check1=$payment_status_check2="";
                            if($user_detail->manual_diposit == 1){ $payment_status_check1="checked";}else{$payment_status_check1="";}

                            if($user_detail->cheque_diposit == 1){ $payment_status_check2="checked";}else{$payment_status_check2="";}
                        ?>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <a href="javascript:void(0);" class="mark_check">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <i class="dripicons-home font-30"></i>
                                                </div>
                                                <div class="col-md-8">
                                                    <p>Bank Transfer (Manual Process)</p>
                                                    <p>Download Bank Advice and process the payment through your bank's website</p>
                                                </div>
                                                <div class="col-md-2">
                                                    <i class="uil-check-circle manual_color font-30" onclick="payment_type_manage(1)" style="<?php if(isset($user_detail) && $user_detail->manual_diposit == 1){echo "color: blue;";}?>"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-12" id="bank_payment" style="<?php if(isset($user_detail) && $user_detail->manual_diposit != 1){echo "display: none;";}?>">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Account Holder Name <span class="red-txt">*</span></label>
                                                    <input type="text" class="form-control" id="manual_ac_holder_name" name="ac_holder_name" value="{{ (isset($user_detail) ? $user_detail->ac_holder_name: '') }}" >
                                                </div>    
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Bank Name <span class="red-txt">*</span></label>
                                                    <input type="text" class="form-control" id="manual_bank_name" name="bank_name" value="{{ (isset($user_detail) ? $user_detail->bank_name: '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Account Number <span class="red-txt">*</span></label>
                                                    <input type="password" class="form-control" id="manual_ac_no" name="ac_no" value="{{ (isset($user_detail) ? $user_detail->ac_no: '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Re-enter Account Number <span class="red-txt">*</span></label>
                                                    <input type="password" class="form-control" id="manual_confirm_ac_no" name="manual_confirm_ac_no" value="{{ (isset($user_detail) ? $user_detail->ac_no: '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>IFSC <span class="red-txt">*</span></label>
                                                    <input type="text" class="form-control" id="manual_ifsc" name="ifsc" value="{{ (isset($user_detail) ? $user_detail->ifsc: '') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Account Type <span class="red-txt">*</span></label><br>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio3" name="ac_type" class="custom-control-input" value="Current" <?php if($user_detail->ac_type == "Current"){ echo "checked";
                                                        }?>>
                                                        <label class="custom-control-label" for="customRadio3">Current</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="customRadio4" name="ac_type"  value="Savings" class="custom-control-input" <?php if($user_detail->ac_type == "Savings"){ echo "checked";
                                                        }?>>
                                                        <label class="custom-control-label" for="customRadio4">Savings</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="javascript:void(0);" class="mark_check">
                                        <div class="row">
                                            <div class="col-md-2"> 
                                                <i class="uil-money-stack font-30"></i>
                                            </div>
                                            <div class="col-md-8">
                                                <p>Cheque</p>
                                            </div>
                                            <div class="col-md-2">
                                                <i class="uil-check-circle check_color font-30" onclick="payment_type_manage(2)" style="<?php if(isset($user_detail) && $user_detail->manual_diposit != 1){echo "color: blue;";}?>"></i>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <ul class="list-inline wizard mb-0">
                                <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Submit</a></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="numberCopy" style="display: none;">
    <div class="row">
        <div class="col-10">
            <div class="form-group">
                <label>Alternate Number</label>
                <input type="text" class="form-control" name="alt_mobile[]" />
            </div>
        </div>
        <div class="col-2">
            <div class="addnum-btn-div">
                <button class="btn btn-sm btn-danger family-add-btn remove_alt" type="button"><i class="uil-minus-circle"></i></button>    
            </div>
        </div>
    </div>
</div>




<!-- copy of experience input fields group -->

<div class="work_fieldmoreCopy row"  style="display: none;">
    <div class="add2-inp-div">
        <div class="form-group">
            <label>Previous Company Name</label>
            <input type="text" class="form-control" name="exp_company_name[]"/>
        </div>
    </div>

    <div class="add2-inp-div">
        <div class="form-group">
            <label>Job Title</label>
            <input type="text" class="form-control" name="exp_job_title[]"/>
        </div>
    </div>
    
    <div class="add2-inp-div">
        <div class="form-group">
            <label>From Date</label>
            <input type="date" class="form-control" name="exp_from_date[]"/>
        </div>
    </div>
    <div class="add2-inp-div">
        <div class="form-group">
            <label>To Date</label>
            <input type="date" class="form-control" name="exp_to_date[]"/>
        </div>
    </div>
    <div class="add2-inp-div">
        <div class="form-group">
            <label>Job Description</label>
            <input type="text" class="form-control" name="exp_job_desc[]"/>
        </div>
    </div>

    <div class="add-btn-div  mb-2">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>
<!-- copy of experience input fields group -->

<!-- copy of education input fields group -->
<div class="education_fieldmoreCopy row"  style="display: none;">
    <div class="add1-inp-div">
        <div class="form-group">
            <label>School Name</label>
            <input type="text" class="form-control" name="edu_school_name[]">
        </div>
    </div>

    <div class="add1-inp-div">
        <div class="form-group">
            <label>Degree/Diploma</label>
            <input type="text" class="form-control" name="edu_degree[]">
        </div>
    </div>



    <div class="add1-inp-div">
        <div class="form-group">
            <label>Field(s) of Study</label>
            <input type="text" class="form-control" name="edu_branch[]">
        </div>
    </div>

    <div class="add1-inp-div">
        <div class="form-group">
            <label>Date of Completion</label>
            <input type="date" class="form-control" name="edu_completion_date[]">
        </div>
    </div>
        
    <div class="add1-inp-div">
        <div class="form-group">
            <label>Additional Notes</label>
            <input type="text" class="form-control" name="edu_add_note[]">
        </div>
    </div>
    <div class="add1-inp-div">
        <div class="form-group">
            <label>Interests</label>
            <input type="text" class="form-control" name="edu_interest[]">
        </div>
    </div>

    <div class="add-btn-div  mb-2">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>
<!-- copy of education input fields group -->


<!-- copy of input fields group -->
<div class="fieldmoreCopy row" style="display: none;">

    <div class="add-inp-div col-3">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" name="staff_relation_name[]">
        </div>
    </div>

    <div class="add-inp-div col-3">
        <div class="form-group">
            <label>Relationship</label>
            <input type="text" class="form-control" name="staff_relation[]">
        </div>
    </div>

    <div class="add-inp-div col-3">
        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" class="form-control" name="staff_relation_dob[]">
        </div>
    </div>

    <div class="add-inp-div col-2">
        <div class="form-group">
            <label>Mobile</label>
            <input type="text" class="form-control" name="staff_relation_mobile[]">
        </div>
    </div>

    <div class="add-btn-div  mb-2 col-1">
        <a href="javascript:void(0);" class="btn btn-sm btn-danger family-add-btn remove"
            onclick="$('.dimmer').removeClass('dimmer')"><i class="uil-minus-circle"></i></a>
    </div>
</div>

<!-- Add Details Modal start-->
<div id="AddDetails" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title" id="topModalLabel">Add Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="add_detail" action="javascript:void(0)">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Add Detail</label>
                        <input type="text" name="detail" id="detail" class="form-control" />
                        <input type="hidden" name="type" id="detail_type" class="form-control" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" id="editMemberForm" class="btn btn-primary">Save changes</button>
                        <!-- <span id="hidebutext">Add</span>&nbsp; -->
                        <span class="editMemberForm" style="display:none;"><img
                                    src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('extrascripts')
<script>
    function payment_type_manage(check){
        if(check == 1){
            $('#manual_diposit_option').val(1);
            $('#cheque_diposit_option').val(0);
            $('#bank_payment').show();
            $(".manual_color").css("color", "blue");
            $(".check_color").css("color", "black");
        }else if(check == 2){
            $('#manual_diposit_option').val(0);
            $('#cheque_diposit_option').val(1);
            $('#bank_payment').hide();
            $(".manual_color").css("color", "black");
            $(".check_color").css("color", "blue");
        }
    }




    $('#manual_ac_no').bind("cut copy paste",function(e) {
        e.preventDefault();
    });
    $('#manual_confirm_ac_no').bind("cut copy paste",function(e) {
        e.preventDefault();
    });
    //employee_provident_fund
    if($("#employee_provident_fund").prop('checked')){
        $('#employee_provident_fund_fields').show();
    }else{
        $('#employee_provident_fund_fields').hide();
    }
    $("#employee_provident_fund").click(function(){
        if($("#employee_provident_fund").prop('checked')){
            $('#employee_provident_fund_fields').show();
        }else{
            $('#employee_provident_fund_fields').hide();
        }
    });

    $(document).ready(function () {
        set_inclusions();
    });
    var e_inclusion_count = 0;
    function set_inclusions(){
        var id='{{$id}}';//alert(id);return;
        var type = "post";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        my_url = "{{ route('Crm::get_tags_data') }}";
        $.ajax({
            type: type,
            url: my_url,
            data: {id:id},
            //processData: false,
            //contentType: false,
            dataType: 'json',
            success: function (data) {
                //alert();
                $.each(JSON.parse(data.detail),function(key,value){
                  var resultHtml = "";                  

                     resultHtml+='<div class="bullet inclusion-box-'+e_inclusion_count+'">';
                     resultHtml+= value+' <i onclick="e_remove_inclusion('+e_inclusion_count+')" style="cursor: pointer;font-size: 17px;margin-left: 5px;" class="uil-times"></i>';
                     resultHtml+='<input type="hidden" name="tags[]" value="'+value+'" >';
                     resultHtml+='</div>';
                    $('#e_more_inclusions').append(resultHtml);
                    e_inclusion_count++;
                })
            }, error: function (data) {
                // $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                // setTimeout(function(){
                //     //location.reload();
                // }, 3500);
            },
        });
    }

    function e_add_more_inclusions(){
        var resultHtml = "";                  
        var tag = $('#e_tag').val();
        resultHtml+='<div class="bullet inclusion-box-'+e_inclusion_count+'">';
        resultHtml+= tag+' <i onclick="e_remove_inclusion('+e_inclusion_count+')" style="cursor: pointer;font-size: 17px;margin-left: 5px;" class="uil-times"></i>';
        resultHtml+='<input type="hidden" name="tags[]" value="'+tag+'" >';
        resultHtml+='</div>';
        $('#e_more_inclusions').append(resultHtml);
        e_inclusion_count++;
        $('#e_tag').val("");
    }
    function e_remove_inclusion(sl){
        $('.inclusion-box-'+sl).remove();
    }

   function remove_inclusions(sl){
        $('.inclusion-boxs-'+sl).remove();
    }
    $(document).ready(function () {
        $('.staff_update').submit(function (e) {
            e.preventDefault();
            $( ".btn" ).prop( "disabled", true );
            var pt = $('#pt').text();
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var formData=new FormData(this);

            formData.append('pt', pt);
            my_url = "{{ route('Crm::Update_payment_information') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                //dataType: 'json',
                success: function (data) {
                    $( ".btn" ).prop( "disabled", false );
                    $.NotificationApp.send("Success","Staff has been updated successfully!","top-center","green","success");
                    // setTimeout(function(){
                    //     location.href = "{{ route('Crm::staff') }}";
                    // }, 3500);
                }, error: function (data) {
                    $( ".btn" ).prop( "disabled", false );
                    $.NotificationApp.send("Error","Something is wrong. Please try again!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        });
    });
    $(document).ready(function(){
        //group add limit
        var maxGroup = 3;

        //add more fields group
        $(".addMoreWork").click(function(){
            if($('body').find('.work_fieldmore').length < maxGroup){
                var fieldHTML = '<div class="work_fieldmore row">'+$(".work_fieldmoreCopy").html()+'</div>';
                $('body').find('.work_fieldmore:last').after(fieldHTML);
            }else{
                Swal.fire(
                    'Maximum',
                    maxGroup +' groups are allowed.',
                    'error'
                    );
            }
        });

        //remove fields group
        $("body").on("click",".remove",function(){ 
            $(this).parents(".work_fieldmore").remove();
        });

        //add more fields group
        $(".addMoreEducation").click(function(){
            if($('body').find('.education_fieldmore').length < maxGroup){
                var fieldHTML = '<div class="education_fieldmore row">'+$(".education_fieldmoreCopy").html()+'</div>';
                $('body').find('.education_fieldmore:last').after(fieldHTML);
            }else{
                Swal.fire(
                    'Maximum',
                    maxGroup +' groups are allowed.',
                    'error'
                    );
            }
        });

        //remove fields group
        $("body").on("click",".remove",function(){ 
            $(this).parents(".education_fieldmore").remove();
        });
        
        
        //add more fields group
        $(".addMore").click(function(){
            if($('body').find('.fieldmore').length < maxGroup){
                var fieldHTML = '<div class="fieldmore row">'+$(".fieldmoreCopy").html()+'</div>';
                $('body').find('.fieldmore:last').after(fieldHTML);
            }else{
                Swal.fire(
                    'Maximum',
                    maxGroup +' groups are allowed.',
                    'error'
                    );
            }
        });

        //remove fields group
        $("body").on("click",".remove",function(){ 
            $(this).parents(".fieldmore").remove();
        });
        //remove address group
        $("body").on("click",".remove_address",function(){ 
            $(this).parents(".addressmore").remove();
        });
        $("body").on("click",".remove_alt",function(){ 
            $(this).parents(".numbermore").remove();
        });
        
        //add more address group
        $(".addAddress").click(function(){
            var length=$('body').find('.addressmore').length;
            if($('body').find('.addressmore').length < maxGroup){
                var clone = $(".addressmore:last").clone();
                clone.find("#state_"+length).attr("id","state_"+(length+1));
                clone.find("#district_"+length).attr("id","district_"+(length+1));
                if($('body').find('.addressmore').length == 1){
                    length=$('body').find('.addressmore').length;
                    clone.find("#state_"+length-1).attr("id","state_"+(length+1));
                    clone.find("#district_"+length-1).attr("id","district_"+(length+1));
                    var btn=clone.find(".addAddress");
                    
                    btn.html('<i class="fa fa-minus"></i>')
                    btn.addClass('btn-danger').removeClass('btn-primary');
                    btn.addClass('remove_address').removeClass('addAddress');
                }
                    var address_type=clone.find('#address_type');
                    address_type.val('temp');
                    var type=clone.find('.header_title');
                    type.text('Temporary Address')
                $('body').find('.addressmore:last').after(clone);
            }else{
                alert('Maximum '+maxGroup+' address are allowed.');
            }
        });
        //add AlternateNumbers
        // $(".addAlternate").click(function(){
        //     if($('body').find('.numbermore').length < maxGroup){
        //         var fieldHTML = '<div class="numbermore">'+$(".numberCopy").html()+'</div>';
        //         $('body').find('.numbermore:last').after(fieldHTML);
        //         //$('#alternetcontainer').append(fieldHTML);
        //     }else{
        //         Swal.fire(
        //             'Maximum',
        //             'error'
        //             );
        //     }
        // });
        

        $(".addAlternate").click(function(){
            if($('body').find('.numbermore').length < maxGroup){
                var fieldHTML = '<div class="col-md-4 numbermore">'+$(".numberCopy").html()+'</div>';
                //$('body').find('.numbermore:last').after(fieldHTML);
                $('#alternetcontainer').append(fieldHTML);
            }else{
                alert('Maximum '+maxGroup+' numbers are allowed.');
            }
        });


        $('#mobile').on('input',function(e){
            var value=$(this).val();
            if(value.length>=10 && value!=$(this).attr('data-old')){
                $('#verify_mobile').show();
            }
        });
        /*send otp*/
        $('#verify_mobile').click(function () {
        if($('#verify_label').text()=='Verified')   {
            return;
        }
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })       
        
        var sender = $("#sender_id").val();
        var receiver_mobile = $("#mobile").val();
        if($('#verify_label').text()!='Verify') {
            if ($('#otp').val() == '') {
                swal('Warning!', 'Please enter Otp!', 'warning')
                return false;
            }
            $('#verify_label').html('Verifying..');
            $.ajax({
                type: 'post',
                url: "{{ route('Crm::verify_otp') }}",
                data: {receiver_mobile:receiver_mobile,otp:$('#otp').val()},
                success: function (data) {          
                    if(data.status=='success'){
                        $('#verify_label').html('Verified');
                        $('#otp').hide(); 
                        
                    }else {             
                        $('#verify_label').html('Wrong Otp! Reverify');
                    }
                }
            });
        }   
        else{
        $('#verify_label').html('SENDING..');
        $.ajax({
            type: 'post',
            url: "{{ route('Crm::send_otp') }}",
            data: {sender:sender,receiver_mobile:receiver_mobile},
            success: function (data) {          
                if(data.status=='success'){
                    $('#verify_label').html('Verify Otp');
                    $('#otp').show(); 
                    //  setTimeout(function(){                          
                    //     location.reload();
                    // }, 3000);
                }else {             
                    $('#verify_label').html('Resend');
                }
            }
        });
    }
        
    });
        
        $('#sms').change(function () {
            if(this.checked)
            $('#sms_language').show();
            else
            $('#sms_language').hide();
        });
        $('#work_title').change(function(){
                //Selected value
            $("#detail_type").val('');
            $("#detail").val('');
            var inputValue = $(this).val();
            //Ajax for calling php function
                if ('add' == inputValue){
                $("#detail_type").val(0);
                $("#AddDetails").modal("show");
            }
        });
        $('#hire_source').change(function(){
                    //Selected value
            $("#detail_type").val('');
            $("#detail").val('');
            var inputValue = $(this).val();
            //Ajax for calling php function
            if ('add' == inputValue){
                $("#detail_type").val(1);
                $("#AddDetails").modal("show");
            }
        });
        $('#staff_type').change(function(){
                    //Selected value
            $("#detail_type").val('');
            $("#detail").val('');
            var inputValue = $(this).val();
            //Ajax for calling php function
            if ('add' == inputValue){
                $("#detail_type").val(2);
                $("#AddDetails").modal("show");
            }
        });
        $('#department').change(function(){
                    //Selected value
            $("#detail_type").val('');
            $("#detail").val('');
            var inputValue = $(this).val();
            //Ajax for calling php function
            if ('add' == inputValue){
                $("#detail_type").val(3);
                $("#AddDetails").modal("show");
            }
        });
        
        $('#work_status').change(function(){
                    //Selected value
            $("#detail_type").val('');
            $("#detail").val('');
            var inputValue = $(this).val();
            //Ajax for calling php function
            if ('add' == inputValue){
                $("#detail_type").val(4);
                $("#AddDetails").modal("show");
            }
        });
        $('#work_location').change(function(){
                    //Selected value
            $("#detail_type").val('');
            $("#detail").val('');
            var inputValue = $(this).val();
            //Ajax for calling php function
            if ('add' == inputValue){
                $("#detail_type").val(5);
                $("#AddDetails").modal("show");
            }
        });

        var APP_URL="{{route('console::console')}}";
        $('#add_detail').submit(function (e) {
        e.preventDefault();
        //  e.preventDefault();
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
        
        
        if($('#detail_type').val()== 0){
            my_url=APP_URL + '/manage/designationAdd';
            formData.append('designation',detail);
        }
        else if($('#detail_type').val()== 1){
            my_url=APP_URL + '/manage/hireOfSource';
            formData.append('source_hire',detail);
        }
        else if($('#detail_type').val()== 2){
            my_url=APP_URL + '/manage/staffTypeAdd';
            formData.append('staff_type',detail);
        }
        else if($('#detail_type').val()==3){
            my_url=APP_URL + '/manage/departmentData';
            formData.append('department',detail);
        }
        else if($('#detail_type').val()== 4){
            my_url=APP_URL + '/manage/workStatusAdd';
            formData.append('work_status',detail);
        }
        else if($('#detail_type').val()== 5){
            my_url=APP_URL + '/manage/workLocationAdd';
            formData.append('work_location',detail);
        }
        else
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
            success: function (data) {
                if(data.status==true){
                    if($('#detail_type').val()==0){
                        $('#work_title').val(null).trigger('change');
                        $("#work_title option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==1){
                        $('#hire_source').val(null).trigger('change');
                        $("#hire_source option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==2){
                        $('#staff_type').val(null).trigger('change');
                        $("#staff_type option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==3){
                        $('#department').val(null).trigger('change');
                        $("#department option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==4){
                        $('#work_status').val(null).trigger('change');
                        $("#work_status option:last").before("<option value="+addText+">"+addText+"</option>");
                    }else if($('#detail_type').val()==5){
                        $('#work_location').val(null).trigger('change');
                        $("#work_location option:last").before("<option value="+addText+">"+addText+"</option>");
                    }  
                }
            },
            error: function (data) {
                swal('Error!', data, 'error')
            }
        });
    });

});
</script>
@endsection