@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ Novo</small></h1>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="card-body">
                
                @include('clients.partials.form')
			
            </div>

            <div class="card-footer text-muted">
                <a href="{{ route('clients.index') }}" class="btn btn-outline-dark">Cancelar</a>
                <button class="btn btn-primary" type="submit">Enviar</button>
            </div>
        </form>
    </div>
@endsection