@extends('layouts.master')
@section('title', $prod_details->title)
@section('content')
   <!--page-content-start-->
<div class="container pt-40 pb-40">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<!--product-list-area-1-start-->
			<div class="cs-product-detail">
				<div class="row">
					<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
						<a href="#">
							<img src="{{ asset('console_public/data/products/') }}/{{ $prod_details->image }}" class="img-fluid product-main-img img-thumbnail" />
						</a>
						<!--span class="badge badge-warning product-offer">Offer</span-->
					</div>
					<div class="col-lg-7 col-lg-7 col-md-7 col-sm-12 col-12">
						<h3 class="product-heading">{{ $prod_details->title }}</h3>
						
						{!! $prod_details->description !!}
						<div class="row product_descrption">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="card">
									<div class="card-body">
										<div class="row">
											
									   <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
										   <form method="POST" id="calculate_form" action="javascript:void(0)" >
										   <input type="hidden" value="{{ $prod_details->product_type }}" />
										   @if($prod_details->product_type==2)
											<div class="form-group">
												<select class="form-control custom-select" name="sms_type" id="sms_type">
													<option value="">SMS Type</option>
													<option value="Transactional">Transactional SMS</option>
													<option value="Promotional">Promotional SMS</option>
												</select>
											</div>	
                                            @endif											
											<div class="form-group">
											   @if($prod_details->product_type==2)
												<label>Number of SMS</label>
											    @else
												<label>Quantity</label>
												@endif
												<input type="text" placeholder="Enter quantity" name="msg_qty" id="msg_qty" class="form-control" />
											</div>
											<button type="submit" id="calculationForm" class="signup-btn"><span id="hidectext">CALCULATE</span>&nbsp;
											<span class="calculationForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
											</button>											
											</form>												
										</div>
											
										<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">																								
											<h4><b><span id="per_sms_price">{{ !empty($price_details->flat_price) ? $price_details->flat_price : '0' }}</span>/Credit</b> INR</h4>											
											<p class="mb-5"><small>*{{ !empty($price_details->gst_extra) ? $price_details->gst_extra : '0' }}% GST Extra</small></p>
											<p class="mb-5"><small>*Min. Purchase: {{ !empty($price_details->min_purchase) ? $price_details->min_purchase : '0' }} Credits</small></p>
											<div class="clearfix"></div>
											<span class="show_calculation" style="display:none;">
												<p class="mb-5">Total Qty: <span id="total_qty">9,000</span></p>
												<p class="mb-5">Price Per SMS: <span id="total_price">9,000</span></p>
												<p>Total Amount: <span id="total_amount">9,000</span> INR</p>
											</span>
																						
										</div>											
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>						
						
					</div>
						
					<!--ADDITIONAL INFORMATION-->
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<h3 class="product-heading mt-40 mb-30">ADDITIONAL INFORMATION</h3>
						
						<div class="row">
						  @if(!empty($prod_details->sub_product_title1))
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
								<div class="pro-detail-list">
									<img src="{{ asset('console_public/data/products/sub_product') }}/{{ $prod_details->sub_product_icon1 }}" title="{{ $prod_details->sub_product_title1 }}" alt="{{ $prod_details->sub_product_title1 }}" width="60">
									<h4>{{ $prod_details->sub_product_title1 }}</h4>
									<p>{{ $prod_details->sub_product_desc1 }}</p>
								</div>
							</div>
							@endif
							@if(!empty($prod_details->sub_product_title2))
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
								<div class="pro-detail-list">
									<img src="{{ asset('console_public/data/products/sub_product') }}/{{ $prod_details->sub_product_icon2 }}" title="{{ $prod_details->sub_product_title2 }}" alt="{{ $prod_details->sub_product_title2 }}" width="60">
									<h4>{{ $prod_details->sub_product_title2 }}</h4>
									<p>{{ $prod_details->sub_product_desc2 }}</p>
								</div>
							</div>
							@endif
							@if(!empty($prod_details->sub_product_title3))
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
								<div class="pro-detail-list">
									<img src="{{ asset('console_public/data/products/sub_product') }}/{{ $prod_details->sub_product_icon3 }}" title="{{ $prod_details->sub_product_title3 }}" alt="{{ $prod_details->sub_product_title3 }}" width="60">
									<h4>{{ $prod_details->sub_product_title3 }}</h4>
									<p>{{ $prod_details->sub_product_desc3 }}</p>
								</div>
							</div>
							@endif
							@if(!empty($prod_details->sub_product_title4))
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12">
								<div class="pro-detail-list">
									<img src="{{ asset('console_public/data/products/sub_product') }}/{{ $prod_details->sub_product_icon4 }}" title="{{ $prod_details->sub_product_title4 }}" alt="{{ $prod_details->sub_product_title4 }}" width="60">
									<h4>{{ $prod_details->sub_product_title4 }}</h4>
									<p>{{ $prod_details->sub_product_desc4 }}</p>
							</div>
							@endif
						</div>
						
					</div>
					<!--ADDITIONAL INFORMATION-->
					
					
				</div>
			</div>
			<!--product-list-area-1-end-->
		 
		</div>
	</div>
</div>
<!--page-content-end-->
</div>
@endsection