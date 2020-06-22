@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ $client->name }}</small></h1>
@endsection

@section('button-header')
<a href="{{ route('clients.edit', $client->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" type="button" aria-expanded="false" title="{{ __('client.edit_client') }}">
    <i class="fas fa-edit"></i>
  </a>
@endsection

@section('content')
    <div class="card-body">
                    
        @include('clients.partials.form', $client)

    </div>

    <div class="card-footer text-muted">
        <a href="{{ route('clients.index') }}" class="btn btn-outline-dark">{{ __('client.back') }}</a>
    </div>
@endsection