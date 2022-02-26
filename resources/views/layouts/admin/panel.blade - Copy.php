<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>@yield('title') - {{ Laralum::settings()->website_title }}</title>
	<meta name="description" content="Eventnuts -administration panel">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="_token" content="{{ csrf_token() }}">
	<meta name="author" content="Eventnuts -administration panel">
	<link rel='shortcut icon' href="{{ asset(Laralum::publicPath() . '/favicon/laralum.jpeg') }}" type='image/x-icon'/ >
    
	
	{!! Laralum::includeAssets('laralum_header') !!}

	{!! Laralum::includeAssets('charts') !!}

  @yield('css')
   <link href="{{ asset(Laralum::publicPath() .'/css/font-awesome.min.css') }}" type="text/css" rel="stylesheet">
    
    <link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    
      <link href="{{ asset(Laralum::publicPath() .'/data_table/dataTables.bootstrap.min.css') }}" type="text/css" rel="stylesheet">
	  <link href="{{ asset(Laralum::publicPath() .'/data_table/data_table_pagination.css') }}" type="text/css" rel="stylesheet" />
	  <link href="{{ asset(Laralum::publicPath() .'/css/responsive-table.css') }}" type="text/css" rel="stylesheet" />
      <link href="{{ asset(Laralum::publicPath() .'/css/custom.css') }}" type="text/css" rel="stylesheet" />
       <link href="{{ asset(Laralum::publicPath() .'/css/responsive-tabs.css') }}" type="text/css" rel="stylesheet" />
       <link href="{{ asset(Laralum::publicPath() .'/menu/styles.css') }}" type="text/css" rel="stylesheet" />
      <script src="https://use.fontawesome.com/b8911f426f.js"></script>
      
      
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

  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  
  <style>

  </style>
  
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

	
	

	<div class="ui sidebar left-menu">
		<header>
			<div class="ui left fixed vertical menu mCustomScrollbar" id="vertical-menu" data-mcs-theme="dark">
            <div class="" >
				<div id="vertical-menu-height" class="accordion">
					<a href="#" class="item logo-box"><div class="logo-container"></div></a>
					 @if(Laralum::loggedInUser()->hasPermission('laralum.groups.access'))
                            <!--add-group-area-->
                            <div class="add-group-area">
							
                           <div class="item" id="add-g-btn">
					    <div class="header link hide_m_t"> 
                        <i class="fa fa-user-plus" aria-hidden="true"></i>  <span>Add Group</span></div>    
						</div>
                            <form id="frmGroups" name="frmGroups" novalidate="">           
								 <!--add-group-text-box-->
								<div class="add-group-text-box" id="add-g-btn-txt" style="display:none;">
								
								<input type="text" id="group_name" name="group_name" class="add-group-text-box-inp" placeholder="Group Name" autocomplete="off"/>
								 <input type="hidden" id="state" name="state" value="add" autocomplete="off"/>
								
								<div class="add-group-text-box-txt">
								<span>Press Enter</span><p id="add-g-close-btn"><i class="fa fa-times" aria-hidden="true"></i></p>
								</div>
								
								</div>
								<!--add-group-text-box-->
                           </form>
                            <div id="remove" class="more-limit">
                           
							@foreach(Laralum::GroupList() as $group)
							 <div id="groupslist">
							 <div id="groupList{{ $group->id }}">
                            <!--add-group-member-list-1-->
							 <div id="{{ $group->id }}" class="grpEdit">
                            <div class="add-group-member-list">
                            <input type="text" id="editGroup_{{ $group->id }}" class="add-group-member-list-inp" value="{{ $group->name }}" />
							<input type="hidden" class="add-group-member-list-inp" id="groupid_{{ $group->id }}" value="{{ $group->id }}" autocomplete="off"/>
							 <input type="hidden" id="states" name="state" value="edit" autocomplete="off"/>
                             <span class="on-hover-btn">{{ $group->Contactcount }}
							 <div class="on-hover-delete">
							 <a href="{{ route('Laralum::contacts', ['id' => $group->id]) }}" data-toggle="tooltip" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
							 <button class="deleteGroup" value="{{ $group->id }}" data-toggle="tooltip" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
							  </div>
							 </span>
                            </div>
							
                            <!--add-group-member-list-1-->
							 </div>
							 </div>
							 </div>
							@endforeach
                            </div>
                            <?php if(count(Laralum::GroupList())>4) { ?>
                            <div class="more-dis"><span href="#" id="dis-more-unl"><i class="fa fa-plus" aria-hidden="true"></i> More</span></div>
                            <div class="less-dis" style="display:none;"><span href="#" id="dis-less-unl"><i class="fa fa-minus" aria-hidden="true"></i>&nbsp; Less</span></div>
                            <?php } ?>                                  
                            </div>
                            <!--add-group-area-->
                            @endif
                       <!--menu manager-->  
						 
						  <!--01-menu-->
						   @if(Laralum::loggedInUser()->hasPermission('laralum.sendsms.access'))
							<div class="item">
                            <a href="{{ route('Laralum::sendsms') }}" class="color_black">
							  <div class="header link hide_m_t">
								 <i class="fa fa-comment-o" aria-hidden="true"></i> 
								 <span>{{ trans('laralum.sendsms_manager') }}</span>
							 </div>
                              </a>
						  </div>
						 @endif
                      <!--01-menu-->
						 
					<!--02-menu-->
					 @if(Laralum::loggedInUser()->hasPermission('laralum.reports.access'))
						<div class="item">
                          <a href="{{ route('Laralum::reports') }}" class="color_black">
						  <div class="header link hide_m_t">
						     <i class="fa fa-file-text" aria-hidden="true"></i>
						     <span>{{ trans('laralum.report_manager') }}</span>
						 </div>
                         </a>
					  </div>
                     @endif
                     <!--02-menu-->
                            
					<!--03-menu-->
					@if(Laralum::loggedInUser()->hasPermission('laralum.users.access'))
					     <div class="item">
                            <a href="{{ route('Laralum::users') }}" class="color_black">
							  <div class="header link hide_m_t">
								 <i class="fa fa-user-circle-o" aria-hidden="true"></i> 
								 <span>{{ trans('laralum.user_manager') }}</span>
							 </div>
                              </a>
						  </div>
					 @endif
					<!--03-menu-->
                       
                      
                    <!--04-menu-->
					 @if(Laralum::loggedInUser()->hasPermission('laralum.senderid.access'))
						<div class="item">
                          <a href="{{ route('Laralum::senderid') }}" class="color_black">
						  <div class="header link hide_m_t">
						     <i class="fa fa-share-square" aria-hidden="true"></i> 
						     <span>{{ trans('laralum.sender_manager') }}</span>
						 </div>
                         </a>
					  </div>
                     @endif
                      <!--04-menu-->
					   
                    <!--05-menu-->
					@if(Laralum::loggedInUser()->hasPermission('laralum.settings.access'))
                      <div class="item">
					<div class="header link hide_m_t"> <i class="fa fa-cogs" aria-hidden="true"></i>  
					 <span>{{ trans('laralum.system_manager') }}</span> <b class="fa fa-chevron-down"></b></div>
                            <div class="menu submenu1">
							        @if(Laralum::loggedInUser()->hasPermission('laralum.roles.access'))
							        <a href="{{ route('Laralum::roles') }}" class="item">{{ trans('laralum.role_list') }}</a>
								    @endif
									@if(Laralum::loggedInUser()->hasPermission('laralum.permissions.access'))
									<a href="{{ route('Laralum::permissions') }}" class="item">{{ trans('laralum.permission_list') }}</a>
								    @endif
									@if(Laralum::loggedInUser()->hasPermission('laralum.getways.access'))
									<a href="{{ route('Laralum::getway') }}" class="item">{{ trans('laralum.getway_manager') }}</a>
								    @endif
									@if(Laralum::loggedInUser()->hasPermission('laralum.bank.access'))
									<a href="{{ route('Laralum::bank') }}" class="item">{{ trans('laralum.bank_details') }}</a>
								    @endif
									@if( Laralum::loggedInUser()->hasPermission('laralum.users.access') && Laralum::loggedInUser()->hasPermission('laralum.users.settings'))
								     <a href="{{ route('Laralum::users_settings') }}" class="item">{{ trans('laralum.users_settings') }}</a>
							        @endif
									<a href="{{ route('Laralum::settings') }}" class="item">{{ trans('laralum.general_settings') }}</a>
							</div>
						</div>
						@endif
                      <!--05-menu-->  
					   <!--05-menu-->
					
						<div class="item">
                          <a href="{{ route('Laralum::API') }}" class="color_black">
						  <div class="header link hide_m_t">
						    <i class="fa fa-folder-o" aria-hidden="true"></i>
						     <span>{{ trans('laralum.laralum_API') }}</span>
						 </div>
                         </a>
					  </div>
                    
                      <!--05-menu-->
					  <!--06-menu-->
					 @if(Laralum::loggedInUser()->hasPermission('laralum.ivr.access'))
						<div class="item">
                        <a href="{{ route('Laralum::ivr') }}" class="color_black">
						  <div class="header link hide_m_t">
						     <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
						     <span>{{ trans('laralum.ivr_manager') }}</span>
						 </div>
                         </a>
					  </div>
                     @endif
                     <!--06-menu-->
					 
					  <!--07-menu-->
					 @if(Laralum::loggedInUser()->hasPermission('laralum.resellerSetting.access'))
						<div class="item">
					   <a href="{{ route('Laralum::reSetting') }}" class="color_black">
						  <div class="header link hide_m_t">
						     <i class="fa fa-cog" aria-hidden="true"></i>
						     <span>{{ trans('laralum.reseller_settings') }}</span>
						 </div>
						 </a>
					  </div>
                     @endif
                     <!--07-menu-->
					 
					   <!--08-menu-->
					 @if(Laralum::loggedInUser()->hasPermission('laralum.myWebsite.access'))
						<div class="item">
					    <a href="{{ route('Laralum::mywebsite') }}" class="color_black">
						  <div class="header link hide_m_t">
						     <i class="fa fa-window-maximize" aria-hidden="true"></i>
						     <span>{{ trans('laralum.my_website') }}</span>
						 </div>
					   </a>
					  </div>
                     @endif
                     <!--08-menu-->
					</div>

				</div>
                </div>
		</header>
	</div>




	<div class="ui top fixed menu"  id="menu-div">
    
    	<!--logo-->
		<a href="{{ route('Laralum::dashboard') }}" >
        <div class="logo-container">
		<img class="logo-image ui fluid small image" src="@if(Laralum::settings()->logo) {{ Laralum::settings()->logo }} @else {{ Laralum::laralumLogo() }} @endif">
		</div>
		</a>
        <!--logo-->
    
		<div class="item" id="menu">
			<div class="ui secondary button res_menu_btn"><i class="bars icon"></i> {{ trans('laralum.menu') }}</div>
		</div>
		
		<div id='cssmenu'>
			<ul>
				<li class="active">
					<a href="{{ route('Laralum::dashboard') }}"><i class="fa fa-tachometer"></i>Dashboard</a>
				</li>
				<li class="">
					<a href="#" class="nav-link"><i class="fa fa-id-badge"></i>Contacts</a>
				</li>
				<li class="">
					<a href="#" class="nav-link"><i class="fa fa-users" aria-hidden="true"></i>Clients</a>
				</li>
				<li class="">
					<a href="#" class="nav-link"><i class="fa fa-cog" aria-hidden="true"></i>Manage</a>
				</li>
				<!--li class="dropdown ">
				<a href="javascript:void(0);" class="nav-link"><i class="fas fa-cog" aria-hidden="true"></i>Manage</a>
				<ul class="dropdown-menu">
				<li><a href="http://localhost/cleverstack/public/admin/manage/roles" class="nav-link"><i class="fa-fw fas fa-briefcase nav-icon"></i>Roles</a></li>
				<li><a href="http://localhost/cleverstack/public/admin/manage/permissions" class="nav-link"><i class="fa-fw fas fa-unlock-alt nav-icon"></i>Permissions</a></li>

				</ul>
				</li-->
			</ul>
			</div>

		
		<div class="right menu">
		    @if( Session::has('orig_user') )
		    <div class="item">
		      <div class="ui secondary top labeled icon left pointing  button responsive-button">
			  <i class="icon fa fa-mail-reply-all"></i>
				<a href="{{ route('Laralum::switch_stop') }}" class="text responsive-text w_txt">Switch Back</a>
				</div>
			</div>
			@endif
			<div class="item">
				<div class="ui secondary top labeled icon left pointing dropdown button responsive-button">
				  <i class="globe icon"></i>
				  <span class="text responsive-text"> {{ trans('laralum.language') }}</span>
				  <div class="menu">
					@foreach(Laralum::locales() as $locale => $locale_info)
						@if($locale_info['enabled'])
							<a href="{{ route('Laralum::locale', ['locale' => $locale]) }}" class="item">
								@if($locale_info['type'] == 'image')
									<img class="ui image"  height="11" src="{{ $locale_info['type_data'] }}">
								@elseif($locale_info['type'] == 'flag')
									<i class="{{ $locale_info['type_data'] }} flag"></i>
								@endif
								{{ $locale_info['name'] }}
							</a>
						@endif
					@endforeach
				  </div>
				</div>
			</div>
			<div class="item">
				<div class="ui {{ Laralum::settings()->button_color }} top labeled icon left pointing dropdown button responsive-button">
				  <i class="user icon"></i>
				  <span class="text responsive-text">{{ Auth::user()->name }}</span>
				  <div class="menu">
				  	<a href="{{ route('Laralum::profile') }}" class="item">
						{{ trans('laralum.profile') }}
  					</a>
					<a href="{{ route('Laralum::transaction') }}" class="item">
						{{ trans('laralum.transaction_list') }}
  					</a>
					
					<a href="{{ route('Laralum::receipt') }}" class="item">
						{{ trans('laralum.receipt_request') }}
  					</a>
					
					<a href="{{ url('/') }}" class="item" target="_blank" onclick="$('.dimmer').removeClass('dimmer')">
						{{ trans('laralum.visit_site') }}
  					</a>
				  	<a href="{{ url('/logout') }}" onClick="event.preventDefault();document.getElementById('logout-form').submit();" class="item">
						{{ trans('laralum.logout') }}
  					</a>
				  </div>
				</div>
			</div>
		</div>
	</div>




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
	 var url = "{{ url('admin/groupAction') }}";
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
	var my_url = "{{ url('admin/groupDeleteAction') }}";
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
        <script src="{{ asset(Laralum::publicPath() .'/menu/script.js') }}" type="text/javascript"></script>
		
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
</body>
</html>
