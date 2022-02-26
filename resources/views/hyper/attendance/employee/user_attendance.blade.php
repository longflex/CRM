
@foreach ($dateWiseData as $key => $dateData)
    @php
        $currentDate = \Carbon\Carbon::parse($key);
    @endphp
    @if($dateData['attendance'])

        <tr>
            <td>
                {{ $currentDate->format('d-m-Y') }}
                <br>
                <label class="label label-success">{{ $currentDate->format('l') }}</label>
            </td>
            <td><label class="label label-success">Present</label></td>
            <td colspan="3">
                <table width="100%">
                    @foreach($dateData['attendance'] as $attendance)
                        <tr>
                            <td width="25%" class="al-center bt-border">
                                {{ $attendance->clock_in_time->timezone("Asia/Kolkata")->format("h:i a") }}
                            </td>
                            <td width="25%" class="al-center bt-border text-center">
                                @if(!is_null($attendance->clock_out_time)) {{ $attendance->clock_out_time->timezone("Asia/Kolkata")->format("h:i a") }} @else - @endif
                            </td>
                            <td class="bt-border text-center" style="padding-bottom: 5px;">
                                <button type="button"  class="btn btn-info btn-xs btn-rounded view-attendance" data-attendance-id="{{$attendance->aId}}">
                                    <i class="fa fa-search"></i> Details
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </td>

        </tr>
    @else
        <tr>
            <td>
                {{ $currentDate->format('d-m-Y') }}
                <br>
                <label class="label label-success">{{ $currentDate->format('l') }}</label>
            </td>
            <td>
                @if(!$dateData['holiday'] && !$dateData['leave'])
                    <label class="label label-danger">Absent</label>
                @elseif($dateData['leave'])
                    @if ($dateData['leave']['duration'] == "half day")
                    <label class="label label-primary">Leave</label><br><br>
                    <label class="label label-warning">Half Day</label>
                    @else
                        <label class="label label-primary">Leave</label>
                    @endif
                @else
                    <label class="label label-megna">Holiday</label>
                @endif
            </td>
            <td colspan="3">
                <table width="100%">
                    <tr>
                        <td width="25%" class="al-center">-</td>
                        <td width="25%" class="al-center text-center">-</td>
                        <td class="text-center" style="padding-bottom: 5px;">
                            @if($dateData['holiday']  && !$dateData['leave'])
                                Holiday for {{ ucwords($dateData['holiday']->occassion) }}
                            @elseif($dateData['leave'])
                                Leave for {{ ucwords($dateData['leave']['reason']) }}
                            @else
                                -
                            @endif

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif

@endforeach

