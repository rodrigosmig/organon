<div class="form-group row">
    <label for="task-name" class="col-sm-2 col-form-label">{{ __('task.name') }}</label>
    <div class="col-sm-10">
      <input type="text" id="task-name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ __('task.task_name') }}" value="{{ $task->name ?? old('name') }}" required {{ isset($readonly) ? 'readonly' : '' }}>
    </div>
</div>
<div class="form-group row">
    <label for="task-description" class="col-sm-2 col-form-label">{{ __('task.description') }}</label>
    <div class="col-sm-10">
      <textarea id="task-description" class="form-control @error('description') is-invalid @enderror" name="description" placeholder="{{ __('task.task_description') }}" rows="3" required style="resize: none">{{ $task->description ?? old('description') }}</textarea>
    </div>
</div>
<div class="form-group row">
    <label for="task-deadline" class="col-sm-2 col-form-label">{{ __('task.deadline') }}</label>
    <div class="col-sm-10">
      <input type="text" class="form-control datepicker @error('deadline') is-invalid @enderror" id="task-deadline" name="deadline" value="{{ $task->deadline ?? old('deadline') }}" required>
    </div>
</div>
