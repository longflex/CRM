@extends('hyper.layout.master')
@section('title', "Campaign List")
@section('content')
<div class="px-3">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::campaign') }}"><i class="uil-home-alt"></i>Campaign</a></li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
                <h4 class="page-title">Campaign List</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <!-- start page content -->
    <!-- <a href="{{ route('Crm::create-campaign') }}"><i class="uil-plus-circle font-20"></i></a> -->
    <!-- <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped dt-responsive nowrap w-100" id="campaign-DataTable">
                            <thead>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Agent</th>
                                <th>
                                    Action
                                    <a href="{{ route('Crm::create-campaign') }}"><i class="uil-plus-circle font-20"></i></a>commented
                                </th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row" id="getdata">
        @include('hyper/campaign/page')
    </div>
    <!-- end page content --> 
</div>  
@endsection
@section('extrascripts')
    
    <script type="text/javascript">
        $(document).ready(function() {
            //campaignDataTable();
        });
        // function campaignDataTable() {
        //     $('#campaign-DataTable').DataTable().destroy();
        //     let table = $('#campaign-DataTable');
        //     table.DataTable(
        //         {
        //             order: [['0', 'DESC']],
        //             serverSide: true,
        //             responsive: true,
        //             processing: true,
        //             ajax: {
        //                 url: "{{ route('Crm::get_campaign_table') }}",
        //                 type: 'POST',
        //                 data: function (d) {
        //                     d._token = '{{ csrf_token() }}';
        //                 }
        //             },
        //             columns: [                        
        //                 {"data": "id", name: 'campaigns.id'},
        //                 {"data": "name", name: 'campaigns.name'},
        //                 {"data": "type", name: 'campaigns.type'},
        //                 {"data": "status", name: 'campaigns.status'},
        //                 {"data": "agent", name: 'campaign_agents.user_list.name'},
        //                 {"data": "action", sortable: false, searchable : false},
        //             ]
        //         }
        //     );
        // }
    </script>
    <script type="text/javascript">
        // function campaignedit(id) {
        //     var dataid = id;
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ route('Crm::edit-campaign') }}",
        //         data: { "id" : dataid },
        //         success: function (data) {
        //             $.NotificationApp.send("Success","Campaign deleted.","top-center","green","success");
        //             campaignDataTable();
        //         }, error: function (data) {
        //             $.NotificationApp.send("Error","Campaign not deleted.","top-center","red","error");
        //             campaignDataTable();
        //         },
        //     });
        // }
        function campaigndestroy(id) {
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
                    text: "You want to delete this Campaign !!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('Crm::delete-campaign') }}",
                        data: { "id" : dataid },
                        success: function (data) {
                            if (data.campaign_delete == true) {
                                $.NotificationApp.send("Success","Campaign deleted.","top-center","green","success");
                                var url = "{{ route('Crm::campaign') }}";
                                window.location = url;
                            }
                        }, error: function (data) {
                            $.NotificationApp.send("Error","Campaign not deleted.","top-center","red","error");
                            
                        },
                    });
                } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Campaign not deleted !',
                        'error'
                    )
                }
            });
        }
    </script>
@endsection