<?php

namespace App\Http\Controllers\Agent\helpdesk;

// controllers
use App\Http\Controllers\Controller;
use App\Model\helpdesk\Agent\Department;
use App\Model\helpdesk\Agent_panel\Organization;
use App\Model\helpdesk\Manage\Help_topic;
use App\Model\helpdesk\Settings\Ticket;
use App\Model\helpdesk\Ticket\Ticket_Priority;
use App\Model\helpdesk\Ticket\Ticket_Thread;
// request
use App\Model\helpdesk\Ticket\Tickets;
use App\Model\helpdesk\Utility\Priority;
use App\User;
use DateTime;
// Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
// classes
use PDF;

/**
 * ReportController
 * This controlleris used to fetch reports in the agent panel.
 *
 * @author      Ladybird <info@ladybirdweb.com>
 */
class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     * constructor to check
     * 1. authentication
     * 2. user roles
     * 3. roles must be agent.
     *
     * @return void
     */
    public function __construct()
    {
        // checking for authentication
        $this->middleware('auth');
        // checking if the role is agent
        $this->middleware('role.agent');
    }

    /**
     * Get the Report page.
     *
     * @return type view
     */
    public function index()
    {
        try {
            return view('themes.default1.agent.helpdesk.report.index');
        } catch (Exception $e) {
        }
    }

    public function graphical_reports(Request $request)
    {
        return view('themes.default1.agent.helpdesk.report.graphical-reports');
    }

    public function get_graphical_report_data(Request $request)
    {
        $report_type = $request->get('report_type');
        $start_date = $this->formatDateDB($request->get("start_date"));
        $end_date = $this->formatDateDB($request->get("end_date"));
        $open = $request->get('open');
        $closed = $request->get('closed');
        $reopened = $request->get('reopened');
        $help_topic = $request->get('help_topic');
        $priority = $request->get('priority');

        $report = [];

        if ($report_type == "report_help_topic") {
            $report = Tickets::selectRaw('help_topic_id, count(id) as ticket_count')
                            ->whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date);

            if ($closed == "true")
                $report = $report->where('closed', 1);
            if ($reopened == "true")
                $report = $report->where('reopened', 1);
            if ($open == "true")
                $report = $report->where(['closed' => 0, 'isanswered' => 0]);
            if ($help_topic)
                $report = $report->where('help_topic_id', $help_topic);

            $report = $report
                            ->groupBy('help_topic_id')->get()
                            ->map(function($help_topic) {
                                return [
                                    'label' => $help_topic->helptopic->topic,
                                    'data' => $help_topic->ticket_count
                                ];
                            });
            
            $data = $report
                        ->pluck('data')
                        ->toArray();
            
            $label = $report
                        ->pluck('label')
                        ->toArray();

            $report = [
                "label" => ["Report of Tickets per Help Topic"],
                "data" => [
                    "data" => $data,
                    "label" => $label
                ]
            ];
        }
        
        if ($report_type == "report_priority") {
            $report = Tickets::selectRaw('priority_id, count(id) as ticket_count')
                            ->whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date);

            if ($closed == "true")
                $report = $report->where('closed', 1);
            if ($reopened == "true")
                $report = $report->where('reopened', 1);
            if ($open == "true")
                $report = $report->where(['closed' => 0, 'isanswered' => 0]);
            if ($priority)
                $report = $report->where('priority_id', $priority);

            $report = $report
                            ->groupBy('priority_id')
                            ->orderBy('priority_id', 'asc')
                            ->get()
                            ->map(function($priority) {
                                return [
                                    'label' => $priority->priority->priority,
                                    'data' => $priority->ticket_count
                                ];
                            });

            $data = $report
                        ->pluck('data')
                        ->toArray();
            
            $label = $report
                        ->pluck('label')
                        ->toArray();

            $report = [
                "label" => ["Report of Tickets per Priority"],
                "data" => [
                    "data" => $data,
                    "label" => $label
                ]
            ];
        }
        
        if ($report_type == "report_help_topic_per_priority") {
            $report = Tickets::selectRaw('help_topic_id, count(id) as ticket_count')
                            ->whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date);

            if ($closed == "true")
                $report = $report->where('closed', 1);
            if ($reopened == "true")
                $report = $report->where('reopened', 1);
            if ($open == "true")
                $report = $report->where(['closed' => 0, 'isanswered' => 0]);
            if ($priority)
                $report = $report->where('priority_id', $priority);

            $report = $report
                            ->groupBy('help_topic_id')
                            ->orderBy('help_topic_id', 'asc')
                            ->get()
                            ->map(function($help_topic) use ($start_date, $end_date, $closed, $open, $reopened) {

                                return [
                                    'label' => $help_topic->helptopic->topic,
                                    'help_topic_id' => $help_topic->help_topic_id
                                ];
                            });

            $help_topics = $report
                        ->pluck('help_topic_id')
                        ->toArray();

            $priorities = Ticket_Priority::all();
            $priority_names = $priorities->pluck('priority')->toArray();
            $priority_ids = $priorities->pluck('priority_id')->toArray();
            
            $data_tmp = [];
            $total_data_tmp = [];
            foreach ($priority_ids as $priority_id) {
                foreach ($help_topics as $help_topic_id) {
                    $priorities = Tickets::selectRaw('priority_id, count(id) as ticket_count')
                        ->whereDate('created_at', '>=', $start_date)
                        ->whereDate('created_at', '<=', $end_date)
                        ->where('help_topic_id', $help_topic_id)
                        ->where('priority_id', $priority_id);
                    
                    if ($closed == "true")
                        $priorities = $priorities->where('closed', 1);
                    if ($reopened == "true")
                        $priorities = $priorities->where('reopened', 1);
                    if ($open == "true")
                        $priorities = $priorities->where(['closed' => 0, 'isanswered' => 0]);
                    
                    $priorities = $priorities->first();   
                    array_push($data_tmp, ((int) ($priorities->ticket_count ?? 0)));
                }
                
                array_push($total_data_tmp, $data_tmp);
                $data_tmp = [];
            }

            // $total_data_tmp = [[1, 3], [3, 1], [4, 2], [5, 0]];
            
            $label = $report
                        ->pluck('label')
                        ->toArray();

            // array_push($label, "Test Label");

            $report = [
                "label" => $label,
                "data" => [
                    "label" => $priority_names,
                    "data" => $total_data_tmp
                ]
            ];
        }
        
        if ($report_type == "report_priority_trend") {
            $report = Tickets::selectRaw('help_topic_id, count(id) as ticket_count, month(created_at) as month_created_at, created_at')
                            ->whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date);

            if ($closed == "true")
                $report = $report->where('closed', 1);
            if ($reopened == "true")
                $report = $report->where('reopened', 1);
            if ($open == "true")
                $report = $report->where(['closed' => 0, 'isanswered' => 0]);
            if ($priority)
                $report = $report->where('priority_id', $priority);

            $report = $report
                            ->groupBy('month_created_at')
                            ->orderBy('month_created_at', 'asc')
                            ->get()
                            ->map(function($ticket) {
                                $now = new DateTime($ticket->created_at);
                                return [
                                    'label' => $now->format('M'),
                                    'date' => $ticket->created_at,
                                    'data' => $ticket->month_created_at
                                ];
                            });

            $months = $report
                        ->pluck('data')
                        ->toArray();

            $priorities = Ticket_Priority::all();
            $priority_names = $priorities->pluck('priority')->toArray();
            $priority_ids = $priorities->pluck('priority_id')->toArray();
            
            $data_tmp = [];
            $total_data_tmp = [];
            foreach ($priority_ids as $priority_id) {
                foreach ($months as $month) {
                    $priorities = Tickets::selectRaw('priority_id, count(id) as ticket_count')
                        ->whereMonth('created_at', '=', $month)
                        ->whereYear('created_at', '<=', $end_date)
                        ->where('priority_id', $priority_id);
                    
                    if ($closed == "true")
                        $priorities = $priorities->where('closed', 1);
                    if ($reopened == "true")
                        $priorities = $priorities->where('reopened', 1);
                    if ($open == "true")
                        $priorities = $priorities->where(['closed' => 0, 'isanswered' => 0]);
                    
                    $priorities = $priorities->first();   
                    array_push($data_tmp, ((int) ($priorities->ticket_count ?? 0)));
                }
                
                array_push($total_data_tmp, $data_tmp);
                $data_tmp = [];
            }

            $label = $report
                        ->pluck('label')
                        ->toArray();

            $report = [
                "label" => $label,
                "data" => [
                    "label" => $priority_names,
                    "data" => $total_data_tmp
                ]
            ];
        }
        
        if ($report_type == "report_lead_times") {
            $report = Tickets::join('ticket_transactions as tt', 'tt.ticket_id', '=', 'tickets.id')
                            ->join('users as u', 'u.id', '=', 'tt.assigned_to')
                            ->leftJoin('organization as o', 'o.id', '=', 'u.organization_id')
                            ->selectRaw('
                                            o.name as organization_name, 
                                            tt.assigned_to, 
                                            datediff(
                                                max(tt.created_at), min(tt.created_at)
                                            ) as ticket_count, 
                                            total_weekdays(
                                                max(tt.created_at), min(tt.created_at)
                                            ) as ticket_count2, 
                                            min(tt.created_at) as started_date, 
                                            max(tt.created_at) as end_date
                                        ')
                            ->whereDate('tickets.created_at', '>=', $start_date)
                            ->whereDate('tickets.created_at', '<=', $end_date)
                            ->groupBy('u.organization_id')
                            ->get()
                            ->map(function($lead_time) {
                                return [
                                    'label' => $lead_time->organization_name ?? "N/A",
                                    'data' => $lead_time->ticket_count2,
                                    'started_date' => $lead_time->started_date,
                                    'end_date' => $lead_time->end_date,
                                ];
                            });
            
            $data = $report
                        ->pluck('data')
                        ->toArray();
            
            $label = $report
                        ->pluck('label')
                        ->toArray();

            $report = [
                "label" => ["Report of Organizations per Lead Times (Number of days to close tickets)"],
                "data" => [
                    "data" => $data,
                    "label" => $label
                ]
            ];
        }

        if ($report_type == "report_lead_times_per_agent") {
            $report = Tickets::join('ticket_transactions as tt', 'tt.ticket_id', '=', 'tickets.id')
                            ->join('users as u', 'u.id', '=', 'tt.assigned_to')
                            ->leftJoin('organization as o', 'o.id', '=', 'u.organization_id')
                            ->selectRaw('
                                            o.name as organization_name, 
                                            tt.assigned_to, 
                                            datediff(
                                                max(tt.created_at), min(tt.created_at)
                                            ) as ticket_count, 
                                            total_weekdays(
                                                max(tt.created_at), min(tt.created_at)
                                            ) as ticket_count2, 
                                            min(tt.created_at) as started_date, 
                                            max(tt.created_at) as end_date
                                        ')
                            ->whereDate('tickets.created_at', '>=', $start_date)
                            ->whereDate('tickets.created_at', '<=', $end_date)
                            ->groupBy('tt.assigned_to')
                            ->get()
                            ->map(function($lead_time) {
                                return [
                                    'label' => $lead_time->assignedto->first_name . " " . $lead_time->assignedto->last_name . " (" . ($lead_time->organization_name ?? "N/A") . ")",
                                    'data' => $lead_time->ticket_count2,
                                    'started_date' => $lead_time->started_date,
                                    'end_date' => $lead_time->end_date,
                                ];
                            });
            
            $data = $report
                        ->pluck('data')
                        ->toArray();
            
            $label = $report
                        ->pluck('label')
                        ->toArray();
            
            // $started_date = $report
            //             ->pluck('started_date')
            //             ->toArray();
            
            // $end_date = $report
            //             ->pluck('end_date')
            //             ->toArray();

            $report = [
                "label" => ["Report of Lead Times per Agent (Organization)"],
                "data" => [
                    "data" => $data,
                    "label" => $label,
                    // "started_data" => $started_date,
                    // "end_date" => $end_date
                ]
            ];
        }

        // Show not found error message within a graph
        if (count($report['data']['data']) <= 0)
            $report = [
                "label" => ["No data has been found!"],
                "data" => [
                    "data" => [0],
                    "label" => ['No data']
                ]
            ];

        return response()->json([
            'reports' => $report
        ]);
    }

    public function user(Request $request)
    {
        $tickets = [];
        if (auth()->user()->role == 'agent') {
            $dept = Department::where('id', '=', auth()->user()->primary_dpt)->first();                 
            $tickets = Tickets::
                join('ticket_thread as tt', 'tt.ticket_id', 'tickets.id')
                ->selectRaw("
                    tickets.*,
                    tt.poster,
                    tt.ip_address,
                    tt.source,
                    tt.reply_rating,
                    tt.rating_count,
                    tt.is_internal,
                    tt.title,
                    tt.body,
                    tt.format
                ")
                ->where(function ($query) use ($dept) {
                    $query->where('tickets.dept_id', '=', $dept->id)
                        ->orWhere('tickets.assigned_to', auth()->user()->id);
                    })
                ->where('tickets.is_deleted', 0);
                
        } elseif (auth()->user()->role == 'admin') {
            $tickets = Tickets::
            join('ticket_thread as tt', 'tt.ticket_id', 'tickets.id')
            ->selectRaw("
                    tickets.*,
                    tt.poster,
                    tt.ip_address,
                    tt.source,
                    tt.reply_rating,
                    tt.rating_count,
                    tt.is_internal,
                    tt.title,
                    tt.body,
                    tt.format
                ")
                ->where('tickets.is_deleted', 0);
        }

        // Retreave inputs from request
        $assigned_user = $request->get("assigned_user");
        $thread_user = $request->get("thread_user");
        $help_topic = $request->get("help_topic");
        $start_date = $this->formatDateDB($request->get("start_date"));
        $end_date = $this->formatDateDB($request->get("end_date"));
        $open = $request->get("open");
        $reopened = $request->get("reopened");
        $closed = $request->get("closed");
        $overdue = $request->get("overdue");
        $answered = $request->get("answered");

        // Help topic and dates filter
        if ($help_topic)
            $tickets = $tickets->whereRaw('tickets.help_topic_id like ?', ['%' . $help_topic . '%']);
        if ($start_date)
            $tickets = $tickets->whereDate('tickets.created_at', '>=', $start_date);
        if ($end_date)
            $tickets = $tickets->whereDate('tickets.created_at', '<=', $end_date);
        
        // Users filter
        if ($assigned_user)
            $tickets = $tickets->whereRaw('tickets.assigned_to like ?', ['%' . $assigned_user . '%']);
        if ($thread_user)
            $tickets = $tickets->whereRaw('tt.user_id like ?', ['%' . $thread_user . '%']);
        
        // Status filter
        if ($overdue == 'on')
            $tickets = $tickets
            ->whereRaw('
                        DATE_FORMAT(tickets.duedate, "%Y %m %d") < DATE_FORMAT(NOW(), "%Y %m %d") and
                        tickets.isanswered = 0 and
                        tickets.closed = 0
                    ');
        if ($answered == 'on')
            $tickets = $tickets->where('tickets.isanswered', 1);
        if ($closed == 'on')
            $tickets = $tickets->where('tickets.closed', 1);
        if ($reopened == 'on')
            $tickets = $tickets->where('tickets.reopened', 1);
        if ($open == 'on')
            $tickets = $tickets->where(['tickets.closed' => 0, 'tickets.isanswered' => 0]);
        
        $tickets = $tickets
        ->orderBy('tickets.created_at', 'desc')
        ->groupBy('tickets.id')
        ->get();
        
        $data['tickets'] = $tickets;
        $data['assignedUsers'] = Ticket_Thread::
        join('tickets as t', 'ticket_thread.ticket_id', '=', 't.id')
        ->join('users as u', 't.assigned_to', '=', 'u.id')
        ->selectRaw('
            u.id as id,
            u.email as email
        ')
        ->groupByRaw('t.assigned_to')
        ->get();

        $data['users'] = Ticket_Thread::
        join('tickets as t', 'ticket_thread.ticket_id', '=', 't.id')
        ->join('users as u', 'ticket_thread.user_id', '=', 'u.id')
        ->selectRaw('
            u.id as id,
            u.email as email
        ')
        ->groupByRaw('ticket_thread.user_id')
        ->get();
        
        // dd($data['users']);
        // return response()->json($data['users']);
        try {
            session()->flashInput($request->input());
            return view('themes.default1.agent.helpdesk.report.users', $data);
        } catch (Exception $e) {
        }
    }

    public function user_show(Request $request, $user_id)
    {
        $tickets = [];
        if (auth()->user()->role == 'agent') {
            $dept = Department::where('id', '=', auth()->user()->primary_dpt)->first();                 
            $tickets = Tickets::
                join('ticket_thread as tt', 'tt.ticket_id', 'tickets.id')
                ->selectRaw("
                    tickets.*,
                    tt.poster,
                    tt.ip_address,
                    tt.source,
                    tt.reply_rating,
                    tt.rating_count,
                    tt.is_internal,
                    tt.title,
                    tt.body,
                    tt.format
                ")
                ->where(function ($query) use ($dept) {
                    $query->where('tickets.dept_id', '=', $dept->id)
                        ->orWhere('tickets.assigned_to', auth()->user()->id);
                    })
                ->where('tickets.is_deleted', 0);
                
        } elseif (auth()->user()->role == 'admin') {
            $tickets = Tickets::
            join('ticket_thread as tt', 'tt.ticket_id', 'tickets.id')
            ->selectRaw("
                    tickets.*,
                    tt.poster,
                    tt.ip_address,
                    tt.source,
                    tt.reply_rating,
                    tt.rating_count,
                    tt.is_internal,
                    tt.title,
                    tt.body,
                    tt.format
                ")
                ->where('tickets.is_deleted', 0);
        }

        // Retreave inputs from request
        $assigned_user = $request->get("assigned_user");
        $thread_user = $request->get("thread_user");
        $help_topic = $request->get("help_topic");
        $start_date = $this->formatDateDB($request->get("start_date"));
        $end_date = $this->formatDateDB($request->get("end_date"));
        $open = $request->get("open");
        $reopened = $request->get("reopened");
        $closed = $request->get("closed");
        $overdue = $request->get("overdue");
        $answered = $request->get("answered");

        // Help topic and dates filter
        if ($help_topic)
            $tickets = $tickets->whereRaw('tickets.help_topic_id like ?', ['%' . $help_topic . '%']);
        if ($start_date)
            $tickets = $tickets->whereDate('tickets.created_at', '>=', $start_date);
        if ($end_date)
            $tickets = $tickets->whereDate('tickets.created_at', '<=', $end_date);
        
        // Users filter
        if ($assigned_user)
            $tickets = $tickets->whereRaw('tickets.assigned_to like ?', ['%' . $user_id . '%']);
        if ($thread_user)
            $tickets = $tickets->whereRaw('tt.user_id like ?', ['%' . $user_id . '%']);
        
        // Status filter
        if ($overdue == 'on')
            $tickets = $tickets
            ->whereRaw('
                        DATE_FORMAT(tickets.duedate, "%Y %m %d") < DATE_FORMAT(NOW(), "%Y %m %d") and
                        tickets.isanswered = 0 and
                        tickets.closed = 0
                    ');
        if ($answered == 'on')
            $tickets = $tickets->where('tickets.isanswered', 1);
        if ($closed == 'on')
            $tickets = $tickets->where('tickets.closed', 1);
        if ($reopened == 'on')
            $tickets = $tickets->where('tickets.reopened', 1);
        if ($open == 'on')
            $tickets = $tickets->where(['tickets.closed' => 0, 'tickets.isanswered' => 0]);
        
        $tickets = $tickets
        ->orderBy('tickets.created_at', 'desc')
        ->groupBy('tickets.id')
        ->get();
        
        $data['tickets'] = (!$assigned_user && !$thread_user) ? [] : $tickets;
        
        // dd($data['users']);
        // return response()->json($data['users']);
        try {
            session()->flashInput($request->input());
            return view('themes.default1.agent.helpdesk.report.my-reports', $data);
        } catch (Exception $e) {
        }
    }

    public function formatDateDB($date)
    {
        $normalDate = explode('/', $date);
        return count($normalDate) > 1 ? ($normalDate[2] . '-' . $normalDate[1] . '-' . $normalDate[0])  : '';
    }

    public function get_stats($data = [])
    {
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];
        // $help_topic = $data['help_topic'];
        if($data['help_topic'] > 0) $help_topic = [$data['help_topic']];
        if($data['help_topic'] == 0) $help_topic = [1,2,3]; //Open,Resolved,Closed

        // // Created Tickets
        // $created_count = \DB::table('tickets')->select('created_at')->whereIn('help_topic_id', $help_topic)
        //     ->whereDate('created_at', '>=', $start_date)
        //     ->whereDate('created_at', '<=', $end_date)
        //     ->count();

        // // Closed Tickets
        // $closed_count = \DB::table('tickets')->select('closed_at')->whereIn('help_topic_id', $help_topic)
        //     ->whereDate('closed_at', '>=', $start_date)
        //     ->whereDate('closed_at', '<=', $end_date)
        //     ->count();

        // // Reopened Tickets
        // $reopened_count = \DB::table('tickets')->select('reopened_at')->whereIn('help_topic_id', $help_topic)
        //     ->whereDate('reopened_at', '>=', $start_date)
        //     ->whereDate('reopened_at', '<=', $end_date)
        //     ->count();

        $response = [
            'start_date'        => $start_date,
            'end_date'          => $end_date,
            'created_count'     => $created_count,
            'closed_count'      => $closed_count,
            'reopened_count'    => $reopened_count,
        ];

        // return Response::json($response);
        return $response;
    }

    public function open($period = null, Request $request)
    {
        // dd($request->get("open") );
        $ticket_status_Array = [];

        if( is_null($request->get("status_open")) && is_null($request->get("status_resolved")) && is_null($request->get("status_closed")) && is_null($request->get("status_reopened")) )
        {
            $ticket_status_Array = [1,2,3]; //Open,Resolved,Closed
            $data['status_open'] = 0;
            $data['status_resolved'] = 0;
            $data['status_closed'] = 0;
            $data['status_reopened'] = 0;
        }

        if(!is_null($request->get("status_open"))) {
            $ticket_status_Array[] = 1;
            $data['status_open'] = 1;
        }else{
            $data['status_open'] = 0;
        }

        if(!is_null($request->get("status_resolved"))) {
            $ticket_status_Array[] = 2;
            $data['status_resolved'] = 1;
        }else{
            $data['status_resolved'] = 0;
        }

        if(!is_null($request->get("status_closed"))) {
            $ticket_status_Array[] = 3;
            $data['status_closed'] = 1;
        }else{
            $data['status_closed'] = 0;
        }

        if(!is_null($request->get("status_reopened"))) {
            $ticket_status_Array[] = 1;
            $data['status_reopened'] = 1;
        }else{
            $data['status_reopened'] = 0;
        }

        // dd('ticket_status_Array', $ticket_status_Array);

        $tickets = [];
        if (auth()->user()->role == 'agent') {
            $dept = Department::where('id', '=', auth()->user()->primary_dpt)->first();                 
            $tickets = Tickets::
                join('ticket_thread as tt', 'tt.ticket_id', 'tickets.id')
                ->selectRaw("
                    tickets.*,
                    tt.poster,
                    tt.ip_address,
                    tt.source,
                    tt.reply_rating,
                    tt.rating_count,
                    tt.is_internal,
                    tt.title,
                    tt.body,
                    tt.format
                ")
                ->where(function ($query) use ($dept) {
                    $query->where('tickets.dept_id', '=', $dept->id)
                        ->orWhere('tickets.assigned_to', auth()->user()->id);
                    })
                ->where('tickets.closed', 0)
                // ->where('reopened', 1)
                ->where('tickets.is_deleted', 0);
                
        } elseif (auth()->user()->role == 'admin') {
            $tickets = Tickets::
            join('ticket_thread as tt', 'tt.ticket_id', 'tickets.id')
            ->selectRaw("
                    tickets.*,
                    tt.poster,
                    tt.ip_address,
                    tt.source,
                    tt.reply_rating,
                    tt.rating_count,
                    tt.is_internal,
                    tt.title,
                    tt.body,
                    tt.format
                ")
                // ->where('tickets.closed', 0)
                // ->where('reopened', 1)
                ->where('tickets.is_deleted', 0)
                ->whereIn('tickets.status', $ticket_status_Array);

        }


        // Retreave inputs from request
        $help_topic = $request->get("help_topic");
        $start_date = $this->formatDateDB($request->get("start_date"));
        $end_date = $this->formatDateDB($request->get("end_date"));
        // dd($request->get("end_date"), $end_date);

        if ($help_topic && $help_topic > 0) $tickets = $tickets->whereRaw('tickets.help_topic_id like ?', ['%' . $help_topic . '%']);
        if ($start_date) $tickets = $tickets->whereDate('tickets.created_at', '>=', $start_date);
        if ($end_date) $tickets = $tickets->whereDate('tickets.created_at', '<=', $end_date);

        // dd($tickets->whereIn('tickets.status', [3])->count());
        // $copy = clone $obj;

        // $all_count = clone $tickets;
        // $stats_array['all_tickets_count'] = $all_count->count();
        // // dd($start_date);
        // unset($all_count);

        // $created_count = clone $tickets;
        // $stats_array['created_count'] = $created_count->whereIn('tickets.status', [1])->count();
        // unset($created_count);

        // $resolved_count =  clone $tickets;
        // $stats_array['resolved_count'] = $resolved_count->whereIn('tickets.status', [2])->count();
        // unset($resolved_count);

        // $closed_count = clone $tickets;
        // $stats_array['closed_count'] = $closed_count->whereIn('tickets.status', [3])->count();
        // $stats_array['reopened_count'] = 0;
        // unset($closed_count);

        // dd($stats_array);

        $tickets = $tickets
            ->whereIn('tickets.status', $ticket_status_Array)
            ->orderBy('tickets.created_at', 'desc')
            ->groupBy('tickets.id');
        
        $tickets = $tickets->get();

        $stats_array = [
            'all_tickets_count' => 0,
            'created_count' => 0,
            'resolved_count' => 0,
            'closed_count' => 0,
            'reopened_count' => 0
        ];

        foreach($tickets as $ticket){
            // dd($ticket);
            $stats_array['all_tickets_count'] += 1;
            if($ticket->status == 1) $stats_array['created_count'] += 1;
            if($ticket->status == 2) $stats_array['resolved_count'] += 1;
            if($ticket->status == 3) $stats_array['closed_count'] += 1;

        }

        $array_data['start_date'] = $start_date;
        $array_data['end_date'] = $end_date;
        $array_data['help_topic'] = $help_topic;

        // $stats_array = self::get_stats($array_data);
        // dd($stats_array);
        // dd($tickets[1]->status_name);

        // $tickets = DB::select(
        //     DB::raw("CALL spGetOpenTicketsPerDept(:dept_name)"),
        //     [':dept_name' => $dept_name]
        //   );
        // echo('
        //     THIS PAGE IS UNDER CONSTRUCTION...<br /><br />
        //     <button onclick="goBack()">Go Back</button>
        
        //     <script>
        //         function goBack() {
        //         window.history.back();
        //         }
        //     </script>
        // ');
        // die;

        $data['help_topic_val'] = $help_topic;
        $data['start_date_val'] = $request->get("start_date");
        $data['end_date_val'] = $request->get("end_date");
        $data['tickets'] = $tickets;
        $data['stats_array'] = $stats_array;

        if($request->has('download_pdf')){
            $table_datas = json_decode($request->input('pdf_form'));
            $data['table_datas'] = $table_datas;
            // dd(100);
            // $pdf = \PDF::loadView('findhouses', $data)
            //         ->setPaper('a4')
            //         ->setOption("footer-right", "Page [page] of [topage]");

            // $PDF_title = 'helpdesk-report-'.'-'.date('Y-M-d');
            $PDF_title = 'report_'. $data['start_date_val'] .'_to_'. $data['start_date_val'] . '_' .uniqid();

            //   return $pdf->download($PDF_title.'.pdf');

            $pdf = PDF::loadView('themes.default1.agent.helpdesk.report.pdf_open', $data);
            // $pdf->set_paper('letter', 'landscape');
            $pdf->setPaper('A2', 'landscape');
    
            return $pdf->stream($PDF_title);
        }

        if($request->has('download_spreadsheet'))
        {
            try {
                $ticketsArray = [];
                $sn_excel = 1;
                foreach($tickets as $key => $ticket ){
                    $ticketArray = [];
    
                    $ticketArray["#"] = $sn_excel++;
                    $ticketArray["Ticket_Number"] = $ticket->ticket_number;
                    $ticketArray["Help_Topic"] = $ticket->help_topic_name;
                    $ticketArray["Description"] = $ticket->ticket_subject;
                    $ticketArray["Status"] = $ticket->status_name;
                    $ticketArray["Created_by"] = $ticket->owner;
                    $ticketArray["Assignee"] = $ticket->assigned_to_name;
                    $ticketArray["Date_Created"] = date("d-F-Y H:i", strtotime($ticket->created_at));
                    $ticketArray["Last_Activity"] = date("d-F-Y H:i", strtotime($ticket->last_activity));
                    $ticketArray["Remarks"] = "";
    
                    $ticketsArray[] = $ticketArray;
                }
    
                $date = $request->input('start_date');
                $date = str_replace(' ', '', $date);
                $date_array = explode(':', $date);
                $first = $date_array[0].' 00:00:00';
                $second = $request->input('end_date').' 23:59:59';
                $first_date = date('Y-m-d H:i:s', strtotime($first));
                $second_date = date('Y-m-d H:i:s', strtotime($second));
                $excel_controller = new \App\Http\Controllers\Common\ExcelController();
                $filename = 'report_'. $data['start_date_val'] .'_to_'. $data['start_date_val'] . '_' .uniqid();

                $excel_controller->export($filename, $ticketsArray);
            } catch (Exception $ex) {
                return redirect()->back()->with('fails', $ex->getMessage());
            }
        }

        try {
            return view('themes.default1.agent.helpdesk.report.open', $data);
        } catch (Exception $e) {
        }
    }

    public function periodic(Request $request)
    {
        echo('
            THIS PAGE IS UNDER CONSTRUCTION...<br /><br />
            <button onclick="goBack()">Go Back</button>
        
            <script>
                function goBack() {
                window.history.back();
                }
            </script>
        ');
        die;
    }

    /**
     * function to get help_topic graph.
     *
     * @param type $date111
     * @param type $date122
     * @param type $helptopic
     */
    public function chartdataHelptopic(Request $request, $date111 = '', $date122 = '', $helptopic = '')
    {
        $date11 = strtotime($date122);
        $date12 = strtotime($date111);
        $help_topic = $helptopic;
        $duration = $request->input('duration');
        if ($date11 && $date12 && $help_topic) {
            $date2 = $date12;
            $date1 = $date11;
            $duration = null;
            if ($request->input('open') == null || $request->input('closed') == null || $request->input('reopened') == null || $request->input('overdue') == null || $request->input('deleted') == null) {
                $duration = 'day';
            }
        } else {
            // generating current date
            $date2 = strtotime(date('Y-m-d'));
            $date3 = date('Y-m-d');
            $format = 'Y-m-d';
            // generating a date range of 1 month
            if ($request->input('duration') == 'day') {
                $date1 = strtotime(date($format, strtotime('-15 day'.$date3)));
            } elseif ($request->input('duration') == 'week') {
                $date1 = strtotime(date($format, strtotime('-69 days'.$date3)));
            } elseif ($request->input('duration') == 'month') {
                $date1 = strtotime(date($format, strtotime('-179 days'.$date3)));
            } else {
                $date1 = strtotime(date($format, strtotime('-30 days'.$date3)));
            }
//            $help_topic = Help_topic::where('status', '=', '1')->min('id');
        }

        $return = '';
        $last = '';
        $j = 0;
        $created1 = 0;
        $closed1 = 0;
        $reopened1 = 0;
        $in_progress = \DB::table('tickets')->where('help_topic_id', '=', $help_topic)->where('status', '=', 1)->count();

        for ($i = $date1; $i <= $date2; $i = $i + 86400) {
            $j++;
            $thisDate = date('Y-m-d', $i);
            $thisDate1 = date('jS F', $i);
            $open_array = [];
            $closed_array = [];
            $reopened_array = [];

            if ($request->input('open') || $request->input('closed') || $request->input('reopened')) {
                if ($request->input('open') && $request->input('open') == 'on') {
                    $created = \DB::table('tickets')->select('created_at')->where('help_topic_id', '=', $help_topic)->where('created_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $open_array = ['open' => $created];
                }
                if ($request->input('closed') && $request->input('closed') == 'on') {
                    $closed = \DB::table('tickets')->select('closed_at')->where('help_topic_id', '=', $help_topic)->where('closed_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $closed_array = ['closed' => $closed];
                }
                if ($request->input('reopened') && $request->input('reopened') == 'on') {
                    $reopened = \DB::table('tickets')->select('reopened_at')->where('help_topic_id', '=', $help_topic)->where('reopened_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $reopened_array = ['reopened' => $reopened];
                }
//                if ($request->input('overdue') && $request->input('overdue') == 'on') {
//                    $overdue = Tickets::where('status', '=', 1)->where('isanswered', '=', 0)->where('dept_id', '=', $dept->id)->orderBy('id', 'DESC')->get();
//                }
//                        $open_array = ['open'=>$created1];
//                        $closed_array = ['closed'=>$closed1];
//                        $reopened_array = ['reopened'=>$reopened1];
                $value = ['date' => $thisDate1];
//                        if($open_array) {
                $value = array_merge($value, $open_array);
                $value = array_merge($value, $closed_array);
                $value = array_merge($value, $reopened_array);
                $value = array_merge($value, ['inprogress' => $in_progress]);
//                        } else {
//                            $value = "";
//                        }
                $array = array_map('htmlentities', $value);
                $json = html_entity_decode(json_encode($array));
                $return .= $json.',';
            } else {
                if ($duration == 'week') {
                    $created = \DB::table('tickets')->select('created_at')->where('help_topic_id', '=', $help_topic)->where('created_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $created1 += $created;
                    $closed = \DB::table('tickets')->select('closed_at')->where('help_topic_id', '=', $help_topic)->where('closed_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $closed1 += $closed;
                    $reopened = \DB::table('tickets')->select('reopened_at')->where('help_topic_id', '=', $help_topic)->where('reopened_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $reopened1 += $reopened;
                    if ($j % 7 == 0) {
                        $open_array = ['open' => $created1];
                        $created1 = 0;
                        $closed_array = ['closed' => $closed1];
                        $closed1 = 0;
                        $reopened_array = ['reopened' => $reopened1];
                        $reopened1 = 0;
                        $value = ['date' => $thisDate1];
//                        if($open_array) {
                        $value = array_merge($value, $open_array);
                        $value = array_merge($value, $closed_array);
                        $value = array_merge($value, $reopened_array);
                        $value = array_merge($value, ['inprogress' => $in_progress]);
//                        } else {
//                            $value = "";
//                        }
                        $array = array_map('htmlentities', $value);
                        $json = html_entity_decode(json_encode($array));
                        $return .= $json.',';
                    }
                } elseif ($duration == 'month') {
                    $created_month = \DB::table('tickets')->select('created_at')->where('help_topic_id', '=', $help_topic)->where('created_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $created1 += $created_month;
                    $closed_month = \DB::table('tickets')->select('closed_at')->where('help_topic_id', '=', $help_topic)->where('closed_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $closed1 += $closed_month;
                    $reopened_month = \DB::table('tickets')->select('reopened_at')->where('help_topic_id', '=', $help_topic)->where('reopened_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $reopened1 += $reopened_month;
                    if ($j % 30 == 0) {
                        $open_array = ['open' => $created1];
                        $created1 = 0;
                        $closed_array = ['closed' => $closed1];
                        $closed1 = 0;
                        $reopened_array = ['reopened' => $reopened1];
                        $reopened1 = 0;
                        $value = ['date' => $thisDate1];

                        $value = array_merge($value, $open_array);
                        $value = array_merge($value, $closed_array);
                        $value = array_merge($value, $reopened_array);
                        $value = array_merge($value, ['inprogress' => $in_progress]);

                        $array = array_map('htmlentities', $value);
                        $json = html_entity_decode(json_encode($array));
                        $return .= $json.',';
                    }
                } else {
                    if ($request->input('default') == null) {
                        $help_topic = Help_topic::where('status', '=', '1')->min('id');
                    }
                    $created = \DB::table('tickets')->select('created_at')->where('help_topic_id', '=', $help_topic)->where('created_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $open_array = ['open' => $created];
                    $closed = \DB::table('tickets')->select('closed_at')->where('help_topic_id', '=', $help_topic)->where('closed_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $closed_array = ['closed' => $closed];
                    $reopened = \DB::table('tickets')->select('reopened_at')->where('help_topic_id', '=', $help_topic)->where('reopened_at', 'LIKE', '%'.$thisDate.'%')->count();
                    $reopened_array = ['reopened' => $reopened];
                    if ($j % 1 == 0) {
                        $open_array = ['open' => $created];
                        $created = 0;
                        $closed_array = ['closed' => $closed];
                        $closed = 0;
                        $reopened_array = ['reopened' => $reopened];
                        $reopened = 0;
                        $value = ['date' => $thisDate1];
                        if ($request->input('default') == null) {
                            $value = array_merge($value, $open_array);
                            $value = array_merge($value, $closed_array);
                            $value = array_merge($value, $reopened_array);
                            $value = array_merge($value, ['inprogress' => $in_progress]);
                        } else {
                            if ($duration == null) {
                                if ($request->input('open') == 'on') {
                                    $value = array_merge($value, $open_array);
                                }
                                if ($request->input('closed') == 'on') {
                                    $value = array_merge($value, $closed_array);
                                }
                                if ($request->input('reopened') == 'on') {
                                    $value = array_merge($value, $reopened_array);
                                }
                            } else {
                                $value = array_merge($value, $open_array);
                                $value = array_merge($value, $closed_array);
                                $value = array_merge($value, $reopened_array);
                                $value = array_merge($value, ['inprogress' => $in_progress]);
                            }
                        }

//                        } else {
//                            $value = "";
//                        }
                        $array = array_map('htmlentities', $value);
                        $json = html_entity_decode(json_encode($array));
                        $return .= $json.',';
                    }
                }
            }

//            $value = ['date' => $thisDate];
//            if($open_array) {
//                $value = array_merge($value,$open_array);
//            }
//            if($closed_array) {
//                $value = array_merge($value,$closed_array);
//            }
//            if($reopened_array) {
//                $value = array_merge($value,$reopened_array);
//            }
        }
        $last = rtrim($return, ',');

        return '['.$last.']';
    }

    public function helptopicPdf(Request $request)
    {
        $table_datas = json_decode($request->input('pdf_form'));
        $table_help_topic = json_decode($request->input('pdf_form_help_topic'));
        // $html = view('themes.default1.agent.helpdesk.report.pdf', compact('table_datas', 'table_help_topic'))->render();
        // $html1 = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        //
        // return PDF::load($html1)->show();

        $data['table_datas'] = $table_datas;
        $data['table_help_topic'] = $table_help_topic;


        $pdf = PDF::loadView('themes.default1.agent.helpdesk.report.pdf', $data);
        return $pdf->stream('file.pdf');
    }

    public function openTicketPdf(Request $request)
    {
        $data = $request->json()->all(); 
        // dd($data);

        // $tickets = [];
        // if (\Auth::user()->role == 'agent') {
        //     $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();                 
        //     $tickets = Tickets::where(function ($query) use ($dept) {
        //             $query->where('dept_id', '=', $dept->id)
        //                 ->orWhere('assigned_to', Auth::user()->id);
        //             })
        //         ->where('closed', 0)
        //         // ->where('reopened', 1)
        //         ->where('is_deleted', 0)
        //         ->orderBy('id', 'desc')
        //         ->get();
        // } elseif (\Auth::user()->role == 'admin') {
        //     $tickets = Tickets::where('status', 1)
        //         ->where('closed', 0)
        //         // ->where('reopened', 1)
        //         ->where('is_deleted', 0)
        //         ->orderBy('id', 'desc')
        //         ->get();
        // }

        $tickets = [];
        if (auth()->user()->role == 'agent') {
            $dept = Department::where('id', '=', auth()->user()->primary_dpt)->first();                 
            $tickets = Tickets::
                join('ticket_thread as tt', 'tt.ticket_id', 'tickets.id')
                ->selectRaw("
                    tickets.*,
                    tt.poster,
                    tt.ip_address,
                    tt.source,
                    tt.reply_rating,
                    tt.rating_count,
                    tt.is_internal,
                    tt.title,
                    tt.body,
                    tt.format
                ")
                ->where(function ($query) use ($dept) {
                    $query->where('tickets.dept_id', '=', $dept->id)
                        ->orWhere('tickets.assigned_to', auth()->user()->id);
                    })
                ->where('tickets.closed', 0)
                // ->where('reopened', 1)
                ->where('tickets.is_deleted', 0);
                
        } elseif (auth()->user()->role == 'admin') {
            $tickets = Tickets::
            join('ticket_thread as tt', 'tt.ticket_id', 'tickets.id')
            ->selectRaw("
                    tickets.*,
                    tt.poster,
                    tt.ip_address,
                    tt.source,
                    tt.reply_rating,
                    tt.rating_count,
                    tt.is_internal,
                    tt.title,
                    tt.body,
                    tt.format
                ")
                ->where('tickets.status', 1)
                ->where('tickets.closed', 0)
                // ->where('reopened', 1)
                ->where('tickets.is_deleted', 0);
        }

        // Retreave inputs from request
        $help_topic = $request->get("help_topic");
        $start_date = $this->formatDateDB($request->get("start_date"));
        $end_date = $this->formatDateDB($request->get("end_date"));
        // dd($request->get("end_date"), $end_date);

        if ($help_topic) $tickets = $tickets->whereRaw('tickets.help_topic_id like ?', ['%' . $help_topic . '%']);
        if ($start_date) $tickets = $tickets->whereDate('tickets.created_at', '>=', $start_date);
        if ($end_date) $tickets = $tickets->whereDate('tickets.created_at', '<=', $end_date);
        
        $tickets = $tickets
            ->orderBy('tickets.created_at', 'desc')
            ->groupBy('tickets.id');
        $tickets = $tickets->get();

        $table_datas = json_decode($request->input('pdf_form'));
        // $table_help_topic = json_decode($request->input('pdf_form_help_topic'));
        // $html = view('themes.default1.agent.helpdesk.report.pdf', compact('table_datas', 'table_help_topic'))->render();
        // $html1 = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        //
        // return PDF::load($html1)->show();

        $data['table_datas'] = $table_datas;
        $data['table_data'] = [];
        $data['tickets'] = $tickets;

        // $data['table_help_topic'] = $table_help_topic;

        $data['start_date'] = json_decode($request->input('start_date'));
        $data['end_date'] = json_decode($request->input('end_date'));

        $pdf = PDF::loadView('themes.default1.agent.helpdesk.report.pdf_open', $data);
        // $pdf->set_paper('letter', 'landscape');
        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('file.pdf');
    }

    public function openTicketSpreadsheet(Request $request)
    {
        try {
            $tickets = [];
            if (\Auth::user()->role == 'agent') {
                $dept = Department::where('id', '=', Auth::user()->primary_dpt)->first();                 
                $tickets = Tickets::where(function ($query) use ($dept) {
                        $query->where('dept_id', '=', $dept->id)
                            ->orWhere('assigned_to', Auth::user()->id);
                        });
             

            } elseif (\Auth::user()->role == 'admin') {
                $tickets = Tickets::where('status', 1);
            }

            $tickets = $tickets->where('closed', 0)
                // ->where('reopened', 1)
                ->where('is_deleted', 0)
                ->orderBy('id', 'desc')
                // ->get(['ticket_number','assigned_to']);
                ->get();

                // ->toArray();

            $ticketsArray = [];
            foreach($tickets as $key => $ticket ){
                $ticketArray = [];

                $ticketArray["#"] = $key;
                $ticketArray["Ticket_Number"] = $ticket->ticket_number;
                $ticketArray["Date_Logged"] = date("d-F-Y H:i", strtotime($ticket->created_at));
                $ticketArray["Description"] = $ticket->ticket_subject; 
                $ticketArray["Status"] = $ticket->ticket_number;
                $ticketArray["Assignee"] = $ticket->assigned_to_name;
                $ticketArray["Due_Date"] = date("d-F-Y H:i", strtotime($ticket->last_activity));
                $ticketArray["Remarks"] = "";

                $ticketsArray[] = $ticketArray;
            }

            $date = $request->input('start_date');
            $date = str_replace(' ', '', $date);
            $date_array = explode(':', $date);
            $first = $date_array[0].' 00:00:00';
            $second = $request->input('end_date').' 23:59:59';
            $first_date = date('Y-m-d H:i:s', strtotime($first));
            $second_date = date('Y-m-d H:i:s', strtotime($second));
            $excel_controller = new \App\Http\Controllers\Common\ExcelController();
            $filename = 'open-tickets-report-'. date('Y-m-d');
            $excel_controller->export($filename, $ticketsArray);
        } catch (Exception $ex) {
            return redirect()->back()->with('fails', $ex->getMessage());
        }
    }

}
