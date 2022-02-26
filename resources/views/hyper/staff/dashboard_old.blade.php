@extends('hyper.layout.master')
@section('title', "Dashboard")
@section('content')
<!-- Bootstrap Core CSS -->
    <link href="{{ asset('hrcrm/plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css'>
    <link rel='stylesheet prefetch'
          href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css'>

    <!-- This is Sidebar menu CSS -->
    <link href="{{ asset('hrcrm/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">

    <link href="{{ asset('hrcrm/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <link href="{{ asset('hrcrm/plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">

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

 
    <!-- <link href="{{ asset('hrcrm/css/rounded.css') }}" rel="stylesheet">
    <link href="{{ asset('hrcrm/css/member-custom.css') }}" rel="stylesheet"> -->


    <link rel="stylesheet" href="{{ asset('hrcrm/css/full-calendar/main.min.css') }}">
    <link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">

    <link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
    <link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/multiselect/css/multi-select.css') }}">
    <link rel="stylesheet" href="{{ asset('hrcrm/plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">
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
    <style>
        .fc-event{
            font-size: 10px !important;
        }
    </style>

<div class="px-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="uil-home-alt"></i>Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard <span class="text-warning b-l p-l-10 m-l-5" id="pendingLeaves">{{ count($pendingLeaves) }}</span> <span class="font-12 text-muted m-l-5"> Pending Leaves</span></h4>
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
                        <div class="col-lg-13 col-sm-12 col-md-12 col-xs-12 text-right">
                            @if(Laralum::hasPermission('laralum.leave.create'))
                            <!-- can('add_leave') -->
                                <!-- <a href="{{ route('Crm::staff.leaves-dashboard.create') }}" class="btn btn-sm btn-success btn-outline waves-effect waves-light">
                                    <i class="ti-plus"></i> Assign Leave
                                </a> -->
                            @endif
                        </div>
                        <!-- /.breadcrumb -->
                    </div>
                    <div class="white-box">
   

                        <div class="row">

                            @if($attendanceSettings->employee_clock_in_out == 'yes')
                            <div class="col-md-6">
                                <div class="panel panel-inverse">
                                    <div class="panel-heading">Attendance</div>
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body">

                                            <input type="hidden" id="current-latitude">
                                            <input type="hidden" id="current-longitude">
                                            @if (!isset($noClockIn))

                                                @if(!$checkTodayHoliday)
                                                    @if($todayTotalClockin < $maxAttendanceInDay)
                                                        <div class="col-xs-6">
                                                            <h3>Clock In</h3>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            <h3>Clock In IP</h3>
                                                        </div>
                                                        <div class="col-xs-6">
                                                            @if(is_null($currenntClockIn))
                                                                {{ \Carbon\Carbon::now()->timezone('Asia/Kolkata')->format('h:i a') }}
                                                            @else
                                                                {{ $currenntClockIn->clock_in_time->timezone('Asia/Kolkata')->format('h:i a') }}
                                                            @endif
                                                        </div>
                                                        <div class="col-xs-6">
                                                            {{ $currenntClockIn->clock_in_ip ?? request()->ip() }}
                                                        </div>

                                                        @if(!is_null($currenntClockIn) && !is_null($currenntClockIn->clock_out_time))
                                                            <div class="col-xs-6 m-t-20">
                                                                <label for="">Clock Out</label>
                                                                <br>{{ $currenntClockIn->clock_out_time->timezone('Asia/Kolkata')->format('h:i a') }}
                                                            </div>
                                                            <div class="col-xs-6 m-t-20">
                                                                <label for="">Clock Out IP</label>
                                                                <br>{{ $currenntClockIn->clock_out_ip }}
                                                            </div>
                                                        @endif

                                                        <div class="col-xs-8 m-t-20 truncate">
                                                            <label for="">Working From</label>
                                                            @if(is_null($currenntClockIn))
                                                                <input type="text" class="form-control" id="working_from" name="working_from">
                                                            @else
                                                                <br> {{ $currenntClockIn->working_from }}
                                                            @endif
                                                        </div>

                                                        <div class="col-xs-4 m-t-20">
                                                            <label class="m-t-30">&nbsp;</label>
                                                            @if(is_null($currenntClockIn))
                                                                <button class="btn btn-success btn-sm" id="clock-in">Clock In</button>
                                                            @endif
                                                            @if(!is_null($currenntClockIn) && is_null($currenntClockIn->clock_out_time))
                                                                <button class="btn btn-danger btn-sm" id="clock-out">Clock Out</button>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="col-xs-12">
                                                            <div class="alert alert-info">Maximum check-ins reached.</div>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="col-xs-12">
                                                        <div class="alert alert-info alert-dismissable">
                                                            <b>Today is Holiday for {{ ucwords($checkTodayHoliday->occassion) }}.</b> </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-xs-12 text-center">
                                                    <h4><i class="ti-alert text-danger"></i></h4>
                                                    <h4>Office hours have passed. You cannot mark attendance for today now.</h4>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <div id="calendar"></div>
                            </div>
                            @if(Laralum::hasPermission('laralum.leave.edit'))
                            <!-- can('edit_leave') -->
                            <div class="col-md-5">
                                <div class="white-box">
                                    <div class="panel panel-inverse">
                                        <div class="panel-heading">Pending Leaves</div>
                                        <div class="panel-wrapper collapse in">
                                            <div class="panel-body">
                                                <ul class="list-task list-group" data-role="tasklist">
                                                    @forelse($pendingLeaves as $key=>$pendingLeave)
                                                        <li class="list-group-item" data-role="task">
                                                            {{ ($key+1) }}. <strong>{{ ucwords($pendingLeave->user->name) }}</strong> for {{ $pendingLeave->leave_date->format('d-m-Y') }} ({{ $pendingLeave->leave_date->format('l') }})
                                                            <br>
                                                            <strong>Reason: </strong>{{ $pendingLeave->reason }}
                                                            <br>
                                                            <div class="m-t-10"></div>
                                                            <a href="javascript:;" data-leave-id="{{ $pendingLeave->id }}" data-leave-action="approved" class="btn btn-xs btn-success btn-outline btn-rounded m-r-5 leave-action"><i class="fa fa-check"></i> Accept</a>

                                                            <a href="javascript:;" data-leave-id="{{ $pendingLeave->id }}" data-leave-action="rejected" class="btn btn-xs btn-danger btn-outline btn-rounded leave-action"><i class="fa fa-times"></i> Reject</a>
                                                        </li>
                                                    @empty
                                                        No pending leaves remaining.
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
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


<script src="{{ asset('hrcrm/plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('hrcrm/js/moment-timezone.js') }}"></script>




<script>
    $(function () {
        $('.selectpicker').selectpicker();
    });

    $('#clock-in').click(function () {
        var workingFrom = $('#working_from').val();

        var currentLatitude = document.getElementById("current-latitude").value;
        var currentLongitude = document.getElementById("current-longitude").value;

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            url: '{{route('Crm::staff.attendance.store')}}',
            type: "POST",
            data: {
                working_from: workingFrom,
                currentLatitude: currentLatitude,
                currentLongitude: currentLongitude,
                _token: token
            },
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    })

    @if(!is_null($currenntClockIn))
    $('#clock-out').click(function () {

        var token = "{{ csrf_token() }}";
        var currentLatitude = document.getElementById("current-latitude").value;
        var currentLongitude = document.getElementById("current-longitude").value;

        $.easyAjax({
            url: '{{route('Crm::staff.attendance.update', $currenntClockIn->id)}}',
            type: "POST",
            data: {
                currentLatitude: currentLatitude,
                currentLongitude: currentLongitude,
                _method: 'PUT',
                _token: token
            },
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    })
    @endif

</script>
<script>
    var taskEvents = [
        @foreach($leaves as $leave)
        @if($leave->status == 'approved')
        {
            id: '{{ ucfirst($leave->id) }}',
            title: '{{ ucfirst($leave->user->name) }}',
            start: '{{ $leave->leave_date->format("Y-m-d") }}',
            end: '{{ $leave->leave_date->format("Y-m-d") }}',
            className: 'bg-{{ $leave->type->color }}'
        },
        @else
        {
            id: '{{ ucfirst($leave->id) }}',
            title: '<i class="fa fa-warning"></i> {{ ucfirst($leave->user->name) }}',
            start: '{{ $leave->leave_date->format("Y-m-d") }}',
            end: '{{ $leave->leave_date->format("Y-m-d") }}',
            className: 'bg-{{ $leave->type->color }}'
        },
        @endif
        @endforeach
];

    var getEventDetail = function (id) {
        var url = '{{ route('Crm::staff.leaves-dashboard.show', ':id')}}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Event');
        $.ajaxModal('#eventDetailModal', url);
    }

    var calendarLocale = 'en';

    $('.leave-action').click(function () {
        var action = $(this).data('leave-action');
        var leaveId = $(this).data('leave-id');
        var url = '{{ route("Crm::staff.leaves-dashboard.leaveAction") }}';

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

<script src="{{ asset('hrcrm/plugins/bower_components/calendar/jquery-ui.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('hrcrm/js/full-calendar/main.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/full-calendar/locales-all.min.js') }}"></script>
<script>
    var initialLocaleCode = 'en';
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
  
      var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: initialLocaleCode,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        // initialDate: '2020-09-12',
        navLinks: true, // can click day/week names to navigate views
        selectable: false,
        selectMirror: true,
        select: function(arg) {
          var title = prompt('Event Title:');
          if (title) {
            calendar.addEvent({
              title: title,
              start: arg.start,
              end: arg.end,
              allDay: arg.allDay
            })
          }
          calendar.unselect()
        },
        eventClick: function(arg) {
            getEventDetail(arg.event.id);
        },
        editable: false,
        dayMaxEvents: true, // allow "more" link when too many events
        events: taskEvents,
        eventDidMount: function(info){
            if (info.el.querySelector('.fc-event-title') !== null) {
                info.el.querySelector('.fc-event-title').innerHTML = info.event.title;
            }
            if (info.el.querySelector('.fc-list-event-title') !== null) {
                info.el.querySelector('.fc-list-event-title').innerHTML = info.event.title;
            }

        }
        
      });
  
      calendar.render();
    });
  
</script>
@endsection