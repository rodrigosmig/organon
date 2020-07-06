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

@section('messages-js')
    <script>
        var delete_msg = '{{ __('project.messages.delete_msg') }}';
        var delete_title = '{{ __('project.messages.delete_title') }}';
        var user_removed = '{{ __('project.user_removed') }}';
        var user_msg = '{{ __('project.messages.user_removed') }}'
        var button_cancel = '{{ __('project.cancel') }}';
        var button_confirm = '{{ __('project.confirm') }}';
        var search_for_user = '{{ __('project.search_user') }}'
    </script>
@endsection

@section('title')
	<h1 class="h3 mb-0 text-gray-800">{{ $title }} <small>/ {{ $project->name }}</small></h1>
@endsection

@section('button-header')
    <div class="dropdown">
        <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            @if ($project->isActive())
                <a class="dropdown-item" href="{{ route('projects.edit', $project->id) }}">
                    <i class="fas fa-edit"></i>
                    {{ __('project.edit') }}
                </a>
                <a class="dropdown-item delete-project" href="{{ route('projects.delete', $project->id) }}">
                    <i class="fas fa-trash-alt"></i>
                    {{ __('project.delete') }}
                </a>
                <a class="dropdown-item" href="{{ route('projects.finish-project', $project->id) }}">
                    <i class="fas fa-check"></i>
                    {{ __('project.finish') }}
                </a>
            @else
                <a class="dropdown-item" href="{{ route('projects.open-project', $project->id) }}">
                    <i class="fas fa-folder-open"></i>
                    {{ __('project.reopen') }}
                </a>
            @endif
        </div>
    </div>
@endsection

@section('modal')
	<div class="modal fade" id="modal-add_user" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add_userLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ __('project.add_member') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-add-member" action="{{ route('projects.add-member', ['project_id' => $project->id]) }}" method="post">
					@csrf
					<input id="project_id" type="hidden" name="project_id">
					<div class="modal-body">
						<div class="input-group mb-3">
							<label for="add-member">{{ __('project.search_user') }}</label>
							<select id="add-member" name="user_id" class="select-user-ajax" style="width: 100%" required></select>
            </div>
            <div class="input-group mb-3">
							<label for="amount">{{ __('project.amount') }}</label>
							<input type="number" id="amount" name="amount" class="input-user-ajax" style="width: 100%" value="0.0"></select>
            </div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('project.close') }}</button>
						<button type="submit" class="btn btn-primary">{{ __('project.add_member') }}</button>
					</div>
				</form>
			</div>
		</div>
  </div>
  
  <div class="modal fade" id="modal-assign_user" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-assign_userLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ __('project.assign_user') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-assign-task-member" action="{{ route('projects.assign-task-member', ['project_id' => $project->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input id="task_id" type="hidden" name="task_id">
					<div class="modal-body">
						<div class="form-group mb-3">
							<label for="add-member">{{ __('project.select_user') }}</label>
							<select class="form-control" name="user_id" required>
                                <option value="">{{ __('project.none') }}</option>
                                @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                @endforeach
                            </select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('project.close') }}</button>
						<button type="submit" class="btn btn-primary">{{ __('project.add_member') }}</button>
					</div>
				</form>
			</div>
		</div>
  </div>

  <div class="modal fade" id="modal-add_task" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add_taskLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">{{ __('task.add_task') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="form-add-task" action="{{ route('tasks.store') }}" method="post">
					@csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="hidden" name="client_id" value="{{ $project->client->id }}">
					<div class="modal-body">
                        <div class="form-group row">
                            <label for="task-name" class="col-sm-2 col-form-label">{{ __('project.name') }}</label>
                            <div class="col-sm-12">
                                <input type="text" id="task-name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ __('task.task_name') }}" value="{{ old('name') }}" >
                            </div>
                        </div>
						<div class="form-group row">
                            <label for="task-description" class="col-sm-2 col-form-label">{{ __('project.description') }}</label>
                            <div class="col-sm-12">
                                <textarea id="task-description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="{{ __('task.task_description') }}" rows="3" required style="resize: none">{{ $task->description ?? old('description') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="task-deadline" class="col-sm-2 col-form-label">{{ __('project.deadline') }}</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control datepicker @error('deadline') is-invalid @enderror" id="task-deadline" name="deadline" value="{{ old('deadline') }}" required>
                            </div>
                        </div>
                        <label for="add-member">{{ __('project.select_user') }}</label>
                        <select class="form-control" name="user_id">
                            <option value="">{{ __('project.none') }}</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('project.close') }}</button>
						<button type="submit" class="btn btn-primary">{{ __('task.add_task') }}</button>
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
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">{{ __('project.deadline') }}</div>
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
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('project.time.total_time_worked') }}</div>
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
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('project.cost') }}</div>
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
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">{{ __('project.amount_charged') }}</div>
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
        <form action="{{ route("projects.update", $project->id) }}" method="POST">
            @csrf
            <div class="card-header">
              <h4>
                <i class="fas fa-tasks"></i>
                {{ __('task.tasks') }}
                @if ($project->isActive())
                    <a class="btn btn-success btn-sm" href="javascript:void(0)" data-toggle="modal" data-target="#modal-add_task"><i class="fas fa-plus">
                        </i> {{ __('task.add_task') }}
                    </a>
                @endif
              </h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <th>{{ __('project.user') }}</th>
                        <th>{{ __('task.task_name') }}</th>
                        <th>{{ __('project.time.time_worked') }}</th>
                        <th>{{ __('project.deadline') }}</th>
                        <th>{{ __('project.status') }}</th>
                        <th>{{ __('project.actions') }}</th>
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
                                  <a href="{{ route('tasks.show', $task->id) }}" target="_blank">
                                    {{ $task->name }}
                                  </a>
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
                                      <a class="dropdown-item" href="{{ route('tasks.edit-project-task', ['id'=>$task->id, 'project_id'=>$project->id]) }}"><i class="fas fa-edit"></i> {{ __('task.edit_task') }}</a>
                                      <a class="dropdown-item" href="{{ route('tasks.delete', $task->id) }}"><i class="fas fa-trash"></i> {{ __('task.delete_task') }}</a>
                                      @if ($task->user)
                                        <a class="dropdown-item" href="{{ route('projects.remove-task-member', ['task_id' => $task->id, 'project_id' => $project->id]) }}"><i class="fas fa-user-minus"></i> {{ __('task.remove_user') }}</a>
                                      @else
                                      <a class="dropdown-item assign_task_member" href="javascript:void(0)" data-task="{{ $task->id }}" data-toggle="modal" data-target="#modal-assign_user"><i class="fas fa-user-plus"></i> {{ __('task.assign_user') }}</a>
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
        <form action="{{ route("projects.update", $project->id) }}" method="POST">
            @csrf
            <div class="card-header">
              <h4>
                <i class="fas fa-users"></i>
                {{ __('project.members') }}
                @if ($project->isActive())
                    <a class="btn btn-success btn-sm add_member" href="javascript:void(0)" data-project="{{ $project->id }}" data-toggle="modal" data-target="#modal-add_user">
                        <i class="fas fa-plus"></i> {{ __('project.add_members') }}
                    </a>
                @endif
              </h4>
            </div>
            <div class="card-body">
                
                <table class="table table-hover">
                    <thead>
                        <th>{{ __('project.avatar') }}</th>
                        <th>{{ __('project.name') }}</th>
                        <th>{{ __('project.time.total_worked') }}</th>
                        <th>{{ __('project.amount') }}</th>
                        <th>{{ __('project.action') }}</th>
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
                                  <td>${{ number_format($user->pivot->amount, 2, ',', '.') }}</td>    
                                @else
                                <td>0</td>
                                @endif
                                
                                <td>
                                    @if ($project->isActive())
                                        <a href="javascript:void(0)" class="remove-member" data-user="{{ $user->id }}" 
                                            data-project="{{ $project->id }}" data-toggle="tooltip" 
                                            data-placement="right" 
                                            title="{{ __('project.remove_member') }}">
                                            <i class="fas fa-user-minus"></i>
                                        </a>
                                    @else
                                        <i class="fas fa-user-minus"></i>
                                    @endif
                                </td>
                            </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>
@endsection