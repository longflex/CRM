<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PriceList extends Model
{
    protected $fillable = ['price_id' , 'sms_type', 'from_qty', 'to_qty', 'price'];

}
