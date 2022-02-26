@extends('layouts.console.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::getway') }}">{{ trans('laralum.getway_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.getway_create_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.getway_create_title'))
@section('content')
<div class="ui doubling stackable grid container mb-30">
    <div class="three wide column"></div>
    <div class="ten wide column">
        <div class="ui very padded segment">
            <form class="ui form" method="POST">
                {{ csrf_field() }}
				<!-- STRING COLUMN -->
				<div class="field ">
				<label>GATEWAY NAME</label>
				<input type="text" id="gateway_name" name="gateway_name" placeholder="Gateway name" value="">
				</div>
				<!-- STRING COLUMN -->
				<div class="field ">
				<label>SMS API</label>
				<input type="text" id="send_sms_api" name="send_sms_api" placeholder="Send sms api" value="">
				</div>
				<!-- STRING COLUMN -->
				<div class="field ">
				<label>UNICODE SMS API</label>
				<input type="text" id="send_unicode_sms_api" name="send_unicode_sms_api" placeholder="Send unicode sms api" value="">
				</div>
				<!-- STRING COLUMN -->
				<div class="field ">
				<label>BALANCE API</label>
				<input type="text" id="balance_sms_api" name="balance_sms_api" placeholder="Balance sms api" value="">
				</div>
				<!-- STRING COLUMN -->
				<div class="field ">
				<label>DELIVERY SMS API</label>
				<input type="text" id="delivery_sms_api" name="delivery_sms_api" placeholder="Delivery sms api" value="">
				</div>
				<!-- INTEGER COLUMN -->
				<div class="field ">
				<label>BATCH SIZE</label>
				<input type="number" id="batch_size" name="batch_size" placeholder="Batch size" value="">
				</div>
				<!-- INTEGER COLUMN -->
				<div class="field ">
				<label>TRANSACTIONAL SMS ID</label>
				<input type="number" id="transactional" name="transactional" placeholder="Transactional sms id" value="">
				</div>
				<!-- INTEGER COLUMN -->
				<div class="field ">
				<label>PROMOTIONAL SMS ID</label>
				<input type="number" id="promotional" name="promotional" placeholder="promotional sms id" value="">
				</div>
				
				<div class="field">
				<label>METHOD</label>
				<div class="ui search dropdown selection"><select name="method" id="method">
				<option value="POST">POST</option>
				<option value="GET">GET</option>
				</select><i class="dropdown icon"></i><input class="search" autocomplete="off" tabindex="0"><div class="text">POST</div><div class="menu" tabindex="-1"><div class="item active selected" data-value="POST">POST</div><div class="item" data-value="GET">GET</div></div></div>
				</div>
				<!-- STRING COLUMN -->
				<div class="field ">
				<label>AUTHENTICATION STRING<small>(API KEY)</small></label>
				<input type="text" id="authentication_string" name="authentication_string" placeholder="Authentication string" value="">
				</div>
                <br>
                <button type="submit" class="ui {{ Laralum::settings()->button_color }} submit button">{{ trans('laralum.submit') }}</button>
            </form>
        </div>
    </div>
    <div class="three wide column"></div>
</div>
@endsection
