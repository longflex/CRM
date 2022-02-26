<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{

	protected $table = 'payslips';
	protected $fillable = ['employee_id' , 'name', 'anual_ctc', 'basic_perc', 'hra_perc', 'special_allowance_per', 'pf_percentage', 'esi_percentage', 'advance_percentage', 'pt_percentage', 'payment_date', 'joining_date'];				



}
