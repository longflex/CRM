@extends('layouts.master')
@section('title', 'Products')
@section('content')
   <!--page-content-start-->
<div class="container pt-40 pb-40">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		  @if(count($products)>0)
			@foreach($products as $product)
			<!--product-list-area-1-start-->
			<div class="cs-product-list">
				<div class="row">
					<div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
						<a href="#">
							<img src="{{ asset('console_public/data/products/') }}/{{ $product->image }}" class="img-fluid product-main-img img-thumbnail" />
						</a>
						
						<!--span class="badge badge-warning product-offer">Offer</span-->
					</div>
					<div class="col-lg-8 col-lg-8 col-md-7 col-sm-12 col-12">
						<h3 class="product-heading">{{ $product->title }}</h3>
						
						{!! $product->description !!}
						
						<a href="{{ url('/solutions') }}/{{ $product->id }}/{{  $product->url }}" class="product-view-btn mmb-15">View More ...</a>
						
						
					</div>
				</div>
			</div>
			<!--product-list-area-1-end-->
		 @endforeach
		@endif				
		</div>
	</div>
</div>
<!--page-content-end-->

@endsection
