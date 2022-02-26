@extends('hyper.layout.master')
@section('title', "Campaign View")
@section('content')
<div class="container-fluid p x-3">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::campaign') }}"><i class="uil-home-alt"></i>Campaign</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
                <h4 class="page-title">Campaign View</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">
        <div class="col-sm-2 mb-2 mb-sm-0">
            <div class="card">
                <div class="card-head">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                            <span class="d-none d-md-block">Telephonic settings</span>
                        </a>
                        <a class="nav-link active show" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                            <span class="d-none d-md-block">Campaign</span>
                        </a>
                    </div>
                </div> 
            </div> 
        </div> 

        <div class="col-sm-10">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-0">Nothing to show..</p>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade active show" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="card">
                        <div class="card-body">
                            <a class="btn btn-primary float-right" href="{{ route('Crm::campaign') }}"> Back to List &nbsp;<i class="uil-external-link-alt"></i></a>
                            <h4 class="header-title">Outbound Campaign</h4>
                            <p class="">P2P calls and pre-recorded voice messages or IVR based campaigns for your customers</p>
                            <div class="table-responsive">
                                @php
                                    $startDate = date_create($campValue['start_date']);
                                    $endDate = date_create($campValue['end_date']);
                                @endphp
                                <div class="m-3 p-3 border border-secondary rounded">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="">
                                                <h3 class="">{{ $campValue['name'] }} &nbsp;|&nbsp; <span class="bg-gray">
                                                    {{ date_format($startDate, "M d, Y") }} to 
                                                    {{ date_format($endDate, "M d, Y") }}</span>
                                                </h3>
                                            </div>
                                            <div class="">
                                                <i class="uil-calendar-alt"></i>&nbsp;
                                                <span>{{ ucwords($campValue['days']) }}  &nbsp;&nbsp;
                                                <i class="uil-clock"></i>
                                                <span class="bg-gray">
                                                    {{ $campValue['start_time'] }}  to  
                                                    {{ $campValue['end_time'] }}
                                            </div>
                                        </div>
                                        <h5 class="col-lg-2">
                                            <b>Status</b> :
                                            @if($campValue['status'] == 1)
                                                <span class="badge badge-success badge-pill">Active</span>
                                            @else
                                                <span class="badge badge-warning badge-pill">Draft</span>
                                            @endif
                                        </h5>
                                        <div class="col-lg-12">
                                            <table class="table table-striped dt-responsive nowrap w-100">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>&nbsp;
                                                        <th>Member ID</th>&nbsp;
                                                        <th>Phone</th>&nbsp;
                                                        <th>Created Date</th>&nbsp;
                                                        <th>Agent</th>&nbsp;
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($LeadsData as $leads)
                                                    <tr>
                                                        <td>{{$leads->name}}</td>
                                                        <td>{{$leads->member_id}}</td>
                                                        <td>{{$leads->mobile}}</td>
                                                        <td>{{$leads->created_at}}</td>
                                                        <td>{{$leads->agentName}}</td>
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
    <!-- end page content --> 
</div>  
@endsection
@section('extrascripts')
   
@endsection