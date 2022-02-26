@extends('layouts.console.panel')
@section('breadcrumb')
     <div class="ui breadcrumb">
        <a class="section" href="{{ route('console::manage_module') }}">{{ trans('laralum.module_manager') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.getway_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.getway_title'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
  		<div class="ui very padded segment">
        <div class="row">
		 <div class="col-md-12 text-right">
		   <a href="{{ route('console::gateways_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
			<i class="fa fa-plus" aria-hidden="true"></i> <span>{{ trans('laralum.getway_create_title') }}</span>
		   </a>
		</div>
		</div>
  		<table class="ui five column table">
  			  <thead>
  			    <tr>
				   <th>{{ trans('laralum.getway_name') }}</th>
				   <th>{{ trans('laralum.trans_balance') }}</th>
				   <th>{{ trans('laralum.promo_balance') }}</th>
				   <th>{{ trans('laralum.options') }}</th>
  			    </tr>
  			  </thead>
  			  <tbody>
                @foreach($getways as $getway)
					<tr id="gatewayList{{ $getway->id }}">
						<td>
                            <div class="text">
                                {{ $getway->gateway_name }}
                            </div>
                        </td>
                        <td>
                            <div class="text">
							  {{ $getway->promo }}
                            </div>
                        </td>
                        <td>
                            <div class="text">
                               {{ $getway->trans }}
                            </div>
                        </td>
			
                        <td>
                          @if(Laralum::loggedInUser()->hasPermission('laralum.gateways.edit') or (Laralum::loggedInUser()->hasPermission('laralum.gateways.delete') and !$getway->su))
                              <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
                                <i class="configure icon"></i>
                                <div class="menu">
								 @if(Laralum::loggedInUser()->hasPermission('laralum.gateways.edit') and !$getway->su)
                                  <div class="header">{{ trans('laralum.editing_options') }}</div>
                                  <a href="{{ route('console::gateways_edit', ['id' => $getway->id]) }}" class="item">
                                    <i class="edit icon"></i>
                                    {{ trans('laralum.getway_edit_title') }}
                                  </a>
								  @endif
                                  @if(Laralum::loggedInUser()->hasPermission('laralum.gateways.delete') and !$getway->su)
                                  <div class="header">{{ trans('laralum.advanced_options') }}</div>
                                  <button value="{{ $getway->id }}" class="item deleteGetway">
                                    <i class="trash bin icon"></i>
                                    {{ trans('laralum.getway_delete_title') }}
                                  </button>
                                  @endif
                                </div>
                              </div>
                          @else
                              <div class="ui disabled {{ Laralum::settings()->button_color }} icon button">
                                  <i class="lock icon"></i>
                              </div>
                          @endif
						</td>
					</tr>
				@endforeach
  			  </tbody>
  			</table>
  		</div>
		
        <br>
  	</div>
  </div>
<script>
$(document).on('click','.deleteGetway',function(){
	var gateway_id = $(this).val();
	var my_url = "{{ url('admin/getwayDeleteAction') }}";

	var type = "POST"; 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		}
	})
	var formData = {
		gateway_id: gateway_id,
	}
	 swal({
		title: "Are you sure?",
		text: "You will not be able to recover this gateway!",
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
				text: 'Gateway is successfully deleted!',
				type: 'success'
			}, function() {
				$.ajax({
					type: type,
					url: my_url,
					data: formData,
					dataType: 'json',
					success: function (data) {
						console.log(data);
						$("#gatewayList" + gateway_id).remove();
					    window.location.reload();
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			});
			
		} else {
			swal("Cancelled", "Your gateway is safe :)", "error");
		}
	});
	
});
</script>
	
	
@endsection
