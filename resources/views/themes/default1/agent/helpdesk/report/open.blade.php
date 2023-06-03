@extends('themes.default1.agent.layout.agent')

@section('sidebar')
<li class="header">{!! Lang::get('lang.Report') !!}</li>
<li>
    <a href="">
        <i class="fa fa-area-chart"></i> <span>{!! Lang::get('lang.help_topic') !!}</span> <small class="label pull-right bg-green"></small>
    </a>
</li>
<li>

</li>
@stop

@section('Report')
class="active"
@stop

@section('dashboard-bar')
active
@stop

@section('PageHeader')
<h1>{!! Lang::get('lang.report') !!}</h1>
@stop

@section('dashboard')
class="active"
@stop

@section('content')
<!-- check whether success or not -->
{{-- Success message --}}
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
{{-- failure message --}}
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>{!! Lang::get('lang.alert') !!}!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
<link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
{{-- <script src="{{asset("lb-faveo/dist/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script> --}}

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{!! Lang::get('lang.filter') !!} {!! Lang::get('lang.reports') !!}</h3>
    </div>
    <div class="box-body">
        <form id="report-form">
            <input type="hidden" name="duration" value="" id="duration">
            <input type="hidden" name="default" value="false" id="default">
            <div  class="form-group">
                <div class="row">
                    <div class='col-sm-3'>
                        {!! Form::label('helptopic', Lang::get('lang.help_topic')) !!}
                        <select name="help_topic" id="help_topic" class="form-control">
                            <?php $helptopics = App\Model\helpdesk\Manage\Help_topic::where('status', '=', '1')->get([ 'id', 'topic']); 
                            // dd($help_topic_val);
                            ?>
                                <option @if($help_topic_val == 0) selected @endif value="0">All</option>

                            @foreach($helptopics as $helptopic)
                                <option @if($help_topic_val == $helptopic->id) selected @endif value="{!! $helptopic->id !!}">{!! $helptopic->topic !!}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-sm-1' style="padding-right:0px;padding-left:0px">
                        <label>{!! Lang::get('lang.status') !!}</label>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">{!! Lang::get('lang.select') !!}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" id="stop"><input type="checkbox" name="status_open" id="status_open" @if($status_open == 1) checked @endif> {!! lang::get('lang.created') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                <li><a href="#" id="stop"><input type="checkbox" name="status_resolved" id="status_resolved" @if($status_open == 1) checked @endif> Resolved {!! lang::get('lang.tickets') !!}</a></li>
                                <li><a href="#" id="stop"><input type="checkbox" name="status_closed" id="status_closed" @if($status_closed == 1) checked @endif> {!! lang::get('lang.closed') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                <!-- <li><a href="#" id="stop"><input type="checkbox" name="status_reopened" id="status_reopened" @if($status_reopened == 1) checked @endif> {!! lang::get('lang.reopened') !!} {!! lang::get('lang.tickets') !!}</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class='col-sm-3 form-group' id="start_date">
                        {!! Form::label('date', Lang::get('lang.start_date')) !!}
                        {!! Form::text('start_date', $start_date_val, ['class'=>'form-control','id'=>'datepicker4','autocomplete' => 'off'])!!} 
                        <?php /* <input class="form-control" id="start_date" autocomplete="off" name="start_date" type="date" value="{{$start_date}}">*/ ?>

                    </div>
                    <?php
                    $start_date = App\Model\helpdesk\Ticket\Tickets::where('id', '=', '1')->first();
                    if ($start_date != null) {
                        $created_date = $start_date->created_at;
                        $created_date = explode(' ', $created_date);
                        $created_date = $created_date[0];
                        $start_date = date("m/d/Y", strtotime($created_date . ' -1 months'));
                    } else {
                        $start_date = date("m/d/Y", strtotime(date("m/d/Y") . ' -1 months'));
                    }
                    ?>
                    <script type="text/javascript">
                        $(function() {
                            var timestring1 = "{!! $start_date !!}";
                            var timestring2 = "{!! date('m/d/Y') !!}";
                            $('#datepicker4').datetimepicker({
                                format: 'DD/MM/YYYY',
                                minDate: moment(timestring1).startOf('day'),
                                maxDate: moment(timestring2).startOf('day')
                            });
                        });
                    </script>
                    <div class='col-sm-3 form-group' id="end_date">
                        <?php //dd($end_date); ?>
                        {!! Form::label('start_time', Lang::get('lang.end_date')) !!}
                        {!! Form::text('end_date', $end_date_val,['class'=>'form-control','id'=>'datetimepicker3','autocomplete' => 'off'])!!} 
                        <?php /* <input class="form-control" id="end_date" autocomplete="off" name="end_date" type="date" value="{{$end_date}}">*/ ?>
                    </div>
                    <script type="text/javascript">
                        $(function() {
                            var timestring1 = "{!! $start_date !!}";
                            var timestring2 = "{!! date('m/d/Y') !!}";
                            $('#datetimepicker3').datetimepicker({
                                format: 'DD/MM/YYYY',
                                minDate: moment(timestring1).startOf('day'),
                                maxDate: moment(timestring2).startOf('day')
                            });
                        });
                    </script>
                    <div class='col-sm-2'>
                        {!! Form::label('filter', 'Filter') !!}<br>
                        <input type="submit" class="btn btn-primary" value="Submit" id="submit">
                    </div>
                    {{-- <br/> --}}
                    <div class="col-sm-12">
                        {!! Form::label('generate', 'Generate') !!}<br>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">{!! Lang::get('lang.generate') !!}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <!-- <li><a href="#" id="pdf">{!! Lang::get('lang.generate_pdf') !!}</a></li> -->
                                <!-- <li><a href="#" id="xlxs">Generate Spreadsheet</a></li> -->

                                <li>
                                    <button name="download_spreadsheet" value="spreadsheet" form="report-form" class="btn "><i class="fa fa-download"></i> Download Spreadsheet</button>
                                </li>
                                <li>
                                    <button name="download_pdf" value="pdf" form="report-form" class="btn "><i class="fa fa-download"></i> Download PDF</button>
                                </li>
                            </ul>
                        </div>
                        <?php /*
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default" id="click_day">Day</button>
                                <button type="button" class="btn btn-default" id="click_week">Week</button>
                                <button type="button" class="btn btn-default" id="click_month">Month</button>
                            </div>
                        </div> */ ?>
                    </div>
                </div>

       
            </div>
        </form>
        <!--<div id="legendDiv"></div>-->
        <?php /*
        <div class="chart">
            <canvas class="chart-data" id="tickets-graph" width="1000" height="250"></canvas>
        </div>
        */ ?>
    </div><!-- /.box-body -->

</div><!-- /.box -->

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Tickets</h3>
    </div>
    <div class="box-body">
    <table width='100%'>
            <tr>
                <td>
                    <span style="color:#F7CF07;">TOTAL TICKETS</span> : {{$stats_array['all_tickets_count']}}
                </td>
                <td>
                    <span style="color:blue;">TOTAL OPEN</span>  : {{$stats_array['created_count']}}
                </td>
                <td>
                    <span style="color:orange;">TOTAL RESOLVED</span>  : {{$stats_array['resolved_count']}}
                </td>
                <td>
                    <span style="color:#00e765;">TOTAL CLOSED</span> : {{$stats_array['closed_count']}}
                </td>
            </tr>
        </table>
        <hr />

        <table class="table table-bordered no-footer" id="tickets_table">
            <thead>
                <tr>
                    <!-- <td><a class="checkbox-toggle"><i class="fa fa-square-o fa-2x"></i></a></td> -->
                    <td>S/N</td>
                    <td>{!! Lang::get('lang.subject') !!}</td>
                    <td>{!! Lang::get('lang.ticket_id') !!}</td>
                    <td>Help Topic</td>
                    <td>{!! Lang::get('lang.from') !!}</td>
                    <td>{!! Lang::get('lang.assigned_to') !!}</td>

                    <td>Status</td>
                    <!-- <td>Priority</td> -->

                    <td>{!! Lang::get('lang.last_activity') !!}</td>
                </tr>
            </thead>
            <tbody>
                <?php $sn=1; ?>
                @foreach($tickets as $ticket)
                    <?php //dd($ticket->owner) ?>
                    <tr>
                        <!-- <td><a class="checkbox-toggle"><i class="fa fa-square-o fa-2x"></i></a></td> -->
                        <td>{{$sn}}</td>
                        <td>{{$ticket->ticket_subject}}</td>
                        <td>
                            <button type="button" onclick="viewTicketDetails(`{{ json_encode($ticket) }}`)" class="btn btn-link m-0 p-0" data-toggle="modal" data-target="#ticketDetails">
                                {{ $ticket->ticket_number }}
                            </button>
                        </td>
                        <td>{{$ticket->help_topic_name}}</td>
                        <td>{{$ticket->owner}}</td>
                        <td>{{$ticket->assigned_to_name ?? $ticket->assigned_to}}</td>

                        <td>{{$ticket->status_name}}</td>

                        <!-- <td>
                            <span class="callout callout-{{$ticket->priority_color}}" style = 'background-color:{{$ticket->priority_color}}; color:#F9F9F9'>
                                {{$ticket->priority}}
                            </span>
                        </td> -->
                        <td>{{ date("d-F-Y H:i", strtotime($ticket->last_activity))}}</td>
                    </tr>
                    <?php $sn++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="ticketDetails" tabindex="-1" role="dialog" aria-labelledby="ticketDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header" style="height: 50px">
            <h5 class="modal-title" id="ticketDetailsLabel" style="width: 90%; float: left"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body table-responsive" style="clear: both">
            <div id="ticket-link"></div>
            <br>

            <div>
                <p class="bg-primary" style="padding: 10px; border-radius: 5px"><b>Assigned Agents with Lead Times</b></p>
                <table class="table table-bordered" id="transactions_table_lead">
                    <thead>
                        <tr>
                            <th>Initiated By</th>
                            <th>Assigned To</th>
                            <th>Organization</th></th>
                            <th>Started At</th>
                            <th>Closed At</th>
                            <th>Lead Time</th>
                        </tr>
                    </thead>
                    <tbody id="transactions-table-lead"></tbody>
                </table>
            </div>
            
            <br><br>
            <div>
                <p class="bg-primary" style="padding: 10px; border-radius: 5px"><b>Transactions</b></p>
                <table class="table table-bordered" id="transactions_table">
                    <thead>
                        <tr>
                            <th>Initiated By</th>
                            <th>Assigned To</th>
                            <th>Transaction By</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="transactions-table"></tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function viewTicketDetails(ticketDetails) {
        var ticket = JSON.parse(ticketDetails);
        var table = document.getElementById('transactions-table');
        var table_lead = document.getElementById('transactions-table-lead');
        var ticket_heading = document.getElementById('ticketDetailsLabel');
        var ticket_link = document.getElementById('ticket-link');

        ticket_heading.innerHTML = `Ticket transactions for ticket ${ticket.ticket_number}`;
        ticket_link.innerHTML = `<a href="/thread/${ticket.id}" target="_blank">Go to thread of ticket: ${ticket.ticket_number}</a><br/>`;
        // console.log(ticket.id);
        
        if ( $.fn.dataTable.isDataTable( '#transactions_table_lead' ) )
            dt_transaction_leads.destroy();
        
        if ( $.fn.dataTable.isDataTable( '#transactions_table' ) )
            dt_transactions.destroy();

        jQuery(document).ready(function() { 
            $.ajax({
                type: "GET",
                url: "/ticket-transactions?ticket_id="+ticket.id,
                beforeSend: function() {
                    table.innerHTML = "<tr><td colspan='5' class='text-center p-4'> Loading Transactions...</td></tr>";
                },
                success: function(response) {
                    if (response.error)
                        table.innerHTML = `<tr><td colspan='5' class="bg-danger text-center">Ticket ID is not defined</td></tr>`
                    
                    if (response.transactions.length == 0)
                        table.innerHTML = "<tr><td colspan='5' class='bg-danger text-center'>No transactions found!</td></tr>";
                    
                    if (response.lead_times.length == 0)
                        table_lead.innerHTML = "<tr><td colspan='5' class='bg-danger text-center'>No transactions found!</td></tr>";
                    
                    // console.log(response);

                    // Table for Lead Times
                    table_rows = '';
                    response.lead_times.forEach(transaction => {
                        table_rows += `
                            <tr>
                                <td>${transaction.initiated_by}</td>
                                <td>${transaction.assigned_to}</td>
                                <td>${transaction.organization}</td>
                                <td>${transaction.started_at}</td>
                                <td>${transaction.closed_at}</td>
                                <td>${transaction.lead_time} day(s)</td>
                                </tr>
                                `;
                    });
                    // closed_at = new Date(transaction.closed_at);
                    // <td>${closed_at.getDay() + "-" + (closed_at.getMonth() + 1) + "-" + closed_at.getFullYear() + " " + closed_at.getHours() + ":" + closed_at.getMinutes()}</td>
                    table_lead.innerHTML = table_rows;
                    table_rows = '';
                    
                    dt_transaction_leads = $('#transactions_table_lead').DataTable( {
                        "retrieve": true,
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    } );

                    // Table for transactions
                    response.transactions.forEach(transaction => {
                       table_rows += `
                            <tr>
                                <td>${transaction.initiated_by}</td>
                                <td>${transaction.assigned_to}</td>
                                <td>${transaction.transaction_by}</td>
                                <td>${transaction.transaction_status}</td>
                                <td>${transaction.created_at}</td>
                            </tr>
                        `;
                    });
                    table.innerHTML = table_rows;
                    table_rows = '';
                    
                    dt_transactions = $('#transactions_table').DataTable( {
                        "retrieve": true,
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    } );
                    
                }
            })
            return false;
        });
    }
</script>

<?php /*
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Tabular</h3>
    </div>
    <div class="box-body">
        <table class="table table-bordered" id="tabular">
        </table>
    </div>
</div>
*/ ?>
<form action="{!! route('report.open.pdf') !!}" method="POST" id="form_pdf">
    {!! Form::token() !!}
    <input type="hidden" name="pdf_form" value="" id="pdf_form">
    <!-- <input type="hidden" name="pdf_form_help_topic" value="" id="pdf_form_help_topic"> -->
    <input type="submit" style="display:none;">
</form>

<form action="{!! route('report.open.spreadsheet') !!}" method="POST" id="form_xlxs">
    {!! Form::token() !!}
    <input type="hidden" name="xlxs_form" value="" id="xlxs_form">
    <!-- <input type="hidden" name="pdf_form_help_topic" value="" id="pdf_form_help_topic"> -->
    <input type="submit" style="display:none;">
</form>

<div id="refresh">
    <script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>
</div>
<script src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script>

<script type="text/javascript">
    var result1a;
//    var help_topic_global;
    $(document).ready(function() {
    
        $("#pdf").on('click', function(){
            document.getElementById("pdf_form").value = JSON.stringify(result1a);
            // document.getElementById("pdf_form_help_topic").value = $('#help_topic :selected').val();
            document.getElementById("start_date").value = $('#help_topic :selected').val();
            document.getElementById("end_date").value = $('#help_topic :selected').val();

            document.getElementById("form_pdf").submit();
        });

        $("#xlxs").on('click', function(){
            document.getElementById("xlxs_form").value = JSON.stringify(result1a);
            // document.getElementById("xlxs_form_help_topic").value = $('#help_topic :selected').val();
            document.getElementById("start_date").value = $('#start_date').val();
            document.getElementById("end_date").value = $('#end_date').val();
            document.getElementById("form_xlxs").submit();
        });
        
    });
</script>

<script>
    $(function () {
        //    $("#tabular").DataTable();
        $('#tickets_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        // Close a ticket
        $('#close').on('click', function(e) {
            $.ajax({
                type: "GET",
                url: "agen",
                beforeSend: function() {

                },
                success: function(response) {

                }
            })
            return false;
        });
    });
</script>



<script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
@stop
