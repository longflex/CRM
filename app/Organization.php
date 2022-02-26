<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Organization extends Model
{
    protected $table = 'organization_profile';
    protected $fillable = ['client_id', 'organization_name', 'industry', 'business_location', 'organization_logo', 'company_address_line1', 'company_address_line2','company_id'];
}
