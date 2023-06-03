<?php

namespace App\Model\helpdesk\Ticket;

use App\BaseModel;
use App\User;

class Tickets extends BaseModel
{
    protected $table = 'tickets';
    protected $fillable = ['id', 'ticket_number', 'num_sequence', 'user_id', 'priority_id', 'sla', 'help_topic_id', 'max_open_ticket', 'captcha', 'status', 'lock_by', 'lock_at', 'source', 'isoverdue', 'reopened', 'isanswered', 'is_deleted', 'closed', 'is_transfer', 'transfer_at', 'reopened_at', 'duedate', 'closed_at', 'last_message_at', 'last_response_at', 'created_at', 'updated_at', 'assigned_to','immigration_office_id'];

//        public function attach(){
//            return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_attachments',);
//
//        }
    public function thread()
    {
        return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_Thread', 'ticket_id');
    }

    public function collaborator()
    {
        return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_Collaborator', 'ticket_id');
    }

    public function helptopic()
    {
        $related = 'App\Model\helpdesk\Manage\Help_topic';
        $foreignKey = 'help_topic_id';

        return $this->belongsTo($related, $foreignKey);
    }

    public function category()
    {
        $related = 'App\Model\helpdesk\Ticket\TicketCategory';
        $foreignKey = 'ticket_category_id';
        return $this->belongsTo($related, $foreignKey);
    }
    
    public function concludedcategory()
    {
        $related = 'App\Model\helpdesk\Ticket\TicketCategory';
        $foreignKey = 'concluded_category';
        return $this->belongsTo($related, $foreignKey, 'id');
    }

    public function formdata()
    {
        return $this->hasMany('App\Model\helpdesk\Ticket\Ticket_Form_Data', 'ticket_id');
    }

    public function extraFields()
    {
        $id = $this->attributes['id'];
        $ticket_form_datas = \App\Model\helpdesk\Ticket\Ticket_Form_Data::where('ticket_id', '=', $id)->get();

        return $ticket_form_datas;
    }

    public function source()
    {
        $source_id = $this->attributes['source'];
        $sources = new Ticket_source();
        $source = $sources->find($source_id);

        return $source;
    }

    public function sourceCss()
    {
        $css = 'fa fa-comment';
        $source = $this->source();
        if ($source) {
            $css = $source->css_class;
        }

        return $css;
    }

    public function delete()
    {
        $this->thread()->delete();
        $this->collaborator()->delete();
        $this->formdata()->delete();
        parent::delete();
    }

    public function setAssignedToAttribute($value)
    {
        if (!$value) {
            $this->attributes['assigned_to'] = null;
        } else {
            $this->attributes['assigned_to'] = $value;
        }
    }

    public function getAssignedTo()
    {
        $agentid = $this->attributes['assigned_to'];
        if ($agentid) {
            $users = new \App\User();
            $user = $users->where('id', $agentid)->first();
            if ($user) {
                return $user;
            }
        }
    }

    public function user()
    {
        $related = "App\User";
        $foreignKey = 'user_id';

        return $this->belongsTo($related, $foreignKey);
    }

    public function statuses()
    {
        $related = 'App\Model\helpdesk\Ticket\Ticket_Status';
        $foreignKey = 'status';

        return $this->belongsTo($related, $foreignKey);
    }

    /**
     * gets the department details for which ticket is mapped in.
     */
    public function department()
    {
        $related = 'App\Model\helpdesk\Agent\Department';
        $foreignKey = 'dept_id';

        return $this->belongsTo($related, $foreignKey);
    }

    public function assigned()
    {
        $related = 'App\User';
        $foreignKey = 'assigned_to';

        return $this->belongsTo($related, $foreignKey);
    }

    public function assignedTeam()
    {
        $related = 'App\Model\helpdesk\Agent\Teams';
        $foreignKey = 'team_id';

        return $this->belongsTo($related, $foreignKey)->withDefault();
    }

    public function priority()
    {
        $related = 'App\Model\helpdesk\Ticket\Ticket_Priority';
        $foreignKey = 'priority_id';

        return $this->belongsTo($related, $foreignKey);
    }

    public function sources()
    {
        return $this->belongsTo('App\Model\helpdesk\Ticket\Ticket_source', 'source');
    }

    public function slaPlan()
    {
        return $this->belongsTo(\App\Model\helpdesk\Manage\Sla_plan::class, 'sla');
    }

    public function threadSelectedFields()
    {
        return $this->hasOne('App\Model\helpdesk\Ticket\Ticket_Thread', 'ticket_id')->addSelect(
            'ticket_id',
            \DB::raw('substring_index(group_concat(title order by id asc SEPARATOR "-||,||-") , "-||,||-", 1) as title'),
            \DB::raw('substring_index(group_concat(if(`is_internal` = 0, `poster`,null)ORDER By id desc) , ",", 1) as poster'),
            \DB::raw('CONVERT_TZ(max(updated_at), "+00:00", "'.getGMT().'") as updated_at2')
        )->where('is_internal', '=', 0)->groupBy('ticket_id');
    }

    public function getTicketSubjectAttribute()
    {
        $ticket_thread = $this->thread()->where('poster', 'client')->first();
        return $ticket_thread->title ?? 'N/A';
    }

    public function getLastActivityAttribute()
    {
        $activity = $this->thread()->where('ticket_id', $this->id)->orderBy('id', 'DESC')->first();
        if(is_null($activity)) return $this->created_at;
        return $activity->created_at;
    }

    public function immigrationOffice()
    {
        $related = 'App\ImmigrationOffice';
        $foreignKey = 'immigration_office_id';
        $owner_key = 'Key';

        return $this->belongsTo($related, $foreignKey, $owner_key);
    }

    public function getImmigrationOfficeNameAttribute()
    {
        $name = null;

        if($this->immigrationOffice()->exists()) $name = $this->immigrationOffice->Office .' ('. $this->immigrationOffice->OfficeType .')';

        return $name;
    }

    public function getOwnerAttribute()
    {
        // $this->
        $name = $this->user->full_name ." <". $this->user->email .">";
        return $name;
    }

    public function getAssignedToNameAttribute()
    {
        $name = null;
        $assinged_user = $this->getAssignedTo();
        if(!is_null($assinged_user)) $name =  $assinged_user->full_name ." <".  $assinged_user->email .">";
        return $name;
    }

    public function getStatusNameAttribute()
    {
        return $this->statuses->name;
    }

    public function getHelpTopicNameAttribute()
    {
        return $this->helptopic->topic;
    }

    static function getEscalatedTicketCount()
    {
        return Tickets::where('escalated', '!=', 1)->where('escalated', '=', auth()->user()->management_level)->count();
    }

    public function assignedto()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

}
