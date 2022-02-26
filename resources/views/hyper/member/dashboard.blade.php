@extends('hyper.layout.master')
@section('title', "Members Dashboard")
@section('content')
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-light" id="dash-daterange">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <i class="mdi mdi-calendar-range font-13"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ml-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ml-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Members Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-xl-5 col-lg-6">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">Total Members</h5>
                            <h3 class="mt-3 mb-3">{{$total_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 5.27%</span>
                            </p>
                        </div> 
                    </div>
                </div> 
                @if(Laralum::permissionToAccessModule() === true)
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                            <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">Permanent</h5>
                            <h3 class="mt-3 mb-3">{{$total_permanent_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                            </p>
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">Temporary</h5>
                            <h3 class="mt-3 mb-3">{{$total_temporary_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> 1.08%</span>
                            </p>
                        </div> 
                    </div> 
                </div> 
                @endif
            </div>
            @if(Laralum::permissionToAccessModule() === true)
            <div class="row">
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">Partners</h5>
                            <h3 class="mt-3 mb-3">{{$partners}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i> 7.00%</span>
                            </p>
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Growth">Sponsors</h5>
                            <h3 class="mt-3 mb-3">{{$sponsors}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                            </p>
                        </div> 
                    </div> 
                </div> 
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Growth">CST</h5>
                            <h3 class="mt-3 mb-3">{{(isset($cst) && $cst) ? $cst : 'NA'}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                            </p>
                        </div> 
                    </div> 
                </div> 
            </div> 
            @endif
        </div> 
        @if(Laralum::permissionToAccessModule() === true)
        <div class="col-xl-7 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="javascript:void(0);" class="dropdown-item">Today</a>
                            <a href="javascript:void(0);" class="dropdown-item">Yesterday</a>
                            <a href="javascript:void(0);" class="dropdown-item">Last 7 Days</a>
                            <a href="javascript:void(0);" class="dropdown-item">Last 30 Days</a>
                            <a href="javascript:void(0);" class="dropdown-item">This Month</a>
                            <a href="javascript:void(0);" class="dropdown-item">Custom Range</a>
                        </div>
                    </div>
                    <h4 class="header-title mb-3">Permanent Vs Temporary Members</h4>
                    <div id="high-performing-product" class="apex-charts"
                        data-colors="#727cf5,#e3eaef">
                    </div>
                </div>
            </div> 
        </div>
        @endif
    </div>
    <div class="row">
        <!-- <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 450px;">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0);" class="dropdown-item">Weekly Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Monthly Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                            </div>
                        </div>
                        <h4 class="header-title mb-3">Upcoming Occasions</h4>
                        <div class="table-responsive">
                            <table id="upcomingOctDatatable" class="table table-striped pagination-rounded dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Birthday</th>
                                        <th>Anniversary</th>
                                    </tr>
                                </thead>
                                -- <tbody>
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <img class="mr-2 rounded-circle" src="{% static 'images/users/avatar-2.jpg' %}" width="40" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="mt-0 mb-1">Soren Drouin<small class="font-weight-normal ml-3">18 Jan 2019 11:28 pm</small></h5>
                                                    <span class="font-13">Completed "Design new idea"...</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted font-13">Occasion</span> <br/>
                                            <p class="mb-0">Birthday</p>
                                        </td>
                                        <td class="table-action" style="width: 50px;">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                                    <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody> --
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 450px;">
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0);" class="dropdown-item filter_by_anniversary_occasion">Filter By Anniversary</a>
                                <a href="javascript:void(0);" class="dropdown-item filter_by_birthday_occasion">Filter By Birthday</a>
                                <a href="javascript:void(0);" class="dropdown-item">Send Greetings</a>
                            </div>
                        </div>
                        <h4 class="header-title mb-3">Upcoming Occasions</h4>
                        <div class="row">
                            <div class="col-lg-5">
                                <div data-provide="datepicker-inline" id="date_events" data-date-today-highlight="true" class="calendar-widget" onClick="showTestDate()">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-group mt-2">
                                    <div class="table-responsive">
                                        <table id="upcommingOccasion-datatable" class="table table-striped pagination-rounded dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Occasion</th>
                                                    <!-- <th>Birthday</th>
                                                    <th>Anniversary</th> -->
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
    </div>
</div>     
@endsection
@section('extrascripts')
    <script>
        $(document).ready(function() {
            upcomingOctDatatable();
            var d = new Date();
            var month = d.getMonth()+1;
            var day = d.getDate();
            var output = d.getFullYear() + '-' +
            (month<10 ? '0' : '') + month + '-' +
                (day<10 ? '0' : '') + day;
            upcommingOccasionDataTable(output);
        });
        function upcommingOccasionDataTable(output) {
            $('#upcommingOccasion-datatable').DataTable().destroy();
            let table = $('#upcommingOccasion-datatable');
            let data_id = output;
            table.DataTable({
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                    url: "{{ route('Crm::get_memberOccation_data') }}",
                    type: 'POST',
                    data: function (d) { 
                        d._token = '{{csrf_token()}}';
                        d.filter_by_data_id = data_id;
                        d.filter_by_anniversary_occasion = $('.filter_by_anniversary_occasion').val();
                        d.filter_by_birthday_occasion = $('.filter_by_birthday_occasion').val();
                    },
                },
                columns: [
                    {"data": "name",name: 'leads.name'},
                    {"data": "mobile",name: 'leads.mobile'},
                    {"data": "occasion"},
                    //{"data": "birthday", name: 'leads.date_of_birth'},
                    //{"data": "anniversary", name: 'leads.date_of_anniversary'},
                ]
            });
        }
        function upcomingOctDatatable() {
            $('#upcomingOctDatatable').DataTable().destroy();
            let table = $('#upcomingOctDatatable');
            //let data_id = output;
            table.DataTable({
                order: [['0', 'ASC']],
                lengthMenu: [[10, 25, 50, 100, 500, 1000], [10, 25, 50, 100, 500, 1000]],
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                    url: "{{ route('Crm::get_memberUpcomingOccation_data') }}",
                    type: 'POST',
                    data: function (d) { 
                        d._token = '{{csrf_token()}}';
                        //d.filter_by_data_id = data_id;
                        //d.filter_by_anniversary_occasion = $('.filter_by_anniversary_occasion').val();
                        //d.filter_by_birthday_occasion = $('.filter_by_birthday_occasion').val();
                    },
                },
                columns: [
                    {"data": "name", name: 'leads.name'},
                    {"data": "birthday", name: 'leads.date_of_birth'},
                    {"data": "anniversary", name: 'leads.date_of_anniversary'},
                ]
            });
        }
    </script>
    <script>     
    ! function(o) {
    "use strict";

    function e() {
        this.$body = o("body"), this.charts = []
    }
    e.prototype.initCharts = function() {
        window.Apex = {
            chart: {
                parentHeightOffset: 0,
                toolbar: {
                    show: !1
                }
            },
            grid: {
                padding: {
                    left: 0,
                    right: 0
                }
            },
            colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"]
        };
        var e = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"],
            t = o("#revenue-chart").data("colors");
        t && (e = t.split(","));
        var r = {
            chart: {
                height: 364,
                type: "line",
                dropShadow: {
                    enabled: !0,
                    opacity: .2,
                    blur: 7,
                    left: -7,
                    top: 7
                }
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                curve: "smooth",
                width: 4
            },
            series: [{
                name: "Current Week",
                data: [10, 20, 15, 25, 20, 30, 20]
            }, {
                name: "Previous Week",
                data: [0, 15, 10, 30, 15, 35, 25]
            }],
            colors: e,
            zoom: {
                enabled: !1
            },
            legend: {
                show: !1
            },
            xaxis: {
                type: "string",
                categories: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                tooltip: {
                    enabled: !1
                },
                axisBorder: {
                    show: !1
                }
            },
            yaxis: {
                labels: {
                    formatter: function(e) {
                        return e + "k"
                    },
                    offsetX: -15
                }
            }
        };
        new ApexCharts(document.querySelector("#revenue-chart"), r).render();
        e = ["#727cf5", "#e3eaef"];
        (t = o("#high-performing-product").data("colors")) && (e = t.split(","));
        r = {
            chart: {
                height: 257,
                type: "bar",
                stacked: !0
            },
            plotOptions: {
                bar: {
                    horizontal: !1,
                    columnWidth: "4%"
                }
            },
            dataLabels: {
                enabled: !1
            },
            stroke: {
                show: !0,
                width: 5,
                colors: ["transparent"]
            },
            series: [{
                name: "Permanent",
                data: [{{$permanent_member_c }}]
            }, {
                name: "Temporary",
                data: [{{ $temporary_member_c }}]
            }],
            zoom: {
                enabled: !1
            },
            legend: {
                show: !1
            },
            colors: e,
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                axisBorder: {
                    show: !1
                }
            },
            yaxis: {
                labels: {
                    formatter: function(e) {
                        return e
                    },
                    offsetX: -15
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(e) {
                        return e
                    }
                }
            }
        };
        new ApexCharts(document.querySelector("#high-performing-product"), r).render();
        e = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"];
        (t = o("#average-sales").data("colors")) && (e = t.split(","));
        r = {
            chart: {
                height: 213,
                type: "donut"
            },
            legend: {
                show: !1
            },
            stroke: {
                colors: ["transparent"]
            },
            series: [44, 55, 41, 17],
            labels: ["Direct", "Affilliate", "Sponsored", "E-mail"],
            colors: e,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: "bottom"
                    }
                }
            }]
        };
        new ApexCharts(document.querySelector("#average-sales"), r).render()
    }, e.prototype.initMaps = function() {
        0 < o("#world-map-markers").length && o("#world-map-markers").vectorMap({
            map: "world_mill_en",
            normalizeFunction: "polynomial",
            hoverOpacity: .7,
            hoverColor: !1,
            regionStyle: {
                initial: {
                    fill: "#e3eaef"
                }
            },
            markerStyle: {
                initial: {
                    r: 9,
                    fill: "#727cf5",
                    "fill-opacity": .9,
                    stroke: "#fff",
                    "stroke-width": 7,
                    "stroke-opacity": .4
                },
                hover: {
                    stroke: "#fff",
                    "fill-opacity": 1,
                    "stroke-width": 1.5
                }
            },
            backgroundColor: "transparent",
            markers: [{
                latLng: [40.71, -74],
                name: "New York"
            }, {
                latLng: [37.77, -122.41],
                name: "San Francisco"
            }, {
                latLng: [-33.86, 151.2],
                name: "Sydney"
            }, {
                latLng: [1.3, 103.8],
                name: "Singapore"
            }],
            zoomOnScroll: !1
        })
    }, e.prototype.init = function() {
        o("#dash-daterange").daterangepicker({
            singleDatePicker: !0
        }), this.initCharts(), this.initMaps()
    }, o.Dashboard = new e, o.Dashboard.Constructor = e
}(window.jQuery),
function(t) {
    "use strict";
    t(document).ready(function(e) {
        t.Dashboard.init()
    })
}(window.jQuery);

$(document).on('click','.donation', function(){
    const val = $(this).attr('data-value');
    if(val== 'current-week'){
        $('#donation_text1').text('Current Week');
        $('#donation_text2').text('Previous Week');
    }else if(val== 'current-month'){
        $('#donation_text1').text('Current Month');
        $('#donation_text2').text('Previous Month');
    }else if(val== 'current-year'){
        $('#donation_text1').text('Current Year');
        $('#donation_text2').text('Previous Year');
    }
    
    $.ajax({
        type: "GET",
        url: "/crm/admin/donations/comparison/"+val,
        data: null,
        success: function (data) {
            console.log(data);
            $("#current-donation").html(data.current_donations);
            $("#previous-donation").html(data.previous_donations);
        }, error: function (data) {
        },
    });

});
$('#date_events').datepicker({
  format: "yyyy-mm-dd",
  todayBtn: "linked",
  language: "de",
  daysOfWeekDisabled: "0,6",
  daysOfWeekHighlighted: "4",
  todayHighlight: true,
}).on('changeDate', showTestDate);

function showTestDate(){
 var output = $('#date_events').datepicker('getFormattedDate');
 
  upcommingOccasionDataTable(output);
}


    </script>
@endsection