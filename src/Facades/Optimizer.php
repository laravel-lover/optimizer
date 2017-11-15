<?php

namespace LaralLover\Optimizer\Facades;

use Illuminate\Support\Facades\Facade;

class Optimizer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'optimizer';
    }
}
