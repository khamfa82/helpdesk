<?php

namespace App\Http\Controllers\Agent\helpdesk;

use App\Http\Controllers\Controller;
use App\Http\Requests\helpdesk\TicketTransactionRequest;
use App\Model\helpdesk\Ticket\Tickets;
use App\TicketTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ticket_id = $request->get('ticket_id');
        if ($ticket_id) {
            $ticket_transactions = TicketTransaction::where('ticket_id', $ticket_id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'initiated_by' => $transaction->initiator->first_name . " " . $transaction->initiator->last_name,
                        'assigned_to' => $transaction->assigned->first_name . " " . $transaction->assigned->last_name,
                        'transaction_by' => $transaction->transactor->first_name . " " . $transaction->transactor->last_name,
                        'transaction_status' => $transaction->status->name,
                        'created_at' => $transaction->created_at->format('d-m-Y H:i:s')
                    ];
            });

            $ticket_lead_times = TicketTransaction::where('ticket_id', $ticket_id)
                ->select(
                    '*', 
                    DB::raw('datediff(max(created_at), min(created_at)) as totaldiff'), 
                    DB::raw('min(created_at) as started_at'), 
                    DB::raw('max(created_at) as closed_at')
                )
                ->groupBy('assigned_to')
                ->get()
                ->map(function ($transaction) {
                    return [
                        'id' => $transaction->id,
                        'initiated_by' => $transaction->initiator->first_name . " " . $transaction->initiator->last_name,
                        'assigned_to' => $transaction->assigned->first_name . " " . $transaction->assigned->last_name,
                        'transaction_by' => $transaction->transactor->first_name . " " . $transaction->transactor->last_name,
                        'transaction_status' => $transaction->status->name,
                        'lead_time' => $transaction->totaldiff,
                        'started_at' => $transaction->started_at,
                        'closed_at' => $transaction->closed_at,
                        'organization' => $transaction->assigned->organization['name'] ?? "N/A"
                    ];
            });

            return response()->json([
                'transactions' => $ticket_transactions,
                'lead_times' => $ticket_lead_times   
            ]);
        } else {
            return response()->json(['error' => 'Ticket ID is required!']);
        }
    }

    /**
     * Store a ticket transaction.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveTransaction($ticket_id, $initiated_by, $assigned_to, $transaction_status)
    {
        $transaction = new TicketTransaction;
        $transaction->ticket_id = $ticket_id;
        $transaction->initiated_by = $initiated_by;
        $transaction->assigned_to = $assigned_to;
        $transaction->transaction_by = auth()->user()->id;
        $transaction->transaction_status = $transaction_status;
        $transaction->save();
    }

    /**
     * Get the last person to be assigned ticket
     * 
     * @param $ticket_id
     * @return $user_id
     */
    public function getLastUserAssigned($ticket_id)
    {
        $ticket = Tickets::where('id', '=', $ticket_id)->first();
        $ticket_transaction = TicketTransaction::where('ticket_id', $ticket_id);
        if ($ticket_transaction->exists())
            return $ticket_transaction->orderBy('created_at', 'desc')->first()->assigned_to;
        return $ticket->assigned_to;
    }

}
