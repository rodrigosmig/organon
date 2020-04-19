@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection

@section('button-header')
	<a href="{{ route('projects.new' )}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus"></i> {{__("New Project")}}</a>
@endsection

@section('link-css')
	<link rel="stylesheet" href="{{ asset('css/projects.css') }}">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script-js')
	<script src="{{ asset('js/projects.js' )}}" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
				  <a class="nav-item nav-link active" id="nav-active-tab" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="true">{{ __('Active') }}</a>
				  <a class="nav-item nav-link" id="nav-finished-tab" data-toggle="tab" href="#nav-finished" role="tab" aria-controls="nav-finished" aria-selected="false">{{ __('Finished') }}</a>
				</div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
					<table class="table table-hover" style="border-collapse:collapse;">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Deadline</th>
								<th>Team</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($projects as $key => $project)
								<tr>
									<td>
										<a href="{{ route('projects.show', ['id' => $project->id]) }}">
											<i class="fas fa-eye"></i>
										</a>
									</td>
									<td>{{ $project->name }}</td>
									<td>{{ $project->deadline }}</td>
									<td><i class="fas fa-users"></i> {{ $project->members->count() + 1 }}</td>
									<td>
										<div class="dropdown">
											<a href="javascript:void(0)" class="menuAction" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-ellipsis-h"></i>
											</a>
											<div class="dropdown-menu" aria-labelledby="projectActions">
												<a class="dropdown-item" href="{{ route('projects.edit', ['id' => $project->id]) }}"><i class="fas fa-edit"></i> Edit Project</a>
												<a class="dropdown-item" href="{{ route('projects.delete', ['id' => $project->id]) }}"><i class="fas fa-trash-alt"></i> Delete Project</a>
											</div>
										</div>
									</td>
								</tr>
							@endforeach
									
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="nav-finished" role="tabpanel" aria-labelledby="nav-finished-tab">...</div>
			</div>
        </div>
    </div>

@endsection