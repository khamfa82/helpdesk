<?php

namespace App\Http\Controllers\Agent\helpdesk\Reports;

use App\Http\Controllers\Agent\helpdesk\ReportController;
use App\Http\Controllers\Controller;
use App\Model\helpdesk\Agent_panel\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrmReportController extends ReportController
{
    private function crm_base_ticket($weeks, $year, $date_column)
    {
        return DB::table('tickets as t')
                // ->join('ticket_thread as tt', 'tt.ticket_id', 't.id')
                ->join('users as u', 't.assigned_to', 'u.id')
                ->join('organization as o', 'u.organization_id', 'o.id')
                ->selectRaw("
                    count(t.id) as count,
                    week(t.$date_column) as week,
                    o.id as assigned_to
                ")
                ->whereRaw("week(t.$date_column) in (?,?,?,?,?,?,?,?,?,?,?,?,?)", $weeks)
                ->whereYear('t.' . $date_column . '', $year)
                ->where('t.is_deleted', 0);
    }
    
    private function crm_base_ticket_from_beginning(
        $weeks, 
        $year, 
        $date_column, 
        $filter_column, 
        $filter_value, 
        $organizationIds,
        $untilWeekBefore = false
    ) {
        $tickets = [];
        foreach ($weeks as $week) {

            $ticket = DB::table('tickets as t')
                    ->leftJoin('users as u', 't.assigned_to', 'u.id')
                    ->leftJoin('organization as o', 'u.organization_id', 'o.id')
                    ->selectRaw("
                        case 
                            when STR_TO_DATE('$year $week Sunday 23 59', '%X %V %W %H %i') < curdate() 
                            then count(distinct t.id) 
                            else 0 
                        end as count,
                        week(STR_TO_DATE('$year $week Sunday 23 59', '%X %V %W %H %i')) as week,
                        o.id as assigned_to
                    ")
                    ->whereRaw("date(t.$date_column) < STR_TO_DATE('$year " . ($week + ($untilWeekBefore ? 0 : 1)) . " Sunday 23 59', '%X %V %W %H %i')")
                    ->where('t.is_deleted', 0);
                    
                    if (!is_null($filter_column) && !is_null($filter_value))
                        $ticket = $ticket->where("t.$filter_column", $filter_value);
                    
                    $ticket = $ticket->whereIn('o.id', $organizationIds)->first();

            array_push($tickets, [
                "week" => $ticket->week ?? 0,
                "count" => $ticket->count ?? 0,
            ]);
        }
        return $tickets;
    }
    
    private function crm_base_ticket_on_that_week($weeks, $year, $date_column, $filter_column, $filter_value, $organizationIds)
    {
        $tickets = [];
        foreach ($weeks as $week) {

            $ticket = DB::table('tickets as t')
                    ->leftJoin('users as u', 't.assigned_to', 'u.id')
                    ->leftJoin('organization as o', 'u.organization_id', 'o.id')
                    ->selectRaw("
                        case 
                            when STR_TO_DATE('$year $week Sunday 23 59', '%X %V %W %H %i') < curdate() 
                            then count(distinct t.id) 
                            else 0 
                        end as count,
                        week(STR_TO_DATE('$year $week Sunday 23 59', '%X %V %W %H %i')) as week,
                        o.id as assigned_to
                    ")
                    ->whereRaw("date(t.$date_column) >= STR_TO_DATE('$year " . ($week + 0) . " Monday 00 00', '%X %V %W %H %i')")
                    ->whereRaw("date(t.$date_column) <= STR_TO_DATE('$year " . ($week + 1) . " Sunday 23 59', '%X %V %W %H %i')")
                    ->where('t.is_deleted', 0);
                    
                    if (!is_null($filter_column) && !is_null($filter_value))
                        $ticket = $ticket->where("t.$filter_column", $filter_value);
                    
                    $ticket = $ticket->whereIn('o.id', $organizationIds)
                    ->first();

            array_push($tickets, [
                "week" => $ticket->week ?? 0,
                "count" => $ticket->count ?? 0,
            ]);
        }
        return $tickets;
    }
    
    
    private function crm_base_ticket_lead_time(
        $weeks, 
        $year, 
        $organizationIds, 
        $optionalCondition, 
        $optionalConditionValue,
        $leadTimeColumn
        )
    {
        $tickets = DB::table('tickets as t')
                ->join('ticket_thread as tt', 'tt.ticket_id', '=', 't.id')
                ->join('users as u', 't.assigned_to', '=', 'u.id')
                ->join('organization as o', 'u.organization_id', '=', 'o.id')
                ->selectRaw("
                    count(distinct t.ticket_number) as ticket_count,
                    min(tt.created_at) as created_at,
                    t.updated_at,
                    t.closed_at,
                    total_weekdays(
                        $leadTimeColumn, t.created_at
                    ) as lead_time,
                    week(t.closed_at) as week
                ")
                // ->whereRaw('week(tt.created_at) in (?,?,?,?,?,?,?,?,?,?,?,?,?)', $weeks)
                // ->whereYear('tt.created_at', $year)
                ->whereIn('o.id', $organizationIds)
                ->where('t.is_deleted', 0)
                ->where($optionalCondition, $optionalConditionValue)
                ->groupBy('t.ticket_number')
                ->havingRaw("week($leadTimeColumn) in (?,?,?,?,?,?,?,?,?,?,?,?,?)", $weeks)
                ->havingRaw("year($leadTimeColumn) = ?", [$year])
                ->orderBy('week', 'asc')
                ->get();

        // return $tickets;

        $week_set = 0;
        $week_tmp = 0;
        $ticket_tmp = [];
                
        $grouped_tickets = [];
        $ticket_count = 0;
        $lead_time = 0;
        $ticket_count_and_lead_time = 0;

        foreach($tickets as $ticket) {
            if ($week_set == 0) {
                $week_set = 1;
                $week_tmp = $ticket->week;
            }

            if ($ticket->week != $week_tmp) {
                $ticket_tmp['average'] = $ticket_count != 0 ? ($ticket_count_and_lead_time / $ticket_count) : 0.00;
                array_push($grouped_tickets, $ticket_tmp);
                $week_tmp = $ticket->week;
                $ticket_tmp = [];
                $ticket_count = 0;
                $lead_time = 0;
                $ticket_count_and_lead_time = 0;
            }

            $ticket_count += $ticket->ticket_count;
            $lead_time += $ticket->lead_time;
            $ticket_count_and_lead_time += ($ticket->lead_time * $ticket->ticket_count);
            
            $ticket_tmp['week'] = $ticket->week;
            $ticket_tmp['ticket_count'] = $ticket_count;
            $ticket_tmp['lead_time'] = $lead_time;
            $ticket_tmp['ticket_count_and_lead_time'] = $ticket_count_and_lead_time;
            $ticket_tmp['created_at'] = $ticket->created_at;
            $ticket_tmp['updated_at'] = $ticket->updated_at;
            $ticket_tmp['closed_at'] = $ticket->closed_at;
        }

        // Last data
        $ticket_tmp['average'] = $ticket_count != 0 ? ($ticket_count_and_lead_time / $ticket_count) : 0.00;
        array_push($grouped_tickets, $ticket_tmp);

        return $grouped_tickets;
    }

    public function get_weeks($quarter = 1)
    {
        $weeks = [];
        $count = 13;
        $max_week = $quarter * 13;
        while($count >= 1) {
            array_push($weeks, $max_week--);
            $count--;
        }
        sort($weeks);
        return $weeks; 
    }

    public function crm(Request $request)
    {  
        $fiscal_quarter = $request->get('fiscal_quarter');
        $start_date = $request->get('start_date');
        $year = $request->get('year');
        $months = [];
        $weeks = [];
        
        if ($fiscal_quarter == 1) $weeks = $this->get_weeks(1);
        if ($fiscal_quarter == 2) $weeks = $this->get_weeks(2);
        if ($fiscal_quarter == 3) $weeks = $this->get_weeks(3);
        if ($fiscal_quarter == 4) $weeks = $this->get_weeks(4);

        if ($fiscal_quarter) {
            
            $organizations = Organization::orderBy('name', 'desc')->get();
            $organizationIds = $organizations->pluck('id')->toArray();
                        
            $open_tickets_all =  $this->crm_base_ticket_on_that_week($weeks, $year, 'created_at', NULL, NULL, $organizationIds);
            $closed_tickets_all =  $this->crm_base_ticket_on_that_week($weeks, $year, 'closed_at', 'closed', 1, $organizationIds);
            $lead_time_to_closure_tickets_all = $this->crm_base_ticket_lead_time($weeks, $year, $organizationIds, 't.closed', 1, 't.closed_at');
            $lead_time_to_resolve_tickets_all = $this->crm_base_ticket_lead_time($weeks, $year, $organizationIds, 't.status', 2, 't.updated_at');
            $total_tickets_all = $this->crm_base_ticket_from_beginning($weeks, $year, 'created_at', NULL, NULL, $organizationIds);
            $total_closed_tickets_all = $this->crm_base_ticket_from_beginning($weeks, $year, 'closed_at', NULL, NULL, $organizationIds);
            
            $open_tickets = [];
            $closed_tickets = [];
            $total_tickets = [];
            $total_closed_tickets = [];
            $lead_time_to_closure_tickets = [];
            $lead_time_to_resolve_tickets = [];

            foreach ($organizations as $organization) {
                // open
                $tickets =  $this->crm_base_ticket_on_that_week($weeks, $year, 'created_at', NULL, NULL, array($organization->id));

                array_push( 
                    $open_tickets,
                    $tickets   
                );

                // closed 
                $tickets =  $this->crm_base_ticket_on_that_week($weeks, $year, 'closed_at', 'closed', 1, array($organization->id));

                array_push(
                    $closed_tickets,
                    $tickets
                );
                
                // total tickets
                $tickets =  $this->crm_base_ticket_from_beginning($weeks, $year, 'created_at', NULL, NULL, array($organization->id));

                array_push(
                    $total_tickets,
                    $tickets
                );
                
                // total closed 
                $tickets =  $this->crm_base_ticket_from_beginning($weeks, $year, 'closed_at', 'closed', 1, array($organization->id));
                
                array_push(
                    $total_closed_tickets,
                    $tickets
                );
                
                // lead time to closure
                $tickets =  $this->crm_base_ticket_lead_time($weeks, $year, array($organization->id), 't.closed', 1, 't.closed_at');
                
                array_push(
                    $lead_time_to_closure_tickets,
                    $tickets
                );
                
                // lead time to resolve
                $tickets =  $this->crm_base_ticket_lead_time($weeks, $year, array($organization->id), 't.status', 2, 't.updated_at'); 

                array_push(
                    $lead_time_to_resolve_tickets,
                    $tickets
                );
            }
        }

        $fiscal_quarter = 'Q' . $fiscal_quarter;

        return view('themes.default1.agent.helpdesk.report.crm-report-overview', compact(
            'open_tickets',
            'open_tickets_all',
            'closed_tickets',
            'closed_tickets_all',
            'total_tickets',
            'total_tickets_all',
            'total_closed_tickets',
            'total_closed_tickets_all',
            'lead_time_to_resolve_tickets_all',
            'lead_time_to_resolve_tickets',
            'lead_time_to_closure_tickets_all',
            'lead_time_to_closure_tickets',
            'fiscal_quarter',
            'weeks',
            'organizations',
            'start_date'
        ));
    }
}
