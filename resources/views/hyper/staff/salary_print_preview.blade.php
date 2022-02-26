@extends('hyper.layout.master')
@section('title', ucfirst($org_profile->organization_name))
@section('content')
<link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset(Laralum::publicPath() .'/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

<link href="{{ asset('crm_public/css/receipt.css') }}" type="text/css" rel="stylesheet" />
<?php
    if(isset($user_detail)){
       $monthly_comp_cost = (($user_detail->anual_ctc)*($user_detail->basic_perc)/(1200)) + (($user_detail->anual_ctc)*($user_detail->hra_perc)/(1200)) + (($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(1200)) - ((($user_detail->anual_ctc)*($user_detail->advance_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->pf_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->esi_percentage)/(1200)) + (($user_detail->anual_ctc)*($user_detail->pt_percentage)/(1200)) );
       
       $anual_comp_cost = (($user_detail->anual_ctc)*($user_detail->basic_perc)/(100)) + (($user_detail->anual_ctc)*($user_detail->hra_perc)/(100)) + (($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(100)) - ( (($user_detail->anual_ctc)*($user_detail->pf_percentage)/(100)) + (($user_detail->anual_ctc)*($user_detail->esi_percentage)/(100)) + (($user_detail->anual_ctc)*($user_detail->advance_percentage)/(100)) + (($user_detail->anual_ctc)*($user_detail->pt_percentage)/(100)));

    }       
?>   
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::staff') }}"><i class="uil-home-alt"></i> staff</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Staff Details</h4>
            </div>
        </div>
    </div> 
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    
                    <a href="{{route('Crm::staff_details', ['id' => $user->id])}}" class="btn btn-primary hidden-print pull-right mt-20 ml-5"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>Back</a>
                    <button class="btn btn-primary hidden-print pull-right mt-20" onclick="window.print()">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-sm-11 col-xs-11 col-md-offset-1 main-cer-area">
                                <div class="row">
                                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3 mb-0">
                                        <div class="main-logo mb-0">
                                            <img src="{{ asset('console_public/data/organization') }}/{{ $org_profile->organization_logo }}" class="img-responsive center-block" align="left" width="100" />
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
                                        <div class="cer-header">
                                            <h3 class="font-22">{{ ucfirst($org_profile->organization_name) }}</h3>
                                            <p><b><small>{{ $org_profile->company_address_line1 }}, {{ $org_profile->company_address_line2 }}</small></b></p>
                                        </div>
                                    
                                    </div>                                              
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 cer-header-border"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <h3>SALARY STRUCTURE</h3>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <table class="table table-bordered border-none">
                                            <tbody>
                                                <tr>
                                                    <td>EMPLOYEE NAME</td>
                                                    <td></td>
                                                    <td>DATE OF JOINING</td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">{{ $user->name ?? '' }}</td>
                                                    <td width="30%"></td>
                                                    <td width="30%" align="left"><strong>{{ date("jS F, Y", strtotime($user_detail->joining_date)) }}</strong></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Salary Components</th>
                                                    <th>Amount Monthly</th>
                                                    <th>Amount Annually</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">Basic</td>
                                                    <td width="30%"><strong> <p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->basic_perc)/(1200) : 0) }}</p></strong></td>
                                                    <td width="30%" align="left"><strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->basic_perc)/(100) : 0) }}</p></strong></td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">House Rent Allowance</td>
                                                    <td width="30%"><strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->hra_perc)/(1200) : 0) }}</p></strong></td>
                                                    <td width="30%" align="left"><strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->hra_perc)/(100) : 0) }}</p></strong></td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">Special Allowance</td>
                                                    <td width="30%"><strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(1200) : 0) }}</p></strong></td>
                                                    <td width="30%" align="left"><strong><p> ₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->special_allowance_per)/(100) : 0) }}</p></strong></td>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">Deductions</td>
                                                    <td width="30%"></td>
                                                    <td width="30%" align="left"></td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left"><strong>EPF - Employer Contribution</strong></td>
                                                    <td width="30%"><strong><p> ₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pf_percentage)/(1200) : 0) }}</p></strong></td>
                                                    <td width="30%" align="left"><strong><p> ₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pf_percentage)/(100) : 0) }}</p></strong></td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left"><strong>ESI - Employer Contribution</strong></td>
                                                    <td width="30%"><strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->esi_percentage)/(1200) : 0) }}</p></strong></td>
                                                    <td width="30%" align="left"><strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->esi_percentage)/(100) : 0) }}</p></strong></td>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left"><strong>PT</strong></td>
                                                    <td width="30%"><strong> <p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pt_percentage)/(1200) : 0) }}</p></strong></td>
                                                    <td width="30%" align="left"><strong> <p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->pt_percentage)/(100) : 0) }}</p></strong></td>
                                                </tr>

                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left"><strong>Advance</strong></td>
                                                    <td width="30%"><strong><p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->advance_percentage)/(1200) : 0) }}</p></strong></td>
                                                    <td width="30%" align="left"><strong> <p>₹ {{ round(isset($user_detail) ? ($user_detail->anual_ctc)*($user_detail->advance_percentage)/(100) : 0) }}</p></strong></td>
                                                </tr>
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th width="40%" align="left"><h4>Cost to Company</h4></th>
                                                    <th width="30%"><strong><p>₹ {{$monthly_comp_cost}}</p></strong></th>
                                                    <th width="30%" align="left"><strong> <p>₹ {{$anual_comp_cost}}</p></strong></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>


                </div>
            </div>
        </div>
    </div>
</div> 





@endsection
@section('extrascripts')
<script>

</script>
@endsection    