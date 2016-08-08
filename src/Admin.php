<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password',
    ];

}
