<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    const ACTIVE    = 'active';
    const INACTIVE  = 'Inactive';

    protected $fillable = ['owner_id', 'name', 'email', 'cpf_cnpj', 'postal_code', 'address', 'city', 'state', 'phone'];
    
}
