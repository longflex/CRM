@extends('hyper.layout.master')
@section('title', "Holiday")
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


<link rel="stylesheet" href="{{ asset('hrcrm/css/full-calendar/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">

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
                        <li class="breadcrumb-item active">Holiday</li>
                    </ol>
                </div>
                <h4 class="page-title">Holiday List Of {{ \Carbon\Carbon::now()->format('Y') }}</h4>
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
                        <div class="col-md-12 show" id="new-follow-panel" style="">
                            <h4 id="currentMonthName"></h4>

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Date</th>
                                    <th>Occassion</th>
                                </tr>
                                </thead>
                                <tbody id="monthDetailData">

                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="white-box">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group col-md-2 pull-right">
                                            <label class="control-label">Select Year</label>
                                            <select onchange="getYearData()" class="select2 form-control" data-placeholder="Projects Status" id="year">
                                                @forelse($years as $yr)
                                                    <option @if($yr == $year) selected @endif value="{{ $yr }}">{{ $yr }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="calendar"></div>
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

    var taskEvents = [
        @foreach($holidays as $holiday)
        {
            id: '{{ ucfirst($holiday->id) }}',
            title: '{{ ucfirst($holiday->occassion) }}',
            start: '{{ $holiday->date->format("Y-m-d") }}',
            className:function(){
                var occassion = '{{ $holiday->occassion }}';
                if(occassion == 'Sunday' || occassion == 'Saturday'){
                    return 'bg-info';
                }else{
                    return 'bg-danger';
                }
            }
        },
        @endforeach
    ];

    var getEventDetail = function (id) {
        var url = '{{ route('Crm::staff.holidays.show', ':id')}}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Event');
        $.ajaxModal('#eventDetailModal', url);
    }

    var calendarLocale = 'en';

    var date = new Date();
    var y = date.getFullYear();
    var d = date.getDate();
    var m = date.getMonth();

    var year = "{{ $year }}";

    year =  parseInt(year, 10);
    var defaultDate;

    if(y != year){
        defaultDate = new Date(year, m, d);
    }
    else{
        defaultDate = new Date(y, m, d);
    }

</script>

<script src="{{ asset('hrcrm/plugins/bower_components/calendar/jquery-ui.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('hrcrm/js/full-calendar/main.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/full-calendar/locales-all.min.js') }}"></script>

<script>
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    var currentMonth = new Date();
    $('#currentMonthName').html(monthNames[currentMonth.getMonth()]);
    var currentMonthData = '';

    setMonthData(currentMonth);
    $('.fc-button-group .fc-prev-button').click(function(){
        var bs = $('#calendar').fullCalendar('getDate');
        var d = new Date(bs);
        setMonthData(d);
    });


    $('.fc-button-group .fc-next-button').click(function(){
        var bs = $('#calendar').fullCalendar('getDate');
        var d = new Date(bs);
        setMonthData(d);
    });

    function setMonthData(d){

        var month_int = d.getMonth();
        var year_int = d.getFullYear();
        var firstDay = new Date(year_int, month_int, 1);

        firstDay = moment(firstDay).format("YYYY-MM-DD");

        $('#currentMonthName').html(monthNames[d.getMonth()]);

        var year = "{{ $year }}";
        var url = "{{ route('Crm::staff.holidays.calendar-month') }}?startDate="+encodeURIComponent(firstDay)+"&year="+year;

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'GET',
            url: url,
            success: function (response) {
                $('#monthDetailData').html(response.data);
            }
        });
    }

    function getYearData(){
        var year = $('#year').val();
        var url = "{{ route('Crm::staff.holidays.calendar', ':year') }}";
        url = url.replace(':year', year);
        window.location.href = url;
    }
</script>

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
        customButtons: {
            prev: {
                text: 'Prev',
                click: function() {
                    calendar.prev();
                    setMonthData(calendar.getDate());
                }
            },
            next: {
                text: 'Next',
                click: function() {
                    calendar.next();
                    setMonthData(calendar.getDate());
                }
            },
        }
      });
  
      calendar.render();
    });
  
</script>

@endsection