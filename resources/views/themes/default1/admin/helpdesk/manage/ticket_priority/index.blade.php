@extends('themes.default1.admin.layout.admin')

@section('Manage')
active
@stop

@section('manage-bar')
active
@stop

@section('priority')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.ticket_priority') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop

<!-- content -->
@section('content')

@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <b>Success!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('success') !!}
</div>
@endif
<!-- failure message -->
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b>Fail!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {!! Session::get('fails') !!}
</div>
@endif
<div class="box box-primary">
    <div class="box-header with-border">
        <span class="lead border-right">{!! Lang::get('lang.priority') !!}</span>
        <div class="pull-right">
             <a href="{{route('priority.create')}}" class="btn btn-primary"> <span class="glyphicon glyphicon-plus"></span> &nbsp;{{Lang::get('lang.create_ticket_priority')}}</a>
        </div>
    </div>

      <div class="box-header with-border">
    <a class="right" title="" data-placement="right" data-toggle="tooltip" href="#" data-original-title="{{Lang::get('lang.active_user_can_select_the_priority_while_creating_ticket')}}">

        <span class="lead border-right" >{!! Lang::get('lang.current') !!}{!! Lang::get('lang.user_priority_status') !!}</span>
       
           </a>

                            <div class="btn-group pull-right" id="toggle_event_editing">
                                <button type="button"  class="btn {{$user_status->status == '0' ? 'btn-info' : 'btn-default'}} locked_active">Inactive</button>
                                <button type="button"  class="btn {{$user_status->status == '1' ? 'btn-info' : 'btn-default'}} unlocked_inactive">Active</button>
                            </div>
                            <!-- <div class="alert alert-info" id="switch_status"></div> -->
                      
             <!-- <a href="{{route('priority.create')}}" class="btn btn-primary">{{Lang::get('lang.create_ticket_priority')}}</a> -->
        
    </div>





    <div class="box-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Color</th>
                    <th>Urgency</th>
                    <th>Is Public</th>
                    <th>Is Default</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($priorities as $priority)
                    <tr>
                        <td>{{ $priority->priority_id }}</td>
                        <td>
                            <a style='color: {{ $priority->status == 1 ? 'green' : 'red' }}'>{{ $priority->status == 1 ? 'Active' : 'Inactive' }}</a>
                        </td>
                        <td>{{ $priority->priority }}</td>
                        <td>{{ $priority->priority_desc }}</td>
                        <td>
                            <button class='btn btn-sm' style ='background-color:{{ $priority->priority_color }}'></button>
                        </td>
                        <td>{{ $priority->priority_urgency }}</td>
                        <td>{{ $priority->ispublic }}</td>
                        <td>
                            @if ($priority->is_default > 0)
                                <a href="/ticket/priority/{{$priority->priority_id}}/edit" class='btn btn-info btn-xs'>Edit</a>&nbsp;<a href="#" class='btn btn-warning btn-info btn-xs' disabled='disabled' > Delete </a>
                            @else
                                <a href="/ticket/priority/{{$priority->priority_id}}/edit" class='btn btn-info btn-xs'>Edit</a>&nbsp;<a href="#" class='btn btn-warning btn-info btn-xs' onclick='confirmDelete("{{$priority->priority_id}}")'> Delete </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="box-footer">
    </div>
</div>
<script type="text/javascript">
    $('a').tooltip()
</script>

<script>
    function confirmDelete(priority_id) {
        var r = confirm('Are you sure?');
        if (r == true) {
            // console.log(r);
            // alert('{!! url("ticket_priority") !!}/' + priority_id + '/destroy');
            window.location = '{!! url("ticket/priority") !!}/' + priority_id + '/destroy';
            //    $url('ticket_priority/' . $priority->priority_id . '/destroy')
        } else {
            return false;
        }
    }
</script>
<script>
    $('#toggle_event_editing button').click(function () {

        var user_settings_priority=1;
         var user_settings_priority=0;
        if ($(this).hasClass('locked_active') ) {
         

            user_settings_priority = 0
        } if ( $(this).hasClass('unlocked_inactive')) {
          
            user_settings_priority = 1;
        }

        /* reverse locking status */
        $('#toggle_event_editing button').eq(0).toggleClass('locked_inactive locked_active btn-default btn-info');
        $('#toggle_event_editing button').eq(1).toggleClass('unlocked_inactive unlocked_active btn-info btn-default');
        $.ajax({
            type: 'post',
            url: '{{route("user.priority.index")}}',
            data: {
                "_token": "{{ csrf_token() }}",
                user_settings_priority: user_settings_priority},
            success: function (result) {
                // with('success', Lang::get('lang.approval_settings-created-successfully'));
                // alert("Hi, testing");
                alert(result);
                location.reload(); 
            }
        });
    });
</script>

@stop