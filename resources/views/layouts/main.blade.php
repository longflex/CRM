<!DOCTYPE html>
<html lang="en">
<head>
<title>@yield('title', '')&nbsp;|&nbsp;CleverStack</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link href="{{ asset('home_assets/images/favicon.png') }}" rel="shortcut icon" > 
<!-- Bootstrap core CSS -->
<link href="{{ asset('home_assets/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- icon font CSS -->
<link href="{{ asset('home_assets/font-awesome/css/all.css') }}" rel="stylesheet"> 
<!-- Custom Design CSS -->
<link href="{{ asset('home_assets/css/style.css') }}" rel="stylesheet"> 
<link href="{{ asset('home_assets/css/product-style.css') }}" rel="stylesheet">
  
<link href="{{ asset('home_assets/css/responsive.css') }}" rel="stylesheet">  
<style>
.offer{animation: offer 2s infinite; padding: 0 !important; border-radius: 15px; margin:5px 0 0 20px;border:5px solid rgba(255, 197, 32, 0.5)}
@-webkit-keyframes offer {
  0% {-webkit-box-shadow: 0 0 0 0 rgba(243, 182, 85, 0.4);}
  70% {-webkit-box-shadow: 0 0 0 10px rgba(243, 182, 85, 0);}
  100% {-webkit-box-shadow: 0 0 0 0 rgba(243, 182, 85, 0);}
}
 @media screen and (max-width: 480px) {
.offer {margin-left: 0px; width: 64px;
  } 
}
</style> 

 

</head>
<body>
	<header class="navbar navbar-expand-lg sticky-top header">
		<div class="container">
		<a class="navbar-brand text-light" href="{{ url('/') }}">
		<img  src="{{ asset('home_assets/images/clever-stack.png') }}" class="d-inline-block align-middle header-logo" alt="">

		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown"> 
		<ul class="navbar-nav mr-auto pl-5 head_ul">
			<li class="nav-item">
			<a class="nav-link" href="{{ url('/solutions') }}">Solutions</a>
			</li>  
			<li class="nav-item">
			<a class="nav-link" href="{{ url('/industries') }}">Industries</a>
			</li>  
			<li class="nav-item">
			<a class="nav-link" href="{{ url('/resource') }}">Resource</a>  
			</li>
		</ul>
		<div class="form-inline my-2 my-lg-0">
		<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
    		{{ csrf_field() }}
    	</form>
		<ul class="navbar-nav right-menu ml-5">
			@if(Auth::check())
			<li class="nav-item">
			<a class="nav-link signup-btn" href="{{ url('/console') }}">Console</a> 
			</li>	
			<li class="nav-item">
			<a class="nav-link login-btn" href="{{ url('/logout') }}" onClick="event.preventDefault();document.getElementById('logout-form').submit();">LOGOUT</a>
			</li>		
			@else
			<li class="nav-item dropdown">
		      <a class="dropdown-toggle nav-link login-btn" data-toggle="dropdown" href="#">LOG IN<span class="caret"></span></a>
				<ul class="dropdown-menu">
				  <li><a href="http://sms.mesms.in" class="nav-link login-btn" target="_blank">SMS</a></li>
				  <li><a href="http://voice.mesms.in/login.php" class="nav-link login-btn" target="_blank">Voice</a></li>
				  <li><a href="http://audio.mesms.in/login" class="nav-link login-btn" target="_blank">Audio Conference</a></li>
				</ul>
			 </li>
			<!--li class="nav-item">
			<a class="nav-link login-btn" href="{{ url('/login') }}">LOG IN</a>
			</li>
			<li class="nav-item">
			<a class="nav-link signup-btn" href="{{ url('/register') }}">SIGN UP</a> 
			</li-->
			@endif
		</ul>
		</div>
		</div>
		</div>
	</header> 

<!--content-area-->

 @yield('content')
    
<!--content-area-->


<!--Footer-Wrap-->
  <section class="footercontainer" >
<div class="click scrollup"><i class="fas fa-angle-double-up"></i></div>
<div class="container-fluid ">   
    <div class="container">        	
             <div class="row">
             	<div class="col-lg-8 col-md-12">
             		 <div class="col-md-12 col-sm-12">
             		   <div class="row"> 
             		 	<div class="col-lg-3 col-md-6 contact supportnumber" ><i style="transform: rotate(100deg);" class="fas fa-phone"></i><a href="tel:+91-9010565566">+91 9010565566</a> 
                        </div>
             		 	<div class="col-lg-4 col-md-6 contact supportemail" ><i class="fas fa-envelope"></i><a href="mailto:info@cleverstack.in">info@cleverstack.in</a></div>
             		 </div>
             		 </div>
             	<hr>
                 <div class="col-md-12 col-sm-12 col-xs-12 footerbotlink">
					<a href="{{ url('/about') }}" title="About Us">About Us</a>					                 
					 <a href="{{ url('/contacts') }}" title="Contact Us">Contact Us</a>
					 <a href="{{ url('/terms') }}" title="Terms of Use">Terms of Use</a>
					 <a href="{{ url('/privacy') }}" title="Privacy policy">Privacy policy</a>
                 </div>
                </div>
                 <div class=" col-lg-4 col-md-12 col-sm-12 col-xs-4 text-center">
                   <ul class="footer-socialmedia">
                        <li><a href="#" class="iconfacebook" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#" class="icontwitter" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                      
                         <li><a href="#" class="iconlinkdin" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                    </ul>
                </div>
              </div>
    </div>
</div>

</section>
<section class="footerbottom" >
	<p>&copy; 2020 CleverStack. All rights reserved.</p>
</section>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
<script src="{{ asset('home_assets/js/jquery.min.js') }}"></script> 
<!-- Include all compiled plugins (below), or include individual files as needed --> 
<script src="{{ asset('home_assets/js/popper.min.js') }}"></script>
<script src="{{ asset('home_assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript">
$(window).scroll(function () {
    var sc = $(window).scrollTop()
    if (sc > 50) {
        $(".navbar").addClass("navbar-fixed")
    } else {
        $(".navbar").removeClass("navbar-fixed")
    }
});

</script>

<script type="text/javascript">
  $(document).ready(function () {
        $('a.smoothscroll').click(function () {
            var hash = $(this).attr('href').substr($(this).attr('href').indexOf('#')); //window.location.hash; 
            if (hash) {
                hash = hash.replace('#', '');
                var offSet = 70;
                var obj = $('#s_' + hash).offset() || {top: 0};
                var targetOffset = obj.top - offSet;
                $('html,body').animate({scrollTop: targetOffset}, 800);
            }
        });
        var hash = window.location.hash;
        if (hash) {
            hash = hash.replace('#', '');
            var offSet = 70;
            var obj = $('#s_' + hash).offset() || {top: 0};
            var targetOffset = obj.top - offSet;
            $('html,body').animate({scrollTop: targetOffset}, 800);
        }
    });
 </script>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            $('.alert').hide();
        }, 20000)
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.scrollup').fadeIn();
            } else {
                $('.scrollup').fadeOut();
            }
        });

        $('.scrollup').click(function () {
            $("html, body").animate({scrollTop: 0}, 600);
            return false;
        });

    }); 

</script> 

<script type="text/javascript">
    $(document).on('mouseenter','.linkblur',function(){
        $(document).find('.main ').addClass('mainblur')
    }).on('mouseleave','.linkblur', function(){
    $(document).find('.main ').removeClass('mainblur')
});

 $(document).on('mouseenter','.linkblur',function(){
        $(document).find('.hasblur ').addClass('blur1')
    }).on('mouseleave','.linkblur', function(){
    $(document).find('.hasblur ').removeClass('blur1')
});
 
</script>

<style type="text/css">
  .zsiq_float6{    position: fixed;
    right: 0;
    bottom: 0;
    z-index: 9999;}
</style>
<script src="{{ asset('home_assets/js/owl.carousel.js') }}"></script> 
<script type="text/javascript">
$('.owl-carousel').owlCarousel({
    loop:false,
    slideBy: 6,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:false,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        },
        1200:{
            items:6
        }
    }
})
</script>
<script type="text/javascript">
	

$(document).ready(function() {     
    $('.endnode').hover(function(){     
        $('.select-module-box').addClass('showmodulebx');    
    },     
    function(){    
        $('.select-module-box').removeClass('showmodulebx');     
    });
});   


</script>	
</body>
</html>
