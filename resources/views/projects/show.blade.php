@extends('layouts.front')

@section('link-css')
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="{{ asset('js/projects.js' )}}" type="text/javascript"></script>
@endsection

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ $project->name }}</small></h1>
@endsection

@section('button-header')
    <div class="dropdown">
        <a href="javascript:void(0)" class="menuMembers d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Members">
            <i class="fas fa-cog"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="projectActions">
            <a class="dropdown-item" href="{{ route('projects.edit', ['id' => $project->id]) }}"><i class="fas fa-edit"></i> {{ __('Edit Project') }}</a>
            <a class="dropdown-item add_member" href="javascript:void(0)" data-project="{{ $project->id }}" data-toggle="modal" data-target="#modal-add_user"><i class="fas fa-user-plus"></i> {{ __('Add Member') }}</a>
        </div>
    </div>
    
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
    
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>

    <div class="card shadow mb-4">
        <form action="{{ route("projects.update", ['id' => $project->id]) }}" method="POST">
            @csrf
            <div class="card-body">
                <h5>Tasks</h5>
                <table class="table">
                    <thead>
                        <th>User</th>
                        <th>Description</th>
                        <th>Time Worked</th>
                        <th>Deadline</th>
                    </thead>
                    <tbody>
                        @foreach ($project->tasks as $task)
                            <tr>
                                <td>
                                   photo
                                </td>
                                <td>
                                    {{ $task->description }}
                                </td>
                                <td>
                                    Time Worked
                                </td>
                                <td>
                                    {{ $task->deadline }}
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <div class="card shadow mb-4">
        <form action="{{ route("projects.update", ['id' => $project->id]) }}" method="POST">
            @csrf
            <div class="card-body">
                <h5>Team Members</h5>
                <table class="table">
                    <thead>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Time Worked</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                @if ($owner->photo != "user.png")
                                    <img class="img-profile rounded-circle" src="/storage/{{$owner->photo}}" width="30px" height="30px">                                        
                                @else
                                    <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}" width="30px" height="30px">
                                @endif
                            </td>
                            <td>
                                {{ $owner->name }}
                            </td>
                            <td>
                                1000
                            </td>
                            <td>
                                <a href="#" data-toggle="tooltip" data-placement="right" title="Remove Member"><i class="fas fa-user-minus"></i></a>
                            </td>
                        </tr>
                        @foreach ($project->users as $user)
                            <tr>
                                <td>
                                    @if ($user->photo != "user.png")
                                        <img class="img-profile rounded-circle" src="/storage/{{$user->photo}}" width="30px" height="30px">                                        
                                    @else
                                        <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}" width="30px" height="30px">
                                    @endif
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    1000
                                </td>
                                <td>
                                    <a href="#" data-toggle="tooltip" data-placement="right" title="Remove Member"><i class="fas fa-user-minus"></i></a>
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection