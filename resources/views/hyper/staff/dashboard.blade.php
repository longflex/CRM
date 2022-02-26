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

<!-- This is a Animation CSS -->
<link href="{{ asset('hrcrm/css/animate.css') }}" rel="stylesheet">

<!-- head-script -->

<!-- head-script -->

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


<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/calendar/dist/fullcalendar.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/morrisjs/morris.css') }}"><!--Owl carousel CSS -->
<link rel="stylesheet"
      href="{{ asset('hrcrm/plugins/bower_components/owl.carousel/owl.carousel.min.css') }}"><!--Owl carousel CSS -->
<link rel="stylesheet"
      href="{{ asset('hrcrm/plugins/bower_components/owl.carousel/owl.theme.default.css') }}"><!--Owl carousel CSS -->
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/morrisjs/morris.css') }}">
<style>
    .col-in {padding: 0 20px !important;}
    .fc-event {font-size: 10px !important;}
    .dashboard-settings {padding-bottom: 8px !important;}
    .customChartCss { height: 100% !important; }
    .customChartCss svg { height: 400px; }
    @media (min-width: 769px) {
        #wrapper .panel-wrapper {height: 530px;overflow-y: auto;}
    }
</style>

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
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <h4 class="page-title">Dashboard</h4>
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


                            

       
                        <!-- /.breadcrumb -->
                    </div>


                    <div class="white-box">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 m-b-10" style="display: flex;align-items: center;">
                                <label style="font-size: 13px;margin-bottom: 0;margin-right: 10px;">Select Date Range</label>
                                <div class="input-daterange input-group" id="date-range" style="margin-right: 10px;">
                                    <input type="text" class="form-control" id="start-date" placeholder="@lang('app.startDate')" style="width: 110px;"
                                        value="{{ \Carbon\Carbon::parse($fromDate)->timezone('Asia/Kolkata')->format('d-m-Y') }}"/>
                                    <span class="input-group-addon bg-info b-0 text-white">To</span>
                                    <input type="text" class="form-control" id="end-date" placeholder="@lang('app.endDate')" style="width: 110px;"
                                        value="{{ \Carbon\Carbon::parse($toDate)->timezone('Asia/Kolkata')->format('d-m-Y') }}"/>
                                </div>
                                <button type="button" id="apply-filters" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Apply</button>
                            </div>
                            <div class="col-lg-6 col-md-6 pull-right hidden-xs hidden-sm">
                                {!! Form::open(['id'=>'createProject','class'=>'ajax-form','method'=>'POST']) !!}
                                {!! Form::hidden('dashboard_type', 'admin-client-dashboard') !!}
                                <div class="btn-group dropdown keep-open pull-right m-l-10">
                                    <button aria-expanded="true" data-toggle="dropdown"
                                            class="btn bg-white b-all dropdown-toggle waves-effect waves-light"
                                            type="button"><i class="icon-settings"></i>
                                    </button>
                                    <ul role="menu" class="dropdown-menu  dropdown-menu-right dashboard-settings">
                                            <li class="b-b"><h4>Dashboard Widgets</h4></li>

                                        @foreach ($widgets as $widget)
                                            @php
                                                $wname = \Illuminate\Support\Str::camel($widget->widget_name);
                                            @endphp
                                            <li>
                                                <div class="checkbox checkbox-info ">
                                                    <input id="{{ $widget->widget_name }}" name="{{ $widget->widget_name }}" value="true"
                                                        @if ($widget->status)
                                                         checked
                                                        @endif
                                                            type="checkbox">
                                                  <label for="{{ $widget->widget_name }}">@lang('modules.dashboard.' . $wname)</label>
                                                </div>
                                            </li>
                                        @endforeach

                                        <li>
                                            <button type="button" id="save-form" class="btn btn-success btn-sm btn-block">Save</button>
                                        </li>

                                    </ul>
                                </div>
                                {!! Form::close() !!}
                                
                                
                            </div>
                        </div>
                    </div>

                    <div class="white-box" id="dashboard-content">
                             
                    </div>


                    
   
                </div>
            </div>
        </div>

    </div>
    <!-- end page content --> 
</div>  


@endsection
@section('extrascripts') 
<!-- jQuery -->
<script src="{{ asset('hrcrm/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
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



<script src="{{ asset('hrcrm/plugins/bower_components/morrisjs/morris.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/datatables/responsive.bootstrap.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('hrcrm/js/datatables/buttons.server-side.js') }}"></script>

{{-- {!! $dataTable->scripts() !!} --}}

<script src="{{ asset('hrcrm/js/Chart.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/morrisjs/morris.js') }}"></script>

<script src="{{ asset('hrcrm/plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>

<!--weather icon -->

<script src="{{ asset('hrcrm/plugins/bower_components/calendar/jquery-ui.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/calendar/dist/jquery.fullcalendar.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/calendar/dist/locale-all.js') }}"></script>
{{-- <script src="{{ asset('hrcrm/js/event-calendar.js') }}"></script> --}}
<script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/Chart.min.js') }}"></script>

<script>
//javascript throw error
//throw new Error('This is not an error. This is just to abort javascript');
    var startDate = '';
    var endDate = '';

    function getLatestDate(){
        startDate = $('#start-date').val();
        if (startDate == '') { startDate = null; }
        endDate = $('#end-date').val();
        if (endDate == '') { endDate = null; }

        startDate = encodeURIComponent(startDate);
        endDate = encodeURIComponent(endDate);
    }

    $(function() {
        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: 'dd-mm-yyyy',
            language: 'en',
            autoclose: true
        });
    });
    $('#apply-filters').click(function() {
        getLatestDate();
        loadData();
    })
    
    getLatestDate();
    loadData();

    $('.keep-open .dropdown-menu').on({
        "click":function(e){
        e.stopPropagation();
        }
    });

    $('#save-form').click(function () {
        $.easyAjax({
            url: '{{route('Crm::staff.dashboard.widget', "admin-hr-dashboard")}}',
            container: '#createProject',
            type: "POST",
            redirect: true,
            data: $('#createProject').serialize(),
            success: function(){
                window.location.reload();
            }
        })
    });

    function loadData () {

            var url = '{{route('Crm::staff.dashboard')}}?startDate=' + startDate + '&endDate=' + endDate;

            $.easyAjax({
                url: url,
                container: '#dashboard-content',
                type: "GET",
                success: function (response) {
                    $('#dashboard-content').html(response.view);
                }
            })

        }
</script>
@endsection