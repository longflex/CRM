<div class="row">
@php
    $call_sources = ($calls) ? $calls->call_source: '';
    $call_source = ($call_sources == '1') ? 'Incoming': 'Outgoing';
@endphp
    <div class="col-md-10"><strong style="font-size: 18px;">Mobile: {{$mobile}}  <span style="margin-left: 20px;"> Call Type: {{$call_source}} </span></strong></div>
</div>
<div class="row">
    <div class="col-md-2 modal-box1">
        <form id="incoming_realstate_call_lead_details_save">@csrf
            <input type="hidden" id="incoming_realstate_lead_id" name="incoming_realstate_lead_id" value="{{($lead) ? $lead->id: ''}}">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="description">Mobile *</label>
                    <input class="form-control" readonly value="{{$mobile}}" name="incoming_realstate_mobile"
                        id="incoming_realstate_mobile"></input>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="description">Name *</label>
                    <input class="form-control" {{($lead) ? 'readonly': ''}} value="{{($lead) ? $lead->name: ''}}"
                        name="incoming_realstate_name" id="incoming_realstate_name"></input>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="description">Lead Source </label>
                    <select class="form-control select2" name="incoming_realstate_lead_source" id="incoming_realstate_lead_source" data-toggle="select2" data-placeholder="Please select..">
                    <option value="">Please select..</option>
                    @if(!empty($sources))
                    @foreach($sources as $source)
                    <option value="{{ $source->source }}"
                        {{ (!empty($lead) && $lead->lead_source == $source->source ? 'selected': '') }}>
                        {{ $source->source }}
                    </option>
                    @endforeach
                    @endif
                </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="create_at">Lead Status</label>
                    <select class="form-control select2" name="incoming_realstate_lead_status" id="incoming_realstate_lead_status" data-toggle="select2"
                        data-placeholder="Please select..">
                        <option value="">Please select..</option>
                        @if(!empty($lead_statuses))
                        @foreach($lead_statuses as $lead_status)
                        <option value="{{ $lead_status->lead_status }}"
                            {{ (!empty($lead) && $lead->lead_status == $lead_status->lead_status ? 'selected': '') }}>
                            {{ $lead_status->description }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="create_at">Priority</label>
                    <select class="form-control select2" name="incoming_realstate_priority" id="incoming_realstate_priority" data-toggle="select2"
                        data-placeholder="Please select..">, , , 
                        <option value="">Please select..</option>
                        <option value="Low" {{ (!empty($lead) && $lead->priority == "Low" ? 'selected': '') }}>Low</option>
                        <option value="Medium" {{ (!empty($lead) && $lead->priority == "Medium" ? 'selected': '') }}>Medium</option>
                        <option value="High" {{ (!empty($lead) && $lead->priority == "High" ? 'selected': '') }}>High</option>
                        <option value="Highest" {{ (!empty($lead) && $lead->priority == "Highest" ? 'selected': '') }}>Highest</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-12">
                <center><button type="submit" id="" class="btn btn-success btn-sm">SAVE</button></center>
            </div>

        </form>
    </div>
    <div class="col-md-6 modal-box">
        <form id="incoming_realstate_call_details_save">@csrf

            <input type="hidden" id="incoming_realstate_member_id" name="member_id" value="{{($lead) ? $lead->id: ''}}" />
            <input type="hidden" id="incoming_realstate_manual_callLog_id" name="incoming_realstate_manual_callLog_id"
                value="{{($calls) ? $calls->id: ''}}" />
            <input type="hidden" id="incoming_realstate_call_sourse" name="incoming_realstate_call_sourse"
                value="{{($calls) ? $calls->call_source: ''}}" />
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="create_at">Project</label>
                        <select class="form-control select2" name="incoming_realstate_call_purpose" id="incoming_realstate_call_purpose" data-toggle="select2" data-placeholder="Please select..">
                            <option value="">Please select..</option>
                            <option value="Satellite Township">Satellite Township</option>
                            <option value="Pharmacity">Pharmacity</option>
                            <option value="Pharmahills">Pharmahills</option>
                            <option value="Royal City">Royal City</option>
                            <option value="Wondercity">Wondercity</option>
                            <option value="King Farm Meadows">King Farm Meadows</option>
                            <option value="Yadadri Pearl City">Yadadri Pearl City</option>
                        </select>
                    </div>
                </div>

                
                @if($calls)
                <div class="col-lg-12">
                    <center><button type="submit" id="" class="btn btn-success btn-sm">SAVE</button></center>
                </div>
                @endif
            </div>
        </form>
    </div>
    <div class="col-md-3 modal-box1">
        <?php $found_data=0;?>
        <label for="description">Recent calls</label>
        <div data-simplebar style="height: 400px;">
            <div class="col-lg-12" id="recent_calls_div">
                <div class="table-responsive">
                    <table class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Purpose</th>
                        </thead>
                        <tbody>
                            @forelse($recent_calls as $key => $value)
                            <tr>
                                <td>{{$value->call_type}}</td>
                                <td>{{$value->duration}}</td>
                                <td>{{$value->call_purpose}}</td>
                            </tr>
                            @empty
                            <?php $found_data=1;?>
                            @endforelse


                        </tbody>
                    </table>
                </div>
                <div>
                    <?php if($found_data==1){?>
                    <center>
                        <p>No Data Found</p>
                    </center>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>    
</div>



<style>
.modal-box {
    width: 500px;
    border: 2px solid #e1e1e1;
    padding: 10px;
    margin: 10px;
}

.modal-box1 {
    width: 300px;
    border: 2px solid #e1e1e1;
    padding: 10px;
    margin: 10px;
}
</style>

<script>



$("#incoming_realstate_call_details_save").submit(function(event) {
    event.preventDefault();
    $(".btn").prop("disabled", true);
    var incoming_call_purpose = $('#incoming_call_purpose').val();
    var incoming_manual_callLog_id = $('#incoming_manual_callLog_id').val();

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        var formData = new FormData(this);
        $.ajax({
                type: 'POST',
                url: "{{route('Crm::incoming.realstate.calllog.update')}}",
                data: formData,
                dataType: 'json',
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                dataType: 'json',
            })
            .done(function(data) {
                if (data.status == false) {
                    $.NotificationApp.send("Error", data.message, "top-center", "red", "error");
                    setTimeout(function() {}, 3500);
                }
                if (data.status == true) {

                    $.NotificationApp.send("Success", "The request has been created!", "top-center",
                        "green", "success");
                    setTimeout(function() {}, 3500);

                }
                $(".btn").prop("disabled", false);
            })
            .fail(function(data) {
                $.NotificationApp.send("Error", data.message, "top-center", "red", "error");
                setTimeout(function() {}, 3500);
                $(".btn").prop("disabled", false);
            });

})

$("#incoming_realstate_call_lead_details_save").submit(function(event) {
    event.preventDefault();
    $(".btn").prop("disabled", true);
    var incoming_realstate_mobile = $('#incoming_realstate_mobile').val();
    var incoming_realstate_name = $('#incoming_realstate_name').val();

    var incoming_realstate_lead_id = $('#incoming_realstate_lead_id').val();
    var incoming_realstate_lead_source = $('#incoming_realstate_lead_source').val();
    var incoming_realstate_lead_status = $('#incoming_realstate_lead_status').val();
    var incoming_realstate_priority = $('#incoming_realstate_priority').val();

    $.ajax({
        type: "POST",
        url: "{{ route('Crm::incoming.realstate.lead.create') }}",
        data: {
            '_token': "{{ csrf_token() }}",
            'lead_id': incoming_realstate_lead_id,
            'mobile': incoming_realstate_mobile,
            'name': incoming_realstate_name,
            'lead_source': incoming_realstate_lead_source,
            'lead_status': incoming_realstate_lead_status,
            'priority': incoming_realstate_priority,
        },

        success: function(data) {
            $(".btn").prop("disabled", false);
            $('#incoming_member_id').val(data.lead_id);
            $("#incoming_call_purpose").prop("disabled", false);
            
            //$('#callDetails').modal('toggle');
            $.NotificationApp.send("Success", "Lead Data Submitted Successfully.", "top-center", "green",
                "success");
            setTimeout(function() {}, 3500);

        },
        error: function(data) {
            $.NotificationApp.send("Error", "Something went wroung.", "top-center", "red", "error");
            setTimeout(function() {}, 3500);
            $(".btn").prop("disabled", false);
        },

    });


})
</script>

 


