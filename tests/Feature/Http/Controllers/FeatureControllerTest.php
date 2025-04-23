<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mydnic\Volet\Features\FeatureManager;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;
use Mydnic\VoletFeatureBoard\Http\Controllers\FeatureController;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Models\Vote;
use Mydnic\VoletFeatureBoard\VoletFeatureBoard;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->featureManager = \Mockery::mock(FeatureManager::class);
    $this->featureBoard = new VoletFeatureBoard();

    $this->featureManager->shouldReceive('getFeature')
        ->with('volet-feature-board')
        ->andReturn($this->featureBoard);

    $this->controller = new FeatureController($this->featureManager);

    $this->featureBoard->addCategory('bug', 'Bug', 'bug-icon')
                       ->addCategory('feature', 'Feature', 'feature-icon');
});

test('index returns all features with vote information', function () {
    // Create test features
    $feature1 = Feature::create([
        'title' => 'Feature 1',
        'description' => 'Description 1',
        'category' => 'bug',
        'status' => FeatureStatus::PENDING,
        'author_id' => 'guest_123',
    ]);

    $feature2 = Feature::create([
        'title' => 'Feature 2',
        'description' => 'Description 2',
        'category' => 'feature',
        'status' => FeatureStatus::APPROVED,
        'author_id' => 'guest_456',
    ]);

    // Create a vote
    Vote::create([
        'feature_id' => $feature1->id,
        'author_id' => 'guest_123',
    ]);

    $request = new Request();
    $request->headers->set('X-Guest-ID', 'guest_123');

    $response = $this->controller->index($request);
    $data = $response->getData(true);

    expect($data)->toHaveCount(2);
    expect($data[0]['title'])->toBe('Feature 1');
    expect($data[0]['has_voted'])->toBeTrue();
    expect($data[0]['category']['slug'])->toBe('bug');

    expect($data[1]['title'])->toBe('Feature 2');
    expect($data[1]['has_voted'])->toBeFalse();
    expect($data[1]['category']['slug'])->toBe('feature');
});

test('store creates a new feature', function () {
    $request = new Request([
        'title' => 'New Feature',
        'description' => 'New Description',
        'category' => 'bug',
    ]);
    $request->headers->set('X-Guest-ID', 'guest_123');

    $request->validate = function () {
        return [
            'title' => 'New Feature',
            'description' => 'New Description',
            'category' => 'bug',
        ];
    };

    $response = $this->controller->store($request);
    $data = $response->getData(true);

    expect($data['title'])->toBe('New Feature');
    expect($data['description'])->toBe('New Description');
    expect($data['category'])->toBe('bug');
    expect($data['status'])->toBe(FeatureStatus::PENDING->value);
    expect($data['author_id'])->toBe('guest_123');

    // Check database
    $this->assertDatabaseHas('volet_features', [
        'title' => 'New Feature',
        'description' => 'New Description',
        'category' => 'bug',
    ]);
});

test('show returns a single feature with vote information', function () {
    // Create test feature
    $feature = Feature::create([
        'title' => 'Feature 1',
        'description' => 'Description 1',
        'category' => 'bug',
        'status' => FeatureStatus::PENDING,
        'author_id' => 'guest_123',
    ]);

    // Create a vote
    Vote::create([
        'feature_id' => $feature->id,
        'author_id' => 'guest_123',
    ]);

    $request = new Request();
    $request->headers->set('X-Guest-ID', 'guest_123');

    $response = $this->controller->show($request, $feature);
    $data = $response->getData(true);

    expect($data['id'])->toBe($feature->id);
    expect($data['title'])->toBe('Feature 1');
    expect($data['has_voted'])->toBeTrue();
});
