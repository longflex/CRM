


@foreach($leads as $lead)

<tr>
    <td><input type='checkbox' id="{{$lead->id}}" name='sms' value="{{$lead->id}}"></td>
    <td>{{$lead->id}}</td>
    <td>{{$lead->member_id}}</td>
    <td><a href="{{route('Crm::lead_details', ['id' => $lead->id])}}">{{$lead->name}}</a></td>
    <td>{{ $lead->mobile }}</td>
    <td>{{ $lead->assign_to??'N.A.' }}</td>
    
    <td>
    @php 
        $lead_status = "";
        if ($lead->lead_status == 1) {
            echo '<span class="badge badge-primary">Assigned</span>';
        } elseif ($lead->lead_status == 2) {
            echo '<span class="badge badge-info">Open</span>';
        } elseif ($lead->lead_status == 3) {
            echo '<span class="badge badge-success">Converted</span>';
        } elseif ($lead->lead_status == 4) {
            echo '<span class="badge badge-warning">Follow Up</span>';
        } elseif ($lead->lead_status == 5) {
            echo '<span class="badge badge-danger">Closed</span>';
        } else {
            echo '<span class="badge badge-secondary">Not available</span>';
        }
    @endphp
    </td>


    <td>
        @php 
            if ($lead->preferred_language != null || $lead->preferred_language != "") {
                echo $lead->preferred_language;
            } else {
                echo 'Not available';
            }
        @endphp
    </td>

    <td>
        @php
        echo '<a href="' . route('Crm::lead_edit',['id'=>$lead->id]) . '"><i class="uil-edit"></i></a> <a href="javascript:void(0);" data-id="'.$lead->id.'" onclick="destroy('.$lead->id.')"><i class="uil-trash"></i></a>';
        @endphp

    </td>
</tr>
@endforeach
<tr>
    <td colspan="12" align="center">
        {!! $leads->links() !!}
    </td>
</tr>