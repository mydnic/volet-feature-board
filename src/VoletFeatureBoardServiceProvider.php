<?php

namespace Mydnic\VoletFeatureBoard;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VoletFeatureBoardServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('volet-feature-board')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_volet_features_table');
    }
}
