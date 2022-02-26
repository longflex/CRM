<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CampaignAgent;

class Campaign extends Model
{
    protected $table = 'campaigns';

    public function campaign_agents()
    {
        return $this->hasMany(CampaignAgent::class, 'campaign_id', 'id');
    }
}