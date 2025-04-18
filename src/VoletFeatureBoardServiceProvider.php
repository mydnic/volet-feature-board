<?php

namespace Mydnic\VoletFeatureBoard;

use Illuminate\Support\Facades\Blade;
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
            ->hasMigration('create_volet_features_table')
            ->hasTranslations()
            ->hasRoute('api')
            ->hasAssets();
    }

    public function boot()
    {
        parent::boot();

        // Register Blade Directives
        Blade::directive('voletFeatureBoardStyles', function () {
            $styleUrl = asset('vendor/volet-feature-board/volet-feature-board.css');

            return "<?php echo '<link rel=\"stylesheet\" href=\"{$styleUrl}\">'; ?>";
        });

        Blade::directive('voletFeatureBoard', function () {
            $scriptUrl = asset('vendor/volet-feature-board/volet-feature-board.js');

            return "<?php echo '<script src=\"{$scriptUrl}\"></script>'; ?>";
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/dist' => public_path('vendor/volet'),
            ], 'volet-assets');
        }
    }
}
