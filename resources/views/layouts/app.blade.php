<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', '')&nbsp;|&nbsp;CleverStack</title>
<link href="{{ asset('home_assets/images/favicon.png') }}" rel="shortcut icon" > 
<link href="{{ asset('home_assets/login/bootstrap.min.css') }}" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
 <!-- Styles -->
<link href="{{ asset('home_assets/css/login.css') }}" rel="stylesheet" >
<!-- Bootstrap core CSS -->
<!-- icon font CSS -->
<!-- Custom Design CSS -->
<!-- Scripts -->
<script>
	window.Laravel = <?php echo json_encode([
		'csrfToken' => csrf_token(),
	]); ?>
</script>
</head>
<body>
@yield('content')
<!-- Scripts -->
<script src="{{ asset('home_assets/js/jquery.min.js') }}"></script>
</body>
</html>
