<?php

namespace Mydnic\VoletFeatureBoard\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mydnic\VoletFeatureBoard\VoletFeatureBoard
 */
class VoletFeatureBoard extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Mydnic\VoletFeatureBoard\VoletFeatureBoard::class;
    }
}
