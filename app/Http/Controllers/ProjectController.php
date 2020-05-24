<?php

namespace App\Http\Controllers;

use App\Task;
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
        $this->title = 'Projects';
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
            //'projects'          => $projects
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
        return view('projects.new', ['title' => $this->title]);
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

        $project = Project::create([
            'name'      => $validated['name'],
            'deadline'  => $validated['deadline'],
            'owner_id'  => $request->user()->id
        ]);
        
        Alert::success(__('Success'), "The {$project->name} project was successfully created");
        
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
            Alert::error('Invalid Request.', 'This project is not active');
            return redirect()->route('projects.index');
        }
     
        $data = [
            'title'     => $this->title,
            'project'  => $project
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
            Alert::error('Invalid Request.', 'This project is not active');
            return redirect()->route('projects.index');
        }

        $validated = $request->validated();
        
        $project->name      = $validated['name'];
        $project->deadline  = $validated['deadline'];
        $project->save();

        Alert::success("Success", ("The project was successfully changed"));

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
            Alert::error('Invalid Request.', 'This project is not active');
            return redirect()->route('projects.index');
        }

        $project->tasks()->delete();
        $project->delete();

        Alert::success(__("Success"), (__("The project was successfully deleted")));
        
        return redirect()->route('projects.index');
    }

    public function addMember(ProjectMemberRequest $request)
    {
        $project    = Project::find($request->input("project_id"));
        $user       = User::find($request->input('user_id'));

        if ($user->checkUser($project->owner)) {
            Alert::error('Invalid User.', 'User is project owner.');
            return redirect()->route('projects.show', ['id' => $project->id]);
        }

        if($project->isMember($user)) {
            Alert::error('Invalid User.', 'User already belongs to the project.');
            return redirect()->route('projects.show', ['id' => $project->id]);
        }

        $project->addMember($user);

        Alert::success('User Added.', "User " . $user->name . " has been added to the project.");
        return redirect()->route('projects.show', ['id' => $project->id]);
    }

    public function ajaxRemoveMember(ProjectMemberRequest $request)
    {
        $user       = User::find($request->input('user_id'));
        $project    = Project::find($request->input('project_id'));

        if ($user->checkUser($project->owner)) {
            return response($user->name . " is the project owner.", 403);
        }

        if(!$project->isMember($user)) {
            return response($user->name . " is not a project member.", 403);
        }

        if (!$project->getTasksByUserId($user->id)->isEmpty()) {
            return response("It is not possible to remove the user because he has a task assigned.", 403);
        }

        $project->members()->detach([$user->id]);
        
        return response($user->name . " was removed from the project.", 200);
    }

    public function finishProject($id) {
        $project = Project::find($id);
        
        if ($project->status !== Project::ACTIVE) {
            Alert::error('Invalid Request.', 'This project is not active');
            return redirect()->route('projects.index');
        }

        $project->status = Project::FINISHED;
        $project->save();

        Alert::success("Sucess", "Status changed successfully.");
        return redirect()->route('projects.index');
    }

    public function openProject($id) {
        $project = Project::find($id);
        
        if ($project->status !== Project::FINISHED) {
            Alert::error('Invalid Request.', 'This project is not finished');
            return redirect()->route('projects.index');
        }

        $project->status = Project::ACTIVE;
        $project->save();

        Alert::success("Sucess", "Status changed successfully.");
        return redirect()->route('projects.index');
    }
}
