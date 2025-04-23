<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;
use Mydnic\VoletFeatureBoard\Models\Feature;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('volet-feature-board.tables.features', 'volet_features');
    config()->set('volet-feature-board.models.vote', \Mydnic\VoletFeatureBoard\Models\Vote::class);
    config()->set('volet-feature-board.models.comment', \Mydnic\VoletFeatureBoard\Models\Comment::class);
});

test('feature uses the correct table name', function () {
    $feature = new Feature();
    
    expect($feature->getTable())->toBe('volet_features');
    
    // Test with custom config
    config()->set('volet-feature-board.tables.features', 'custom_features');
    expect($feature->getTable())->toBe('custom_features');
});

test('feature has fillable attributes', function () {
    $feature = new Feature();
    
    expect($feature->getFillable())->toContain('title')
        ->toContain('description')
        ->toContain('category')
        ->toContain('status')
        ->toContain('author_id');
});

test('feature status is cast to enum', function () {
    $feature = new Feature();
    $feature->status = 'pending';
    
    expect($feature->status)->toBeInstanceOf(FeatureStatus::class);
    expect($feature->status)->toBe(FeatureStatus::PENDING);
});

test('feature has votes relationship', function () {
    $feature = new Feature();
    
    expect($feature->votes())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('feature has comments relationship', function () {
    $feature = new Feature();
    
    expect($feature->comments())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
});

test('feature can get author name for regular user', function () {
    $feature = new Feature();
    $feature->author_id = 1;
    
    // Mock the author relationship
    $user = new class {
        public $name = 'John Doe';
    };
    
    $feature->setRelation('author', $user);
    
    expect($feature->getAuthorNameAttribute())->toBe('John Doe');
});

test('feature can get author name for guest', function () {
    $feature = new Feature();
    $feature->author_id = 'guest_123';
    
    expect($feature->getAuthorNameAttribute())->toBe('Guest');
});
