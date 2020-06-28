@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection

@section('button-header')
	<a href="{{ route('tasks.create' )}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus"></i> {{__("task.new_task")}}</a>
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
                                <th></th>
                                <th>{{ __('task.name') }}</th>
                                <th>{{ __('project.project') }}</th>
                                <th>{{ __('task.client') }}</th>
                                <th>{{ __('task.deadline') }}</th>
                                <th>{{ __('task.worked_time') }}</th>
                                <th>{{ __('task.actions') }}</th>
                            </thead>

                            <tbody>
                                @foreach ($open_tasks as $task)
                                    <tr>
                                        <td>
                                            <a href="{{ route('tasks.show', $task->id) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->project ? $task->project->name : '-' }}</td>
                                        <td>{{ $task->client ? $task->client->name : '-' }}</td>
                                        <td>{{ $task->deadline }}</td>
                                        <td>
                                            {{-- <time-counter 
                                                total-worked="{{ $task->getTotalWorkedByUser($task->user->id) }}"
                                                project_id="{{ $task->project->id }}"
                                                user_id="{{ $task->user->id }}"
                                                task_id="{{ $task->id }}"
                                                msg_title="{{ __('task.messages.are_you_sure') }}"
                                                msg_message="{{ __('task.messages.all_task_restarted') }}"
                                                msg_confirm="{{ __('task.messages.yes_restart_it') }}"
                                                msg_cancel="{{ __('task.cancel') }}"
                                            ></time-counter> --}}
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="javascript:void(0)" class="menuAction" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="projectActions">
                                                    <a class="dropdown-item" href="{{ route('tasks.edit', $task->id) }}"><i class="fas fa-edit"></i> {{ __('task.edit') }}</a>
                                                    <a class="dropdown-item" href=""><i class="fas fa-trash"></i> {{ __('task.delete') }}</a>
                                                    <a class="dropdown-item" href=""><i class="fas fa-check"></i> {{ __('task.finish') }}</a>
                                                </div>
                                            </div>
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
                                <th></th>
                                <th>{{ __('task.name') }}</th>
                                <th>{{ __('project.project') }}</th>
                                <th>{{ __('task.client') }}</th>
                                <th>{{ __('task.worked_time') }}</th>
                                <th>{{ __('task.reopen_task') }}</th>
                            </thead>

                            <tbody>
                                @foreach ($finished_tasks as $task)
                                    <tr>
                                        <tr>
                                            <td>
                                                <a href="{{ route('tasks.show', $task->id) }}">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->project ? $task->project->name : '-' }}</td>
                                            <td>{{ $task->client ? $task->client->name : '-' }}</td>
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
