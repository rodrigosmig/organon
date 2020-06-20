@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection

@section('content')
    <div class="card">
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
                    @if (isset($projects[App\Task::OPEN]))
                        @foreach ($projects[App\Task::OPEN] as $key => $task)
                            <div class="accordion" id="project_tasks">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#project-{{ $key }}" aria-expanded="true" aria-controls="project">
                                            {{ $task['project_name'] }}
                                        </button>
                                        </h2>
                                    </div>            
                                    <div id="project-{{ $key }}" class="collapse" aria-labelledby="headingOne" data-parent="#project_tasks">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <th>{{ __('task.description') }}</th>
                                                    <th>{{ __('task.deadline') }}</th>
                                                    <th>{{ __('task.worked_time') }}</th>
                                                    <th>{{ __('task.finish') }}</th>
                                                </thead>

                                                <tbody>
                                                    @foreach ($task as $key => $item)
                                                        @if ($key !== 'project_name')
                                                            <tr>
                                                                <td>{{ $item->description }}</td>
                                                                <td>{{ $item->deadline }}</td>
                                                                <td>
                                                                    <time-counter 
                                                                        total-worked="{{ $item->getTotalWorkedByUser($item->user->id) }}"
                                                                        project_id="{{ $item->project->id }}"
                                                                        user_id="{{ $item->user->id }}"
                                                                        task_id="{{ $item->id }}"
                                                                    ></time-counter>
                                                                </td>
                                                                <td>
                                                                    <a href="{{ route('tasks.finish-task', ['task_id'=>$item->id, 'project_id'=>$item->project->id]) }}" class="btn btn-circle btn-success" title="{{ __('task.finish_task') }}"><i class="fas fa-check"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endif                                                    
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>        
                            </div>
                        @endforeach
                    @endif

                    @empty($projects[App\Task::OPEN])
                        <h5 style="margin-top:20px">{{ __('task.no_task_found') }}.</h3>
                    @endempty
                </div>
                <div class="tab-pane fade" id="finished" role="tabpanel" aria-labelledby="finished-tab">

                    @if (isset($projects[App\Task::FINISHED]))
                        @foreach ($projects[App\Task::FINISHED] as $key => $task)
                            <div class="accordion" id="project_tasks">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#project-{{ $key }}" aria-expanded="true" aria-controls="project">
                                            {{ $task['project_name'] }}
                                        </button>
                                        </h2>
                                    </div>            
                                    <div id="project-{{ $key }}" class="collapse" aria-labelledby="headingOne" data-parent="#project_tasks">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <th>{{ __('task.description') }}</th>
                                                    <th>{{ __('task.deadline') }}</th>
                                                    <th>{{ __('task.worked_time') }}</th>
                                                    <th>{{ __('task.reopen_task') }}</th>
                                                </thead>

                                                <tbody>
                                                    @foreach ($task as $key => $item)
                                                        @if ($key !== 'project_name')
                                                            <tr>
                                                                <td>{{ $item->description }}</td>
                                                                <td>{{ $item->deadline }}</td>
                                                                <td>{{secondsToTime( $item->getTotalWorkedByUser($item->user->id)) }}</td>
                                                                <td><a class="btn btn-sm btn-success" href="{{ route('tasks.open-task', ['task_id'=>$item->id, 'project_id'=>$item->project->id]) }}"><i class="fas fa-folder-open"></i></a></td>
                                                            </tr>
                                                        @endif
                                                        
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>        
                            </div>
                        @endforeach
                    @endif

                    @empty($projects[App\Task::FINISHED])
                        <h5 style="margin-top:20px">{{ __('task.no_task_found') }}.</h3>
                    @endempty    
                </div>
            </div>
        </div>
    </div>
@endsection
