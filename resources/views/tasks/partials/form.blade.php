<div class="form-group row">
    <label for="task-name" class="col-sm-2 col-form-label">{{ __('task.name') }}</label>
    <div class="col-sm-10">
      <input type="text" id="task-name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ __('task.task_name') }}" value="{{ $task->name ?? old('name') }}" required {{ isset($readonly) ? 'readonly' : '' }}>
    </div>
</div>
<div class="form-group row">
    <label for="task-description" class="col-sm-2 col-form-label">{{ __('task.description') }}</label>
    <div class="col-sm-10">
      <textarea id="task-description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="{{ __('task.task_description') }}" rows="3" required {{ isset($readonly) ? 'readonly' : '' }} style="resize: none">{{ $task->description ?? old('description') }}</textarea>
    </div>
</div>
<div class="form-group row">
    <label for="task-deadline" class="col-sm-2 col-form-label">{{ __('task.deadline') }}</label>
    <div class="col-sm-10">
      <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="task-deadline" name="deadline" value="{{ $task->deadline ?? old('deadline') }}" required {{ isset($readonly) ? 'readonly' : '' }}>
    </div>
</div>
<div class="form-group row">
    <label for="task-project" class="col-sm-2 col-form-label">{{ __('task.project') }}</label>
    <div class="col-sm-10">
        <select class="form-control" name="project_id" id="task-project" {{ isset($readonly) ? 'disabled' : '' }}>
            <option value="">{{ __('project.none') }}</option>
            @foreach ($projects as $project)
                @if (isset($project) && isset($task) && $project->id === $task->project_id)
                    <option value="{{ $project->id }}" selected>{{ $project->name }}</option>
                @else
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endif
            @endforeach 
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="task-client" class="col-sm-2 col-form-label">{{ __('task.client') }}</label>
    <div class="col-sm-10">
        <select class="form-control" name="client_id" id="task-client" {{ isset($readonly) ? 'disabled' : '' }}>
            <option value="">{{ __('project.none') }}</option>
            @foreach ($clients as $client)
                @if (isset($task) && $task->client_id === $client->id)
                    <option value="{{ $client->id }}" selected>{{ $client->name }}</option>
                @else
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endif
            @endforeach 
        </select>
    </div>
</div>