@extends('layouts.ivr.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
    <div class="active section">{{ trans('laralum.dashboard') }}</div>
</div>
@endsection
@section('title', trans('laralum.dashboard'))
@section('icon', "dashboard")
@section('subtitle')
{{ trans('laralum.welcome_user', ['name' => Laralum::loggedInUser()->name]) }}
@endsection
@section('content')

<div class="container-fluid new-dashboard">
	<div class="row">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="dash-box-content">
								<h3 class="blue-text">INR 0</h3>
								<p><i class="far fa-money-bill-alt"></i> Current Balance</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">
						<div class="dash-box-content">
								<h3 class="light-blue-text"><i class="fas fa-phone"></i> 0</h3>
								<p>Todays Calls</p>
							</div>
					  </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">
						<div class="dash-box-content">
								<h3 class="red-text"><i class="fas fa-phone-slash"></i> 0</h3>
								<p>Todays Missed Calls</p>
							</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
					  <div class="panel-body">
						<div class="dash-box-content">
								<h3 class="green-text"><i class="fa fa-phone-square"></i> 0</h3>
								<p>Total DID</p>
							</div>
					  </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">
						<div class="dash-box-content">
								<h3 class="orange-text"><i class="fas fa-users"></i> 0</h3>
								<p>Agent Online</p>
							</div>
					  </div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">
						<div class="dash-box-content">
								<h3 class="blue-text"><i class="fas fa-phone-volume"></i> 0</h3>
								<p>Active Calls</p>
							</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-default">
			  <div class="panel-body">
				<div class="new-right-box">
				<p>MOUDLES HITS (LAST 30 DAYS)</p>
				</div>
			  </div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			  <div class="panel-body">
				
				<p>TRAFFIC</p>
				
			  </div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			  <div class="panel-body text-center">
				<a href="{{ route('Ivr::complete_setup') }}" class="ui {{ Laralum::settings()->button_color }} submit button" style="text-align:center;">Complete the setup</a>
				<p>It will take less then 15 minutes to convert your trial account to an active account.</p>
			  </div>
			</div>
		</div>
	</div>
	
</div>

<br>
@endsection
