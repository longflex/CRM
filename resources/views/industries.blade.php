@extends('layouts.master')
@section('title', 'Industries')
@section('content')
   <!--page-content-start-->
<div class="container pt-40 pb-40">
	<div class="row">
	    
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		   <h5 class="sub-heading">The following industries are benefitting from our efficient Unified communication:</h5>
			<div class="row">	
             @if(count($industries)>0)			
				@foreach($industries as $industrie)
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-25">
					<div class="industries_area">
						<img  src="{{ asset('console_public/data/industries/') }}/{{ $industrie->icon }}" alt="{{ $industrie->title }}">
						<h3>{{ $industrie->title }}</h3>
						<p>{{ $industrie->description }}</p>
					</div>
				</div>
				@endforeach
               @endif							
			</div>						
		</div>
	</div>
</div>
<!--page-content-end-->

@endsection
