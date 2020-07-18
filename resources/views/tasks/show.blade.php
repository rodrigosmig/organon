@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ $task->name }}</small></h1>
@endsection

@section('button-header')
    @if ($task->project && $task->project->isOwner(auth()->user()))
        <a href="{{ route('tasks.edit', $task->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" type="button" aria-expanded="false" title="{{ __('task.edit_task') }}">
            <i class="fas fa-edit"></i>
        </a>
    @elseif(! $task->project)
        <a href="{{ route('tasks.edit', $task->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" type="button" aria-expanded="false" title="{{ __('task.edit_task') }}">
            <i class="fas fa-edit"></i>
        </a>
    @endif    
@endsection

@section('modal')
    <div class="modal fade" id="addComment" tabindex="-1" role="dialog" aria-labelledby="addCommentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCommentLabel">{{ __('comments.add_comment') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tasks.add-comment', $task->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="comment-task" class="col-sm-2 col-form-label">{{ __('comments.comment') }}</label>
                            <div class="col-sm-12">
                              <textarea id="comment-task" class="form-control @error('comment') is-invalid @enderror" name="comment" rows="3" required style="resize: none"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('comments.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('comments.submit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow">
        @csrf
        <div class="card-body">
            {{-- @include('tasks.partials.form') --}}
            <div class="form-group row">
                <label for="task-name" class="col-sm-2 col-form-label">{{ __('task.name') }}</label>
                <div class="col-sm-10">
                    <label style="padding-top: 8px">
                        {{ $task->name }}
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <label for="task-description" class="col-sm-2 col-form-label">{{ __('task.description') }}</label>
                <div class="col-sm-10">
                    <label style="padding-top: 8px">
                        {{ $task->description }}
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <label for="task-deadline" class="col-sm-2 col-form-label">{{ __('task.deadline') }}</label>
                <div class="col-sm-10">
                    <label style="padding-top: 8px">
                        {{ $task->deadline }}
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <label for="task-project" class="col-sm-2 col-form-label">{{ __('task.project') }}</label>
                <div class="col-sm-10">
                    <label style="padding-top: 8px">
                        {{ $task->project ? $task->project->name : '-' }}
                    </label>
                </div>
            </div>

            <div class="form-group row">
                <label for="task-client" class="col-sm-2 col-form-label">{{ __('task.client') }}</label>
                <div class="col-sm-10">
                    <label style="padding-top: 8px">
                        {{ $task->client ? $task->client->name : '-' }}
                    </label>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="task-name" class="col-sm-2 col-form-label">{{ __('task.worked_time') }}</label>
                <div class="col-sm-10">
                    <label style="padding-top: 8px">
                        {{secondsToTime( $task->getTotalWorkedByUser($task->user->id)) }}
                    </label>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">
            <a href="{{ route('tasks.my-tasks') }}" class="btn btn-outline-dark">{{ __('task.back') }}</a>
        </div>
    </div>

    <div class="card shadow" style="margin-top: 50px">
        <div class="card-header">            
                {{ __('comments.comments') }}
                <div class="float-right">
                    <button href="#" class="btn btn-success btn-sm shadow-sm" data-toggle="modal" data-target="#addComment"><i class="fas fa-plus"></i> {{__("comments.add")}}</button>
                </div>
        </div>
        <div class="card-body">
            @if ($comments->isNotEmpty())
                <table class="table table-striped">
                    <thead>
                        <th>{{ __('comments.user') }}</th>
                        <th>{{ __('comments.comment') }}</th>
                        <th>{{ __('comments.date') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <td>
                                    @if ($comment->user->hasPhoto())
                                        <img class="img-profile rounded-circle" src="/storage/{{ $comment->user->photo }}" width="30px" height="30px" title="{{ $comment->user->name }}">                                        
                                    @else
                                        <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}" width="30px" height="30px" title="{{ $comment->user->name }}">
                                    @endif    
                                </td>
                                <td>{{ $comment->comment }}</td>
                                <td>{{ $comment->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h5 style="margin-top:20px">{{ __('comments.messages.no_comment') }}</h3>
            @endif
            
        </div>

    </div>
@endsection
