<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    public function module()
    {
        return $this->belongsTo(TaskModule::class, 'module_id', 'id');
    }

    public function priority()
    {
        return $this->belongsTo(TaskPriority::class, 'priority_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'status_id', 'id');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    static function countTasksByModule($module_id)
    {
        return Task::where('module_id', $module_id)->count();
    }

    static function countTasksByPriority($priority_id)
    {
        return Task::where('priority_id', $priority_id)->count();
    }
    
    static function countTasksByStatus($status_id)
    {
        return Task::where('status_id', $status_id)->count();
    }
    
    static function countTasksByUser()
    {
        return Task::where('assigned_to', auth()->user()->id)
            ->whereHas('status', function ($status) { 
                $status->where('is_done', 0); 
            })
            ->count();
    }
}
