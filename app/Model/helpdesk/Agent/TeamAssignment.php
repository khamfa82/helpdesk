<?php

namespace App\Model\helpdesk\Agent;

use App\BaseModel;

class TeamAssignment extends BaseModel
{
    protected $table = 'team_assignments';
    protected $fillable = [
        'from_team_id', 'to_team_id', 'remarks', 'active', 'hide',
    ];

    public function toTeam()
    {
        $foreign_key = 'to_team_id';
        $local_key = 'id';
        return $this->belongsTo('App\Model\helpdesk\Agent\Teams', $foreign_key, $local_key);
    }

    public function fromTeam()
    {
        $foreign_key = 'from_team_id';
        $local_key = 'id';
        return $this->belongsTo('App\Model\helpdesk\Agent\Teams', $foreign_key, $local_key);
    }

    public function getToGroupNameAttribute()
    {
        $name = $this->toTeam->name;
        return $name;
    }

    public function getActiveStatusAttribute()
    {
        if($this->active == 1) return 'YES';
        return 'No';
    }

}
