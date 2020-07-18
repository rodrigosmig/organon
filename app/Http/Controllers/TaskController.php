<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Notifications\OpenTask;
use App\Notifications\CompletedTask;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AddTaskComment;
use App\Http\Requests\TaskTimeRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreTaskFormRequest;
use App\Http\Requests\StoreUpdateCommentRequest;

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
            'title'             => $this->title,
            'open_tasks'        => Task::getTasksByStatus(Task::OPEN),
            'finished_tasks'    => Task::getTasksByStatus(Task::FINISHED)
        ];
        //dd($data);
        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title'     => $this->title,
            'clients'   => auth()->user()->getClients(),
            'projects'  => Project::getProjectsByStatus(Project::ACTIVE)
        ];

        return view('tasks.new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskFormRequest $request)
    {
        $data       = $request->except('_token');
        $project    = Project::find($data['project_id']);

        if ($project && !is_null($data['client_id'])) {
            if ($project->client && $project->client->id != $data['client_id']) {
                Alert::error(__('Ops...'), __('task.messages.different_client'));
                return redirect()->route('tasks.create');
            }
        }

        $task = Task::create([
            'name'          => $data['name'],
            'description'   => $data['description'],
            'deadline'      => $data['deadline'],
            'project_id'    => $data['project_id'],
            'client_id'     => $data['client_id'],
            'user_id'       => $data['user_id'],
        ]);
        Alert::success(__('task.success'), __('task.messages.task_created'));

        if ($task->project) {
            return redirect()->route('projects.show', $task->project->id);
        }
        
        return redirect()->route('tasks.my-tasks');
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

        $data = [
            'title'     => $this->title,
            'task'      => $task,
            'comments'  => $task->getComments()
        ];

        return view('tasks.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        
        if ($task->project && ! $task->project->isOwner(auth()->user())) {
            Alert::error(__('task.invalid_request'), __('task.messages.not_allowed'));
            return redirect()->route('tasks.my-tasks');
        }

        $data = [
            'title'     => $this->title,
            'task'      => $task,
            'clients'   => auth()->user()->getClients(),
            'projects'  => Project::getProjectsByStatus(Project::ACTIVE)
        ];

        return view('tasks.edit', $data);
    }

    public function editProjectTask($id)
    {
        $task = Task::find($id);
        
        $data = [
            'title'     => $this->title,
            'task'      => $task,
            'members'   => $task->project->getAllProjectMembers(),
        ];

        return view('tasks.edit-project-task', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskFormRequest $request, $id)
    {
        $task = Task::find($id);
        
        $validated = $request->validated();

        $task->name  = $validated['name'];
        $task->description  = $validated['description'];
        $task->deadline     = $validated['deadline'];
        $task->project_id   = $validated['project_id'];
        $task->client_id    = $validated['client_id'];

        $task->save();

        Alert::success(__('task.success'), __('task.messages.task_updated'));

        return redirect()->route('tasks.my-tasks');
    }

    public function updateProjectTask(StoreTaskFormRequest $request, $id)
    {
        $task = Task::find($id);
        
        $validated = $request->validated();

        $task->name         = $validated['name'];
        $task->description  = $validated['description'];
        $task->deadline     = $validated['deadline'];
        $task->user_id      = $validated['user_id'];

        $task->save();

        Alert::success(__('task.success'), __('task.messages.task_updated'));

        return redirect()->route('projects.show', $task->project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task->project && ! $task->project->isOwner(auth()->user())) {
            Alert::error(__('task.invalid_request'), __('task.messages.not_allowed'));
            return redirect()->route('tasks.my-tasks');
        }

        $task->delete();

        Alert::success(__('task.success'), __('task.messages.task_deleted'));

        if (! $task->project) {
            return redirect()->route('tasks.my-tasks');
        }

        return redirect()->route('projects.show', $task->project->id);
    }

    public function ajaxUpdateTaskTime(TaskTimeRequest $request)
    {
        $type       = $request->input('type');
        $task       = Task::find($request->input('task_id'));

        if (!in_array($type, ['start', 'pause', 'reset'])) {
            return response(json_encode(['status'=>'error', 'msg'=>__('task.request_not_allowed')]), Response::HTTP_FORBIDDEN);
        }

        $response = $task->updateTime($type);

        if ($response['status'] === 'success') {
            return response(json_encode($response), Response::HTTP_OK);
        }

        return response(json_encode($response), Response::HTTP_BAD_REQUEST);
    }

    public function finishTask($id)
    {
        $task = Task::find($id);

        if ($task->taskInProgress()) {
            Alert::error(__('task.invalid_request'), __('task.messages.time_in_progress'));
            return redirect()->route('tasks.my-tasks');
        }

        if ($task->getTotalWorkedByUser(Auth::user()->id) <= 0) {
            Alert::error(__('task.invalid_request'), __('task.messages.time_not_started'));
            return redirect()->route('tasks.my-tasks');
        }

        if (! $task->finishTask()) {
            Alert::error(__('task.invalid_request'), __('task.messages.is_not_open'));
            return redirect()->route('tasks.my-tasks');
        }

        $task->save();

        if ($task->project && !$task->project->isOwner($task->user)) {
            $task->project->owner->notify(new CompletedTask($task));
        }
        
        Alert::success(__('task.success'), __('task.messages.task_completed'));
        return redirect()->route('tasks.my-tasks');
    }

    public function openTask($id)
    {
        $task = Task::find($id);

        if (! $task->openTask()) {
            Alert::error(__('task.invalid_request'), __('task.messages.is_not_finished'));
            return redirect()->route('tasks.my-tasks');
        }

        $task->save();

        if ($task->project && !$task->project->isOwner($task->user)) {
            $task->project->owner->notify(new OpenTask($task));
        }

        Alert::success(__('task.success'), __('task.messages.task_opened'));
        return redirect()->route('tasks.my-tasks');
    }

    public function commentTask(StoreUpdateCommentRequest $request, $id)
    {
        $task = Task::find($id);

        $comment = $task->addComment($request->all());

        if ($task->project->isOwner(auth()->user())) {
            $task->user->notify(new AddTaskComment($comment));
        } else {
            $task->project->owner->notify(new AddTaskComment($comment));
        }

        Alert::success(__('comments.success'), __('comments.messages.add_comment'));
        return redirect()->route('tasks.show', $task->id);
    }
}
