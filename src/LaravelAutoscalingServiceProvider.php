<?php

namespace VentureDrake\LaravelAutoscaling;

use Illuminate\Console\Scheduling\Schedule;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use VentureDrake\LaravelAutoscaling\Commands\LaravelAutoscalingCommand;

class LaravelAutoscalingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-autoscaling')
            ->hasConfigFile([
                'autoscaling',
            ])
           /* ->hasViews()
            ->hasMigration('create_laravel_autoscaling_table')*/
            ->hasCommand(LaravelAutoscalingCommand::class);
    }

    public function packageBooted(): void
    {
        // Not sure whether this should be automatically scheduled or not.
        
        /*if ($this->app->runningInConsole()) {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('autoscaling:run')
                ->name('autoscaling-run')
                ->everyFiveMinutes()
                ->withoutOverlapping();
        }*/
    }
}
