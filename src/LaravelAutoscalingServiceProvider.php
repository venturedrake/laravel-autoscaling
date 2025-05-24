<?php

namespace VentureDrake\LaravelAutoscaling;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use VentureDrake\LaravelAutoscaling\Commands\LaravelAutoscalingCommand;

class LaravelAutoscalingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-autoscaling')
            ->hasConfigFile([
                'autoscaling',
            ])
           /* ->hasViews()
            ->hasMigration('create_laravel_autoscaling_table')*/
            ->hasCommand(LaravelAutoscalingCommand::class);
    }
}
