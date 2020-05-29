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
        $data = [
            'title' => $this->title,
            'totalProjectsCost' => Project::getTotalCostActiveProjects(),
            'totalProjectValue' => Project::getTotalValueOfActiveProjects(),
            'delayedProjects'   => Project::getDelayedProjects()->count()
        ];

        return view('home', $data);
    }

}
