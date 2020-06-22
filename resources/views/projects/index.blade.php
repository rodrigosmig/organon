@extends('layouts.front')

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
@endsection

@section('button-header')
	<a href="{{ route('projects.new' )}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus"></i> {{__("project.new_project")}}</a>
@endsection

@section('link-css')
	<link rel="stylesheet" href="{{ asset('css/projects.css') }}">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script-js')
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script src="{{ asset('js/projects.js' )}}" type="text/javascript"></script>
@endsection
   
@section('content')
    <div class="card">
        <div class="card-body">
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
				  <a class="nav-item nav-link active" id="nav-active-tab" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="true">{{__("project.active")}}</a>
				  <a class="nav-item nav-link" id="nav-finished-tab" data-toggle="tab" href="#nav-finished" role="tab" aria-controls="nav-finished" aria-selected="false">{{__("project.finished")}}</a>
				</div>
			</nav>
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
					@if ($open_projects->isNotEmpty())
						<table class="table table-hover" style="border-collapse:collapse;">
							<thead>
								<tr>
                                    <th>{{__("project.name")}}</th>
                                    <th>{{ __('project.client') }}</th>
                                    <th>{{__("project.deadline")}}</th>
                                    <th>{{ __('project.cost') }}</th>
                                    <th>{{ __('project.amount_charged') }}</th>
									<th>{{__("project.members")}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($open_projects as $key => $project)
									<tr>
										<td>
                                            <a href="{{ route('projects.show', ['id' => $project->id]) }}">
												{{ $project->name }}
											</a>
                                        </td>
                                        <td>
                                            <a href="{{ route('clients.show', $project->client->id) }}" target="_blank">
                                                {{$project->client->name }}
                                            </a>
                                        </td>
                                        <td>{{ $project->deadline }}</td>
                                        <td>${{ number_format($project->getTotalProjectCost(), 2, ',', '.') }}</td>
                                        <td>${{ number_format($project->amount_charged, 2, ',', '.') }}</td>
										<td><i class="fas fa-users"></i> {{ $project->members->count() + 1 }}</td>
									</tr>
								@endforeach										
							</tbody>
						</table>
					@else
						<h5 style="margin-top:20px">{{__("project.no_projectd")}}.</h3>
					@endif
					
				</div>
				<div class="tab-pane fade" id="nav-finished" role="tabpanel" aria-labelledby="nav-finished-tab">
					<div class="tab-pane fade show" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
						@if ($finished_projects->isNotEmpty())
							<table class="table table-hover" style="border-collapse:collapse;">
								<thead>
									<tr>
										<th>{{__("project.name")}}</th>
                                        <th>{{ __('project.client') }}</th>
                                        <th>{{ __('project.cost') }}</th>
                                        <th>{{ __('project.amount_charged') }}</th>
                                        <th>{{ __('project.time.total_time_worked') }}</th>
                                        <th>{{__("project.members")}}</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($finished_projects as $key => $project)
										<tr>
                                            <td>
                                                <a href="{{ route('projects.show', ['id' => $project->id]) }}">
                                                    {{ $project->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('clients.show', $project->client->id) }}" target="_blank">
                                                    {{$project->client->name }}
                                                </a>
                                            </td>
                                            <td>${{ number_format($project->getTotalProjectCost(), 2, ',', '.') }}</td>
                                            <td>${{ number_format($project->amount_charged, 2, ',', '.') }}</td>
											<td>{{ secondsToTime($project->getTotalWorkedOnProject()) }}</td>
											<td><i class="fas fa-users"></i> {{ $project->members->count() + 1 }}</td>
										</tr>
									@endforeach											
								</tbody>
							</table>
						@else
							<h5 style="margin-top:20px">{{__("project.no_projectd")}}</h3>
						@endif
					</div>
				</div>
			</div>
        </div>
    </div>

@endsection