<?php

namespace Gyf\Stag\Facades;

use Illuminate\Support\Facades\Facade;

class Stag extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Stag';
    }
}