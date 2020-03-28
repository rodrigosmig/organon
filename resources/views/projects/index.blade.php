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

@section('modal')
	<div class="modal fade" id="modal-add_user" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add_userLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ __("Add Member") }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-add-member" action="{{ route('projects.add-member') }}" method="post">
					@csrf
					<input id="project_id" type="hidden" name="project_id">
					<div class="modal-body">
						<div class="input-group mb-3">
							<label for="add-member">Search for a user</label>
							<select id="add-member" name="user" class="select-user-ajax" style="width: 100%" required></select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">{{ __('Add Members') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
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
									<td><i class="fas fa-users"></i> {{ $project->users->count() + 1 }}</td>
									<td>
										<div class="dropdown">
											<a href="javascript:void(0)" class="menuAction" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-ellipsis-h"></i>
											</a>
											<div class="dropdown-menu" aria-labelledby="projectActions">
												<a class="dropdown-item" href="{{ route('projects.edit', ['id' => $project->id]) }}"><i class="fas fa-edit"></i> {{ __('Edit Project') }}</a>
												<a class="dropdown-item" href="{{ route('projects.delete', ['id' => $project->id]) }}"><i class="fas fa-trash-alt"></i> {{ __('Delete Project') }}</a>
												<a class="dropdown-item add_member" href="javascript:void(0)" data-project="{{ $project->id }}" data-toggle="modal" data-target="#modal-add_user"><i class="fas fa-user-plus"></i> {{ __('Add Member') }}</a>
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