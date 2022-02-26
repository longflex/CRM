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


<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
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
                        <li class="breadcrumb-item active">Leaves</li>
                    </ol>
                </div>
                <h4 class="page-title">Create Leaves</h4>
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
                        <div class="col-md-12">

                            <div class="panel panel-inverse">
                                <div class="panel-heading"> Assign Leave</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        {!! Form::open(['id'=>'createLeave','class'=>'ajax-form','method'=>'POST']) !!}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>Choose Members</label>
                                                        <select class="select2 form-control" data-placeholder="@lang('modules.messages.chooseMember')" name="user_id">
                                                            @foreach($employees as $employee)
                                                                <option value="{{ $employee->id }}">{{ ucwords($employee->name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!--/span-->
                                            </div>
                                            <div class="row">

                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label class="control-label">Edit Leave
                                                        </label>
                                                        <select class="selectpicker form-control" name="leave_type_id" id="leave_type_id"
                                                                data-style="form-control">
                                                            @forelse($leaveTypes as $leaveType)
                                                                <option value="{{ $leaveType->id }}">{{ ucwords($leaveType->type_name) }}</option>
                                                            @empty
                                                                <option value="">No leave type added.</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Select Duration</label>
                                                        <div class="radio-list">
                                                            <label class="radio-inline p-0">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="duration" id="duration_single" checked value="single">
                                                                    <label for="duration_single">Single</label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="duration" id="duration_multiple" value="multiple">
                                                                    <label for="duration_multiple">Multiple</label>
                                                                </div>
                                                            </label>
                                                            <label class="radio-inline">
                                                                <div class="radio radio-info">
                                                                    <input type="radio" name="duration" id="duration_half_day" value="half day">
                                                                    <label for="duration_half_day">Half Day</label>
                                                                </div>
                                                            </label>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <!--/row-->

                                            <div class="row">
                                                <div class="col-md-6" id="single-date">
                                                    <label>Date</label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="leave_date" id="single_date" value="{{ Carbon\Carbon::today()->format('d-m-Y') }}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6" id="multi-date" style="display: none">
                                                    <label>Select Dates <h6>(You can select multiple dates.)</h6></label>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="multi_date" id="multi_date" value="{{ Carbon\Carbon::today()->format('d-m-Y') }}">
                                                    </div>
                                                </div>

                                            </div>
                                            <!--/span-->

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Reason for absence</label>
                                                    <div class="form-group">
                                                        <textarea name="reason" id="reason" class="form-control" cols="30" rows="5"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Status</label>
                                                    <div class="form-group">
                                                        <select  class="selectpicker" data-style="form-control" name="status" id="status" >
                                                            <option value="approved">Approved</option>
                                                            <option value="pending">Pending</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" id="save-form-2" class="btn btn-success"><i class="fa fa-check"></i>
                                                Save
                                            </button>
                                            <button type="reset" class="btn btn-default">Reset</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
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
    <div class="modal fade bs-modal-md in" id="projectCategoryModal" role="dialog" aria-labelledby="myModalLabel"
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
<script>


    $(".select2").select2({
        formatNoMatches: function () {
            return "{{ __('messages.noRecordFound') }}";
        }
    });

    jQuery('#multi_date').datepicker({
        format: 'dd-mm-yyyy',
        multidate: true,
        todayHighlight: true
    });

    jQuery('#single_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });

    $("input[name=duration]").click(function () {
        if($(this).val() == 'multiple'){
            $('#multi-date').show();
            $('#single-date').hide();
        }
        else{
            $('#multi-date').hide();
            $('#single-date').show();
        }
    })

    $('#createLeave').on('click', '#addLeaveType', function () {
        var url = '{{ route('Crm::leaveType.create')}}';
        $('#modelHeading').html('Manage Leave Type');
        $.ajaxModal('#projectCategoryModal', url);
    })

    $('#save-form-2').click(function () {
        $.easyAjax({
            url: '{{route('Crm::staff.leaves-dashboard.store')}}',
            container: '#createLeave',
            type: "POST",
            redirect: true,
            data: $('#createLeave').serialize()
        })
    });
</script>
@endsection