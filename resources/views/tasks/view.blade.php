@extends('tasks.layout')

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ Lang::get('lang.task') }} #{{$task->id}}</h3>
        </div>
        <div class="box-body">
            <div class="mailbox-messages" id="refresh">
                <form action="/tasks/{{ $task->id }}" method="post" style="padding: 15px !important">
                    @csrf
                    @method('put')
                    <div class="row">
                        {{-- Task Description --}}
                        <div class="col col-md-4 form-group">
                            <label for="description">Task Description</label>
                            @if (auth()->user()->is_tasks_admin)
                                <textarea style="resize: none" class="form-control" rows="9" name="description" id="description">{{ $task->description }}</textarea>
                            @else
                                <p style="height: 150px !important">{{ $task->description }}</p>
                            @endif
                        </div>

                        {{-- Assigned --}}
                        @php
                            $assigned_to = $task->assigned_to ?? 0;
                            $assigned_user = $task->assigned_to ? ($task->assigned->first_name . " " . $task->assigned->last_name) : "Not Assigned";
                        @endphp
                        <div class="col col-md-4 form-group">
                            <label for="assigned_to">Assigned To</label>
                            @if (auth()->user()->is_tasks_admin)
                                <select name="assigned_to" id="assigned_to" class="form-control">
                                    <option value="">-- Select Assigned Agent ---</option>
                                    @foreach ($users as $user)
                                        <option @if($assigned_to == $user->id) selected @endif value="{{ $user->id }}">{{ $user->first_name . " " . $user->last_name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <p> {{ $assigned_user }} </p>
                            @endif
                        </div>

                        {{-- Module --}}
                        <div class="col col-md-4 form-group">
                            <label for="module">Module (Category)</label>
                            @if (auth()->user()->is_tasks_admin)
                                <select name="module" id="module" class="form-control">
                                    <option value="">-- Select Task Module ---</option>
                                    @foreach ($modules as $module)
                                        <option @if($task->module_id == $module->id) selected @endif value="{{ $module->id }}">{{ $module->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <p>{{ $task->module->name }}</p>
                            @endif
                        </div>

                        {{-- Priority --}}
                        <div class="col col-md-4 form-group">
                            <label for="priority">Priority</label>
                            @if (auth()->user()->is_tasks_admin)
                                <select name="priority" id="priority" class="form-control">
                                    <option value="">-- Select Task Priority ---</option>
                                    @foreach ($priorities as $priority)
                                        <option @if($task->priority_id == $priority->id) selected @endif value="{{ $priority->id }}">{{ $priority->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <p>{{ $task->priority->name }}</p>
                            @endif
                        </div>

                        {{-- Status --}}
                        <div class="col col-md-4 form-group">
                            <label for="status">Status</label>
                            @if (auth()->user()->is_tasks_admin || auth()->user()->id == $task->assigned_to)
                                <select name="status" id="status" class="form-control">
                                    <option value="">-- Select Task Status ---</option>
                                    @foreach ($statuses as $status)
                                        <option @if($task->status_id == $status->id) selected @endif value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <p>{{ $task->status->name }}</p>
                            @endif
                        </div>

                        {{-- Due Date --}}
                        <div class="col col-md-4 form-group">
                            <label for="due_date">Due Date</label>
                            @if (auth()->user()->is_tasks_admin)
                                <input class="form-control" value="{{ $task->due_date }}" type="date" name="due_date" id="due_date">
                            @else
                                <p>{{ $task->due_date ?? "Not Set" }}</p>
                            @endif
                        </div>
                        
                        <div class="col col-md-4 form-group">
                            <label for="">_</label>
                            @if (auth()->user()->is_tasks_admin || auth()->user()->id == $task->assigned_to)
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i> Save</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ Lang::get('lang.task-thread') }}</h3>
        </div>
        <div class="box-body">
            <div class="mailbox-messages" id="refresh">
                
                @if (count($task_thread) > 0)
                    @foreach ($task_thread as $thread)
                        <div class="alert alert-default">
                            @if (auth()->user()->is_tasks_admin || auth()->user()->id == $thread->user_id)
                                <form onsubmit="confirm('Are you sure? This action can not be undone!');" action="/task-threads/{{ $thread->id }}" method="post">
                                    @csrf
                                    @method('delete')
                                    {{ $thread->user->first_name . " " . $thread->user->last_name }}
                                    <button type="submit" class="btn btn-danger btn-sm" style="float: right">Delete comment</button>
                                </form>
                            @endif
                            <div class="clear-both"></div>
                            <hr>
                            <div>
                                {{ $thread->description }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning text-center">No thread were found on this task</div>
                @endif

                <form action="/task-threads" method="post" style="padding: 15px !important">
                    @csrf
                    <div class="row">
                        {{-- Task Description --}}
                        <div class="col col-12 form-group">
                            <label for="description">Comment / Issue</label>
                            <input type="hidden" name="task" value="{{ $task->id }}">
                            <textarea style="resize: none" class="form-control" name="description" id="description"></textarea>
                        </div>
                        
                        <div class="col col-12 form-group">
                            <button type="submit" style="float: right" class="btn btn-success btn-block"></i> Post</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection