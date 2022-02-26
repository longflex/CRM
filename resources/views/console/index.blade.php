@extends('layouts.console.panel')
@section('title', trans('laralum.console_dashboard_title'))
@section('content')
<div class="content-wrapper">
	<div class="container">
		<!-- Breadcrumbs-->

		<!-- Icon Cards-->
		<div class="row">

			<div class="col-md-12 margin_top_20">

				<div class="row welcome-area">
					<div class="col-md-9">
						<div class="">
							<p><i class="fa fa-smile-o red-txt" aria-hidden="true"></i> Hi {{ Auth::user()->name }},
								Welcome to Clever<span class="yellow-txt">Stack</span></P>
						</div>
					</div>
					@if(Laralum::loggedInUser()->isReseller || Laralum::loggedInUser()->su)
					<div class="col-md-3">
						<small><label>Your Profile Completed</label></small>
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="{{ $total_progress }}"
								aria-valuemin="0" aria-valuemax="100" style="width: {{ $total_progress }}%;">
								<span class="show">{{ $total_progress }}%</span>
							</div>
						</div>
					</div>
					@endif
				</div>

				<div class="my-services">
					<p>My Services</P>
				</div>


				<div class="row mb-55">

					<div class="col-md-3 mb-50">
						@if(($total_progress>0 && Laralum::loggedInUser()->isReseller) or
						(!Laralum::loggedInUser()->isReseller) or Laralum::loggedInUser()->su)
						<div class="consol-dashboard-area dashboard-list">
							<a
								href="{{ Laralum::hasPermission('laralum.admin.dashboard')?route('Crm::dashboard'):(Laralum::hasPermission('laralum.member.dashboard')?route('Crm::leads_dashboard'):route('Crm::leads') ) }}">
								<img src="{{ asset(Laralum::publicPath() . '/images/clever-stack-crm.png') }}"
									class="" />
								<button class="dashboard-boxes-btn">CleverStack CRM</button>
							</a>
						</div>
						@else
						<div class="consol-dashboard-area dashboard-list">
							<a href="{{ route('console::profile') }}">
								<img src="{{ asset(Laralum::publicPath() . '/images/clever-stack-crm.png') }}"
									class="" />
								<button class="dashboard-boxes-btn">CleverStack CRM</button>
							</a>
						</div>
						@endif
					</div>

					<div class="col-md-3 mb-50">
						@if(($total_progress>0 && Laralum::loggedInUser()->isReseller) or
						(!Laralum::loggedInUser()->isReseller) or Laralum::loggedInUser()->su)
						<div class="consol-dashboard-area dashboard-list">
							@if(Laralum::hasPermission('laralum.sms.dashboard'))
							<a href="{{ route('Laralum::dashboard') }}">
								<img src="{{ asset(Laralum::publicPath() . '/images/cs-sms.png') }}" class="" />
								<button class="dashboard-boxes-btn">SMS</button>
							</a>
							@else
							<a onclick="showPermissionAlert('Sms Dashboard');">
								<img src="{{ asset(Laralum::publicPath() . '/images/cs-sms.png') }}" class="" />
								<button class="dashboard-boxes-btn">SMS</button>
							</a>
							@endif
						</div>
						@else
						<div class="consol-dashboard-area dashboard-list">
							<a href="{{ route('console::profile') }}">
								<img src="{{ asset(Laralum::publicPath() . '/images/cs-sms.png') }}" class="" />
								<button class="dashboard-boxes-btn">SMS</button>
							</a>
						</div>
						@endif
					</div>

					<div class="col-md-3 mb-50">
						<div class="consol-dashboard-area dashboard-list">
							<a href="javascript:void(0);" onclick="showAlert('voice broadcasting');">
								<img src="{{ asset(Laralum::publicPath() . '/images/voice-brodcast.png') }}" class="" />
								<button href="javascript:void(0);" onclick="showAlert('voice broadcasting');"
									class="dashboard-boxes-btn">Voice Broadcasting</button>
							</a>
						</div>
					</div>

					<div class="col-md-3 mb-50">
						<div class="consol-dashboard-area dashboard-list">
							<a href="javascript:void(0);" onclick="showAlert('whatsapp marketing');">
								<img src="{{ asset(Laralum::publicPath() . '/images/whats-app.png') }}" class="" />
								<button href="javascript:void(0);" onclick="showAlert('whatsapp marketing');"
									class="dashboard-boxes-btn">WhatsApp</button>
							</a>
						</div>
					</div>

					<div class="col-md-3 mb-50">
						<div class="consol-dashboard-area dashboard-list">
							@if(Laralum::hasPermission('laralum.sms.dashboard'))
							<a href="{{ route('Ivr::dashboard') }}">
								<img src="{{ asset(Laralum::publicPath() . '/images/ivr.png') }}" class="" />
								<button class="dashboard-boxes-btn">IVR</button>
							</a>
							@else
							<a onclick="showPermissionAlert('Ivr');">
								<img src="{{ asset(Laralum::publicPath() . '/images/ivr.png') }}" class="" />
								<button class="dashboard-boxes-btn">IVR</button>
							</a>
							@endif

						</div>
					</div>

					<div class="col-md-3 mb-50">
						<div class="consol-dashboard-area dashboard-list">
							<a href="javascript:void(0);" onclick="showAlert('audio conference');">
								<img src="{{ asset(Laralum::publicPath() . '/images/audio-c.png') }}" class="" />
								<button href="javascript:void(0);" onclick="showAlert('audio conference');"
									class="dashboard-boxes-btn">Audio Conference</button>
							</a>
						</div>
					</div>

					<div class="col-md-3 mb-50">
						<div class="consol-dashboard-area dashboard-list">
							<a href="javascript:void(0);" onclick="showAlert('video conference');">
								<img src="{{ asset(Laralum::publicPath() . '/images/video-c.png') }}" class="" />
								<button href="javascript:void(0);" onclick="showAlert('video conference');"
									class="dashboard-boxes-btn">Video Conference</button>
							</a>
						</div>
					</div>

					<div class="col-md-3 mb-50">
						<div class="consol-dashboard-area dashboard-list">
							<a href="javascript:void(0);" onclick="showAlert('email marketing');">
								<img src="{{ asset(Laralum::publicPath() . '/images/email-m.png') }}" class="" />
								<button href="javascript:void(0);" onclick="showAlert('email marketing');"
									class="dashboard-boxes-btn">Email Marketing</button>
							</a>
						</div>
					</div>

				</div>

			</div>



		</div>


		<style>
			.page-content {
				padding-top: 0;
			}

			.content-title {
				display: none;
			}

			.sweet-alert .sa-icon.sa-info {
				border-color: #EA9D0E !important;
			}

			.sweet-alert .sa-icon.sa-info::before {
				background-color: #EA9D0E !important;
			}

			.sweet-alert .sa-icon.sa-info::after {
				background-color: #EA9D0E !important;
			}

			.sweet-alert .sa-confirm-button-container .confirm {
				background-color: #26476c !important;
			}
		</style>
		<script>
			function showAlert(type){
	$('.dimmer').removeClass('dimmer')
    swal("Coming soon...", "We are working on "+type+"!", "info");
}

function showPermissionAlert(type){
	$('.dimmer').removeClass('dimmer')
    swal("You don't have "+type+" permission.","Please contact your administrator!", "info");
}

		</script>

		@endsection