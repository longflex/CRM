@extends('hyper.layout.master')
@section('title', "Attendance")
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('hrcrm/plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<!-- color CSS you can use different color css from css/colors folder -->
<!-- We have chosen the skin-blue (default.css) for this starter
   page. However, you can choose any other skin from folder css / colors .
   -->
<link href="{{ asset('hrcrm/css/colors/default.css') }}" id="theme" rel="stylesheet">
<link href="{{ asset('hrcrm/plugins/froiden-helper/helper.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('hrcrm/css/magnific-popup.css') }}">
<link href="{{ asset('hrcrm/css/custom-new.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/switchery/dist/switchery.min.css') }}">
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
                        <li class="breadcrumb-item active">Attendance</li>
                    </ol>
                </div>
                <h4 class="page-title">Attendance</h4>
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
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-justified nav-bordered mb-1">
                                <li class="nav-item">
                                    <a href="{{ route('Crm::attendance.summary') }}" aria-expanded="true" class="nav-link">
                                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Summary</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('Crm::attendance') }}" aria-expanded="false" class="nav-link active">
                                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                        <span class="d-none d-md-block">Attendance By Member</span>
                                    </a>
                                </li>
                            </ul>                  
                        </div>
                    
                        <div class="col-md-12">
                            <div class="white-box p-b-0">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">Select Date Range</label>

                                        <div class="input-daterange input-group" id="date-range">
                                            <input type="text" class="form-control" id="start-date" placeholder="Start Date" value="{{ $startDate->format('d-m-Y') }}"/>
                                            <span class="input-group-addon bg-info b-0 text-white"> To </span>
                                            <input type="text" class="form-control" id="end-date" placeholder="End Date" value="{{ $endDate->format('d-m-Y') }}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Employee Name</label>
                                            <select class="select2" data-placeholder="Choose Employee" id="user_id" name="user_id">
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group mt-1">
                                            <label class="control-label"></label>
                                            <button type="button" id="apply-filter" class="btn btn-success btn-block">Apply</button>
                                        </div>
                                    </div>

                                    <div class="col-md-2 float-right">
                                        <div class="form-group mt-4">
                                            <label class="control-label"></label>
                                            <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::attendance.create') }}"><i class="uil-plus-circle"></i> Mark Attendance</a>
                                        </div>
                                        
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row dashboard-stats">
                                <div class="col-md-12 m-b-30">
                                    <div class="white-box">
                                        <div class="col-md-2  col-sm-4 text-center">
                                            <h4><span class="text-dark" id="totalWorkingDays">{{ $totalWorkingDays }}</span> <span class="font-12 text-muted m-l-5"> Total Working Days</span></h4>
                                        </div>
                                        <div class="col-md-2 b-l  col-sm-4 text-center">
                                            <h4><span class="text-success" id="daysPresent">{{ $daysPresent }}</span> <span class="font-12 text-muted m-l-5"> Days Present</span></h4>
                                        </div>
                                        <div class="col-md-2 b-l  col-sm-4 text-center">
                                            <h4><span class="text-danger" id="daysLate">{{ $daysLate }}</span> <span class="font-12 text-muted m-l-5">Day(s) Late</span></h4>
                                        </div>
                                        <div class="col-md-2 b-l  col-sm-4 text-center">
                                            <h4><span class="text-warning" id="halfDays">{{ $halfDays }}</span> <span class="font-12 text-muted m-l-5">Half Day</span></h4>
                                        </div>
                                        <div class="col-md-2 b-l  col-sm-4 text-center">
                                            <h4><span class="text-info" id="absentDays">{{ (($totalWorkingDays - $daysPresent) < 0) ? '0' : ($totalWorkingDays - $daysPresent) }}</span> <span class="font-12 text-muted m-l-5"> Day(s) Absent</span></h4>
                                        </div>
                                        <div class="col-md-2 b-l  col-sm-4 text-center">
                                            <h4><span class="text-primary" id="holidayDays">{{ $holidays }}</span> <span class="font-12 text-muted m-l-5">Holidays</span></h4>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="white-box">

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Clock In</th>
                                            <th>Clock Out</th>
                                            <th>Others</th>
                                        </tr>
                                        </thead>
                                        <tbody id="attendanceData">
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
    <!-- end page content --> 
</div>  
{{--Timer Modal--}}
<div class="modal fade bs-modal-lg in" id="attendanceModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
{{--Timer Modal Ends--}}

{{--Timer Modal--}}
<div class="modal fade bs-modal-lg in" id="projectTimerModal" role="dialog" aria-labelledby="myModalLabel"
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
{{--Timer Modal Ends--}}
@endsection
@section('extrascripts')
<!-- jQuery -->
<script src="{{ asset('hrcrm/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/jquery-ui.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('hrcrm/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/bootstrap-select.min.js') }}"></script>

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
<script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/switchery/dist/switchery.min.js') }}"></script>
<script>
    // $(function() {
    //   $('#start-date').daterangepicker({
    //     singleDatePicker: true,
    //     autoUpdateInput: false,
    //     autoApply: false,
    //     showDropdowns: true,
    //     minYear: 1901,
    //     maxYear: parseInt(moment().format('YYYY'),10)
    //   });
    //   $('#start-date').on('apply.daterangepicker', function(ev, picker) {
    //         $(this).val(picker.startDate.format('DD-MM-YYYY'));

    //     });
    // });
    // $(function() {
    //   $('#end-date').daterangepicker({
    //     singleDatePicker: true,
    //     autoUpdateInput: false,
    //     autoApply: false,
    //     showDropdowns: true,
    //     minYear: 1901,
    //     maxYear: parseInt(moment().format('YYYY'),10)
    //   });
    //   $('#end-date').on('apply.daterangepicker', function(ev, picker) {
    //         $(this).val(picker.startDate.format('DD-MM-YYYY'));

    //     });
    // });

    jQuery('#date-range').datepicker({
        toggleActive: true,
        format: "dd-mm-yyyy",
        autoclose: true
    });
    // $('.input-daterange-datepicker').on('apply.daterangepicker', function (ev, picker) {
    //     startDate = picker.startDate.format('YYYY-MM-DD');
    //     endDate = picker.endDate.format('YYYY-MM-DD');
    //     showTable();
    // });


    $('#apply-filter').click(function () {
       showTable();
    });

    $(".select2").select2({
        formatNoMatches: function () {
            return "NO RECORD FOUND" ;
        }
    });

    var table;

    function showTable() {

        var startDate = $('#start-date').val();
        var endDate = $('#end-date').val();

        // $('body').block({
        //     message: '<p style="margin:0;padding:8px;font-size:24px;">Just a moment...</p>'
        //     , css: {
        //         color: '#fff'
        //         , border: '1px solid #fb9678'
        //         , backgroundColor: '#fb9678'
        //     }
        // });

        var userId = $('#user_id').val();
        if (userId == "") {
            userId = 0;
        }

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        //refresh counts
        var url = "{{ route('Crm::attendance.refreshCount') }}";

        //var token = "{{ csrf_token() }}";
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url:  url,
            data: {
                    _token : "{{ csrf_token() }}",
                    startDate: startDate,
                    endDate: endDate,
                    userId: userId
                },
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        // using the done promise callback
        .done(function(data) {

            if(data.status==true){
                // $('#daysPresent').html(data.daysPresent);
                // $('#daysLate').html(data.daysLate);
                // $('#halfDays').html(data.halfDays);
                // $('#totalWorkingDays').html(data.totalWorkingDays);
                // $('#absentDays').html(data.absentDays);
                // $('#holidayDays').html(data.holidays);
                // initConter();
            }
            
        })
        // using the fail promise callback
        .fail(function(data) {
            //$.NotificationApp.send("Error",data.message,"top-center","red","error");
            setTimeout(function(){
                //location.reload();
            }, 3500);
            
          
        });

        

        //refresh datatable
        var url2 = '{{ route('Crm::attendance.employeeData') }}';
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url:  url2,
            data: {
                    _token : "{{ csrf_token() }}",
                    startDate: startDate,
                    endDate: endDate,
                    userId: userId
                },
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
        // using the done promise callback
        .done(function(data) {

            if(data.status==true){
                $('#attendanceData').html(data.data);
            }
            
        })
        // using the fail promise callback
        .fail(function(data) {
            //$.NotificationApp.send("Error",data.message,"top-center","red","error");
            setTimeout(function(){
                //location.reload();
            }, 3500);
            
          
        });
        
    }



    $('#attendanceData').on('click', '.delete-attendance', function(){
        var dataid = $(this).data('attendance-id');
        const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You will not be able to recover the deleted record!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('Crm::delete_attendance',':id') }}";
                    url = url.replace(':id', id);

                    $.ajax({
                        type: "GET",
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id" : dataid
                        },
                        success: function (data) {
                            $.NotificationApp.send("Success","Attendance deleted successfully.","top-center","green","success");
                            $.unblockUI();

                            $('#timelogBox'+id).remove();
//                                    swal("Deleted!", response.message, "success");
                            showTable();
                            $('#projectTimerModal').modal('hide');
                        
                            setTimeout(function(){
                                location.reload();
                            }, 3500);
                        }, error: function (data) {
                            $.NotificationApp.send("Error","Attendance has not been deleted.","top-center","red","error");
                            setTimeout(function(){
                                location.reload();
                            }, 3500);
                        },
                    });
                } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Attendance not deleted !',
                        'error'
                    )
                }
            });
    });


    $('#attendanceData').on('click', '.view-attendance',function () {
        var attendanceID = $(this).data('attendance-id');
        var url = '{{ route('Crm::attendance.info',':attendanceID') }}';
        url = url.replace(':attendanceID', attendanceID);

        $('#modelHeading').html('Attendance');
        $.ajaxModal('#projectTimerModal', url);
    });


    function initConter() {
        $(".counter").counterUp({
            delay: 100,
            time: 1200
        });
    }

    showTable();

    function exportData(){

        
    }

    function exportData(){

        
    }

    function editAttendance (id) {
        $('#projectTimerModal').modal('hide');

        var url = '{!! route('Crm::attendance.edit', [':id']) !!}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Attendance');
        $.ajaxModal('#attendanceModal', url);
    }

</script>

@endsection