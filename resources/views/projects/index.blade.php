@extends('layouts.front')

@section('link-css')
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
@endsection

@section('script-js')
    <script src="{{ asset('js/projects.js' )}}" type="text/javascript"></script>
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
								<tr class="teste">
									<td>
										<button class="btn btn-outline-primary btn-sm expand" data-toggle="collapse" data-target="#demo{{ $key }}" class="accordion-toggle">
											<i  class="fas fa-plus"></i>
										</button>
									</td>
									<td>{{ $project->name }}</td>
									<td>{{ Carbon\Carbon::parse($project->deadline)->format('d/m/Y') }}</td>
									<td><i class="fas fa-users"></i> {{ $project->users->count() + 1 }}</td>
									<td>
										<div class="dropdown">
											<a href="javascript:void(0)" class="menuAction" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<i class="fas fa-ellipsis-h"></i>
											</a>
											<div class="dropdown-menu" aria-labelledby="projectActions">
												<a class="dropdown-item" href="#">Edit</a>
												<a class="dropdown-item" href="#">Delete</a>
												<a class="dropdown-item" href="#">Something else here</a>
											</div>
										</div>
									</td>
								</tr>
								<tr class="p">
									<td colspan="6" class="hiddenRow">
										<div class="accordian-body collapse" id="demo{{ $key }}">
											<p>No : <span>1</span></p>
											<p>Date : <span>66666 Jan 2018</span> </p>
											<p>Description : <span>Good</span> </p>
											<p>Credit : <span>$150.00</span> </p>
											<p>Debit : <span></span></p>
											<p>Balance : <span>$150.00</span></p>
										</div> 
									</td> 
								</tr>
							@endforeach
									
						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="nav-finished" role="tabpanel" aria-labelledby="nav-finished-tab">...</div>
			</div>

            {{-- <table class="table table-hover">
                <thead>
                <tr>
                    <th>Creation Date</th>
                    <th>Name</th>
                    <th>Team</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>
                                {{ Carbon\Carbon::parse($project->created_at)->format('d/m/Y') }}
                            </td>
                            <td>
                                {{ $project->name }}
                            </td>
                            <td>
                                <i class="fas fa-users"></i> 1
                            </td>
                        </tr>    
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>

@endsection