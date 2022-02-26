<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" ><i class="icon-clock"></i> Attendance Details </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="card punch-status">
                <div class="white-box">
                    <h4>Attendance <small class="text-muted">{{ $startTime->format("d-m-Y") }}</small></h4>
                    <div class="punch-det">
                        <h6>Clock In</h6>
                        <p>{{ $startTime->format("h:i a") }}</p>
                    </div>
                    <div class="punch-info">
                        <div class="punch-hours">
                            <span>{{ $totalTime }} hrs</span>
                        </div>
                    </div>
                    <div class="punch-det">
                        <h6>Clock Out</h6>
                        <p>{{ $endTime->format("h:i a") }} 
                        @if (isset($notClockedOut))
                            Did not clock out
                        @endif
                        </p>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card recent-activity">
                <div class="white-box">
                    <h5 class="card-title">Activity</h5>

                        @foreach ($attendanceActivity->reverse() as $item)
                         <div class="row res-activity-box" id="timelogBox{{ $item->aId }}">
                            <ul class="res-activity-list col-md-6">
                                <li>
                                    <p class="mb-0">Clock In</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        {{ $item->clock_in_time->timezone("Asia/Kolkata")->format("h:i a") }}.
                                    </p>
                                </li>
                                <li>
                                    <p class="mb-0">Clock Out</p>
                                    <p class="res-activity-time">
                                        <i class="fa fa-clock-o"></i>
                                        @if (!is_null($item->clock_out_time))
                                            {{ $item->clock_out_time->timezone("Asia/Kolkata")->format("h:i a") }}.
                                        @else
                                            Did not clock out
                                        @endif
                                    </p>
                                </li>
                            </ul>

                             <div class="col-md-6">
                                <a href="javascript:;" onclick="editAttendance({{ $item->aId }})"  id="attendance-edit" data-attendance-id="{{ $item->aId }}" class="btn btn-info btn-xs"  ><i class="fa fa-pencil"></i> Edit</a>
                                <a href="javascript:;" onclick="deleteAttendance({{ $item->aId }})" id="attendance-edit" data-attendance-id="{{ $item->aId }}" class="btn btn-danger btn-xs"  ><i class="fa fa-times"></i> Delete</a>
                            </div>
                         </div>
                        @endforeach

                </div>
            </div>
        </div>
    </div>

</div>
<script>
    $('#attendanceData').on('click', '.delete-attendance', function(){
        var dataid = $(this).data('attendance-id');
        
    });
     function deleteAttendance(id){
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
                            "id" : id
                        },
                        success: function (data) {
                            $.NotificationApp.send("Success","Attendance deleted successfully.","top-center","green","success");
                            $.unblockUI();

                            $('#timelogBox'+id).remove();
//                                  
                            showTable();
                            $('#projectTimerModal').modal('hide');
                        
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

    }

</script>