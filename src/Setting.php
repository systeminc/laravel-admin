<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['title', 'source'];
}
