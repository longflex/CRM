
<div class="chart-content-bg">
    <div class="row text-center">
        <div class="col-md-6"> 
            <p class="text-muted mb-0 mt-3" id="donation_text1"><?=$currentGraphName.$current_sp;?></p>
            <h2 class="font-weight-normal mb-3">
                <small class="mdi mdi-checkbox-blank-circle text-primary align-middle mr-1"></small>
                <span id="current-donation">₹{{number_format($current_donations)}}</span>
            </h2>
        </div>
        <div class="col-md-6">
            <p class="text-muted mb-0 mt-3" id="donation_text2"><?=$previousGraphName.$previous_sp;?></p>
            <h2 class="font-weight-normal mb-3">
                <small class="mdi mdi-checkbox-blank-circle text-success align-middle mr-1"></small>
                <span id="previous-donation">₹{{number_format($previous_donations)}}</span>
            </h2>
        </div>
    </div>
</div>
 
<div class="dash-item-overlay d-none d-md-block">
    <h5>Today's Earning: ₹{{$today_donations }}</h5>
    <a href="{{ route('Crm::donations') }}" class="btn btn-outline-primary">View Statements
        <i class="mdi mdi-arrow-right ml-2"></i>
    </a>
</div>

<div id="revenue-chart" class="apex-charts mt-3" data-colors="#727cf5,#0acf97">
</div>

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
                name: "<?=$currentGraphName;?>",
                data: [<?=$donationsData;?>]
            }, {
                name: "<?=$previousGraphName;?>",
                data: [<?=$previousDonationsData;?>]
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
                categories: [<?=$graphString;?>],
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
 
        
    }, 
 
    e.prototype.init = function() {
        o("#dash-daterange").daterangepicker({
            singleDatePicker: !0
        }), this.initCharts() //,this.initMaps()
    }, o.Dashboard = new e, o.Dashboard.Constructor = e
}(window.jQuery),
function(t) {
    "use strict";
    t(document).ready(function(e) {
        t.Dashboard.init()
    })
}(window.jQuery);
</script>