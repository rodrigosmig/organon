@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ $client->name }}</small></h1>
@endsection

@section('button-header')
    <div class="dropdown">
        <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('clients.edit', $client->id) }}">
                <i class="fas fa-edit"></i>
                {{ __('task.edit') }}
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card-body">
                    
        @include('clients.partials.form', $client)

    </div>

    <div class="card-footer text-muted">
        <a href="{{ route('clients.index') }}" class="btn btn-outline-dark">{{ __('client.back') }}</a>
    </div>
@endsection