<?php

namespace App\Model\helpdesk\Agent;

use App\BaseModel;

class Teams extends BaseModel
{
    protected $table = 'teams';
    protected $fillable = [
        'name', 'status', 'team_lead', 'assign_alert', 'admin_notes',
    ];

    public function getTeamMembers()
    {
        // $teamMembers = 
        $users = \DB::table('team_assign_agent')->select('team_assign_agent.id', 'team_assign_agent.agent_id','team_assign_agent.team_id', 'users.user_name', 'users.first_name', 'users.last_name', 'users.active', 'users.assign_group', 'users.primary_dpt', 'users.role')
          ->join('users', 'users.id', '=', 'team_assign_agent.agent_id')
          ->where('team_assign_agent.team_id', '=', $this->id)
          ->get();
        // dd($users);

        return $users;
    }
}
