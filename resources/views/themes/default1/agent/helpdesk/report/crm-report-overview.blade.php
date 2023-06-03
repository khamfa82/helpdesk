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
                    <div class='col-sm-2'>
                        {!! Form::label('year', Lang::get('lang.year')) !!}
                        <select name="year" id="year" class="form-control">
                                @for ($y = -5; $y <= 5; $y++)
                                    <option @if (request()->get('year') == date('Y') + $y) selected @endif value="{{ date('Y') + $y }}">{{ date('Y') + $y }}</option>
                                @endfor
                        </select>
                    </div>
                    <div class='col-sm-6'>
                        {!! Form::label('fiscal_quarters', Lang::get('lang.fiscal_quarters')) !!}
                        <select name="fiscal_quarter" id="fiscal_quarter" class="form-control">
                                <option @if (request()->get('fiscal_quarter') == 1) selected @endif value="1">Q1 (January to March)</option>
                                <option @if (request()->get('fiscal_quarter') == 2) selected @endif value="2">Q2 (April to June)</option>
                                <option @if (request()->get('fiscal_quarter') == 3) selected @endif value="3">Q3 (July to September)</option>
                                <option @if (request()->get('fiscal_quarter') == 4) selected @endif value="4">Q4 (October to December)</option>
                        </select>
                    </div>

                    {{-- <div class='col-sm-4 form-group' id="start_date"> --}}
                        {{-- {!! Form::label('date', Lang::get('lang.start_date') . ' for Remaining Open Tickets') !!} --}}
                        {{-- {!! Form::text('start_date',null,['class'=>'form-control','id'=>'datepicker4','autocomplete'=>'off'])!!} --}}
                        {{-- <input type="date" value="{{ $start_date }}" class="form-control" name="start_date" autocomplete="off"> --}}
                    {{-- </div> --}}
                    
                    <div class='col-sm-2'>
                        {!! Form::label('filter', 'Filter') !!}<br>
                        <input type="submit" class="btn btn-primary" value="Submit" id="submit">
                    </div>
                    {{-- <br/> --}}
                    <div class="col-sm-2">
                        {!! Form::label('generate', 'Generate') !!}<br>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default">{!! Lang::get('lang.generate') !!}</button>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <!-- <li><a href="#" id="pdf">{!! Lang::get('lang.generate_pdf') !!}</a></li> -->
                                <li>
                                    <button type="button" name="download_spreadsheet"  onclick="ExportToExcel('xlsx')" value="spreadsheet" form="report-form" class="btn "><i class="fa fa-download"></i> Download Spreadsheet</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div><!-- /.box-body -->

</div><!-- /.box -->

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">CRM Report Overview ({{ date('Y') }})</h3>
    </div>
    <div class="box-body table-responsive">
        
        @php
            function getValue($entry, $array) {
                $value = 0;
                foreach ($array as $compare) {
                    //dd($compare->week);
                    if ($compare->week == $entry) {
                        $value = $compare->count;
                        break;
                    }
                }
                return $value;
            }
            
            function getValueArr($entry, $array) {
                $value = 0;
                foreach ($array as $compare) {
                    //dd($compare->week);
                    if (array_key_exists('week', $compare)) {
                        if ($compare['week'] == $entry) {
                            $value = $compare['count'];
                            break;
                        }
                    }
                }
                return $value;
            }
            
            function getValueLeadTime($entry, $array) {
                $value = 0.00;
                foreach ($array as $compare) {
                    if (array_key_exists('week', $compare)) {
                        if ($compare['week'] == $entry) {
                            $value = round(($compare['average'] ?? 0.00), 1);
                            break;
                        }
                    }
                }
                return $value;
            }
        @endphp

        @if(count($weeks) == 0)
            <div class="alert alert-warning text-center">
                No data found on this quarter, please filter again.
            </div>
        @else
            <table id="tbl_exporttable_to_xls" class="table table-bordered table-stripped">
                <tr class="text-bold">
                    <td rowspan="2" colspan="3">Weekno#</td>
                    <td colspan="{{ count($weeks) }}" class="text-center">Status {{ $fiscal_quarter }}</td>
                    <td rowspan="2">Explanation:</td>
                </tr>
                <tr class="text-bold">
                    @foreach ($weeks as $week)
                        <td>{{ $week }}</td>
                    @endforeach
                </tr>

                

                {{--            OPENED / CREATED TICKETS            --}}
                
                
                <tr style="background: lightblue">
                    <td rowspan="3" class="text-bold">Opened / Created tickets</td>
                    <td rowspan="3" class="text-bold">No#</td>
                    <td class="text-bold">Total</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $open_tickets_all)
                            }}
                        </td>
                    @endforeach
                    <td rowspan="3" class="text-bold">No# of tickets opened in this week and allocated to which organisation</td>
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[0]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueArr($week, $open_tickets[0]) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="text-bold"> {{ $organizations[1]->name }} </td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueArr($week, $open_tickets[1]) }}</td>
                    @endforeach
                </tr>
                

                {{--            CLOSED TICKETS            --}}
                
                
                <tr class="bg-success">
                    <td rowspan="3" class="text-bold">Closed tickets</td>
                    <td rowspan="3" class="text-bold">No#</td>
                    <td class="text-bold">Total</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $closed_tickets_all)
                            }}
                        </td>
                    @endforeach
                    <td rowspan="3" class="text-bold">No# of tickets closed in this week and by which organisation</td>
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[0]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueArr($week, $closed_tickets[0]) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[1]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueArr($week, $closed_tickets[1]) }}</td>
                    @endforeach
                </tr>
                

                {{--            AVG LEAD LIME TO CLOSURE            --}}
                
                
                <tr style="background: rgb(251, 255, 230)">
                    <td rowspan="3" class="text-bold">Avg Leadtime to Closure</td>
                    <td rowspan="3" class="text-bold">Days</td>
                    <td class="text-bold">Total</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ getValueLeadTime($week, $lead_time_to_closure_tickets_all) }}
                        </td>
                    @endforeach
                    <td rowspan="3" class="text-bold">Avg no# of days leadtime of tickets closed in this week and by which organisation</td>
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[0]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueLeadTime($week, $lead_time_to_closure_tickets[0]) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[1]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueLeadTime($week, $lead_time_to_closure_tickets[1]) }}</td>
                    @endforeach
                </tr>


                {{--            AVG LEAD TIME TO RESOLVE            --}}
                
                
                <tr style="background: rgb(243, 234, 255)">
                    <td rowspan="3" class="text-bold">Avg Leadtime to Resolve</td>
                    <td rowspan="3" class="text-bold">Days</td>
                    <td class="text-bold">Total</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ getValueLeadTime($week, $lead_time_to_resolve_tickets_all) }}
                        </td>
                    @endforeach
                    <td rowspan="3" class="text-bold">Avg no# of days leadtime of tickets resolvedin this week and by which organisation</td>
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[0]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueLeadTime($week, $lead_time_to_resolve_tickets[0]) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[1]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueLeadTime($week, $lead_time_to_resolve_tickets[1]) }}</td>
                    @endforeach
                </tr>
                

                {{--            REMAINING OPEN TICKETS            --}}
                
                
                <tr class="bg-danger">
                    <td rowspan="3" class="text-bold">
                        Remaining Open Tickets
                    </td>
                    <td rowspan="3" class="text-bold">No#</td>
                    <td class="text-bold">Total</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $total_tickets_all) -
                                getValueArr($week, $total_closed_tickets_all)
                            }}
                        </td>
                    @endforeach
                    <td rowspan="3" class="text-bold">Total No# of tickets still open at the end of this week at Sunday 23:59hrs and allocated to which organisation</td>
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[0]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $total_tickets[0]) -
                                getValueArr($week, $total_closed_tickets[0])
                            }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[1]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $total_tickets[1]) -
                                getValueArr($week, $total_closed_tickets[1])
                            }}
                        </td>
                    @endforeach
                </tr>


                {{--            TOTAL CLOSED TICKETS            --}}
                
                
                <tr style="background: rgb(255, 250, 250)">
                    <td rowspan="3" class="text-bold">Total Closed Tickets</td>
                    <td rowspan="3" class="text-bold">No#</td>
                    <td class="text-bold">Total</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $total_closed_tickets_all)
                            }}
                        </td>
                    @endforeach
                    <td rowspan="3" class="text-bold">No# of tickets closed from beginning to end of this week at Sunday 23:59hrs and by which organisation</td>
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[0]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueArr($week, $total_closed_tickets[0]) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[1]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>{{ getValueArr($week, $total_closed_tickets[1]) }}</td>
                    @endforeach
                </tr>


                {{--            TOTAL TICKETS            --}}
                
                
                <tr style="background: rgb(222, 251, 255)">
                    <td rowspan="3" class="text-bold">Total Tickets</td>
                    <td rowspan="3" class="text-bold">No#</td>
                    <td class="text-bold">Total</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $total_tickets_all)
                            }}
                        </td>
                    @endforeach
                    <td rowspan="3" class="text-bold">No# of total tickets from beginning to end of this week at Sunday 23:59hrs and by which organisation</td>
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[0]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $total_tickets[0])
                            }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="text-bold">{{ $organizations[1]->name }}</td>
                    @foreach ($weeks as $week)
                        <td>
                            {{ 
                                getValueArr($week, $total_tickets[1])
                            }}
                        </td>
                    @endforeach
                </tr>
            </table>
        @endif

    </div>
</div>

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

<script src="{{ asset('js/xlsx.full.min.js') }}"></script>
<script>
    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('CRM_Report_Overview.' + (type || 'xlsx')));
    }
</script>



<script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
<script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>
@stop
