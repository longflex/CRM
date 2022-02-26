@extends('layouts.crm.panel')
@section('breadcrumb')
    <div class="ui breadcrumb">
        <a class="section" href="{{ route('Crm::vehicles') }}">{{  trans('laralum.vehicle_title') }}</a>
        <i class="right angle icon divider"></i>
        <div class="active section">{{ trans('laralum.vehicle_show') }}</div>
    </div>
@endsection
@section('title', trans('laralum.vehicle_show'))
@section('icon', "plus")
@section('subtitle', trans('laralum.vehicle_show'))
@section('content')
<div class="ui one column doubling stackable grid container">
    <div class="three wide column"></div>
	<div class="ui very padded segment">
    <div class="fifteen wide column">      
		 
		<div class="row">
			<div class="col-md-12">
				<h3 class="vehicle-form-heading">
				@if($vehicle->vehicle_type==1)
				<i class='fas fa-motorcycle' style='font-size:35px;color:#26476c;'></i>
			    @endif
				@if($vehicle->vehicle_type==2)
				<i class='fas fa-car-side' style='font-size:35px;color:#26476c;'></i>
			    @endif
				@if($vehicle->vehicle_type==3)
				<i class='fas fa-shuttle-van' style='font-size:35px;color:#26476c;'></i>
			    @endif
				@if($vehicle->vehicle_type==4)
				<i class='fas fa-truck-moving' style='font-size:35px;color:#26476c;'></i>
			    @endif
				&nbsp;&nbsp; {{ strtoupper($vehicle->vehicle_name) }}
				</h3>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
                    <table class="ui table">
						<tbody>
						@if(!empty($vehicle->branch))
                        <tr>
                            <th>Branch</th>
                            <td>{{ strtoupper($vehicle->branch) }}</td>
                        </tr>
						@endif
						 @if(!empty($vehicle->purpose))
                        <tr>
                            <th>Purpose</th>
                            <td>{{ strtoupper($vehicle->purpose) }}</td>
                        </tr>
						@endif
					   @if(!empty($vehicletype))
                        <tr>
                            <th>Vehicle type</th>
                            <td>{{ strtoupper($vehicletype) }}</td>
                        </tr>
						@endif
						@if(!empty($vehicle->reg_no))
                        <tr>
                            <th>Reg No</th>
                            <td>{{ strtoupper($vehicle->reg_no) }}</td>
                        </tr>
						@endif
						@if(!empty($vehicle->engine_no))
                        <tr>
                            <th>Engine No</th>
                            <td>{{ strtoupper($vehicle->engine_no) }}</td>
                        </tr>
						@endif
						@if(!empty($vehicle->model_no))
						 <tr>
                            <th>Model No</th>
                            <td>{{ strtoupper($vehicle->model_no) }}</td>
                        </tr>
						@endif
						@if(!empty($fueltype))
						 <tr>
                            <th>Fuel Type</th>
                            <td>{{ strtoupper($fueltype) }}</td>
                        </tr>
						@endif
						@if(!empty($vehicle->km_drive))
						 <tr>
                            <th>KM Drive</th>
                            <td>{{ strtoupper($vehicle->km_drive) }}</td>
                        </tr>
						@endif
						@if(!empty($vehicle->last_service))
						 <tr>
                            <th>Last Service</th>
                            <td><?php echo date('M d, Y', strtotime($vehicle->last_service)); ?></td>
                        </tr>
						@endif
						@if(!empty($vehicle->next_service))
						 <tr>
                            <th>Next Service</th>
                            <td><?php echo date('M d, Y', strtotime($vehicle->next_service)); ?></td>
                        </tr>
						@endif
						@if(!empty($vehicle->next_service_km))
						 <tr>
                            <th>Next Service (KM)</th>
                            <td>{{ $vehicle->next_service_km }}</td>
                        </tr>
						@endif
						</tbody>
					</table>
                </div>
				
				<div class="col-md-6">
					<table class="ui table">
						<tbody>
							@if(!empty($vehicle->insurance_no))
                        <tr>
                            <th>Insurance No</th>
                            <td>{{ strtoupper($vehicle->insurance_no) }}</td>
                        </tr>
						@endif
						@if(!empty($vehicle->insurance_date))
                        <tr>
                            <th>Insurance Exp Date</th>
                            <td><?php echo date('M d, Y', strtotime($vehicle->insurance_date)); ?></td>
                        </tr>
						@endif
						@if(!empty($vehicle->pollution_exp))
                        <tr>
                            <th>Pollution Exp Date</th>
                            <td><?php echo date('M d, Y', strtotime($vehicle->pollution_exp)); ?></td>
                        </tr>
						@endif
						@if(!empty($vehicle->chassis_no))
						 <tr>
                            <th>Chassis No</th>
                            <td>{{ strtoupper($vehicle->chassis_no) }}</td>
                        </tr>
						@endif
						@if(!empty($vehicle->road_tax_no))
						 <tr>
                            <th>Road TAX No</th>
                            <td>{{ strtoupper($vehicle->road_tax_no) }}</td>
                        </tr>
						@endif
						@if(!empty($vehicle->road_tax_expiry))
						 <tr>
                            <th>Road Tax Expiry</th>
                            <td><?php echo date('M d, Y', strtotime($vehicle->road_tax_expiry)); ?></td>
                        </tr>
						@endif
						@if(!empty($vehicle->fitness_exp))
						 <tr>
                            <th>Fitness Exp Date</th>
                            <td><?php echo date('M d, Y', strtotime($vehicle->fitness_exp)); ?></td>
                        </tr>
						@endif
						@if(!empty($vehicle->permit_exp))
						<tr>
                            <th>Permit Exp Date</th>
                            <td><?php echo date('M d, Y', strtotime($vehicle->permit_exp)); ?></td>
                        </tr>
						@endif
						</tbody>
					</table>
                </div>
				
				
		</div>
	
	
     </div>
    </div>
    <div class="three wide column"></div>
</div>

<style>
.ui.table tr th {
    border-top: 1px solid rgba(34,36,38,.1);
}
</style>

<script>
$(document).ready(function() {
  $('.dimmer').removeClass('dimmer');
});
</script>
@endsection