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

<link rel="stylesheet" href="{{ asset('hrcrm/css/full-calendar/main.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/timepicker/bootstrap-timepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/multiselect/css/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">
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
                        <li class="breadcrumb-item active">Leaves</li>
                    </ol>
                </div>
                <h4 class="page-title">Leaves : {{ $pendingLeaves}} <a href="{{ route('Crm::leaves.pending') }}" class="font-12 text-muted m-l-5"> Pending Leaves</a></h4>
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
                            <a href="{{ route('Crm::leaves.all-leaves') }}" class="btn btn-sm btn-info waves-effect waves-light btn-outline">
                                        <i class="fa fa-list"></i> All Leaves
                            </a>
                            
                            <a href="{{ route('Crm::leaves.create') }}" class="btn btn-sm btn-success waves-effect waves-light m-l-10 btn-outline">
                            <i class="ti-plus"></i> Assign Leave</a>
                        </div>
                        <!-- /.breadcrumb -->
                    </div>


                    <div class="row">
        
                        <div class="col-md-12">
                            <div class="white-box">

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
    var getEventDetail = function (id) {
        var url = '{{ route('Crm::leaves.show', ':id')}}';
        url = url.replace(':id', id);

        $('#modelHeading').html('Event');
        $.ajaxModal('#eventDetailModal', url);
    }

    var calendarLocale = 'en';

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

    $('#pending-leaves').click(function() {
        window.location = '{{ route("Crm::leaves.pending") }}';
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
              addEventModal(arg.start, arg.end, arg.allDay);
              calendar.unselect()
          },
        eventClick: function(arg) {
            getEventDetail(arg.event.id);
        },
        editable: false,
        dayMaxEvents: true, // allow "more" link when too many events
        events: "{{ route('Crm::leaves') }}",
        
      });
  
      calendar.render();
    });
  
</script>

@endsection