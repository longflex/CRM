<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="_token" content="{{ csrf_token() }}">
	<link href="{{ asset(Laralum::publicPath() .'/font-awesome/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet" />        
   <link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('console_public/css/sb-admin.css') }}" rel="stylesheet">
	<link href="{{ asset(Laralum::publicPath() .'/css/custom.css') }}" type="text/css" rel="stylesheet" />  
	{!! Laralum::includeAssets('laralum_header') !!}
	<style>
body {
    margin: 0;
    max-width: 900px;
    padding: 0;
    padding: 20px;
	
}

.expand {
    background: rgba(0, 0, 0, .05);
}

.btn-primary
{
	background:#000068;
	border-color:#000068;
	font-size: 16px;
}

.btn-primary:hover
{
	background:#EC1228;
	border-color:#EC1228;
}

.mb-15
{
	margin-bottom: 15px !important;
}

.heading
{
	border-bottom: 1px #26476c solid;
margin: 20px 0 25px 0 !important;
padding-bottom: 12px;
color: #26476;
}

.fancybox-close-small{
    right: 15px !important;
    top: 0 !important;
    color: #26476c !important;
}
.fancybox-nav {
  display:none;
}
</style>
</head>
<body>
<div class="container-fluid">
<div class="row">			
<div class="col-md-12">
	<h3 class="heading">
	@if(\Request::segment(6)=='2') Pending @else Resolved   @endif Request List</h3>
</div>
<div class="col-sm-12">				
<table class="ui four column table">
<thead>
<tr>
<th class="text-left" width="60%">Issue</th>
<th class="d-text-center" width="20%">Date</th>
<th class="text-left" width="20%">Taken by</th>				
</tr>
</thead>
<tbody>
@foreach($data as $d)
<tr>
<td class="left">{{ $d->issue }}</td>
<td class="d-text-center">{{ date('d/m/Y', strtotime($d->created_at)) }}</td>
<td class="left">{{ $d->taken_by }}</td>							
</tr>
@endforeach
</tbody>
</table>

</div>
								
</div>
</div>
<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!};	
</script>
<script src="{{ asset(Laralum::publicPath() .'/js/jquery-3.0.0.min.js') }}"></script>	  

</body>
</html>