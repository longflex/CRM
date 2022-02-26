<?php
namespace App\Http\Controllers\Crm;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Lead;
use App\User;
use App\Vehicle;
use App\Exports\VehicleExport;
use Maatwebsite\Excel\Facades\Excel;
use Laralum;
use Validator,DB,File;
use Response;
class VehiclesController extends Controller
{

    public function index(Request $request) {
		Laralum::permissionToAccess('laralum.vehicles.view');
        # Get all vehicles for admin
		
		$vehicle_type = $request->vehicle_type;
		$fuel_type = $request->fuel_type;
		$from_date = $request->from_date;
		$to_date = $request->to_date;      
        # Get all appointments for admin
		if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		}else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		
		if(Laralum::loggedInUser()->reseller_id==0){
			$vehicles = DB::table('vehicles')
			     ->when($vehicle_type, function ($query, $vehicle_type){
					  return $query->where('vehicle_type', $vehicle_type);
				   })
				 ->when($fuel_type, function ($query, $fuel_type){
					  return $query->where('fuel_type', $fuel_type);
				   })
			     ->when($from_date, function ($query, $from_date) {
					   return $query->whereDate('created_at', '>=', $from_date);
				   })
				 ->when($to_date, function ($query, $to_date) {
					   return $query->whereDate('created_at', '<=', $to_date);
				   })
				->where('client_id', Laralum::loggedInUser()->id)
				->orderBy('id', 'desc')
				->paginate(12);
		}else{
		   $vehicles = DB::table('vehicles')
		        ->when($vehicle_type, function ($query, $vehicle_type){
					  return $query->where('vehicle_type', $vehicle_type);
				   })
				 ->when($fuel_type, function ($query, $fuel_type){
					  return $query->where('fuel_type', $fuel_type);
				   })
			     ->when($from_date, function ($query, $from_date) {
					   return $query->whereDate('created_at', '>=', $from_date);
				   })
				 ->when($to_date, function ($query, $to_date) {
					   return $query->whereDate('created_at', '<=', $to_date);
				   })
				->where('created_by', Laralum::loggedInUser()->id)
				->orderBy('id', 'desc')
				->paginate(12);
		  
		}
		foreach($vehicles as $vehicle){
			if($vehicle->vehicle_type==1){
			 $vehicle->type = 'Two Wheeler';
			}else if($vehicle->vehicle_type==2){
			  $vehicle->type = 'Four Wheeler(non transport)';
			}else if($vehicle->vehicle_type==3){
			  $vehicle->type = 'Light commercial vehicle';
			}else{
			  $vehicle->type = 'Heavy Commercial';
			}
			
			if($vehicle->fuel_type==1){
			  $vehicle->ftype = 'Deisel';
			}else if($vehicle->fuel_type==2){
			  $vehicle->ftype = 'Petrol';
			}else{
			  $vehicle->ftype = 'Gas';
			}
			
		}		
			
        # Return the view
        return view('crm/vehicles/index', ['vehicles' => $vehicles, 'client_id' => $client_id]);
    }
	
	public function dashboard(Request $request) {	
		Laralum::permissionToAccess('laralum.vehicles.dashboard');	
			# Get all leads for admin
			if(Laralum::loggedInUser()->reseller_id==0){
			    $two_wheeler = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('vehicle_type', 1)->count();
			    $four_wheeler = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('vehicle_type', 2)->count();
			    $total = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->count();
			    $todays = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->count();
				$deisel = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('fuel_type', 1)->count();
			    $petrol = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('fuel_type', 2)->count();			    
			    $gas = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('fuel_type', 3)->count();
			}else{
			    $two_wheeler = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('vehicle_type', 1)->count();
			    $four_wheeler = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('vehicle_type', 2)->count();
			    $total = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->count();
			    $todays = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '=', date("Y-m-d"))->count();
				$deisel = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('fuel_type', 1)->count();
			    $petrol = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('fuel_type', 2)->count();			    
			    $gas = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('fuel_type', 3)->count();
			}
		    $account_types = DB::table('account_types')->get();
			# Return the view
			return view('crm/vehicles/dashboard',[			   
			       'two_wheeler' => $two_wheeler,					   
			       'four_wheeler' => $four_wheeler,					   
			       'total' => $total,					   
			       'todays' => $todays,					   
			       'deisel' => $deisel,					   				   
			       'petrol' => $petrol,					   				   
			       'gas' => $gas,					   				   					   				   
			]);
		         		 		
    }
	
	public function vehiclesDashboardFilter(Request $request) {		
			$exp_requested_date = explode("-",$request->data);
			$from = $exp_requested_date[0];
			$to = $exp_requested_date[1];
			
			$from_date = date('Y-m-d H:i:s', strtotime($from));
			$to_date = date('Y-m-d H:i:s', strtotime($to));
						
			# Get all vehicles for admin
			if(Laralum::loggedInUser()->reseller_id==0){
			    $two_wheeler = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('vehicle_type', 1)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
			    $four_wheeler = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('vehicle_type', 2)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
			    $total = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
				$deisel = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('fuel_type', 1)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
			    $petrol = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('fuel_type', 2)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();			    
			    $gas = DB::table('vehicles')->where('client_id', Laralum::loggedInUser()->id)->where('fuel_type', 3)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
			}else{
			    $two_wheeler = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('vehicle_type', 1)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
			    $four_wheeler = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('vehicle_type', 2)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
			    $total = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
				$deisel = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('fuel_type', 1)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
			    $petrol = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('fuel_type', 2)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();			    
			    $gas = DB::table('vehicles')->where('created_by', Laralum::loggedInUser()->id)->where('fuel_type', 3)->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->count();
			}
			
		   return response()->json(array(
		           'success' => true, 
		           'status' => 'success',
		           'two_wheeler' => $two_wheeler,					   
			       'four_wheeler' => $four_wheeler,					   
			       'total' => $total,					   				   
			       'deisel' => $deisel,					   				   
			       'petrol' => $petrol,					   				   
			       'gas' => $gas,	
		   ), 200);		         		 		
    }

    public function create()
    {
		Laralum::permissionToAccess('laralum.vehicles.create');
        # Return the view
        return view('crm/vehicles/create');
    }

    public function store(Request $request)
    {
		Laralum::permissionToAccess('laralum.vehicles.create');
		# Check permissions
        //Laralum::permissionToAccess('laralum.senderid.access');
	    //echo '<pre>';print_r($request->all());die;
		if(Laralum::loggedInUser()->reseller_id==0){
			$client_id = Laralum::loggedInUser()->id;
		}else{
			$client_id = Laralum::loggedInUser()->reseller_id;
		}
		        	    		
		$vehicle = new Vehicle;
		$vehicle->client_id = $client_id;
		$vehicle->branch = $request->branch;
		$vehicle->vehicle_type = $request->vehicle_type;
		$vehicle->vehicle_name = $request->vehicle_name;
		$vehicle->purpose = $request->purpose;
		$vehicle->reg_no = $request->reg_no;
		$vehicle->engine_no = $request->engine_no;
		$vehicle->model_no = $request->model_no;
		$vehicle->fuel_type = $request->fuel_type;
		$vehicle->km_drive = $request->km_drive;
		$vehicle->last_service = $request->last_service;
		$vehicle->next_service = $request->next_service;
		$vehicle->next_service_km = $request->next_service_km;
		$vehicle->insurance_no = $request->insurance_no;
		$vehicle->insurance_date = $request->insurance_date;
		$vehicle->pollution_exp = $request->pollution;
		$vehicle->chassis_no = $request->chassis_no;
		$vehicle->road_tax_no = $request->road_tax_no;
		$vehicle->road_tax_expiry = $request->road_tax_expiry;
		$vehicle->fitness_exp = $request->fitness;
		$vehicle->permit_exp = $request->permit;
		$vehicle->created_by = Laralum::loggedInUser()->id;							
		$vehicle->save();
        # Return the admin to the blogs page with a success message
        return response()->json(array('success' => true, 'status' => 'success'), 200);
    }
	
	public function edit($id)
    {
		Laralum::permissionToAccess('laralum.vehicles.edit');
        # Check permissions to access
        //Laralum::permissionToAccess('laralum.senderid.access');
		
       # Find the vehicle
	   $vehicle = DB::table('vehicles')->where('id', $id)->first();
        # Return the edit form
        return view('crm/vehicles/edit', [
            'vehicle'  =>  $vehicle,
        ]);
    }
	
	
	public function updateVehicle(Request $request)
    {
		Laralum::permissionToAccess('laralum.vehicles.edit');
		# Check permissions
        //Laralum::permissionToAccess('laralum.senderid.access');
		
		DB::table('vehicles')->where('id', $request->vehicle_id )->update([
			 'branch' => $request->branch, 
			 'vehicle_type' => $request->vehicle_type, 
			 'vehicle_name' => $request->vehicle_name, 
			 'purpose' => $request->purpose, 			 		 		 
			 'reg_no' => $request->reg_no, 			 		 		 
			 'engine_no' => $request->engine_no, 			 		 		 
			 'model_no' => $request->model_no, 			 		 		 
			 'fuel_type' => $request->fuel_type,
             'km_drive' => $request->km_drive, 
			 'last_service' => $request->last_service, 
			 'next_service' => $request->next_service, 
			 'next_service_km' => $request->next_service_km, 			 		 		 
			 'insurance_no' => $request->insurance_no, 			 		 		 
			 'insurance_date' => $request->insurance_date, 			 		 		 
			 'pollution_exp' => $request->pollution, 			 		 		 
			 'chassis_no' => $request->chassis_no, 			 
			 'road_tax_no' => $request->road_tax_no, 			 
			 'road_tax_expiry' => $request->road_tax_expiry, 			 
			 'fitness_exp' => $request->fitness, 			 
			 'permit_exp' => $request->permit, 			 			 
		 ]);
		 		
        # Return the admin to the donation page with a success message
        return response()->json(array('success' => true, 'status' => 'success'), 200);
    }
	
	
  
     public function show($id)
     {
		Laralum::permissionToAccess('laralum.vehicles.view');
       $vehicle = Vehicle::findOrFail($id);
			if($vehicle->vehicle_type==1){
				 $vehicletype = 'Two Wheeler';
			}else if($vehicle->vehicle_type==2){
			  $vehicletype = 'Four Wheeler(non transport)';
			}else if($vehicle->vehicle_type==3){
			  $vehicletype = 'Light commercial vehicle';
			}else{
			  $vehicletype = 'Heavy Commercial';
			}

			if($vehicle->fuel_type==1){
			  $fueltype = 'Deisel';
			}else if($vehicle->fuel_type==2){
			  $fueltype = 'Petrol';
			}else{
			  $fueltype = 'Gas';
			}		
				
		
    	# Return the view
    	return view('crm/vehicles/show', compact('vehicle', 'vehicletype', 'fueltype'));
     }
	
	public function destroy(Request $request, $id)
    {
		Laralum::permissionToAccess('laralum.vehicles.delete');
        # Find The Donation
        $vehicle = Laralum::vehicle('id', $id);		
    	
		# Delete Donation 
		$vehicle->delete();

		# Return a redirect
		return redirect()->route('Crm::vehicles')->with('success', "The vehicle has been deleted");
       
    }

    public function export(Request $request) 
    {
      return Excel::download(new VehicleExport($request->client_id), 'vehicles.xlsx');
    } 
	
	public function import(Request $request)
    {
   
	  if(isset($_POST['importSubmit'])){    
		// Allowed mime types
		$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
		
			// Validate whether selected file is a CSV file
			if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)){
				
				// If the file is uploaded
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					// Open uploaded CSV file with read-only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					
					// Skip the first line
					fgetcsv($csvFile);
					
					// Parse data from CSV file line by line
					while(($line = fgetcsv($csvFile)) !== FALSE){
						//echo '<pre>';print_r($line);die;
						// Get row data
						$vehicle = new Vehicle;
						$vehicle->client_id = $request->import_vehicle_client_id;
						$vehicle->branch = $line[0];
						$vehicle->vehicle_type = $line[1];
						$vehicle->vehicle_name = $line[2];
						$vehicle->purpose = $line[3];
						$vehicle->reg_no = $line[4];
						$vehicle->engine_no = $line[5];
						$vehicle->model_no = $line[6];
						$vehicle->fuel_type = $line[7];
						$vehicle->km_drive = $line[8];
						$vehicle->last_service = ($line[9]!='') ? date('Y-m-d', strtotime($line[9])) : '';
						$vehicle->next_service = ($line[10]!='') ? date('Y-m-d', strtotime($line[10])) : '';
						$vehicle->next_service_km = $line[11];
						$vehicle->insurance_no = $line[12];
						$vehicle->insurance_date = ($line[13]!='') ? date('Y-m-d', strtotime($line[13])) : '';
						$vehicle->pollution_exp = ($line[14]!='') ? date('Y-m-d', strtotime($line[14])) : '';
						$vehicle->chassis_no = $line[15];
						$vehicle->road_tax_no = $line[16];
						$vehicle->road_tax_expiry = ($line[17]!='') ? date('Y-m-d', strtotime($line[17])) : '';
						$vehicle->fitness_exp = ($line[18]!='') ? date('Y-m-d', strtotime($line[18])) : '';
						$vehicle->permit_exp = ($line[19]!='') ? date('Y-m-d', strtotime($line[19])) : '';
						$vehicle->created_by = Laralum::loggedInUser()->id;							
						$vehicle->save();
						
						
					}
					
					// Close opened CSV file
					fclose($csvFile);
					
					return redirect()->route('Crm::vehicles')->with('success', 'Vehicle data has been imported successfully.');
				}else{
					
					return redirect()->route('Crm::vehicles')->with('error', 'Some problem occurred, please try again.');
				}
			}else{
				
				return redirect()->route('Crm::vehicles')->with('error', 'Please upload a valid CSV file.');
			}
		}
		
        
    }

   		
}