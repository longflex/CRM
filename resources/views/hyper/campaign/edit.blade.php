@extends('hyper.layout.master')
@section('title', "Campaign Edit")
@section('content')
<div class="contain er-fluid px-3">
    <!-- start page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('Crm::campaign') }}"><i class="uil-home-alt"></i>Campaign</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
                <h4 class="page-title">Edit Campaign</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <!-- start page body -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <form method="post" action="{{ route('Crm::update-campaign') }}" class="form-horizontal">@csrf
                            <input type="hidden" name="id" value="{{ $campaign->id }}">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="name">Campaign Name</label>
                                <div class="col-lg-10">
                                    <input type="text" id="name" name="name" class="form-control"  value="{{ $campaign->name }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="type">Campaign Type</label>
                                <div class="col-lg-10">
                                    <input type="text" id="type" name="type" class="form-control" value="{{ $campaign->type }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="status">Campaign Status</label>
                                <div class="col-lg-10">
                                    <select name="status" class="custom-select">
                                        @if($campaign->status == 1)
                                        <option value="1" selected>Pause</option>
                                        <option value="2">Stop</option>
                                        <option value="3">Resume</option>
                                        @elseif($campaign->status == 2)
                                        <option value="1">Pause</option>
                                        <option value="2" selected>Stop</option>
                                        <option value="3">Resume</option>
                                        @elseif($campaign->status == 3)
                                        <option value="1">Pause</option>
                                        <option value="2">Stop</option>
                                        <option value="3" selected>Resume</option>
                                        @else
                                        <option value="1">Pause</option>
                                        <option value="2">Stop</option>
                                        <option value="3">Resume</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="status">Start Date</label>
                                <div class="col-lg-10">
                                    <input type="text" readonly class="form-control" id="start_date" name="start_date" value="{{ $campaign->start_date }}" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="status">End Date</label>
                                <div class="col-lg-10">
                                    <input type="text" readonly class="form-control" id="end_date" name="end_date" value="{{ $campaign->end_date }}" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="status">Call To Call Gap</label>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control" id="call_to_call_gap" name="call_to_call_gap" value="{{ $campaign->call_to_call_gap }}" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label" for="status">Break Time</label>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control" id="break_time" name="break_time" value="{{ $campaign->break_time }}" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- <label class="col-lg-2 col-form-label" for="agent">Choose Agent</label> -->
                                <label class="col-lg-2" for="">
                                    <select class="custom-select" id="chooseAgentLabel">
                                        <option value="1">Agent</option>
                                        <option value="2">Agent Group</option>
                                    </select>
                                </label>
                                <div class="col-lg-10" id="agentselect">
                                    <select class="select2 select2-multiple" data-toggle="select2" multiple="multiple" id="agent" name="agent[]" data-placeholder="Choose Agent ...">
                                        @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}" @foreach($agentselected as $agentsel) @if($agentsel->id == $agent->id) selected @else @endif @endforeach>{{ $agent->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-10" id="agentgroupselect">
                                    <select class="select2" data-toggle="select2" id="agentGroup" name="agentGroup" data-placeholder="Choose Agent Group ...">
                                        <option value="">Choose Agent Group ...</option>
                                        @foreach($agentGroup as $agentGro)
                                        <option value="{{ $agentGro->id }}">{{ $agentGro->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-success float-right">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end page body -->
</div>
@endsection
@section('extrascripts')
<script>
    $(function() {
      $('input[name="start_date"]').daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false,
        autoApply: false,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
      });
      $('input[name="start_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));

        });
    });
    $(function() {
      $('input[name="end_date"]').daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: false,
        autoApply: false,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'),10)
      });
      $('input[name="end_date"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));

        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#agentgroupselect').hide(); 
        $('#chooseAgentLabel').on('change', function () {
            if($(this).val() == 1) {
                $('#agentselect').show();
                $('#agentgroupselect').hide(); 
            } else {
                $('#agentselect').hide();
                $('#agentgroupselect').show();
            }
        });
    });
</script>
@endsection