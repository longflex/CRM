<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>{{ config('app.name') }} | @yield('title')</title>
        <meta name="description" content="CleverStack - administration panel">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	    <meta name="_token" content="{{ csrf_token() }}">
	    <meta name="author" content="CleverStack - administration panel">
	    <link href="{{ asset('hyper/assets/favicon.png') }}" rel="shortcut icon">
        <!-- third party css -->
        <link href="{{ asset('/hyper/assets/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('/hyper/assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/hyper/assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/hyper/assets/css/vendor/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/hyper/assets/css/vendor/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
        <!-- third party css end -->
        <!-- sweetalert2 css -->
        <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css" rel="stylesheet">
        <!-- App css -->
        <link href="{{ asset('/hyper/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('/hyper/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="light-style"/>
        <link href="{{ asset('/hyper/assets/css/app-creative-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style"/>
        <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
        <!-- Custom css -->
        <link href="{{ asset('/hyper/assets/css/custom-style.css')}}" rel="stylesheet" type="text/css"/>
        
    </head>

    <body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false,"showRightSidebarOnStart": true}'>
        
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    @include('hyper.includes.topbar')
                    <!-- end Topbar -->
                    <!-- Menubar Start -->
                    @include('hyper.includes.menubar')
                    <!-- end Menubar -->
                    <!-- Start Content-->
                    <?php echo session('import_message');?>
                    @if(Session::has('import_message'))
                    <p class="alert alert-success">{{ Session::get('import_message') }}</p>
                    @endif
					@yield('content')
                    <!-- container -->


                    <div id="callDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addnoteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" style="width: 1250px !important;max-width: 1250px !important;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="addnoteModalLabel"><i class="uil-question-circle mr-1"></i>Add Call Details</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <div id="calling_lead_details"></div>
                                    <div class="modal-footer">
                                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Add Details Modal -->
                <div id="incoming_AddDetails" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="incoming_addDetailsModalLabel">Add Detail</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <form method="POST" enctype="multipart/form-data" id="incoming_add_detail" action="javascript:void(0)">@csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Add Detail</label>
                                        <input type="text" name="detail" id="incoming_detail" class="form-control" />
                                        <input type="hidden" name="type" id="incoming_detail_type" class="form-control" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-sm"><span id="hidebutext">Add</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- content -->
                <!-- Footer Start -->
                @include('hyper.includes.footer')
                <!-- end Footer -->
            </div>
            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->

        <!-- bundle -->
        <script src="{{ asset('/hyper/assets/js/vendor.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/app.min.js') }}"></script>
        <!-- third party js -->
        <script src="{{ asset('/hyper/assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script>
        <!-- Datatable js -->
        <script src="{{ asset('/hyper/assets/js/vendor/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/buttons.print.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/vendor/dataTables.select.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/pages/demo.datatable-init.js') }}"></script>
        <!-- Apex js -->
        <!-- <script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>
        <script src="https://apexcharts.com/samples/assets/series1000.js"></script>
        <script src="https://apexcharts.com/samples/assets/github-data.js"></script>
        <script src="https://apexcharts.com/samples/assets/irregular-data-series.js"></script> -->
        <script src="{{ asset('/hyper/assets/js/vendor/apexcharts.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/pages/demo.apex-area.js') }}"></script>
        <!-- Todo js -->
        <script src="{{ asset('/hyper/assets/js/ui/component.todo.js') }}"></script>
        <!-- third party js ends -->
        <!-- sweetalert2 js -->
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
        <!-- toastr js -->
        <script src="{{ asset('/hyper/assets/js/pages/demo.toastr.js') }}"></script>
        <!-- demo app -->
        <script src="{{ asset('/hyper/assets/js/pages/demo.dashboard.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/pages/demo.dashboard-crm.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/pages/demo.form-wizard.js') }}"></script>
        <!-- end demo js-->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <!-- Custom js -->
        <script src="{{ asset('/hyper/assets/js/custom-script.js') }}"></script>
        <script src="{{ asset('crm_public/js/member-script.js') }}" type="text/javascript"></script>
        <!-- Plgins only -->
        <script src="{{ asset('/hyper/assets/js/vendor/ion.rangeSlider.min.js') }}"></script>
        <script src="{{ asset('/hyper/assets/js/ui/component.range-slider.js') }}"></script>
        @yield('extrascripts')
        
        <script>        
            $('#CALLEND').on('click',function(){
                if ($(this).data('id') === 'end') {
                    let number = $('#dialnum').val();
                    const filter_by_campaign = $('#filter_by_campaign').val();
                    $('#dialnum').val('');
                    $("#pause-play").prop('disabled', true);
                    $.ajax({
                        url: "{{ route('Crm::leads_load_api') }}",
                        type: "GET",
                        data: { mobile : number, campaign : filter_by_campaign, call_type : 0 },
                        success: function (data) {
                            if (data === false) { 
                                $('#DISMSG').html("Network Error");
                                $('#DISMSG').css("color", "red");
                            }
                            $('#call-title').html('Calling ... <i class="uil-outgoing-call"></i>');
                            $('#Dailing').html(number);
                            // if (data.includes('\"')) { newdata = JSON.parse(data); }
                            var message = data.replace(/\\/g, "");
                            var test = JSON.parse(message);
                            // var data = JSON.parse(JSON.parse(json).data);
                            // var message = JSON.stringify(data.msg);
                            // console.log(test.msg_text);
                            $('#DISMSG').html(test.msg_text);
                            if (test.msg === 'success') { 
                                $('#DISMSG').css("color", "green");
                            }
                            if (test.msg === 'error') { 
                                $('#DISMSG').css("color", "red");
                            }
                        },
                        error: function (data) {
                            $.NotificationApp.send("Error",data,"top-center","red","error");
                        }
                    });
                } else {
                    stopAutoDial();
                }
            });

            function stopAutoDial(){
                $.ajax({
                    url: "{{ route('Crm::stop_auto_dial') }}",
                    type: "GET",
                    data: null,
                    success: function (data) {},
                    error: function (data) {
                        $.NotificationApp.send("Error",data,"top-center","red","error");
                    }
                });
                $('#Dailing').html('');
                $("#pause-play").prop('disabled', false);
            }

            function updateCallDetail(number){
                $('#callDetails').modal('show');
                $.ajax({
                    url: "{{ route('Crm::calling_lead_details') }}",
                    type: "GET",
                    data: { mobile : number},
                    success: function (data) {
                        $('#calling_lead_details').html(data);
                    },
                    error: function (arr_response) {
                        $.NotificationApp.send("Error","Calling API Failed !","top-center","red","error");
                    }
                });
            }

            function callLead(number, filter_by_campaign){
                $("#pause-play").prop('disabled', true);
                console.log(number);
                $.ajax({
                    url: "{{ route('Crm::leads_load_api') }}",
                    type: "GET",
                    data: { mobile : number , campaign : filter_by_campaign, call_type : 1 },
                    success: function (arr_response) {
                        
                        if(arr_response.status !== false && arr_response.duplicate !== true){

                            console.log('SATYA');
                            $('#call-title').html('Calling ... <i class="uil-outgoing-call"></i>');
                            $('#Dailing').html(number);
                            $('#DISMSG').html(arr_response.msg_text);
                            
                            // var timer2 = "0:0";
                            // var interval = setInterval(function() {
                            //     var timer = timer2.split(':');
                            //     var minutes = parseInt(timer[0], 10);
                            //     var seconds = parseInt(timer[1], 10);
                            //     seconds++;
                            //     minutes = (seconds < 0) ? minutes++ : minutes;
                            //     if (minutes < 0) clearInterval(interval);
                            //     seconds = (seconds < 0) ? 59 : seconds;
                            //     seconds = (seconds < 10) ? '0' + seconds : seconds;
                            //     //minutes = (minutes < 10) ?  minutes : minutes;
                            //     $('#call-countdown').html(minutes + ':' + seconds);
                            //     timer2 = minutes + ':' + seconds;
                            // }, 1000);

                            checkAutoCall();
                            if (arr_response.msg === 'success') { 
                                $('#DISMSG').css("color", "green");
                            }
                            if (arr_response.msg === 'error') { 
                                $('#DISMSG').css("color", "red");
                            }
                        }
                        //sleep(1000);
                    },
                    error: function (arr_response) {
                        $.NotificationApp.send("Error","Calling API Failed !","top-center","red","error");
                    }
                });
            }

            $('#CALLING').on('click', function () {
                if ($(this).data('id') === 'manual') {
                    const filter_by_campaign = $('#filter_by_campaign').val();
                    if(filter_by_campaign != ''){
                        $.ajax({
                            url: "{{ route('Crm::campaign_leads_number') }}",
                            type: "GET",
                            data: {filter_by_campaign : filter_by_campaign},
                            success: function (data) {
                                if(data.status == true){
                                    callLead(data.mobile, filter_by_campaign)
                                }else{
                                    $( "#CALLEND" ).trigger( "click" );
                                }
                            },
                            error: function (arr_response) {
                                $.NotificationApp.send("Error","Calling API Failed !","top-center","red","error");
                            }
                        });
                    }else{
                        $.NotificationApp.send("Error","Please select Campaign !","top-center","red","error");
                        //alert("Please select Campaign!");
                    }
                } else {
                    // $.NotificationApp.send("","Manual Calling starting !","top-center","green","success");
                }
            });
            // $(document).ready(function() {
            //     window.setInterval(function() {
            //         $.ajax({
            //             url: "{{ route('incoming.call.check') }}",
            //             type: "GET",
            //             data: {},
            //             success: function(data) {
            //                 if (data.call == true) {
            //                     location.href = "{{route('Crm::lead_details', '')}}" + "/" + data.lead;
            //                 } 
            //                 if (data.call == false) {
            //                     location.href = "{{ route('Crm::leads_create') }}";
            //                 }
            //             },
            //             error: function(data) {
            //                 console(data);
            //             }
            //         });
            //     }, 1000);
            // });
            $(document).on("click", "#top-search-submit", function() {
                var number = $('#top-search').val();
                $.ajax({
                    url: "{{ route('Crm::fetch-leads') }}",
                    type: "GET",
                    data: { mobile : number },
                    success: function (data) {
                        $("#search-dropdown").html(data);
                        //sleep(1000);
                    },
                    error: function (arr_response) {
                        $.NotificationApp.send("Error"," Failed !","top-center","red","error");
                    }
                });
            });

            function checkAutoCall(){
                var checkinterval = setInterval(function() {
                    $.ajax({
                        url: "{{ route('auto.dial.call.check') }}",
                        type: "GET",
                        data: {},
                        success: function(data) {
                            if (data.call == true) {
                                $("#DIS").show();
                                $('#call-title').html('Calling ... <i class="uil-outgoing-call"></i>');
                                $('#Dailing').html(data.lead);


                                $('#Showcall').css("display", "block");
                                $('#Showcall').css("text", "center");
                                $('#Dialer').css("display", "none");
                                $('#CALLING').css("display", "none");
                                
                                $('#CALLEND').attr("data-original-title", "End Call");
                                $('#CALLEND').data("id", "end");
                                
                                $('#CALLEND').removeClass('btn-success');
                                $('#CALLEND').addClass('btn-danger');
                                $('#CALLEND').html('<i class="uil-phone-slash"></i>');
                                $("#pause-play").prop('disabled', true);
                                //if (data.auto_dial == false && data.incoming == true) {
                                    const details = '<button class="btn btn-primary" onclick="updateCallDetail('+data.lead+')">Details</button>';
                                    $('#call-details').html(details);
                                //}
                                //location.href = "{{route('Crm::lead_details', '')}}" + "/" + data.lead;
                            }else if (data.call == false && (data.auto_dial == true && data.incoming == false)) {
                                if(data.auto_dial == false){
                                    $( "#CALLEND" ).trigger( "click" );
                                }else{
                                //console.log('Sujay');
                                clearInterval(checkinterval);
                                //$.domCache('#CALLING').remove();
                                avilableServerDataTable();
                                dashbordCountData(1);
                                setWillDonateParams();
                                //$("#CALLING").click();
                                //$("#CALLING").trigger("click");
                                    const filter_by_campaign = $('#filter_by_campaign').val();
                                    if(filter_by_campaign != ''){
                                        $.ajax({
                                            url: "{{ route('Crm::campaign_leads_number') }}",
                                            type: "GET",
                                            data: {filter_by_campaign : filter_by_campaign},
                                            success: function (data) {
                                                if(data.status == true){
                                                    callLead(data.mobile, filter_by_campaign)
                                                }else{
                                                    $( "#CALLEND" ).trigger( "click" );
                                                }
                                            },
                                            error: function (arr_response) {
                                                $.NotificationApp.send("Error","Calling API Failed !","top-center","red","error");
                                            }
                                        });
                                    }else{
                                        $.NotificationApp.send("Error","Please select Campaign !","top-center","red","error");
                                        //alert("Please select Campaign!");
                                    }
                                }
                                
                            }else{
                                $('#Dailing').html('');
                                $("#pause-play").prop('disabled', false);
                            }
                        },
                        error: function(data) {
                            console(data);
                        }
                    });
                }, 5000);
            }
            
            @if(Laralum::loggedInUser()->id != 1)
                $(document).ready(function() {
                    checkAutoCall();
                    // var pause_time = localStorage.getItem("pause_time");
                    // var pause_limit = localStorage.getItem("pause_limit");
                    // if(pause_time && pause_limit){

                    //     var timer2 = pause_time;
                    //     var pause_limit = pause_limit;
                    // var interval = setInterval(function() {
                    //     var timer = timer2.split(':');
                    //     //by parsing integer, I avoid all extra string processing
                    //     var minutes = parseInt(timer[0], 10);
                    //     var seconds = parseInt(timer[1], 10);
                    //     --seconds;
                    //     minutes = (seconds < 0) ? --minutes : minutes;
                    //     seconds = (seconds < 0) ? 59 : seconds;
                    //     seconds = (seconds < 10) ? '0' + seconds : seconds;
                    //     //minutes = (minutes < 10) ?  minutes : minutes;
                    //     $('.countdown').html(minutes + ':' + seconds);
                    //     if (minutes < 0) clearInterval(interval);
                    //     //check if both minutes and seconds are 0
                    //     if ((seconds <= 0) && (minutes <= 0)) clearInterval(interval);
                    //     timer2 = minutes + ':' + seconds;
                    //     $('.countbreak').html(pause_limit);
                    //     localStorage.setItem("pause_time", timer2);
                    // }, 1000);
                    // localStorage.setItem("pause_limit", pause_limit);
                    // }else{
                        $.ajax({
                            url: "/crm/admin/leads/load/resume",
                            type: "GET",
                            data: {},
                            success: function(data) {
                                // localStorage.setItem("pause_time", data.pause_time);
                                // var timer2 = localStorage.getItem("pause_time");
                                var timer2 = data.pause_time;
                                var pause_limit = data.pause_limit;
                                //var interval = setInterval(function() {
                                    var timer = timer2.split(':');
                                    //by parsing integer, I avoid all extra string processing
                                    var minutes = parseInt(timer[0], 10);
                                    var seconds = parseInt(timer[1], 10);
                                    --seconds;
                                    minutes = (seconds < 0) ? --minutes : minutes;
                                    seconds = (seconds < 0) ? 59 : seconds;
                                    seconds = (seconds < 10) ? '0' + seconds : seconds;
                                    //minutes = (minutes < 10) ?  minutes : minutes;
                                    $('.countdown').html(minutes + ':' + seconds);
                                    if (minutes < 0) clearInterval(interval);
                                    //check if both minutes and seconds are 0
                                    if ((seconds <= 0) && (minutes <= 0)) clearInterval(interval);
                                    timer2 = minutes + ':' + seconds;
                                    $('.countbreak').html(pause_limit);
                                    localStorage.setItem("pause_limit", pause_limit);
                                    localStorage.setItem("pause_time", timer2);
                                //}, 1000);
                            },
                            error: function(data) {
                                $.NotificationApp.send("", "error !", "top-center", "red", "error");
                            }
                        });
                    //}
                });
            @endif

            
        </script>

        <script>
            $(document).on('submit', '#incoming_add_detail', function(e) {
                e.preventDefault();
                $("#incoming_AddDetails").modal("hide");
                var detail = $('#incoming_detail').val();

                //alert(detail);return;
                if (detail == '') {
                    $.NotificationApp.send("Error",'Please enter value',"top-center","red","error");
                    return false;
                }
                var type = "POST";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                var formData = new FormData(this);
                var my_url = '';
                var APP_URL="{{route('console::console')}}";
                if ($('#incoming_detail_type').val() == 3) {
                    my_url = APP_URL + '/manage/departmentData';
                    formData.append('department', detail);
                } else if ($('#incoming_detail_type').val() == 4) {
                    my_url = APP_URL + '/manage/branchData';
                    formData.append('branch', detail);
                } else if ($('#incoming_detail_type').val() == 5) {
                    my_url = APP_URL + '/manage/callPurposeData';
                    formData.append('call_purpose', detail);
                } else if ($('#incoming_detail_type').val() == 2) {
                    my_url = APP_URL + '/manage/insertDonationpurpose';
                    formData.append('purpose', detail);
                } else if ($('#incoming_detail_type').val() == 6) {
                    my_url = APP_URL + '/manage/requestData';
                    formData.append('prayer_request', detail);
                } else
                    my_url = APP_URL + '/manage/memberData';
                var type = "POST";

                var addText=$('#incoming_detail').val();  
                $.ajax({
                    type: type,
                    url: my_url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(data) {
                        if(data.status==true){
                        if($('#incoming_detail_type').val()==1){
                            $('#incoming_member_type_id').val(null).trigger('change');
                            $("#incoming_member_type_id option:last").before("<option value="+addText+">"+addText+"</option>");
                            }else if($('#incoming_detail_type').val()==2){
                                $('#incoming_donation_purpose').val(null).trigger('change');
                                $("#incoming_donation_purpose option:last").before("<option value="+addText+">"+addText+"</option>");
                            }else if($('#incoming_detail_type').val()==4){
                                $('#incoming_location').val(null).trigger('change');
                                $("#incoming_location option:last").before("<option value="+addText+">"+addText+"</option>");
                            }else if($('#incoming_detail_type').val()==5){
                                $('#incoming_call_purpose').val(null).trigger('change');
                                $("#incoming_call_purpose option:last").before("<option value="+addText+">"+addText+"</option>");

                                $('#incoming_call_purpose_radio').val(null).trigger('change');
                                $("#incoming_call_purpose_radio option:last").before("<option value="+addText+">"+addText+"</option>");
                            }else if($('#incoming_detail_type').val()==6){
                                $('#incoming_issue').val(null).trigger('change');
                                $("#incoming_issue option:last").before("<option value="+addText+">"+addText+"</option>");
                            }
                        }
                        $.NotificationApp.send("Success","Data has been submited!","top-center","green","success");
                        setTimeout(function(){
                        }, 3500);
                        
                        if($('#incoming_detail_type').val()==1){
                                $('#callDetails').modal('show');
                            }else if($('#incoming_detail_type').val()==2){
                                $('#callDetails').modal('show');  
                            }else if($('#incoming_detail_type').val()==4){
                                $('#callDetails').modal('show');
                            }else if($('#incoming_detail_type').val()==5){
                                $('#callDetails').modal('show');
                            }else if($('#incoming_detail_type').val()==6){
                                $('#callDetails').modal('show');
                            }
                    },
                    error: function(data) {
                        $.NotificationApp.send("Error",data,"top-center","red","error");
                    }
                });
            });



    




        </script>
        <style>
            .btn-primary {
                color: #fff;
                background-color: #727cf5;
                border-color: #727cf5;
            }
        </style>
    </body>
</html>