<div class="dropdown-menu dropdown-menu-animated dropdown-lg d-block" id="search-dropdown">
    
    @if($lead)
    <a href="javascript:void(0);" class="dropdown-item notify-item">
        <a href="{{route('Crm::lead_details', ['id' => $lead->id])}}">
            <i class="uil-notes font-16 mr-1"></i>
            <span>{{$lead->name}} | {{$lead->mobile}} | {{$lead->member_id}} | </span>
        </a>
        <a href="javascript:void(0);" onClick ="manualsinglecall('{{$lead->mobile}}')"><i class="uil-phone"></i></a>
    </a>
    
    @else
    <div class="dropdown-header noti-title">
        <h5 class="text-overflow mb-2">No <span class="text-danger">Result</span> found</h5>
    </div>
    @endif

</div>