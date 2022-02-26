<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DashboardWidget extends Model
{
    protected $fillable = ['widget_name', 'status', 'dashboard_type'];
}