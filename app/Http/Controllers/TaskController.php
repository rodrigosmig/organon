<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreTaskFormRequest;
use App\Http\Requests\TaskValidationRequest;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->title = "Tasks";
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
    public function edit(Request $request, $project_id, $id)
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
    public function destroy(Request $request, $project_id, $id)
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

    public function assignTaskMember(Request $request)
    {
        $user       = User::find($request->input('user_id'));
        $task       = Task::find($request->input('task_id'));
        $project    = Project::find($request->input('project_id'));

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

        if ($task->user) {
            Alert::error('Invalid Task.', 'Task already has a user assigned.');
            return redirect()->route('projects.show', ['id' => $task->project->id]);
        }

        if (!$user) {
            Alert::error('Invalid User.', 'User not found.');
            return redirect()->route('projects.show', ['id' => $task->project->id]);
        }

        $task->user()->associate($user);
        $task->save();
        
        Alert::success('Success.', 'User successfully assigned.');
        return redirect()->route('projects.show', ['id' => $task->project->id]);
    }

    public function removeTaskMember(Request $request, $project_id, $id)
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

    public function ajaxUpdateTaskTime(Request $request)
    {
        $type       = $request->input('type');
        $user       = User::find($request->input('user_id'));
        $task       = Task::find($request->input('task_id'));
        $project    = Project::find($request->input('project_id'));

        if (!$user) {
            return response(json_encode(['status'=>'error', 'msg'=>"User not found."]), Response::HTTP_NOT_FOUND);
        }
        
        if(!$project->isMember($user)) {
            return response(json_encode(['status'=>'error', 'msg'=>"User is not a member of the project."]), Response::HTTP_FORBIDDEN);
        }
        
        if (!$task) {
            return response(json_encode(['status'=>'error', 'msg'=>"Task not found."]), Response::HTTP_NOT_FOUND);
        }
        
        if (!$project) {
            return response(json_encode(['status'=>'error', 'msg'=>"Project not found."]), Response::HTTP_NOT_FOUND);
        }
        
        if ($task->project->id !== $project->id) {
            return response(json_encode(['status'=>'error', 'msg'=>"Invalid Task."]), Response::HTTP_FORBIDDEN);
        }
        
        if (!$user->checkUser($task->user)) {
            return response(json_encode(['status'=>'error', 'msg'=>"Request not allowed."]), Response::HTTP_FORBIDDEN);
        }
        
        if (!in_array($type, ['start', 'pause', 'reset'])) {
            return response(json_encode(['status'=>'error', 'msg'=>"Request not allowed."]), Response::HTTP_FORBIDDEN);
        }

        $response = $task->updateTime($type);

        if ($response['status'] === 'success') {
            return response(json_encode($response), Response::HTTP_OK);
        }

        return response(json_encode($response), Response::HTTP_BAD_REQUEST);
    }

    public function finishTask(TaskValidationRequest $request)
    {
        $user       = User::find($request->input('user_id'));
        $task       = Task::find($request->input('task_id'));
        $project    = Project::find($request->input('project_id'));

        if (!$user) {
            Alert::error('Not Found.', 'User not found.');
            return redirect()->route('tasks.my-tasks');
        }

        if(!$project->isMember($user)) {
            Alert::error('Invalid Request.', 'User is not a member of the project.');
            return redirect()->route('tasks.my-tasks');
        }

        if (!$task) {
            Alert::error('Not Found.', 'Task not found.');
            return redirect()->route('tasks.my-tasks');
        }

        if (!$project) {
            Alert::error('Not Found.', 'Project not found.');
            return redirect()->route('tasks.my-tasks');
        }

        if ($task->project->id !== $project->id) {
            Alert::error('Invalid Request.', 'Invalid Task.');
            return redirect()->route('tasks.my-tasks');
        }

        if (!$user->checkUser($task->user)) {
            Alert::error('Invalid Request.', 'Request not allowed.');
            return redirect()->route('tasks.my-tasks');
        }

        if ($task->getTotalWorkedByUser($user->id) <= 0) {
            Alert::error('Invalid Request.', 'Unable to finish task. Time worked not started.');
            return redirect()->route('tasks.my-tasks');
        }

        if ($task->taskInProgress()) {
            Alert::error('Invalid Request.', 'Unable to finish task. Task with time in progress.');
            return redirect()->route('tasks.my-tasks');
        }

        $task->status = Task::FINISHED;
        $task->save();

        Alert::success('Success.', 'Task successfully completed.');
        return redirect()->route('tasks.my-tasks');
    }
}
