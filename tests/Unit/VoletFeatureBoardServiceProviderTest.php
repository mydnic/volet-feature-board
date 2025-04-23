<?php

use Mydnic\VoletFeatureBoard\VoletFeatureBoardServiceProvider;
use Spatie\LaravelPackageTools\Package;

test('service provider configures package correctly', function () {
    $package = mock(Package::class);

    $package->expects('name')->with('volet-feature-board')->andReturnSelf();
    $package->expects('hasConfigFile')->withNoArgs()->andReturnSelf();
    $package->expects('hasViews')->withNoArgs()->andReturnSelf();
    $package->expects('hasMigration')->with('create_volet_features_table')->andReturnSelf();
    $package->expects('hasTranslations')->withNoArgs()->andReturnSelf();
    $package->expects('hasRoute')->with('api')->andReturnSelf();
    $package->expects('hasAssets')->withNoArgs()->andReturnSelf();

    $provider = new VoletFeatureBoardServiceProvider(app());
    $provider->configurePackage($package);

    expect(true)->toBeTrue();
});
