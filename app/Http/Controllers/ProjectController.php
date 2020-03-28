<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\StoreProjectFormRequest;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->title = __('Projects');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $projects = Project::getProjectsByOwnerId(Auth::user()->id);

        $data = [
            'title'     => $this->title,
            'projects'  => $projects
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

        $data = [
            'title'     => $this->title,
            'project'   => $project,
            'owner'     => $project->getOwner()
        ];

        return view('projects.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $project = Project::find($id);

        if (!$project) {
            Alert::error(__("Invalid Project"), (__("Project not found.")));
            return redirect()->route('projects.index');
        }
        
        if ($project->owner_id !== $request->user()->id) {
            Alert::error(__("Invalid Request"), (__("You are not project owner.")));
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

        if (!$project) {
            Alert::error(__("Invalid Project"), (__("Project not found.")));
            return redirect()->route('projects.index');
        }
        
        if ($project->owner_id !== $request->user()->id) {
            Alert::error(__("Invalid Request"), (__("You are not project owner.")));
            return redirect()->route('projects.index');
        }

        $validated = $request->validated();
        
        $project->name      = $validated['name'];
        $project->deadline  = $validated['deadline'];
        $project->save();

        Alert::success(__("Success"), (__("The project was successfully changed")));

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

        if (!$project) {
            Alert::error(__("Invalid Project"), (__("Project not found.")));
            return redirect()->route('projects.index');
        }
        
        if ($project->owner_id !== $request->user()->id) {
            Alert::error(__("Invalid Request"), (__("You are not project owner.")));
            return redirect()->route('projects.index');
        }

        $project->delete();

        Alert::success(__("Success"), (__("The project was successfully deleted")));
        
        return redirect()->route('projects.index');
    }

    public function addMember(Request $request)
    {
        if ($request->input('user') && $request->input("project_id")) {
            $project_id = $request->input("project_id");
            $user_id    = $request->input('user');

            $project    = Project::find($project_id);
            
            if (!$project) {
                Alert::error(__('Invalid Project.'), __('Project not found.'));
                return redirect()->route('projects.index');
            }

            $user = User::find($request->input('user'));

            if (!$user) {
                Alert::error(__('Invalid User.'), __('User not found.'));
                return redirect()->route('projects.index');
            }
            
            if ($user->checkUser($project->getOwner())) {
                Alert::error(__('Invalid User.'), __('User is project owner.'));
                return redirect()->route('projects.index');
            }

            if($project->users->contains($user_id)) {
                Alert::error(__('Invalid User.'), __('User already belongs to the project.'));
                return redirect()->route('projects.index');
            }

            $project->users()->attach($user->id);

            Alert::success(__('User Added.'), __("User " . $user->name . " has been added to the project."));
            return redirect()->route('projects.index');
        }

        dd(777);
        /* checkar se usuario existe
        checkar se já está no projeto */
    }
}
