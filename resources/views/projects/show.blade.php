@extends('layouts.front')

@section('link-css')
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script-js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/projects.js' )}}" type="text/javascript"></script>
@endsection

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ $project->name }}</small></h1>
@endsection

@section('button-header')
<a href="{{ route('projects.edit', ['id' => $project->id]) }}" class="menuMembers d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" type="button" aria-expanded="false" title="Edit Project">
    <i class="fas fa-edit"></i>
  </a>
@endsection

@section('modal')
	<div class="modal fade" id="modal-add_user" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add_userLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Member</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-add-member" action="{{ route('projects.add-member', ['project_id' => $project->id]) }}" method="post">
					@csrf
					<input id="project_id" type="hidden" name="project_id">
					<div class="modal-body">
						<div class="input-group mb-3">
							<label for="add-member">Search for a user</label>
							<select id="add-member" name="user_id" class="select-user-ajax" style="width: 100%" required></select>
            </div>
            <div class="input-group mb-3">
							<label for="hour_value">Hour Value</label>
							<input type="number" id="hour_value" name="hour_value" class="input-user-ajax" style="width: 100%" value="0.0"></select>
            </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Add Member</button>
					</div>
				</form>
			</div>
		</div>
  </div>
  
  <div class="modal fade" id="modal-assign_user" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-assign_userLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Assign User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-assign-task-member" action="{{ route('projects.task.assign-task-member', ['project_id' => $project->id]) }}" method="POST">
          @csrf
          <input type="hidden" name="project_id" value="{{ $project->id }}">
					<input id="task_id" type="hidden" name="task_id">
					<div class="modal-body">
						<div class="form-group mb-3">
							<label for="add-member">Select a user</label>
							<select class="form-control" name="user_id" required>
                <option value="">None</option>
                @foreach ($members as $member)
                  <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
              </select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Add Member</button>
					</div>
				</form>
			</div>
		</div>
  </div>

  <div class="modal fade" id="modal-add_task" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add_taskLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Task</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-add-task" action="{{ route('projects.task.store', ['project_id' => $project->id]) }}" method="post">
					@csrf
					<input type="hidden" name="project_id" value="{{ $project->id }}">
					<div class="modal-body">
						<div class="form-group row">
              <label for="task-description" class="col-sm-2 col-form-label">Description</label>
              <div class="col-sm-12">
                <input type="text" id="task-description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="Task description" value="{{ old('description') }}" >
              </div>
            </div>
            <div class="form-group row">
              <label for="task-deadline" class="col-sm-2 col-form-label">Deadline</label>
              <div class="col-sm-12">
                <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="task-deadline" name="deadline" value="{{ old('deadline') }}" required>
              </div>
            </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Add Task</button>
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
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Deadline</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $project->deadline }}</div>
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
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Time Worked</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ secondsToTime($total_worked) }}</div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Project cost</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($project->getTotalProjectCost(), 2, ',', '.') }}</div>
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
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Project Value</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($project->amount_charged, 2, ',', '.') }}</div>
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
            <div class="card-header">
              <h4>
                <i class="fas fa-tasks"></i>
                Tasks
                <a class="btn btn-success btn-sm" href="javascript:void(0)" data-toggle="modal" data-target="#modal-add_task"><i class="fas fa-plus"></i> Add Task</a>
              </h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>User</th>
                        <th>Description</th>
                        <th>Time Worked</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($project->tasks as $task)
                            <tr>
                                <td>
                                  @if ($task->user)
                                    @if ($task->user->hasPhoto())
                                      <img class="img-profile rounded-circle" src="/storage/{{ $task->user->photo }}" width="30px" height="30px" title={{ $task->user->name }}>                                        
                                    @else
                                      <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}" width="30px" height="30px" title={{ $task->user->name }}>
                                    @endif    
                                  @else
                                    <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}" width="30px" height="30px" title="No user">
                                  @endif
                                </td>
                                <td>
                                  {{ $task->description }}
                                </td>
                                <td>
                                  {{ secondsToTime($task->getTotalWorked()) }}
                                </td>
                                <td>
                                  {{ $task->deadline }}
                                </td>
                                <td>
                                  {{ App\Task::STATUS[$task->status] }}
                                </td>
                                <td>
                                  <div class="dropdown">
                                    <a href="javascript:void(0)" class="menuAction" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fas fa-ellipsis-h"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="projectActions">
                                      <a class="dropdown-item" href="{{ route('projects.task.edit', ['id' => $task->id, 'project_id' => $project->id]) }}"><i class="fas fa-edit"></i> Edit Task</a>
                                      <a class="dropdown-item" href="{{ route('projects.task.delete', ['id' => $task->id, 'project_id' => $project->id]) }}"><i class="fas fa-trash"></i> Delete Task</a>
                                      @if ($task->user)
                                        <a class="dropdown-item" href="{{ route('projects.task.remove-task-member', ['id' => $task->id, 'project_id' => $project->id]) }}"><i class="fas fa-user-minus"></i> Remove the user</a>
                                      @else
                                      <a class="dropdown-item assign_task_member" href="javascript:void(0)" data-task="{{ $task->id }}" data-toggle="modal" data-target="#modal-assign_user"><i class="fas fa-user-plus"></i> Assign a user</a>
                                      @endif
                                    </div>
                                  </div>
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
            <div class="card-header">
              <h4>
                <i class="fas fa-users"></i>
                Team Members
                <button class="btn btn-success btn-sm add_member" href="javascript:void(0)" data-project="{{ $project->id }}" data-toggle="modal" data-target="#modal-add_user"><i class="fas fa-plus"></i> Add Member</button>
              </h4>
            </div>
            <div class="card-body">
                
                <table class="table table-hover">
                    <thead>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Total Worked</th>
                        <th>Hour Value</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach ($members as $user)
                            <tr>
                                <td>
                                    @if ($user->hasPhoto())
                                        <img class="img-profile rounded-circle" src="/storage/{{$user->photo}}" width="30px" height="30px" title="{{$user->name}}">                                        
                                    @else
                                        <img class="img-profile rounded-circle" src="{{ asset('img/user.png') }}" width="30px" height="30px" title="{{$user->name}}">
                                    @endif
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ secondsToTime($user->total_worked) }}
                                </td>
                                @if (! $project->isOwner($user))
                                  <td>${{ number_format($user->pivot->hour_value, 2, ',', '.') }}</td>    
                                @else
                                <td>0</td>
                                @endif
                                
                                <td>
                                    <a href="javascript:void(0)" class="remove-member" data-user="{{ $user->id }}" data-project="{{ $project->id }}" data-toggle="tooltip" data-placement="right" title="Remove Member"><i class="fas fa-user-minus"></i></a>
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection