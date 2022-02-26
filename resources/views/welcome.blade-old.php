@extends('layouts.main')
@section('title', 'Home')
@section('content')
 <link href="{{ asset('home_assets/css/owl.carousel.min.css') }}" rel="stylesheet"> 
<Style>
.blur1{ filter: blur(2px); transition: .4s } 
.linkblur:hover{ filter: blur(0px)!important;}
canvas {
  display: block;
  vertical-align: bottom;
}

/* ---- stats.js ---- */

.count-particles{
  background: #000022;
  position: absolute;
  top: 48px;
  left: 0;
  width: 80px;
  color: #13E8E9;
  font-size: .8em;
  text-align: left;
  text-indent: 4px;
  line-height: 14px;
  padding-bottom: 2px;
  font-family: Helvetica, Arial, sans-serif;
  font-weight: bold;
}

.js-count-particles{
  font-size: 1.1em;
}

#stats,
.count-particles{
  -webkit-user-select: none;
}

#stats{
  border-radius: 3px 3px 0 0;
  overflow: hidden;
}

.count-particles{
  border-radius: 0 0 3px 3px;
}
.line-1{   
    top: 50%;  
    width: 24em;
    margin: 0 auto;
    border-right: 2px solid rgba(255,255,255,.35);
    font-size: 180%;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;       
}

/* Animation */
.anim-typewriter{
  animation: typewriter 4s steps(44) 1s 1 normal both,
             blinkTextCursor 500ms steps(44) infinite normal;
}
@keyframes typewriter{
  from{width: 0;}
  to{width:18em;}
}
@keyframes blinkTextCursor{
  from{border-right-color: rgba(255,255,255,.35);}
  to{border-right-color: transparent;}
}



</style>


<div style="background-color:#161d2f; padding:90px 0px 40px!important; position: relative; " class="container-fluid main">
	<div class="container ">
	     <div class="row text-center">
	     	<div class="col-lg-6 col-md-12  col-xs-12 left hasblur " style="padding-left:20px;">
      
	     			<h1 class="heading-top">{{ $banner->title ? $banner->title : '' }}</h1>

					<p class="line-1 anim-typewriter">Centralized Thought of<b style="font-weight: 400; color: #d97091"> CleverStack</b></p>
					<p> {!! $banner->description ? $banner->description : '' !!}</p>	
					<a href="{{ url('/register') }}" class="btan">Get A Demo</a>
					<a href="{{ url('/contacts') }}" class="btan" data-toggle="modal" data-target="#call_back_modal" style="margin-left: 5px; color: #d97091 !important; border-color:#a43c5d !important; background: #d970911c!important">
					<i class="fas fa-phone-volume"></i>&nbsp; Get A Call</a>
					<p style="height: 260px" class="mobdisplaynone height260"></p>
	     	</div>

	     	<div class="col-lg-6 col-md-10 col-xs-12 banner-img-area">
				<img src="{{ asset('console_public/data/banner/') }}/{{ $banner->image }}" class="img-fluid" />
			</div>
			
	     </div>
	</div>
</div>

<!--Client Section start here-->
<div class="container-fluid pt-3 border-bot">
<div class="container home-client-slider">
    <div class="pageheading text-center mt-4 mb-5">Over {{ count($testimonials) }}   <span>Happy Customers!</span> <img src="{{ asset('home_assets/images/smile.svg') }}" alt="" width="30" style="opacity:0.8;"  /></div>
    <div class="owl-carousel owl-theme">
	   @if(count($testimonials)>0)
		@foreach($testimonials as $testimonial)
        <div class="item">
		<img  src="{{ asset('console_public/data/testimonial/') }}/{{ $testimonial->company_logo }}" style="width: 150px;" alt="">
		</div>
		@endforeach
	   @endif
    </div>
  </div>
</div>
<!--Client Section end here-->



<div class="container-fluid mt-5 pt-3 shape-pattern-bg">

	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h2 class="pageheading mb-5 text-center">{{ $home_section->title ? $home_section->title : '' }}</h2>
				<div class="service_descrption">
				   {!! $home_section->description ? $home_section->description : '' !!}
				</div>
			</div>
		</div>
		</div>

	

	<!-- ivr flow section -->
	
	<div class="container">
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<img src="{{ asset('console_public/data/page/') }}/{{ $home_section->image }}" class="img-fluid mx-auto d-block" width="50%" />
			</div>
		</div>
	</div>

	  	<!-- ivr flow section -->

	  	<hr>

  @if(count($products)>0)
   @foreach($products as $product)
    @if($loop->iteration % 2 == 0)
	<!-- Email Marketing section Start here -->
	<div  class="container mt-0 email-marketing-section"> 
		<div class="row">		
			<div class="col-lg-6 col-md-12 col-12 mob-homefeature"> 
				<div class="service_descrption email-marketing-txt text-center margintop40 ">
					   <a href="#" title="{{ $product->title }}">{{ $product->title }}</a>
					  {!! $product->description !!}
				</div>	
				
				<div class="feature_io pt-3 email-marketing-feature">
					<ul>
					   @if(!empty($product->sub_product_title1))
						<li class="border-green">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon1 }}" title="{{ $product->sub_product_title1 }}" alt="{{ $product->sub_product_title1 }}" width="55"></span>
							<h4>{{ $product->sub_product_title1 }}</h4>
							<p>{{ $product->sub_product_desc1 }}</p>
						</li>
						@endif
						@if(!empty($product->sub_product_title2))
						<li class="border-purple">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon2 }}" title="{{ $product->sub_product_title2 }}" alt="{{ $product->sub_product_title2 }}" width="55"></span>
							<h4>{{ $product->sub_product_title2 }}</h4>
							<p>{{ $product->sub_product_desc2 }}</p>
						</li>
						@endif
						@if(!empty($product->sub_product_title3))
						<li class="border-yellow"> 
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon3 }}" title="{{ $product->sub_product_title3 }}" alt="{{ $product->sub_product_title3 }}" width="50"></span>
							<h4>{{ $product->sub_product_title3 }}</h4>
							<p>{{ $product->sub_product_desc3 }}</p>
						</li>
						@endif
						@if(!empty($product->sub_product_title4))
						<li class="border-red">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon4 }}" title="{{ $product->sub_product_title4 }}" alt="{{ $product->sub_product_title4 }}" width="48"></span>
							<h4>{{ $product->sub_product_title4 }}</h4>
							<p>{{ $product->sub_product_desc4 }}​</p>
						</li>
						@endif
					</ul>
				</div>
				
			</div>
			<div class="col-lg-6 col-md-12 col-12"> 
			<div class="desktop_screen"> 
				<img src="{{ asset('console_public/data/products/') }}/{{ $product->image }}" class="img-fluid" title="{{ $product->title }}" alt="{{ $product->title }}" width="100%">
			</div>  
			</div>  
		</div>
	</div>
   <!-- Email Marketing section end here -->
  @else
   <!-- Transactional Email section Start here -->
	<div class="container pt-5 pb-5 margintop40 transactional-email-section"> 
		<div class="row"> 			 
			<div class="col-md-12 col-lg-6">
				<div class="desktop_screen mt-0">
					<img src="{{ asset('console_public/data/products/') }}/{{ $product->image }}" class="img-fluid" title="{{ $product->title }}" alt="{{ $product->title }}" width="100%">
				</div>
			</div>
			<div class="col-md-12 col-lg-6 minus-mar-top20 mobpadlr0" style="float:right;">
				<div class="service_descrption text-center">
				  <a class="" href="#" title="{{ $product->title }}">{{ $product->title }}</a>
					  {!! $product->description !!}
					  
				</div>
				
				<div class="feature_io pt-3">
					<ul>
						@if(!empty($product->sub_product_title1))
						<li class="border-green">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon1 }}" title="{{ $product->sub_product_title1 }}" alt="{{ $product->sub_product_title1 }}" width="55"></span>
							<h4>{{ $product->sub_product_title1 }}</h4>
							<p>{{ $product->sub_product_desc1 }}</p>
						</li>
						@endif
						@if(!empty($product->sub_product_title2))
						<li class="border-purple">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon2 }}" title="{{ $product->sub_product_title2 }}" alt="{{ $product->sub_product_title2 }}" width="55"></span>
							<h4>{{ $product->sub_product_title2 }}</h4>
							<p>{{ $product->sub_product_desc2 }}</p>
						</li>
						@endif
						@if(!empty($product->sub_product_title3))
						<li class="border-yellow"> 
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon3 }}" title="{{ $product->sub_product_title3 }}" alt="{{ $product->sub_product_title3 }}" width="50"></span>
							<h4>{{ $product->sub_product_title3 }}</h4>
							<p>{{ $product->sub_product_desc3 }}</p>
						</li>
						@endif
						@if(!empty($product->sub_product_title4))
						<li class="border-red">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $product->sub_product_icon4 }}" title="{{ $product->sub_product_title4 }}" alt="{{ $product->sub_product_title4 }}" width="48"></span>
							<h4>{{ $product->sub_product_title4 }}</h4>
							<p>{{ $product->sub_product_desc4 }}​</p>
						</li>
						@endif
					</ul>
				</div>
			</div> 
		</div>
	</div>
   <!-- Transactional Email section end here -->
  @endif
@endforeach
@endif		
</div>
@if(isset($crm_product))
<div class="container-fluid wallet-section mt-5 blue-area-product">
	<div class="container">
		
		<div class="row">
		
				<div class="col-md-12 col-lg-6 minus-mar-top20 mobpadlr0">
				<div class="service_descrption text-center">
				  <a class="" href="#" title="{{ $crm_product->title }}">{{ $crm_product->title }}</a>
				   {!! $crm_product->description !!}
				</div>
		
				<div class="feature_io pt-3">
					<ul>
						@if(!empty($crm_product->sub_product_title1))
						<li class="border-green">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $crm_product->sub_product_icon1 }}" title="{{ $crm_product->sub_product_title1 }}" alt="{{ $crm_product->sub_product_title1 }}" width="55"></span>
							<h4>{{ $crm_product->sub_product_title1 }}</h4>
							<p>{{ $crm_product->sub_product_desc1 }}</p>
						</li>
						@endif
						@if(!empty($crm_product->sub_product_title2))
						<li class="border-purple">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $crm_product->sub_product_icon2 }}" title="{{ $crm_product->sub_product_title2 }}" alt="{{ $crm_product->sub_product_title2 }}" width="55"></span>
							<h4>{{ $crm_product->sub_product_title2 }}</h4>
							<p>{{ $crm_product->sub_product_desc2 }}</p>
						</li>
						@endif
						@if(!empty($crm_product->sub_product_title3))
						<li class="border-yellow"> 
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $crm_product->sub_product_icon3 }}" title="{{ $crm_product->sub_product_title3 }}" alt="{{ $crm_product->sub_product_title3 }}" width="50"></span>
							<h4>{{ $crm_product->sub_product_title3 }}</h4>
							<p>{{ $crm_product->sub_product_desc3 }}</p>
						</li>
						@endif
						@if(!empty($crm_product->sub_product_title4))
						<li class="border-red">
							<span><img src="{{ asset('console_public/data/products/sub_product') }}/{{ $crm_product->sub_product_icon4 }}" title="{{ $crm_product->sub_product_title4 }}" alt="{{ $crm_product->sub_product_title4 }}" width="48"></span>
							<h4>{{ $crm_product->sub_product_title4 }}</h4>
							<p>{{ $crm_product->sub_product_desc4 }}​</p>
						</li>
						@endif
					</ul>
				</div>
			</div>
			
			<div class="col-lg-6 col-md-12">
					<img src="{{ asset('console_public/data/products/') }}/{{ $crm_product->image }}" alt="{{ $crm_product->title }}" class="img-fluid">
				</div>

					
		</div>
	</div>
</div>
@endif
<div class="clearfix"></div>
<!--hr style="margin-top:90px;" class="mobdisplaynone"-->
<div class="container-fluid testimonial-sec">
	<div class="container">
		<div class="client">
		 <h5 class="pageheading text-center mb-3 pb-3 text-uppercase">What Our happy clients have to say about us ?</h5>
		 <div class="testimonial-box">
		 		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"> 
					  <div class="carousel-inner">
                        @if(count($testimonials)>0)
		                @foreach($testimonials as $testimonial)
					    <div class="carousel-item @if ($loop->first) active @endif">
					        <p>{{ $testimonial->comments }}</p>
							<div class="col-md-12 text-center revier">
							{{ $testimonial->company_name }} <font>{{ $testimonial->company_url }}</font>
							</div>
					    </div>
					    @endforeach
					    @endif
					  </div>
					  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					    <i class="icon fas fa-chevron-left"></i> 
					  </a>
					  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					     <i class="icon fas fa-chevron-right"></i>
					  </a>
					   <ol class="carousel-indicators">
					    @if(count($testimonials)>0)
		                @foreach($testimonials as $key=>$testimonial)
					    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}" @if ($loop->first) class="active" @endif>
					    	<img src="{{ asset('console_public/data/testimonial/') }}/{{ $testimonial->company_logo }}" alt="{{ $testimonial->company_name }}" />
					    </li>
					    @endforeach
					    @endif
					  </ol>
				</div>
           <div class="col-lg-12 col-md-12 text-center"><a href="#" class="btn btn-view-all">View All</a></div>
		 </div>
		</div>
	</div>

</div>
<style type="text/css">
	.showmodulebx{ display: block!important; opacity: 1; visibility: visible; }
</style>
<section>
	<div class="get-started">
    <div class="container">
     <div class="row">
     	<div class="col-md-12">
        <h6>Ready to Get Started?</h6>
        <p>Enjoy the experience, CleverStack is the right choice for you and your business! </p>
        <div style="text-align: center;"><a href="{{ url('/register') }}">Start Today Now</a></div>
    </div>
    </div>
    </div>
</div>
</section>
@stop
