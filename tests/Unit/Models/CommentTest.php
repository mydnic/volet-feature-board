<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mydnic\VoletFeatureBoard\Models\Comment;

uses(RefreshDatabase::class);

beforeEach(function () {
    config()->set('volet-feature-board.tables.comments', 'volet_feature_comments');
    config()->set('volet-feature-board.models.feature', \Mydnic\VoletFeatureBoard\Models\Feature::class);
});

test('comment uses the correct table name', function () {
    $comment = new Comment();
    
    expect($comment->getTable())->toBe('volet_feature_comments');
    
    // Test with custom config
    config()->set('volet-feature-board.tables.comments', 'custom_comments');
    expect($comment->getTable())->toBe('custom_comments');
});

test('comment has fillable attributes', function () {
    $comment = new Comment();
    
    expect($comment->getFillable())->toContain('feature_id')
        ->toContain('author_id')
        ->toContain('content');
});

test('comment has feature relationship', function () {
    $comment = new Comment();
    
    expect($comment->feature())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
});

test('comment can get author name for regular user', function () {
    $comment = new Comment();
    $comment->author_id = 1;
    
    // Mock the author relationship
    $user = new class {
        public $name = 'John Doe';
    };
    
    $comment->setRelation('author', $user);
    
    expect($comment->getAuthorNameAttribute())->toBe('John Doe');
});

test('comment can get author name for guest', function () {
    $comment = new Comment();
    $comment->author_id = 'guest_123';
    
    expect($comment->getAuthorNameAttribute())->toBe('Guest');
});
