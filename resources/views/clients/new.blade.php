@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ __('client.new') }}</small></h1>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="card-body">
                
                @include('clients.partials.form')
			
            </div>

            <div class="card-footer text-muted">
                <a href="{{ route('clients.index') }}" class="btn btn-outline-dark">{{ __('client.cancel') }}</a>
                <button class="btn btn-primary" type="submit">{{ __('client.submit') }}</button>
            </div>
        </form>
    </div>
@endsection