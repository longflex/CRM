@extends('layouts.master')
@section('title', $content->title)
@section('content')
   <!--page-content-start-->
<div class="container pt-40 pb-40">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			{!! $content->description !!}						
		</div>
	</div>
</div>
<!--page-content-end-->

@endsection
