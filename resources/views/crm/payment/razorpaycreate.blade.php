@extends('layouts.crm.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
	<a class="section" href="{{ route('Crm::payments') }}">{{  trans('laralum.payment_title') }}</a>
	<i class="right angle icon divider"></i>
	<div class="active section">{{ trans('laralum.payment_create_title') }}</div>
</div>
@endsection
@section('title', trans('laralum.payment_create_title'))
@section('icon', "plus")
@section('subtitle', trans('laralum.payment_create_subtitle'))
@section('content')
<div class="ui one column doubling stackable grid container">
	<div class="three wide column"></div>
	<div class="ui very padded segment">
		<div class="fifteen wide column">

			<div class="col-md-12">
				<h3 class="form-heading">Make Payment</h3>
			</div>

			<form class="ui form" action="/crm/admin/payments/razorpaycreate" method="POST" enctype="multipart/form-data"
				id="upload_payment_formaa">
				{{ csrf_field() }}
                <script src="https://checkout.razorpay.com/v1/checkout.js"
						data-key="{{ env('RAZOR_KEY') }}"
						data-amount="100"
						data-buttontext="Pay with Razorpay"
						data-name="test payment"
						data-description="Rozerpay"
						data-image="{{ asset('/eventnutsui/images/clever-stack.png') }}"
						data-prefill.name="name"
						data-prefill.email="email"
						data-theme.color="#ff7529">
				</script>
			</form>

			
		</div>
	</div>
	<div class="three wide column"></div>
</div>

@endsection