<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Campaign;
use App\User;

class CampaignAgent extends Model
{
    protected $table = 'campaign_agents';

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'id', 'campaign_id');
    }
    public function user_list()
    {
        return $this->hasOne(User::class, 'id', 'agent_id');
    }
}