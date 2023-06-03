@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('teams')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{$teams->name}}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop
<!-- /breadcrumbs -->
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
<!-- <input type="text" name="show_id" value="{{$id}}"> -->
<?php
 if($team_lead_name= App\User::whereId($teams->team_lead)->first())
          {
            $team_lead = $team_lead_name->first_name . " " . $team_lead_name->last_name;
             // $assign_team_agent=App\Model\helpdesk\Agent\Assign_team_agent::all();
            // $total_members = $assign_team_agent->where('team_id',$id)->count();
        }

?>
            
    <div class="box box-primary">
        <div class="box-header with-border">
        @if($team_lead_name)
            <span class="lead border-right">{!! Lang::get('lang.team_lead') !!} : {!! $team_lead !!} </span>
         @endif
            <span class="lead border-left">{!! Lang::get('lang.status') !!} : <?php if($teams->status == 1) { $stat = Lang::get('lang.active'); } elseif($teams->status == 0) { $stat = Lang::get('lang.inactive'); } ?>{!! $stat !!} </span>
            

            <div class="pull-right">
                <a href="{{URL::route('teams.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> {{Lang::get('lang.go_back')}}</a>
                <a href="{{URL::route('teams.add_recipient', $teams->id)}}" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add Group Recipient </a>

            </div>
        </div>
        <input type="hidden" name="show_id" value={{$id}}>
        <!-- /.box-header -->
        <div class="box-body">             
            <?php /* {!! \DataTables::table()
                    ->addColumn(
                        Lang::get('lang.user_name'),
                        Lang::get('lang.name'),
                        Lang::get('lang.status'),
                        Lang::get('lang.group'),
                        Lang::get('lang.depertment'),
                        Lang::get('lang.role')
                    )
                    ->setUrl(route('teams.getshow.list', $id))  // this is the route where data will be retrieved
                    ->render() 
            !!} */ ?>
            <h2>Group Recipients</h2>
            <h4>Group That Can Recieve Tickets From This One</h4>
            <table class="table table-hover table-striped dataTable">
                <thead>
                    <th>S/N</th>
                    <th>Group Name</th>
                    <th>Active?</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($groupRecipients as $key => $groupRecipient)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$groupRecipient->to_group_name}}</td>
                            <td>{{$groupRecipient->active_status}}</td>
                            <td>
                            @if($groupRecipient->active == 1)
                                <!-- <a href="{{URL::route('teams.reset_recipient_activate', $teams->id)}}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> De-activate </a> -->
                                <!-- <a href="{{URL::route('teams.reset_recipient_activate', $teams->id)}}" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> De-activate </a> -->

                                <!-- <a href="/admin/users/{{$user->id}}/edit" class="btn btn-primary">Edit</a> -->
                                <form method="POST" action="{{URL::route('teams.reset_recipient_deactivate', $groupRecipient->id)}}">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-danger delete-user" value="De-Activate">
                                    </div>
                                </form>
                            @else
                                <form method="POST" action="{{URL::route('teams.reset_recipient_activate', $groupRecipient->id)}}">
                                    {{ csrf_field() }}
                                    {{ method_field('PATCH') }}

                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success delete-user" value="Activate">
                                    </div>
                                </form>                            
                            @endif
                            </td>   
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        <h2>Team Members</h2>
            <table class="table table-hover table-striped dataTable">
                <thead>
                    <th>S/N</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Active</th>
                    <th>Primary Department</th>
                    <th>Role</th>
                </thead>
                <tbody>
                    @foreach($teams->getTeamMembers() as $key => $teamMember)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $teamMember->user_name }}</td>
                            <td>{{ $teamMember->first_name }} {{ $teamMember->last_name }}</td>
                            <td>{{ $teamMember->active }}</td>
                            <td>{{ $teamMember->primary_dpt }}</td>
                            <td>{{ $teamMember->role }}</td>   
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
        
    <!-- <script>
        $('.dataTable').DataTable();
    </script> -->

@stop