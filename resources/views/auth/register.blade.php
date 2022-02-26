@extends('layouts.app')
@section('title', 'Sign Up')
@section('content')
<div class="row m-0">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 plr-30 login-left">
			<img src="{{ asset('home_assets/images/clever-stack.png') }}" class="login-logo img-fluid" />
			
			<img src="{{ asset('home_assets/images/login-bg.png') }}" class="img-fluid login-img" />
		</div>
		
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 plr-30 login-right">
			
			<div class="">
                    @if(\Session::has('message'))
                        <p class="alert alert-info">
                            {{ \Session::get('message') }}
                        </p>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
					   {!! csrf_field() !!}
						<h3 class="text-muted sign-in-heading mt-25">User Sign Up</h3>                           
						   @if(session('success'))
								<p style='font-size: 10px;color:green;'>{!! session('success') !!}<p>
							@endif
							@if(session('error'))
								<p style='font-size: 10px;color:red;'>{!! session('error') !!}<p>
							@endif
							@if(session('warning'))
								<p style='font-size: 10px;color:orange;'>{!! session('warning') !!}<p>
							@endif
							@if(session('info'))
								<p style='font-size: 10px;color:blue;'>{!! session('info') !!}<p>
							@endif
							@if (session('status'))
								<p style='font-size: 10px;color:green;'>{!! session('status') !!}<p>
							@endif																		
							<div class="form-group row social-login">
							<div class="col-md-6">
								 <a href="{{ route('Laralum::social', ['provider' => 'facebook']) }}" class="btn btn-facebook"><i class="fa fa-facebook"></i>Login with Facebook</a>								  
							</div>							
							<div class="col-md-6">								 
								  <a href="{{ route('Laralum::social', ['provider' => 'google']) }}" class="btn btn-google-plus"><i class="fa fa-google"></i>Login with Google</a>
							</div>							
						</div>																			
						<div class="form-group row mtb-30">
							<div class="col-md-12">
							 <div class="d-flex">
								  <hr class="my-auto flex-grow-1">
								  <div class="px-4 or-btn">OR</div>
								  <hr class="my-auto flex-grow-1">
								</div>							 
							</div>
						</div>					                                             											  
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                         <input type="text" class="login-inp" name="name" value="{{ old('name') }}" placeholder="Name">
							@if ($errors->has('name'))
								<span class="help-block">
									<strong>{{ $errors->first('name') }}</strong>
								</span>
							@endif                            
                        </div>
						
						<div class="form-group{{ $errors->has('company_name') ? ' has-error' : '' }}">
                         <input type="text" class="login-inp" name="company_name" value="{{ old('company_name') }}" placeholder="Company Name">
							@if ($errors->has('company_name'))
								<span class="help-block">
									<strong>{{ $errors->first('company_name') }}</strong>
								</span>
							@endif                            
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">						
                          <input type="email" class="login-inp" name="email" value="{{ old('email') }}" placeholder="E-mail Address">
							@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
                         </div>						
						 <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">                            
							<input type="text" class="login-inp" name="mobile" value="{{ old('mobile') }}" placeholder="Phone Number">
							@if ($errors->has('mobile'))
								<span class="help-block">
									<strong>{{ $errors->first('mobile') }}</strong>
								</span>
							@endif
                        </div>
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<input type="password" class="login-inp" name="password" placeholder="Password" autocomplete="off">
							@if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif							
                        </div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							<input type="password" class="login-inp" name="password_confirmation" placeholder="Confirm Password">
							@if ($errors->has('password_confirmation'))
								<span class="help-block">
									<strong>{{ $errors->first('password_confirmation') }}</strong>
								</span>
							@endif                          
                        </div>
							</div>
						</div>
                        
                        
                        <div class="form-group row">                            
							<div class="col-6">
								<a class="btn btn-link px-0" href="{{ route('login') }}">
                                    Sign In&nbsp;&nbsp;<i class="fa fa-sign-in"></i>
                                </a>
                            </div>							
							<div class="col-6 text-right">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
			
		</div>
	</div>
@endsection
