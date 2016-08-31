<?php

namespace SystemInc\LaravelAdmin\Facades;

use Illuminate\Support\Facades\Facade;

class SLA extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sla';
    }
}
