<link rel="stylesheet" href="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"> <i class="fa fa-pencil"></i>  Mark Holiday</h4>
</div>
<div class="modal-body">
    {!! Form::open(array('id' => 'add_holiday_mark_form', 'class'=>'form-horizontal ','method'=>'POST')) !!}
    <div class="form-body">
        <div class="row">
            <h5>Mark day for Holiday</h5>
            <div class="col-xs-12">
                <div class="form-group">
                    @forelse($holidaysArray as $key => $holidayData)
                        <div class="checkbox checkbox-inline checkbox-info col-md-2">
                            <input  id="{{ $holidayData }}{{ $key }}" name="office_holiday_days[]" value="{{ $key }}" type="checkbox">
                            <label for="{{ $holidayData }}{{ $key }}">{{ $holidayData }}</label>
                        </div>
                    @empty
                    @endforelse


                </div>
            </div>

        </div>
        <!--/row-->
    </div>
    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
    <button type="button" onclick="markHolidays()" class="btn btn-info save-event waves-effect waves-light"><i class="fa fa-check"></i> Save
    </button>
</div>

<script src="{{ asset('hrcrm/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script>

    // Store Holidays
    function markHolidays(){
        var url = "{{ route('Crm::staff.holidays.mark-holiday-store') }}";
        $.easyAjax({
            type: 'POST',
            url: url,
            container: '#add_holiday_mark_form',
            data: $('#add_holiday_mark_form').serialize(),
            success: function (response) {
                console.log([response.status, 'success']);
                if(response.status != 'fail'){
                    $('#edit-column-form').modal('hide');
                }
            }
        });
    }

</script>


