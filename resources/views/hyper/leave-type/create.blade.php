<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bootstrap-colorselector/bootstrap-colorselector.min.css') }}">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Leave Type</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Leave Type</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($leaveTypes as $key=>$leaveType)
                    <tr id="type-{{ $leaveType->id }}">
                        <td>{{ $key+1 }}</td>
                        <td><label class="label label-{{ $leaveType->color }}">{{ ucwords($leaveType->type_name) }}</label></td>
                        <td><a href="javascript:;" data-cat-id="{{ $leaveType->id }}" class="btn btn-sm btn-danger btn-rounded delete-category"><i class="fa fa-times"></i> Remove</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No leave type added.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <hr>
        {!! Form::open(['id'=>'createLeaveType','class'=>'ajax-form','method'=>'POST']) !!}
        <div class="form-body">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label>Leave Type</label>
                        <input type="text" name="type_name" id="type_name" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label>No of Leaves</label>
                        <input type="number" min="0" name="leave_number" value="0" id="leave_number" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <label>Leave Paid Status</label>
                    <div class="form-group">
                        <select  class="form-control"  name="paid" id="paid" >
                            <option value="1">Paid</option>
                            <option value="0">Unpaid</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 ">
                    <div class="form-group">
                        <label>Color</label>
                        <select id="colorselector" name="color">
                            <option value="info" data-color="#5475ed" selected>Blue</option>
                            <option value="warning" data-color="#f1c411">Yellow</option>
                            <option value="purple" data-color="#ab8ce4">Purple</option>
                            <option value="danger" data-color="#ed4040">Red</option>
                            <option value="success" data-color="#00c292">Green</option>
                            <option value="inverse" data-color="#4c5667">Grey</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="save-type" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<script src="{{ asset('hrcrm/plugins/bootstrap-colorselector/bootstrap-colorselector.min.js') }}"></script>
<script>
    $('#colorselector').colorselector();

    $('#createLeaveType').submit(function () {
        $.easyAjax({
            url: '{{route('Crm::leaveType.store')}}',
            container: '#createLeaveType',
            type: "POST",
            data: $('#createLeaveType').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
        return false;
    })

    $('.delete-category').click(function () {
        var id = $(this).data('cat-id');
        var url = "{{ route('Crm::leaveType.destroy',':id') }}";
        url = url.replace(':id', id);

        var token = "{{ csrf_token() }}";

        $.easyAjax({
            type: 'GET',
            url: url,
            data: {'_token': token},
            success: function (response) {
                if (response.status == "success") {
                    $.unblockUI();
//                                    swal("Deleted!", response.message, "success");
                    $('#type-'+id).fadeOut();
                }
            }
        });
    });

    $('#save-type').click(function () {
        $.easyAjax({
            url: '{{route('Crm::leaveType.store')}}',
            container: '#createLeaveType',
            type: "POST",
            data: $('#createLeaveType').serialize(),
            success: function (response) {
                if(response.status == 'success'){
                    window.location.reload();
                }
            }
        })
    });
</script>