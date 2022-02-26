@extends('hyper.layout.master')
@section('title', "Leaves")
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('hrcrm/plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link rel='stylesheet prefetch'
      href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css'>
<link rel='stylesheet prefetch'
      href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>

<!-- This is Sidebar menu CSS -->
<link href="{{ asset('hrcrm/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">

<link href="{{ asset('hrcrm/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
<link href="{{ asset('hrcrm/plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet">

<!-- This is a Animation CSS -->
<link href="{{ asset('hrcrm/css/animate.css') }}" rel="stylesheet">
        <!-- This is a Custom CSS -->
<link href="{{ asset('hrcrm/css/style.css') }}" rel="stylesheet">
<!-- color CSS you can use different color css from css/colors folder -->
<!-- We have chosen the skin-blue (default.css) for this starter
   page. However, you can choose any other skin from folder css / colors .
   -->
<link href="{{ asset('hrcrm/css/colors/default.css') }}" id="theme" rel="stylesheet">
<link href="{{ asset('hrcrm/plugins/froiden-helper/helper.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('hrcrm/css/magnific-popup.css') }}">
<link href="{{ asset('hrcrm/css/custom-new.css') }}" rel="stylesheet">

<style>
    .topnav .navbar-nav .nav-link {
        font-size: 15px;
        padding: 17px 22px;
    }
    .dropdown-item {
    display: block;
    width: 100%;
    padding: .575rem 1.5rem;
    clear: both;
    color: #6c757d;
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    font-size: 13px;
    }
    .p-2 {
    padding: 12px !important;
}
.navbar-collapse{
    padding-left: 0px !important;
}
.mr-1{
    margin-right: .5rem!important;
}
.mt-2{
    margin-top: 1.25rem!important;
}
#top-search{
    width: 75%;
}
#top-search-submit{
    height: 38px;
}
</style>
<div class="px-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="uil-home-alt"></i>Home</a></li>
                        <li class="breadcrumb-item active">Leaves</li>
                    </ol>
                </div>
                <h4 class="page-title"> Leaves : {{ count($pendingLeaves)}} Pending Leaves</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <div class="row">

        <div class="col-lg-12">    
            <div class="card">
                <div class="card-body">
                    
                    <div class="row bg-title">
                        
                        <!-- .breadcrumb -->
                        @if(!$pendingLeaves->isEmpty())
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-right">
                            <a href="{{ route('Crm::leaves.all-leaves') }}" class="btn btn-sm btn-info waves-effect waves-light btn-outline">
                                        <i class="fa fa-list"></i> All Leaves
                            </a>

                            <a href="{{ route('Crm::leaves') }}" class="btn btn-sm btn-primary waves-effect waves-light m-l-10 btn-outline">
                                    <i class="fa fa-calendar"></i> Calendar View
                            </a>

                            <a href="{{ route('Crm::leaves.create') }}" class="btn btn-sm btn-success waves-effect waves-light m-l-10 btn-outline">
                            <i class="ti-plus"></i> Assign Leave</a>

                        </div>
                        @endif
                        <!-- /.breadcrumb -->
                    </div> 

                    <div class="row">

                        <div class="col-md-12">

                            <div class="white-box">
                                <div class="">
                                    @forelse($pendingLeaves as $key=>$pendingLeave)
                                        <div class="col-md-3 m-b-25">
                                            <div class=" pending-leaves  p-10">
                                            <h5 class="font-normal">{{ $pendingLeave->type->type_name }} Leave Request @if($pendingLeave->duration == 'half day') 
                                                <label class="label label-danger">Half Day</label> 
                                            @endif
                                            </h5>
                                            <div class="m-b-15">
                                                <span class="m-l-5"><a href="{{ route('Crm::staff_details', $pendingLeave->user_id) }}" >{{  ucwords($pendingLeave->user->name) }}</a></span>
                                            </div>
                                            @php
                                                try{
                                                    //$allowedLeaves = $pendingLeave->user->leaveTypes->sum('no_of_leaves');
                                                    $leavesRemaining = ($allowedLeaves-$pendingLeave->leaves_taken_count);
                                                    $percentLeavesRemaining = ($leavesRemaining/$allowedLeaves) * 100;
                                                }
                                                catch(Exception $e){
                                                    $percentLeavesRemaining = 0;
                                                    $leavesRemaining = 0;
                                                }
                                            @endphp
                                            <div class="text-center bg-light p-t-20 p-b-20 m-l-n-25 m-r-n-25">
                                                {{ $pendingLeave->leave_date->format('d-m-Y') }} ({{ $pendingLeave->leave_date->format('l') }})
                                                <div class="progress m-l-30 m-r-30 m-t-15">
                                                    <div class="progress-bar progress-bar-info" aria-valuenow="{{ $percentLeavesRemaining }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $percentLeavesRemaining }}%" role="progressbar"> <span class="sr-only">{{ $percentLeavesRemaining }}% Complete</span> </div>
                                                </div>

                                                <div class="m-l-30 m-r-30 m-t-15">
                                                    {{ ($leavesRemaining) }} Remaining Leaves
                                                </div>
                                            </div>

                                            <div class="p-t-10">
                                                <h6 class="font-normal">Reason</h6>
                                                <div class="p-b-15 font-12" style="height: 80px; overflow-y: auto;">{{ $pendingLeave->reason }}</div>

                                                <div class="p-t-20 text-center m-l-n-25 m-r-n-25">
                                                    <a href="javascript:;" data-leave-id="{{ $pendingLeave->id }}" data-leave-action="approved" class="btn btn-success btn-rounded m-r-5 leave-action"><i class="fa fa-check"></i> Accept</a>

                                                    <a href="javascript:;" data-leave-id="{{ $pendingLeave->id }}" data-leave-action="rejected" class="btn btn-danger btn-rounded leave-action-reject"><i class="fa fa-times"></i> Reject</a>

                                                </div>

                                            </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div  class="text-center">
                                            <div class="empty-space" style="height: 300px;">
                                                <div class="empty-space-inner">
                                                    <div class="icon" style="font-size:30px"><i
                                                                class="icon-logout"></i>
                                                    </div>
                                                    <div class="title m-b-15">No pending leaves remaining.
                                                    </div>
                                                    <div class="subtitle">
                                                        <a href="{{ route('Crm::leaves.all-leaves') }}" class="btn btn-sm btn-info waves-effect waves-light btn-outline">
                                                            <i class="fa fa-list"></i> All Leaves 
                                                        </a>

                                                        <a href="{{ route('Crm::leaves') }}" class="btn btn-sm btn-primary waves-effect waves-light m-l-10 btn-outline">
                                                            <i class="fa fa-calendar"></i> Calendar View
                                                        </a>

                                                        <a href="{{ route('Crm::leaves.create') }}" class="btn btn-sm btn-success waves-effect waves-light m-l-10 btn-outline">
                                                            <i class="ti-plus"></i> Assign Leave</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse

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

{{--Ajax Modal--}}
<div class="modal fade bs-modal-md in" id="eventDetailModal" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-data-application">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <span class="caption-subject font-red-sunglo bold uppercase" id="modelHeading"></span>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
                <button type="button" class="btn blue">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{--Ajax Modal Ends--}}

@endsection
@section('extrascripts')
<!-- jQuery -->
<!-- <script src="{{ asset('hrcrm/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script> -->
<script src="{{ asset('hrcrm/js/jquery-ui.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('hrcrm/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src='{{ asset('hrcrm/js/bootstrap-select.min.js') }}'></script>

<!-- Sidebar menu plugin JavaScript -->
<script src="{{ asset('hrcrm/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
<!--Slimscroll JavaScript For custom scroll-->
<script src="{{ asset('hrcrm/js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('hrcrm/js/waves.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('hrcrm/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/custom.js') }}"></script>
<script src="{{ asset('hrcrm/js/jasny-bootstrap.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/froiden-helper/helper.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>

{{--sticky note script--}}
<script src="{{ asset('hrcrm/js/cbpFWTabs.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/icheck/icheck.init.js') }}"></script>
<script src="{{ asset('hrcrm/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/jquery.magnific-popup-init.js') }}"></script>

<script src="https://js.pusher.com/5.0/pusher.min.js"></script>   
<script>


    $('.leave-action-reject').click(function () {
        var action = $(this).data('leave-action');
        var leaveId = $(this).data('leave-id');
        var searchQuery = "?leave_action="+action+"&leave_id="+leaveId;
        var url = '{!! route('Crm::leaves.show-reject-modal') !!}'+searchQuery;
        $('#modelHeading').html('Reject Reason');
        $.ajaxModal('#eventDetailModal', url);
    });

    $('.leave-action').on('click', function() {
        var action = $(this).data('leave-action');
        var leaveId = $(this).data('leave-id');
        var url = '{{ route("Crm::leaves.leaveAction") }}';

        $.easyAjax({
            type: 'POST',
            url: url,
            data: { 'action': action, 'leaveId': leaveId, '_token': '{{ csrf_token() }}' },
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        });
    })
</script>
@endsection