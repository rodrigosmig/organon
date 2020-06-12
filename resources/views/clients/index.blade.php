@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection

@section('button-header')
	<a href="{{ route('clients.new' )}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus"></i> Novo Cliente</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-friends"></i> {{ $title }}
        </div>

        <div class="card-body">
            <table class="table">
                <thead>
                    <th></th>
                    <th>Name</th>
                    <th>E-mail</th>
                    <th>Status</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>
                                <a href="{{ route('clients.show', $client->id) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('clients.show', $client->id) }}">
                                    {{ $client->name }}
                                </a>
                            </td>
                            <td>{{ $client->email }}</td>
                            <td>{{ ucFirst($client->status) }}</td>
                            <td>
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="menuAction" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="projectActions">
                                        <a class="dropdown-item" href="{{ route('clients.edit', $client->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
