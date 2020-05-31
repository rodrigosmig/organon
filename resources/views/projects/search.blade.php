@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">Result</h1>
@endsection


@section('content')
    <div class="card">
        <div class="card-header">
            <h6>Projects</h6>
        </div>
        <div class="card-body">
            @if (! $projects->isEmpty())
                <table class="table">
                    <thead>
                        <th></th>
                        <th>Name</th>
                        <th>Deadline</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>
                                    <a href="{{ route('projects.show', ['id' => $project->id]) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->deadline }}</td>
                                <td>{{ App\Project::STATUS[$project->status] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                No Projects found
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
