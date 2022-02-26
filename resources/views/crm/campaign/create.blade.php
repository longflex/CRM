@extends('layouts.crm.newLayout')
@section('breadcrumb')
<div class="ui breadcrumb">
    <div class="active section">Campaign</div>
</div>
@endsection
@section('title', "Campaign")
@section('icon', "mobile")
@section('content')
  
<style>
    #grad1 {
        background-color: : #9C27B0;
    }
    
    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px
    }
    
    #msform fieldset .form-card {
        background: white;
        border: 0 none;
        border-radius: 0px;
        /* box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2); */
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;
        position: relative
    }
    
    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding: 20px 0px;
        position: relative
    }
    
    #msform fieldset:not(:first-of-type) {
        display: none
    }
    
    #msform fieldset .form-card {
        text-align: left;
        color: #9E9E9E
    }
    
    #msform input,
    #msform textarea {
        padding: 0px 8px 4px 8px;
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 100%;
        box-sizing: border-box;
        /* font-family: montserrat; */
        color: #2C3E50;
        font-size: 16px;
        letter-spacing: 1px
    }
    
    #msform input:focus,
    #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid skyblue;
        outline-width: 0
    }
    
    #msform .action-button {
        width: 100px;
        background: #26476c;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px
    }
    
    #msform .action-button:hover,
    #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
    }
    
    #msform .action-button-previous {
        width: 100px;
        background: #f9ba48;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px
    }
    
    #msform .action-button-previous:hover,
    #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161
    }
    
    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px
    }
    
    select.list-dt:focus {
        border-bottom: 2px solid skyblue
    }
    
    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative
    }
    
    .fs-title {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left
    }
    
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey
    }
    
    #progressbar .active {
        color: #000000
    }
    
    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        width: 12%;
        float: left;
        position: relative
    }
    
    #progressbar #wiz1:before {
        /* font-family: FontAwesome; */
        content: "01";
    }
    
    #progressbar #wiz2:before {
        /* font-family: FontAwesome;
        content: "\f017" */
        content: "02";
    }
    
    #progressbar #wiz3:before {
        /* font-family: FontAwesome;
        content: "\f0c0" */
        content: "03";
    }
    
    #progressbar #wiz4:before {
        /* font-family: FontAwesome;
        content: "\f2c1" */
        content: "04";
    }
    #progressbar #wiz5:before {
        /* font-family: FontAwesome;
        content: "\f00c" */
        content: "05";
    }
    #progressbar #wiz6:before {
        /* font-family: FontAwesome;
        content: "\f085" */
        content: "06";
    }
    #progressbar #wiz7:before {
        /* font-family: FontAwesome;
        content: "\f095" */
        content: "07";
    }
    #progressbar #wiz8:before {
        font-family: FontAwesome;
        content: "\f00c"
    }
    
    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px
    }
    
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1
    }
    
    #progressbar li.active:before, #progressbar li.active:after {
        background: #26476c;
    }
/* 
    #progressbar li.active:after {
        background: #f9ba48;
    } */
    
    .radio-group {
        position: relative;
        margin-bottom: 25px
    }
    
    .radio {
        display: inline-block;
        width: 204;
        height: 104;
        border-radius: 0;
        background: lightblue;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor: pointer;
        margin: 8px 2px
    }
    
    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3)
    }
    
    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1)
    }
    
    .fit-image {
        width: 100%;
        object-fit: cover
    }
    @media only screen and (min-width: 1200px) {
        .custom-pos {
            right: -350px;
        }
    }
    /* The container */
    .containers {
        display: block;
        position: relative;
        padding-left: 25px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 16px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .containers input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
    }

    /* On mouse-over, add a grey background color */
    .containers:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the checkbox is checked, add a blue background */
    .containers input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .containers input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .containers .checkmark:after {
        left: 9px;
        top: 5px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }
    .failed {
        color: rgb(168, 17, 17);
        font-weight:700;
    }
    </style>
    
        <!-- MultiStep Form -->
    <div class="container-fluid" id="grad1">
        <div class="row justify-content-center mt-0">
            <div class="col-12 col-sm-12 col-lg-6 custom-pos text-center p-0 mt-3 mb-2">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    <h2><strong>Create New Campaign</strong></h2>
                    <p>Fill all form field to go to next step</p>
                    <div class="row">
                        <div class="col-md-12 mx-0">
                            <form id="msform">
                                {{-- @csrf --}}
                                <!-- progressbar -->
                                <ul id="progressbar">
                                    <li class="active" id="wiz1"><strong>Campaign</strong></li>
                                    <li id="wiz2"><strong>Timing</strong></li>
                                    <li id="wiz3"><strong>Contact List</strong></li>
                                    <li id="wiz4"><strong>Choose Agent</strong></li>
                                    <li id="wiz5"><strong>Setting</strong></li>
                                    <li id="wiz6"><strong>Call View</strong></li>
                                    <li id="wiz7"><strong>Finish</strong></li>
                                </ul> 
                                <!-- fieldsets -->
                                {{-- campaign --}}
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">New outbound campaign</h2> 
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-sm-9">
                                                <h4>Peer to peer</h4>
                                                <p>Peer to peer outbound campaigns will bridge calls between your agents and customers directly</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="radio" name="rad" class="rad" id="rad" value="p2p">
                                            </div>
                                            
                                            <div class="col-sm-9" style="margin-top: 20px;">
                                                <h4>IVR based</h4>
                                                <p>PIVR based outbound campaigns will dial your customers and broadcast them with a voice message or IVR</p>
                                            </div>
                                            <div class="col-sm-3" style="margin-top: 30px;">
                                                <input type="radio" name="rad" class="rad" id="rad1" value="ivr">
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 20px;">
                                                <p class="failed" id="first-error"></p>
                                            </div>
                                        </div>
                                    </div> <input type="button" name="next" class="next action-button" id="first-next" value="Next Step" />
                                </fieldset>
                                {{-- timing --}}
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Timing</h2>
                                           <div class="row">
                                            <div class="col-sm-12">
                                                <label for="campaign-name">Campaign Name</label> 
                                                <input type="text" id="campaign-name" name="campaign_name" />
                                                <span class="failed" id="campaign-name-fail"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="start_time">Start Time</label>
                                                <input type="time" name="start_time" id="start-time"/>
                                                <span class="failed" id="start-time-fail"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="end_time">End Time</label>
                                                <input type="time" name="end_time" id="end-time"/>
                                                <span class="failed" id="end-time-fail"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" name="start_date" id="start-date"/>
                                                <span class="failed" id="start-date-fail"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="end_date">End Date</label>
                                                <input type="date" name="end_date" id="end-date"/>
                                                <span class="failed" id="end-date-fail"></span>
                                            </div>
                                            <div class="col-sm-12 mb-5">
                                                <label>Select Days</label><span class="failed" id="days-fail"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="containers">Mon
                                                <input type="checkbox" name="days[]" id="days" value="Monday">
                                                <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Tues
                                                <input type="checkbox" name="days[]" id="days" value="Tuesday">
                                                <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Wed
                                                <input type="checkbox" name="days[]" id="days" value="Wednesday">
                                                <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Thu
                                                <input type="checkbox" name="days[]" id="days" value="Thursday">
                                                <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Fri
                                                <input type="checkbox" name="days[]" id="days" value="Friday">
                                                <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Sat
                                                <input type="checkbox" name="days[]" id="days" value="Saturday">
                                                <span class="checkmark"></span>
                                                </label>
                                            </div>  
                                        </div>
                                    </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" class="next action-button" id="second-next" value="Next Step" />
                                </fieldset>
                                
                                {{-- contact list --}}
                                {{-- <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Contact List</h2>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-sm-9">
                                                <h4>From Members</h4>
                                                <p>Choose list from members</p>
                                            </div>
                                            <div class="col-sm-3" style="margin-top: 10px;">
                                                <input type="number" name="contact_list" id="members" class="contact" value="members">
                                            </div>
                                            <div class="col-sm-12">Or,</div>
                                            <div class="col-sm-9" style="margin-top: 20px;">
                                                <h4>From Leads</h4>
                                                <p>Choose list from leads</p>
                                            </div>
                                            <div class="col-sm-3" style="margin-top: 30px;">
                                                <input type="number" name="contact_list" id="leads" class="contact" value="leads">
                                            </div>
                                            <div class="col-sm-12">Or,</div>
                                            <div class="col-sm-9" style="margin-top: 20px;">
                                                <h4>Upload CSV</h4>
                                                <p>Upload Leads CSV</p>
                                            </div>
                                            <div class="col-sm-3" style="margin-top: 30px;">
                                                <input type="radio" name="contact_list" id="contact-csv" class="contact" value="csv">
                                            </div>
                                            <div class="col-sm-12" style="display: none;" id="import-csv-div">
                                                <input type="file" name="importSubmit" id="import-csv">
                                            </div>
                                            <div class="col-sm-12" style="margin-top: 20px;">
                                                <p class="failed" id="third-error"></p>
                                            </div>
                                        </div>
                                    </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" class="next action-button" id="third-next" value="Next Step" />
                                </fieldset> --}}

                                  {{-- contact list --}}
                                  <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Contact List</h2>
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-sm-9">
                                                <h4>From Members</h4>
                                                <p>Choose list from members</p>
                                            </div>
                                            <div class="col-sm-3" style="margin-top: 10px;">
                                                <input type="number" name="members" placeholder="Members" id="members" >
                                            </div>

                                            <div class="col-sm-12">Or,</div>
                                            <div class="col-sm-9" style="margin-top: 20px;">
                                                <h4>From Leads</h4>
                                                <p>Choose list from leads</p>
                                            </div>
                                            <div class="col-sm-3" style="margin-top: 30px;">
                                               <input type="number" name="leads" placeholder="Leads" id="leads">
                                            </div>
                                            
                


                                            <div class="col-sm-12" style="margin-top: 20px;">
                                                <p class="failed" id="third-error"></p>
                                            </div>
                                        </div>
                                    </div>  <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" class="next action-button" id="third-next" value="Next Step" />
                                </fieldset>

                                {{-- Choose Agent --}}
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Choose Agent</h2> 
                                        <div class="row" style="margin-top: 30px;">
                                            <div class="col-sm-3">
                                                Choose Agent
                                            </div>
                                            <div class="col-sm-1" style="
                                            margin-left: -35px;">
                                                <input type="radio" name="agent" id="agent" class="agent" value="Agent">
                                            </div>
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">
                                                Agent Group
                                            </div>
                                            <div class="col-sm-1" style="
                                            margin-left: -35px;">
                                                <input type="radio" name="agent" id="agent"class="agent-group" value="AgentGroup">
                                            </div>
                                            <div class="col-sm-12" id="agent-select" style="margin-top: 30px; display:none;">
                                                <select id="onlyAgent" name="onlyAgent[]" class="form-control" multiple>
                                                    @foreach($agents as $agnt)
                                                       <option value="{{$agnt->id}}">{{$agnt->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-12" id="agent-group-select" style="margin-top: 30px; display:none;">
                                                <select name="agentGroup[]" id="agentGroup[]" class="form-control" multiple>
                                                    @foreach($agentGroup as $agent)
                                                       <option value="{{$agent->id}}">{{$agent->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" id="fourth-next" class="next action-button" value="Next Step" />
                                </fieldset>

                                {{-- setting --}}
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Setting</h2>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label for="">Show Content</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="checkbox" name="show_content" id="show_content" value="1">
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="max-attempt">Max Attempt</label>
                                                <input type="number" name="max_attempt" value="2" id="max-attempt">
                                                <p class="failed" id="max-attempt-fail"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="max-time">Max Time (in seconds)</label>
                                                <input type="number" name="max_time"  id="max-time" value="120">
                                                <p class="failed" id="max-time-fail"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="gap-bet-calls">Gap Between Calls (in seconds)</label>
                                                <input type="number" name="gap_bet_calls"  id="gap-bet-calls" value="5">
                                                <p class="failed" id="gap-bet-calls-fail"></p>
                                            </div>
                                        </div>
                                    </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" id="sixth-next" class="next action-button" value="Next Step" />
                                </fieldset>

                                {{-- call view --}}
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Call View</h2>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                First Name
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="checkbox" name="firstname" id="firstname" value="1">
                                            </div>
                                            <div class="col-sm-6">
                                                Mobile
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="checkbox" name="mobile" id="mobile" value="1">
                                            </div>
                                            <div class="col-sm-6">
                                                Address
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="checkbox" name="address" id="addres" value="1">
                                            </div>
                                            
                                        </div>
                                    </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" id="seventh-next" class="next action-button" value="Next Step" />
                                </fieldset>

                                {{-- finish --}}

                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Confirm Submission</h2>
                                        <div class="row text-center">
                                            <h3>Confirm your submission!</h3>
                                        </div>
                                    </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="make_payment" id="eighth-next" class="next action-button" value="Confirm" />
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title text-center">Success !</h2> <br><br>
                                        <div class="row justify-content-center">
                                            <div class="col-3"> <img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="fit-image"> </div>
                                        </div> <br><br>
                                        <div class="row justify-content-center">
                                            <div class="col-7 text-center">
                                                <h5>You Have Successfully Signed Up</h5>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
<!-- agent and agent group dropdown -->
<script>
    $(".agent").on('click' , function(){
        $(".agent-select").show();
        $(".agent-group-select").hide();
    });
    $(".agent-group").on('click' , function(){
        $(".agent-group-select").show();
        $(".agent-select").hide();
    });
</script>


{{-- submitting form --}}
<script>
    $(document).ready(function(){

        $('#fourth-next').click(function(){
             //console.log("hi");
            var agents = [];
            var agentGroup=[];
            $("#onlyAgent").children("option:selected").each(function() {
                agents.push($(this).val());
                //console.log(agents);
            }); 
            $("#agentGroup").children("option:selected").each(function() {
                agentGroup.push($(this).val());
            }); 
            let agentVal;
            if($("input[type='radio']#agent:checked")) {
                agentVal = $("input[type='radio']#agent:checked").val();
                //console.log(agentVal);
            }
            else{
                agentVal =$("input[type='radio']#agent-group:checked").val();
                //console.log(agentVal);
            }
            console.log(agentVal);
            //alert(agents);
            //alert(agentGroup);
            $.ajax({
                url: '{{route('Crm::store-campaign')}}',
                type: "post",
                data: {
                    "step": 4,
                    "_token": "{{ csrf_token() }}", 
                    "agent": agentVal,
                    "agents[]": agents,
                    "agentGroup[]": agentGroup
                },
                success: function (data) {
                    console.log(data);
                }
            });     
        });

        $('#fifth-next').click(function(){
            $.ajax({
                url: '{{route('Crm::store-campaign')}}',
                type: "post",
                data: {
                        "step": 5,
                        "_token": "{{ csrf_token() }}", 
                        "ivr": ""
                    },
                success: function (data) {
                    console.log(data);
                }
            });
        });

        $('#seventh-next').click(function(){
            $.ajax({
                url: '{{route('Crm::store-campaign')}}',
                type: "post",
                data: {
                        "step": 7,
                        "_token": "{{ csrf_token() }}", 
                        "firstname": $("input[name='firstname']:checked").val(), 
                        "mobile": $("input[name='mobile']:checked").val(),
                        "address": $("input[name='address']:checked").val(),
                    },
                success: function (data) {
                    console.log(data);
                }
            });
        });

        $('#eighth-next').click(function(){
            $.ajax({
                url: '{{route('Crm::store-campaign')}}',
                type: "post",
                data: {
                        "step": 8,
                        "_token": "{{ csrf_token() }}" 
                    },
                success: function (data) {
                    console.log(data);
                }
            });
            window.location.href = "{{route('Crm::campaign')}}";
        });
    });
</script>
  

<script>
    $(document).ready(function(){

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function(){

    current_fs = $(this).parent();
    next_fs = $(this).parent().next();

    //06-02-2021 new code
    if(this.id == 'first-next') {
        if($("input[type='radio'].rad:checked").val()) {
            $("#first-error").html("");
            $.ajax({
                url: '{{route('Crm::store-campaign')}}',
                type: "post",
                data: {
                        "step": 1,
                        "_token": "{{ csrf_token() }}", 
                        "rad": $("input[type='radio'].rad:checked").val()
                    },
                success: function (data) {
                    console.log(data);
                }
            });
        }
        else {
            $("#first-error").html("Select one of the campaign type");
            return false;
        }
    }

    if(this.id == 'second-next') {
        $(".failed").html("");
        var days = [];
        $("input[name='days[]']:checked").each(function() {
            days.push($(this).val());
        });  
        var name = $("#campaign-name").val(); 
        var start_time = $("#start-time").val(); 
        var end_time = $("#end-time").val();
        
        var stt = new Date("May 26, 2020 " + start_time);
        var ett = new Date("May 26, 2020 " + end_time);
        var st = stt.getTime();
        var et = ett.getTime();

        var start_date = $("#start-date").val();
        var end_date = $("#end-date").val();
        
        var sd = new Date(start_date);
        var ed = new Date(end_date);
        
        if(name == "") {
            $("#campaign-name-fail").html("Campaign name required");
            return false;
        }
        if(start_time == "") {
            $("#start-time-fail").html("Start timing required");
            return false;
        }
        if(end_time == "") {
            $("#end-time-fail").html("End timing required");
            return false;
        }
        if (st > et) {
            // alert('End time always greater then start time.');
            swal({
                title: "Whops!",
                text: "End time should always greater then start time.",
                type: "error",
                confirmButtonText: "Okay"
            });
            return false;
        }
        if(start_date == "") {
            $("#start-date-fail").html("Start date required");
            return false;
        }
        if(end_date == "") {
            $("#end-date-fail").html("End date required");
            return false;
        }
        if (sd > ed) {
            swal({
                title: "Whops!",
                text: "End date should always greater then start date.",
                type: "error",
                confirmButtonText: "Okay"
            });
            return false;
        }
        if(days.length == 0) {
            $("#days-fail").html("<br>Please select days<br>");
            return false;
        }
            $.ajax({
                url: '{{route('Crm::store-campaign')}}',
                type: "post",
                data: {
                        "step": 2,
                        "_token": "{{ csrf_token() }}", 
                        "name": $("#campaign-name").val(), 
                        "start_time": $("#start-time").val(), 
                        "end_time": $("#end-time").val(), 
                        "start_date": $("#start-date").val(),
                        "end_date": $("#end-date").val(),
                        "days[]": days
                },
                success: function (data) {
                    console.log(data);
                }
            });   
    }
    if(this.id == 'third-next') {
        $(".failed").html("");

                $.ajax({
                    url: '{{route('Crm::store-campaign')}}',
                    type: "post",
                    data: {
                            "step": 3,
                            "_token": "{{ csrf_token() }}", 
                            "members": $("#members").val(),
                            "leads": $("#leads").val(),
                        },
                    success: function (data) {
                        console.log(data);
                    }
                });
    }



    if(this.id == 'sixth-next') { 
        $(".failed").html("");
        var max_attempt = $("#max-attempt").val(); 
        var max_time = $("#max-time").val(); 
        var gap_bet_calls = $("#gap-bet-calls").val();  
        if(max_attempt == "") {
            $("#max-attempt-fail").html("Max attempt required");
            return false;
        }
        if(max_time == "") {
            $("#max-time-fail").html("Max time required");
            return false;
        }
        if(gap_bet_calls == "") {
            $("#gap-bet-calls-fail").html("Gap between two calls required");
            return false;
        }
        $.ajax({
            url: '{{route('Crm::store-campaign')}}',
            type: "post",
            data: {
                "step": 6,
                "_token": "{{ csrf_token() }}",
                "show_content": $("input[name='show_content']:checked").val(), 
                "max_attempt": $("#max-attempt").val(), 
                "max_time": $("#max-time").val(), 
                "gap_bet_calls": $("#gap-bet-calls").val()
            },
            success: function (data) {
                console.log(data);
            }
        });                                                              
    }



    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
    step: function(now) {
    // for making fielset appear animation
    opacity = 1 - now;

    current_fs.css({
    'display': 'none',
    'position': 'relative'
    });
    next_fs.css({'opacity': opacity});
    },
    duration: 600
    });
    });

    $(".previous").click(function(){

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    //Remove class active
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();

    //hide the current fieldset with style
    current_fs.animate({opacity: 0}, {
    step: function(now) {
    // for making fielset appear animation
    opacity = 1 - now;

    current_fs.css({
    'display': 'none',
    'position': 'relative'
    });
    previous_fs.css({'opacity': opacity});
    },
    duration: 600
    });
    });

    // $('.radio-group .radio').click(function(){
    // $(this).parent().find('.radio').removeClass('selected');
    // $(this).addClass('selected');
    // });

    $(".submit").click(function(){
    return false;
    })

    });
</script>

@endsection
