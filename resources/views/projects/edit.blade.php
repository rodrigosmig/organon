@extends('layouts.front')

@section('title')
    <h1 class="h3 mb-0 text-gray-800">{{ $title }} <small> / {{ $project->name }} </small><small> / {{ __('project.edit') }}</small></h1>
@endsection

@section('link-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
@endsection

@section('script-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/projects.js' )}}" type="text/javascript"></script>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route("projects.update", ['id' => $project->id]) }}" method="POST">
            @csrf
            <div class="card-body">
                
                @include('projects.partials.form')
                
            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('projects.show', ['id' => $project->id]) }}" class="btn btn-outline-dark">{{ __('project.cancel') }}</a>
                <button class="btn btn-primary" type="submit">{{ __('project.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
