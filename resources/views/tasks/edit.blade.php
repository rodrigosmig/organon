@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ $task->description }}</small><small> / {{ __('task.edit') }}</small></h1>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route("projects.task.update", ['id' => $task->id, 'project_id' => $project->id]) }}" method="POST">
            @csrf
            <input id="project_id" type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="card-body">
                <div class="form-group row">
                    <label for="-name" class="col-sm-2 col-form-label">{{ __('task.description') }}</label>
                    <div class="col-sm-10">
                      <input type="text" id="-description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="{{ __('task.task_description') }}" value="{{ $task->description }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="task-deadline" class="col-sm-2 col-form-label">{{ __('task.deadline') }}</label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="task-deadline" name="deadline" value="{{ $task->deadline }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="task-user" class="col-sm-2 col-form-label">{{ __('project.change_user') }}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="user_id" id="task-user">
                            <option value="">{{ __('project.none') }}</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ $task->user_id === $member->id ? 'selected' : ''}}>{{ $member->name }}</option>
                            @endforeach 
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('projects.show', ['id' => $task->project->id]) }}" class="btn btn-outline-dark">{{ __('task.cancel') }}</a>
                <button class="btn btn-primary" type="submit">{{ __('task.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
