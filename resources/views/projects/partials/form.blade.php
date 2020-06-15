<div class="form-group row">
    <label for="projects-name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
    <div class="col-sm-10">
      <input type="text" id="projects-name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Project Name" value="{{ $project->name ?? old('name') }}" required>
    </div>
</div>
<div class="form-group row">
    <label for="project-deadline" class="col-sm-2 col-form-label">{{ __("Deadline") }}</label>
    <div class="col-sm-10">
      <input type="date" class="form-control @error('deadline') is-invalid @enderror" id="project-deadline" name="deadline" value="{{ $project->deadline ?? old('deadline') }}" required>
    </div>
</div>
<div class="form-group row">
    <label for="project-amount_charged" class="col-sm-2 col-form-label">Amount Charged</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="project-amount_charged" name="amount_charged" value="{{ $project->amount_charged ?? old('amount_charged') }}">
    </div>
</div>
<div class="form-group row">
    <label for="project-client" class="col-sm-2 col-form-label">Cliente</label>
    <div class="col-sm-10">
        <select id="project-client" class="form-control" name="client" required>
            <option value="">Selecione um cliente</option>
            @foreach ($clients as $client)
                @if (isset($project) && $project)
                    <option value="{{ $client->id }}" {{ $project->client_id === $client->id ? 'selected' : '' }}>{{$client->name}}</option>
                @else
                    <option value="{{ $client->id }}">{{$client->name}}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>