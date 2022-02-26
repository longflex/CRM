@extends('layouts.app')
@section('title', trans('laralum.reset_password'))
@section('content')
<style>
.invalid-feedback {
    display: block !important;
}
</style>
<div class="row m-0">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 plr-30 login-left">
			<img src="{{ asset('home_assets/images/clever-stack.png') }}" class="login-logo img-fluid" />			
			<img src="{{ asset('home_assets/images/login-bg.png') }}" class="img-fluid login-img" />
		</div>
		
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 plr-30 login-right">			
			<div class="card-body dmt-80">
				
                    <form method="POST" action="{{ url('/password/email') }}">
                       {!! csrf_field() !!}                   
                        <h3 class="text-muted sign-in-heading">{{ trans('laralum.reset_password') }}</h3>
                          @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif					
                        <div class="form-group">                            
						   <input type="text" name="email" class="login-inp{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ trans('laralum.email') }}" value="{{ old('email') }}" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Your e-mail address';}">
                        </div>                       										
                        <div class="row">
							<div class="col-6">
                                <a class="btn btn-link px-0" href="{{ route('login') }}">
                                    Sign In&nbsp;&nbsp;<i class="fa fa-sign-in"></i>
                                </a>
								<span class="m-none">&nbsp;&nbsp;|&nbsp;&nbsp;</span>
								<a class="btn btn-link px-0" href="{{ route('register') }}">
                                    Sign Up
                                </a>

                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="btn btn-lg btn-primary px-4">
                                    {{ trans('laralum.send_password_link') }}
                                </button>
                            </div>
                            
                        </div>
                    </form>
                </div>
			
		</div>
	</div>
@endsection