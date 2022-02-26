@extends('hyper.layout.master')
@section('title', "Staff List")
@section('content')
<div class="px-2">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::staff') }}"><i class="uil-home-alt"></i> staff</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
                <h4 class="page-title">Staff List</h4>
            </div>
        </div>
    </div>     
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body mx-3">
                    <div class="">
                        <h3 class="font-weight-bold"><a class="float-right text-secondary" href="" data-toggle="tooltip" title="Reset Filters" data-placement="top"><i class="mdi mdi-refresh-circle"></i></a><i class="dripicons-experiment"></i> Filters</h3>
                    </div>
                    <hr>
                    <div class="form-group">
                        <input type="text" class="form-control filter_by_created_date_range" placeholder="-Select Created Date Range -" name="created_date_range" value="" />
                    </div>
                    <div class="form-group">
                        <select class="select2" name="work_status" id="filter_by_work_status" data-toggle="select2" data-placeholder="-- Select Staff Status --">
                            <option value="">-- Select Staff Status --</option>
                            <option value="Active">Active</option>
                            <option value="Terminated">Terminated</option>
                            <option value="Deceased">Deceased</option>
                            <option value="Resigned">Resigned</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="select2" name="staff_type" id="filter_by_staff_type" data-toggle="select2" data-placeholder="-- Select staff type --">
                            <option value="">--  Select staff type  --</option>
                            <option value="Permanent">Permanent</option>
                            <option value="On Contract">On Contract</option>
                            <option value="Temporary">Temporary</option>
                            <option value="Trainee">Trainee</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="select2" name="reporting_to" id="filter_by_reporting_to" data-toggle="select2" data-placeholder="-- Select reporting to --">
                            <option value="">-- Select reporting to --</option>
                            <option value="Test User">Test User</option>
                        </select>
                    </div> 
                    <div class="form-group">
                        <select class="select2" name="work_role" id="filter_by_work_role" data-toggle="select2" data-placeholder="-- Select reporting to --">
                            <option value="">-- Select work role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Team member">Team member</option>
                            <option value="Mnager">Mnager</option>
                            <option value="Director">Director</option>
                            <option value="Team Incharge">Team Incharge</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="select2" name="department" id="filter_by_department" data-toggle="select2" data-placeholder="-- Select Departments --">
                            <option value="">-- Select Departments --</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="select2" name="gender" id="filter_by_gender" data-toggle="select2" data-placeholder="-- Select Gender --">
                            <option value="">-- Select Gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="select2" name="marital_status" id="filter_by_marital_status" data-toggle="select2" data-placeholder="-- Select Marital Status --">
                            <option value="">-- Select Marital Status --</option>
                            <option value="Married">Married</option>
                            <option value="Unmarried">Unmarried</option>
                        </select>
                    </div> 
                </div> 
            </div> 
            
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="staff-preview">
                            <div class="row mb-3"> 
                                <div class="col-md-10 text-left">
                                    <div class="row">
                                        <div class="col-md-7 text-left">
                                            <div class="input-group">
                                                <select class="custom-select" id="check_action" aria-label="Example select with button addon">
                                                  <option value="Select Action" selected>Select Action</option>
                                                    <option value="Export Selected">Export Selected</option>
                                                    <option value="Delete Selected">Delete Selected</option>
                                                    @if(Laralum::hasPermission('laralum.member.sendsms'))
                                                    <option value="Send Sms">Send Sms</option>
                                                    @endif
                                                </select>
                                                <div class="input-group-append">
                                                  <a class="btn btn-primary" id='action_btn'>Go <i class="mdi mdi-arrow-right-bold"></i></a>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <div class="col-md-5 text-left"> 
                                            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddDetails"><i class="uil-plus-circle"></i> Quick Add</button> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 float-right">
                                    
                                    
                                    <!-- <a href="{{ route('Crm::staff_create') }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-plus icon_m"
                                            aria-hidden="true"></i><span>{{ trans('laralum.create_lead') }}</span>
                                    </a> -->
                                    
                                    <!-- <a href="{{ route('Crm::staff_import') }}" class="btn btn-primary">
                                        <i class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span>
                                    </a> -->
                                    <a class="btn btn-light float-right" href="{{ route('Crm::staff_import') }}"><i class="uil-cloud-upload"></i></a> 
                                    <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::staff_create') }}"><i class="uil-plus-circle"></i> </a>
                                </div>                                                                      
                                
                            </div>
                            <hr>
                            <table id="staff-table" class="table table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll" value=true></th>  
                                        <th>Id</th> 
                                        <th>Name</th> 
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Department</th>
                                        <th>Staff type</th>
                                        <th>Staff Status</th>
                                        <th>Role</th>
                                        <th>Hiring Source</th>
                                       
                                        <th>Action</th>
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

<!-- Standard modal -->

<div id="AddDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel">Add Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" id="add_detail" action="javascript:void(0)">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="simpleinput">Name<span class="red-txt">*</span></label>
                        <input type="text" id="name" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="example-email">Email<span class="red-txt">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="simpleinput">Phone<span class="red-txt">*</span></label>
                        <input type="text" id="mobile" minlength="10" class="form-control" name="mobile" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

                    <button type="submit" id="editMemberForm" class="btn btn-primary">Save changes</button>
                </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div id="change_password" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-top">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                <h4 class="modal-title" id="topModalLabel">Change Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" enctype="multipart/form-data" id="change_staff_pass" action="javascript:void(0)">
                <input type="hidden" name="staff_user_id" id="staff_user_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="simpleinput">Old Password<span class="red-txt">*</span></label>
                        <input type="password" id="old_password" class="form-control" minlength="6" name="old_password" required placeholder="Enter old password">
                    </div>
                    <div class="form-group">
                        <label for="simpleinput">New Password<span class="red-txt">*</span></label>
                        <input type="password" id="new_password" minlength="6" class="form-control" name="new_password" required placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="simpleinput">Confirm Password<span class="red-txt">*</span></label>
                        <input type="password" id="confirm_password" minlength="6" class="form-control" name="confirm_password" required placeholder="Enter confirm password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                        <button type="button" id="change_pass_update_btn" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('extrascripts')
<script>change_pass_update_btn
    $(document).on('click', '#change_pass_update_btn', function (e) {
        var staff_user_id = $('#staff_user_id').val();
        var old_password = $('#old_password').val();
        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        if (old_password == '' && new_password == '' && confirm_password == '') {
            // swal('Warning!', 'All fields are required', 'warning');
            $.NotificationApp.send("Error","All fields are required.","top-center","red","error");
            return false;
        }
        if (new_password != confirm_password) {
            // swal('Warning!', 'All fields are required', 'warning');
            $.NotificationApp.send("Error","Password and confirm password should be same.","top-center","red","error");
            return false;
        }
        var type = "POST";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })       
        my_url = "{{ route('Crm::staff_change_password') }}";
        var type = "POST";
        $.ajax({
            type: type,
            url: my_url,
            data: {staff_user_id:staff_user_id, old_password:old_password, new_password:new_password},
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (data) {
                $.NotificationApp.send("Success","Password has been submited!","top-center","green","success");
                setTimeout(function(){
                    location.reload();
                }, 3500);
            }, error: function (data) {
                $.NotificationApp.send("Error","Password has not been submited!","top-center","red","error");
                setTimeout(function(){
                    //location.reload();
                }, 3500);
            },
        });
    });

    $(document).on('click', '.button_password', function (e) {
        var id = $(this).data('id');
        $('#staff_user_id').val(id);
        $('#change_password').modal('show');
    });


    $(function() {
        $('input[name="created_date_range"]').daterangepicker({
            autoUpdateInput: false,
            applyButtonClasses: 'btn btn-warning',
            drops: ('up'),
            autoApply: false,
            locale: {
                cancelLabel: 'Clear',
            }
        });
        $('input[name="created_date_range"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            staffDataTable();
        });
        $('input[name="recently_contacted"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            staffDataTable();
        });
    });

    $(document).ready(function () {
        staffDataTable();
        $('#filter_by_work_status').on('change', function (){ 
            staffDataTable();
        });    
        $('#filter_by_staff_type').on('change', function () {
            staffDataTable();
        });
        $('#filter_by_reporting_to').on('change', function () {
            staffDataTable();
        });
        $('#filter_by_prayer_request').on('change', function () {
            staffDataTable();
        });
        $('#filter_by_work_role').on('change', function () {
            staffDataTable();
        });
        $('#filter_by_department').on('change', function () {
            staffDataTable();
        });
        $('#filter_by_gender').on('change', function () {
            staffDataTable();
        });
        $('#filter_by_blood_group').on('change', function () {
            staffDataTable();
        });
        $('#filter_by_marital_status').on('change', function () {
            staffDataTable();
        });
    });

    function staffDataTable() {
        $('#staff-table').DataTable().destroy();
        let table = $('#staff-table');
        //let data_id = $('#filter_by_lead_status').val();
        table.DataTable(
            {
                order: [['1', 'desc']],
                lengthMenu: [[10, 25, 50, 100, 500, 1000], [10, 25, 50, 100, 500, 1000]],
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                    url: "{{ route('Crm::get_staffs_data') }}",
                    type: 'POST',
                    data: function (d) {
                            d._token = '{{csrf_token()}}';
                            //d.filter_by_data_id = data_id;
                            d.filter_by_created_date_range = $('.filter_by_created_date_range').val();
                            d.filter_by_work_status = $('#filter_by_work_status').val();
                            d.filter_by_staff_type = $('#filter_by_staff_type').val();
                            d.filter_by_reporting_to = $('#filter_by_reporting_to').val();
                            d.filter_by_department = $('#filter_by_department').val();
                            d.filter_by_work_role = $('#filter_by_work_role').val();
                            d.filter_by_gender = $('#filter_by_gender').val();
                            d.filter_by_marital_status = $('#filter_by_marital_status').val();
                        },
                },
                columns: [                        
                    {data: "checkbox", sortable: false, searchable : false},
                    {data: "id", name: 'u.id',},
                    {data: "name", name: 'u.name',},
                    {data: "email", name: 'u.email',},
                    {data: "mobile", name: 'u.mobile'},
                    {data: "department", name: 'd.department'},
                    {data: "staff_type", name: 'ud.staff_type'},
                    {data: "work_status", name: 'ud.work_status'},
                    {data: "work_role", name: 'ud.work_role'},
                    {data: "hire_source", name: 'ud.hire_source'},
                    {data: "action", sortable: false, searchable : false},

                ]
            }
        );
    }





    $(document).ready(function () {
        $('#add_detail').submit(function (e) {
            e.preventDefault();
            //  e.preventDefault();
            $("#AddDetails").modal("hide");

            var name = $('#name').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();
            if (name == '' && email == '' && mobile == '') {
                // swal('Warning!', 'All fields are required', 'warning');
                $.NotificationApp.send("Error","All fields are required.","top-center","red","error");
                return false;
            }
            var type = "POST";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            var formData=new FormData(this);       
            my_url = "{{ route('Crm::quickAdd') }}";
            var type = "POST";
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    $.NotificationApp.send("Success","Account details has been submited!","top-center","green","success");
                    setTimeout(function(){
                        location.reload();
                    }, 3500);
                }, error: function (data) {
                    $.NotificationApp.send("Error","Account details has not been submited!","top-center","red","error");
                    setTimeout(function(){
                        //location.reload();
                    }, 3500);
                },
            });
        });
    });

    $(document).on('click', '.button_delete', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    //alert(11);return;
    const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You want to delete this Staff !!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: "{{route('Crm::delete-staff')}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id":id
                },
                success: function (data) {
                        $.NotificationApp.send("Success","Staff has been deleted.","top-center","green","success");
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    }, error: function (data) {
                        $.NotificationApp.send("Error","Staff has not been deleted.","top-center","red","error");
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    },
                });
            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Staff not deleted !',
                    'error'
                )
            }
        });
    });

    
</script>

<script>
//     $("#FilterShow").click(function(){
//   $(".filter-area").slideToggle();
// });
// $("#ImportShow").click(function(){
//   $(".import-area").slideToggle();
// });
$('#selectAll').click(function(e){   
    var table= $(e.target).closest('table');
    $('td input:checkbox',table).prop('checked',this.checked); 
});
$("#action_btn").click(function(){
    var ids=[];
    $('input[type=checkbox]:checked').each(function(i, val){
      if(val.id!='selectAll')
      ids.push(val.id); 
    });
    if(ids.length==0){
        $('.dimmer').removeClass('dimmer');
        swal('Error!', 'Please select staff first!', 'error')
        return;
    }
    if($('#check_action').val()!='Select Action'){
        var url="";
        var body={};
        if($('#check_action').val()=='Delete Selected'){
            url="{{ route('Crm::staff_deleteSelected') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
        
            $.ajax({
                type: 'POST',
                url: url,
                data: {ids:ids},
                success: function (data) {
                    $.NotificationApp.send("Success","Selected data has been deleted.","top-center","green","success");
                    setTimeout(function(){
                        location.reload();
                    }, 3500);
                }, error: function (data) {
                    $.NotificationApp.send("Error","Selected data not has been deleted.","top-center","red","error");
                    setTimeout(function(){
                        location.reload();
                    }, 3500);
                },
            })
        }else if($('#check_action').val()=='Export Selected'){
            var query = {
                ids: ids
            }
            var url = "{{route('Crm::exportSelectedStaff')}}?" + $.param(query)

            window.location = url;
        }else{
            $('#sms_ids').val(ids);
            $('#SendSms').modal('show');
        }
        
    }else{
        $.NotificationApp.send("Error","Please select action first!","top-center","red","error");
    }
    $('.dimmer').removeClass('dimmer');

});
</script>
<script>
    $(document).ready(function () {
        $('.verify_mobile').click(function () {
            if($('#verify_label').text()=='Verified')   {
                return;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })       
    
            var sender = $("#sender_id").val();
            var receiver_mobile = $("#mobile").val();
            if($('#verify_label').text()!='Verify') {
                if ($('#otp').val() == '') {
                    swal('Warning!', 'Please enter Otp!', 'warning')
                    return false;
                }
                $('#verify_label').html('Verifying..');
                $.ajax({
                    type: 'post',
                    url: "{{ route('Crm::verify_otp') }}",
                    data: {receiver_mobile:receiver_mobile,otp:$('#otp').val()},
                    success: function (data) {          
                        if(data.status=='success'){
                             $('#verify_label').html('Verified');
                             $('#otp').hide(); 
                            
                        }else {             
                            $('#verify_label').html('Wrong Otp! Reverify');
                        }
                    }
                });
            }else{
                $('#verify_label').html('SENDING..');
                $.ajax({
                    type: 'post',
                    url: "{{ route('Crm::send_otp') }}",
                    data: {sender:sender,receiver_mobile:receiver_mobile},
                    success: function (data) {          
                        if(data.status=='success'){
                             $('#verify_label').html('Verify Otp');
                             $('#otp').show(); 
                            //  setTimeout(function(){                          
                            //     location.reload();
                            // }, 3000);
                        }else {             
                            $('#verify_label').html('Resend');
                        }
                    }
                });
            }
    
        });
    });    

    function stateChange(object) {
        var id=object.id;
        var stateID = object.value;
        if(stateID==''){
            alert('Please select state');
            return false;
        }
        if(stateID){
            var token = $("input[name='_token']").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "POST",
                url:"{{ route('Crm::get_district') }}",
                data: {state_id:stateID,_token:token},
                success:function(res){
                    if(res){
                        var district=$('#district');
                        district.empty();
                        district.append('<option>District</option>');
                        $.each(res,function(key,value){
                            district.append('<option value="'+key+'">'+value+'</option>');
                        });

                    }else{
                        district.empty();
                    }
                }
            });
        }else{
            $("#state").empty();
            $("#city").empty();
        }
    }
</script>

<script>
    $(document).on('click','#addNotePopup',function(e) {
        $('#member_issue_id').val($(this).attr('data-id'))
    });
</script>
        
@endsection









