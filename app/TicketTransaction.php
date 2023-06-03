<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketTransaction extends Model
{
    public function status()
    {
        return $this->belongsTo('App\Model\helpdesk\Ticket\Ticket_Status', 'transaction_status', 'id');
    }

    public function initiator()
    {
        return $this->belongsTo('App\User', 'initiated_by', 'id');
    }
    
    public function assigned()
    {
        return $this->belongsTo('App\User', 'assigned_to', 'id');
    }
    
    public function transactor()
    {
        return $this->belongsTo('App\User', 'transaction_by', 'id');
    }
}
