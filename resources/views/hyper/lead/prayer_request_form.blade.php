<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="follow_up_date">Follow up Date</label>
            <input type="text" readonly class="form-control" value="" id="incoming_follow_up_date" name="incoming_follow_up_date">
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="create_at">Prayer Request</label>
            <select class="form-control select2" name="incoming_issue" id="incoming_issue"  data-toggle="select2" data-placeholder="Please select.." required>
                <option value="">Please select..</option>
                @foreach($prayer_requests as $issue)
                <option value="{{ $issue->prayer_request }}">{{ $issue->prayer_request }}</option>
                @endforeach
                <option value="add">Add Value</option>
            </select>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="incoming_description" id="incoming_description"></textarea>
        </div>
    </div>
</div>
<script>
    $(function() {
      $('input[name="incoming_follow_up_date"]').daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false,
        autoApply: true,
        drops: ('up'),
        //showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
      });
      $('input[name="incoming_follow_up_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));

        });
    });

    $('#incoming_issue').change(function() {
        var inputValue = $(this).val();
        if ('add' == inputValue) {
            $("#incoming_detail_type").val(6);
            $("#callDetails").modal("hide");
            $("#incoming_AddDetails").modal("show");
        }
    });
</script>