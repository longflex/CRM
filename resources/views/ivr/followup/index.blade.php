@extends('layouts.ivr.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">FollowUp</div>
    </div>
@endsection
@section('title', "FollowUp"))
@section('icon', "mobile")
@section('subtitle', trans('laralum.vehicle_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container mb-20">
    <div class="column">	  	  	  	  
      <div class="ui very padded segment">
			<div class="ui negative icon message">
				<i class="frown icon"></i>
				<div class="content">
					<div class="header">
						{{ trans('laralum.missing_title') }}
					</div>
					<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "data"]) }}</p>
				</div>
			</div>
  		</div>
  	</div>
  </div>  
@endsection
@section('js')
@endsection
