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
   <?php
        if(isset($user_detail)){
           $monthly_comp_cost = (($user_detail->anual_ctc)*($user_detail->basic_perc)/(1200)) + (($user_detail->anual_ctc)*($user_detail->hra_perc)/(1200)) + (($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(1200)) - ((($user_detail->anual_ctc)*($user_detail->advance_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->pf_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->esi_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->pt_percentage)/(1200)) );
           
           $anual_comp_cost = (($user_detail->anual_ctc)*($user_detail->basic_perc)/(100)) + (($user_detail->anual_ctc)*($user_detail->hra_perc)/(100)) + (($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(100)) - ( (($user_detail->anual_ctc)*($user_detail->pf_percentage)/(100)) + (($user_detail->anual_ctc)*($user_detail->esi_percentage)/(100)) + (($user_detail->anual_ctc)*($user_detail->advance_percentage)/(100)) + (($user_detail->anual_ctc)*($user_detail->pt_percentage)/(100)));

        }       
    ?> 
    <!-- end page title --> 
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3>Basic information</h3><hr>
                    <form class="form-horizontal staff_update" id="Personal_details" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="edit_id" value="{{$id}}">
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mt-1">Annual CTC * </p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group text-right">
                                    <input class="text-right" data-toggle="" id="anual_ctc_value" type="number" value="{{ old('anual_ctc', (isset($user_detail) && !empty($user_detail->anual_ctc) ) ? $user_detail->anual_ctc : 0) }}" name="anual_ctc" data-bts-prefix="₹">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="mt-1">per year </p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3 center">
                                <center><p>Salary Components</p></center>
                            </div>
                            <div class="col-md-3 center">
                                <center><p>Calculation Type</p></center>
                            </div>
                            <div class="col-md-3 center">
                                <center><p>Amount Monthly</p></center>
                            </div>
                            <div class="col-md-3 center">
                                <center><p>Amount Annually</p></center>
                            </div>
                            </hr>
                        </div>
                        <h4>Earnings</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <p>Basic</p>                                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="text-right" name="basic_ctc_percentage" data-toggle="touchspin" value="{{ old('anual_ctc', (isset($user_detail) && !empty($user_detail->basic_perc) ) ? $user_detail->basic_perc : 0) }}" type="text" id="basic_ctc_percentage" data-step="0.1" data-decimals="2" data-bts-postfix="% of CTC">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <input class="text-right" name="monthly_basic_pay" data-toggle="" type="text" id="monthly_basic_pay" value="{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->basic_perc)/(1200) : 0) }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="anual_basic_pay">{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->basic_perc)/(100) : 0) }}</p>
                                </div>
                            </div>
                        </div>   

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <p>House Rent Allowance</p>                                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="text-right" data-toggle="touchspin" value="{{ ((isset($user_detail) && !empty($user_detail->hra_perc) ) ? ($user_detail->hra_perc) : 0) }}" id="hra_percentage" type="text" data-step="0.1" data-decimals="2" data-bts-postfix="% of Basic" name="hra_percentage">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <input class="text-right" data-toggle="" type="text" id="hra_monthly"  value="{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->hra_perc)/(1200) : 0) }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="hra_anualy">{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->hra_perc)/(100) : 0) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <p>Special Allowance</p>                                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input class="text-right" data-toggle="touchspin" value="{{ ((isset($user_detail) && !empty($user_detail->special_allowance_per) ) ? ($user_detail->special_allowance_per) : 0) }}" id="special_allowance_percentage" type="text" data-step="0.1" data-decimals="2" data-bts-postfix="% of Basic" name="special_allowance_percentage">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <input class="text-right" data-toggle="" type="text" id="special_allowance_monthly"  value="{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(1200) : 0) }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="special_allowance_anualy">{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(100) : 0) }}</p>
                                </div>
                            </div>
                        </div>  
                        <h4>Deductions</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <p>EPF - Employer Contribution</p>
                                    <!-- <p>EPS contribution is not enabled</p> -->
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <!-- <p>12.00% of PF Wages </p>  -->
                                    <input class="text-right" data-toggle="touchspin" value="{{ ((isset($user_detail) && !empty($user_detail->pf_percentage) ) ? ($user_detail->pf_percentage) : 0) }}" id="pf_percentage" type="text" data-step="0.1" data-decimals="2" data-bts-postfix="% of CTC" name="pf_percentage">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <input class="text-right" data-toggle="" type="text" id="pf_monthly"  value="{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pf_percentage)/(1200) : 0) }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="pf_anualy">{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pf_percentage)/(100) : 0) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <p>ESI - Employer Contribution</p>                                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <input class="text-right" data-toggle="touchspin" value="{{ ((isset($user_detail) && !empty($user_detail->esi_percentage) ) ? ($user_detail->esi_percentage) : 0) }}" id="esi_percentage" type="text" data-step="0.05" data-decimals="2" data-bts-postfix="% of CTC" name="esi_percentage">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <input class="text-right" data-toggle="" type="text" id="esi_monthly"  value="{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->esi_percentage)/(1200) : 0) }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="esi_anualy">{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->esi_percentage)/(100) : 0) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <p>PT</p>                                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <input class="text-right" data-toggle="touchspin" value="{{ ((isset($user_detail) && !empty($user_detail->pt_percentage) ) ? ($user_detail->pt_percentage) : 0) }}" id="pt_percentage" type="text" data-step="0.05" data-decimals="2" data-bts-postfix="% of CTC" name="pt_percentage">   
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <input class="text-right" data-toggle="" type="text" id="pt_monthly"  value="{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pt_percentage)/(1200) : 0) }}" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="pt_anualy">{{ (isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pt_percentage)/(100) : 0) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <p>Advance</p>                                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group ">
                                    <input class="text-right" data-toggle="touchspin" value="0" id="advance_percentage" type="text" data-step="0.1" data-decimals="2" data-bts-postfix="% of CTC" name="advance_percentage">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <input class="text-right" data-toggle="" type="text" id="advance_monthly"  value="0" disabled="disabled">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="advance_anualy">0</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <p>Cost to Company</p>                                                
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="monthly_cost_company">{{ $monthly_comp_cost}}</p> 
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group text-right">
                                    <p id="anual_cost_company">{{$anual_comp_cost}}</p> 
                                </div>
                            </div>
                            
                        </div>
                        <ul class="list-inline wizard mb-0">
                            <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Submit</a></li>
                        </ul>

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



@endsection
@section('extrascripts')
<script>
    $(document).ready(function () { 
        $("#anual_ctc_value").on('change',function(){
            update_salary_calculations();
        })
        $("#basic_ctc_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#hra_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#special_allowance_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#pf_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#esi_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#advance_percentage").on('change',function(){
            update_salary_calculations();
        })
        $("#pt_percentage").on('change',function(){
            update_salary_calculations();
        }) 
    });
    function update_salary_calculations(){
        var anual_ctc = $("#anual_ctc_value").val();
        var basic_percentage = $('#basic_ctc_percentage').val(); 
        var hra_percentage = $('#hra_percentage').val();
        var special_allowance_percentage = $('#special_allowance_percentage').val();

        var pf_percentage = $('#pf_percentage').val();
        var esi_percentage = $('#esi_percentage').val();
        var advance_percentage = $('#advance_percentage').val();
        var pt_percentage = $('#pt_percentage').val();

        var basic_anual_pay = (anual_ctc * basic_percentage)/(100);
        var basic_monthly_pay = (basic_anual_pay)/(12);

        var hra_anual_pay = (anual_ctc * hra_percentage)/(100);
        var hra_monthly_pay = (hra_anual_pay)/(12);

        var special_allowance_anualy = (anual_ctc * special_allowance_percentage)/(100);
        var special_allowance_monthly = (special_allowance_anualy)/(12);


        var pf_anualy = (anual_ctc * pf_percentage)/(100);
        var pf_monthly = (pf_anualy)/(12);

        var esi_anualy = (anual_ctc * esi_percentage)/(100);
        var esi_monthly = (esi_anualy)/(12);

        var advance_anualy = (anual_ctc * advance_percentage)/(100);
        var advance_monthly = (advance_anualy)/(12);

        var pt_anual_pay = (anual_ctc * pt_percentage)/(100);
        var pt_monthly_pay = (pt_anual_pay)/(12);

        $('#pt_monthly').val((pt_monthly_pay).toFixed(2)); 
        $('#pt_anualy').text((pt_anual_pay).toFixed(2));


        $('#pf_monthly').val((pf_monthly).toFixed(2)); 
        $('#pf_anualy').text((pf_anualy).toFixed(2));

        $('#esi_monthly').val((esi_monthly).toFixed(2)); 
        $('#esi_anualy').text((esi_anualy).toFixed(2));

        $('#advance_monthly').val((advance_monthly).toFixed(2)); 
        $('#advance_anualy').text((advance_anualy).toFixed(2));


        $('#monthly_basic_pay').val((basic_monthly_pay).toFixed(2)); 
        $('#anual_basic_pay').text((basic_anual_pay).toFixed(2)); 
      
        $('#hra_monthly').val((hra_monthly_pay).toFixed(2)); 
        $('#hra_anualy').text((hra_anual_pay).toFixed(2)); 

        $('#special_allowance_monthly').val((special_allowance_monthly).toFixed(2)); 
        $('#special_allowance_anualy').text((special_allowance_anualy).toFixed(2)); 

        var monthly_cost_company = (basic_monthly_pay + hra_monthly_pay + special_allowance_monthly) - (pf_monthly + esi_monthly + advance_monthly + pt_monthly_pay);
        var anual_cost_company = (basic_anual_pay + hra_anual_pay + special_allowance_anualy) - (pf_anualy + esi_anualy + advance_anualy + pt_anual_pay);
        $('#monthly_cost_company').text((monthly_cost_company).toFixed(2)); 
        $('#anual_cost_company').text((anual_cost_company).toFixed(2));
    }

    $(document).ready(function () {
        $('.staff_update').submit(function (e) {
            e.preventDefault();
            $( ".btn" ).prop( "disabled", true );
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var formData=new FormData(this);
            
            my_url = "{{ route('Crm::Update_salary_information') }}";
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


</script>
@endsection