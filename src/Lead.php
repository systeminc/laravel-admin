<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $fillable = ['data'];

    protected $dates = ['deleted_at'];
}
