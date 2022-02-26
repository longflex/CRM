@extends('hyper.layout.master')
@section('title', ucfirst($org_profile->organization_name))
@section('content')
<link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset(Laralum::publicPath() .'/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

<link href="{{ asset('crm_public/css/receipt.css') }}" type="text/css" rel="stylesheet" />
   
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
                    
                    <a href="{{route('Crm::staff.payrun.preview', ['payment_date' => $payslips->payment_date])}}" class="btn btn-primary hidden-print pull-right mt-20 ml-5"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>Back</a>
                    <button class="btn btn-primary hidden-print pull-right mt-20" onclick="window.print()">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                        <div class="row">
                            <div class="col-md-11 col-lg-11 col-sm-11 col-xs-11 col-md-offset-1 main-cer-area">
                                <div class="row">
                                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2 mb-0">
                                        <div class="main-logo mb-0">
                                            <img src="{{ asset('console_public/data/organization') }}/{{ $org_profile->organization_logo }}" class="img-responsive center-block" align="left" width="100" />
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
                                        <div class="cer-header">
                                            <h3 class="font-22">{{ ucfirst($org_profile->organization_name) }}</h3>
                                            <p><b><small>{{ $org_profile->company_address_line1 }}, {{ $org_profile->company_address_line2 }}</small></b></p>
                                        </div>
                                    
                                    </div>
                                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">
                                    </div>                                              
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 cer-header-border"></div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <h3>Payslip for the month of {{ date("F, Y", strtotime($payslips->payment_date)) }}</h3>
                                        <h4>Employee Pay Summary</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-7 col-lg-7 col-sm-7 col-xs-7">
                                        <table class="table table-bordered border-none">
                                            <tbody>
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">Employee Name</td>
                                                    <td width="60%">{{ $payslips->name ?? '' }}</td>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">Date of Joining</td>
                                                    <td width="60%">{{ empty($payslips->joining_date) ? 'N.A' : date("d/m/Y", strtotime($payslips->joining_date)) }}</td>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">PAY Period</td>
                                                    <td width="60%">{{ date("F, Y", strtotime($payslips->payment_date)) }}</td>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <td width="40%" align="left">PAY Date</td>
                                                    <td width="60%">{{ date("d/m/Y", strtotime($payslips->payment_date)) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4 modal-box">
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left: 70px;">
                                            Employee Net Pay
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left: 45px; color: green;">
                                            <h1>₹ {{round(($net_pay),2)}}</h1>
                                        </div>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left: 70px;">
                                            Paid Days : 30
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Earnings</th>
                                                    <th>Amount </th>
                                                    <th>Deductions </th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr style="font-weight:bold">
                                                    <td width="25%" align="left">Basic</td>
                                                    <td width="25%"><strong> <p>₹ {{ round((isset($payslips) ? ($payslips->anual_ctc)*($payslips->basic_percentage)/(1200) : 0), 2) }}</p></strong></td>
                                                    <td width="25%" align="left"><strong><p>EPF - Employer Contribution</p></strong></td>
                                                    <td width="25%" align="left"><strong><p>₹ {{ round((isset($payslips) ? ($payslips->anual_ctc)*($payslips->pf_percentage)/(100) : 0), 2)  }}</p></strong></td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="25%" align="left">House Rent Allowance</td>
                                                    <td width="25%"><strong><p>₹ {{ round((isset($payslips) ? ($payslips->anual_ctc)*($payslips->hra_percentage)/(1200) : 0), 2) }}</p></strong></td>
                                                    <td width="25%" align="left"><strong><p>ESI - Employer Contribution</p></strong></td>
                                                    <td width="25%" align="left"><strong><p>₹ {{ round((isset($payslips) ? ($payslips->anual_ctc)*($payslips->esi_percentage)/(100) : 0), 2)  }}</p></strong></td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="25%" align="left">Special Allowance</td>
                                                    <td width="25%"><strong><p>₹ {{ round((isset($payslips) ? ($payslips->anual_ctc)*($payslips->special_allowance_per)/(1200) : 0), 2) }}</p></strong></td>
                                                    <td width="25%" align="left"><strong><p>PT</p></strong></td>
                                                    <td width="25%" align="left"><strong><p> ₹ {{ round((isset($payslips) ? ($payslips->anual_ctc)*($payslips->pt_percentage)/(100) : 0), 2) }}</p></strong></td>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <td width="25%" align="left"></td>
                                                    <td width="25%"></td>
                                                    <td width="25%" align="left"><strong><p>Advance</p></strong></td>
                                                    <td width="25%" align="left"><strong><p> ₹ {{ round((isset($payslips) ? ($payslips->anual_ctc)*($payslips->advance_percentage)/(100) : 0), 2) }}</p></strong></td>
                                                </tr>

                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th width="25%" align="left"><h4>Gross Earnings</h4></th>
                                                    <th width="25%"><strong><p>₹ {{round($gross_earning, 2)}} </p></strong></th>
                                                    <th width="40%" align="left"><h4>Total Deductions</h4></th>
                                                    <th width="25%" align="left"><strong> <p>₹ {{round($total_deduction, 2)}}</p></strong></th>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <strong><p>Total Net Payable ₹ {{round(($net_pay), 2) }}</strong>  ({{$net_pay_word}})</p>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
                                        <p style="margin: auto;">**Total Net Payable = Gross Earnings - Total Deductions </p>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style="margin-left: 343px;">
                                        <p>-- This is system generated payslip. -- </p>
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
<style>
.modal-box {
    width: 500px;
    border: 2px solid #e1e1e1;
    padding: 10px;
    margin: 10px;
}

</style>
<script>

</script>
@endsection    