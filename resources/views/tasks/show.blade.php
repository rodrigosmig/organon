@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ $task->name }}</small></h1>
@endsection

@section('button-header')
    <a href="{{ route('tasks.edit', $task->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" type="button" aria-expanded="false" title="{{ __('task.edit_task') }}">
        <i class="fas fa-edit"></i>
    </a>
@endsection

@section('content')
    <div class="card">
        @csrf
        <div class="card-body">
            {{-- @include('tasks.partials.form') --}}
            <div class="form-group row">
                <label for="task-name" class="col-sm-2 col-form-label">{{ __('task.name') }}</label>
                <div class="col-sm-10">
                    {{ $task->name }}
                </div>
            </div>

            <div class="form-group row">
                <label for="task-description" class="col-sm-2 col-form-label">{{ __('task.description') }}</label>
                <div class="col-sm-10">
                    {{ $task->description }}
                </div>
            </div>

            <div class="form-group row">
                <label for="task-deadline" class="col-sm-2 col-form-label">{{ __('task.deadline') }}</label>
                <div class="col-sm-10">
                    {{ $task->deadline }}
                </div>
            </div>

            <div class="form-group row">
                <label for="task-project" class="col-sm-2 col-form-label">{{ __('task.project') }}</label>
                <div class="col-sm-10">
                    {{ $task->project ? $task->project->name : '-' }}
                </div>
            </div>

            <div class="form-group row">
                <label for="task-client" class="col-sm-2 col-form-label">{{ __('task.client') }}</label>
                <div class="col-sm-10">
                    {{ $task->client ? $task->client->name : '-' }}
                </div>
            </div>
            
            <div class="form-group row">
                <label for="task-name" class="col-sm-2 col-form-label">{{ __('task.worked_time') }}</label>
                <div class="col-sm-10">
                    {{secondsToTime( $task->getTotalWorkedByUser($task->user->id)) }}
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <a href="{{ route('tasks.my-tasks') }}" class="btn btn-outline-dark">{{ __('task.back') }}</a>
        </div>
    </div>
@endsection
