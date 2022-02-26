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


<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">

<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/morrisjs/morris.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('hrcrm/css/datatables/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/css/datatables/responsive.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/css/datatables/buttons.dataTables.min.css') }}"> -->
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
                <h4 class="page-title">Leaves</h4>
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
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-right">
                            <a href="{{ route('Crm::staff.leaves.create') }}" class="btn btn-sm btn-success btn-outline waves-effect waves-light">
                                <i class="ti-plus"></i> Apply Leave
                            </a>
                        </div>
                        <!-- /.breadcrumb -->
                    </div> 
                    <div class="row">
                        @if(Laralum::hasPermission('laralum.leave.view'))
                        <!-- can('view_leave') -->
                        <div class="sttabs tabs-style-line col-md-12">
                            <div class="white-box">
                                <nav>
                                    <ul>
                                        <li  class="tab-current"><a href="{{ route('Crm::staff.leaves') }}"><span>My Leaves</span></a>
                                        </li>
                                        <!-- <li><a href="{{ route('Crm::staff.dashboard') }}"><span>Dashboard</span></a>
                                        </li> -->

                                    </ul>
                                </nav>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                    <div class="col-md-4">
                                        <ul class="basic-list">
                                           
                                        </ul>
                                    </div>

                                    <div class="col-md-3 col-md-offset-1 text-center"><span class="donut" data-peity='{ "fill": ["red", "#eeeeee"],    "innerRadius": 40, "radius": 60 }'>{{ count($leaves) }}/{{ $allowedLeaves }}</span><br>
                                        <div class="btn btn-inverse btn-rounded">Leaves Taken : {{ $leavesCount }}/{{ $allowedLeaves }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Pending Leaves</div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            
                                            @forelse($pendingLeaves as $key=>$pendingLeave)
                                                <div class="col-md-6 m-b-10" data-role="task">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            {{ ($key+1) }}. <strong>{{ ucwords($pendingLeave->user->name) }}</strong> for {{ $pendingLeave->leave_date->format('d-m-Y') }}
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <a href="javascript:;" data-leave-id="{{ $pendingLeave->id }}" data-leave-action="rejected" class="btn btn-sm btn-danger btn-outline leave-action m-l-10"><i class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            @empty
                                                <div class="col-md-12">
                                                    No pending leaves remaining.
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                    <h3 class="box-title col-md-3">Leaves</h3>

                                </div>


                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable" id="leaves-table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Leave Type</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
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

    function getEventDetail(id) {
        var url = '{{ route('Crm::staff.leaves.show', ':id')}}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Event');
        $.ajaxModal('#eventDetailModal', url);
    }

    $('.leave-action').click(function () {
        var action = $(this).data('leave-action');
        var leaveId = $(this).data('leave-id');
        var url = '{{ route("Crm::staff.leaves.leaveAction") }}';

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
    });

    $(function() {
        var table = $('#leaves-table').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: '{!! route('Crm::staff.leaves.data') !!}',
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/English.json"
            },
            "fnDrawCallback": function( oSettings ) {
                $("body").tooltip({
                    selector: '[data-toggle="tooltip"]'
                });
            },
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'type', name: 'type' },
                { data: 'leave_date', name: 'leave_date' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', width: '15%' }
            ]
        });
    });

    $('body').on('click', '.sa-params', function(){
        var id = $(this).data('user-id');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You will not be able to recover the deleted leave!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('Crm::staff.leaves.destroy',':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id" : id
                    },
                    success: function (data) {
                        $.NotificationApp.send("Success","Leave deleted successfully.","top-center","green","success");
                        $.unblockUI();
                        //window.location.reload();
                    
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    }, error: function (data) {
                        $.NotificationApp.send("Error","Leave has not been deleted.","top-center","red","error");
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    },
                });
            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Leave not deleted !',
                    'error'
                )
            }
        });
    });

</script>

<script src="{{ asset('hrcrm/plugins/bower_components/moment/moment.js') }}"></script>

<script src="{{ asset('hrcrm/plugins/bower_components/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/peity/jquery.peity.init.js') }}"></script>

<!-- <script src="{{ asset('hrcrm/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/datatables/responsive.bootstrap.min.js') }}"></script> -->





@endsection