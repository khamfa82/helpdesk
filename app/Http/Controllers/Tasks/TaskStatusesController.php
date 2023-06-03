<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskStatusRequest;
use App\TaskStatus;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Predis\Response\Status;

class TaskStatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = TaskStatus::all();
        return view('tasks.status.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.status.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskStatusRequest $request)
    {
        $status = new TaskStatus;
        $status->name = $request->get('name');
        $status->is_active = $request->get('is_active');
        $status->is_done = $request->get('is_done');
        $status->save();

        return redirect()->route('task-statuses.index')->with('success', 'Task status added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = TaskStatus::find($id);
        return view('tasks.status.edit', compact('status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskStatusRequest $request, $id)
    {
        $status = TaskStatus::find($id);
        $status->name = $request->get('name');
        $status->is_active = $request->get('is_active');
        $status->is_done = $request->get('is_done');
        $status->save();

        return redirect()->route('task-statuses.index')->with('success', 'Task status updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Task::where('status_id', $id)->exists())
            throw ValidationException::withMessages(['status' => 'This status is currently used by other tasks!']);

        TaskStatus::destroy($id);
        return redirect()->route('task-statuses.index')->with('success', 'Task status deleted.');
    }
}
