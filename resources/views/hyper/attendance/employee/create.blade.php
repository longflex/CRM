@extends('hyper.layout.master')
@section('title', "Attendance")
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


<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/switchery/dist/switchery.min.css') }}">

<!-- <link rel="stylesheet" href="{{ asset('hrcrm/css/datatables/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/css/datatables/responsive.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/css/datatables/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/css/datatables/buttons.dataTables.min.css') }}"> -->
<style>
    .topnav .navbar-nav .nav-link {
        font-size: 14px;
        font-weight: 500;
        padding: 17px 18px;
    }
    .dropdown-item {
        font-size: 12px;
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
                            <div class="white-box">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Attendance Date</label>
                                            <input type="text" class="form-control" name="attendance_date" id="attendance_date" value="{{ Carbon\Carbon::today()->format('d-m-Y') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="" id="tableBox">
                                    <table  id="attendance-table">

                                    </table>
                                </div>
                                <div id="holidayBox" style="display: none">
                                    <div class="alert alert-primary">Holiday For <span id="holidayReason"> </span>. </div>
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
<div class="modal fade bs-modal-md in" id="attendancesDetailsModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" id="modal-data-application">
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
    <!-- /.modal-dialog -->.
</div>
{{--Ajax Modal Ends--}}
@endsection
@section('extrascripts')
<!-- jQuery -->
<!-- <script src="{{ asset('hrcrm/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/jquery-ui.min.js') }}"></script> -->

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('hrcrm/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/bootstrap-select.min.js') }}"></script>

<!-- Sidebar menu plugin JavaScript -->
<!-- <script src="{{ asset('hrcrm/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script> -->
<!--Slimscroll JavaScript For custom scroll-->
<script src="{{ asset('hrcrm/js/jquery.slimscroll.js') }}"></script> 
<!--Wave Effects -->
<!-- <script src="{{ asset('hrcrm/js/waves.js') }}"></script> -->
<!-- Custom Theme JavaScript -->
<!-- <script src="{{ asset('hrcrm/plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script> -->
<script src="{{ asset('hrcrm/js/custom.js') }}"></script>
<script src="{{ asset('hrcrm/js/jasny-bootstrap.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/froiden-helper/helper.js') }}"></script>
<!-- <script src="{{ asset('hrcrm/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script> -->

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
$(".select2").select2({
        formatNoMatches: function () {
            return "No record found";
        }
    });
    checkHoliday();
    jQuery('#attendance_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        endDate: '+0d'
    }).on('changeDate', function (ev) {
        checkHoliday();
    });

    function checkHoliday() {
        var selectedDate = $('#attendance_date').val();
        var token = "{{ csrf_token() }}";
        $.easyAjax({
            url: '{{route('Crm::staff.attendance.check-holiday')}}',
            type: "GET",
            data: {
                date: selectedDate,
                _token: token
            },
            success: function (response) {
                if(response.status == 'success'){
                    if(response.holiday != null){
                        $('#holidayBox').show();
                        $('#tableBox').hide();
                        $('#holidayReason').html(response.holiday.occassion);
                    }else{
                        $('#holidayBox').hide();
                        $('#tableBox').show();
                        showTable();
                    }

                }
            }
        })
    }

    var table;

    function showTable(){
        table = $('#attendance-table').dataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{!! route('Crm::staff.attendance.data') !!}",
                data: function (d) {
                    d.date = $('#attendance_date').val();
                }
            },
            "bStateSave": true,
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/English.json"
            },
            columns: [
                { data: 'id', name: 'id', width:50 }],
            "fnDrawCallback": function (oSettings) {
                $(oSettings.nTHead).hide();
                $('.a-timepicker').timepicker({
                    @if('h:i a' == 'H:i')
                    showMeridian: false,
                    @endif
                    minuteStep: 1
                });
                $('.b-timepicker').timepicker({
                    @if('h:i a' == 'H:i')
                    showMeridian: false,
                    @endif
                    minuteStep: 1,
                    defaultTime: false
                });

                $('#attendance-table_wrapper').removeClass( 'form-inline' );

                // Switchery
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                $('.js-switch').each(function() {
                    new Switchery($(this)[0], $(this).data());

                });

            },
            "destroy" : true
        });
    }

    $('#attendance-table').on('click', '.save-attendance', function () {
        var userId = $(this).data('user-id');
        var clockInTime = $('#clock-in-'+userId).val();
        var clockInIp = $('#clock-in-ip-'+userId).val();
        var clockOutTime = $('#clock-out-'+userId).val();
        var clockOutIp = $('#clock-out-ip-'+userId).val();
        var workingFrom = $('#working-from-'+userId).val();
        var date = $('#attendance_date').val();

        var late = 'no';
        if($('#late-'+userId).is(':checked')){
            late = 'yes';
        }
        var halfDay = 'no';
        if($('#halfday-'+userId).is(':checked')){
            halfDay = 'yes';
        }
        var token = "{{ csrf_token() }}";

        $.easyAjax({ 
            url: '{{route('Crm::staff.attendance.storeAttendance')}}',
            type: "POST",
            container: '#attendance-container-'+userId,
            data: {
                user_id: userId,
                clock_in_time: clockInTime,
                clock_in_ip: clockInIp,
                clock_out_time: clockOutTime,
                clock_out_ip: clockOutIp,
                late: late,
                half_day: halfDay,
                working_from: workingFrom,
                date: date,
                _token: token
            },
            success: function (response) {
                if(response.status == 'success'){
                    showTable();
                }
            }
        })
    })

    // Attendance Detail
   function attendanceDetail(id,attendanceDate) {

       var url = "{{ route('Crm::staff.attendance.detail') }}?userID="+id+"&date="+attendanceDate;
        $('#modelHeading').html('Attendance Detail');
        $.ajaxModal('#attendancesDetailsModal',url);
    }

</script>

@endsection