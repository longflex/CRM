@extends('layouts.app')
@section('title', 'Sign In')
@section('content')
<div class="row m-0">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 plr-30 login-left">
			<img src="{{ asset('home_assets/images/clever-stack.png') }}" class="login-logo img-fluid" />			
			<img src="{{ asset('home_assets/images/login-bg.png') }}" class="img-fluid login-img" />
		</div>
		
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 plr-30 login-right">			
			<div class="card-body dmt-80">
                    @if(\Session::has('message'))
                        <p class="alert alert-info">
                            {{ \Session::get('message') }}
                        </p>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                       
                        <h3 class="text-muted sign-in-heading">User Sign In</h3>
						
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
						
                        <div class="form-group">
                            <input name="email" type="text" class="login-inp{{ $errors->has('email') ? ' is-invalid' : '' }}" required autofocus placeholder="Email" value="{{ old('email', null) }}" autocomplete="off">
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
						
						

                        <div class="form-group">
                            <input name="password" type="password" class="login-inp{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="Password">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-4">
                            <div class="form-check checkbox">
                                <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                                <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                    Remember me
                                </label>
                            </div>
                        </div>												
                        <div class="row">
							<div class="col-6">
                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                    Forgot your password?
                                </a>
								<span class="m-none">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
								<a class="btn btn-link px-0" href="{{ route('register') }}">
                                    Sign Up
                                </a>

                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-lg btn-primary px-4">
                                    Login
                                </button>
                            </div>
                            
                        </div>
                    </form>
                </div>
			
		</div>
	</div>
@endsection