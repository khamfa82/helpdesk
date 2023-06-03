@php
    // TODO: url activation on other pages such as new tasks
    $module = $_GET['module'] ?? 0;
    $priority = $_GET['priority'] ?? 0;
    $status = $_GET['status'] ?? 0;
    $mytasks = $_GET['mytasks'] ?? 0;

    $url = Request::path();
    $is_home = count(explode('/', $url)) == 1;
@endphp

<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <div class="user-panel">
        @if (trim($__env->yieldContent('profileimg')))
            <h1> @yield('profileimg') </h1>
        @else
            <div class = "row">
                <div class="col-xs-3"></div>
                <div class="col-xs-2" style="width:50%;">
                    <a href="{!! url('profile') !!}">
                        <img src="{{auth()->user()->profile_pic}}" class="img-circle" alt="User Image" />
                    </a>
                </div>
            </div>
        @endif
        <div class="info" style="text-align:center;">
            @if(!auth()->guest())
                <p>{{auth()->user()->first_name . " " . auth()->user()->last_name}}</p>
            @endif
            
            @if(!auth()->guest() && auth()->user()->active==1)
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            @else
                <a href="#"><i class="fa fa-circle"></i> Offline</a>
            @endif
        </div>
    </div>
    
    <ul id="side-bar" class="sidebar-menu">
        
        @yield('sidebar')
        <li class="header">{!! Lang::get('lang.tasks') !!}</li>
        
        @if (auth()->user()->is_tasks_admin)
            <li @if($url == 'tasks/create') class="active" @endif>
                <a href="/tasks/create" id="load-inbox">
                    <i class="fa fa-plus-square"></i> <span>{{ Lang::get('lang.new-import-tasks') }}</span>  
                </a>
            </li>
        @endif

        <li @if(!$module && !$status && !$priority && !$mytasks && $is_home && $url == 'tasks') class="active" @endif>
            <a href="/tasks" id="load-inbox">
                <i class="fa fa-square-o"></i> <span>{{ Lang::get('lang.all-tasks') }}</span>  <small class="label pull-right bg-green">{{ App\Task::count() }}</small> 
            </a>
        </li>

        <li @if($mytasks) class="active" @endif>
            <a href="/tasks?mytasks=true&name=My Tasks" id="load-inbox">
                <i class="fa fa-inbox"></i> <span>{{ Lang::get('lang.my-tasks') }}</span>  <small class="label pull-right bg-green">{{ App\Task::countTasksByUser() }}</small>
            </a>
        </li>

        {{--Tasks by Modules  --}}
        <li class="treeview @if($module) active @endif">
            <a href="#">
                <i class="fa fa-list"></i> <span>{!! Lang::get('lang.tasks-by-modules') !!}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            @foreach (App\TaskModule::where('is_active', 1)->get() as $task_module)   
                <ul class="treeview-menu">
                    <li @if($module == $task_module->id) class="active" @endif>
                        <a href="/tasks?module={{$task_module->id}}&name={{ $task_module->name }} Tasks" id="load-inbox">
                            <i class="fa fa-caret-right"></i> <span>{{ $task_module->name }}</span> <small class="label pull-right bg-green">{{ App\Task::countTasksByModule($task_module->id) }}</small>
                        </a>
                    </li>
                </ul>
            @endforeach
        </li>
        
        {{--Tasks by Priorities  --}}
        <li class="treeview @if($priority) active @endif">
            <a href="#">
                <i class="fa fa-sort-numeric-desc"></i> <span>{!! Lang::get('lang.tasks-by-priority') !!}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            @foreach (App\TaskPriority::all() as $task_priority)   
                <ul class="treeview-menu">
                    <li @if($priority == $task_priority->id) class="active" @endif>
                        <a href="/tasks?priority={{$task_priority->id}}&name={{ $task_priority->name }} Tasks" id="load-inbox">
                            <i class="fa fa-caret-right"></i> <span>{{ $task_priority->name }}</span> <small class="label pull-right bg-green">{{ App\Task::countTasksByPriority($task_priority->id) }}</small>
                        </a>
                    </li>
                </ul>
            @endforeach
        </li>

        {{-- Settings  --}}
        @if (auth()->user()->is_tasks_admin)
            <li class="treeview @if(explode('/', $url)[0] == 'task-modules' || explode('/', $url)[0] == 'task-statuses') active @endif">
                <a href="#">
                    <i class="fa fa-gear"></i> <span>{!! Lang::get('lang.task-settings') !!}</span> <i class="fa fa-angle-left pull-right"></i>
                </a> 
                <ul class="treeview-menu">
                    <li  @if(explode('/', $url)[0] == 'task-modules') class="active" @endif>
                        <a href="/task-modules?name=Task Modules" id="load-inbox">
                            <i class="fa fa-caret-right"></i> <span>Task Modules</span> 
                        </a>
                    </li>
                    <li @if(explode('/', $url)[0] == 'task-statuses') class="active" @endif>
                        <a href="/task-statuses?name=Task Statuses" id="load-inbox">
                            <i class="fa fa-caret-right"></i> <span>Task Statuses</span> 
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        <li class="header">{!! Lang::get('lang.tasks-by-status') !!}</li>

        {{-- Tasks by Status --}}
        @foreach (App\TaskStatus::where('is_active', 1)->get() as $task_status)   
            
            <li @if($status == $task_status->id) class="active" @endif>
                <a href="/tasks?status={{$task_status->id}}&name={{ $task_status->name }} Tasks" id="load-inbox">
                    <i class="fa fa-star"></i> <span>{{ $task_status->name }}</span> <small class="label pull-right bg-green">{{ App\Task::countTasksByStatus($task_status->id) }}</small>
                </a>
            </li>

        @endforeach        

    </ul>
</section>
<!-- /.sidebar -->