<?php

use Mydnic\VoletFeatureBoard\VoletFeatureBoard;

test('feature board has correct id', function () {
    $featureBoard = new VoletFeatureBoard;

    expect($featureBoard->getId())->toBe('volet-feature-board');
});

test('feature board has correct label', function () {
    $featureBoard = new VoletFeatureBoard;

    expect($featureBoard->getLabel())->toBe('Feature Requests');
});

test('feature board has correct icon', function () {
    $featureBoard = new VoletFeatureBoard;

    expect($featureBoard->getIcon())->toBe('https://api.iconify.design/lucide:lightbulb.svg?color=%23888888');
});

test('feature board has correct component name', function () {
    $featureBoard = new VoletFeatureBoard;

    expect($featureBoard->getComponentName())->toBe('feature-board');
});

test('feature board scripts contain the correct asset url', function () {
    $featureBoard = new VoletFeatureBoard;

    expect($featureBoard->getScripts())->toContain('vendor/volet-feature-board/volet-feature-board.js');
});

test('can add categories to feature board', function () {
    $featureBoard = new VoletFeatureBoard;

    expect($featureBoard->getCategories())->toBeEmpty();

    $featureBoard->addCategory('bug', 'Bug', 'bug-icon');

    expect($featureBoard->getCategories())->toHaveCount(1);
    expect($featureBoard->getCategories()[0]['slug'])->toBe('bug');
    expect($featureBoard->getCategories()[0]['name'])->toBe('Bug');
    expect($featureBoard->getCategories()[0]['icon'])->toBe('bug-icon');
});

test('can add multiple categories to feature board', function () {
    $featureBoard = new VoletFeatureBoard;

    $featureBoard->addCategory('bug', 'Bug', 'bug-icon')
        ->addCategory('feature', 'Feature', 'feature-icon');

    expect($featureBoard->getCategories())->toHaveCount(2);
    expect($featureBoard->getCategories()[1]['slug'])->toBe('feature');
});

test('config contains all required keys', function () {
    $featureBoard = new VoletFeatureBoard;

    $config = $featureBoard->getConfig();

    expect($config)->toHaveKeys(['routes', 'labels', 'categories']);
    expect($config['routes'])->toHaveKeys(['features', 'store', 'show', 'vote', 'comments']);
});
