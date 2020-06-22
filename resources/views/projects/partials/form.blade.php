<div class="form-group row">
    <label for="projects-name" class="col-sm-2 col-form-label">{{ __('project.name') }}</label>
    <div class="col-sm-10">
      <input type="text" id="projects-name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{ __('project.project_name') }}" value="{{ $project->name ?? old('name') }}" required>
    </div>
</div>
<div class="form-group row">
    <label for="project-deadline" class="col-sm-2 col-form-label">{{ __("project.deadline") }}</label>
    <div class="col-sm-10">
      <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="project-deadline" name="deadline" value="{{ $project->deadline ?? old('deadline') }}" required>
    </div>
</div>
<div class="form-group row">
    <label for="project-amount_charged" class="col-sm-2 col-form-label">{{ __("project.amount_charged") }}</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="project-amount_charged" name="amount_charged" value="{{ $project->amount_charged ?? old('amount_charged') }}" placeholder="500,00">
    </div>
</div>
<div class="form-group row">
    <label for="project-client" class="col-sm-2 col-form-label">{{ __('project.client') }}</label>
    <div class="col-sm-10">
        <select id="project-client" class="form-control" name="client" required>
            <option value="">{{ __('project.select_client') }}</option>
            @foreach ($clients as $client)
                @if (isset($project) && $project)
                    <option value="{{ $client->id }}" {{ $project->client_id === $client->id ? 'selected' : '' }}>{{$client->name}}</option>
                @else
                    <option value="{{ $client->id }}" {{ old('client') ? 'selected' : '' }}>{{$client->name}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>