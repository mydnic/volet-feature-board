<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mydnic\VoletFeatureBoard\Models\Vote;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('volet-feature-board.tables.votes', 'volet_feature_user_votes');
    config()->set('volet-feature-board.models.feature', \Mydnic\VoletFeatureBoard\Models\Feature::class);
});

test('vote uses the correct table name', function () {
    $vote = new Vote();
    
    expect($vote->getTable())->toBe('volet_feature_user_votes');
    
    // Test with custom config
    config()->set('volet-feature-board.tables.votes', 'custom_votes');
    expect($vote->getTable())->toBe('custom_votes');
});

test('vote has fillable attributes', function () {
    $vote = new Vote();
    
    expect($vote->getFillable())->toContain('feature_id')
        ->toContain('author_id');
});

test('vote has feature relationship', function () {
    $vote = new Vote();
    
    expect($vote->feature())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

test('vote can get author name for regular user', function () {
    $vote = new Vote();
    $vote->author_id = 1;
    
    // Mock the author relationship
    $user = new class {
        public $name = 'John Doe';
    };
    
    $vote->setRelation('author', $user);
    
    expect($vote->getAuthorNameAttribute())->toBe('John Doe');
});

test('vote can get author name for guest', function () {
    $vote = new Vote();
    $vote->author_id = 'guest_123';
    
    expect($vote->getAuthorNameAttribute())->toBe('Guest');
});
