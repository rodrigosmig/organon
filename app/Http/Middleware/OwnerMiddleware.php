<?php

namespace App\Http\Middleware;

use Closure;
use App\Project;
use RealRashid\SweetAlert\Facades\Alert;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route()->hasParameter('project_id')) {
            $project = Project::find($request->route()->parameter('project_id'));
            
            if($project) {
                if($request->user()->checkUser($project->owner)) {
                    return $next($request);
                }
            }
            Alert::error(__('project.invalid_request'), __('project.messages.not_owner'));
            return redirect()->route('projects.index');
        }
        
        return $next($request);
    }
}
