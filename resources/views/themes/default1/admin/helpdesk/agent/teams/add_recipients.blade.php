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
<h1>{{Lang::get('lang.teams')}}</h1>
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
<!-- open a form -->
{!! Form::open(array('route' => ['teams.add_recipient_store', [$teams->id] ], 'method' => 'post') )!!}
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Add Team Recipient to the Team: {{ $teams->name }}	</h3>
    </div>
    <div class="box-body">
        @if(Session::has('errors'))
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <b>Alert!</b>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <br/>
                @if($errors->first('to_team_id'))
                <li class="error-message-padding">{!! $errors->first('to_team_id', ':message') !!}</li>
                @endif
                @if($errors->first('remarks'))
                <li class="error-message-padding">{!! $errors->first('remarks', ':message') !!}</li>
                @endif
            </div>
        @endif
        <div class="row">
      
            <!-- team -->
            <div class="col-xs-6 form-group {{ $errors->has('team_lead') ? 'has-error' : '' }}">
                {!! Form::label('to_team_id','Recipient Team') !!}
                {!! Form::select('to_team_id',[''=>'Select Team', Lang::get('lang.members')=>$allTeams->pluck('name','id')->toArray()],null,['class' => 'form-control select2']) !!}	
            </div>
        </div>
        <!-- status -->
        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
            {!! Form::label('status',Lang::get('lang.status')) !!}
            <div class="row">
                <div class="col-xs-1">
                    {!! Form::radio('active','1',true) !!} {{Lang::get('lang.active')}}
                </div>
                <div class="col-xs-2">
                    {!! Form::radio('active','0',null) !!} {{Lang::get('lang.inactive')}}
                </div>
            </div>
        </div>
        <!-- admin notes -->
        <div class="form-group">
            {!! Form::label('remarks',Lang::get('lang.admin_notes')) !!}
            {!! Form::textarea('remarks',null,['class' => 'form-control','size' => '30x5']) !!}
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary'])!!}
    </div>
</div>
{!!Form::close()!!}
@stop