<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">Attendance Detail</h4>
</div>
<div class="modal-body">
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" >Late</label>
                    @if(count($attendances) > 0 && $attendances[0]->late == "yes") <span class="label label-success"><i class="fa fa-check"></i>Yes</span>
                    @else
                        <span class="label label-danger"><i class="fa fa-times"></i> No</span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" >Half Day</label>
                    @if(count($attendances) > 0 && $attendances[0]->half_day == "yes") <span class="label label-success"><i class="fa fa-check"></i> Yes</span>
                    @else
                        <span class="label label-danger"><i class="fa fa-times"></i> No</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Others</th>
                </tr>
                </thead>
                <tbody>
                @forelse($attendances as $attendance)
                    <tr>
                        <td width="25%" class="al-center bt-border">
                            {{ $attendance->clock_in_time->timezone("Asia/Kolkata")->format('h:i a') }}
                        </td>
                        <td width="25%" class="al-center bt-border">
                            @if(!is_null($attendance->clock_out_time)) {{ $attendance->clock_out_time->timezone("Asia/Kolkata")->format('h:i a') }} @else - @endif
                        </td>
                        <td class="bt-border" style="padding-bottom: 5px;">
                            <strong>Clock In IP: </strong> {{ $attendance->clock_in_ip }}<br>
                            <strong>Clock Out IP: </strong> {{ $attendance->clock_out_ip }}<br>
                            <strong>Working From: </strong> {{ $attendance->working_from }}<br>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No attendance detail for today.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
