<link rel="stylesheet" href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}">

<div class="row dashboard-stats front-dashboard">
    @if( in_array('total_leaves_approved',$activeWidgets))
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('Crm::leaves') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-xs-3">
                            <div><span class="bg-success-gradient"><i class="fa fa-sign-out"></i></span></div>
                        </div>
                        <div class="col-xs-9 text-right">
                            <span class="widget-title"> Total Leaves Approved</span><br>
                            <span class="counter">{{ $totalLeavesApproved }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
    @if(in_array('total_new_employee',$activeWidgets))
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('Crm::staff') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-xs-3">
                            <div><span class="bg-warning-gradient"><i class="icon-user"></i></span></div>
                        </div>
                        <div class="col-xs-9 text-right">
                            <span class="widget-title"> Total New Employee</span><br>
                            <span class="counter">{{ $totalNewEmployee }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
    @if( in_array('total_employee_exits',$activeWidgets))
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('Crm::staff') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-xs-3">
                            <div><span class="bg-danger-gradient"><i class="icon-user"></i></span></div>
                        </div>
                        <div class="col-xs-9 text-right">
                            <span class="widget-title"> Total Employee Exits</span><br>
                            <span class="counter">{{ $totalEmployeeExits }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
    @if( in_array('average_attendance',$activeWidgets))
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('Crm::attendance') }}">
                <div class="white-box">
                    <div class="row">
                        <div class="col-xs-3">
                            <div><span class="bg-inverse-gradient"><i class="icon-user"></i></span></div>
                        </div>
                        <div class="col-xs-9 text-right">
                            <span class="widget-title"> Average Attendance</span><br>
                            <span class="counter">{{ $averageAttendance }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endif
</div>
<div class="row">
    @if( in_array('department_wise_employee',$activeWidgets))
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">Department Wise Employee
                    <a href="javascript:;" data-chart-id="department_wise_employees" class="text-dark pull-right download-chart">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if(!empty(json_decode($departmentWiseEmployee)))
                                    <div>
                                        <canvas id="department_wise_employees"></canvas>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="empty-space" style="height: 200px;">
                                            <div class="empty-space-inner">
                                                <div class="icon" style="font-size:30px"><i class="icon-user"></i></div>
                                                <div class="title m-b-15">No Department Wise Employee</div>
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
    @endif
    @if( in_array('designation_wise_employee',$activeWidgets))
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">Designation Wise Employee
                    <a href="javascript:;" data-chart-id="designation_wise_employees" class="text-dark pull-right download-chart">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
           
                                @if(!empty(json_decode($designationWiseEmployee)))
                                    <div>
                                        <canvas id="designation_wise_employees"></canvas>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="empty-space" style="height: 200px;">
                                            <div class="empty-space-inner">
                                                <div class="icon" style="font-size:30px"><i class="icon-user"></i></div>
                                                <div class="title m-b-15">No Designation Wise Employee</div>
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
    @endif

    @if( in_array('gender_wise_employee',$activeWidgets))
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">Gender Wise Employee
                    <a href="javascript:;" data-chart-id="gender_wise_employees" class="text-dark pull-right download-chart">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if(!empty(json_decode($genderWiseEmployee)))
                                    <div>
                                        <canvas id="gender_wise_employees" ></canvas>
                                    </div>
                                @else
                                    <div class="text-center">
                                        <div class="empty-space" style="height: 200px;">
                                            <div class="empty-space-inner">
                                                <div class="icon" style="font-size:30px"><i class="icon-user"></i></div>
                                                <div class="title m-b-15">No Gender Wise Employee</div>
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
    @endif


    @if( in_array('leaves_taken',$activeWidgets))
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">Leaves Taken</div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Leaves Taken</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leavesTakens as $leavesTaken)
                                
                                <tr>
                                    <td>
                                        <div class="row truncate"><div class="col-sm-12 col-xs-12"><a href="{{ route('Crm::staff_details', $leavesTaken->id) }}">{{ ucwords($leavesTaken->name) }}</a></div></div>
                                        
                                    </td>
                                    <td>
                                        <label class="label label-success">{{ $leavesTaken->employeeLeaveCount }}</label>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2">
                                        No leaves taken.
                                    </td>
                                    
                                </tr>
                               
                            @endforelse
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if( in_array('late_attendance_mark',$activeWidgets))
        <div class="col-md-6">
            <div class="panel panel-inverse">
                <div class="panel-heading">Late Attendance Mark</div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Late Mark</th>   
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lateAttendanceMarks as $lateAttendanceMark)
                                
                                <tr>
                                    <td>
                                        <div class="row truncate"><div class="col-sm-12 col-xs-12"><a href="{{ route('Crm::staff_details', $lateAttendanceMark->id) }}">{{ ucwords($lateAttendanceMark->name) }}</a></div></div>
                                        
                                    </td>
                                    <td>
                                        <label class="label label-success">{{ $lateAttendanceMark->employeeLateCount }}</label>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2">
                                        No late attendance mark found.
                                    </td>
                                    
                                </tr>
                               
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="{{ asset('js/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/morrisjs/morris.js') }}"></script>
<script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
<script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/jquery.fullcalendar.js') }}"></script>
<script src="{{ asset('plugins/bower_components/calendar/dist/locale-all.js') }}"></script>
<script src="{{ asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
    $(document).ready(function () {
        @if(!empty(json_decode($departmentWiseEmployee)))
            function departmentWiseEmployeePieChart(departmentWiseEmployee) {
                var ctx2 = document.getElementById("department_wise_employees");
                var data = new Array();
                var color = new Array();
                var labels = new Array();
                var total = 0;

                $.each(departmentWiseEmployee, function(key,val){
                    labels.push(val.department);
                    data.push(parseInt(val.totalEmployee));
                    total = total+parseInt(val.totalEmployee);
                    color.push(getRandomColor());
                });

                // labels.push('Total '+total);
                var chart = new Chart(ctx2,{
                    "type":"doughnut",
                    "data":{
                        "labels":labels,
                        "datasets":[{
                            "data":data,
                            "backgroundColor":color
                        }]
                    }
                });
                chart.canvas.parentNode.style.height = '470px';
            }
            departmentWiseEmployeePieChart(jQuery.parseJSON('{!! $departmentWiseEmployee !!}'));

        @endif
        @if(!empty(json_decode($designationWiseEmployee)))
            function designationWiseEmployeePieChart(designationWiseEmployee) {
                var ctx2 = document.getElementById("designation_wise_employees");
                var data = new Array();
                var color = new Array();
                var labels = new Array();
                var total = 0;

                $.each(designationWiseEmployee, function(key,val){
                    labels.push(val.designation);
                    data.push(parseInt(val.totalEmployee));
                    total = total+parseInt(val.totalEmployee);
                    color.push(getRandomColor());
                });

                // labels.push('Total '+total);
                var chart = new Chart(ctx2,{
                    "type":"doughnut",
                    "data":{
                        "labels":labels,
                        "datasets":[{
                            "data":data,
                            "backgroundColor":color
                        }]
                    }
                });
                chart.canvas.parentNode.style.height = '470px';
            }
            designationWiseEmployeePieChart(jQuery.parseJSON('{!! $designationWiseEmployee !!}'));

        @endif

        @if(!empty(json_decode($genderWiseEmployee)))
            function genderWiseEmployeePieChart(genderWiseEmployee) {
                var ctx2 = document.getElementById("gender_wise_employees");
                var data = new Array();
                var color = new Array();
                var labels = new Array();
                var total = 0;

                $.each(genderWiseEmployee, function(key,val){
                    labels.push(val.gender.toUpperCase());
                    data.push(parseInt(val.totalEmployee));
                    total = total+parseInt(val.totalEmployee);
                    color.push(getRandomColor());
                });

                // labels.push('Total '+total);
                var chart = new Chart(ctx2,{
                    "type":"doughnut",
                    "data":{
                        "labels":labels,
                        "datasets":[{
                            "data":data,
                            "backgroundColor":color
                        }]
                    }
                });
                chart.canvas.parentNode.style.height = '470px';
            }
            genderWiseEmployeePieChart(jQuery.parseJSON('{!! $genderWiseEmployee !!}'));

        @endif
        

        function getRandomColor() {
            var letters = '0123456789ABCDEF'.split('');
            var color = '#';
            for (var i = 0; i < 6; i++ ) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        $('.download-chart').click(function() {alert('okk');
            var id = $(this).data('chart-id');
            this.href = $('#'+id)[0].toDataURL();// Change here
            this.download = id+'.png';
        });

    });

    
    
</script>