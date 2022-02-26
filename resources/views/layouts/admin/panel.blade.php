<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>@yield('title') - {{ Laralum::settings()->website_title }}</title>
	<meta name="description" content="CleverStack - administration panel">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="_token" content="{{ csrf_token() }}">
	<meta name="author" content="CleverStack - administration panel">
	<link href="{{ asset('home_assets/images/favicon.png') }}" rel="shortcut icon" >
	{!! Laralum::includeAssets('laralum_header') !!}
	{!! Laralum::includeAssets('charts') !!}
    @yield('css') 
        <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />      
      <link href="{{ asset(Laralum::publicPath() .'/font-awesome/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet" />        
      <link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">    
      <link href="{{ asset(Laralum::publicPath() .'/data_table/dataTables.bootstrap.min.css') }}" type="text/css" rel="stylesheet">
	  <link href="{{ asset(Laralum::publicPath() .'/data_table/data_table_pagination.css') }}" type="text/css" rel="stylesheet" />
	  <link href="{{ asset(Laralum::publicPath() .'/css/responsive-table.css') }}" type="text/css" rel="stylesheet" />
      <link href="{{ asset(Laralum::publicPath() .'/css/custom.css') }}" type="text/css" rel="stylesheet" />    
	  <link href="{{ asset(Laralum::publicPath() .'/css/responsive-tabs.css') }}" type="text/css" rel="stylesheet" />
      
       <!--custom-scrolbar-->
      <link rel="stylesheet" href="{{ asset(Laralum::publicPath() .'/css/jquery.mCustomScrollbar.css') }}" />
      <script src="{{ asset(Laralum::publicPath() .'/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
      <script>
    	(function($){
        $(window).on("load",function(){
            $(".content").mCustomScrollbar();
        });
    	})(jQuery);
		</script>
		<!--custom-scrollnar-->
		
		<!--datepicker-->
		  <link rel="stylesheet" href="{{ asset(Laralum::publicPath() .'/css/jquery-ui.css') }}" />
          <script src="{{ asset(Laralum::publicPath() .'/js/jquery-ui.js') }}"></script>
		  <script>
		  $( function() {
			$( "#datepicker" ).datepicker();
		  } );
		  </script>
		<!--datepicker-->
	
        <!--tabs-->
     <script src="{{ asset(Laralum::publicPath() .'/js/tabscroll.js') }}"></script>
        <!--tabs-->
  		
 <script>
  $( function() {
    $( document ).tooltip();
  } );
  </script>

</head>
<body>
 <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
		{{ csrf_field() }}
</form>
<div class="ui inverted dimmer" id="customID"><div class="ui text loader">Loading</div></div>
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
	  <img class="logo-image ui fluid small image" src="@if(Laralum::settings()->logo) {{ Laralum::settings()->logo }} @else {{ Laralum::laralumLogo() }} @endif"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
		@if(Laralum::hasPermission('laralum.sms.dashboard'))
	   <li class="{{ request()->is('sms/admin') ? 'active' : '' }}">
			<a href="{{ route('Laralum::dashboard') }}"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
		</li>
		@endif
		@if(Laralum::hasPermission('laralum.sendsms.access'))
		<li class="{{ request()->is('sms/admin/sendsms') ? 'active' : '' }}">
			<a href="{{ route('Laralum::sendsms') }}" class="nav-link"><i class="fas fa-comment-alt"></i>{{ trans('laralum.sendsms_manager') }}</a>
		</li>
		@endif
		@if(Laralum::hasPermission('laralum.reports.access'))
		<li class="{{ request()->is('sms/admin/reports') ? 'active' : '' }}">
			<a href="{{ route('Laralum::reports') }}" class="nav-link"><i class="fas fa-chart-bar"></i>{{ trans('laralum.report_manager') }}</a>
		</li>
		@endif				
		
		@if(Laralum::hasPermission('laralum.senderid.access'))
		<li class="{{ request()->is('sms/admin/senderid') || request()->is('sms/admin/senderid*') ? 'active' : '' }}">
			<a href="{{ route('Laralum::senderid') }}" class="nav-link"><i class="fa fa-share-square" aria-hidden="true"></i>{{ trans('laralum.sender_manager') }}</a>
		</li>
		@endif
		@if(Laralum::hasPermission('laralum.groups.access'))
		<li class="{{ request()->is('sms/admin/groups') || request()->is('sms/admin/groups*') ? 'active' : '' }}">
			<a href="{{ route('Laralum::groups') }}" class="nav-link"><i class="fas fa-address-book"></i>{{ trans('laralum.contact_manager') }}</a>
		</li>
		@endif				
      </ul>
      <ul class="nav navbar-nav navbar-right">
		<li class="dropdown">
          <a class="dropdown-toggle user-arrow" data-toggle="dropdown" href="javascript:void(0)" onclick="$('.dimmer').removeClass('dimmer')">
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
			<li><a href="{{ url('/') }}" target="_blank" onclick="$('.dimmer').removeClass('dimmer')">{{ trans('laralum.visit_site') }}</a></li>
			@if(Laralum::loggedInUser()->su)
            <li><a href="{{ route('console::manage_module') }}">Manage</a></li>	
            @endif		
			<li><a href="{{ url('/logout') }}" onClick="event.preventDefault();document.getElementById('logout-form').submit();">
				{{ trans('laralum.logout') }}
  			</a>
			</li>
			
          </ul>
          {{-- <ul class="dropdown-menu">				  	
			<li><a href="{{ url('/logout') }}" onClick="event.preventDefault();document.getElementById('logout-form').submit();">
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
				<div class="page-footer">
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
							
								<a class="ui tiny header right floated" href='http://technodreamsit.com/' target="_blank">&copy; Copyright TechnoDreams </a>
								
							</div>
						</div>
					</div>
				</div>
		</div>
	</div>


	{!! Laralum::includeAssets('laralum_bottom') !!}

	@yield('js')


	 <script src="{{ asset(Laralum::publicPath() .'/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>	
    <script src="{{ asset(Laralum::publicPath() .'/data_table/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset(Laralum::publicPath() .'/data_table/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
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
$('#frmGroups').on('submit',function(e){
	 var url = "{{ url('sms/admin/groupAction') }}";
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	e.preventDefault(); 
	var formData = {
		group_name: $('#group_name').val(),
		
	}
	//used to determine the http verb to use [add=POST], [update=PUT]
	var state = $('#state').val();
	var type = "POST"; 
	var my_url = url;
	
	console.log(formData);
	$.ajax({
		type: type,
		url: my_url,
		data: formData,
		dataType: 'json',
		success: function (data) {
			swal('Success!','The group has been created!','success')
			console.log(data);
			
			   var groupid = data.id;
			   
			   var urls = "<?php echo url('/admin/groups/"+groupid+"/contacts')?>";

				$('#groupslist').append("<div id='groupList"+groupid+"'><div id='"+groupid+"' class='grpEdit'><div class='add-group-member-list'><input type='text' id='editGroup_"+groupid+"' class='add-group-member-list-inp' value='" + data.group_name + "' /><span class='on-hover-btn'>0 <div class='on-hover-delete'><a href='"+urls+"'><i class='fa fa-eye' aria-hidden='true'></i></a><button class='deleteGroup' value='"+groupid+"'><i class='fa fa-trash-o' aria-hidden='true'></i></button> </div></span></div></div></div>" );
			
				$("#add-g-btn").show();
				$("#add-g-btn-txt").hide();
			
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
	}); 

                           
//Edit group script
 $(".grpEdit").click(function(e){
	
	}).change(function(e)
    {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})	
	e.preventDefault(); 
	var url = "{{ url('admin/groupEditAction') }}";
	var ID =$(this).attr('id');
	var grpname = $("#editGroup_"+ID).val();
	var formData = {
		group_name: grpname,
		group_id: ID,
	}
	
	//used to determine the http verb to use [add=POST], [update=PUT]
	
	var type = "POST"; 
	var my_url = url;
	
	console.log(formData);
	$.ajax({
		type: type,
		url: my_url,
		data: formData,
		dataType: 'json',
		success: function (data) {
			console.log(data);
			 if(data){
			  swal('Success!','The group has been edited!','success')	
			  }
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
	}); 

//delete product and remove it from list
$(document).on('click','.deleteGroup',function(){
	var my_url = "{{ url('sms/admin/groupDeleteAction') }}";
	var urldashboard = "{{ url('admin') }}";
	var group_id = $(this).val();
	var type = "POST"; 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	var formData = {
		group_id: group_id,
	}
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this group!",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#DD6B55',
		confirmButtonText: 'Yes, I am sure!',
		cancelButtonText: "No, cancel it!",
		closeOnConfirm: false,
		closeOnCancel: false
	},
	function(isConfirm) {
		if (isConfirm) {
			swal({
				title: 'Confirmed!',
				text: 'Group is successfully deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: type,
					url: my_url,
					data: formData,
					dataType: 'json',
					success: function (data) {
						console.log(data);
						$("#groupList" + group_id).remove();
						
					    window.location.href = urldashboard;
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			});
			
		} else {
			swal("Cancelled", "Your group is safe :)", "error");
		}
	});
	
});
                           
</script>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>


	
		
        <!--new-time-picker-->
        <link href="{{ asset(Laralum::publicPath() .'/time-picker/bootstrap-material-datetimepicker.css') }}" type="text/css" rel="stylesheet">
        <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
        <script src="{{ asset(Laralum::publicPath() .'/time-picker/bootstrap-material-datetimepicker.js') }}" type="text/javascript"></script>
       
		
        <script type="text/javascript">
		$(document).ready(function()
		{
			$('#time').bootstrapMaterialDatePicker
			({
				date: false,
				shortTime: false,
				format: 'HH:mm'
			});
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
$(document).ready(function(){

$("#Transactional").click(function(){
$("#Transactionaldiv").show();
$("#Promotionaldiv").hide();
});

});
</script>

<script>
$(document).ready(function(){

$("#Promotional").click(function(){
$("#Promotionaldiv").show();
$("#Transactionaldiv").hide();
});

});
</script>

<script>
$("#openID").click(function(){
    $("#promotional1").toggle();
});
</script>

<script>
$("#openID1").click(function(){
    $("#trans-f-div").toggle();
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('input[type="checkbox"]').click(function(){
        var inputValue = $(this).attr("value");
        $("." + inputValue).toggle();
    });
});
</script>

<!--new--show-hide-->
<script>
$(document).ready(function(){

$("#ShowsmsTemplet").click(function(){
$("#smsTempletdiv").show();
$("#groupCampaigndiv").hide();
});

});
</script>

<script>
$(document).ready(function(){

$("#ShowgroupCampaign").click(function(){
$("#smsTempletdiv").hide();
$("#groupCampaigndiv").show();
});

});
</script>


<script>
$(document).ready(function(){

$("#ShowsmsTemplet1").click(function(){
$("#smsTempletdiv").show();
$("#groupCampaigndiv").hide();
});

});
</script>

<script>
$(document).ready(function(){

$("#ShowgroupCampaign1").click(function(){
$("#smsTempletdiv").hide();
$("#groupCampaigndiv").show();
});

});
</script>
<!--new-show-hide-->
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
} );</script>




<!--custom-modal-->
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
<!--custom-modal-->
<!--fancybox-->
<script src="{{ asset(Laralum::publicPath() .'/fancy-lightbox/jquery.fancybox.js') }}"></script>
<link rel="stylesheet" href="{{ asset(Laralum::publicPath() .'/fancy-lightbox/jquery.fancybox.css') }}" />
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
<!--fancybox-->
<script>
 $(function() {
	$(window).on("navigate", function (event, data) {
		var direction = data.state.direction;
		alert(direction);
		if (direction == 'back') {
			 $('.dimmer').removeClass('dimmer');
		}
	});
)};
</script>
</body>
</html>
