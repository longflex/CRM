<div id="event-detail">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="ti-eye"></i> Leaves Details</h4>
    </div>
    <div class="modal-body">
        {!! Form::open(['id'=>'updateEvent','class'=>'ajax-form','method'=>'GET']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="form-group">
                        <label>Applicant Name</label>
                        <p>
                            {{ ucwords($leave->user->name) }}
                        </p>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label>Date</label>
                        <p>{{ $leave->leave_date->format('d-m-Y') }} <label class="label label-{{ $leave->type->color }}">{{ ucwords($leave->type->type_name) }}</label>
                            @if($leave->duration == 'half day')
                                <label class="label label-info">{{ ucwords($leave->duration) }}</label>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                    <div class="form-group">
                        <label>Reason for absence</label>
                        <p>{!! $leave->reason !!}</p>
                    </div>
                </div>
                <div class="col-md-12 ">
                    <div class="form-group">
                        <label>Leave Paid Status</label>
                        <p> {{($leave->paid == 0) ? 'Unpaid' : 'Paid'}} </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Status</label>
                        <p>
                            @if($leave->status == 'approved')
                                <strong class="text-success">Approved</strong>
                            @elseif($leave->status == 'pending')
                                <strong class="text-warning">Pending</strong>
                            @else
                                <strong class="text-danger">Reject</strong>
                            @endif

                        </p>
                    </div>
                </div>

                @if(!is_null($leave->reject_reason))
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <label>Reject Reason</label>
                            <p>{!! $leave->reject_reason !!}</p>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        {!! Form::close() !!}

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
        @if($leave->status == 'pending')
            <button type="button" class="btn btn-danger btn-outline delete-event waves-effect waves-light"><i class="fa fa-times"></i> Delete</button>
            <button type="button" class="btn btn-info save-event waves-effect waves-light"><i class="fa fa-edit"></i> Edit</button>
        @endif
    </div>

</div>

<script>

    $('.save-event').click(function () {
        $.easyAjax({
            url: '{{route('Crm::staff.leaves.edit', $leave->id)}}',
            container: '#updateEvent',
            type: "GET",
            data: $('#updateEvent').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    $('#event-detail').html(response.view);
                }
            }
        })
    })

    $('.delete-event').click(function(){
        var id = '{{$leave->id}}';
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You will not be able to recover the deleted leave!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('Crm::staff.leaves.destroy',':id') }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id" : id
                    },
                    success: function (data) {
                        $.NotificationApp.send("Success","Leave deleted successfully.","top-center","green","success");
                        $.unblockUI();
                        //window.location.reload();
                    
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    }, error: function (data) {
                        $.NotificationApp.send("Error","Leave has not been deleted.","top-center","red","error");
                        setTimeout(function(){
                            location.reload();
                        }, 3500);
                    },
                });
            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Leave not deleted !',
                    'error'
                )
            }
        });
    });


</script>