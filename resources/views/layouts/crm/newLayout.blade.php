<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>@yield('title') - {{ Laralum::settings()->website_title }}</title>
	<meta name="description" content="CleverStack - administration panel">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="_token" content="{{ csrf_token() }}">
	<meta name="author" content="CleverStack - administration panel">
	<link href="{{ asset('home_assets/images/favicon.png') }}" rel="shortcut icon">
	{!! Laralum::includeAssets('laralum_header') !!}
	{!! Laralum::includeAssets('charts') !!}
	@yield('css')
	<link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/font-awesome/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
	<link href="{{ asset(Laralum::publicPath() .'/css/responsive-table.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/css/custom.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/css/selectron.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/css/bootstrap-toggle.min.css') }}" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="{{ asset(Laralum::publicPath() .'/fancy-lightbox/jquery.fancybox.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <!-- bootstrap for Ivr section -->
	<link href="{{ asset(Laralum::publicPath() .'/css/custom-ivr.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/css/callflow-style.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/css/responsive-tabs.css') }}" type="text/css" rel="stylesheet" />
	<!--custom-scrolbar-->
	<link rel="stylesheet" href="{{ asset(Laralum::publicPath() .'/css/jquery.mCustomScrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset(Laralum::publicPath() .'/css/jquery-ui.css') }}" />
    <!-- <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" rel="stylesheet"> -->

	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<style>
		.BTNI {
			background-color: #4CAF50;
			border: none;
			border-radius: 10px;
			color: white;
			padding: 5px 13px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 25px;
			margin: 4px 2px;
			transition-duration: 0.4s;
			cursor: pointer;
			background-color: white; 
			color: black; 
			border: 2px solid #26476c;
		}
		.BTNI:hover {
			background-color: #f9ba48;
			color: white;
		}

		.ui.grid>.row {
			display: table !important;
		}
		
		.dash-middle-area
		{
			margin-bottom: 30px;
			padding-top: 20px;
		}
		
		.nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover
		{
			background-color: transparent;
		}
		
		.tab-content {
			background: transparent;
		}
		
		.nav-tabs li a
		{
			border-bottom: 4px transparent solid;
		}
		
		.nav-tabs li a {
			color: #26476c;
		}
		
		.dash-middle-area .form-inline .form-group {
			display: contents;
			margin-bottom: inherit;
			vertical-align: inherit;
			width: auto;
		}
		
		.dash-item-list {
			margin-top: 15px !important;
			border: 2px #f9ba48 solid;
			padding: 10px;	
			background: #fff;
		}
		
		.dash-item-list-a:first-child {
			margin-top: 60px !important;
				display: block;
		}
		
		.dash-item-list:hover {
			border: 2px #26476c solid;
		}
		
		.dash-item-list h4 {
			font-size: 30px;
			font-weight: bold;
			color: #26476c;
			margin: 0 0 0 30px;
		}
		
		.dash-item-list .media-body, .dash-item-list .media-left, .dash-item-list .media-right {
			vertical-align: middle;
		}
		
		.white-bg
		{
			background:#fff;
		}
		
			
		::after, ::before {

			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;

		}
		::selection {

			background-color: #CCE2FF;
			color: rgba(0,0,0,.87);

		}
		::selection {

			background-color: #CCE2FF;
			color: rgba(0,0,0,.87);

		}

		.page-content {
			padding-top: 34px;
		}

		.left-dashboard-area
		{
			left: 0;
			margin-left: 15px;
			overflow: auto;
		}

		.right-dashboard-area
		{
			position: fixed;
			right: 0;
			overflow: auto;
		}

		.full-width-tabs > ul.nav.nav-tabs {
			display: table;
			width: 100%;
			table-layout: fixed;
		}
		.full-width-tabs > ul.nav.nav-tabs > li {
			float: none;
			display: table-cell;
		}
		.full-width-tabs > ul.nav.nav-tabs > li > a {
			text-align: center;
		}

		.take-all-space-you-can{
			width:100%;
		}

		.daterangepicker {

			top: 147px !important;
		}

		div.dataTables_wrapper div.dataTables_processing {
			background: #26476c !important;
			color: #fff !important;
		}

		table.dataTable thead .sorting_asc::after, table.dataTable thead .sorting_desc::after {
			color: #f9ba48;
		}

		.dialbox{
			border: 2px #f9ba48 solid;
			background: #fff;
			display: none; 
			position: fixed; 
			right: 15px; 
			border-radius: 10px; 
			bottom: 15px; 
			padding-bottom: 0px !important; 
			padding: 20px; 
			height: 400px; 
			width: 300px; 
			overflow: auto; 
			z-index: 100;
		}
		.dialbox:hover {
			border: 2px #26476c solid;
		}

		@media only screen and (min-width: 1200px) {
			.ui.grid.container {
				width: 100% !important;
				padding: 0 15px;
			}
		}
	</style>
</head>

<body>
	<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
		{{ csrf_field() }}
	</form>
	<div class="ui inverted dimmer" id="customID">
		<div class="ui text loader">Loading</div>
	</div>
	@if(session('success'))
	<script>
		swal({
				title: "Nice!",
				text: "{!! session('success') !!}",
				type: "success",
				confirmButtonText: "Cool"
			});
	</script>
	@endif
	@if(session('error'))
	<script>
		swal({
				title: "Whops!",
				text: "{!! session('error') !!}",
				type: "error",
				confirmButtonText: "Okay"
			});
	</script>
	@endif
	@if(session('warning'))
	<script>
		swal({
				title: "Watch out!",
				text: "{!! session('warning') !!}",
				type: "warning",
				confirmButtonText: "Okay"
			});
	</script>
	@endif
	@if(session('info'))
	<script>
		swal({
				title: "Watch out!",
				text: "{!! session('info') !!}",
				type: "info",
				confirmButtonText: "{{ trans('laralum.okai') }}"
			});
	</script>
	@endif
	@if (count($errors) > 0)
	<script>
		swal({
				title: "Whops!",
				text: "<?php foreach($errors->all() as $error){ echo "$error<br>"; } ?>",
				type: "error",
				confirmButtonText: "Okay",
				html: true
			});
	</script>
	@endif
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/console') }}">
				<!-- <img class="logo-image ui fluid small image"
					src="@if(Laralum::settings()->logo) {{ Laralum::settings()->logo }} @else {{ Laralum::laralumLogo() }} @endif"> -->
				</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					@if(Laralum::hasPermission('laralum.admin.dashboard'))
					<li class="{{ request()->is('crm/admin') ? 'active' : '' }}">
						<a href="{{ route('Crm::dashboard') }}"><i class="fa fa-tachometer"></i>Dashboard</a>
					</li>
					@endif
					@if(Laralum::hasPermission('laralum.member.access'))
					<li class="{{ request()->is('crm/admin/members/dashboard') || request()->is('crm/admin/members*') ? 'active' : '' }}">
						<a href="{{ Laralum::hasPermission('laralum.member.dashboard')?route('Crm::members_dashboard'):route('Crm::members') }}"><i class="fa fa-users" aria-hidden="true"></i>Members</a>
					</li>
					@endif
					@if(Laralum::hasPermission('laralum.member.access'))
					<li class="{{ request()->is('crm/admin/leads/dashboard') || request()->is('crm/admin/leads*') ? 'active' : '' }}">
						<a href="{{ Laralum::hasPermission('laralum.member.dashboard')?route('Crm::leads_dashboard'):route('Crm::leads') }}"><i class="fa fa-address-book-o" aria-hidden="true"></i>Leads</a>
					</li>
					@endif
					<li
						class="{{ request()->is('crm/admin/staff/dashboard') || request()->is('crm/admin/staff*') ? 'active' : '' }}">
						<a href="{{ route('Crm::staff') }}"><i class="fa fa-user" aria-hidden="true"></i>Staff</a>
					</li>
					<li
						class="{{ request()->is('crm/admin/staff/dashboard') || request()->is('crm/admin/campaign*') ? 'active' : '' }}">
						<a href="{{ route('Crm::campaign') }}"><i class="fa fa-user" aria-hidden="true"></i>Campaign</a>
					</li>
					
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<button href="javascript:void(0);" id="BRNPLUS" class="btn btn-primary " data-id="open" style="margin:10px; background-color: #f9ba48;">
							<i class="fas fa-phone fa- spin fa- 2x fa -fw"></i>
						</button>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle user-arrow" data-toggle="dropdown" href="javascript:void(0)"
							onclick="$('.dimmer').removeClass('dimmer')">
							<span class="user-text"><strong>{{ substr(Auth::user()->name, 0, 1) }}</strong></span>
							{{ Auth::user()->name }} <span class="caret mobile-show"></span>
						</a>
						<ul class="dropdown-menu">
							@if(Laralum::loggedInUser()->isReseller || Laralum::loggedInUser()->su)
							<li><a href="{{ route('console::profile') }}">Organization Profile</a></li>
							@endif
							<li><a href="{{ url('/') }}" target="_blank"
									onclick="$('.dimmer').removeClass('dimmer')">{{ trans('laralum.visit_site') }}</a>
							</li>
							@if(Laralum::loggedInUser()->su)
							<li><a href="{{ route('console::manage_module') }}">Manage</a></li>
							@endif
							<li><a href="{{ url('/logout') }}"
									onClick="event.preventDefault();document.getElementById('logout-form').submit();">
									{{ trans('laralum.logout') }}
								</a>
							</li>

						</ul>
				</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="pusher back">
		<div class="menu-margin">
			<div class="page-content">
				<div class="menu-pusher">
					@yield('content')
				</div>
			</div>
		</div>
	</div>

	<div class="dialbox w3-center" id="DIS">
		<button class="btn btn-primary btn-xs" id="BRNMINUS" type="button" style="float: right;"><i class="fas fa-minus" aria-hidden="true"></i></button>

		<button class="btn btn-primary" data-id="pause" id="PAUSE" type="button" style="float: left;"><i class="fas fa-pause" aria-hidden="true"></i></button>
		<!-- <div class="row" style="text-align: center; padding-bottom: 10px;">
			<input name="dialnumber" type="text" id="DIAL" style="color: #f9ba48; text-align: right; font-size: 25px; border: hidden;" auto focus readonly fas fa-grip-vertical fab fa-buromobelexperte/>
		</div> -->
		<div id="breakcount" style="col or: #26476c;">Break</div>
		<div class="clearfix"></div>

		<div id="Showcall" class="row" style="display: none;">
			<br><b style="color: #26476c;">Calling ... <i class="fas fa-phone-volume"></i></b><br>
			<h3 style="color: #f9ba48; text-align: center; font-size: 25px; font-weight: bold; margin: 5px;" id="Dailing">&nbsp;</h3><br>
			<div style="font-weight: bold;" id="DISMSG">&nbsp;</div>
			<br><br><br>
			<br><br><br>
		</div>
		<div id="Dialer">
			<div class="row">
				<b id="DIAL" style="color: #26476c; text-align: right; font-size: 25px; font-weight: bold;">&nbsp;</b>
			</div>
			<div class="row">
				<button id="ONE" class="BTNI disable">1</button>
				<button id="TWO" class="BTNI disable">2</button>
				<button id="THREE" class="BTNI disable">3</button>
			</div>
			<div class="row">
				<button id="FOUR" class="BTNI disable">4</button>
				<button id="FIVE" class="BTNI disable">5</button>
				<button id="SIX" class="BTNI disable">6</button>
			</div>
			<div class="row">
				<button id="SEVEN" class="BTNI disable">7</button>
				<button id="EIGHT" class="BTNI disable">8</button>
				<button id="NINE" class="BTNI disable">9</button>
			</div>
			<div class="row">
				<button id="DELE" class="BTNI disable" style="color: #26476c;"><i class="fas fa-arrow-left"></i></button>
				<button id="ZERO" class="BTNI disable">0</button>
				<button id="HASH" class="BTNI disable">#</button>
			</div>
		</div>
		<div class="row" style="position: bottom;">
			<button id="CALLING" data-id="auto" class="BTNI" style="color: #26476c;">&nbsp; <i class="fas fa-retweet"></i> &nbsp;</button>
			<button id="CALLEND" data-id="call" class="BTNI" style="color: green;">&nbsp; <i class="fas fa-phone"></i> &nbsp;</button>
			<!-- <button id="STARTCALL" class="BTNI" style="color: #26476c;"><i class="fas fa-phone"></i></button>
			<button id="MANUAL" class="BTNI" style="color: #26476c;"><i class="fab fa-buromobelexperte"></i></button>
			<button id="CALL" class="BTNI" style="color: green;"><i class="fas fa-phone"></i></button>
			<button id="END" class="BTNI" style="color: red;"><i class="fas fa-phone-slash"></i></button> -->
		</div>
	</div>
	{!! Laralum::includeAssets('laralum_bottom') !!}
	@yield('js')
	<script src="{{ asset(Laralum::publicPath() .'/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset(Laralum::publicPath() .'/js/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset(Laralum::publicPath() .'/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script> -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> -->
	<script>
		$('#CALLING').click(function(){
			if ($(this).data("id") === 'auto') {
				$('#Showcall').css("display", "block");
				$('#Dialer').css("display", "none");
				// $(this).css("display", "none");
				$(this).data("id", "manual");
				$(this).html('&nbsp; <i class="fas fa-grip-vertical"></i> &nbsp;');
				$('#CALLEND').data("id", "end");
				$('#CALLEND').css("color", "red");
				$('#CALLEND').html('&nbsp; <i class="fas fa-phone-slash"></i> &nbsp;');
			} else {
				$('#Dialer').css("display", "block");
				// $(".disable").prop("disabled", false);
				$('#Showcall').css("display", "none");
				$(this).data("id", "auto");
				$(this).html('&nbsp; <i class="fas fa-retweet"></i> &nbsp;');
				$('#CALLEND').data("id", "call");
				$('#CALLEND').css("color", "green");
				$('#CALLEND').html('&nbsp; <i class="fas fa-phone"></i> &nbsp;');
			}
		});
		$('#CALLEND').click(function(){
			if ($(this).data("id") === 'call') {
				$('#Showcall').css("display", "block");
				$('#Dialer').css("display", "none");
				$(this).data("id", "end");
				$(this).css("color", "red");
				$(this).html('&nbsp; <i class="fas fa-phone-slash"></i> &nbsp;');
			} else {
				$('#Showcall').css("display", "none");
				$('#Dialer').css("display", "block");
				$(this).data("id", "call");
				$(this).css("color", "green");
				$(this).html('&nbsp; <i class="fas fa-phone"></i> &nbsp;');
			}
		});
	</script>
	<script>
		function sleep(milliseconds) {
			var start = new Date().getTime();
			for (var i = 0; i < 1e7; i++) {
				if ((new Date().getTime() - start) > milliseconds){
					break;
				}
			}
		}
		$('#CALLING').click( function () {
			if ($(this).data("id") === 'auto') {
				let leads = {!! DB::table('leads')->where('client_id', auth()->user()->id)->get() !!};
				// $(this).attr('disabled','disabled');
				// localStorage.setItem("apifire", "1");
				$(leads).each(function( index, data ) {
					let number = data.mobile;
					$.ajax({
						url: "{{ route('Crm::leads_load_api') }}",
						type: "GET",
						data: { mobile : number },
						success: function (arr_response) {
							// document.getElementById('STARTCALL').disabled = false;
							console.log(arr_response);
							console.log(number);
							// $('#DIS').css("display", "block");
							// $('#DIS').css("transition", "opacity 3s ease-in");
							// $('#DISPLAY').css("display", "block");
							// $('#DISPLAY').css("transition", "opacity 3s ease-out");
							// $('#BRNPLUS').css("display", "none");
							$('#Dailing').html(number);
							$('#DISMSG').html(arr_response.msg_text);
							if (arr_response.msg==='success') { 
								$('#DISMSG').css("color", "green");
							}
							if (arr_response.msg==='error') { 
								$('#DISMSG').css("color", "red");
							}
							// $('#Dailing').css("text-align", "center");
							// $('#Dailing').css("font-weight", "bold");
							// $('#Dailing').css("color", "#f9ba48");
							// $('#DISMSG').css("font-weight", "bold");
							// let Mobile = number;
							// $(Mobile).each(function( index, data ) {
							// 	$.ajax({
							// 		url: '/SARV/Mobile/getMobile/' +Mobile,
							// 		type: "GET",
							// 		data: { },
							// 		success: function (data) {
							// 			$('#MOB').html(data.Mobile);
							// 			$('#STU').html(data.status);
							// 		}
							// 	});
							// });
							// sleep(1000);
						},
						error: function (arr_response) {
							// document.getElementById('STARTCALL').disabled = false;
							// alert('Calling API Failed');
							swal({
								title: "Calling API Failed!",
								text: "",
								type: "error",
								confirmButtonText: "Okay"
							});
						}
					});
				});
			}
		});
		$('#BRNPLUS').click(function(){
			if ($(this).data("id") === 'open') {
				$(this).data("id", "close");
				$(this).html(' <i class="fas fa-phone-volume"></i> ');
				$("#DIS").slideToggle("slow","linear");
				// $('#DIS').css("display", "block");
				// $('#DIS').css("transition", "opacity 3s ease-in");
			} else {
				$(this).data("id", "open");
				$(this).html('<i class="fas fa-phone fa- spin fa- 2x fa -fw"></i>');
				// $('#DIS').css("display", "none");
				$("#DIS").slideToggle("slow","swing");
				// $('#DIS').css("transition", "opacity 3s ease-out");
			}
		});
		$("#BRNMINUS").click(function(){
			$('#BRNPLUS').data("id", "open");
			$('#BRNPLUS').html('<i class="fas fa-phone fa- spin fa- 2x fa -fw"></i>');
			// $('#DIS').css("display", "none");
			$("#DIS").slideToggle("slow","swing");
			// $('#BRNPLUS').css("display", "block");
		});
		$(document).ready(function(){
			localStorage.setItem("pausecounter", "4");
			var m = localStorage.getItem("pausecounter");
			var bre = 'BREAK : ';
			var final = bre.concat(m)
			document.getElementById("breakcount").innerHTML = final;
		});
		// $(document).ready(function(){
		// 	var check = localStorage.getItem("apifire");
		// 	if (check == 1) {
		// 		$('#DIS').css("display", "block");
		// 		$('#DIS').css("transition", "opacity 3s ease-in");
		// 	} else {
		// 		$('#DIS').css("display", "none");
		// 	}
		// 	document.getElementById("BREAK").innerHTML = localStorage.getItem("pausecounter");
		// });
		// $("#BREAK").click(function(){
		// 	var bre = 'BREAK : ';
		// 	var m = localStorage.getItem("pausecounter");
		// 	if (m == 0) {
		// 		$("#BREAK").prop("disabled", true);
		// 	} else {
		// 		var count = m - 1;
		// 		var final = bre.concat(count)
		// 		localStorage.setItem("pausecounter", count);
		// 		// document.getElementById("BREAK").innerHTML += count;
		// 		document.getElementById("BREAK").innerHTML = final;
		// 	}
		// });
		$('#ONE').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+1;
		});
		$('#TWO').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+2;
		});
		$('#THREE').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+3;
		});
		$('#FOUR').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+4;
		});
		$('#FIVE').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+5;
		});
		$('#SIX').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+6;
		});
		$('#SEVEN').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+7;
		});
		$('#EIGHT').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+8;
		});
		$('#NINE').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+9;
		});
		$('#STAR').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+'*';
		});
		$('#ZERO').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+0;
		});
		$('#HASH').click(function(){
			var dial = document.getElementById("DIAL").innerHTML;
			document.getElementById("DIAL").innerHTML = dial+""+'#';
		});

		$('#DELE').click(function(){
			let str = document.getElementById("DIAL").innerHTML;
			str = str.slice(0, -1); 
			document.getElementById("DIAL").innerHTML = str;
		});
		// $('#PAUSE').click(function(){
		// 	$(this).html('<i class="fas fa-play"></i>');
		// 	// $(this).attr('id', 'PLAY');
		// 	document.getElementById('PAUSE').id = 'PLAY';
		// });
		// $('#PLAY').click(function(){
		// 	$(this).html('<i class="fas fa-pause"></i>');
		// 	// $(this).attr('id', 'PAUSE');
		// 	document.getElementById('PLAY').id = 'PAUSE';
		// });
		$('#PAUSE').click(function(){
			if ($(this).data("id") === 'pause') {
				var bre = 'BREAK : ';
				var m = localStorage.getItem("pausecounter");
				if (m == 0) {
					$(this).prop("disabled", true);
				} else {
					var count = m - 1;
					var final = bre.concat(count)
					localStorage.setItem("pausecounter", count);
					document.getElementById("breakcount").innerHTML = final;
					$(this).data("id", "play");
					$(this).html('<i class="fas fa-play"></i>');
				}
			} else {
				$(this).data("id", "pause");
				$(this).html('<i class="fas fa-pause"></i>');
			}
		});
		// $('#CALL').click(function() {
		// 	$(".disable").prop("disabled", true);
		// });
		// $('#END').click(function(){
		// 	$(".disable").prop("disabled", false);
		// 	$("#MANUAL").prop("disabled", true);
		// 	$('#DIAL').css("text-align", "RIGHT");
		// 	$('#DIAL').css("color", "BLACK");
		// 	$('#DIAL').html('&nbsp;');
		// });
		// $('#STARTCALL').click(function(){
		// 	$(".disable").prop("disabled", true);
		// });
		// $('#MANUAL').click(function(){
		// 	$(".disable").prop("disabled", false);
		// 	$('#DIAL').html('&nbsp;');
		// 	$('#DIAL').css("text-align", "RIGHT");
		// 	$('#DIAL').css("color", "BLACK");
		// });
		$('#CALLEND').click(function(){
			let number = document.getElementById("DIAL").innerHTML;
			$('#DIAL').html('&nbsp;');
			$.ajax({
				url: "{{ route('Crm::leads_load_api') }}",
				type: "GET",
				data: { mobile : number },
				success: function (arr_response) {
					console.log(arr_response);
					console.log(number);
					// $('#DIS').css("display", "block");
					// $('#DIS').css("transition", "opacity 3s ease-in");
					$('#Dailing').html(number);
					$('#DISMSG').html(arr_response.msg_text);
					if (arr_response.msg==='success') { 
						$('#DISMSG').css("color", "green");
					}
					if (arr_response.msg==='error') { 
						$('#DISMSG').css("color", "red");
					}
					// $('#Dailing').css("color", "#f9ba48");
					// $('#Dailing').css("text-align", "center");
					// $('#Dailing').css("font-weight", "bold");
					// $('#DISMSG').css("font-weight", "bold");
					// let Mobile = number;
					// $(Mobile).each(function( index, data ) {
					// 	$.ajax({
					// 		url: '/SARV/Mobile/getMobile/' +Mobile,
					// 		type: "GET",
					// 		data: { },
					// 		success: function (data) {
					// 			$('#MOB').html(data.Mobile);
					// 			$('#STU').html(data.status);
					// 		}
					// 	});
					// });
					// sleep(1000);
				},
				error: function (arr_response) {
					// alert('Calling API Failed');
					swal({
						title: "Calling API Failed!",
						text: "",
						type: "error",
						confirmButtonText: "Okay"
					});
				}
			});
		});
	</script>
	<script>
		(function($){
        $(window).on("load",function(){
            $(".content").mCustomScrollbar();
        });
    	})(jQuery);
	</script>
	<!--custom-scrollnar-->

	<!--datepicker-->
	<script src="{{ asset(Laralum::publicPath() .'/js/jquery-ui.js') }}"></script>
	<script>
		$( function() {
			$( "#datepicker" ).datepicker();
			} );
	</script>
	<!--datepicker-->

	<!--tabs-->
	<script src="{{ asset(Laralum::publicPath() .'/js/tabscroll.js') }}"></script>
	<!--tabs-->

	<script>
		$( function() {
    		$( document ).tooltip();
  		} );
	</script>


	
	<script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!};	
	</script>
	<script>
		setInterval(function(){
			var footer = $('.page-footer');
			footer.removeAttr("style");
			var footerPosition = footer.position();
			var docHeight = $( document ).height();
			var winHeight = $( window ).height();
			if(winHeight == docHeight) {
				if((footerPosition.top + footer.height() + 3) < docHeight) {
					var topMargin = (docHeight - footer.height()) - footerPosition.top;
					footer.css({'margin-top' : topMargin + 'px'});
				}
			}
		}, 10);
	</script>

	<script>
    $(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
	</script>
	<script>
		$(document).ready(function(){
	  $('[data-toggle="popover"]').popover();   
	});
	</script>
	<!--new-time-picker-->
	<script>
		$("#bar_menu").click(function(){
	$(".sidebar").toggleClass("sidebar3");
});
	</script>

	<script>
		$("#bar_menu").click(function(){
	$(".menu-pusher").toggleClass("menu-pusher1");
});
	</script>

	<script>
		// Get the modal
		var modal = document.getElementById("myModal");

		// Get the button that opens the modal
		var btn = document.getElementById("myBtn");

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks the button, open the modal 
		btn.onclick = function() {
			modal.style.display = "block";
		}

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			modal.style.display = "none";
		}

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>


	<script>
		$(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu1').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion($('#vertical-menu-height'), false);
});
	</script>

	<script>
		$("#.sidebar3").mouseover(function(){
  $(".sidebar3").addClass(".sidebar").removeClass(".sidebar3")
})
	</script>

	<script>
		$(".sidebar").hover(function () {
    $(this).toggleClass("sidebar4");
});
	</script>

	<script>
		$(document).ready(function(){
    $("#dis-more-unl").click(function(){
      $("#remove").removeClass("more-limit").addClass('more-unlimit');
    });
 });
	</script>

	<script>
		$(document).ready(function(){
    $("#dis-less-unl").click(function(){
      $("#remove").removeClass("more-unlimit").addClass('more-limit');
    });
 });
	</script>



	<script>
		$(document).on("click", function(e){
    if($(e.target).is("#dis-more-unl")){

        $(".more-dis").hide();
    }
});
	</script>

	<script>
		$(document).on("click", function(e){
    if($(e.target).is("#dis-less-unl")){

        $(".less-dis").hide();
    }
});
	</script>

	<script>
		$(document).on("click", function(e){
    if($(e.target).is("#dis-more-unl")){
      $(".less-dis").show();
    }else{
        $("#selectPeriodRangePanel").hide();
    }
});
	</script>

	<script>
		$(document).on("click", function(e){
    if($(e.target).is("#dis-less-unl")){
      $(".more-dis").show();
    }else{
        $("#selectPeriodRangePanel").hide();
    }
});
	</script>

	<script>
		$("#add-g-btn").click(function(){
    $("#add-g-btn").hide();
	 $("#add-g-btn-txt").show();
});

$("#add-g-close-btn").click(function(){
     $("#add-g-btn").show();
	 $("#add-g-btn-txt").hide();
});
	</script>

	<script>
		$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
	</script>

	<!--div-show-hide-->
	<script>
		// Execute something when DOM is ready:
$(document).ready(function(){
   // Delay the action by 10000ms
   setTimeout(function(){
      // Display the div containing the class "bottomdiv"
      $(".bottomdiv").show();
   }, 1000);
});
	</script>
	<script>
		$('#example1').dataTable( {
  "autoWidth": false,
  "ordering": false
} );
	</script>
	

	<!--custom-modal-->
<script>
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}
</script>
<!--custom-modal-->
<!--fancybox-->
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<!-- ivr section -->
<script src="{{ asset(Laralum::publicPath() .'/fancy-lightbox/jquery.fancybox.js') }}"></script>


<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<script>
$('[data-fancybox]').fancybox({
toolbar  : false,
smallBtn : true,
arrows: false,
iframe : {
preload : false,
css : {
	width  : '800px'

}
},

})
</script>
<script type="text/javascript">
$(document).ready(function() {
$('[data-toggle="tooltip"]').tooltip();
});

</script>
<script>
$(document).ready(function(){
$('[data-toggle="popover"]').popover();   
});
</script>
<!--fancybox-->
</body>
</html>