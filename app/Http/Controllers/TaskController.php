<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Project;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskTimeRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreTaskFormRequest;
use App\Http\Requests\AssignTaskMemberRequest;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->title = __('task.tasks');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title'     => $this->title,
            'projects'  => Task::getUserTasksGroupedByProjects()
        ];

        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskFormRequest $request)
    {
        $validated = $request->validated();
        
        $project = Project::find($validated['project_id']);

        if (!$project) {
            Alert::warning('Not Found', "Project Not Found");
            return redirect()->route('projects.index');
        }

        $task = Task::create([
            'description'   => $validated['description'],
            'deadline'      => $validated['deadline'],
            'project_id'    => $project->id
        ]);
        
        Alert::success('Success', "The task was successfully created");
        
        return redirect()->route('projects.show', ['id' => $project->id]);
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
    public function edit($project_id, $id)
    {
        $task       = Task::find($id);
        $project    = Project::find($project_id);

        if (!$project) {
            Alert::warning('Not Found', 'Project Not Found');
            return redirect()->route('projects.index');
        }

        if (!$task) {
            Alert::warning('Not Found', 'Task Not Found');
            return redirect()->route('projects.index');
        }

        if (!$task->checkByProjectId($project->id)) {
            Alert::warning('Invalid Request', 'The task does not belong to the project.');
            return redirect()->route('projects.index');
        }

        $data = [
            'title'     => $this->title,
            'task'      => $task,
            'project'   => $project
        ];

        return view('tasks.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskFormRequest $request, $project_id, $id)
    {
        $task       = Task::find($id);
        $project    = Project::find($project_id);

        if (!$project) {
            Alert::warning('Not Found', 'Project Not Found');
            return redirect()->route('projects.index');
        }

        if (!$task) {
            Alert::warning('Not Found', 'Task Not Found');
            return redirect()->route('projects.index');
        }

        if (!$task->checkByProjectId($project->id)) {
            Alert::warning('Invalid Request', 'The task does not belong to the project.');
            return redirect()->route('projects.index');
        }

        $validated = $request->validated();
        
        $task->description  = $validated['description'];
        $task->deadline     = $validated['deadline'];
        $task->save();

        Alert::success('Success', 'The task was successfully changed');

        return redirect()->route('projects.show', ['id' => $project->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($project_id, $id)
    {
        $task       = Task::find($id);
        $project    = Project::find($project_id);

        if (!$project) {
            Alert::warning('Not Found', 'Project Not Found');
            return redirect()->route('projects.index');
        }

        if (!$task) {
            Alert::warning('Not Found', 'Task Not Found');
            return redirect()->route('projects.index');
        }

        if (!$task->checkByProjectId($project->id)) {
            Alert::warning('Invalid Request', 'The task does not belong to the project.');
            return redirect()->route('projects.index');
        }

        if ($task->user) {
            Alert::warning('Ops...', 'Task with an assigned user. Remove the user from the task.');
            return redirect()->route('projects.show', ['id' => $project->id]);
        }

        $task->delete();

        Alert::success('Success', 'The task was successfully deleted');

        return redirect()->route('projects.show', ['id' => $project->id]);
    }

    public function assignTaskMember(AssignTaskMemberRequest $request)
    {
        $user       = User::find($request->input('user_id'));
        $task       = Task::find($request->input('task_id'));

        if ($task->user) {
            Alert::error('Invalid Task.', 'Task already has a user assigned.');
            return redirect()->route('projects.show', ['id' => $task->project->id]);
        }

        $task->user()->associate($user);
        $task->save();
        
        Alert::success('Success.', 'User successfully assigned.');
        return redirect()->route('projects.show', ['id' => $task->project->id]);
    }

    public function removeTaskMember($project_id, $id)
    {
        $task       = Task::find($id);
        $project    = Project::find($project_id);

        if (!$task) {
            Alert::error('Invalid Task.', 'Task not found.');
            return redirect()->route('projects.index');
        }

        if (!$project) {
            Alert::error('Invalid Project.', 'Project not found.');
            return redirect()->route('projects.index');
        }

        if (!$task->checkByProjectId($project->id)) {
            Alert::error('Invalid Task.', 'The task does not belong to the project.');
            return redirect()->route('projects.index');
        }

        if (!$task->user) {
            Alert::error('Invalid Task.', 'Task has no user assigned.');
            return redirect()->route('projects.show', ['id' => $task->project->id]);
        }

        $task->user()->dissociate();
        $task->save();
        
        Alert::success('Success.', 'User successfully removed.');
        return redirect()->route('projects.show', ['id' => $task->project->id]);
    }

    public function ajaxUpdateTaskTime(TaskTimeRequest $request)
    {
        $type       = $request->input('type');
        $task       = Task::find($request->input('task_id'));

        if (!in_array($type, ['start', 'pause', 'reset'])) {
            return response(json_encode(['status'=>'error', 'msg'=>"Request not allowed."]), Response::HTTP_FORBIDDEN);
        }

        $response = $task->updateTime($type);

        if ($response['status'] === 'success') {
            return response(json_encode($response), Response::HTTP_OK);
        }

        return response(json_encode($response), Response::HTTP_BAD_REQUEST);
    }

    public function finishTask(TaskTimeRequest $request)
    {
        $task = Task::find($request->input('task_id'));

        if ($task->taskInProgress()) {
            Alert::error('Invalid Request.', 'Unable to finish task. Task with time in progress.');
            return redirect()->route('tasks.my-tasks');
        }

        if ($task->getTotalWorkedByUser(Auth::user()->id) <= 0) {
            Alert::error('Invalid Request.', 'Unable to finish task. Time worked not started.');
            return redirect()->route('tasks.my-tasks');
        }

        if (! $task->finishTask()) {
            Alert::error('Invalid Request.', 'Task is not open.');
            return redirect()->route('tasks.my-tasks');
        }

        $task->save();

        Alert::success('Success.', 'Task successfully completed.');
        return redirect()->route('tasks.my-tasks');
    }

    public function openTask(TaskTimeRequest $request)
    {
        $task = Task::find($request->input('task_id'));

        if (! $task->openTask()) {
            Alert::error('Invalid Request.', 'Task is not finished.');
            return redirect()->route('tasks.my-tasks');
        }

        $task->save();

        Alert::success('Success.', 'Task successfully opened.');
        return redirect()->route('tasks.my-tasks');
    }
}
