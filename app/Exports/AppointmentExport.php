<?php
namespace App\Exports;
use App\Appointment;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DB;

class AppointmentExport implements FromQuery, WithHeadings
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
        return  Appointment::query()
				->join('leads', 'appointments.lead_id', '=', 'leads.id')
				->join('users', 'appointments.whom_to_meet', '=', 'users.id')
				->select('appointments.id', 'leads.name','leads.email','users.name as empName','appointments.apt_date','appointments.time_slot','appointments.status')
				->where('appointments.client_id', $this->client);
		
    }
	
	
   
	public function headings(): array
    {

        return [
		    'ID',
		    'Name',
		    'Email',
		    'Whom To Meet',
		    'Date',
		    'Time',
            'Status',      
        ];

    }
}
