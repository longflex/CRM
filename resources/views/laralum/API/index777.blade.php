@extends('layouts.admin.panel')
@section('breadcrumb')
@endsection
@section('title', trans('laralum.laralum_API'))
@section('icon', "exchange")
@section('subtitle', trans('laralum.API_subtitle'))
@section('content')
  <div class="ui doubling stackable two column grid container">
<div class="col-md-12 margin_top_20">
<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#API">API</a></li>
  <li><a data-toggle="tab" href="#Security">Security</a></li>
  <li><a data-toggle="tab" href="#Webhooks">Webhooks</a></li>
</ul>

<div class="tab-content">

  <!--General-->
  <div id="API" class="tab-pane fade in active">
  
  <div class="row">
  <div class="col-md-9">
  <table class="table table-bordered table-hover">
  <thead>
  <tr class="table-head">
  <th>Name</th>
  <th>Authkey</th>
  <th width="20%">Status</th>
  <th>Generated At</th>
  </tr>
  </thead>
  <tbody>
  @foreach($api_keys as $keys)
   <tr>
  <td>{{ $keys->name }}</td>
  <td>{{ $keys->api_key }}</td>
  <td>
  @if($keys->status==1)
   <a href="#" class="pending_btn enable-btn"  disabled="disabled">Enabled</a>
  @else   
   <a href="#" id="1-{{ $keys->id }}" class="pending_btn enable-btn" onclick="changeStatus(this.id)">Enable</a> 
  @endif
  
  @if($keys->status==0)
   <a href="#" class="pending_btn enable-btn"  disabled="disabled">Disabled</a>
  @else   
   <a href="#" id="0-{{ $keys->id }}" class="pending_btn enable-btn red" onclick="changeStatus(this.id)">Disable</a> 
  @endif
 
  <input type="hidden" value="{{ $keys->id }}" id="keys_id{{ $keys->id }}" />
  </td>
  <td>{{ $keys->created_at }}</td>
  </tr>
  @endforeach
  </tbody>
  </table>
  </div>
  
  <div class="col-md-12">
  <span href="#" class="create_new_link" id="myBtn"><u>Create New</u></span>
  </div>
  
   
   <div class="col-md-12">
  <a href="{{ route('api::text-sms') }}"  class="ui teal submit button res-mb-6" target="_blank">API Documentation</a> &nbsp;-or-&nbsp;&nbsp;
  <a href="#" class="ui teal submit button black-bg res-mb-6">Integrate via Socket</a> &nbsp;-or-&nbsp;&nbsp;
  <a href="#" class="ui teal submit button blue-bg res-mb-6">Try some Add-ons</a>
  </div>
  
  
  
  </div>
  
  </div>
 <!--General-->
 
 <!--Biling-->
  <div id="Security" class="tab-pane fade">
 
 <div class="row">
 <div class="col-md-12">
 <h3 class="mb-20">API Security</h3>
 
 <div class="form-group">
 <div class="checkbox">
      <label class="api-Security"><input type="radio"> Enable</label>
      
       <label class="api-Security"><input type="radio">  Disable</label>
    </div>
 </div>
 
 <h3 class="mb-20">IPs hitting the APIs</h3>

 <div class="alert alert-warning">
 No log Exists.
</div>
 
 </div>
 </div>
 
  </div>
  <!--Biling-->
  
   <!--Webhooks-->
  <div id="Webhooks" class="tab-pane fade">
   <div class="row">
 <div class="col-md-9">
 <h3 class="mb-20">We post data (delivery report) in below URL.</h3>
 
 <div class="form-group mb-20">
 <div class="row">
 <div class="col-md-5"><input type="text" class="inp" id="" name="" value="" placeholder="http://yourdomain.com/dlr/pushUrl.php"></div>
 <div class="col-md-2 plr-5"><button type="submit" class="ui teal submit button">Save</button></div>
 </div>
 </div>
 
 <div class="alert alert-warning">
We post data on this URL as soon as we receive delivery report.
</div>

 <div class="alert alert-warning">
We get HTTP response code 200 ok when a URL is called successfully.<br />
In case of any error, the response code from your side should be other than 200 like 500 for internal error or 504 
for gateway timeout so that we can retry after a short period of time.<br />

<strong>How to set HTTP header?</strong> <br />
<a href="#">PHP: http_response_code</a> <br />
<a href="#">PHP: header</a>

</div>
 
 <div class="form-group">
 Try <a href="#">Try requestb.in</a> to test this service. <br />
 
 Get sample php <a href="#">code</a>
 </div>
 
 
 <div class="form-group">
 <button type="submit" class="ui teal submit button" id="">Data format</button>
 </div>
 
 </div>
 </div>
  </div>
 <!--Webhooks-->

</div>
</div>   
</div>

<style>
.menu-margin 
{
    background: #fff;
}

.page-content 
{
    padding-top: 0 !important;
}

.content-title
{
	padding:0 !important;
}
.loadinggif {
    background:url('{{ asset(Laralum::publicPath() .'/images/ajax-loader.gif') }}') no-repeat right center;
}

a[disabled=disabled] {
  cursor: default;
  background-color: #DDDDDD !important;
  font-weight: bold;
}
</style>


<!--Add New Authkey-->
<div id="mySchedule" class="modal1" style="display:none;">
  <!-- Modal content -->
  <div class="modal-content1">
    <div class="modal-header1">
      <span class="close">&times;</span>
      <h2>Add New Authkey</h2>
    </div>
    <div class="modal-body1">
     
     <div class="form-group">
     <input type="text" class="inp" id="authKeyName" placeholder="Auth Key Name" />
     </div>

     
     <div class="">
     <input type="submit"  id="addKey" class="ui teal submit button" value="Add" />
     </div>
     
    </div>
    
  </div>

</div>
<!--Add New Authkey-->



<script>

    function changeStatus(id){
		var status = id;
		var res = status.split("-");
		var value = res[0];
		var id = res[1];
		var keys_id = $('#keys_id'+id).val();
		
		var my_url = APP_URL+'/admin/keyStatus';
		var type = "POST"; 
		 $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			}
		})
		var formData = {
			user_status: value,
			keys_id: keys_id,
		}
		
			$.ajax({
			type: type,
			url: my_url,
			data: formData,
			dataType: 'json',
			success: function (data) {
				console.log(data);
				 if(data.status==0){
					 
					  setTimeout(function () { 
						swal({
						  title: "Success!",
						  text: "Authkey disabled successfully!",
						  type: "success",
						  confirmButtonText: "OK"
						},
						function(isConfirm){
						  if (isConfirm) {
							window.location.reload();
						  }
						}); }, 1000);
					 
				   	
				  }
				  else{
					  
					   setTimeout(function () { 
						swal({
						  title: "Success!",
						  text: "Authkey enabled successfully!",
						  type: "success",
						  confirmButtonText: "OK"
						},
						function(isConfirm){
						  if (isConfirm) {
							window.location.reload();
						  }
						}); }, 1000);
					
				  }
			},
			error: function (data) {
				console.log('Error:', data);
			}
		
		 
	  
	});
  }
	//#add key script
$("#addKey").click(function (e) {
	var my_url = APP_URL+'/admin/addKey';
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	
	if($('#authKeyName').val()==''){
	   swal('Warning!','Please enter Authkey name!','warning')
	   $("#authKeyName").focus();
       return false;	   
	}
	
	
	e.preventDefault(); 
	var formData = {
			keyName: $('#authKeyName').val(),
	}
	
	
	var type = "POST"; 
	
	console.log(formData);
	$.ajax({
		type: type,
		url: my_url,
		data: formData,
		dataType: 'json',
		success: function (data) {
			console.log(data);
           if(data.status=='success'){
			   setTimeout(function () { 
				swal({
				  title: "Success!",
				  text: "Successfully regenerated!",
				  type: "success",
				  confirmButtonText: "OK"
				},
				function(isConfirm){
				  if (isConfirm) {
					window.location.reload();
				  }
				}); }, 1000);
			   
				  			   
			    }
				 else{
					setTimeout(function () { 
				swal({
				  title: "Error!",
				  text: "Something went wrong!",
				  type: "error",
				  confirmButtonText: "OK"
				},
				function(isConfirm){
				  if (isConfirm) {
					window.location.reload();
				  }
				}); }, 1000); 			  
		    }			
		},
		error: function (data) {
			console.log('Error:', data);
		}
	});
	}); 
	


$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection
