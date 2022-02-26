@extends('layouts.crm.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
	<div class="active section">{{ trans('laralum.donation_title') }}</div>
</div>
@endsection
@section('title', trans('laralum.donation_title'))
@section('icon', "mobile")
@section('subtitle', trans('laralum.donation_subtitle'))
@section('content')
<div class="ui one column doubling stackable grid container mb-20">
	<div class="column">
		<div class="ui very padded segment">
			<div class="row">
				<div class="col-md-12 text-right">
					<!-- <a href="{{ route('Crm::donation_create') }}"
						class="res_ex ui {{ Laralum::settings()->button_color }} button">
						<i class="fa fa-plus icon_m"
							aria-hidden="true"></i><span>{{ trans('laralum.donation_create') }}</span>
					</a> -->
					<a href="{{ route('Crm::donations_export', ['client_id' => $client_id]) }}"
						class="res_ex ui {{ Laralum::settings()->button_color }} button" id="Export"
						onclick="$('.dimmer').removeClass('dimmer')">
						<i class="fas fa-download icon_m"></i><span>{{ trans('laralum.export') }}</span>
					</a>
					<a href="javascript:void(0)" class="res_ex ui {{ Laralum::settings()->button_color }} button"
						id="ImportShow" onclick="$('.dimmer').removeClass('dimmer')">
						<i class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span>
					</a>
					<a href="javascript:void(0)" class="res_ex ui {{ Laralum::settings()->button_color }} button"
						id="FilterShow" onclick="$('.dimmer').removeClass('dimmer')">
						<i class="fas fa-filter"></i> <span>Filter</span>
					</a>
				</div>
			</div>
			<div class="filter-area" style="display: none;">
				<div class="row">
					<form class="ui form" method="GET" action="{{ route('Crm::donations') }}">
						<div class="col-md-12 mb-15">
							<h4><i class="fas fa-filter"></i> <span>Filter</span></h4>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Donation Type</label>
								<select class="form-control custom-select" name="donation_type">
									<option value="" selected>All</option>
									<option value="1" @if(request()->get('donation_type')==1) selected @endif>Sponsor
									</option>
									<option value="2" @if(request()->get('donation_type')==2) selected @endif>Land
										Donation</option>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Payment Mode</label>
								<select class="form-control custom-select" name="payment_mode">
									<option value="" selected>All</option>
									<option value="CASH" @if(request()->get('payment_mode')=='CASH') selected
										@endif>Cash</option>
									<option value="CARD" @if(request()->get('payment_mode')=='CARD') selected
										@endif>Card</option>
									<option value="CHEQUE" @if(request()->get('payment_mode')=='CHEQUE') selected
										@endif>Cheque</option>
									<option value="QRCODE" @if(request()->get('payment_mode')=='QRCODE') selected
										@endif>QR code</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>From Date</label>
										<input type="date" value="{{ request()->get('from_date') }}"
											placeholder="From date" name="from_date" class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>To Date</label>
										<input type="date" value="{{ request()->get('to_date') }}" placeholder="To date"
											name="to_date" class="form-control" />
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 text-right">
							<button type="submit" class="res_ex ui teal button">Filter</button>
						</div>
					</form>
				</div>
			</div>
			<!--import-area-->
			<div class="import-area" style="display: none;">
				<div class="row">
					<form class="ui form form-inline" method="POST" enctype="multipart/form-data"
						action="{{ route('Crm::donations_import') }}">
						<div class="col-md-12">
							<h4 class="mb-15"><i
									class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span></h4>
						</div>
						{{ csrf_field() }}
						<div class="col-md-6 col-md-offset-6 text-right">
							<div class="form-group">
								<input type="file" name="file" class="form-control" />
								<input type="hidden" value="{{ $client_id }}" name="import_donation_client_id" />
								<input type="submit" name="importSubmit" class="res_ex ui teal button ml-5"
									value="Import">
							</div>
							<div class="mb-15 text-right">
								<a href="{{ url('files/sample-csv-donations.csv') }}" download>Download Sample File</a>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!--import-area-->
			@if(count($donations) > 0)
			<table class="ui five column table ">
				<thead>
					<tr>
						<th>Receipt No</th>
						<th>Donated by</th>
						<th>Donation Type</th>
						<th>Purpose</th>
						<th>Phone</th>
						<th>Amount</th>
						<th>Mode</th>
						<th>Status</th>
						<th>Location</th>
						<th>Date</th>
						<th>{{ trans('laralum.options') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($donations as $donation)
					<tr>
						<td>
							<div class="text">
								{{ $donation->receipt_number }}
							</div>
						</td>
						<td>
							<div class="text">
								{{ $donation->name }}
							</div>
						</td>
						<td>
							<div class="text">
								{{ $donation->payment_type }}
							</div>
						</td>
						<td>
							<div class="text">
								{{ $donation->donation_purpose??'N.A.' }}
							</div>
						</td>
						<td>
							<div class="text">
								{{ $donation->mobile }}
							</div>
						</td>
						<td>
							<div class="text">
								{{ $donation->amount }}
							</div>
						</td>
						<td>
							<div class="text">
								{{ $donation->payment_mode=='OTHER'?$donation->payment_method:$donation->payment_mode }}
							</div>
						</td>
						<td>
							<div class="text">
								{{ $donation->payment_status?'Paid':'Pending' }}
							</div>
						</td>
						<td>
							<div class="text">
								{{ $donation->location }}
							</div>
						</td>
						<td>
							<div class="text">
								{{  date("d/m/Y h:i:s A", strtotime($donation->created_at)) }}
							</div>
						</td>

						@if($donation->payment_type=='recurring')

						<td>
							<a href="{{ route('Crm::payment_detail', ['id' => $donation->id]) }}" class="ui {{ Laralum::settings()->button_color }} top icon left  button">
								<i class="edit icon"></i>
							</a>
						</td>
						@else
						<td>
							<a href="{{ route('Crm::donation_details', ['id' => $donation->id]) }}"
								class="ui {{ Laralum::settings()->button_color }} top icon left  button">
								<i class="print icon"></i>
							</a>
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
			@else
			<div class="ui negative icon message">
				<i class="frown icon"></i>
				<div class="content">
					<div class="header">
						{{ trans('laralum.missing_title') }}
					</div>
					<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "donation"]) }}</p>
				</div>
			</div>
			@endif
			{{ $donations->links() }}
		</div>
	</div>
</div>
<!-- Status Modal -->
@endsection
@section('js')
<script src="{{ asset('crm_public/js/donation-script.js') }}" type="text/javascript"></script>
<script>
	$("#FilterShow").click(function(){
  $(".filter-area").slideToggle();
});
$("#ImportShow").click(function(){
  $(".import-area").slideToggle();
});
</script>
<script>
	$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});



</script>
@endsection
