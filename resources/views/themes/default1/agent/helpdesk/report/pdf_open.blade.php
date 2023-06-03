<!DOCTYPE html>
<html>
    <head>
        <title>PDF</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
            * {
                font-family: "DejaVu Sans Mono", monospace;
            }

            td, th {
                padding-right: 50px;
            }
        </style>
        <link href="{{ asset('lb-faveo/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>

        <div style="background-color:#F2F2F2;">
            <h2>
                <div id="logo" class="site-logo text-center" style="font-size: 30px;">
                    <?php
                    $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                    $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
                    // dd($system);
                    ?>
                    <center>
                        @if($system->url)
                            <a href="{!! $system->url !!}" rel="home">
                        @else
                            <a href="{{url('/')}}" rel="home" style="text-decoration:none;">
                        @endif

                        @if($company->use_logo == 1)
                            <img src="{!! public_path().'/uploads/company'.'/'.$company->logo !!}" width="100px;"/>
                        @else
                            @if($system->name)
                                {!! $system->name !!}
                            @else
                                <b>SUPPORT</b> CENTER
                            @endif
                        @endif
                            </a>
                            <br/>
                            {!! $system->name !!}
                    </center>
                </div>
            </h2>
        </div>
        <br/><br/>
        <?php 
            if($help_topic_val == 0) $help_topic_name = 'ALL';
            if($help_topic_val > 0) $help_topic_name = App\Model\helpdesk\Manage\Help_topic::where('id', '=', $help_topic_val)->first()->topic; 
        ?>
        <span class="lead"> Help Topic :  {{$help_topic_name}}</span>
        <br/><br/>

        Date Range : {{$start_date_val}} - {{$end_date_val}}
        <br/><br/>

        <!-- <span class="lead">All Tickets: {{$stats_array['all_tickets_count']}}</span>
        <span class="lead">Open Tickets: {{$stats_array['created_count']}}</span>
        <span class="lead">Resolved Tickets: {{$stats_array['resolved_count']}}</span>
        <span class="lead">Closed Tickets: {{$stats_array['closed_count']}}</span> -->


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
                    <th>S/N</th>
                    <th>{!! Lang::get('lang.subject') !!}</th>
                    <th>Help Topic</th>
                    <th>{!! Lang::get('lang.ticket_id') !!}</th>
                    <th>Created By</th>
                    <th>{!! Lang::get('lang.assigned_to') !!}</th>

                    <th>Status</th>
                    <!-- <th>Priority</th> -->

                    <th>Created</th>
                    <th>{!! Lang::get('lang.last_activity') !!}</th>
                    <th>Remark</th>
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
                        <td>{{$ticket->help_topic_name}}</td>
                        <td>{{$ticket->ticket_number}}</td>
                        <td>{{$ticket->owner}}</td>
                        <td>{{$ticket->assigned_to_name ?? $ticket->assigned_to}}</td>
                        <td>{{$ticket->status_name}}</td>
                        <!-- <td>
                            <span class="callout callout-{{$ticket->priority_color}}" style = 'background-color:{{$ticket->priority_color}}; color:#F9F9F9'>
                                {{$ticket->priority}}
                            </span>
                        </td> -->
                        <td>{{ date("d-F-Y H:i", strtotime($ticket->created_at))}}</td>
                        <td>{{ date("d-F-Y H:i", strtotime($ticket->last_activity))}}</td>
                        <td>
 
                        </td>
                    </tr>
                    <?php $sn++; ?>
                @endforeach
            </tbody>
        </table>


    </body>
</html>
