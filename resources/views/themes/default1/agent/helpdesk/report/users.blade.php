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
        <form id="foo">
            <input type="hidden" name="duration" value="" id="duration">
            <input type="hidden" name="default" value="false" id="default">
            <div  class="form-group">
                <div class="row">
                    {{-- Assigned Users --}}
                    <div class='col-sm-2'>
                        {!! Form::label('assigned_user', Lang::get('lang.assigned_user')) !!}
                        <select name="assigned_user" id="assigned_user" class="form-control">
                            <option value=""> <b>-- All Users --</b> </option>
                            @foreach($assignedUsers as $user)
                            <option @if(old('assigned_user') == $user->id) selected @endif value="{!! $user->id !!}">{!! $user->email !!}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Users on Ticket Threads --}}
                    <div class='col-sm-2'>
                        {!! Form::label('thread_user', Lang::get('lang.thread_user')) !!}
                        <select name="thread_user" id="thread_user" class="form-control">
                            <option value=""> <b>-- All Users --</b> </option>
                            @foreach($users as $user)
                            <option @if(old('thread_user') == $user->id) selected @endif value="{!! $user->id !!}">{!! $user->email !!}</option>
                            @endforeach
                        </select>
                    </div>
                    {{--  --}}
                    <div class='col-sm-2 form-group' id="start_date">
                        {!! Form::label('date', Lang::get('lang.start_date')) !!}
                        {!! Form::text('start_date',null,['class'=>'form-control','id'=>'datepicker4'])!!}
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
                    <div class='col-sm-2 form-group' id="end_date">
                        {!! Form::label('start_time', Lang::get('lang.end_date')) !!}
                        {!! Form::text('end_date',null,['class'=>'form-control','id'=>'datetimepicker3'])!!}
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
                    <div class='col-sm-1' style="padding-right:0px;padding-left:0px">
                        <label>{!! Lang::get('lang.status') !!}</label>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">{!! Lang::get('lang.select') !!}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" id="stop"><input type="checkbox" name="open" @if(old('open') == "on") checked @endif id="open"> {!! lang::get('lang.opened') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                <li><a href="#" id="stop"><input type="checkbox" name="closed" @if(old('closed') == "on") checked @endif id="closed"> {!! lang::get('lang.closed') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                <li><a href="#" id="stop"><input type="checkbox" name="reopened" @if(old('reopened') == "on") checked @endif id="reopened"> {!! lang::get('lang.reopened') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                <li><a href="#" id="stop"><input type="checkbox" name="overdue" @if(old('overdue') == "on") checked @endif id="overdue"> {!! lang::get('lang.overdue') !!} {!! lang::get('lang.tickets') !!}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class='col-sm-1'>
                        {!! Form::label('filter', 'Filter') !!}<br>
                        <input type="submit" class="btn btn-primary" value="Submit" id="submit">
                    </div>
                    {{-- <br/> --}}
                    <div class="col-md-2">
                        {!! Form::label('generate', 'Generate') !!}<br>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">{!! Lang::get('lang.generate') !!}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#" id="pdf">{!! Lang::get('lang.generate_pdf') !!}</a></li>
                                <li><a href="#" id="xlxs">Generate Spreadsheet</a></li>
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
        <table class="table table-bordered no-footer" id="tickets_table">
            <thead>
                <tr>
                    <!-- <td><a class="checkbox-toggle"><i class="fa fa-square-o fa-2x"></i></a></td> -->
                    <td>S/N</td>
                    <td>{!! Lang::get('lang.subject') !!}</td>
                    <td>{!! Lang::get('lang.ticket_id') !!}</td>
                    <td>{!! Lang::get('lang.from') !!}</td>
                    <td>{!! Lang::get('lang.assigned_to') !!}</td>

                    <!-- <td>Status</td> -->
                    <!-- <td>Priority</td> -->

                    <td>{!! Lang::get('lang.last_activity') !!}</td>
                    <td>Remark</td>
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
                            <a href="/thread/{{$ticket->id}}" target="_blank">{{$ticket->ticket_number}}</a>
                        </td>
                        <td>{{$ticket->owner}}</td>
                        <td>{{$ticket->assigned_to_name ?? $ticket->assigned_to}}</td>

                        <!-- <td>{{$ticket->status}}</td> -->

                        <!-- <td>
                            <span class="callout callout-{{$ticket->priority_color}}" style = 'background-color:{{$ticket->priority_color}}; color:#F9F9F9'>
                                {{$ticket->priority}}
                            </span>
                        </td> -->
                        <?php 
                            $lastActivityDate = strtotime($ticket->last_activity);
                            $dateNow = strtotime(date("d-m-Y"));
                        ?>
                        <td>{{ date("d-F-Y H:i", strtotime($ticket->last_activity))}}</td>
                        <td>
                            @if ($ticket->closed)
                                <button class="btn btn-success btn-xs"> {{Lang::get('lang.closed') }} </button>
                            @elseif ($ticket->isanswered)
                                <button class="btn btn-info btn-xs"> {{Lang::get('lang.answered') }} </button>
                            @elseif ($ticket->isoverdue || ($dateNow > $lastActivityDate))
                                <button class="btn btn-danger btn-xs"> {{Lang::get('lang.overdue') }} </button>
                            @elseif ($ticket->reopened)
                                <button class="btn btn-warning btn-xs"> {{Lang::get('lang.reopened') }} </button>
                            @else
                                <button class="btn btn-warning btn-xs"> {{Lang::get('lang.open') }} </button>
                            @endif
                        </td>
                    </tr>
                    <?php $sn++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


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
            document.getElementById("start_date").value = $('#help_topic :selected').val();
            document.getElementById("end_date").value = $('#help_topic :selected').val();
            document.getElementById("form_xlxs").submit();
        });
        
    });
</script>

<script>
  $(function () {
//    $("#tabular").DataTable();
    $('#tabular').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
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
