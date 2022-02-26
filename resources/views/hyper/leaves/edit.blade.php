<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="icon-pencil"></i> Edit Leaves</h4>
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'createLeave','class'=>'ajax-form','method'=>'PUT']) !!}
    <div class="form-body">
        <div class="row">
            <div class="col-md-12 ">
                <div class="form-group">
                    <label>Employee</label>
                    <input type="hidden" name="user_id" value="{{ $leave->user_id }}">
                    <p>{{ $leave->user->name }}</p>
                </div>
            </div>

            <!--/span-->
        </div>
        <div class="row">

            <div class="col-md-12 ">
                <div class="form-group">
                    <label class="control-label">Leave Type</label>
                    <select class="form-control" name="leave_type_id" id="leave_type_id"
                            data-style="form-control">
                        @forelse($leaveTypes as $leaveType)
                            <option
                                    @if($leave->leave_type_id == $leaveType->id) selected @endif
                            value="{{ $leaveType->id }}">{{ ucwords($leaveType->type_name) }}</option>
                        @empty
                            <option value="">No leave type added.</option>
                        @endforelse
                    </select>
                </div>
            </div>

        </div>
        <!--/row-->

        <div class="row">
            <div class="col-md-6">
                <label>Date</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="leave_date" id="single_date" value="{{ $leave->leave_date->format('d-m-Y') }}">
                </div>
            </div>

        </div>
        <!--/span-->

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="required">Reason for absence</label>
                    <textarea name="reason" id="reason" class="form-control" cols="30" rows="5">{!! $leave->reason !!}</textarea>
                </div>
            </div>

            <div class="col-md-12">
                <label>Status</label>
                <div class="form-group">
                    <select class="form-control" data-style="form-control" name="status" id="status" >
                        <option
                                @if($leave->status == 'approved') selected @endif
                        value="approved">Approved</option>
                        <option
                                @if($leave->status == 'pending') selected @endif
                        value="pending">Pending</option>
                        <option
                                @if($leave->status == 'rejected') selected @endif
                        value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
        </div>


    </div>
    {!! Form::close() !!}

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success save-leave waves-effect waves-light">Update</button>
</div>

<script src="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>

    $("#createLeave .select2").select2({
        formatNoMatches: function () {
            return 'No record found.';
        }
    });

    jQuery('#single_date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    });

    $('#createLeave').on('click', '#addLeaveType', function () {
        var url = '{{ route('Crm::leaveType.create')}}';
        $('#modelHeading').html('Manage Leave Type');
        $.ajaxModal('#projectCategoryModal', url);
    })

    $('body').on('click', '.save-leave', function () {
        console.log('test');
        $.easyAjax({
            url: '{{route('Crm::leaves.update', $leave->id)}}',
            container: '#createLeave',
            type: "POST",
            data: $('#createLeave').serialize(),
            success: function(response){
                window.location.reload();
            }
        })
    });
</script>
