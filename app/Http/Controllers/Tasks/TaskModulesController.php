<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskModuleRequest;
use App\Task;
use App\TaskModule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = TaskModule::all();
        return view('tasks.module.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.module.new');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskModuleRequest $request)
    {
        $module = new TaskModule;
        $module->name = $request->get('name');
        $module->is_active = $request->get('is_active');
        $module->save();

        return redirect()->route('task-modules.index')->with('success', 'Task module added.');
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
        $module = TaskModule::find($id);
        return view('tasks.module.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskModuleRequest $request, $id)
    {
        $module = TaskModule::find($id);
        $module->name = $request->get('name');
        $module->is_active = $request->get('is_active');
        $module->save();

        return redirect()->route('task-modules.index')->with('success', 'Task module updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Task::where('module_id', $id)->exists())
            throw ValidationException::withMessages(['module' => 'This module is currently used by other tasks!']);

        TaskModule::destroy($id);
        return redirect()->route('task-modules.index')->with('success', 'Task module deleted.');
    }
}
