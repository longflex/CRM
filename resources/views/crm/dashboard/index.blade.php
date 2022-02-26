@extends('hyper.layout.master')
@section('title', "Dashboard")
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
                            <!-- <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    5.27%</span>
                            </p> -->
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
                            <!-- <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    1.08%</span>
                            </p> -->
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
                            <!-- <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    1.08%</span>
                            </p> -->
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
                            <!-- <p class="mb-0 text-muted">
                                <span class="text-danger mr-2"><i class="mdi mdi-arrow-down-bold"></i>
                                    7.00%</span>
                            </p> -->
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
                            <!-- <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    4.87%</span>
                            </p> -->
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
                            <!-- <p class="mb-0 text-muted">
                                <span class="text-success mr-2"><i class="mdi mdi-arrow-up-bold"></i>
                                    4.87%</span>
                            </p> -->
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
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" data-value="current-week" class="dropdown-item donation">Current Week vs Previous
                                Week</a>
                            <!-- item-->
                            <a href="javascript:void(0);" data-value="current-month" class="dropdown-item donation">Current Month vs
                                Previous Month</a>
                            <!-- item-->
                            <a href="javascript:void(0);" data-value="current-year" class="dropdown-item donation">Current Year vs Previous
                                Year</a>
                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item">Custom Date Range</a> -->
                        </div>
                    </div>
                    <h4 class="header-title mb-3">Donations</h4>

                    <div class="chart-content-bg">
                        <div class="row text-center">
                            <div class="col-md-6">
                                <p class="text-muted mb-0 mt-3" id="donation_text1">Current Week</p>
                                <h2 class="font-weight-normal mb-3">
                                    <small class="mdi mdi-checkbox-blank-circle text-primary align-middle mr-1"></small>
                                    <span id="current-donation">{{$donations}}</span>
                                </h2>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted mb-0 mt-3" id="donation_text2">Previous Week</p>
                                <h2 class="font-weight-normal mb-3">
                                    <small class="mdi mdi-checkbox-blank-circle text-success align-middle mr-1"></small>
                                    <span id="previous-donation">{{$weekly_donations}}</span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="dash-item-overlay d-none d-md-block">
                        <h5>Today's Earning: {{$today_donations }}</h5>
                        <a href="{{ route('Crm::donations') }}" class="btn btn-outline-primary">View Statements
                            <i class="mdi mdi-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <div id="revenue-chart" class="apex-charts mt-3" data-colors="#727cf5,#0acf97">
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                    <h4 class="header-title">Donations By Location</h4>
                    <div class="mb-4 mt-4">
                        <div id="world-map-markers" style="height: 224px"></div>
                    </div>

                    <h5 class="mb-1 mt-0 font-weight-normal">Hyderabad</h5>
                    <div class="progress-w-percent">
                        <span class="progress-value font-weight-bold">72k </span>
                        <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" style="width: 72%;" aria-valuenow="72"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <h5 class="mb-1 mt-0 font-weight-normal">Zaheerabad</h5>
                    <div class="progress-w-percent">
                        <span class="progress-value font-weight-bold">39k </span>
                        <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" style="width: 39%;" aria-valuenow="39"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <h5 class="mb-1 mt-0 font-weight-normal">Nambur</h5>
                    <div class="progress-w-percent">
                        <span class="progress-value font-weight-bold">25k </span>
                        <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" style="width: 39%;" aria-valuenow="39"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <h5 class="mb-1 mt-0 font-weight-normal">Kurnool</h5>
                    <div class="progress-w-percent mb-0">
                        <span class="progress-value font-weight-bold">61k </span>
                        <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" style="width: 61%;" aria-valuenow="61"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-xl-6 col-lg-12 order-lg-2 order-xl-1">
            <div class="card">
                <div class="card-body">
                    <a href="" class="btn btn-sm btn-link float-right mb-3">Export
                        <i class="mdi mdi-download ml-1"></i>
                    </a>
                    <h4 class="header-title mt-2">Sponsors by Categories</h4>
                    <div data-simplebar style="max-height: 424px;">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">Aradhana Channel
                                            </h5>
                                            <span class="text-muted font-13">07 April 2018</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">82</h5>
                                            <span class="text-muted font-13">Registered</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">$6,518.18</h5>
                                            <span class="text-muted font-13">Revenue</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">Aradhana Channel
                                            </h5>
                                            <span class="text-muted font-13">07 April 2018</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">2000</h5>
                                            <span class="text-muted font-13">Registered</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">6,518.18</h5>
                                            <span class="text-muted font-13">Revenue</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">Nirikshana
                                                Channel</h5>
                                            <span class="text-muted font-13">07 April 2018</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">82</h5>
                                            <span class="text-muted font-13">Registered</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">$6,518.18</h5>
                                            <span class="text-muted font-13">Revenue</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">Ee TV Channel
                                            </h5>
                                            <span class="text-muted font-13">07 April 2018</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">82</h5>
                                            <span class="text-muted font-13">Registered</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">$6,518.18</h5>
                                            <span class="text-muted font-13">Revenue</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">Ee TV Channel
                                            </h5>
                                            <span class="text-muted font-13">07 April 2018</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">82</h5>
                                            <span class="text-muted font-13">Registered</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">$6,518.18</h5>
                                            <span class="text-muted font-13">Revenue</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">Maa TV Channel
                                            </h5>
                                            <span class="text-muted font-13">07 April 2018</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">82</h5>
                                            <span class="text-muted font-13">Registered</span>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 font-weight-normal">$6,518.18</h5>
                                            <span class="text-muted font-13">Revenue</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive-->
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                    <h4 class="header-title">Graph by Category</h4>

                    <div id="average-sales" class="apex-charts mb-4 mt-4" data-colors="#727cf5,#0acf97,#fa5c7c,#ffbc00">
                    </div>

                    <div data-simplebar style="max-height: 151px;">
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
                        <!-- end timeline -->
                    </div> <!-- end slimscroll -->
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

        <div class="col-xl-3 col-lg-6 order-lg-1">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown"
                            aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                    <h4 class="header-title mb-2">Subscription List</h4>

                    <div data-simplebar style="max-height: 424px;">
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
                        <!-- end timeline -->
                    </div> <!-- end slimscroll -->
                </div>
                <!-- end card-body -->
            </div>
            <!-- end card-->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>
@endsection
@section('extrascripts')
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
                data: [{{ implode(', ', $permanent_member_c) }}]
            }, {
                name: "Temporary",
                data: [{{ implode(', ', $temporary_member_c) }}]
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
        }, error: function (data) {},
    });

});



</script>
@endsection