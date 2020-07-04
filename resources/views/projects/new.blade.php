@extends('layouts.front')

@section('link-css')
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
@endsection

@section('script-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/projects.js' )}}" type="text/javascript"></script>
@endsection

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ __('project.new_project') }}</small></h1>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route("projects.store") }}" method="POST">
            @csrf
            <div class="card-body">
                
                @include('projects.partials.form')

            </div>
            <div class="card-footer text-muted">
                <a href="{{ route('projects.index') }}" class="btn btn-outline-dark">{{ __('project.cancel') }}</a>
                <button class="btn btn-primary" type="submit">{{ __('project.submit') }}</button>
            </div>
        </form>
    </div>
@endsection