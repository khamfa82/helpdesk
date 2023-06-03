@extends('themes.default1.agent.layout.agent')

@section('Tickets')
class="active"
@stop

@section('ticket-bar')
active
@stop

@section('newticket')
class="active"
@stop

@section('PageHeader')
<h1>{{Lang::get('lang.tickets')}}</h1>
@stop

@section('content')
<!-- Main content -->
{!! Form::open(['route'=>'post.newticket','method'=>'post','id'=>'form', 'enctype' => 'multipart/form-data']) !!}
<div class="box box-primary">
    <div class="box-header with-border" id='box-header1'>
        <h3 class="box-title">{!! Lang::get('lang.create_ticket') !!}</h3>
        @if(Session::has('success'))
        <br><br>        
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <br><br>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        @if(Session::has('errors'))
        <br><br>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.alert') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            @if($errors->first('email'))
            <li class="error-message-padding">{!! $errors->first('email', ':message') !!}</li>
            @endif
            @if($errors->first('first_name'))
            <li class="error-message-padding">{!! $errors->first('first_name', ':message') !!}</li>
            @endif
            @if($errors->first('phone'))
            <li class="error-message-padding">{!! $errors->first('phone', ':message') !!}</li>
            @endif
            @if($errors->first('subject'))
            <li class="error-message-padding">{!! $errors->first('subject', ':message') !!}</li>
            @endif
            @if($errors->first('body'))
            <li class="error-message-padding">{!! $errors->first('body', ':message') !!}</li>
            @endif
            @if($errors->first('code'))
            <li class="error-message-padding">{!! $errors->first('code', ':message') !!}</li>
            @endif
            @if($errors->first('mobile'))
            <li class="error-message-padding">{!! $errors->first('mobile', ':message') !!}</li>
            @endif
            @if($errors->first('assignto'))
            <li class="error-message-padding">{!! $errors->first('assignto', ':message') !!}</li>
            @endif
        </div>
        @endif
    </div><!-- /.box-header -->
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.user_details') !!}:</h4>
    </div>
    <div class="box-body">

        <div class="form-group">
            <div class="row">
                <div class="col-md-4">
                    <!-- email -->
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        {!! Form::label('email',Lang::get('lang.email')) !!}
                        @if ($email_mandatory->status == 1)
                        <span class="text-red"> *</span>
                        @endif

                        {!! Form::text('email',auth()->user()->email,['class' => 'form-control', 'id' => 'email','readonly']) !!}
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- email -->
                    <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                        {!! Form::label('email',Lang::get('lang.first_name')) !!} <span class="text-red"> *</span>
                       <!--  {!! Form::text('email',null,['class' => 'form-control'],['id' => 'email']) !!} -->
                       <input type="text" name="first_name" value="{{auth()->user()->first_name}}" id="first_name" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- full name -->
                    <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                        {!! Form::label('fullname',Lang::get('lang.last_name')) !!} <span class="text-red"></span>
                        <input type="text" value="{{auth()->user()->last_name}}" name="last_name" id="last_name" class="form-control" readonly>
                    </div>
                </div>
            </div>
       <?php /*     <div class="row">
                <div class="col-md-1 form-group {{ Session::has('country_code_error') ? 'has-error' : '' }}">
                    <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                    {!! Form::label('code',Lang::get('lang.country-code')) !!}
                    @if ($email_mandatory->status == 0 || $settings->status == 1)
                         <span class="text-red"> *</span>
                    @endif

                    {!! Form::text('code',null,['class' => 'form-control', 'id' => 'country_code', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- phone -->
                    <div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
                        <label>{!! Lang::get('lang.mobile_number') !!}:</label>
                        @if ($email_mandatory->status == 0 || $settings->status == 1)
                         <span class="text-red"> *</span>
                        @endif
                        {!! Form::input('number','mobile',null,['class' => 'form-control', 'id' => 'mobile']) !!}
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- phone -->
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                        <label>{!! Lang::get('lang.phone') !!}:</label>
                        {!! Form::input('number','phone',null,['class' => 'form-control', 'id' => 'phone_number']) !!}
                        {!! $errors->first('phone', '<spam class="help-block text-red">:message</spam>') !!}
                    </div>
                </div>
                <!--  <div class="form-group">
                     <div class="col-md-2">
                         <label>Ticket Notice:</label>
                     </div>
                     <div class="col-md-6">
                         <input type="checkbox" name="notice" id=""> Send alert to User
                     </div>
                 </div> -->
            </div>
        </div>
    </div> */ ?>
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.ticket_option') !!}:</h4>
    </div>
    <div class="box-body">
        <!-- ticket options -->
        <div class="form-group">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{!! Lang::get('lang.help_topic') !!}:</label>
                        <!-- helptopic -->
                        <?php $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->select('topic', 'id')->get(); ?>
                        {!! Form::select('helptopic', [''=>'Select Helptopic', 'Helptopic'=>$helptopic->pluck('topic','id')->toArray()],null,['class' => 'form-control select  select2','id'=>'selectid']) !!}
                    </div>
                </div>
                <div class="col-md-2 form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                    {!! Form::label('category',Lang::get('lang.category') . " " . Lang::get('lang.category')) !!} <span class="text-red"> *</span>
                    @php
                        $ticket_categories = App\Model\helpdesk\Ticket\TicketCategory::all();
                    @endphp
                    {!!Form::select('category',[''=> Lang::get('lang.select') . " " . Lang::get('lang.category'),Lang::get('lang.categories')=>$ticket_categories->pluck('name','id')->toArray()],3,['class' => 'form-control select2']) !!}
                </div>
                <div class="col-md-2">
                    <!-- sla plan -->
                    <div class="form-group">
                        <label>{!! Lang::get('lang.sla_plan') !!}:</label>
                        <?php $sla_plan = App\Model\helpdesk\Manage\Sla_plan::where('status', '=', 1)->select('grace_period', 'id')->get(); ?>
                        {!! Form::select('sla', ['SLA'=>$sla_plan->pluck('grace_period','id')->toArray()],null,['class' => 'form-control select select2']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- due date -->
                    <div class="form-group" id="duedate">
                        <label>{!! Lang::get('lang.due_date') !!}:</label>
                        {!! Form::text('duedate',null,['class' => 'form-control','id'=>'datemask','autocomplete' => 'off']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <!-- assign to -->
                    <div class='form-group {{ $errors->has('assignto') ? 'has-error' : '' }}'>
                        <label>{!! Lang::get('lang.assign_to') !!}:</label>
                        <?php 
                            // $agents = App\User::where('role', '!=', 'user')->where('active', '=', 1)->get(); 
                            // $agentsArray = $agents->pluck('first_name','id')->toArray();

                            /*$agentsArray = App\User::where('role', '!=', 'user')->where('active', '=', 1)
                                ->select(\DB::raw('CONCAT(`first_name`," ", `last_name`," (",`email`,")") as Name'), 'id')
                                ->get()
                                ->pluck('Name','id')
                                ->toArray();*/

                            $agentsArray = Auth::user()->allowedTicketSendLIst();
                            // dd($agentsArray);
                        ?>
                        
                        {!! Form::select('assignto', [''=>'Select an Agent','Agents'=>$agentsArray],null,['class' => 'form-control select select2']) !!}
                    </div>
                </div>

                <div class="col-md-3">
                    <!-- assign to -->
                    <div class="form-group">
                        <label>Reporting Office:</label>
                        {!! Form::select('immigration_office_id', [''=>'Select an office','Offices'=> \App\ImmigrationOffice::get_all() ],null,['class' => 'form-control select select2']) !!}
                    </div>
                </div>

                {{-- <div id="response" class="col-md-6 form-group"></div> --}}
            </div>
            <div class="row">
            {{-- Event fire --}}
            <?php Event::dispatch(new App\Events\ClientTicketForm()); ?>
            </div>
        </div>
    </div>
    <div class="box-header with-border">
        <h4 class="box-title">{!! Lang::get('lang.ticket_detail') !!}:</h4>
    </div>
    <div class="box-body">
        <!-- ticket details -->
        <div class="form-group">
            <!-- subject -->
            <div class="form-group {{ $errors->has('subject') ? 'has-error' : '' }}">
                <div class="row">
                    <div class="col-md-1">
                        <label>{!! Lang::get('lang.subject') !!}:<span class="text-red"> *</span></label>
                    </div>
                    <div class="col-md-4">
                        {!! Form::text('subject',null,['class' => 'form-control','autocomplete' => 'off']) !!}
                    </div>
                </div>
            </div>
            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                <!-- details -->
                <div class="row">
                    <div class="col-md-1">
                        <label>{!! Lang::get('lang.detail') !!}:<span class="text-red"> *</span></label>
                    </div>
                    <div class="col-md-9">
                        {!! Form::textarea('body',null,['class' => 'form-control','id' => 'body', 'style'=>"width:100%; height:150px;"]) !!}

                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <!-- reply content -->
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}" id="reply_content_class">
                        <div class="col-md-2">
                            <label> {!! Lang::get('lang.attachment') !!}</label>
                        </div>
                        <div class="col-md-10">
                            <div id="reset-attachment">
                                <span class='btn btn-default btn-file'> <i class='fa fa-paperclip'></i> <span>{!! Lang::get('lang.upload') !!}</span><input type='file' name='attachment[]' id='attachment' multiple/></span>
                                <div id='file_details'></div><div id='total-size'></div>{!! Lang::get('lang.max') !!}. {!! $max_size_in_actual !!}
                                <div>
                                    <a id='clear-file' onClick='clearAll()' style='display:none; cursor:pointer;'><i class='fa fa-close'></i>Clear all</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <!-- priority -->
                <div class="row">
                    <div class="col-md-1">
                        <label>{!! Lang::get('lang.priority') !!}:</label>
                    </div>
                    <div class="col-md-3">
                        <?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('status','=',1)->get(); ?>
                        {!! Form::select('priority', ['Priority'=>$Priority->pluck('priority','priority_id')->toArray()],null,['class' => 'form-control select', 'id' => 'priority']) !!}
                        <div class="alert" style="margin-bottom: 0" id="priority_desc">
                        </div>
                        <script>
                            var priority = document.getElementById('priority'); 
                            var priority_desc = document.getElementById('priority_desc'); 
                            
                            getDescription();
                            
                            priority.onchange = () => {
                                getDescription();
                            }

                            async function getDescription() {
                                loadingDescr();
                                var priority_id = priority.value;
                                // console.log(priority.value)
                                var result = '';
                                await $.ajax({
                                    url: `{{url('/ticket/priority/${priority_id}/description')}}`,
                                    data: {},
                                    type: "GET",
                                    dataType: "html",
                                    success: function (response) {
                                        var responseJson = JSON.parse(response);
                                        // console.log(responseJson);
                                        priority_desc.style.background = 'lightgray';
                                        priority_desc.innerHTML = `<button type='button' class="btn btn-sm" style='background: ${responseJson.priority_color}'></button> ${responseJson.priority_desc}`;
                                    },
                                    error: function (response) {
                                        priority_desc.innerHTML = response;
                                    }
                                });
                            }

                            function loadingDescr() {
                                priority_desc.style.background = 'lightblue';
                                priority_desc.innerHTML = 'Fetching priority description ...';
                            }
                        </script>
                    </div>
                    
                </div>
            </div>
             
        </div>
    </div>
    <div class="box-footer">
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-3">
                <input type="submit" value="{!! Lang::get('lang.create_ticket') !!}" class="btn btn-primary" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();">
            </div>
        </div>
    </div>
</div><!-- /. box -->
{!! Form::close() !!}
<script type="text/javascript">
    // Clear all
    function clearAll() {
        $("#file_details").html("");
        $("#total-size").html("");
        $("#attachment").val('');
        $("#clear-file").hide();
        $("#replybtn").removeClass('disabled');
    }

    // Attachments
    $('#attachment').change(function() {
        input = document.getElementById('attachment');
        if (!input) {
            alert("Um, couldn't find the fileinput element.");
        } else if (!input.files) {
            alert("This browser doesn't seem to support the `files` property of file inputs.");
        } else if (!input.files[0]) {
        } else {
            $("#file_details").html("");
            var total_size = 0;
            for(i = 0; i < input.files.length; i++) {
                file = input.files[i];
                var supported_size = "{!! $max_size_in_bytes !!}";
                var supported_actual_size = "{!! $max_size_in_actual !!}";
                if(file.size < supported_size) {
                    $("#file_details").append("<tr> <td> " + file.name + " </td><td> " + formatBytes(file.size) + "</td> </tr>");
                } else {
                    $("#file_details").append("<tr style='color:red;'> <td> " + file.name + " </td><td> " + formatBytes(file.size) + "</td> </tr>");
                }
                total_size += parseInt(file.size);
            }
            if(total_size > supported_size) {
                $("#total-size").append("<span style='color:red'>Your total file upload size is greater than "+ supported_actual_size +"</span>");
                $("#replybtn").addClass('disabled');
                $("#clear-file").show();
            } else {
                $("#total-size").html("");
                $("#replybtn").removeClass('disabled');
                $("#clear-file").show();
            }
        }
    });

    function formatBytes(bytes,decimals) {
        if(bytes == 0) return '0 Byte';
        var k = 1000;
        var dm = decimals + 1 || 3;
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
    
    $(document).ready(function () {
        var helpTopic = $("#selectid").val();
        send(helpTopic);
        $("#selectid").on("change", function () {
            helpTopic = $("#selectid").val();
            send(helpTopic);
        });
        function send(helpTopic) {
            $.ajax({
                url: "{{url('/get-helptopic-form')}}",
                data: {'helptopic': helpTopic},
                type: "GET",
                dataType: "html",
                success: function (response) {
                    $("#response").html(response);
                },
                error: function (response) {
                    $("#response").html(response);
                }
            });
        }

        $('.select2').select2();

    });
    $(function () {
        $("textarea").wysihtml5();
    });

    $(document).ready(function () {
        $('#form').submit(function () {
            var duedate = document.getElementById('datemask').value;
            if (duedate) {
                var pattern = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
                if (pattern.test(duedate) === true) {
                    $('#duedate').removeClass("has-error");
                    $('#clear-up').remove();
                } else {
                    $('#duedate').addClass("has-error");
                    $('#clear-up').remove();
                    $('#box-header1').append("<div id='clear-up'><br><br><div class='alert alert-danger alert-dismissable'><i class='fa fa-ban'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> Invalid Due date</div></div>");
                    return false;
                }
            }
        });
    });
                $(document).ready(function(){                   
                    $("#email").autocomplete({
                        source:"{!!URL::route('post.newticket.autofill')!!}",
                        minLength:1,
                        select:function(evt, ui) {
                            // this.form.phone_number.value = ui.item.phone_number;
                            // this.form.user_name.value = ui.item.user_name;
                            if(ui.item.first_name) {
                                this.form.first_name.value = ui.item.first_name;
                            }
                            if(ui.item.last_name) {
                                this.form.last_name.value = ui.item.last_name;
                            }
                            if(ui.item.country_code) {
                                this.form.country_code.value = ui.item.country_code;
                            }
                            if(ui.item.phone_number) {
                                this.form.phone_number.value = ui.item.phone_number;
                            }
                            if(ui.item.mobile) {
                                this.form.mobile.value = ui.item.mobile;
                            }
                        }
                    });
                });

    $(function () {
        $('#datemask').datepicker({changeMonth: true, changeYear: true}).mask('99/99/9999');
    });
</script>

@stop




