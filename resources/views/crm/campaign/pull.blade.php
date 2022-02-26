<!-- Modal -->
<div class="modal-header">
    <div class="row">
        <div class="col-md-6">
            <h5 class="modal-title" id="exampleModalLabel">Leads</h5>
        </div>
        <div class="col-md-6">
            <button type="button" id="modalClose" class="close" >
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>
</div>
<div class="modal-body" id="content">
    <table class="ui table" id="userTable">
        <tr>
            <th>Name</th>&nbsp;
            <th>Member ID</th>&nbsp;
            <th>Phone</th>&nbsp;
        </tr>
        {{--@if(!empty($LeadsData))--}}
            {{--@foreach($LeadsData as $lead)--}}
                {{--<tr role="row" class="odd">--}}
                    {{--<td>{{$lead->name}}</td>--}}
                    {{--<td>{{$lead->member_id}}</td>--}}
                    {{--<td>{{$lead->mobile}}</td>--}}
                    {{--<td>--}}
                        {{--<button type="button" class="deleteProduct" data-id="{{ $lead->id }}"--}}
                                {{--data-token="{{ csrf_token() }}">Delete--}}
                        {{--</button>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
    </table>
    {{--<div class="page">--}}
        {{--{!! $LeadsData->render() !!}--}}
    {{--</div>--}}
    {{--@endif--}}
</div>
<div class="modal-footer">
    <input type="number" id="leadsdata" placeholder="Add New">
    <button type="button" id="addNew" data-id="" data-token="{{ csrf_token() }}">Add New</button>
</div>

<script>
    $(document).ready(function () {
        $('#modalClose').on('click',function () {
            $('#leadModal').hide();
        });
    });
</script>
