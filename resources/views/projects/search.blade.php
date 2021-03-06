@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ __('project.search_results') }}</h1>
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h6>{{ __('project.projects') }}</h6>
        </div>
        <div class="card-body">
            @if (! $projects->isEmpty())
                <table class="table">
                    <thead>
                        <th>{{ __('project.name') }}</th>
                        <th>{{ __('project.client') }}</th>
                        <th>{{ __('project.deadline') }}</th>
                        <th>{{ __('project.status') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>
                                    <a href="{{ route('projects.show', ['id' => $project->id]) }}">
                                        {{ $project->name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('clients.show', ['client_id' => $project->client->id]) }}">
                                        {{ $project->client->name }}
                                    </a>
                                </td>
                                <td>{{ $project->deadline }}</td>
                                <td>{{ App\Project::STATUS[$project->status] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{ __('project.no_projects') }}
            @endif
        </div>
        <div class="card-footer text-muted">
            @if (isset($filters))
                {!! $projects->appends($filters)->links() !!}
            @else
                {!! $projects->links() !!}
            @endif
        </div>
    </div>    
@endsection
