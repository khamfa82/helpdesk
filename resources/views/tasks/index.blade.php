@extends('tasks.layout')

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            @php
                $page_name = $_GET['name'] ?? "All Tasks";
            @endphp
            <h3 class="box-title">{{ $page_name }}</h3>
        </div>
        <div class="box-body">
            <div class="mailbox-messages" id="refresh">
                <!--datatable-->
                 <table class="table table-bordered no-footer" id="tasks_table">
                    <thead>
                        <tr>
                            <th>{!! Lang::get('lang.task-id') !!}</th>
                            <th>{!! Lang::get('lang.subject') !!}</th>
                            <th>{!! Lang::get('lang.module') !!}</th>
                            <th>{!! Lang::get('lang.status') !!}</th>
                            <th>{!! Lang::get('lang.priority') !!}</th>
                            <th>{!! Lang::get('lang.assigned_to') !!}</th>
                            <th>{!! Lang::get('lang.due_date') !!}</th>
                            <th style="width: 160px">{!! Lang::get('lang.action') !!}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                            <tr @if($task->status->is_done) class="bg-success" @endif>
                                <td>{{ $task->id}}</td>
                                <td>{{ substr(($task->description ?? "N/A"), 0, 100) }}</td>
                                <td>{{ $task->module->name ?? "N/A" }}</td>
                                <td>{{ $task->status->name ?? "N/A" }}</td>
                                <td>{{ $task->priority->name ?? "N/A" }}</td>
                                <td>{!! $task->assigned ? ($task->assigned->first_name . " " . $task->assigned->last_name) : "<label style='color: red'>Not Assigned</label>" !!}</td>
                                <td>{{ $task->due_date ? date("d-F-Y H:i", strtotime($task->due_date)) : "Not Set"}}</td>
                                <td>
                                    <form onsubmit="return confirm('Are you sure? This action can not be undone!');" action="/tasks/{{$task->id}}" method="post">
                                        @csrf
                                        @method("delete")
                                        <a href="/tasks/{{ $task->id }}" type="button" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> View</a>
                                        @if (auth()->user()->is_tasks_admin)
                                            <button href="/tasks/{{ $task->id }}" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete</button>
                                        @endif
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