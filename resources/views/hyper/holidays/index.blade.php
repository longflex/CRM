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
                    <div class="row bg-title">

                        <!-- .breadcrumb -->
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <a onclick="showAdd()" class="btn btn-outline btn-success btn-sm pull-right m-l-5">Add Holiday <i class="fa fa-plus" aria-hidden="true"></i></a>

                            <a href="javascript:;" onclick="calendarData()" class="btn btn-outline btn-info btn-sm pull-right m-l-5">View on Calendar <i class="fa fa-calendar" aria-hidden="true"></i></a>

                            <a class="btn btn-outline btn-sm btn-primary markHoliday pull-right" onclick="showMarkHoliday()"  href="javascript:;" >Mark Default Holidays <i class="fa fa-check"></i> </a>
                        </div>
                        <!-- /.breadcrumb -->
                    </div>


                    <div class="row">

                        <div class="col-md-12 panel-inverse">
                            <div class="white-box">

                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group col-md-2 pull-right">
                                            <label class="control-label">Select Year(s)</label>
                                            <select onchange="showData()" class="select2 form-control" data-placeholder="" id="year">
                                                @forelse($years as $yr)
                                                    <option @if($yr == $year) selected @endif value="{{ $yr }}">{{ $yr }}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="row" id="holidaySectionData" >

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
<div class="modal fade bs-modal-md in" id="edit-column-form" role="dialog" aria-labelledby="myModalLabel"
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

    showData();
    $('#attendanceData').on('click', '.delete-attendance', function(){
        var dataid = $(this).data('attendance-id');
        const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You will not be able to recover the deleted record!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('Crm::staff_delete_attendance',':id') }}";
                    url = url.replace(':id', id);

                    $.ajax({
                        type: "GET",
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id" : dataid
                        },
                        success: function (data) {
                            $.NotificationApp.send("Success","Attendance deleted successfully.","top-center","green","success");
                            $.unblockUI();
                            //window.location.reload();
                        
                            setTimeout(function(){
                                location.reload();
                            }, 3500);
                        }, error: function (data) {
                            $.NotificationApp.send("Error","Attendance has not been deleted.","top-center","red","error");
                            setTimeout(function(){
                                location.reload();
                            }, 3500);
                        },
                    });
                } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Attendance not deleted !',
                        'error'
                    )
                }
            });
    });
   // Delete Holiday
    function del(id, date) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You will not be able to recover the deleted holiday!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('Crm::holidays.destroy',':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id" : id
                    },
                    success: function (data) {
                        $.NotificationApp.send("Success","Holiday deleted successfully.","top-center","green","success");
                        $.unblockUI();
                        //window.location.reload();
                    
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    }, error: function (data) {
                        $.NotificationApp.send("Error","Holiday has not been deleted.","top-center","red","error");
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    },
                });
            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Holiday not deleted !',
                    'error'
                )
            }
        });

    }
    // Show Create Holiday Modal
    function showAdd() {
        var url = "{{ route('Crm::holidays.create') }}";
        $.ajaxModal('#edit-column-form', url);
    }
    // Show Create Holiday Modal
    function showMarkHoliday() {
        var url = "{{ route('Crm::holidays.mark-holiday') }}?year"+ $('#year').val();
        $.ajaxModal('#edit-column-form', url);
    }
    // Show Create Holiday Modal
    function calendarData() {
        var year = $('#year').val();
        var url = "{{ route('Crm::holidays.calendar', ':year') }}";
        url = url.replace(':year', year);
        window.location.href = url;
    }

    // Show Holiday
    function showData() {
        var year = $('#year').val();
        var url = "{{ route('Crm::holidays.view-holiday',':year') }}"
        url = url.replace(':year', year);
        $.easyAjax({
            type: 'GET',
            url: url,
            container: '#holidaySectionData',
            success: function (response) {
              $('#holidaySectionData').html(response.view);
            }
        });
    }

</script>

@endsection