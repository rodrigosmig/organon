@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ __('task.new') }}</small></h1>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                @include('tasks.partials.form')
                <div class="form-group row">
                    <label for="task-project" class="col-sm-2 col-form-label">{{ __('task.project') }}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="project_id" id="task-project">
                            <option value="">{{ __('project.none') }}</option>
                            @foreach ($projects as $project)
                                @if (isset($project) && isset($task) && $project->id === $task->project_id)
                                    <option value="{{ $project->id }}" selected>{{ $project->name }}</option>
                                @else
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endif
                            @endforeach 
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="task-client" class="col-sm-2 col-form-label">{{ __('task.client') }}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="client_id" id="task-client">
                            <option value="">{{ __('project.none') }}</option>
                            @foreach ($clients as $client)
                                @if (isset($task) && $task->client_id === $client->id)
                                    <option value="{{ $client->id }}" selected>{{ $client->name }}</option>
                                @else
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endif
                            @endforeach 
                        </select>
                    </div>
                </div>

            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('tasks.my-tasks') }}" class="btn btn-outline-dark">{{ __('task.cancel') }}</a>
                <button class="btn btn-primary" type="submit">{{ __('task.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
