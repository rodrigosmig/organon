@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection

@section('button-header')
	<a href="{{ route('clients.new' )}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus"></i> {{ __('client.new_client') }}</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-friends"></i> {{ $title }}
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <th>{{ __('client.name') }}</th>
                    <th>{{ __('client.email') }}</th>
                    <th>{{ __('client.status') }}</th>
                </thead>

                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>
                                <a href="{{ route('clients.show', $client->id) }}">
                                    {{ $client->name }}
                                </a>
                            </td>
                            <td>{{ $client->email }}</td>
                            <td>{{ ucFirst($client->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
