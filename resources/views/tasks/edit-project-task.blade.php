@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small> / {{ __('task.edit') }}</small> <small>/ {{ $task->name }}</small></h1>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('tasks.update-project-task', ['id'=>$task->id, 'project_id'=>$task->project->id]) }}" method="POST">
            @csrf
            <input id="project_id" type="hidden" name="project_id" value="{{ $task->project->id }}">
            <input id="project_id" type="hidden" name="client_id" value="{{ $task->project->client->id }}">
            <div class="card-body">
                
                @include('tasks.partials.form')

                <div class="form-group row">
                    <label for="add-member" class="col-sm-2 col-form-label">{{ __('project.user') }}</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="user_id" required>
                            <option value="">{{ __('project.none') }}</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}" {{ $task->user_id === $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('projects.show', $task->project->id) }}" class="btn btn-outline-dark">{{ __('task.cancel') }}</a>
                <button class="btn btn-primary" type="submit">{{ __('task.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
