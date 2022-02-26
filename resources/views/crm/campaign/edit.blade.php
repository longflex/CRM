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
            background-color:: #9C27B0;
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

        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    </style>

    <!-- MultiStep Form -->
    <div class="container-fluid" id="grad1">
        <div class="row justify-content-center mt-0">
            <div class="col-12 col-sm-12 col-lg-6 custom-pos text-center p-0 mt-3 mb-2">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    <h2><strong> Campaign</strong></h2>
                    <p>Fill all form field to go to next step</p>
                    <div class="row">
                        <div class="col-md-12 mx-0">
                            <form id="msform" action="{{route('Crm::update-campaign')}}" method="POST"
                                  enctype="multipart/form-data">
                            @csrf
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
                                            <input type="hidden" id="id" name="id" value="{{ ($camp->id)}}"/>
                                            <div class="col-sm-9">
                                                <h4>Peer to peer</h4>
                                                <p>Peer to peer outbound campaigns will bridge calls between your agents
                                                    and customers directly</p>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="radio" name="rad" id="rad" value="p2p"
                                                       {{ ($camp->type=="p2p")? "checked" : "" }} required>
                                            </div>

                                            <div class="col-sm-9" style="margin-top: 20px;">
                                                <h4>IVR based</h4>
                                                <p>PIVR based outbound campaigns will dial your customers and broadcast
                                                    them with a voice message or IVR</p>
                                            </div>
                                            <div class="col-sm-3" style="margin-top: 30px;">
                                                <input type="radio" name="rad" id="rad1"
                                                       value="ivr" {{ ($camp->type=="ivr")? "checked" : "" }}>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="next" class="next action-button" id="first-next"
                                           value="Next Step"/>
                                </fieldset>
                                {{-- timing --}}
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Timing</h2>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="campaign-name">Campaign Name</label>
                                                <input type="text" id="campaign-name" name="campaign_name"
                                                       value="{{ ($camp->name)}}"/>
                                                <span class="failed" id="campaign-name-fail"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="start_time">Start Time</label>
                                                <input type="time" name="start_time" id="start-time"
                                                       value="{{ ($camp->start_time)}}"/>
                                                <span class="failed" id="start-time-fail"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="end_time">End Time</label>
                                                <input type="time" name="end_time" id="end-time"
                                                       value="{{ ($camp->end_time)}}"/>
                                                <span class="failed" id="end-time-fail"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="start_date">Start Date</label>
                                                <input type="date" name="start_date" id="start-date"
                                                       value="{{ ($camp->start_date) }}"/>
                                                <span class="failed" id="start-date-fail"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="end_date">End Date</label>
                                                <input type="date" name="end_date" id="end-date"
                                                       value="{{ ($camp->end_date)}}"/>
                                                <span class="failed" id="end-date-fail"></span>
                                            </div>
                                            <div class="col-sm-12 mb-5">
                                                <label>Select Days</label><span class="failed" id="days-fail"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="containers">Mon
                                                    <input type="checkbox" name="days[]" id="days"
                                                           value="Monday" <?php if (in_array('Monday', $data)) echo "checked"; else echo "";?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Tues
                                                    <input type="checkbox" name="days[]" id="days"
                                                           value="Tuesday" <?php if (in_array('Tuesday', $data)) echo "checked"; else echo "";?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Wed
                                                    <input type="checkbox" name="days[]" id="days"
                                                           value="Wednesday" <?php if (in_array('Wednesday', $data)) echo "checked"; else echo "";?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Thu
                                                    <input type="checkbox" name="days[]" id="days"
                                                           value="Thursday" <?php if (in_array('Thursday', $data)) echo "checked"; else echo "";?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Fri
                                                    <input type="checkbox" name="days[]" id="days"
                                                           value="Friday" <?php if (in_array('Friday', $data)) echo "checked"; else echo "";?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="containers">Sat
                                                    <input type="checkbox" name="days[]" id="days"
                                                           value="Saturday" <?php if (in_array('Saturday', $data)) echo "checked"; else echo "";?>>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="Previous"/> <input type="button" name="next"
                                                                     class="next action-button" id="second-next"
                                                                     value="Next Step"/>
                                </fieldset>

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
                                                <input type="number" name="leads" placeholder="Members" id="members"
                                                       value="{{ ($camp->contact_list_member)}}">
                                            </div>


                                            <div class="col-sm-12">Or,</div>
                                            <div class="col-sm-9" style="margin-top: 20px;">
                                                <h4>From Leads</h4>
                                                <p>Choose list from leads</p>
                                            </div>
                                            <div class="col-sm-3" style="margin-top: 30px;">
                                                <input type="number" name="leads" placeholder="Leads" id="leads"
                                                       value="{{ ($camp->contact_list)}}">
                                            </div>
                                            <!-- modal -->

                                            <div class="modal" id="leadModal">
                                                <div class="modal-dialog modal-xl" role="document">
                                                    <div class="modal-content">
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-primary" id="myBtn"
                                                    data-id="{{$camp->id}}">Edit Leads
                                            </button>


                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="Previous"/>
                                    <input type="button" name="next" class="next action-button" id="third-next"
                                           value="Next Step"/>
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
                                                <input type="radio" name="agent" class="agent" id="agent"
                                                       value="Agent"{{ ($camp->agent=="Agent")? "checked" : "" }}>
                                            </div>
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">
                                                Agent Group
                                            </div>
                                            <div class="col-sm-1" style="
                                            margin-left: -35px;">
                                                <input type="radio" name="agent" class="agent-group" id="agent"
                                                       value="AgentGroup" {{ ($camp->agent=="AgentGroup")? "checked" : "" }}>
                                            </div>
                                            <div class="col-sm-12" id="agent-select" style="margin-top: 30px; display:none;">
                                                <select id="onlyAgent" name="onlyAgent[]" class="form-control" multiple>
                                                    @foreach($agents as $agnt)
                                                       <option value="{{$agnt->id}}" <?php foreach($LeadsData as $data){ if ($agnt->id==$data->agent_id) echo "selected"; else echo "";}?>>{{$agnt->name}}</option>
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
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="Previous"/> <input type="button" name="next" id="fourth-next"
                                                                     class="next action-button" value="Next Step"/>
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
                                                <input type="checkbox" name="firstname" id="firstname"
                                                       value="1" {{ ($camp->first_name=="1")? "checked" : "" }}>
                                            </div>
                                            <div class="col-sm-6">
                                                Mobile
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="checkbox" name="mobile" id="mobile"
                                                       value="1" {{ ($camp->mobile=="1")? "checked" : "" }}>
                                            </div>
                                            <div class="col-sm-6">
                                                Address
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="checkbox" name="address" id="addres"
                                                       value="1"{{ ($camp->address=="1")? "checked" : "" }}>
                                            </div>

                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="Previous"/> <input type="button" name="next"
                                                                     class="next action-button" value="Next Step"/>
                                </fieldset>

                                {{-- finish --}}

                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title">Payment Information</h2>
                                        <div class="row text-center">
                                            <h3>Confirm your submission!</h3>
                                        </div>
                                    </div>
                                    <input type="button" name="previous" class="previous action-button-previous"
                                           value="Previous"/> <input type="submit" name="make_payment"
                                                                     class="next action-button" value="Confirm"/>
                                </fieldset>
                                <fieldset>
                                    <div class="form-card">
                                        <h2 class="fs-title text-center">Success !</h2> <br><br>
                                        <div class="row justify-content-center">
                                            <div class="col-3"><img
                                                        src="https://img.icons8.com/color/96/000000/ok--v2.png"
                                                        height="100" width="100" class="fit-image"></div>
                                        </div>
                                        <br><br>
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
<script>
$(".agent").on('click' , function(){
    $("#agent-select").show();
    $("#agent-group-select").hide();
});
$(".agent-group").on('click' , function(){
    $("#agent-group-select").show();
    $("#agent-select").hide();
});
</script>
    <!-- agent and agent group dropdown -->

    <!-- modal -->


    <script>
        $('#addNew').click(function () {
            alert('hi');
            var username = $('#leadsdata').val();
            var campId = $(this).data("id");
            var token = $(this).data("token");

            if (username != '') {
                $.ajax({
                    url: '{{route('Crm::add-campaign-lead')}}',
                    type: 'post',
                    dataType: "json",
                    data: {
                        "username": username,
                        "campId": campId,
                        "_token": token,
                    },
                    success: function (data) {

                        if (data > 0) {
                            var id = data;
                            var findnorecord = $('#userTable tr.norecord').length;

                            if (findnorecord > 0) {
                                $('#userTable tr.norecord').remove();
                            }
                            var tr_str = "<tr>" +
                                "<td align='center'>'+data.name+'</td>" +
                                "<td align='center'>'+data.member_id+'</td>" +
                                "<td align='center'>'+data.mobile+'</td>" +
                                "<td align='center'><button type='button' class='deleteProduct' data-id='' data-token='{{ csrf_token() }}' >Delete</button></td>" +
                                "</tr>";

                            $("#userTable tr").append(tr_str);
                        } else {
                            alert(data);
                        }

                        // Empty the input fields
                        $('#leadsdata').val('');
                    }
                });
            } else {
                alert('Fill all fields');
            }
        });
    </script>
    <script>
        $(".deleteProduct").click(function () {

            var id = $(this).data("id");
            var token = $(this).data("token");
            var el = this;
            confirm("Are You sure want to delete !");
            $.ajax(
                {
                    url: '{{route('Crm::delete-campaign-lead')}}',
                    type: 'POST',
                    data: {
                        "id": id,
                        "_token": token,
                    },
                    success: function (data) {
                        $(el).closest("tr").remove();
                        console.log(data);
                    }
                });
        });
    </script>
    <!-- Pagination -->
    <script type="text/javascript">
        $(window).on('hashchange', function () {
            page = window.location.hash.replace('#', '');
        });
        $(document).on('click', '.pagination li a', function (e) {
            console.log(e);
            e.preventDefault();

            //to get what page, when you click paging
            var page = $(this).attr('href').split('page=')[1];
            var url = $(this).find('#href_link').val();
            //console.log(page);

            getTransaction(url);
            location.hash = page;
        });

        function getTransaction(url) {
            //console.log('getting sort for page = '+page);
            $.ajax({
                type: 'GET',
                url: url,
            }).done(function (data) {
                console.log(data);
                $('#content').html(data);
            });
        }
    </script>
    {{-- wizard validation --}}

    <script>
        $(document).ready(function () {

            var current_fs, next_fs, previous_fs; //fieldsets
            var opacity;

            $(".next").click(function () {
                current_fs = $(this).parent();
                next_fs = $(this).parent().next();
                //Add Class Active
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                //show the next fieldset
                next_fs.show();
                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function (now) {
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

            $(".previous").click(function () {
                current_fs = $(this).parent();
                previous_fs = $(this).parent().prev();
                //Remove class active
                $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
                //show the previous fieldset
                previous_fs.show();
                //hide the current fieldset with style
                current_fs.animate({opacity: 0}, {
                    step: function (now) {
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

            $('.radio-group .radio').click(function () {
                $(this).parent().find('.radio').removeClass('selected');
                $(this).addClass('selected');
            });

            $(".submit").click(function () {
                return false;
            });


            $('#myBtn').on('click',function () {
               let id=$(this).attr('data-id');
               //alert(id);

               $.ajax({
                   url:'{{route('Crm::pull-campaign')}}',
                   type:'get',
                   data:{
                       _token:'{{csrf_token()}}',
                       lead_id:id
                   },
                   success:function (data) {
                       //console.log(data);
                       $('#leadModal .modal-content').html(data);

                       $('#leadModal').show();
                   }
               })
            });
        });
    </script>
@endsection

