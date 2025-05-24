<?php

namespace VentureDrake\LaravelAutoscaling\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VentureDrake\LaravelAutoscaling\LaravelAutoscaling
 */
class LaravelAutoscaling extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \VentureDrake\LaravelAutoscaling\LaravelAutoscaling::class;
    }
}
