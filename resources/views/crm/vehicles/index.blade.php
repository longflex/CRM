@extends('layouts.crm.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <div class="active section">{{ trans('laralum.vehicle_title') }}</div>
    </div>
@endsection
@section('title', trans('laralum.vehicle_title'))
@section('icon', "mobile")
@section('subtitle', trans('laralum.vehicle_subtitle'))
@section('content')
  <div class="ui one column doubling stackable grid container mb-20">
    <div class="column">	  	  	  	  
      <div class="ui very padded segment">
        <div class="row">
		     <div class="col-md-12 text-right">
			   <a href="{{ route('Crm::vehicle_create') }}" class="res_ex ui {{ Laralum::settings()->button_color }} button">
			      <i class="fa fa-plus icon_m" aria-hidden="true"></i><span>{{ trans('laralum.donation_create') }}</span>
		       </a>
			   <a href="{{ route('Crm::vehicles_export', ['client_id' => $client_id]) }}" class="res_ex ui {{ Laralum::settings()->button_color }} button" id="Export" onclick="$('.dimmer').removeClass('dimmer')">
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
					<form class="ui form" method="GET" action="{{ route('Crm::vehicles') }}">
					    <div class="col-md-12 mb-15">
							<h4><i class="fas fa-filter"></i> <span>FILTER</span></h4>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							 <label>Vehicle Type</label>
							 <select id="vehicle_type" name="vehicle_type" class="inp-form custom-select">
							  <option value="" selected="selected">All</option>
							  <option value="1" @if(request()->get('vehicle_type')==1) selected @endif>Two Wheeler</option>									  
							  <option value="2" @if(request()->get('vehicle_type')==2) selected @endif>Four Wheeler (non transport)</option>
							  <option value="3" @if(request()->get('vehicle_type')==3) selected @endif>Light commercial vehicle</option>									 
							  <option value="4" @if(request()->get('vehicle_type')==4) selected @endif>Heavy Commercial</option>
							 </select>							  								
							</div>
						</div>						
						<div class="col-md-3">
							<div class="form-group">
							    <label>Fuel Type</label>
								<select id="fuel_type" name="fuel_type" class="custom-select">
									<option value="" selected="selected">All</option>
									<option value="1" @if(request()->get('fuel_type')==1) selected @endif>Deisel</option>
									<option value="2" @if(request()->get('fuel_type')==1) selected @endif>Petrol</option>
									<option value="3" @if(request()->get('fuel_type')==1) selected @endif>Gas</option>	  
								</select>
							</div>
						</div>																		
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
									    <label>From Date</label>
										<input type="date" value="{{ request()->get('from_date') }}" placeholder="From date" name="from_date" class="form-control" />
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									    <label>To Date</label>
										<input type="date" value="{{ request()->get('to_date') }}" placeholder="To date" name="to_date" class="form-control" />
									</div>
								</div>
							</div>
						</div>																	
						<div class="col-md-12 text-right">
							<button type="submit" class="res_ex ui teal button">Filter</button>
						</div>
					</form>
				</div>
			</div>
           <!--import-area-->
            <div class="import-area" style="display: none;">
				<div class="row">
					<form class="ui form form-inline" method="POST" enctype="multipart/form-data"  action="{{ route('Crm::vehicles_import') }}">
						<div class="col-md-12">
							<h4 class="mb-15"><i class="fas fa-upload icon_m"></i><span>{{ trans('laralum.import') }}</span></h4>
						</div>
					   {{ csrf_field() }}
						<div class="col-md-6 col-md-offset-6 text-right">
							<div class="form-group">
							 <input type="file"	name="file" class="form-control"	/>			  								
							 <input type="hidden" value="{{ $client_id }}"	name="import_vehicle_client_id"	/>	
							<input type="submit" name="importSubmit" class="res_ex ui teal button ml-5" value="Import">							 
							</div>																
								<div class="mb-15 text-right">
								<a href="{{ url('files/sample-csv-vehicles.csv') }}" download>Download Sample File</a>			
						    </div>
						</div>																																															
						
					</form>
				</div>
			</div>			  		  
          <!--import-area-->			
		
  	  @if(count($vehicles) > 0)
                <table class="ui five column table ">
                  <thead>
                    <tr>           
                      <th>Name</th>
                      <th>Type</th>                     
                      <th>Reg No.</th>                     
                      <th>Fuel Type</th>                     
                      <th>Date</th>                     
					  <th>{{ trans('laralum.options') }}</th>                      
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td>
                                <div class="text">
                                   {{ $vehicle->vehicle_name }}
                                </div>
                            </td>
							<td>
                                <div class="text">
                                    {{ $vehicle->type }}
                                </div>
                            </td>
							<td>
                                <div class="text">
                                    {{ $vehicle->reg_no }}
                                </div>
                            </td>
							<td>
                                <div class="text">
                                 {{ $vehicle->ftype }}    
                                </div>
                            </td>
							<td>
                                <div class="text">
								{{  date("d/m/Y", strtotime($vehicle->created_at)) }}                                   
                                </div>
                            </td>
							
							                          
                            <td>                           
                                  <div class="ui {{ Laralum::settings()->button_color }} top icon left pointing dropdown button">
                                    <i class="configure icon"></i>
                                    <div class="menu">                                     
									  <div class="header">{{ trans('laralum.editing_options') }}</div>
									  <a href="{{ route('Crm::vehicle_edit', ['id' => $vehicle->id]) }}" class="item">
                                       <i class="edit icon"></i>{{ trans('laralum.vehicle_edit') }}
                                      </a>
                                      <a href="{{ route('Crm::vehicle_details', ['id' => $vehicle->id]) }}" class="item">
                                       <i class="eye icon"></i>{{ trans('laralum.vehicle_view') }}
                                      </a>									  
                                      <div class="header">{{ trans('laralum.advanced_options') }}</div>
                                      <a href="{{ route('Crm::vehicle_delete', ['id' => $vehicle->id]) }}" class="item">
                                        <i class="trash bin icon"></i>
                                        {{ trans('laralum.vehicle_delete') }}
                                      </a>
                                    </div>
                                  </div>
                              
                            </td>                         
                        </tr>
                    @endforeach
                  </tbody>
                </table>
				{{ $vehicles->links() }}
            @else
                <div class="ui negative icon message">
                    <i class="frown icon"></i>
                    <div class="content">
                        <div class="header">
                            {{ trans('laralum.missing_title') }}
                        </div>
                        <p>{{ trans('laralum.missing_subtitle', ['element'  =>  "vehicle"]) }}</p>
                    </div>
                </div>
            @endif
			
  		</div>
  	</div>
  </div>  
  <!-- Status Modal -->
@endsection
@section('js')
<script src="{{ asset('crm_public/js/vehicles-script.js') }}" type="text/javascript"></script>
<script>
$("#FilterShow").click(function(){
  $(".filter-area").slideToggle();
});
$("#ImportShow").click(function(){
  $(".import-area").slideToggle();
});
</script>
<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection
