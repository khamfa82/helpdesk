<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskImportRequest;
use App\Http\Requests\TaskRequest;
use App\Task;
use App\TaskModule;
use App\TaskPriority;
use App\TaskStatus;
use App\TaskThread;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mytasks = $request->get('mytasks');
        $module = $request->get('module');
        $status = $request->get('status');
        $priority = $request->get('priority');

        $tasks = Task::where('id', '!=', 0);

        if ($status)
            $tasks = $tasks->where('status_id', $status);
        if ($module)
            $tasks = $tasks->where('module_id', $module);
        if ($priority)
            $tasks = $tasks->where('priority_id', $priority);
        if ($mytasks)
            $tasks = $tasks->where('assigned_to', auth()->user()->id)
                        ->whereHas('status', function ($status) { 
                            $status->where('is_done', 0); 
                        });
                    
        $tasks = $tasks->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorities = TaskPriority::all();
        $modules = TaskModule::all();
        $statuses = TaskStatus::all();
        $users = User::all();

        return view('tasks.new', compact('statuses', 'priorities', 'modules', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = new Task;
        $task->assigned_to = $request->get('assigned_to');
        $task->module_id = $request->get('module');
        $task->status_id = $request->get('status');
        $task->priority_id = $request->get('priority');
        $task->due_date = $request->get('due_date');
        $task->description = $request->get('description');
        $task->save();

        return redirect()->route('tasks');
    }
    
    public function import(TaskImportRequest $request)
    {
        $import_data = json_decode($request->get('import_data'));
       
        foreach ($import_data as $data) {
            
            $module = TaskModule::firstOrCreate(['name' => $data->module]);
            $status = TaskStatus::firstOrCreate(['name' => $data->status ?? "-"]);
            if(TaskPriority::where(['id' => $data->priority ?? "-"])->exists()) {
                $priorityId = TaskPriority::find($data->priority)->id;
            }else {
                $priorityId = 4;
            }
            $assigned_to = User::where(['email' => $data->assigned_to ?? "-"])->first();

            if (Task::where('id', $data->task_id)->exists())
                continue;

            $task = new Task;
            $task->id = $data->task_id;
            $task->assigned_to = $assigned_to ? $assigned_to->id : NULL;
            $task->module_id = $module->id;
            $task->status_id = $status->id == '-' ? NULL : $status->id;
            $task->priority_id = $priorityId;
            $task->due_date = $data->due_date == '-' ? NULL : $data->due_date;
            $task->description = $data->description ?? "N/A";
            $task->save();
        }

        return redirect()->route('tasks.index')->with('success', 'Tasks have been imported.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        $task_thread = TaskThread::where('task_id', $id)->get();

        $priorities = TaskPriority::all();
        $modules = TaskModule::all();
        $statuses = TaskStatus::all();
        $users = User::all();

        return view('tasks.view', compact('task', 'task_thread' ,'statuses', 'priorities', 'modules', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'assigned_to' => 'required'
        ])->validate();
        
        // return response()->json($request->all());
        $task = Task::find($id);
        if ($request->has('assigned_to'))
            $task->assigned_to = $request->get('assigned_to');
        if ($request->has('module'))
            $task->module_id = $request->get('module');
        if ($request->has('status'))
            $task->status_id = $request->get('status');
        if ($request->has('priority'))
            $task->priority_id = $request->get('priority');
        if ($request->has('due_date'))
            $task->due_date = $request->get('due_date');
        if ($request->has('description'))
            $task->description = $request->get('description');
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);
        return redirect()->route('tasks.index')->with('success', 'Task deleted');
    }
}
