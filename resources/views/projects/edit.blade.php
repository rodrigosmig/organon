@extends('layouts.front')

@section('title')
    <h1 class="h3 mb-0 text-gray-800">{{ $title }} <small> / {{ $project->name }} </small><small> / Edit</small></h1>
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
                <div class="form-group row">
                    <label for="projects-name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                    <div class="col-sm-10">
                      <input type="text" id="projects-name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Project Name" value="{{ $project->name }}" required>
                    </div>
                </div>
                  <div class="form-group row">
                    <label for="project-deadline" class="col-sm-2 col-form-label">{{ __("Deadline") }}</label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="project-deadline" name="deadline" value="{{ $project->deadline }}" required>
                    </div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('projects.index') }}" class="btn btn-outline-dark">{{ __("Cancel") }}</a>
                <button class="btn btn-primary" type="submit">{{ __("Submit") }}</button>
            </div>
        </form>
    </div>
@endsection
