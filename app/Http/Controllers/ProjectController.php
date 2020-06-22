<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\ProjectMemberRequest;
use App\Http\Requests\StoreProjectFormRequest;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->title = __('project.projects');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $open_projects      = Project::getProjectsByStatus(Project::ACTIVE);
        $finished_projects  = Project::getProjectsByStatus(Project::FINISHED);

        $data = [
            'title'             => $this->title,
            'open_projects'     => $open_projects,
            'finished_projects' => $finished_projects,
        ];

        return view('projects.index', $data);
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
            'clients'   => auth()->user()->getClients()
        ];

        return view('projects.new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreProjectFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectFormRequest $request)
    {
        $validated = $request->validated();
        //dd($request->all(), $validated['client']);
        $project = Project::create([
            'name'              => $validated['name'],
            'deadline'          => $validated['deadline'],
            'owner_id'          => $request->user()->id,
            'amount_charged'    => $request->input('amount_charged', 0.0),
            'client_id'         => $validated['client']
        ]);
        
        Alert::success(__('project.success'), __('project.messages.new'));
        
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
        $project = Project::find($id);

        $members = [];
        foreach ($project->getAllProjectMembers() as $member) {
            $member->total_worked = $project->getTotalWorkedOnProjectByUserId($member->id);
            $members[] = $member;
        }

        $data = [
            'title'         => $this->title,
            'project'       => $project,
            'members'       => $members,
            'total_worked'  => $project->getTotalWorkedOnProject()
        ];

        return view('projects.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);

        if ($project->status === Project::FINISHED) {
            Alert::error(__('project.invalid_request'), __('project.messages.not_active'));
            return redirect()->route('projects.index');
        }
     
        $data = [
            'title'     => $this->title,
            'project'   => $project,
            'clients'   => $project->owner->getClients()
        ];

        return view('projects.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\StoreProjectFormRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjectFormRequest $request, $id)
    {
        $project = Project::find($id);

        if ($project->status === Project::FINISHED) {
            Alert::error(__('project.invalid_request'), __('project.messages.not_active'));
            return redirect()->route('projects.index');
        }

        $validated = $request->validated();

        $project->name              = $validated['name'];
        $project->deadline          = $validated['deadline'];
        $project->amount_charged    = $request->input('amount_charged', 0.0);
        $project->client_id         = $validated['client'];
        $project->save();

        Alert::success(__('project.success'), __('project.messages.update'));

        return redirect()->route('projects.show', ['id' => $project->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id, Request $request)
    {
        $project = Project::find($id);

        if ($project->status === Project::FINISHED) {
            Alert::error(__('project.invalid_request'), __('project.messages.not_active'));
            return redirect()->route('projects.index');
        }
        
        if ($project->hasTaskInProgress()) {
            Alert::error(__('project.messages.not_delete'), __('project.messages.task_in_progress'));
            return redirect()->route('projects.index');
        }

        $project->tasks()->delete();
        $project->delete();

        Alert::success(__("project.success"), (__('project.messages.delete')));
        
        return redirect()->route('projects.index');
    }

    public function addMember(ProjectMemberRequest $request)
    {
        $project    = Project::find($request->input("project_id"));
        $user       = User::find($request->input('user_id'));
        $hour_value = $request->input('hour_value', 0);
        
        if ($user->checkUser($project->owner)) {
            Alert::error(__("project.invalid_user"), __("project.messages.owner"));
            return redirect()->route('projects.show', ['id' => $project->id]);
        }

        if($project->isMember($user)) {
            Alert::error(__("project.invalid_user"), __("project.messages.is_member"));
            return redirect()->route('projects.show', ['id' => $project->id]);
        }

        $project->addMember($user, $hour_value);

        Alert::success(__('project.user_added'), __("project.messages.add_user"));
        return redirect()->route('projects.show', ['id' => $project->id]);
    }

    public function ajaxRemoveMember(ProjectMemberRequest $request)
    {
        $user       = User::find($request->input('user_id'));
        $project    = Project::find($request->input('project_id'));

        if ($user->checkUser($project->owner)) {
            return response(__('project.messages.owner'), 403);
        }

        if(!$project->isMember($user)) {
            return response(__('project.messages.is_not_member'), 403);
        }

        if (!$project->getTasksByUserId($user->id)->isEmpty()) {
            return response(__('project.messages.task_assigned'), 403);
        }

        $project->members()->detach([$user->id]);
        
        return response(__('project.messages.remove_member'), 200);
    }

    public function finishProject($id) {
        $project = Project::find($id);
        
        if ($project->status !== Project::ACTIVE) {
            Alert::error(__('project.invalid_request'), __('project.messages.not_active'));
            return redirect()->route('projects.index');
        }

        if ($project->hasOpenTask()) {
            Alert::error(__('project.messages.not_finish'), __('project.messages.open_task'));
            return redirect()->route('projects.index');
        }

        $project->status = Project::FINISHED;
        $project->save();

        Alert::success(__('project.success'), __('project.messages.status_finish'));
        return redirect()->route('projects.index');
    }

    public function openProject($id) {
        $project = Project::find($id);
        
        if ($project->status !== Project::FINISHED) {
            Alert::error(__('project.invalid_request'), __('project.messages.not_finished'));
            return redirect()->route('projects.index');
        }

        $project->status = Project::ACTIVE;
        $project->save();

        Alert::success(__('project.success'), __('project.messages.status_open'));
        return redirect()->route('projects.index');
    }

    public function search(Request $request)
    {
        if (empty($request->project_name)) {
            Alert::warning(__('project.no_search_word'), __('project.search_word'));
            return redirect()->route('home');
        }
        
        $filters = $request->except('_token');
        
        $projects = Project::search($request->project_name);

        return view('projects.search', [
            'projects' => $projects,
            'filters' => $filters
        ]);
    }
}
