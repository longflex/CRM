@extends('hyper.layout.master')
@section('title', "Attendance")
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ asset('hrcrm/plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css'>
<link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>
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
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                <li class="nav-item">
                    <a href="{{ route('Crm::staff.attendance.summary') }}" aria-expanded="true" class="nav-link active">
                        <i class="mdi mdi-account-circle d-md-none d-block"></i>
                        <span class="d-none d-md-block">Summary</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('Crm::staff.attendance.index') }}" aria-expanded="false" class="nav-link">
                        <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                        <span class="d-none d-md-block">Attendance By Member</span>
                    </a>
                </li>
            </ul>                  
        </div>
        <div class="col-lg-12">    
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="white-box p-b-0">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Employee Name</label>
                                            <select class="select2" data-placeholder="Choose Employee" id="user_id" name="user_id">
                                                <option value="0">--</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Department</label>
                                            <select class="select2" name="department" id="department" data-style="form-control">
                                                <option value="all">All</option>
                                                @forelse($departments as $department)
                                                    <option value="{{$department->id}}">{{ ucfirst($department->department) }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Select Month</label>
                                            <select class="select2" data-placeholder="" id="month">
                                                <option @if($month == '01') selected @endif value="01">January</option>
                                                <option @if($month == '02') selected @endif value="02">February</option>
                                                <option @if($month == '03') selected @endif value="03">March</option>
                                                <option @if($month == '04') selected @endif value="04">April</option>
                                                <option @if($month == '05') selected @endif value="05">May</option>
                                                <option @if($month == '06') selected @endif value="06">June</option>
                                                <option @if($month == '07') selected @endif value="07">July</option>
                                                <option @if($month == '08') selected @endif value="08">August</option>
                                                <option @if($month == '09') selected @endif value="09">September</option>
                                                <option @if($month == '10') selected @endif value="10">October</option>
                                                <option @if($month == '11') selected @endif value="11">November</option>
                                                <option @if($month == '12') selected @endif value="12">December</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label">Select Year</label>
                                            <select class="select2" data-placeholder="" id="year">
                                                @for($i = $year; $i >= ($year-4); $i--)
                                                    <option @if($i == $year) selected @endif value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group mt-4">
                                            <button type="button" id="apply-filter" class="btn btn-success btn-block">Apply</button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>



                        


                    </div>

                    <div class="row">
                        <div class="col-md-12" id="attendance-data"></div>
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
    $('#apply-filter').click(function () {
       showTable();
    });

    $(".select2").select2({
        formatNoMatches: function () {
            return "NO RECORD FOUND";
        }
    });

    function showTable() {

        var year = $('#year').val();
        var month = $('#month').val();



        var userId = $('#user_id').val();
        var department = $('#department').val();
      
        //refresh counts
        var url = '{!!  route('Crm::staff.attendance.summaryData') !!}';

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'POST',
            data: {
                '_token': token,
                year: year,
                month: month,
                department: department,
                userId: userId
            },
            url: url,
            success: function (response) {
               $('#attendance-data').html(response.data);
            }
        });

    }

    showTable();

    $('#attendance-data').on('click', '.view-attendance',function () {
        var attendanceID = $(this).data('attendance-id');
        var url = '{!! route('Crm::staff.attendance.info', ':attendanceID') !!}';
        url = url.replace(':attendanceID', attendanceID);

        $('#modelHeading').html('Attendance');
        $.ajaxModal('#projectTimerModal', url);
    });


    $('#attendance-data').on('click', '.edit-attendance',function (event) {
        var attendanceDate = $(this).data('attendance-date');
        var userData       = $(this).closest('tr').children('td:first');
        var userID         = $(this).data('user-id');
        var year           = $('#year').val();
        var month          = $('#month').val();

        var url = '{!! route('Crm::staff.attendance.mark', [':userid',':day',':month',':year',]) !!}';
            url = url.replace(':userid', userID);
            url = url.replace(':day', attendanceDate);
            url = url.replace(':month', month);
            url = url.replace(':year', year);

        $('#modelHeading').html('Attendance');
        $.ajaxModal('#projectTimerModal', url);
    });

    function editAttendance (id) {
        $('#projectTimerModal').modal('hide');

        var url = '{!! route('Crm::staff.attendance.edit', [':id']) !!}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Attendance');
        $.ajaxModal('#attendanceModal', url);
    }

</script>

@endsection