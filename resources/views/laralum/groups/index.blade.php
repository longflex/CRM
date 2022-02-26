@extends('layouts.admin.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.group_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.group_title'))
@section('icon', "users")
@section('subtitle', trans('laralum.group_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
  		<div class="ui very padded segment">
		    <div class="row">
		      <div class="col-md-12 text-right">
				   <a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')" data-toggle="modal" data-target="#AddGroup" class="res_ex ui {{ Laralum::settings()->button_color }} button">
					<i class="fas fa-plus icon_m" aria-hidden="true"></i><span>ADD</span>
				   </a>
			   </div>			   
		    </div>
			@if(count($group) > 0)
  			<table class="ui five column table">
  			  <thead>
  			    <tr>
                  <th>{{ trans('laralum.name') }}</th>
                  <th>{{ trans('laralum.description') }}</th>
                   <th>{{ trans('laralum.contact_count') }}</th>
                  <th>{{ trans('laralum.options') }}</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($group as $grp)
					<tr>
						<td>
                            <div class="text">
                                {{ $grp->name }}
                            </div>
                        </td>
                        <td>
                            <div class="text">
                                {{ $grp->description }}
                            </div>
                        </td>
                        <td>
                            <div class="text">
                                <a href="{{ route('Laralum::contacts', ['id' => $grp->id]) }}" title="Manage contacts">{{ $grp->Contactcount }}</a>
                            </div>
                        </td>
                        <td>                         
						  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
							<i class="configure icon"></i>
							<div class="menu">
							  <div class="header">{{ trans('laralum.editing_options') }}</div>
							  <a href="javascript:void(0);" onclick="$('.dimmer').removeClass('dimmer')" id="editGroup" data-id="{{$grp->id}}" data-name="{{$grp->name}}" data-desc="{{$grp->description}}" data-toggle="modal" data-target="#EditGroup" class="item">
								<i class="edit icon"></i>
								{{ trans('laralum.group_edit') }}
							  </a>
							  
							  <a href="{{ route('Laralum::contacts', ['id' => $grp->id]) }}" class="item" >
								<i class="phone icon"></i>
								{{ trans('laralum.manage_contacts') }}
							  </a>
							 
							  <div class="header">{{ trans('laralum.advanced_options') }}</div>
							  <a href="{{ route('Laralum::groups_delete', ['id' => $grp->id]) }}" class="item">
								<i class="trash bin icon"></i>
								{{ trans('laralum.group_delete') }}
							  </a>
							  
							</div>
						  </div>
						</td>
					</tr>
				@endforeach
  			  </tbody>
  			</table>
			{{ $group->links() }}
			@else
			<div class="ui negative icon message">
				<i class="frown icon"></i>
				<div class="content">
					<div class="header">
						{{ trans('laralum.missing_title') }}
					</div>
					<p>{{ trans('laralum.missing_subtitle', ['element'  =>  "group"]) }}</p>
				</div>
			</div>
            @endif
			
  		</div>
		
        <br>
  	</div>
  </div>
<!-- add-group-popup-->
<div id="AddGroup" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Group</h4>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" id="save_group_form" action="javascript:void(0)">
		    {{ csrf_field() }}	
			<div class="form-group">
				<input placeholder="Enter group name" class="form-control" id="group_name" name="group_name" />
				<small id="show_issue_error" style="color:#FF0000;display:none;">Please enter group name</small>
			</div>
			<div class="form-group">
				<textarea placeholder="Enter description" class="form-control" rows="3" id="group_desc" name="group_desc"></textarea>
			</div>
			<div class="text-right">
			<button type="submit" id="groupForm" class="ui teal submit button"><span id="hide_group_text">SAVE</span>&nbsp;
			<span class="groupForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
			</button>
			</div>
		</form>
      </div>     
    </div>
  </div>
</div>
<!-- add-group-popup -->
<!-- edit-group-popup-->
<div id="EditGroup" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Group</h4>
      </div>
      <div class="modal-body">
        <form method="POST" enctype="multipart/form-data" id="edit_group_form" action="javascript:void(0)">
		    {{ csrf_field() }}	
			 <input type="hidden" id="group_id" name="group_id" />
			<div class="form-group">
				<input placeholder="Enter group name" class="form-control" id="edit_group_name" name="edit_group_name" />
				<small id="edit_show_grp_error" style="color:#FF0000;display:none;">Please enter group name</small>
			</div>
			<div class="form-group">
				<textarea placeholder="Enter description" class="form-control" rows="3" id="edit_group_desc" name="edit_group_desc"></textarea>
			</div>
			<div class="text-right">
			<button type="submit" id="editGroupForm" class="ui teal submit button"><span id="hide_edit_group_text">UPDATE</span>&nbsp;
			<span class="editGroupForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
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
<script src="{{ asset(Laralum::publicPath() .'/js/groups-script.js') }}"></script>
<script>
$(document).on('click','#editGroup',function(e) {
	$('#group_id').val($(this).attr('data-id'))
	$('#edit_group_name').val($(this).attr('data-name'))
	$('#edit_group_desc').val($(this).attr('data-desc'))
});
</script>
@endsection
