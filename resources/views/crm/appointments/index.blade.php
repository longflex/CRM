@extends('layouts.crm.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.appointments_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.appointments_title'))
@section('icon', "mobile")
@section('subtitle', trans('laralum.appointments_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container">
  	<div class="column">
  		<div class="ui very padded segment">
		    <div class="row">
		      <div class="col-md-12 text-right">
				   <a href="{{ route('Crm::appointments_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
					<i class="fas fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.appointment_create') }}</span>
				   </a>
				   <a href="{{ route('Crm::appointments_export', ['client_id' => $client_id]) }}" class="res_ex ui {{ Laralum::settings()->button_color }} button" id="Export" onclick="$('.dimmer').removeClass('dimmer')">
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
			<div class="filter-area" style="display: none;">
				<div class="row">
					<form class="ui form" method="GET" action="{{ route('Crm::appointments') }}">
						<div class="col-md-3">
							<div class="form-group">
								<select class="form-control custom-select" name="status">
									<option value="" selected>All Status</option>
									<option value="Completed" @if(request()->get('status')=='Completed') selected @endif>Completed</option>
									<option value="Pending" @if(request()->get('status')=='Pending') selected @endif>Pending</option>
								</select>
							</div>
						</div>					
						<div class="col-md-6">
						<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" value="{{ request()->get('from_date') }}" placeholder="From date" onfocus="(this.type='date')" onblur="(this.type='text')" name="from_date" class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input type="text" value="{{ request()->get('to_date') }}" placeholder="To date" onfocus="(this.type='date')" onblur="(this.type='text')" name="to_date" class="form-control" />
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
					<form class="ui form form-inline" method="POST" enctype="multipart/form-data"  action="{{ route('Crm::appointments_import') }}">
						<div class="col-md-12">
							<h4 class="mb-15"><i class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span></h4>
							
						</div>
						<div class="col-md-12">
						<div class="col-md-6">
						@if(count($apt_staff) > 0)
						<ul class="list-group">
						   <p>Please use below <strong>ID</strong> for whom to meet field</p>
						   @foreach($apt_staff as $staff)
						     <li class="list-group-item">ID - {{ $staff->id }} , Name - {{ $staff->name }}</li>
						   @endforeach
						</ul>
						@else
						<div class="ui negative icon message">
							<i class="frown icon"></i>
							<div class="content">
								<div class="header">
									{{ trans('laralum.missing_title') }}
								</div>
								<p>Please add whom to meet person for appointment.</p>
							</div>
						</div>
						@endif
						</div>
					   {{ csrf_field() }}
						<div class="col-md-6 text-right">
							<div class="form-group">
							 <input type="file"	name="file" class="form-control"	/>			  								
							 <input type="hidden" value="{{ $client_id }}"	name="import_apt_client_id"	/>	
							<input type="submit" name="importSubmit" class="res_ex ui teal button ml-5" value="Import">							 
							</div>																
								<div class="mb-15 text-right">
								<a href="{{ url('files/sample-csv-appointments.csv') }}" download >Download Sample File</a>			
						    </div>
						</div>																																																					
						</div>																																																					
					</form>
				</div>
			</div>			  		  
          <!--import-area-->	
  			@if(count($appointments) > 0)
                <table class="ui five column table ">
                  <thead>
                    <tr>           
                      <th>Name</th>
                      <th>Phone</th>                     
                      <th>Date</th>                     
                      <th>Time</th>                     
                      <th>Status</th>                     
					  <th>{{ trans('laralum.options') }}</th>                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>
                                <div class="text">
                                   {{ $appointment->name }}
                                </div>
                            </td>
							<td>
                                <div class="text">
                                    {{ $appointment->mobile }}
                                </div>
                            </td>
							<td>
                                <div class="text">
                                 {{ date('d/m/Y', strtotime($appointment->apt_date)) }}    
                                </div>
                            </td>
							<td>
                                <div class="text">
								{{  date("g:i A", strtotime($appointment->time_slot)) }}                                   
                                </div>
                            </td>
							<td>
                                <div class="text">
								    @if($appointment->status=='Pending')
                                    <span class="badge badge-info">{{ $appointment->status }}</span>
								    @else
									<span class="badge badge-success">{{ $appointment->status }}</span>	
									@endif
                                </div>
                            </td>
							                          
                            <td>                           
                                  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
                                    <i class="configure icon"></i>
                                    <div class="menu">
                                     
									  <div class="header">{{ trans('laralum.editing_options') }}</div>
                                      <a data-toggle="modal" id="changeStatus" data-id="{{$appointment->id}}" data-target="#StatusModal" class="item">
                                      <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                                        Change Status
                                      </a>
									  <a href="{{ route('Crm::appointment_details', ['id' => $appointment->id]) }}" class="item">
                                       <i class="eye icon"></i>{{ trans('laralum.appointment_view') }} / {{ trans('laralum.appointment_edit') }}
                                      </a>                                 
                                      <div class="header">{{ trans('laralum.advanced_options') }}</div>
                                      <a href="{{ route('Crm::appointment_delete', ['id' => $appointment->id]) }}" class="item">
                                        <i class="trash bin icon"></i>
                                        {{ trans('laralum.delete_lead') }}
                                      </a>
                                    </div>
                                  </div>
                              
                            </td>                         
                        </tr>
                    @endforeach
                  </tbody>
                </table>
            @else
                <div class="ui negative icon message">
                    <i class="frown icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ trans('laralum.missing_title') }}
                        </div>
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "appointments"]) }}</p>
                    </div>
                </div>
            @endif
  		</div>
  	</div>
  </div>
  
  
  
  <!-- Status Modal -->
<div id="StatusModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Change Status</h4>
      </div>
      <div class="modal-body">
        <form class="ui form" action="javascript:void(0)" method="POST" id="change_status_form">
		  {{ csrf_field() }}
			<div class="form-group">
			    <input type="hidden" name="appointment_id" id="appointment_id" />
				<select class="form-control custom-select" name="status" id="status">
					<option value="">Select status</option>
					<option value="Completed">Completed</option>
				</select>
				<p style="color:red; display:none;" id="error_status_text">Please select status.</p>
			</div>
			<div class="form-group">
				<button type="submit" id="statusForm" class="ui {{ Laralum::settings()->button_color }} submit button"><span id="hidestatustext">CHANGE</span>&nbsp;
				<span class="statusForm" style="display:none;"><img src="{{ asset(Laralum::publicPath() . '/images/loader-text.png') }}"></span>
				</button>
			</div>
		</form>
      </div>
      
    </div>

  </div>
</div>
@endsection
@section('js')
<script src="{{ asset('crm_public/js/appointment-script.js') }}" type="text/javascript"></script>
<script>
$("#FilterShow").click(function(){
  $(".filter-area").slideToggle();
});
$("#ImportShow").click(function(){
  $(".import-area").slideToggle();
});
</script>
<script>
$(document).on('click','#changeStatus',function(e) {
	$('#appointment_id').val($(this).attr('data-id'))
});
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection
