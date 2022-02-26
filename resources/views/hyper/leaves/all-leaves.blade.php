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
<!-- <link href="{{ asset('hrcrm/css/animate.css') }}" rel="stylesheet"> -->
        <!-- This is a Custom CSS -->
<!-- <link href="{{ asset('hrcrm/css/style.css') }}" rel="stylesheet"> -->
<!-- color CSS you can use different color css from css/colors folder -->
<!-- We have chosen the skin-blue (default.css) for this starter
   page. However, you can choose any other skin from folder css / colors .
   -->
<link href="{{ asset('hrcrm/css/colors/default.css') }}" id="theme" rel="stylesheet">
<link href="{{ asset('hrcrm/plugins/froiden-helper/helper.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('hrcrm/css/magnific-popup.css') }}">
<link href="{{ asset('hrcrm/css/custom-new.css') }}" rel="stylesheet">


<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
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
                <h4 class="page-title">Leaves <span class="text-warning b-l p-l-10 m-l-5">{{ $pendingLeaves}}</span> <a href="{{ route('Crm::leaves.pending') }}" class="font-12 text-muted m-l-5"> Pending Leaves</a></h4>
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
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-right mb-1">
                            <a href="{{ route('Crm::leaves') }}" class="btn btn-sm btn-primary waves-effect waves-light m-l-10 btn-outline">
                                    <i class="fa fa-calendar"></i> Calendar View
                            </a>
                            
                            <a href="{{ route('Crm::leaves.create') }}" class="btn btn-sm btn-success waves-effect waves-light m-l-10 btn-outline">
                            <i class="ti-plus"></i> Assign Leave</a>
                        </div>
                        <!-- /.breadcrumb -->
                    </div>
                    
                    


                    <div class="row">
                        <div class="col-md-3 filter-section">
                            <h5 class="pull-left"><i class="fa fa-sliders"></i> Filter Results
                            </h5>
                            <h5 class="pull-right hidden-sm hidden-md hidden-xs">
                                <button class="btn btn-default btn-xs btn-outline btn-circle filter-section-close" ><i class="fa fa-chevron-left"></i></button>
                            </h5>
                            <div class="m-b-10">
                                {!! Form::open(['id'=>'storePayments','class'=>'ajax-form','method'=>'POST']) !!}

                                <div class="col-md-12">
                                    <div class="example">
                                        <h5 class="box-title m-t-30">Select Date Range</h5>

                                        <div class="input-daterange input-group" id="date-range">
                                            <input type="text" class="form-control" id="start-date" placeholder="Start Date"
                                                    value="{{ $fromDate->format('d-m-Y') }}"/>
                                            <span class="input-group-addon bg-info b-0 text-white">To</span>
                                            <input type="text" class="form-control" id="end-date" placeholder="End Date"
                                                    value="{{ $toDate->format('d-m-Y') }}"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <h5 class="box-title m-t-30">Employee Name</h5>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <select class="select2 form-control" data-placeholder="Select Employee" id="employee_id">
                                                    <option value="">All</option>
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success" id="filter-results"><i class="fa fa-check"></i> Apply
                                    </button>
                                </div>
                                {!! Form::close() !!}

                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="white-box">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover toggle-circle default footable-loaded footable"
                                           id="leave-table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Leave Date</th>
                                            <th>Leave Status</th>
                                            <th>Leave Type</th>
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


<div class="modal fade bs-example-modal-lg" id="leave-details" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
            </div>
            <div class="modal-body">
                Loading...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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




    <script src="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
    <script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('hrcrm/plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('hrcrm/plugins/bower_components/morrisjs/morris.js') }}"></script>
    <script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
   <!--  <script src="{{ asset('hrcrm/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script> -->
    <!-- <script src="{{ asset('hrcrm/js/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('hrcrm/js/datatables/dataTables.responsive.min.js') }}"></script> -->
    <!-- <script src="{{ asset('hrcrm/js/datatables/responsive.bootstrap.min.js') }}"></script> -->
    <script src="{{ asset('hrcrm/plugins/bower_components/moment/min/moment.min.js') }}"></script>

    <script>

        $("#storePayments .select2").select2({
            formatNoMatches: function () {
                return 'No record found.';
            }
        });

        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: "dd-mm-yyyy",
            autoclose: true
        });

        function loadTable(){
            var startDate = $('#start-date').val();

            if (startDate == '') {
                startDate = null;
            } else {
                // startDate = moment(startDate, "{{ strtoupper("dd-mm-yyyy") }}").format('YYYY-MM-DD');
            }

            var endDate = $('#end-date').val();

            if (endDate == '') {
                endDate = null;
            } else {
                // endDate = moment(endDate, "{{ strtoupper("dd-mm-yyyy") }}").format('YYYY-MM-DD');
            }

            var employeeId = $('#employee_id').val();
            if (!employeeId) {
                employeeId = 0;
            }

            var url = '{!!  route('Crm::leaves.data') !!}'+'?_token={{ csrf_token() }}';


            var table = $('#leave-table').dataTable({
                responsive: true,
                //processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    "url": url,
                    "type": "POST",
                    "data" : {
                        startDate : startDate,
                        endDate : endDate,
                        employeeId  : employeeId
                    }
                },
                language: {
                    "url": '//cdn.datatables.net/plug-ins/1.10.15/i18n/English.json'
                },
                "fnDrawCallback": function( oSettings ) {
                    $("body").tooltip({
                        selector: '[data-toggle="tooltip"]'
                    });
                },
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'employee', name: 'employee' },
                    { data: 'leave_date', name: 'leave_date' },
                    { data: 'status', name: 'status' },
                    { data: 'leave_type', name: 'leave_type' },
                    { data: 'action', name: 'action' }
                ]
            });

        }

        $('#filter-results').click(function () {
            loadTable();
        });

        $(document).on('click', '.leave-action-reject', function () {
            var action = $(this).data('leave-action');
            var leaveId = $(this).data('leave-id');
            var searchQuery = "?leave_action="+action+"&leave_id="+leaveId;
            var url = '{!! route('Crm::leaves.show-reject-modal') !!}'+searchQuery;

            $('#modelHeading').html('Reject Reason');
            $.ajaxModal('#leave-details', url);
        });

        $(document).on('click', '.leave-action', function() {
            var action = $(this).data('leave-action');
            var leaveId = $(this).data('leave-id');
            var url = '{{ route("Crm::leaves.leaveAction") }}';
            $.easyAjax({
                type: 'POST',
                url: url,
                data: { 'action': action, 'leaveId': leaveId, '_token': '{{ csrf_token() }}' },
                success: function (response) {
                    if(response.status == 'success'){
                        loadTable();
                    }
                }
            });
        });

        $('body').on('click', '.sa-params', function(){
            var id = $(this).data('leave-id');
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
                    var url = "{{ route('Crm::leaves.destroy',':id') }}";
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

        $('body').on('click', '.show-leave', function () {
            var leaveId = $(this).data('leave-id');

            var url = '{{ route('Crm::leaves.show', ':id') }}';
            url = url.replace(':id', leaveId);

            $('#modelHeading').html('Leave Details');
            $.ajaxModal('#leave-details', url);
        });

        $('#pending-leaves').click(function() {
            window.location = '{{ route("Crm::leaves.pending") }}';
        })

        loadTable();
    </script>

@endsection