<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="icon-pencil"></i> @lang('app.edit') @lang('app.menu.leaves')</h4>
</div>
<div class="modal-body">
    {!! Form::open(['id'=>'createLeave','class'=>'ajax-form','method'=>'PUT']) !!}
    <div class="form-body">
        <div class="row">
            {!! Form::hidden('user_id', $user_id) !!}

            <!--/span-->
        </div>
        <div class="row">

            <div class="col-md-12 ">
                <div class="form-group">
                    <label class="control-label required">Leave Type</label>
                    <select class="form-control" name="leave_type_id" id="leave_type_id" data-style="form-control">
                        @forelse($leaveTypes as $leaveType)
                            <option
                                    @if($leave->leave_type_id == $leaveType->leaveType->id) selected @endif
                            value="{{ $leaveType->leaveType->id }}">{{ ucwords($leaveType->leaveType->type_name) }}</option>
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
                <label class="required">Date</label>
                <div class="form-group">
                    <input type="text" class="form-control" name="leave_date" id="single_date" value="{{ $leave->leave_date->format('d-m-Y') }}">
                </div>
            </div>

        </div>
        <!--/span-->

        <div class="row">
            <div class="col-md-12">
                <label class="required">Reason for absence</label>
                <div class="form-group">
                    <textarea name="reason" id="reason" class="form-control" cols="30" rows="5">{!! $leave->reason !!}</textarea>
                </div>
            </div>

            {!! Form::hidden('status', $leave->status) !!}

        </div>


    </div>
    {!! Form::close() !!}

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success save-leave waves-effect waves-light">@lang('app.update')</button>
</div>

<script src="{{ asset('hrcrm/plugins/bower_components/custom-select/custom-select.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>

    $(".select2").select2({
        formatNoMatches: function () {
            return 'No record found.';
        }
    });

    jQuery('#single_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true
    });

    $('.save-leave').click(function () {
        $.easyAjax({
            url: '{{route('Crm::staff.leaves.update', $leave->id)}}',
            container: '#createLeave',
            type: "POST",
            redirect: true,
            data: $('#createLeave').serialize()
        })
    });
</script>