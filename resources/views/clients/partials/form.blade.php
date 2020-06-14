<div class="form-group row">
    <label for="client-name" class="col-sm-2 col-form-label">Nome</label>
    <div class="col-sm-10">
      <input type="text" id="client-name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $client->name ?? old('name') }}" required {{ isset($readonly) && $readonly ? "readonly" : "" }}>
    </div>
</div>

<div class="form-group row">
    <label for="client-email" class="col-sm-2 col-form-label">E-mail</label>
    <div class="col-sm-10">
      <input type="email" id="client-email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $client->email ?? old('email') }}" required {{ isset($readonly) && $readonly ? "readonly" : "" }}>
    </div>
</div>

<div class="form-group row">
    <label for="client-cpf_cnpj" class="col-sm-2 col-form-label">CPF/CNPJ</label>
    <div class="col-sm-10">
      <input type="number" id="client-cpf_cnpj" class="form-control @error('cpf_cnpj') is-invalid @enderror" name="cpf_cnpj" value="{{ $client->cpf_cnpj ?? old('cpf_cnpj') }}" {{ isset($readonly) && $readonly ? "readonly" : "" }}>
    </div>
</div>

<check-address
    ca_code="{{ $client->postal_code ?? old('postal_code') }}"
    ca_address="{{ $client->address ?? old('postal_code') }}"
    ca_city="{{ $client->city ?? old('city') }}"
    ca_state="{{ $client->state ?? old('state') }}"
    readonly="{{ isset($readonly) && $readonly ? "true" : "false" }}"
></check-address>

<div class="form-group row">
    <label for="client-phone" class="col-sm-2 col-form-label">Telefone</label>
    <div class="col-sm-10">
      <input type="text" id="client-phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $client->phone ?? old('phone') }}" {{ isset($readonly) && $readonly ? "readonly" : "" }}>
    </div>
</div>
