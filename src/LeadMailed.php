<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class LeadMailed extends Model
{
    protected $fillable = [
        'email',
        'subject',
        'body',
    ];
}
