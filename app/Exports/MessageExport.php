<?php
namespace App\Exports;
use App\Reports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class MessageExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	use Exportable;

    public function __construct($id)
    {
        $this->request_id = $id;
    }

    public function query()
    {
        return Reports::query()->select('receiver', 'description', 'created_at')->where('request_id', $this->request_id);
    }
   
	public function headings(): array
    {

        return [
		    'Receiver',
		    'Status',   
		    'Delivery Time',   
        ];

    }
}
