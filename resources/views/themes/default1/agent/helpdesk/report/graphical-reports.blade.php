@extends('themes.default1.agent.layout.agent')

@section('sidebar')
    <li class="header">
        {!! Lang::get('lang.Report') !!}
    </li>
    <li>
        <a href="">
            <i class="fa fa-area-chart"></i> <span>{!! Lang::get('lang.help_topic') !!}</span> <small class="label pull-right bg-green"></small>
        </a>
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
    <link type="text/css" href="{{asset("lb-faveo/css/bootstrap-datetimepicker4.7.14.min.css")}}" rel="stylesheet">
    <link type="text/css" href="{{asset("css/loading-div.css")}}" rel="stylesheet">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Detailed Graphical Reports</h3>
            
            <div style="float: right" id="download-chart">
                <div class="btn-group">
                    <button type="button" class="btn btn-success"><i class="fa fa-download"></i> Download</button>
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#" onclick="download_image('png')" id="pdf">Download Image/PNG</a></li>
                        <li><a href="#" onclick="download_image('jpeg')" id="image">Download Image/JPEG</a></li>
                        <li><a href="#" onclick="download_excel()" id="excel">Download Excel</a></li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="box-body">
            <form id="foo">
                <input type="hidden" name="duration" value="" id="duration">
                <input type="hidden" name="default" value="false" id="default">
                <div  class="form-group">
                    <div class="row">
                        <div class='col-sm-2 form-group' id="start_date">
                            {!! Form::label('date', Lang::get('lang.start_date').':') !!}
                            {{-- {!! Form::text('start_date',null,['class'=>'form-control','id'=>'datepicker4','autocomplete'=>'off'])!!} --}}
                            <input type="text" class="form-control" id="datepicker4" autocomplete="off">
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
                            {!! Form::label('start_time', Lang::get('lang.end_date').':') !!}
                            {!! Form::text('end_date',null,['class'=>'form-control','id'=>'datetimepicker3','autocomplete'=>'off'])!!}
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
                                    <li><a href="#" id="stop"><input type="checkbox" name="open" id="_open"> {!! lang::get('lang.open') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                    <li><a href="#" id="stop"><input type="checkbox" name="closed" id="_closed"> {!! lang::get('lang.closed') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                    <li><a href="#" id="stop"><input type="checkbox" name="reopened" id="_reopened"> {!! lang::get('lang.reopened') !!} {!! lang::get('lang.tickets') !!}</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class='col-sm-2'>
                            {!! Form::label('report-type', 'Report Type') !!}
                            <select onchange="get_report_data(this)" name="report_type" id="report-type" class="form-control">
                                <option value="">-- Select Report Type --</option>
                                <option value="report_priority">Tickets per Priority</option>
                                {{-- <option value="report_priority_trend">Ticket Priority Trends (Priority / Month(s))</option> --}}
                                <option value="report_help_topic">Ticket per Help Topic</option>
                                <option value="report_help_topic_per_priority">Priorities per Help Topic</option>
                                <option value="report_lead_times">Ticket Lead Times per Organization</option>
                                <option value="report_lead_times_per_agent">Ticket Lead Times per Agent (Organization)</option>
                            </select>
                        </div>
                        
                        <div class='col-sm-2' id="report_priority">
                            {!! Form::label('priority', Lang::get('lang.priority')) !!}
                            <select onchange="get_report_data(this)" name="priority" id="priority" class="form-control">
                                <?php $priorities = App\Model\helpdesk\Ticket\Ticket_Priority::where('status','=',1)->get(); ?>
                                <option value=""> -- All Priorities -- </option>
                                @foreach($priorities as $priority)
                                    <option value="{!! $priority->priority_id !!}">{!! $priority->priority_desc !!}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class='col-sm-2' id="report_help_topic">
                            {!! Form::label('helptopic', Lang::get('lang.help_topic')) !!}
                            <select onchange="get_report_data(this)" name="help_topic" id="help_topic" class="form-control">
                                <?php $helptopics = App\Model\helpdesk\Manage\Help_topic::where('status', '=', '1')->get([ 'id', 'topic']); ?>
                                <option value=""> -- All Helptopics -- </option>
                                @foreach($helptopics as $helptopic)
                                <option value="{!! $helptopic->id !!}">{!! $helptopic->topic !!}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class='col-sm-2'>
                            {!! Form::label('chart', 'Chart') !!}
                            <select onchange="change_chart_type(this)" name="chart_type" id="chart-type" class="form-control">
                                <option value="bar">Bar/Histogram Chart</option>
                                <option value="line">Line Chart</option>
                                <option value="pie">Pie Chart</option>
                                <option value="polarArea">Polar Area Chart</option>
                            </select>
                        </div>
    
                        <div class='col-sm-1'>
                            {!! Form::label('filter', 'Filter:') !!}<br>
                            <input type="button" class="btn btn-primary" onclick="get_report_data()" value="Submit" id="submit">
                        </div>
                        <br/>
                    </div>
                </div>
            </form>

            {{-- Loading Div --}}
            <div class="loader bg-dark" id="loading-div">
                <div class="loader-wheel"></div>
                <div class="loader-text"></div>
            </div>

            {{-- Error Div --}}
            <div class="alert alert-danger text-center" style="padding: 20px" id="error-div"></div>

            {{-- Chart Div --}}
            <div class="chart" id="chart-div">
                <canvas class="chart-data" id="tickets-graph" width="1000" height="300"></canvas>
            </div>

        </div><!-- /.box-body -->
        <div class="box-footer">
            {{-- Simple report --}}
            <div class="row" id="simple-report"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.8.0/dist/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js" integrity="sha512-r22gChDnGvBylk90+2e/ycr3RVrDi8DIOkIGNhJlKfuyQM4tIRAI062MaV8sfjQKYVGjOBaZBOA87z+IhZE9DA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        
        download_btn = document.getElementById('download-chart');
        loading_div = document.getElementById('loading-div');
        chart_div = document.getElementById('chart-div');
        error_div = document.getElementById('error-div');
        simple_report = document.getElementById('simple-report');
        chart_type = document.getElementById('chart-type');

        chart_div.style.display = "none";
        error_div.style.display = "none";
        download_btn.style.display = "none";

        var my_chart;
        var heading = "";
        var chart_data = [];
        var chart_labels = [];
        var chart_colors = getChartColors(chart_data);
        
        get_report_data();

        function getRandomColor() {
            // var letters = '0123456789ABCDEF';
            // var color = '#';
            // for (var i = 0; i < 6; i++) {
            //     color += letters[Math.floor(Math.random() * 16)];
            // }

            var x = Math.floor(Math.random() * 256);
            var y = 100+ Math.floor(Math.random() * 256);
            var z = 50+ Math.floor(Math.random() * 256);
            var bgColor = "rgb(" + x + "," + y + "," + z + ", 0.6)";

            return bgColor;
        }

        function getChartColors(data) {
            var colors = [];
            // console.log(typeof(data), data);
            if (typeof(data) === "string")
                return getRandomColor();

            data.forEach(datum => {
                colors.push(getRandomColor());
            });
            return colors;
        }

        const ctx = document.getElementById('tickets-graph').getContext('2d');
        run_chart();

        function change_chart_type(chart_type) {
            my_chart.destroy();
            run_chart(chart_type?.value ?? 'bar');
        }

        report_help_topic = document.getElementById('report_help_topic');
        report_priority = document.getElementById('report_priority');

        function get_report_data() {
            // console.log("Get new data ...");
            report_type = document.getElementById('report-type');
            // heading = report_type.options[el.selectedIndex].innerHTML;
            _report_type = (report_type?.value ?? 'report_help_topic');
            hide_report_selections(_report_type);

            if (!form_has_error()) {
                var start_date = document.getElementById('datepicker4').value;
                var end_date = document.getElementById('datetimepicker3').value;
                var open = document.getElementById('_open');
                var closed = document.getElementById('_closed');
                var reopened = document.getElementById('_reopened');
                var help_topic = document.getElementById('help_topic');
                var priority = document.getElementById('priority');
    
                var url = "/report/get-graphical-report-data?report_type=" + _report_type;
                url += `&start_date=${start_date}&end_date=${end_date}&open=${open?.checked}&closed=${closed?.checked}&reopened=${reopened?.checked}&help_topic=${help_topic?.value}&priority=${priority?.value}`;
                jQuery(document).ready(function() { 
                    $.ajax({
                        type: "GET",
                        url: url,
                        beforeSend: function() {
                            error_div.style.display = "none";
                            chart_div.style.display = "none";
                            download_btn.style.display = "none"
                            loading_div.style.display = "block";
                        },
                        success: function(response) {
                            var report = response.reports;

                            console.log(report);
                            error_div.style.display = "none";
                            chart_div.style.display = "block"
                            download_btn.style.display = "block"
                            loading_div.style.display = "none";
    
                            my_chart.destroy();
                            
                            heading = report?.label ?? "Graphical Report";
                            var tmp_data = [];
                            chart_data = report?.data?.data ?? [];
                            chart_labels = report?.data?.label ?? [];
                            chart_colors = [];
                            
                            chart_labels.forEach((datum, index) => {
                                _color = getChartColors('');
                                chart_colors.push(_color);
                                
                                // tmp_data.push({
                                //     label: datum,
                                //     data: chart_data[index],
                                //     backgroundColor: _color,
                                //     borderWidth: 1
                                // });
                            });

                            tmp_data.push({
                                label: heading,
                                data: chart_data,
                                backgroundColor: chart_colors,
                                borderWidth: 1
                            });

                            chart_data = tmp_data;
                            console.log(tmp_data);
                            run_chart();
                            write_simple_report(report?.data);
                        }
                    });
                });
            }
        }

        function sum(_data) {
            if (typeof _data == 'number' || typeof _data == 'undefined' || typeof _data == 'string')
                return _data;
            
            return _data.reduce((_datum, _acc) => _acc = _acc + parseInt(_datum), 0);
        }

        function write_simple_report(data) {
            _report = "";
            data.label.forEach((datum, index) => {
                _report += `
                <div class="col-sm-2 col-xs-6">
                    <div class="description-block border-right">
                        <h3 class="simple-report-number" style="background: ${chart_colors[index]}"><strong id="">${sum(data.data[index])}</strong></h3>
                        <span class="">${datum}</span>
                    </div>
                </div>
                `;
            });
            simple_report.innerHTML = _report;
        }

        function hide_report_selections(report_type) {
            // console.log(report_type);
            report_help_topic.style.display = "none";
            report_priority.style.display = "none";

            switch (report_type) {
                case "report_help_topic":
                    report_help_topic.style.display = "block";
                    break;
                case "report_priority":
                    report_priority.style.display = "block";
                    break;
                case "report_help_topic_per_priority":
                    report_help_topic.style.display = "block";
                    break;
                default:
                    //
            }
        }

        function run_chart(_dataset = []) {
            my_chart = new Chart(ctx, {
                type: chart_type?.value,
                data: {
                    labels: chart_labels,
                    datasets: chart_data
                },
                options: {
                    maintainAspectRatio: false,
                    reponsive: true
                }
            });
        }

        function form_has_error() {
            var date1 = $('#datepicker4').val();
            var date2 = $('#datetimepicker3').val();
            var report_type = $('#report-type').val();
            
            if (!date1) {
                $('#datepicker4').addClass("has-error2");
            } else {
                $('#datepicker4').removeClass("has-error2");
            }
            
            if (!report_type) {
                $('#report-type').addClass("has-error2");
            } else {
                $('#report-type').removeClass("has-error2");
            }

            if (!date2) {
                $('#datetimepicker3').addClass("has-error2");
            } else {
                $('#datetimepicker3').removeClass("has-error2");
            }

            if (!date1 || !date2 || !report_type) {
                chart_div.style.display = "none";
                loading_div.style.display = "none";
                error_div.style.display = "block";
                error_div.innerHTML = "Please select start date, end date and report type to show reports ;)";
                return true;
            }
            return false;
        }

        function download_image(type) {
            var image = my_chart.toBase64Image(`image/${type}`, 1);
            
            var a = document.createElement('a');
            a.href = image;
            a.download = `image_of_${report_type?.value}_${Date.now()}.${type}`;

            // Trigger the download
            a.click();              
        }

        function download_excel() {
            // console.log(chart_data);
            let exported_data = Array.from(chart_data);
            exported_data.forEach((data) => {
                delete data.backgroundColor;
                delete data.borderWidth;
            });
            // console.log(exported_data);

            //const xlsx = require("xlsx"); 
            
            let workbook = XLSX.utils.book_new(); 
            XLSX.utils.book_append_sheet(workbook, XLSX.utils.json_to_sheet(exported_data), report_type?.value); 
            XLSX.writeFile(workbook,`sheet_of_${report_type?.value}_${Date.now()}.xlsx`);
        }

    </script>   

    {{-- <script defer src="{{asset("lb-faveo/plugins/chartjs/Chart.min.js")}}" type="text/javascript"></script> --}}
    <script src="{{asset("lb-faveo/plugins/moment-develop/moment.js")}}" type="text/javascript"></script>
    <script src="{{asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")}}" type="text/javascript"></script>    
@stop