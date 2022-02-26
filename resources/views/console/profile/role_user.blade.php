<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="_token" content="{{ csrf_token() }}">
	<link href="{{ asset(Laralum::publicPath() .'/font-awesome/css/font-awesome.min.css') }}" type="text/css"
		rel="stylesheet" />
	<link href="{{ asset(Laralum::publicPath() .'/bootstrap/css/bootstrap.min.css') }}" type="text/css"
		rel="stylesheet">
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

		.btn-primary {
			background: #000068;
			border-color: #000068;
			font-size: 16px;
		}

		.btn-primary:hover {
			background: #EC1228;
			border-color: #EC1228;
		}

		.mb-15 {
			margin-bottom: 15px !important;
		}

		.heading {
			border-bottom: 1px #26476c solid;
			margin: 20px 0 25px 0 !important;
			padding-bottom: 12px;
			color: #26476;
		}

		.fancybox-close-small {
			right: 15px !important;
			top: 0 !important;
			color: #26476c !important;
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="column">
			<table class="ui table">
				<thead>
					<tr>
						<th>{{ trans('laralum.name') }}</th>
						<th>Role</th>
					</tr>
				</thead>
				<tbody>
					@foreach($staff as $staff)
					<tr>
						<td>
							<div class="text" >
								{{ $staff->name }}
							</div>
						</td>
						<td>
							<div class="text" >
								{{ $staff->Role }}
							</div>
						</td>
						
					</tr>
					@endforeach
				</tbody>
			</table>
			<br>
		</div>
	</div>
	<script type="text/javascript">
		var APP_URL = {!! json_encode(url('/')) !!};	
	</script>
	<script src="{{ asset(Laralum::publicPath() .'/js/jquery-3.0.0.min.js') }}"></script>
	<script>
		//Department form script	
	$('#staff_edit_form').submit(function(e) {
		e.preventDefault();		
		var staff_name = $('#staff_name').val();
		var staff_email = $('#staff_email').val();
		var staff_phone = $('#staff_phone').val();
		var staff_branch = $('#staff_branch').val();
		var staff_role = $('#staff_role').val();
		var staff_department = $('#staff_department').val();
				
		if(staff_name=='' || staff_email=='' || staff_phone=='' || staff_branch=='' || staff_department==''|| staff_role==''){
		  $('#staff_error_text').show();
		  return false;
		}	
		
		var type = "POST"; 
		 $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		var formData = new FormData(this); 
		var my_url = APP_URL+'/console/manage/updateStaffData';
		var type = "POST";	
		$("#hideeditstafftext").css('display','none');
	    $(".editStaffForm").css('display','inline-block');
		$.ajax({
			type: type,
			url: my_url,
			data: formData,
			processData: false,
            contentType: false,
			dataType: 'json',
			success: function (data) {
				$(".editStaffForm").css('display','none');
				$("#hideeditstafftext").css('display','inline-block');										    				
                swal({ title: "Success!", text: "Staff data updated successfully!", type: "success" }, function(){ location.reload(); });				
			},
			error: function (data) {				
				swal('Error!',data,'error')
			}
		});
		 
	});
	
//Department form script	
	$('#ivr_permission_form').submit(function(e) {
		e.preventDefault();		
		var ext_no = $('#ext_no').val();
		
		if(ext_no==''){
			swal('Warning!','Please enter extension number for the staff (usually between 11 to 99, should be a number not assigned as an extension to another User)','warning')
			return false;
		}				
		
		var type = "POST"; 
		 $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		var formData = new FormData(this); 
		var my_url = APP_URL+'/console/manage/callingAccess';
		var type = "POST";	
		$("#ivrAccessText").css('display','none');
	    $(".ivrAccess").css('display','inline-block');
		$.ajax({
			type: type,
			url: my_url,
			data: formData,
			processData: false,
            contentType: false,
			dataType: 'json',
			success: function (data) {				
               if(data.status=='success'){				   
					$(".ivrAccess").css('display','none');
					$("#ivrAccessText").css('display','inline-block');
					swal({ title: "Success!", text: data.message, type: "success" }, function(){ location.reload(); });
					
				}else if(data.status=='error'){					
					$(".ivrAccess").css('display','none');
					$("#ivrAccessText").css('display','inline-block');		
                	swal({ title: "Error!", text: data.message, type: "error" }, function(){ location.reload(); });	
				}else{
				   swal({ title: "Error!", text: "Something went wrong, please try again!", type: "error" }, function(){ location.reload(); });	
					
				}					
			},
			error: function (data) {				
				swal('Error!',data,'error')
			}
		});
		 
	});
		
	</script>
	<script>
		$(function() {
	$('#ext_div').hide();
    $('#ivr_access').change(function(){
        if($('#ivr_access').val() == 1) {
            $('#ext_div').show(); 
        } else {
            $('#ext_div').hide(); 
        } 
    });
});	
	</script>
	<script>
		$(".fancybox").fancybox({
	onClosed: function () { 
		parent.location.reload(false);
	}
});
	</script>
</body>

</html>