<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ManualLoggedCall extends Model
{
    protected $table = 'manual_logged_call';

    protected $fillable = ['client_id', 'member_id', 'lead_number', 'agent_number', 'created_by', 
                          'outcome', 'call_status', 'call_initiation', 'date', 'duration', 'description',
                          'status', 'call_type', 'call_source', 'call_purpose', 'call_outcome', 
                          'campaign_id', 'recordings_file1', 'recordings_file'];

}
