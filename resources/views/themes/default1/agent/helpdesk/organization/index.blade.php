@extends('themes.default1.admin.layout.admin')

@section('Staffs')
active
@stop

@section('staffs-bar')
active
@stop

@section('organizations')
class="active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{{ Lang::get('lang.organizations')}} </h1>
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
        <h2 class="box-title">{!! Lang::get('lang.list_of_organizations') !!} </h2><a href="{{route('organizations.create')}}" class="btn btn-primary pull-right">
        <span class="glyphicon glyphicon-plus"></span> &nbsp;{!! Lang::get('lang.create_organization') !!}</a></div>
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
                    <th width="100px">S/N</th>
                    <th width="100px">{{Lang::get('lang.name')}}</th>
                    <th width="100px">{{Lang::get('lang.phone')}}</th>
                    <th width="100px">{{Lang::get('lang.website')}}</th>
                    <th width="100px">{{Lang::get('lang.address')}}</th>
                    <th width="100px">{{Lang::get('lang.action')}}</th>
                </tr>
            </thead>
            <?php $sn = 1; ?>
            <tbody>
            @foreach($organizations as $organization)
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'agent')
                    <tr>
                        <td>{{$sn++}}</td>
                        <td><a href="{{route('organizations.edit', $organization->id)}}"> {!! $organization->name !!}</a></td>
                        <td>{{ $organization->phone }}</td>
                        <td>{{ $organization->website }}</td>
                        <td>{{ $organization->address }}</td>
                       
                        <td>
                            {!! Form::open(['route'=>['organizations.destroy', $organization->id],'method'=>'DELETE']) !!}
                            <a href="{{route('organizations.edit', $organization->id)}}" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> {!! Lang::get('lang.edit') !!} </a>
                            
                            {{-- {!! Form::button(' <i class="fa fa-trash" style="color:black;"> </i> '  . Lang::get('lang.delete') ,['type' => 'submit', 'class'=> 'btn btn-warning btn-xs btn-flat','onclick'=>'return confirm("Are you sure?")']) !!} --}}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
        <div class="pull-right" style="margin-top : -10px; margin-bottom : -10px;">
            <?php /* {!! $organization->links() !!} */ ?>
        </div>
    </div>
</div>
@stop
