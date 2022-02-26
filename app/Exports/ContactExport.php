<?php
namespace App\Exports;
use App\Contact;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ContactExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
	
	use Exportable;

    public function __construct(int $group_id)
    {
        $this->group = $group_id;
    }

    public function query()
    {
        return Contact::query()->select('contact_id', 'name', 'mobile')->where('group_id', $this->group);
    }
   
	public function headings(): array
    {

        return [
		    'Contact ID',
		    'Name',
		    'Mobile',   
        ];

    }
}
