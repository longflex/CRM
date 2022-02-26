@extends('layouts.admin.panel')
@section('breadcrumb')
<div class="ui breadcrumb">
<a class="section" href="{{ route('Laralum::groups') }}">{{  $grpname }}</a><i class="right angle icon divider"></i>
<div class="active section">{{  trans('laralum.contact_list') }}</div>	
</div>
@endsection
@section('title', trans('laralum.contact_list'))
@section('icon', "phone")
@section('subtitle', trans('laralum.contact_subtitle'))
@section('content')
<style>
.ui.five.column.table td {
    width: 0 !important;
}
</style>
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
  		<div class="ui very padded segment">
		  <div class="row">
		      <div class="col-md-12 text-right">
			       <div class="col-md-4 text-left">
				   @if(count($contact) > 0)
				   <button class="res_ex ui {{ Laralum::settings()->button_color }} button delete_all" data-url="{{ route('Laralum::delete_all_contacts') }}">Delete selected row</button>
			       @endif
				   </div>
				   <div class="col-md-8 text-right">
				   <a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')" data-toggle="modal" data-target="#AddContact" class="res_ex ui {{ Laralum::settings()->button_color }} button">
					<i class="fas fa-plus icon_m" aria-hidden="true"></i><span>ADD</span>
				   </a>
				   <a href="{{ route('Laralum::contacts_export', ['group_id' => request()->segment(4)]) }}" class="res_ex ui {{ Laralum::settings()->button_color }} button" id="Export" onclick="$('.dimmer').removeClass('dimmer')">
					<i class="fas fa-download icon_m"></i><span>{{ trans('laralum.export') }}</span>
				   </a>
				    <a href="javascript:void(0)" class="res_ex ui {{ Laralum::settings()->button_color }} button" id="ImportShow" onclick="$('.dimmer').removeClass('dimmer')">
				      <i class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span>
			        </a>
					<a href="javascript:void(0)" class="res_ex ui {{ Laralum::settings()->button_color }} button" id="FilterShow" onclick="$('.dimmer').removeClass('dimmer')">
					<i class="fas fa-filter"></i> <span>Filter</span>
				   </a>				   
			   </div>				  
			   </div>                		   
		    </div>
             <div class="filter-area" style="display: none;">
				<div class="row">
					<form class="ui form" method="GET" action="{{ route('Laralum::contacts', ['id' => request()->segment(4)]) }}">
					    <div class="col-md-12 mb-15">
							<h4><i class="fas fa-filter"></i> <span>Filter</span></h4>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<input type="text" value="{{ request()->get('contact_id') }}" placeholder="Search by contact ID." name="contact_id" class="form-control" />
							</div>
						</div>					
						<div class="col-md-6">
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" value="{{ request()->get('name') }}" placeholder="Search by name" name="name" class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" value="{{ request()->get('mobile') }}" placeholder="Search by mobile no." name="mobile" class="form-control" />
							</div>
						</div>
						</div>
						</div>																								
						<div class="col-md-3">
							<button type="submit" class="res_ex ui teal button">Filter</button>
						</div>
					</form>
				</div>
			</div>
			
			<!--import-area-->
            <div class="import-area" style="display: none;">
				<div class="row">
					<form class="ui form form-inline" method="POST" enctype="multipart/form-data"  action="{{ route('Laralum::contacts_import') }}">
						<div class="col-md-12">
							<h4 class="mb-15"><i class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span></h4>
						</div>
					   {{ csrf_field() }}
						<div class="col-md-6 col-md-offset-6 text-right">
							<div class="form-group">
							 <input type="file"	name="file" class="form-control"	/>			  								
							 <input type="hidden" value="{{ request()->segment(4) }}"	name="import_contact_group_id"	/>	
							 <input type="hidden" value="{{ $grpname }}"	name="import_contact_group_name"	/>	
							 <input type="submit" name="importSubmit" class="res_ex ui teal button ml-5" value="Import">							 
							</div>																
								<div class="mb-15 text-right">
								<a href="{{ url('files/sample-csv-contacts.csv') }}" download >Download Sample File</a>			
						    </div>
						</div>																																																					
					</form>
				</div>
			</div>			  		  
          <!--import-area-->
          @if(count($contact) > 0)		  
  			<table class="ui five column table">
  			  <thead>
  			    <tr>
				  <th width="6%"><input type="checkbox" id="master"></th>
				  <th width="6%">{{ trans('laralum.contact_id') }}</th>
				  <th>{{ trans('laralum.contact_name') }}</th>
				  <th>{{ trans('laralum.contact_mobile') }}</th>                 
                  <th>{{ trans('laralum.options') }}</th>                
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($contact as $key => $con)
					<tr id="tr_{{$con->id}}">
                        <td align="center">
                          <div class="text">
                            <input type="checkbox" class="sub_chk" data-id="{{$con->id}}">
                          </div>
                        </td>					
						<td align="center">
                          <div class="text">
                            {{ $key+1 }}
                          </div>
                        </td>
                        <td align="center">
                           <div class="text">
                              {{ $con->name }}   
                           </div>
                        </td>
                        <td align="center">
                           <div class="text">
						   {{ $con->mobile }}                           
                           </div>
                        </td>
                        <td align="center">
                          <div class="text">
                             <a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')" id="editContact" class="btn btn-sm btn-primary btn-table" data-toggle="modal" data-target="#EditContact" data-id="{{$con->id}}" data-name="{{$con->name}}" data-cid="{{$con->contact_id}}" data-mobile="{{$con->mobile}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
			                 <a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')" id="deleteContact" data-id="{{$con->id}}" data-type="timeslot" class="btn btn-sm btn-primary btn-table btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                           </div>
                        </td>						                       
					</tr>
				@endforeach
  			  </tbody>
  			</table>
			{{ $contact->render() }}
			@else
			<div class="ui negative icon message">
				<i class="frown icon"></i>
				<div class="content">
					<div class="header">
						{{ trans('laralum.missing_title') }}
					</div>
					<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "contacts"]) }}</p>
				</div>
			</div>
            @endif
  		
  		</div>
		
        <br>
  	</div>
  </div>
 <!-- add-group-popup-->
<div id="AddContact" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Contact</h4>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" id="save_contact_form" action="javascript:void(0)">
		    {{ csrf_field() }}
             <input type="hidden" id="group_id" name="group_id" value="{{ request()->segment(4) }}" />			
			<div class="form-group">
				<input placeholder="Enter contact name" class="form-control" id="contact_name" name="contact_name" />
			</div>
			<div class="form-group">
				<input placeholder="Enter contact no." class="form-control" id="contact_no" name="contact_no" />
				<small id="show_contact_no_error" style="color:#FF0000;display:none;">Please enter contact number</small>
			</div>
			<div class="text-right">
			<button type="submit" id="contactForm" class="ui teal submit button"><span id="hide_contact_save_text">SAVE</span>&nbsp;
			<span class="contactForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
			</button>
			</div>
		</form>
      </div>     
    </div>
  </div>
</div>
<!-- add-group-popup -->
<!-- edit-contact-popup-->
<div id="EditContact" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Contact</h4>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" id="edit_contact_form" action="javascript:void(0)">
		    {{ csrf_field() }}
			<input type="hidden" id="edit_group_id" name="edit_group_id" value="{{ request()->segment(4) }}" />
             <input type="hidden" id="contact_id" name="contact_id" />			
			<div class="form-group">
				<input placeholder="Enter contact name" class="form-control" id="edit_contact_name" name="edit_contact_name" />
			</div>
			<div class="form-group">
				<input placeholder="Enter contact no." class="form-control" id="edit_contact_no" name="edit_contact_no" />
				<small id="show_edit_contact_no_error" style="color:#FF0000;display:none;">Please enter contact number</small>
			</div>
			<div class="text-right">
			<button type="submit" id="contactEditButton" class="ui teal submit button"><span id="hide_contact_update_text">UPDATE</span>&nbsp;
			<span class="contactEditButton" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
			</button>
			</div>
		</form>
      </div>     
    </div>
  </div>
</div>
<!-- Edit-group-popup -->
@endsection
@section('js')
<script>
$("#FilterShow").click(function(){
  $(".filter-area").slideToggle();
});
$("#ImportShow").click(function(){
  $(".import-area").slideToggle();
});
</script>
<script src="{{ asset(Laralum::publicPath() .'/js/groups-script.js') }}"></script>
<script>
$(document).on('click','#editContact',function(e) {
	$('#contact_id').val($(this).attr('data-id'))
	$('#edit_contact_id').val($(this).attr('data-cid'))
	$('#edit_contact_name').val($(this).attr('data-name'))
	$('#edit_contact_no').val($(this).attr('data-mobile'))
});
//delete Contact
$(document).on('click','#deleteContact',function(e) {
    e.preventDefault();
    var id=$(this).attr('data-id');
    var dtype=$(this).attr('data-type');
	var url = APP_URL+'/sms/admin/groups/contacts/delete_contact';	
	var type = "POST"; 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	var formData = {
		  id: id,
	}
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this data!",
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
				text: 'The contact has been deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: type,
					url: url,
					data: formData,
					dataType: 'json',
					success: function (data) {
						location.reload();
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			});
			
		} else {
			swal("Cancelled", "Your data is safe :)", "error");
		}
	});
	
});

//delete all Contact
$(document).on('click','.delete_all',function(e) {
    e.preventDefault();
   var allVals = [];  
	$(".sub_chk:checked").each(function() {  
		allVals.push($(this).attr('data-id'));
	}); 
    if(allVals.length <=0)  
	{
        swal("Warning!", "Please select row.", "warning");
        return false;		
	}	
	var url = APP_URL+'/sms/admin/groups/contacts/delete_all_contact';	
	var type = "POST"; 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	var formData = {
		  ids: allVals.join(","), 
	}
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this data!",
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
				text: 'The contacts has been deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: type,
					url: url,
					data: formData,
					dataType: 'json',
					success: function (data) {
						$(".sub_chk:checked").each(function() {  
							$(this).parents("tr").remove();
						});
						$('input[type="checkbox"]').prop('checked', false);
						location.reload();
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			   $.each(allVals, function( index, value ) {
			        $('table tr').filter("[data-row-id='" + value + "']").remove();
		       });
			});
			
		} else {
			swal("Cancelled", "Your data is safe :)", "error");
		}
	});
	
});
</script>
<script type="text/javascript">
$(document).ready(function () {
$('#master').on('click', function(e) {
	 if($(this).is(':checked',true))  
	 {
		$(".sub_chk").prop('checked', true);  
	 }else{  
		$(".sub_chk").prop('checked',false);  
	 }  
    });
});
</script>
@endsection