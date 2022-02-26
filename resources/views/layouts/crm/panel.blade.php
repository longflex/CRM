<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>@yield('title') - {{ Laralum::settings()->website_title }}</title>
	<meta name="description" content="CleverStack - administration panel">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="_token" content="{{ csrf_token() }}">
	<meta name="author" content="CleverStack - administration panel">
	<link href="{{ asset('home_assets/images/favicon.png') }}" rel="shortcut icon">
	{!! Laralum::includeAssets('laralum_header') !!}
	{!! Laralum::includeAssets('charts') !!}
	@yield('css')
	<link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/font-awesome/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
	<link href="{{ asset(Laralum::publicPath() .'/css/responsive-table.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/css/custom.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/css/selectron.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/css/bootstrap-toggle.min.css') }}" type="text/css" rel="stylesheet" />
</head>

<body>
	<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
		{{ csrf_field() }}
	</form>
	<div class="ui inverted dimmer" id="customID">
		<div class="ui text loader">Loading</div>
	</div>
	@if(session('success'))
	<script>
		swal({
				title: "Nice!",
				text: "{!! session('success') !!}",
				type: "success",
				confirmButtonText: "Cool"
			});
	</script>
	@endif
	@if(session('error'))
	<script>
		swal({
				title: "Whops!",
				text: "{!! session('error') !!}",
				type: "error",
				confirmButtonText: "Okay"
			});
	</script>
	@endif
	@if(session('warning'))
	<script>
		swal({
				title: "Watch out!",
				text: "{!! session('warning') !!}",
				type: "warning",
				confirmButtonText: "Okay"
			});
	</script>
	@endif
	@if(session('info'))
	<script>
		swal({
				title: "Watch out!",
				text: "{!! session('info') !!}",
				type: "info",
				confirmButtonText: "{{ trans('laralum.okai') }}"
			});
	</script>
	@endif
	@if (count($errors) > 0)
	<script>
		swal({
				title: "Whops!",
				text: "<?php foreach($errors->all() as $error){ echo "$error<br>"; } ?>",
				type: "error",
				confirmButtonText: "Okay",
				html: true
			});
	</script>
	@endif
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/console') }}">
					<img class="logo-image ui fluid small image"
						src="@if(Laralum::settings()->logo) {{ Laralum::settings()->logo }} @else {{ Laralum::laralumLogo() }} @endif"></a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					@if(Laralum::hasPermission('laralum.admin.dashboard'))
					<li class="{{ request()->is('crm/admin') ? 'active' : '' }}">
						<a href="{{ route('Crm::dashboard') }}"><i class="fa fa-tachometer"></i>Dashboard</a>
					</li>
					@endif
					@if(Laralum::hasPermission('laralum.member.access'))
					<li class="{{ request()->is('crm/admin/members/dashboard') || request()->is('crm/admin/members*') ? 'active' : '' }}">
						<a href="{{ Laralum::hasPermission('laralum.member.dashboard')?route('Crm::members_dashboard'):route('Crm::members') }}"><i class="fa fa-users" aria-hidden="true"></i>Members</a>
					</li>
					@endif
					@if(Laralum::hasPermission('laralum.member.access'))
					<li class="{{ request()->is('crm/admin/leads/dashboard') || request()->is('crm/admin/leads*') ? 'active' : '' }}">
						<a href="{{ Laralum::hasPermission('laralum.member.dashboard')?route('Crm::leads_dashboard'):route('Crm::leads') }}"><i class="fa fa-address-book-o" aria-hidden="true"></i>Leads</a>
					</li>
					@endif
					<li
						class="{{ request()->is('crm/admin/staff/dashboard') || request()->is('crm/admin/staff*') ? 'active' : '' }}">
						<a href="{{ route('Crm::staff') }}"><i class="fa fa-user" aria-hidden="true"></i>Staff</a>
					</li>
					<li
						class="{{ request()->is('crm/admin/staff/dashboard') || request()->is('crm/admin/campaign*') ? 'active' : '' }}">
						<a href="{{ route('Crm::campaign') }}"><i class="fa fa-user" aria-hidden="true"></i>Campaign</a>
					</li>
					
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a class="dropdown-toggle user-arrow" data-toggle="dropdown" href="javascript:void(0)"
							onclick="$('.dimmer').removeClass('dimmer')">
							<!--user-icon-start-->
							<span class="user-text"><strong>{{ substr(Auth::user()->name, 0, 1) }}</strong></span>
							<!--<img src="https://source.unsplash.com/random/50x50" class="user-pic" />-->
							<!--user-img-end-->
							{{ Auth::user()->name }} <span class="caret mobile-show"></span>
						</a>
						<ul class="dropdown-menu">
							@if(Laralum::loggedInUser()->isReseller || Laralum::loggedInUser()->su)
							<li><a href="{{ route('console::profile') }}">Organization Profile</a></li>
							@endif
							<li><a href="{{ url('/') }}" target="_blank"
									onclick="$('.dimmer').removeClass('dimmer')">{{ trans('laralum.visit_site') }}</a>
							</li>
							@if(Laralum::loggedInUser()->su)
							<li><a href="{{ route('console::manage_module') }}">Manage</a></li>
							@endif
							<li><a href="{{ url('/logout') }}"
									onClick="event.preventDefault();document.getElementById('logout-form').submit();">
									{{ trans('laralum.logout') }}
								</a>
							</li>

						</ul>
						{{-- <ul class="dropdown-menu">
            
			<li><a href="{{ route('Laralum::profile') }}">{{ trans('laralum.profile') }}</a>
					</li>
					<li><a href="{{ route('Laralum::transaction') }}">{{ trans('laralum.transaction_list') }}</a></li>

					<li><a href="{{ route('Laralum::receipt') }}">{{ trans('laralum.receipt_request') }}</a></li>

					<li><a href="{{ url('/') }}" target="_blank"
							onclick="$('.dimmer').removeClass('dimmer')">{{ trans('laralum.visit_site') }}</a></li>

					<li><a href="{{ url('/logout') }}"
							onClick="event.preventDefault();document.getElementById('logout-form').submit();">
							{{ trans('laralum.logout') }}
						</a></li>

				</ul> --}}
				</li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="pusher back">
		<div class="menu-margin">
			<div class="content-title">
				<div class="menu-pusher">
					<div class="ui one column doubling stackable grid container">
						<div class="column">

							<div class="item menu-pusher" id="breadcrumb">
								@yield('breadcrumb')
							</div>

						</div>
					</div>
				</div>
			</div>
			<div class="page-content">
				<div class="menu-pusher">
					@yield('content')
				</div>
			</div>
			<br><br>
			<!--div class="page-footer">
				<div class="ui bottom fixed padded segment">
					<div class="menu-pusher">
						<div class="ui container">
							<a href="{{ url('/') }}" class="ui tiny header">
								{{ Laralum::websiteTitle() }}
							</a>
							<?php
										$locales = Laralum::locales();

										if($locale = Laralum::loggedInUser()->locale) {
											$locale = $locales[$locale];
										} else {
											$locale = $locales['en'];
										}
									 ?>

							<a class="ui tiny header right floated" href='http://technodreamsit.com/'
								target="_blank">&copy; Copyright TechnoDreams </a>

						</div>
					</div>
				</div>
			</div-->
		</div>
	</div>
	{!! Laralum::includeAssets('laralum_bottom') !!}
	@yield('js')
	<script src="{{ asset(Laralum::publicPath() .'/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset(Laralum::publicPath() .'/js/bootstrap-toggle.min.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!};	
	</script>
	<script>
		setInterval(function(){
			var footer = $('.page-footer');
			footer.removeAttr("style");
			var footerPosition = footer.position();
			var docHeight = $( document ).height();
			var winHeight = $( window ).height();
			if(winHeight == docHeight) {
				if((footerPosition.top + footer.height() + 3) < docHeight) {
					var topMargin = (docHeight - footer.height()) - footerPosition.top;
					footer.css({'margin-top' : topMargin + 'px'});
				}
			}
		}, 10);
	</script>

	<script>
    $(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
	</script>
	<script>
		$(document).ready(function(){
	  $('[data-toggle="popover"]').popover();   
	});
	</script>
	<!--new-time-picker-->
	<script>
		$("#bar_menu").click(function(){
	$(".sidebar").toggleClass("sidebar3");
});
	</script>

	<script>
		$("#bar_menu").click(function(){
	$(".menu-pusher").toggleClass("menu-pusher1");
});
	</script>

	<script>
		// Get the modal
var modal = document.getElementById('mySchedule');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
	</script>


	<script>
		$(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu1').not($next).slideUp().parent().removeClass('open');
		};
	}	

	var accordion = new Accordion($('#vertical-menu-height'), false);
});
	</script>

	<script>
		$("#.sidebar3").mouseover(function(){
  $(".sidebar3").addClass(".sidebar").removeClass(".sidebar3")
})
	</script>

	<script>
		$(".sidebar").hover(function () {
    $(this).toggleClass("sidebar4");
});
	</script>

	<script>
		$(document).ready(function(){
    $("#dis-more-unl").click(function(){
      $("#remove").removeClass("more-limit").addClass('more-unlimit');
    });
 });
	</script>

	<script>
		$(document).ready(function(){
    $("#dis-less-unl").click(function(){
      $("#remove").removeClass("more-unlimit").addClass('more-limit');
    });
 });
	</script>



	<script>
		$(document).on("click", function(e){
    if($(e.target).is("#dis-more-unl")){

        $(".more-dis").hide();
    }
});
	</script>

	<script>
		$(document).on("click", function(e){
    if($(e.target).is("#dis-less-unl")){

        $(".less-dis").hide();
    }
});
	</script>

	<script>
		$(document).on("click", function(e){
    if($(e.target).is("#dis-more-unl")){
      $(".less-dis").show();
    }else{
        $("#selectPeriodRangePanel").hide();
    }
});
	</script>

	<script>
		$(document).on("click", function(e){
    if($(e.target).is("#dis-less-unl")){
      $(".more-dis").show();
    }else{
        $("#selectPeriodRangePanel").hide();
    }
});
	</script>

	<script>
		$("#add-g-btn").click(function(){
    $("#add-g-btn").hide();
	 $("#add-g-btn-txt").show();
});

$("#add-g-close-btn").click(function(){
     $("#add-g-btn").show();
	 $("#add-g-btn-txt").hide();
});
	</script>

	<script>
		$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
	</script>

	<!--div-show-hide-->
	<script>
		// Execute something when DOM is ready:
$(document).ready(function(){
   // Delay the action by 10000ms
   setTimeout(function(){
      // Display the div containing the class "bottomdiv"
      $(".bottomdiv").show();
   }, 1000);
});
	</script>
	<script>
		$('#example1').dataTable( {
  "autoWidth": false,
  "ordering": false
} );
	</script>
	<!--custom-modal-->
<script>
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}
</script>
<!--custom-modal-->
<!--fancybox-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script>
$('[data-fancybox]').fancybox({
toolbar  : false,
smallBtn : true,
arrows: false,
iframe : {
preload : false,
css : {
	width  : '800px'

}
},

})
</script>
<script type="text/javascript">
$(document).ready(function() {
$('[data-toggle="tooltip"]').tooltip();
});

</script>
<script>
$(document).ready(function(){
$('[data-toggle="popover"]').popover();   
});
</script>
<!--fancybox-->
</body>
</html>