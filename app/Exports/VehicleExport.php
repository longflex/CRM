<?php
namespace App\Exports;
use App\Vehicle;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DB;

class VehicleExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	use Exportable;

    public function __construct(int $client_id)
    {
        $this->client = $client_id;
    }

    public function query()
    {
        return  Vehicle::query()
				->join('vehicle_type', 'vehicles.vehicle_type', '=', 'vehicle_type.id')
				->join('fuel_type', 'vehicles.fuel_type', '=', 'fuel_type.id')
				->select('vehicles.id', 'vehicle_type.name as vtype','fuel_type.name as ftype','vehicles.vehicle_name','vehicles.reg_no','vehicles.engine_no','vehicles.model_no','vehicles.insurance_no','vehicles.last_service','vehicles.next_service','vehicles.insurance_date')
				->where('vehicles.client_id', $this->client);
		
    }
	
	
   
	public function headings(): array
    {

        return [
		    'ID',
		    'Vehicle Type',
		    'Fuel Type',
		    'Vehicle Name',
		    'Reg No.',
		    'Engine No',    
		    'Model No',    
		    'Insurance No',    
		    'Last Service',    
		    'Next Service',    
		    'Insurance Exp Date',    
        ];

    }
}
