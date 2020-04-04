<?php

namespace App\Http\Middleware;

use Closure;
use App\Project;

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
        if ($request->route()->hasParameter('id')) {
            $project = Project::find($request->route()->parameter('id'));
            
            if($project) {
                if($request->user()->checkUser($project->owner)) {
                    return $next($request);
                }
            }
        }
        return redirect()->route('projects.index');
    }
}
