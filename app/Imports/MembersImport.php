<?php

namespace App\Imports;

use App\Lead;
use App\Leadsdata;
use App\Http\Controllers\Laralum\Laralum;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use App\Services\LeadService;
use Throwable;

HeadingRowFormatter::default('none');

class MembersImport implements 
	ToCollection, 
    WithHeadingRow, 
    SkipsOnError, 
    WithValidation,
    SkipsOnFailure,
    WithChunkReading,
    ShouldQueue,
    WithEvents 
{
	use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;

    public function __construct($client_id, $user_id)
    {
        $this->client_id = $client_id;
        $this->user_id = $user_id;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
}
