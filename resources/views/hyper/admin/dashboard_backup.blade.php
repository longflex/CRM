@extends('hyper.layout.master')
@section('title', "Dashboard")

<?php if(Laralum::hasPermission('laralum.admin.dashboard')){ ?>
@section('content')

<div class="col-xl-12">
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
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-5 col-lg-8">

            <div class="row">
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Customers">
                                Total Members</h5>
                            <h3 class="mt-3 mb-3">{{$total_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    5.27%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">
                                Permanent</h5>
                            <h3 class="mt-3 mb-3">{{$total_permanent_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    1.08%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Number of Orders">
                                Temporary</h5>
                            <h3 class="mt-3 mb-3">{{$total_temporary_members}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    1.08%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

            <div class="row">
                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Average Revenue">
                                Partners</h5>
                            <h3 class="mt-3 mb-3">{{$partners}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    7.00%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Growth">Sponsors</h5>
                            <h3 class="mt-3 mb-3">{{$sponsors}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    4.87%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-lg-4">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-right">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted font-weight-normal mt-0" title="Growth">CST</h5>
                            <h3 class="mt-3 mb-3">{{(isset($cst) && $cst) ? $cst : 'NA'}}</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    4.87%</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

        </div> <!-- end col -->

        <div class="col-xl-7  col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Today</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Yesterday</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Last 7 Days</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Last 30 Days</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">This Month</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Custom Range</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export</a>
                        </div>
                    </div>
                    <h4 class="header-title mb-3">Permanent Vs Temporary Members</h4>

                    <div id="high-performing-product" class="apex-charts" data-colors="#727cf5,#e3eaef">
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">


        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <h4 class="header-title mb-3">Donations</h4>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control date filter_by_current_Date" placeholder="-- Filter By Current Date Range --" title="-- Filter By Current Date Range --" name="filter_by_current_Date" value="" />
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <input type="text" class="form-control date filter_by_previous_Date" placeholder="-- Filter By Previous Date Range --" title="-- Filter By Previous Date Range --" name="filter_by_previous_Date" value="" />
                                        <div class="input-group-append">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="dropdown float-right">
                                <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="mdi mdi-dots-vertical"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0);" data-value="current-week" class="dropdown-item donation">Current Week vs Previous
                                        Week</a>
                                    <a href="javascript:void(0);" data-value="current-month" class="dropdown-item donation">Current Month vs
                                        Previous Month</a>
                                    <a href="javascript:void(0);" data-value="current-year" class="dropdown-item donation">Current Year vs Previous
                                        Year</a>
                                    <a href="javascript:void(0);" data-value="date-range" class="dropdown-item donation">Current vs Previous
                                        Date Range</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="donation-graph"></div>
                </div>
            </div>
        </div>






        
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 540px;">
                        <!-- <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div> -->
                        <h4 class="header-title">Donations By Location</h4>
                        <div class="mb-4 mt-4">
                            <div id="world-map-markers" style="height: 224px"></div>
                        </div>
                        @php
                        $donationsByLocationsSum = 0;
                        if(!empty($donationsByLocations)){
                            foreach($donationsByLocations as $val){
                                $donationsByLocationsSum = $donationsByLocationsSum + $val->branchTotalDonation;
                            }
                        }
                        @endphp

                        @forelse($donationsByLocations as $donationsByLocation)
                        <h5 class="mb-1 mt-0 font-weight-normal">{{$donationsByLocation->branch}}</h5>
                        <div class="progress-w-percent">
                            <div class="row">
                                <div class="col-md-9">
                                   <div class="progress progress-sm">
                                        <div class="progress-bar" role="progressbar" style="width: {{(100 * ($donationsByLocation->branchTotalDonation))/($donationsByLocationsSum)}}%;" aria-valuenow="{{(100 * ($donationsByLocationsSum - $donationsByLocation->branchTotalDonation))/($donationsByLocationsSum)}}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div> 
                                </div>
                                <div class="col-md-3">
                                    <p>₹{{number_format($donationsByLocation->branchTotalDonation)}}</p>
                                </div>
                            </div>
                            
                            
                        </div>
                        @empty
                        <div>No Data Found.</div>
                        @endforelse
                    </div>
                    
                </div>
            </div>
        </div> 
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-7">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 340px;">
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="header-title mt-2">Sponsors by Categories</h4>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control date filter_by_Date" placeholder="-- Filter By Date Range --" title="-- Filter By Date Range --" name="filter_by_Date" value="" />
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="dropdown float-right mt-1">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="javascript:void(0);" data-value="1" class="dropdown-item sponsorCatDonation">Current Date</a>
                                        <a href="javascript:void(0);" data-value="2" class="dropdown-item sponsorCatDonation">Current Month</a>
                                        <a href="javascript:void(0);" data-value="3" class="dropdown-item sponsorCatDonation">Current Year</a>
                                    </div>
                                </div>
                                <a href="" class="btn btn-sm btn-link float-right mb-3">Export
                                    <i class="mdi mdi-download ml-1"></i>
                                </a>  
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table w-100 dt-responsive nowrap" id="sponsor-category-datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Category</th>
                                        <th>Count</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <!-- <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div> -->
                    <h4 class="header-title">Graph by Category</h4>

                    <div id="average-sales" class="apex-charts mb-4 mt-4" data-colors="#727cf5,#0acf97,#fa5c7c,#ffbc00">
                    </div>

                    <!-- <div data-simplebar style="max-height: 151px;">
                        <div class="chart-widget-list">
                            <p>
                                <i class="mdi mdi-square text-primary"></i> Aradhana Channel
                                <span class="float-right">$300.56</span>
                            </p>
                            <p>
                                <i class="mdi mdi-square text-danger"></i> Nirikshana
                                <span class="float-right">$135.18</span>
                            </p>
                            <p>
                                <i class="mdi mdi-square text-success"></i> Ee TV
                                <span class="float-right">$48.96</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                            <p class="mb-0">
                                <i class="mdi mdi-square text-warning"></i> Land Donors
                                <span class="float-right">$154.02</span>
                            </p>
                        </div>
                        
                    </div> -->
                </div> 
            </div> 
        </div>

        <div class="col-xl-3 col-lg-3 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <div data-simplebar style="height: 340px;">
                        <h4 class="header-title mb-2">Subscription List</h4>
                        <div data-simplebar style="max-height: 424px;">
                            <div class="chart-widget-list">
                                @forelse($subscriptionList as $subscription)
                                <p>
                                    <i class="mdi mdi-square text-primary"></i> {{$subscription->purpose}}
                                    <span class="float-right">₹{{$subscription->totalDonation}}</span>
                                </p>
                                @empty
                                <div>No Data Found.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php }else{?>
@section('content')

<?php }?>
@endsection
@section('extrascripts')
<script>
$(document).ready(function(){
    sponsorCategoryDataTable(1);
    $(function() {
        $('input[name="filter_by_Date"]').daterangepicker({
            autoUpdateInput: false,
            applyButtonClasses: 'btn btn-warning',
            drops: ('down'),
            autoApply: false,
            locale: {
                cancelLabel: 'Clear',
            }
        });
        $('input[name="filter_by_Date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            sponsorCategoryDataTable(1);
        });
        $('input[name="filter_by_Date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            sponsorCategoryDataTable(1);
        });
    });
    $(function() {
        $('input[name="filter_by_current_Date"]').daterangepicker({
            autoUpdateInput: false,
            applyButtonClasses: 'btn btn-warning',
            drops: ('down'),
            autoApply: false,
            locale: {
                cancelLabel: 'Clear',
            }
        });
        $('input[name="filter_by_current_Date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            //sponsorCategoryDataTable(1);
        });
        $('input[name="filter_by_current_Date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            //sponsorCategoryDataTable(1);
        });
    });
    $(function() {
        $('input[name="filter_by_previous_Date"]').daterangepicker({
            autoUpdateInput: false,
            applyButtonClasses: 'btn btn-warning',
            drops: ('down'),
            autoApply: false,
            locale: {
                cancelLabel: 'Clear',
            }
        });
        $('input[name="filter_by_previous_Date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            //sponsorCategoryDataTable(1);
        });
        $('input[name="filter_by_previous_Date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            //sponsorCategoryDataTable(1);
        });
    });
});



$(document).on('click','.sponsorCatDonation', function(){
    const val = $(this).attr('data-value');
    sponsorCategoryDataTable(val);
});
function sponsorCategoryDataTable(dataId) {
    $('#sponsor-category-datatable').DataTable().destroy();
    let table = $('#sponsor-category-datatable');

    //dashbordCountData(call_status);
    table.DataTable(
        {
            order: [['2', 'DESC']],
            serverSide: true,
            responsive: true,
            processing: true,
            ajax: {
            url: "{{ route('Crm::sponsor_category_admin_data') }}",
            type: 'POST',
            data: function (d) {
                    d._token = '{{ csrf_token() }}';
                    d.filter_by_dataId = dataId;
                    d.filter_by_campaign = $('#filter_by_campaign').val();
                    d.filter_by_agent = $('#filter_by_agent').val();
                    d.filter_by_Date = $('.filter_by_Date').val();
                },
            },
            columns: [
                {"data": "category", name: 'donation_purpose.purpose'},
                {"data": "count", name: 'count', searchable: false},
                {"data": "revenue", name: 'totalDonation', searchable: false},
            ]
        }
    );
}

//, name: 'leads.member_id'

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
                    data: [<?=$donationsWeekData;?>]
                }, {
                    name: "Previous Week",
                    data: [<?=$donationsPrWeekData;?>]
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
                            return e + ""
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
                            columnWidth: "20%"
                        }
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        show: !0,
                        width: 2,
                        colors: ["transparent"]
                    },
                    series: [{
                        name: "Permanent",
                        data: [<?= implode(", ", $permanent_member_c) ?>]
                    }, {
                        name: "Temporary",
                        data: [<?= implode(", ", $temporary_member_c) ?>]
                    }],
                    zoom: {
                        enabled: !1
                    },
                    legend: {
                        show: !1
                    },
                    colors: e,
                    xaxis: {
                        categories: ["Jan", "Feb", "Mar"],
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
            e = ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00", "#e0d2a6"];
            (t = o("#average-sales").data("colors")) && (e = t.split(","));
            r = {
                    chart: {
                        height: 250,
                        type: "donut"
                    },
                    legend: {
                        show: !1
                    },
                    stroke: {
                        colors: ["transparent"]
                    },
                    series: [<?=$sum_Amounts;?>],
                    labels: [<?=$purposes;?>],
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
        }, 
        e.prototype.initMaps = function() {
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
        }, 
        e.prototype.init = function() {
            o("#dash-daterange").daterangepicker({
                singleDatePicker: !0
            }), this.initCharts(), this.initMaps()
        }, 
        o.Dashboard = new e, o.Dashboard.Constructor = e
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
    }else if(val== 'date-range'){
        $('#donation_text1').text('Current Date Range');
        $('#donation_text2').text('Previous Date Range');
    }
    //filter_by_current_Date  filter_by_previous_Date
    //filter_by_donation_Date donations-comparison Crm
    var filter_by_current_Date = $('.filter_by_current_Date').val();
    var filter_by_previous_Date = $('.filter_by_previous_Date').val();
    if(val== 'date-range'){
        if(filter_by_current_Date == "" || filter_by_previous_Date == ""){
            alert('Please set current and previous date range');
            return;
        }
    }
    
    $.ajax({
        type: "GET",
        url: "{{ route('Crm::donations-comparison') }}",
        data: {
                _token : "{{ csrf_token() }}",
                val : val,
                filter_by_current_Date : filter_by_current_Date,
                filter_by_previous_Date : filter_by_previous_Date
            },
        success: function (data) {
            //console.log(data);
            var n1 = 0;
            var n2 = 0;
            n1 = String(data.current_donations).replace(/(.)(?=(\d{3})+$)/g,'$1,');
            n2 = String(data.previous_donations).replace(/(.)(?=(\d{3})+$)/g,'$1,');
            $("#current-donation").html('₹'+n1);
            $("#previous-donation").html('₹'+n2);
        }, error: function (data) {},
    });

});

$.ajax({
        type: "GET",
        url: "{{ route('Crm::dashboard_graph') }}",
        data: {
                _token : "{{ csrf_token() }}",
                // val : val,
                // filter_by_current_Date : filter_by_current_Date,
                // filter_by_previous_Date : filter_by_previous_Date
            },
        success: function (data) {
            $("#donation-graph").html(data);
            
            //console.log(data);
            // var n1 = 0;
            // var n2 = 0;
            // n1 = String(data.current_donations).replace(/(.)(?=(\d{3})+$)/g,'$1,');
            // n2 = String(data.previous_donations).replace(/(.)(?=(\d{3})+$)/g,'$1,');
            // $("#current-donation").html('₹'+n1);
            // $("#previous-donation").html('₹'+n2);
        }, error: function (data) {},
    });

</script>
@endsection







dashboard controller backup
<?php

namespace App\Http\Controllers\Crm;

use App\Lead;
use App\Donation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Laralum\Laralum;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $dashboard;

    public function __construct(DashboardService $dashboard)
    {
        $this->dashboard = $dashboard;
    }
    public function index()
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        $total_members = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('client_id', $client_id)
                        ->count();
        $total_temporary_members = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('account_type', 'Temporary')
                        ->where('client_id', $client_id)
                        ->count();
        $total_permanent_members = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('account_type', 'Permanent')
                        ->where('client_id', $client_id)
                        ->count();
        $temporary_members = Lead::select(DB::raw('count(*) as member'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Temporary')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();
        $permanent_members = Lead::select(DB::raw('count(*) as member'), 
                        DB::raw('MONTHNAME(created_at) as monthname'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Permanent')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();
        $partners = Lead::select(DB::raw('count(*) as member'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Temporary')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();
        $sponsors = Lead::select(DB::raw('count(*) as member'), 
                        DB::raw('MONTHNAME(created_at) as monthname'))
                        ->where('lead_status', 3)
                        ->where('account_type', 'Permanent')
                        ->where('client_id', $client_id)
                        ->groupBy(DB::raw('MONTH(created_at)'))
                        ->get();
        $partners = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('member_type', 'like','%Partner%')
                        ->where('client_id', $client_id)
                        ->count();
        $sponsors = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('member_type', 'like', '%Sponsor%')
                        ->where('client_id', $client_id)
                        ->count();
        $investor = Lead::select('count(*) as allcount')
                        ->where('lead_status', 3)
                        ->where('member_type', 'like','%investor%')
                        ->where('client_id', $client_id)
                        ->count();
        $donations = Donation::whereBetween('donation_date', 
                                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->where('client_id', $client_id)
                                // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                //     return $query->where('created_by', Laralum::loggedInUser()->id);
                                // })
                                ->sum('amount');
        $startOfWeek = Carbon::now()->startOfWeek()->subDays(7);
        $endOfWeek = Carbon::now()->endOfWeek()->subDays(7);
        $weekly_donations = Donation::whereBetween('donation_date', [$startOfWeek, $endOfWeek])
                                    ->where('client_id', $client_id)
                                    // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                    //     return $query->where('created_by', Laralum::loggedInUser()->id);
                                    // })
                                    ->sum('amount');
        // $today_date = Carbon::today();
        // $today_donations = Donation::where('donation_date','=', $today_date)
        //                             ->where('client_id', $client_id)
        //                             ->sum('amount');
        $temporary_member_c = [];
        foreach($temporary_members as $k){
            $temporary_member_c[] = $k->member;
        }  
        $permanent_member_c = [];
        $month_name = [];
        foreach($permanent_members as $k){
            $permanent_member_c[] = $k->member;
            $month_name[] = $k->monthname;
        }
        $subscriptionList = [];
        $subscriptionList = DB::table('donation_purpose')
                    ->leftJoin('donations', 'donation_purpose.id', '=', 'donations.donation_purpose')
                    ->select('donation_purpose.purpose', DB::raw("SUM(donations.amount) as totalDonation") )
                    ->where('donations.client_id', $client_id)
                    // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                    //     return $query->where('donations.created_by', Laralum::loggedInUser()->id);
                    // })
                    ->groupBy('donation_purpose.id')
                    ->get();
        $sum_Amounts = [];
        $purposes = []; 
        if(!empty($subscriptionList)){
            foreach ($subscriptionList as $key => $value) {
                $sum_Amounts[] .= (int)$value->totalDonation;
                $purposes[] .= (string)$value->purpose;
            }
            $sum_Amounts = implode(', ', $sum_Amounts); 
            $purposes = '"' . implode('", "', $purposes) . '"';
        }else{
            $sum_Amounts = ""; 
            $purposes = "";
        }          
        
        $today_date = Carbon::today();
        $today_donations = Donation::where('donation_date','=', $today_date)
                                    ->where('client_id', $client_id)
                                    ->sum('amount');
        $donationsWeek = [];
        $donationsWeek = DB::table('donations')
                        ->select('created_at', DB::raw('SUM(amount) as totD'),DB::raw("DAYNAME(created_at) as dayname"))
                        ->whereBetween('donation_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->where('client_id', $client_id)
                        // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                        //     return $query->where('created_by', Laralum::loggedInUser()->id);
                        // })
                        ->groupBy('dayname')
                        ->get();
        $donationsWeekData=array_fill(0,7,0);
        if(!empty($donationsWeek)){    
            foreach ($donationsWeek as $key => $value) {
                if($value->dayname == 'Monday'){
                    $donationsWeekData[0] = (int)$value->totD;
                }elseif($value->dayname == 'Tuesday'){
                    $donationsWeekData[1] = (int)$value->totD;
                }elseif($value->dayname == 'Wednesday'){
                    $donationsWeekData[2] = (int)$value->totD; 
                }elseif($value->dayname == 'Thursday'){
                    $donationsWeekData[3] = (int)$value->totD;
                }elseif($value->dayname == 'Friday'){
                    $donationsWeekData[4] = (int)$value->totD;
                }elseif($value->dayname == 'Saturday'){
                    $donationsWeekData[5] = (int)$value->totD;
                }elseif($value->dayname == 'Sunday'){
                    $donationsWeekData[6] = (int)$value->totD;
                }
            }
            $donationsWeekData = implode(', ', $donationsWeekData);
        }else{
            $donationsWeekData = "";
        } 
        
        
        /*$previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last monday midnight",$previous_week);
        $end_week = strtotime("next sunday",$start_week);*/
        $donationsPrWeek = [];
        $donationsPrWeek = DB::table('donations')
                        ->select('donation_date', DB::raw('SUM(amount) as totD'),DB::raw("DAYNAME(donation_date) as dayname"))
                        ->whereBetween('donation_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                        // ->where('client_id', $client_id)
                        //     ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                        //     return $query->where('created_by', Laralum::loggedInUser()->id);
                        // })
                        ->groupBy('dayname')
                        ->get();
        $donationsPrWeekData=array_fill(0,7,0);

        if(!empty($donationsPrWeek)){
            foreach ($donationsPrWeek as $key => $value) {
                if($value->dayname == 'Monday'){
                    $donationsPrWeekData[0] = (int)$value->totD;
                }elseif($value->dayname == 'Tuesday'){
                    $donationsPrWeekData[1] = (int)$value->totD;
                }elseif($value->dayname == 'Wednesday'){
                    $donationsPrWeekData[2] = (int)$value->totD; 
                }elseif($value->dayname == 'Thursday'){
                    $donationsPrWeekData[3] = (int)$value->totD;
                }elseif($value->dayname == 'Friday'){
                    $donationsPrWeekData[4] = (int)$value->totD;
                }elseif($value->dayname == 'Saturday'){
                    $donationsPrWeekData[5] = (int)$value->totD;
                }elseif($value->dayname == 'Sunday'){
                    $donationsPrWeekData[6] = (int)$value->totD;
                }
            }
            $donationsPrWeekData = implode(', ', $donationsPrWeekData);
        }else{
            $donationsPrWeekData = "";
        } 
        
        
        $donationsByLocations =[];
        $donationsByLocations = DB::table('branch')
                    ->leftJoin('donations', 'branch.branch', '=', 'donations.location')
                    ->select('branch.branch', DB::raw("SUM(donations.amount) as branchTotalDonation") )
                    ->where('branch.client_id', $client_id)
                    ->where('donations.client_id', $client_id)
                    // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                    //     return $query->where('donations.created_by', Laralum::loggedInUser()->id);
                    // })
                    ->groupBy('branch.branch')
                    ->get();

        /*$donationsByLocationsSum = 0;            
        if($donationsByLocations){
            foreach ($donationsByLocations as $key => $value) {
                $donationsByLocationsSum = $donationsByLocationsSum + $value->branchTotalDonation;  
            }
            foreach ($donationsByLocations as $key => $value) {
                $donationsByLocationsPercentage = (100 * ($donationsByLocationsSum - $value->branchTotalDonation))/($donationsByLocationsSum);

                $donationsByLocations->percentage .= 1111; 
            }
        }*/            
        // echo "<pre>";//   0, 512, 210, 1456, 1501, 1100, 0 location
        // print_r($donationsByLocations);die;          
        return view('hyper.admin.dashboard', [
                'total_members' => $total_members, 
                'total_temporary_members' => $total_temporary_members, 
                'total_permanent_members' => $total_permanent_members,
                'temporary_member_c' => $temporary_member_c,
                'permanent_member_c' => $permanent_member_c,
                'month_name' => $month_name,
                'partners' => $partners,
                'sponsors' => $sponsors,
                'investor' => $investor,
                'donations' => $donations,
                'sum_Amounts' => $sum_Amounts,
                'purposes' => $purposes,
                'weekly_donations' => $weekly_donations,
                'today_donations' => $today_donations,
                'subscriptionList' => $subscriptionList,
                'donationsWeekData' => $donationsWeekData,
                'donationsPrWeekData' => $donationsPrWeekData, 
                'donationsByLocations' => $donationsByLocations
            ]); 
    }

    public function donationGraph(Request $request)
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        $donations = Donation::whereBetween('donation_date', 
                                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->where('client_id', $client_id)
                                // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                //     return $query->where('created_by', Laralum::loggedInUser()->id);
                                // })
                                ->sum('amount');
        $startOfWeek = Carbon::now()->startOfWeek()->subDays(7);
        $endOfWeek = Carbon::now()->endOfWeek()->subDays(7);
        $weekly_donations = Donation::whereBetween('donation_date', [$startOfWeek, $endOfWeek])
                                    ->where('client_id', $client_id)
                                    // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                    //     return $query->where('created_by', Laralum::loggedInUser()->id);
                                    // })
                                    ->sum('amount');
        $donationsWeek = [];
        $donationsWeek = DB::table('donations')
                        ->select('created_at', DB::raw('SUM(amount) as totD'),DB::raw("DAYNAME(created_at) as dayname"))
                        ->whereBetween('donation_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                        ->where('client_id', $client_id)
                        // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                        //     return $query->where('created_by', Laralum::loggedInUser()->id);
                        // })
                        ->groupBy('dayname')
                        ->get();
        $donationsWeekData=array_fill(0,7,0);
        if(!empty($donationsWeek)){    
            foreach ($donationsWeek as $key => $value) {
                if($value->dayname == 'Monday'){
                    $donationsWeekData[0] = (int)$value->totD;
                }elseif($value->dayname == 'Tuesday'){
                    $donationsWeekData[1] = (int)$value->totD;
                }elseif($value->dayname == 'Wednesday'){
                    $donationsWeekData[2] = (int)$value->totD; 
                }elseif($value->dayname == 'Thursday'){
                    $donationsWeekData[3] = (int)$value->totD;
                }elseif($value->dayname == 'Friday'){
                    $donationsWeekData[4] = (int)$value->totD;
                }elseif($value->dayname == 'Saturday'){
                    $donationsWeekData[5] = (int)$value->totD;
                }elseif($value->dayname == 'Sunday'){
                    $donationsWeekData[6] = (int)$value->totD;
                }
            }
            $donationsWeekData = implode(', ', $donationsWeekData);
        }else{
            $donationsWeekData = "";
        } 
        
        
        /*$previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last monday midnight",$previous_week);
        $end_week = strtotime("next sunday",$start_week);*/
        $donationsPrWeek = [];
        $donationsPrWeek = DB::table('donations')
                        ->select('donation_date', DB::raw('SUM(amount) as totD'),DB::raw("DAYNAME(donation_date) as dayname"))
                        ->whereBetween('donation_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                        // ->where('client_id', $client_id)
                        //     ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                        //     return $query->where('created_by', Laralum::loggedInUser()->id);
                        // })
                        ->groupBy('dayname')
                        ->get();
        $donationsPrWeekData=array_fill(0,7,0);

        if(!empty($donationsPrWeek)){
            foreach ($donationsPrWeek as $key => $value) {
                if($value->dayname == 'Monday'){
                    $donationsPrWeekData[0] = (int)$value->totD;
                }elseif($value->dayname == 'Tuesday'){
                    $donationsPrWeekData[1] = (int)$value->totD;
                }elseif($value->dayname == 'Wednesday'){
                    $donationsPrWeekData[2] = (int)$value->totD; 
                }elseif($value->dayname == 'Thursday'){
                    $donationsPrWeekData[3] = (int)$value->totD;
                }elseif($value->dayname == 'Friday'){
                    $donationsPrWeekData[4] = (int)$value->totD;
                }elseif($value->dayname == 'Saturday'){
                    $donationsPrWeekData[5] = (int)$value->totD;
                }elseif($value->dayname == 'Sunday'){
                    $donationsPrWeekData[6] = (int)$value->totD;
                }
            }
            $donationsPrWeekData = implode(', ', $donationsPrWeekData);
        }else{
            $donationsPrWeekData = "";
        }
        $today_date = Carbon::today();
        $today_donations = Donation::where('donation_date','=', $today_date)
                                    ->where('client_id', $client_id)
                                    ->sum('amount');
        return view('hyper.admin.donation_graph', [
                'donations' => $donations,
                'weekly_donations' => $weekly_donations,
                'today_donations' => $today_donations,
                //'subscriptionList' => $subscriptionList,
                'donationsWeekData' => $donationsWeekData,
                'donationsPrWeekData' => $donationsPrWeekData, 
                //'donationsByLocations' => $donationsByLocations
            ]); 
    }

    public function donationsComparison(Request $request)
    {
        if (Laralum::loggedInUser()->reseller_id == 0) {
            $client_id = Laralum::loggedInUser()->id;
        } else {
            $client_id = Laralum::loggedInUser()->reseller_id;
        }
        if ($request->val == 'current-week') {
            $current_donations = Donation::whereBetween('donation_date', 
                                            [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
            $startOfWeek = Carbon::now()->startOfWeek()->subDays(7);
            $endOfWeek = Carbon::now()->endOfWeek()->subDays(7);
            $previous_donations = Donation::whereBetween('donation_date', [$startOfWeek, $endOfWeek])
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
        } elseif($request->val == 'current-month') {
            $current_donations = Donation::whereMonth('donation_date', Carbon::now()->month)
                                            ->whereYear('donation_date', Carbon::now()->year)
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
            $previous_donations = Donation::whereMonth('donation_date', 
                                            Carbon::now()->subMonth()->month)
                                            ->whereYear('donation_date', Carbon::now()->year)
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('donations.created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
        } elseif($request->val == 'current-year') {
            $current_donations = Donation::whereYear('donation_date', Carbon::now()->year)
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('donations.created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
                                            // ->select('amount','donation_date','id')
                                            // ->get();
            $previous_donations = Donation::whereYear('donation_date', date('Y', strtotime('-1 year')))
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('donations.created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');     
        }elseif($request->val == 'date-range') {
            $currentData = explode(' - ', $request->filter_by_current_Date);
            $previousData = explode(' - ', $request->filter_by_previous_Date);
            $current_donations = Donation::whereBetween('donation_date', [date("Y-m-d", strtotime($currentData[0])), date("Y-m-d", strtotime($currentData[1]))])
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
            $previous_donations = Donation::whereBetween('donation_date', [date("Y-m-d", strtotime($previousData[0])), date("Y-m-d", strtotime($previousData[1]))])
                                            ->where('client_id', $client_id)
                                            // ->when(Laralum::loggedInUser()->id != 1, function ($query) {
                                            //         return $query->where('donations.created_by', Laralum::loggedInUser()->id);
                                            //     })
                                            ->sum('amount');
        }
        return response()->json([
            'previous_donations' => $previous_donations,
            'current_donations' => $current_donations,
        ]);
    }

    public function sponsor_category_admin_data(Request $request)
    {
        $dashboards = $this->dashboard->getSponsorCategoryForTable($request);
        return $this->dashboard->sponsorCategoryDataTable($dashboards);
    }
}
