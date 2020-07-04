<?php

namespace App\Http\Middleware;

use Closure;
use App\Task;
use App\Project;
use RealRashid\SweetAlert\Facades\Alert;

class TaskOwnerMiddleware
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
            $project = Project::where('id', $request->route()->parameter('project_id'))
                        ->where('owner_id', auth()->user()->id)
                        ->first();
            if ($project) {
                return $next($request);
            }
        }

        if ($request->route()->hasParameter('id')) {
            $id = $request->route()->parameter('id');
            $task = Task::where('id', $id)
                        ->first();

            if (! $task) {
                Alert::error(__('task.not_found'), __('task.messages.not_found'));
                return redirect()->route('tasks.my-tasks');
            }

            if ($task->user_id !== auth()->user()->id) {

                if ($task->project && $task->project->isOwner(auth()->user())) {
                    return $next($request);
                }

                Alert::error(__('task.not_found'), __('task.messages.not_found'));
                return redirect()->route('tasks.my-tasks');
            }
        }

        return $next($request);
    }
}
