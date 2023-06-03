@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

<?php
$old = false;
$inputs     = \Request::get('show');
$activepage = $inputs[0];
if (\Request::has('assigned'))
{
    $activepage = \Request::get('assigned')[0];
} elseif (\Request::has('last-response-by')){
    $activepage = \Request::get('last-response-by')[0];
}
?>

@if($activepage == 'trash')
    @section('trash')
        class="active"
    @stop
@elseif ($activepage == 'mytickets')
    @section('myticket')
        class="active"
    @stop
@elseif ($activepage == 'followup')
    @section('followup')
        class="active"
    @stop
@elseif($activepage == 'inbox')
    @section('inbox')
        class="active"
    @stop
@elseif($activepage == 'overdue')
    @section('overdue')
        class="active"
    @stop
@elseif($activepage == 'closed')
    @section('closed')
        class="active"
    @stop
@elseif($activepage == 'approval')
    @section('approval')
        class="active"
    @stop
@elseif($activepage == 'Agent')
    @section('answered')
        class="active"
    @stop
@elseif($activepage == 'Client')
    @section('open')
        class="active"
    @stop
@elseif($activepage == 0)
    @section('unassigned')
        class="active"
    @stop
@else
    @section('assigned')
        class="active"
    @stop
@endif

@section('PageHeader')
<h1>{{ Lang::get('lang.tickets') }}</h1>
<style>
    .tooltip1 {
        position: relative;
        /*display: inline-block;*/
        /*border-bottom: 1px dotted black;*/
    }

    .tooltip1 .tooltiptext {
        visibility: hidden;
        width: 100%;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
    }

    .tooltip1:hover .tooltiptext {
        visibility: visible;
    }
</style>
@stop
@section('content')
<!-- Main content -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            @if($activepage == 'trash')
            {{Lang::get('lang.trash')}}
            @elseif ($activepage == 'mytickets')
            {{Lang::get('lang.my_tickets')}}
            @elseif ($activepage == 'followup')
            {{Lang::get('lang.followup')}}
            @elseif($activepage == 'inbox')
            {{Lang::get('lang.inbox')}}
            @elseif($activepage == 'overdue')
            {{Lang::get('lang.overdue')}}
            @elseif($activepage == 'closed')
            {{Lang::get('lang.closed')}}
            @elseif($activepage == 'approval')
            {{Lang::get('lang.approval')}}
            @elseif($activepage == 0)
            {{Lang::get('lang.unassigned')}}
            @else
            {{Lang::get('lang.inbox')}}
            @endif
            @if(count(Request::all()) > 2 && $activepage != '0')
            / {{Lang::get('lang.filtered-results')}}
            @else()
            @if(count(Request::get('departments')) == 1 && Request::get('departments')[0] != 'All')
            / {{Lang::get('lang.filtered-results')}}
            @elseif (count(Request::get('departments')) > 1)
            / {{Lang::get('lang.filtered-results')}}
            @endif
            @endif
        </h3>
    </div><!-- /.box-header -->

    <div class="box-body ">
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"> </i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!}! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif

        <div class="alert alert-success alert-dismissable" style="display: none;">
            <i class="fa fa-check-circle"> </i> <span class="success-message"></span>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        <div class="alert alert-danger alert-dismissable" style="display: none;">
            <i class="fa fa-ban"> </i> <b> {!! Lang::get('lang.alert') !!}!</b> <span class="error-message"></span>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        <!--<div class="mailbox-controls">-->
        <!-- Check all button -->

        <!-- <button type="button" class="btn btn-sm btn-default text-green" id="Edit_Ticket" data-toggle="modal" data-target="#MergeTickets"><i class="fa fa-code-fork"> </i> {!! Lang::get('lang.merge') !!}</button>
            <?php //$inputs   = Request::all(); ?>
        <div class="btn-group">
<?php $statuses = Finder::getCustomedStatus(); ?>
            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" id="d1"><i class="fa fa-exchange" style="color:teal;" id="hidespin"> </i><i class="fa fa-spinner fa-spin" style="color:teal; display:none;" id="spin"></i>
                {!! Lang::get('lang.change_status') !!} <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @foreach($statuses as $ticket_status)
                <li onclick="changeStatus({!! $ticket_status -> id !!}, '{!! $ticket_status->name !!}')"><a href="#"><i class="{!! $ticket_status->icon !!}" style="color:{!! $ticket_status->icon_color !!};"> </i>{!! $ticket_status->name !!}</a></li>
                @endforeach
            </ul>
        </div>

        <button type="button" class="btn btn-sm btn-default" id="assign_Ticket" data-toggle="modal" data-target="#AssignTickets" style="display: none;"><i class="fa fa-hand-o-right"> </i> {!! Lang::get('lang.assign') !!}</button>
        @if($activepage == 'trash')
        <button form="modalpopup" class="btn btn-sm btn-danger" id="hard-delete" name="submit" type="submit"><i class="fa fa-trash"></i>&nbsp;{{Lang::get('lang.clean-up')}}</button> -->
        <!-- @endif -->
        <p></p>

        <div class="mailbox-messages" id="refresh">
            <!--datatable-->
            {!! Form::open(['id'=>'modalpopup', 'route'=>'select_all','method'=>'post']) !!}
             <table class="table table-bordered no-footer" id="tickets_table">
                <thead>
                    <tr>
                        <!-- <td><a class="checkbox-toggle"><i class="fa fa-square-o fa-2x"></i></a></td> -->
                        <td>S/N</td>
                        <td>{!! Lang::get('lang.subject') !!}</td>
                        <td>{!! Lang::get('lang.ticket_id') !!}</td>
                        <td>{!! Lang::get('lang.ticket') . " " . Lang::get('lang.category') !!}</td>
                        <td>{!! Lang::get('lang.from') !!}</td>
                        <td>{!! Lang::get('lang.assigned_to') !!}</td>
                        <td>{!! Lang::get('lang.first_activity') !!}</td>

                        <!-- <td>Status</td> -->
                        <!-- <td>Priority</td> -->

                        <td>{!! Lang::get('lang.last_activity') !!}</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $sn=1; ?>
                    @foreach($tickets as $ticket)
                        <?php //dd($ticket->owner) ?>
                        <tr>
                            <!-- <td><a class="checkbox-toggle"><i class="fa fa-square-o fa-2x"></i></a></td> -->
                            <td>{{$sn}}</td>
                            <td>{{$ticket->ticket_subject ?? "N/A"}}</td>
                            <td>{{$ticket->ticket_number}}</td>
                            <td>{{$ticket->category->name ?? ""}}</td>
                            <td>{{$ticket->owner}}</td>
                            <td>{{$ticket->assigned_to_name ?? $ticket->assigned_to}}</td>

                            <!-- <td>{{$ticket->status}}</td> -->

                            <!-- <td>
                                <span class="callout callout-{{$ticket->priority_color}}" style = 'background-color:{{$ticket->priority_color}}; color:#F9F9F9'>
                                    {{$ticket->priority}}
                                </span>
                            </td> -->
                            <td>{{ date("d-F-Y H:i", strtotime($ticket->first_activity ?? $ticket->created_at))}}</td>
                            <td class="@if (($ticket->first_activity ?? $ticket->created_at) == $ticket->last_activity) bg-danger @else bg-success @endif">{{ date("d-F-Y H:i", strtotime($ticket->last_activity))}}</td>
                            <td>
                                <a href="{{route('ticket.thread',[$ticket->id])}}" type="button" class="btn btn-primary"><i class="fa fa-eye"></i> VIEW</a>
                            </td>
                        </tr>
                        <?php $sn++; ?>
                    @endforeach
                </tbody>
            </table>
            {!! Form::close() !!}

            <!-- /.datatable -->
        </div><!-- /.mail-box-messages -->
    </div><!-- /.box-body -->
</div><!-- /. box -->


<!-- Modal -->
@include('themes.default1.agent.helpdesk.ticket.more.tickets-model')
@include('vendor.yajra.tickets-javascript')
@include('themes.default1.agent.helpdesk.ticket.more.tickets-options-script')
<script>
    $(document).ready(function () { /// Wait till page is loaded
            var date_options = '<option value="any-time">{{Lang::get("lang.any-time")}}</option><option value="5-minutes">{{Lang::get("lang.5-minutes")}}</option><option value="10-minutes">{{Lang::get("lang.10-minutes")}}</option><option value="15-minutes">{{Lang::get("lang.15-minutes")}}</option><option value="30-minutes">{{Lang::get("lang.30-minutes")}}</option><option value="1-hour">{{Lang::get("lang.1-hour")}}</option><option value="4-hours">{{Lang::get("lang.4-hours")}}</option><option value="8-hours">{{Lang::get("lang.8-hours")}}</option><option value="12-hours">{{Lang::get("lang.12-hours")}}</option><option value="24-hours">{{Lang::get("lang.24-hours")}}</option><option value="today">{{Lang::get("lang.today")}}</option><option value="yesterday">{{Lang::get("lang.yesterday")}}</option><option value="this-week">{{Lang::get("lang.this-week")}}</option><option value="last-week">{{Lang::get("lang.last-week")}}</option><option value="15-days">{{Lang::get("lang.15-days")}}</option><option value="30-days">{{Lang::get("lang.30-days")}}</option><option value="this-month">{{Lang::get("lang.this-month")}}</option><option value="last-month">{{Lang::get("lang.last-month")}}</option><option value="last-2-months">{{Lang::get("lang.last-2-months")}}</option><option value="last-3-months">{{Lang::get("lang.last-3-months")}}</option><option value="last-6-months">{{Lang::get("lang.last-6-months")}}</option><option value="last-year">{{Lang::get("lang.last-year")}}</option>';
            $('#modified, #created').append(date_options);
            $('#modified, #created').trigger("change");
            var create_dropdown = $("#created").select2({maximumSelectionLength : 1});
            //valueSelected(create_dropdown);
            var update_dropdown = $("#modified").select2({maximumSelectionLength : 1});
            //valueSelected(update_dropdown);
            var due_dropdown = $("#due-on-filter").select2({maximumSelectionLength : 1});
            //valueSelected(due_dropdown);
            var assign_dropdown = $("#assigned-filter").select2({maximumSelectionLength : 1});
            //valueSelected(assign_dropdown);
            var response_dropdown = $('#response-filter').select2({maximumSelectionLength : 1});
            //valueSelected(response_dropdown);
            $('.select2-selection').css('border-radius', '0px');
            $('.select2-selection').css('border-color', '#D2D6DE')
            $('.select2-container').children().css('border-radius', '0px');
            @if (array_key_exists('assigned', $inputs))
            assign_dropdown.val(JSON.parse('<?= json_encode($inputs["assigned"]) ?>')).trigger("change");
            if (JSON.parse('<?= json_encode($inputs["assigned"]) ?>') == '1' || JSON.parse('<?= json_encode($inputs["assigned"]) ?>') == 1) {
    }
    @endif

            @if (array_key_exists('created', $inputs))
            create_dropdown.val(JSON.parse('<?= json_encode($inputs["created"]) ?>')).trigger("change");
            @endif

            @if (array_key_exists('updated', $inputs))
            update_dropdown.val(JSON.parse('<?= json_encode($inputs["updated"]) ?>')).trigger("change");
            @endif

            @if (array_key_exists('due-on', $inputs))
            due_dropdown.val(JSON.parse('<?= json_encode($inputs["due-on"]) ?>')).trigger("change");
            @endif

            @if (array_key_exists('last-response-by', $inputs))
            response_dropdown.val(JSON.parse('<?= json_encode($inputs["last-response-by"]) ?>')).trigger("change");
            @endif

            $('#resetFilter').on("click", function (){
    $('.filter, #assigned-to-filter, #departments-filter, #sla-filter, #priority-filter, #source-filter').val(null).trigger("change");
            clearlist += 1;
            clearfilterlist();


    });

    $('#tickets_table').DataTable({
      "columnDefs": [
      { "width": "5%", "targets": 0 },
      { "width": "15%", "targets": 1 },
      { "width": "12%", "targets": 2 },
      // { "width": "70px", "targets": 3 },
      // { "width": "70px", "targets": 4 },
      // { "width": "70px", "targets": 5 }
    ],
    });
    });

    function showhidefilter()
    {
    if (filterClick == 0) {
    $('#filterBox').css('display', 'block');
            filterClick += 1;
    } else {
    $('#filterBox').css('display', 'none');
            filterClick = 0;
    }
    }

    function removeEmptyValues()
    {
    $(':input[value=""]').attr('disabled', true);
    }



</script>
<!-- @include('themes.default1.agent.helpdesk.selectlists.selectlistjavascript') -->
<!-- @include('themes.default1.agent.helpdesk.selectlists.selectlist') -->
@stop
