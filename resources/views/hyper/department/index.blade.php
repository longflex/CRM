@extends('hyper.layout.master')
@section('title', "Department")
@section('content')
<div class="px-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="uil-home-alt"></i>Home</a></li>
                        <li class="breadcrumb-item active">Department</li>
                    </ol>
                </div>
                <h4 class="page-title">Department</h4>
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
                        <div class="col-md-12 float-right">
                            <!-- <a class="btn btn-light float-right" href="{{ route('Crm::get_leads_import') }}"><i class="uil-cloud-upload"></i></a> -->
                            @if(Laralum::hasPermission('laralum.department.create'))
                            <a class="btn btn-danger float-right mr-1" href="{{ route('Crm::department_create') }}"><i class="uil-plus-circle"></i></a>
                            @endif
                        </div> 
                    </div>
                    <hr>
                    <div class="form-group mt-2">
                        <div class="table-responsive">
                            <table  class="table dt-responsive nowrap w-100" id="department-datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end page content --> 
</div>  



@endsection
@section('extrascripts')

<script>
      
    $(document).ready(function() {
        departmentDataTable();

    });
    function departmentDataTable() {
        $('#department-datatable').DataTable().destroy();
        let table = $('#department-datatable');
        table.DataTable(
            {
                order: [['0', 'desc']],
                lengthMenu: [[10, 25, 50, 100, 500, 1000], [10, 25, 50, 100, 500, 1000]],
                serverSide: true,
                responsive: true,
                processing: true,
                ajax: {
                    url: "{{ route('Crm::get.department.data') }}",
                    type: 'POST',
                    data: function (d) {
                            d._token = '{{csrf_token()}}';
                        },
                },
                columns: [   
                    {data: "id", name: 'departments.id',},
                    {data: "department", name: 'departments.department',},
                    {data: "action", sortable: false, searchable : false},
                ]
            } 
        );
    }

    function destroy(id) {
            var dataid = id;
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this Department !!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('Crm::delete_department') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id" : dataid
                        },
                        success: function (data) {
                            $.NotificationApp.send("Success","Department has been deleted.","top-center","green","success");
                            setTimeout(function(){
                                location.reload();
                            }, 3500);
                        }, error: function (data) {
                            $.NotificationApp.send("Error","Department has not been deleted.","top-center","red","error");
                            setTimeout(function(){
                                location.reload();
                            }, 3500);
                        },
                    });
                } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Department not deleted !',
                        'error'
                    )
                }
            });
        }    
</script>

@endsection