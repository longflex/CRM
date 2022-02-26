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
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations') }}"><i class="uil-home-alt"></i>Donation</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('Crm::donations_report') }}">Donation Report</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div>
                <h4 class="page-title">Donation Details</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    
                    <a href="{{ url()->previous() }}#Donations" class="btn btn-primary hidden-print pull-right mt-20 ml-5"><span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>Back</a>
                    <button class="btn btn-primary hidden-print pull-right mt-20" onclick="window.print()">
                    <span class="glyphicon glyphicon-print" aria-hidden="true"></span> Print</button>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3 main-cer-area">
                                <div class="row">
                                    <div class="col-md-3">
                                    <div class="main-logo">
                                        <img src="{{ asset('console_public/data/organization') }}/{{ $org_profile->organization_logo }}" class="img-responsive center-block" align="left" width="100" />
                                    </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="cer-header">
                                            <h3 class="font-22">{{ ucfirst($org_profile->organization_name) }}</h3>
                                            <p><b><small>{{ $org_profile->company_address_line1 }}, {{ $org_profile->company_address_line2 }}</small></b></p>
                                        </div>
                                    
                                    </div>												
                                    <div class="col-md-12 cer-header-border"></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered border-none">
                                            <tbody>
                                                <tr style="font-weight:bold">
                                                    <td width="23%" align="left">Receipt No.</td>
                                                    <td width="5%">:</td>
                                                    <td width="23%" align="left">{{ $donations->receipt_number }}</td>
                                                    <td width="28%" align="left">Receipt Date:</td>
                                                    <td width="5%">:</td>
                                                    <td width="23%" align="left">{{ date("d/m/Y", strtotime($donations->created_at )) }}</td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="20%" align="left">Name</td>
                                                    <td width="5%">:</td>
                                                    <td width="23%" align="left">{{ $donations->name }}</td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="23%" align="left">Phone No.</td>
                                                    <td width="5%">:</td>
                                                    <td width="23%" align="left">{{ $donations->mobile }}</td>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <td width="23%" align="left">Address</td>
                                                    <td width="5%">:</td>
                                                    <td colspan="4" align="left">{{ $donations->address }}</td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="23%" align="left">Amount</td>
                                                    <td width="5%">:</td>
                                                    <td colspan="4" align="left">Rs. {{ $donations->amount }} <small>( {{ $amount }})</small></td>
                                                </tr>
                                                
                                                <tr style="font-weight:bold">
                                                    <td width="30%" align="left">Payment Mode</td>
                                                    <td width="5%">:</td>
                                                    <td width="23%" align="left">{{ $donations->payment_mode }}</td>
                                                </tr>
                                                <tr style="font-weight:bold">
                                                    <td width="30%" align="left">Payment Status</td>
                                                    <td width="5%">:</td>
                                                    <td width="23%" align="left">{{ $donations->payment_status ? 'Paid' : 'Not Paid' }}</td>
                                                </tr>
                                                
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





@endsection
@section('extrascripts')
<script>

</script>
@endsection    