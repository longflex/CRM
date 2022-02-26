@extends('layouts.app')
@section('title', trans('laralum.reset_password'))
@section('content')
<div class="row m-0">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 plr-30 login-left">
			<img src="{{ asset('home_assets/images/clever-stack.png') }}" class="login-logo img-fluid" />			
			<img src="{{ asset('home_assets/images/login-bg.png') }}" class="img-fluid login-img" />
		</div>
		
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 plr-30 login-right">			
			<div class="card-body dmt-80">
				
                    <form method="POST" action="{{ url('/password/reset') }}">
                       {!! csrf_field() !!}                   
                        <h3 class="text-muted sign-in-heading">{{ trans('laralum.reset_password') }}</h3>
                         <input type="hidden" name="token" value="{{ $token }}">					
                        <div class="form-group">                            
						    <input type="hidden" name="email" class="login-inp" value="{{ old('email', isset($email) ? $email : '') }}" placeholder="{{ trans('laralum.email') }}" autofocus>
                        </div>
                        <div class="form-group">                            
						   <input type="password" class="login-inp" name="password" placeholder="{{ trans('laralum.password') }}">
                        </div>
                        <div class="form-group">                            
						    <input type="password" class="login-inp" name="password_confirmation" placeholder="{{ trans('laralum.repeat_password') }}">
                        </div>
                       					
                        <div class="row">
							<div class="col-6">

                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-lg btn-primary px-4">
                                    {{ trans('laralum.submit') }}
                                </button>
                            </div>
                            
                        </div>
                    </form>
                </div>
			
		</div>
	</div>
@endsection