@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small> / {{ __('task.edit') }}</small> <small>/ {{ $task->name }}</small></h1>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            <input id="project_id" type="hidden" name="project_id" value="">
            <div class="card-body">
                
                @include('tasks.partials.form')

            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('tasks.my-tasks') }}" class="btn btn-outline-dark">{{ __('task.cancel') }}</a>
                <button class="btn btn-primary" type="submit">{{ __('task.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
