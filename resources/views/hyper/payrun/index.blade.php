@extends('hyper.layout.master')
@section('title', "Payrun")
@section('content')

<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::staff') }}"><i class="uil-home-alt"></i> staff</a></li>
                        <li class="breadcrumb-item active">Payrun</li>
                    </ol>
                </div>
                <h4 class="page-title">Pay Runs</h4> 
            </div>
        </div>
    </div> 
    <!-- end page title -->
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row" id="user_id" data-id="">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs nav- bordered mb-3">
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <li class="nav-item">
                                    <a href="#Overview" id="Overview-tab" class="nav-link active" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Run Payroll</span></a>
                                </li>
                                @endif
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <!-- <li class="nav-item">
                                    <a href="#Salary" id="Salary-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Tax and Deduction</span></a>
                                </li> -->
                                @endif
                                @if(Laralum::hasPermission('laralum.donation.view'))
                                <li class="nav-item">
                                    <a href="#Payslips" id="Payslips-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Payroll History</span></a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content">    
                                <div class="tab-pane tab_status active" id="Overview">
                                    <div>Process Pay Run for <strong><span>{{ date("F, Y", strtotime($payment_date)) }}</span></strong></div> 
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table border-none">
                                                <tbody>
                                                    <tr>
                                                        <td>Employees' Net Pay</td>
                                                        <td>Payment Date</td>
                                                        <td>No. of Employees</td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr style="font-weight:bold">
                                                        <td width="40%" align="left">₹{{number_format($net_monthly_comp_cost,2) }}</td>
                                                        <td width="30%">{{ date("d/m/Y", strtotime($payment_date)) }}</td>
                                                        <td width="30%" align="left">{{$employee_count}}</td>
                                                    </tr>                                      
                                                </tbody>
                                            </table>
                                        </div>
                                        <form method="GET" action="{{ route('Crm::staff.payrun.preview') }}">
                                            
                                            <input type="hidden" name="payment_date" value="{{$payment_date}}">
                                            <div class="col-md-4 mt-4" >
                                                <center><button type="submit" class="btn btn-primary">View Details</button></center>
                                            </div>
                                        </form>
                                        
                                    </div>   
                                    

                                    
                                </div>
                            
                                <div class="tab-pane tab_status" id="Payslips">
                                    <div class="col-lg-10">
                                        <div class="card">
                                            <div class="card-body">
                                                       
                                                <table class="table table-bordered border-none">
                                                    <tbody>
                                                        <tr>
                                                            <td>Payment Date</td>
                                                            <td>Month</td>
                                                            <td>Payslips</td>
                                                        </tr>
                                                    </tbody>
                                                    <tbody>
                                                        
                                                            @foreach($payslips as $payslip)
                                                            <tr style="font-weight:bold">
                                                                <td width="40%" align="left">{{ date("d/m/Y", strtotime($payslip->payment_date)) }}</td>
                                                                <td width="30%">{{ date("F, Y", strtotime($payslip->payment_date)) }}</td>
                                                                <td width="30%" align="left">
                                                                    <form method="GET" action="{{ route('Crm::staff.payrun.preview') }}">
                                                                        
                                                                        <input type="hidden" name="payment_date" value="{{$payslip->payment_date}}">
                                                                        <div class="col-md-4" >
                                                                            <button type="submit" class="btn btn-sm btn-light">View</button>
                                                                        </div>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                  
                                                    </tbody>
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
        </div>
    </div>
    <!-- end page content -->
</div>


<div id="generatePayslip" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn btn-sm btn-light float-right Close" data-dismiss="modal" aria-hidden="true">X</button>
            </div>
            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" id="generatePayslipForm" action="javascript:void(0)">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label>Payment Date</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date">
                    </div>
                    <ul class="list-inline wizard mb-0">
                        <li class="next list-inline-item float-right"><button type="submit" class="btn btn-primary">Submit</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@section('extrascripts')
<script> 
   
</script>


@endsection