@extends('tasks.layout')

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            @php
                $page_name = $_GET['name'] ?? "Task Modules";
            @endphp
            <h3 class="box-title">{{ $page_name }}</h3>
            <a href="/task-modules/create" class="btn btn-success btn-sm" style="float: right"><i class="fa fa-plus"></i> New</a>
        </div>
        <div class="box-body">
            <div class="mailbox-messages" id="refresh">
                <!--datatable-->
                 <table class="table table-bordered no-footer" id="tasks_table">
                    <thead>
                        <tr>
                            <th>{!! Lang::get('lang.id') !!}</th>
                            <th>{!! Lang::get('lang.name') !!}</th>
                            <th>{!! Lang::get('lang.active') !!}</th>
                            <th>{!! Lang::get('lang.action') !!}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($modules as $module)
                            <tr>
                                <td>{{ $module->id }}</td>
                                <td>{{ $module->name ?? "N/A" }}</td>
                                <td>{!! $module->is_active ? "<i class=\"fa fa-check text-green\"></i>" : "<i class=\"fa fa-times text-danger\"></i>" !!}</td>
                                <td>
                                    <form onsubmit="return confirm('Are you sure? This action can not be undone!');" action="/task-modules/{{$module->id}}" method="post">
                                        @csrf
                                        @method("delete")
                                        <a href="/task-modules/{{ $module->id }}/edit" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                                        <button href="/task-modules/{{ $module->id }}" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- /.datatable -->
            </div>
        </div>
    </div>
@endsection