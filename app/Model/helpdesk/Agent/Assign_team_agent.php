<?php

namespace App\Model\helpdesk\Agent;

use App\BaseModel;

class Assign_team_agent extends BaseModel
{
    protected $table = 'team_assign_agent';
    protected $fillable = ['id', 'team_id', 'agent_id', 'updated_at', 'created_at'];

    public function team()
    {
        $foreign_key = 'team_id';
        $local_key = 'id';
        return $this->belongsTo('App\Model\helpdesk\Agent\Teams', $foreign_key, $local_key);
    }
}
