@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">{{ __('task.my_tasks') }}</div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="open-tab" data-toggle="tab" href="#open" role="tab" aria-controls="open" aria-selected="true">{{ __('task.open') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="finished-tab" data-toggle="tab" href="#finished" role="tab" aria-controls="finished" aria-selected="false">{{ __('task.finished') }}</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="open" role="tabpanel" aria-labelledby="open-tab">
                    @if ($open_tasks->isNotEmpty())
                        <table class="table">
                            <thead>
                                <th>{{ __('project.project') }}</th>
                                <th>{{ __('task.description') }}</th>
                                <th>{{ __('task.deadline') }}</th>
                                <th>{{ __('task.worked_time') }}</th>
                                <th>{{ __('task.finish') }}</th>
                            </thead>

                            <tbody>
                                @foreach ($open_tasks as $task)
                                    <tr>
                                        <td>{{ $task->project->name }}</td>
                                        <td>{{ $task->description }}</td>
                                        <td>{{ $task->deadline }}</td>
                                        <td>
                                            <time-counter 
                                                total-worked="{{ $task->getTotalWorkedByUser($task->user->id) }}"
                                                project_id="{{ $task->project->id }}"
                                                user_id="{{ $task->user->id }}"
                                                task_id="{{ $task->id }}"
                                                msg_title="{{ __('task.messages.are_you_sure') }}"
                                                msg_message="{{ __('task.messages.all_task_restarted') }}"
                                                msg_confirm="{{ __('task.messages.yes_restart_it') }}"
                                                msg_cancel="{{ __('task.cancel') }}"
                                            ></time-counter>
                                        </td>
                                        <td>
                                            <a href="{{ route('tasks.finish-task', ['task_id'=>$task->id, 'project_id'=>$task->project->id]) }}" class="btn btn-circle btn-success" title="{{ __('task.finish_task') }}"><i class="fas fa-check"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h5 style="margin-top:20px">{{ __('task.no_task_found') }}.</h3>
                    @endif                    
                </div>
                <div class="tab-pane fade" id="finished" role="tabpanel" aria-labelledby="finished-tab">
                    @if ($finished_tasks->isNotEmpty())
                        <table class="table">
                            <thead>
                                <th>{{ __('task.description') }}</th>
                                <th>{{ __('task.deadline') }}</th>
                                <th>{{ __('task.worked_time') }}</th>
                                <th>{{ __('task.reopen_task') }}</th>
                            </thead>

                            <tbody>
                                @foreach ($finished_tasks as $task)
                                    <tr>
                                        <tr>
                                            <td>{{ $task->description }}</td>
                                            <td>{{ $task->deadline }}</td>
                                            <td>{{secondsToTime( $task->getTotalWorkedByUser($task->user->id)) }}</td>
                                            <td><a class="btn btn-sm btn-success" href="{{ route('tasks.open-task', ['task_id'=>$task->id, 'project_id'=>$task->project->id]) }}"><i class="fas fa-folder-open"></i></a></td>
                                        </tr>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h5 style="margin-top:20px">{{ __('task.no_task_found') }}.</h3>
                    @endif  
                </div>
            </div>
        </div>
    </div>
@endsection
