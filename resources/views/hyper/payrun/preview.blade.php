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
                    <div class="row">
                      <div class="col-md-4">
                        <div class="card">
                          <div class="card-body">
                            <div> Period: <strong>{{ date("F, Y", strtotime($payment_date)) }}</strong> | {{$no_of_days}} Payable Days </div>
                            <div class="row">
                              <div class="col-md-6">
                                <h4>₹{{number_format($payroll_cost,2)}}</h4>
                                <h6>PAYROLL COST</h6>
                              </div>
                              <div class="col-md-6">
                                <h4>₹{{number_format($net_monthly_comp_cost,2)}}</h4>
                                <h6>EMPLOYEE'S NET PAY</h6>
                              </div>   
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2">
                        <div class="card">
                          <div class="card-body">
                            <div align="center">
                              <div class="text-uppercase">Pay Day</div>
                              <h4>{{ date("d", strtotime($payment_date)) }}</h4>
                              <div class="text-uppercase">{{ date("F, Y", strtotime($payment_date)) }}</div>
                              <hr>
                                <div class="">
                                  {{$employee_count}} Employees
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="mt-3">Deductions</div>
                        <div class="row mt-1">
                          <div class="col-md-3">
                            Total Deduction
                          </div>
                          <div class="col-md-6">
                            <strong>₹{{number_format($total_deduction,2)}}</strong>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 text-right">
                        <button class="btn btn-light button_delete">Delete Payroll</button>
                      </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs nav- bordered mb-3">
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <li class="nav-item">
                                    <a href="#Overview" id="Overview-tab" class="nav-link active" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Employee Summary</span></a>
                                </li>
                                @endif
                                @if(Laralum::hasPermission('laralum.lead.view'))
                                <!-- <li class="nav-item">
                                    <a href="#Salary" id="Salary-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Tax and Deduction</span></a>
                                </li> -->
                                @endif
                                @if(Laralum::hasPermission('laralum.donation.view'))
                                <!-- <li class="nav-item">
                                    <a href="#Payslips" id="Payslips-tab" class="nav-link" data-toggle="tab" aria-expanded="false"><span class="d-none d-md-block">Tax and Deduction</span></a>
                                </li> -->
                                @endif
                            </ul>
                            <div class="tab-content">    
                                <div class="tab-pane tab_status active" id="Overview">
                                  <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                                   
                                            <table class="table table-bordered border-none">
                                                <tbody>
                                                    <tr>      
                                                        <td>Employee Name</td>
                                                        <td>Gross Pay</td>
                                                        <td>Deductions</td>
                                                        <td>Net Pay</td>
                                                        <td>Payslips</td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
<!-- //`payslips` `id``employee_id``name``payment_date``joining_date``anual_ctc``basic_percentage``hra_percentage``special_allowance_per``pf_percentage``esi_percentage``advance_percentage``pt_percentage`   -->                                                  
                                                        @foreach($payslips as $payslip)
                                                        <tr style="font-weight:bold">
                                                            <td width="30%">{{$payslip->name}}</td>
                                                            <td width="30%">{{number_format(((($payslip->anual_ctc)*($payslip->basic_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->hra_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->special_allowance_per)/(1200))),2) }}
                                                            </td>
                                                            <td width="40%" align="left">{{ number_format(((($payslip->anual_ctc)*($payslip->advance_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->pf_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->esi_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->pt_percentage)/(1200))),2)}}
                                                            </td>
                                                            
                                                            <td>{{number_format(((($payslip->anual_ctc)*($payslip->basic_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->hra_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->special_allowance_per)/(1200)) - ((($payslip->anual_ctc)*($payslip->advance_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->pf_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->esi_percentage)/(1200)) + (($payslip->anual_ctc)*($payslip->pt_percentage)/(1200))) ),2)}}
                                                            </td>
                                                            <td width="30%" align="left"><a class="btn btn-sm btn-light" href="{{ route('Crm::payslip_preview', ['id' => $payslip->id]) }}">View</a></td>
                                                        </tr>
                                                        @endforeach
                                              
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                  </div>     

                                </div>
                            
                                <!-- <div class="tab-pane tab_status" id="Payslips">
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
                                                        <td width="40%" align="left">₹{{ $net_monthly_comp_cost }}</td>
                                                        <td width="30%">{{ date("d/m/Y", strtotime($payment_date)) }}</td>
                                                        <td width="30%" align="left">{{$employee_count}}</td>
                                                    </tr>                                      
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-4 mt-4" >
                                            <center><a href="" class="btn btn-primary">View Details</a></center>
                                        </div>
                                    </div> 
                                    
                                </div> -->
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
$(document).on('click', '.button_delete', function (e) {
    e.preventDefault();
    var payment_date = '{{$payment_date}}';
    //alert(11);return;
    const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You want to delete this Paryroll !!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: "{{route('Crm::delete-payroll')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "payment_date":payment_date
                },
                success: function (data) {
                        $.NotificationApp.send("Success","Paryroll has been deleted.","top-center","green","success");
                        setTimeout(function(){
                            location.href = "{{ route('Crm::staff') }}";
                        }, 3500);
                    }, error: function (data) {
                        $.NotificationApp.send("Error","Paryroll has not been deleted.","top-center","red","error");
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    },
                });
            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Paryroll not deleted !',
                    'error'
                )
            }
        });
    });   
</script>


@endsection