<?php

namespace App\Http\Controllers;

use Exception;
use App\Project;
use SendGrid\Mail\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->title = __('Home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $delayed_projects = Project::getDelayedProjects();
        $data = [
            'title' => $this->title,
            'projects'          => Project::getProjectsByStatus(Project::ACTIVE),
            'totalProjectsCost' => Project::getTotalCostActiveProjects(),
            'totalProjectValue' => Project::getTotalValueOfActiveProjects(),
            'delayedProjects'   => $delayed_projects->count()
        ];

        return view('home', $data);
    }

}
