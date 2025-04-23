<?php

namespace Mydnic\VoletFeatureBoard\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mydnic\VoletFeatureBoard\VoletFeatureBoardServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mydnic\\VoletFeatureBoard\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            VoletFeatureBoardServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function getEnvironmentSetUp($app)
    {
        // Configuration de la base de données pour les tests
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Charger la configuration du package
        $app['config']->set('volet-feature-board', require __DIR__.'/../config/volet-feature-board.php');
    }

    /**
     * Définir les routes pour les tests
     */
    protected function defineRoutes($router)
    {
        // Définir les routes nécessaires pour les tests
        $router->get('volet-feature-board/features', function () {
            return response()->json([]);
        })->name('volet.feature-board.features.index');

        $router->post('volet-feature-board/features', function () {
            return response()->json([]);
        })->name('volet.feature-board.features.store');

        $router->get('volet-feature-board/features/{feature}', function () {
            return response()->json([]);
        })->name('volet.feature-board.features.show');

        $router->post('volet-feature-board/features/{feature}/vote', function () {
            return response()->json([]);
        })->name('volet.feature-board.features.vote');

        $router->post('volet-feature-board/features/{feature}/comments', function () {
            return response()->json([]);
        })->name('volet.feature-board.features.comments.store');
    }
}
