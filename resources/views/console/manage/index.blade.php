@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.module_manager') }}</div>
    </div>
@endsection
@section('title', trans('laralum.module_manager'))
@section('subtitle', trans('laralum.module_manager'))
@section('content')
  <div class="ui one column doubling stackable grid container mb-20">
  	<div class="column">	  
  		<div class="ui very padded segment">
		           <div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
									<i class="fa fa-users text-info"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::users') }}">Clients</a></h3>
									<span class="counter text-info">{{ $users }}</span>
								</div>
							</div>
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
									<i class="fa fa-briefcase text-success"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::roles') }}">Role</a></h3>
									<span class="counter text-success">{{ $roles }}</span>
								</div>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
									<i class="fa fa-key text-purple"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::permissions') }}">Permission</a></h3>
									<span class="counter text-purple">{{ $permissions }}</span>
								</div>
							</div>
                        </div>
                    </div>	
                     <div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
									<i class="fa fa-file-image-o text-purple"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::kyc') }}">KYC</a></h3>
									<small class="counter text-purple">For Approval</small>
								</div>
							</div>
                        </div>
                    </div>								
  		           <div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
									<i class="fa fa fa-comments text-success"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::testimonials') }}">Testimonials</a></h3>
									<span class="counter text-success">{{ $testimonial }}</span>
								</div>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
									<i class="fa fa-picture-o text-yellow"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::banners') }}">Banners</a></h3>
									<span class="counter text-yellow">{{ $banner }}</span>
								</div>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
									<i class="fa fa-th-list text-purple"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::products') }}">Products</a></h3>
									<span class="counter text-purple">{{ $product }}</span>
								</div>
							</div>
                        </div>
                    </div>
					
					<div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
									<i class="fa fa-file-text text-info"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::pages') }}">Pages</a></h3>
									<span class="counter text-info">{{ $page }}</span>
								</div>
							</div>
                        </div>
                    </div>
                   <div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
								    <i class="fa fa-industry text-yellow"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::industries') }}">Industries</a></h3>
									<span class="counter text-yellow">{{ $industries }}</span>
								</div>
							</div>
                        </div>
                    </div>
					<div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
								<i class="fa fa-tags text-purple"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::pricing') }}">Pricing</a></h3>
									<span class="counter text-purple">{{ $permissions }}</span>
								</div>
							</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
								    <i class="fa fa-envelope-square text-success"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::enquiry') }}">Enquiry</a></h3>
									<span class="counter text-success">{{ $roles }}</span>
								</div>
							</div>
                        </div>
                    </div>


                  <div class="col-md-3">
                        <div class="white-box analytics-info">
							<div class="row">
								<div class="col-xs-6">
								    <i class="fa fa-tags text-yellow"></i>
								</div>
								<div class="col-xs-6 p-0">
									<h3 class="box-title"><a href="{{ route('console::getway') }}">{{ trans('laralum.getway_manager') }}</a></h3>
									<span class="counter text-yellow"></span>
								</div>
							</div>
                        </div>
                    </div>								
					
  		</div>
  	</div>
  </div>
@endsection
@section('js')
@endsection
