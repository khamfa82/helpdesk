@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('agents')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{ Lang::get('lang.agents')}} </h1>
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
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title">{!! Lang::get('lang.list_of_agents') !!} </h2><a href="{{route('agents.create')}}" class="btn btn-primary pull-right">
        <span class="glyphicon glyphicon-plus"></span> &nbsp;{!! Lang::get('lang.create_an_agent') !!}</a></div>
    <div class="box-body table-responsive">
        <?php
        $users = App\User::where('role', '!=', 'user')->orderBy('id', 'ASC')
            // ->paginate(50);
            ->get();
//	dd($users);
        ?>
        <!-- check whether success or not -->
        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('success')}}
        </div>
        @endif
        <!-- failure message -->
        @if(Session::has('fails'))
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>{!! Lang::get('lang.fails') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('fails')}}
        </div>
        @endif
        <!-- Warning Message -->
        @if(Session::has('warning'))
        <div class="alert alert-warning alert-dismissable">
            <i class="fa fa-warning"></i>
            <b>{!! Lang::get('lang.warning') !!}!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{Session::get('warning')}}
        </div>
        @endif
        <!-- Agent table -->
        <!-- <table class="table table-bordered dataTable" style="overflow:hidden;"> -->
        <table class="table table-hover table-striped dataTable">
            <thead>
                <tr>
                    <th width="10px">S/N</th>
                    <th width="100px">{{Lang::get('lang.name')}}</th>
                    <th width="100px">{{Lang::get('lang.user_name')}}</th>
                    <th width="100px">{{Lang::get('lang.role')}}</th>
                    <th width="100px">{{Lang::get('lang.management_level')}}</th>
                    <th width="100px">{{Lang::get('lang.all_emails')}}</th>
                    <th width="100px">{{Lang::get('lang.status')}}</th>
                    <th width="100px">{{Lang::get('lang.group')}}</th>
                    <th width="100px">{{Lang::get('lang.organization')}}</th>
                    <th width="100px">{{Lang::get('lang.department')}}</th>
                    <th width="100px">{{Lang::get('lang.created')}}</th>
                    {{-- <th width="100px">{{Lang::get('lang.lastlogin')}}</th> --}}
                    <th width="100px">{{Lang::get('lang.action')}}</th>
                </tr>
            </thead>
            <?php $sn = 1; ?>
            <tbody>
            @foreach($users as $use)
                @if($use->role == 'admin' || $use->role == 'agent')
                    <tr>
                        <td>{{$sn++}}</td>
                        <td><a href="{{route('agents.edit', $use->id)}}"> {!! $use->first_name !!} {!! " ". $use->last_name !!}</a></td>
                        <td><a href="{{route('agents.edit', $use->id)}}"> {!! $use->user_name !!}</td>
                        <?php
                            if ($use->role == 'admin') {
                                echo '<td><button class="btn btn-success btn-xs">' . Lang::get('lang.admin') . '</button></td>';
                            } elseif ($use->role == 'agent') {
                                echo '<td><button class="btn btn-primary btn-xs">' . Lang::get('lang.agent') . '</button></td>';
                            }
                        ?>
                        <td>{{Lang::get('lang.level')}} {{ $use->management_level }}</td>
                        <td>
                            @if ($use->all_emails && $use->role == 'admin')
                                <button class="btn btn-success btn-xs"> {{Lang::get('lang.yes') }} </button>
                            @else
                                <button class="btn btn-warning btn-xs"> {{Lang::get('lang.no') }} </button>
                            @endif
                        </td>
                        <td>
                            @if($use->active=='1')
                            <span style="color:green">{!! Lang::get('lang.active') !!}</span>
                            @else
                            <span style="color:red">{!! Lang::get('lang.inactive') !!}</span>
                            @endif
                            <?php
                            $group = App\Model\helpdesk\Agent\Groups::whereId($use->assign_group)->first();
                            $department = App\Model\helpdesk\Agent\Department::whereId($use->primary_dpt)->first();
                            $organization = App\Model\helpdesk\Agent_panel\Organization::whereId($use->organization_id)->first();
                            ?>
                        <td>{{ $group->name }}</td>
                        <td>{{ $organization->name ?? "N/A" }}</td>
                        <td>{{ $department->name }}</td>
                        <td>{{ UTC::usertimezone($use->created_at) }}</td>
                        {{-- <td>{{$use->Lastlogin_at}}</td> --}}
                        <td>
                            {!! Form::open(['route'=>['agents.destroy', $use->id],'method'=>'DELETE']) !!}
                            <a href="{{route('agents.edit', $use->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> {!! Lang::get('lang.edit') !!} </a>
                            <!-- To pop up a confirm Message -->
                            <a href="{{route('agents.reset_password', $use->id)}}" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-key" style="color:black;"> </i> Reset Password </a>

                            {{-- {!! Form::button(' <i class="fa fa-trash" style="color:black;"> </i> '  . Lang::get('lang.delete') ,['type' => 'submit', 'class'=> 'btn btn-warning btn-xs btn-flat','onclick'=>'return confirm("Are you sure?")']) !!} --}}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        <div class="pull-right" style="margin-top : -10px; margin-bottom : -10px;">
            <?php /* {!! $user->links() !!} */ ?>
        </div>
    </div>
</div>
@stop
