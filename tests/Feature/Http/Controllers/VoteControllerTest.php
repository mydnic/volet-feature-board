<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;
use Mydnic\VoletFeatureBoard\Http\Controllers\VoteController;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Models\Vote;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->controller = new VoteController();
    
    // Create a test feature
    $this->feature = Feature::create([
        'title' => 'Test Feature',
        'description' => 'Test Description',
        'category' => 'bug',
        'status' => FeatureStatus::PENDING,
        'author_id' => 'guest_123',
    ]);
});

test('store adds a vote when user has not voted', function () {
    // Mock request with guest ID
    $request = Request::create("/features/{$this->feature->id}/vote", 'POST');
    $request->headers->set('X-Guest-ID', 'guest_456');
    
    $response = $this->controller->store($request, $this->feature);
    $data = $response->getData(true);
    
    expect($data['action'])->toBe('added');
    expect($data['votes_count'])->toBe(1);
    
    // Check database
    $this->assertDatabaseHas('volet_feature_user_votes', [
        'feature_id' => $this->feature->id,
        'author_id' => 'guest_456',
    ]);
});

test('store removes a vote when user has already voted', function () {
    // Create an existing vote
    Vote::create([
        'feature_id' => $this->feature->id,
        'author_id' => 'guest_456',
    ]);
    
    // Mock request with guest ID
    $request = Request::create("/features/{$this->feature->id}/vote", 'POST');
    $request->headers->set('X-Guest-ID', 'guest_456');
    
    $response = $this->controller->store($request, $this->feature);
    $data = $response->getData(true);
    
    expect($data['action'])->toBe('removed');
    expect($data['votes_count'])->toBe(0);
    
    // Check database
    $this->assertDatabaseMissing('volet_feature_user_votes', [
        'feature_id' => $this->feature->id,
        'author_id' => 'guest_456',
    ]);
});

test('store returns error when no author id is provided', function () {
    // Mock request without guest ID
    $request = Request::create("/features/{$this->feature->id}/vote", 'POST');
    
    $response = $this->controller->store($request, $this->feature);
    $data = $response->getData(true);
    
    expect($response->getStatusCode())->toBe(400);
    expect($data['error'])->toBe('No author ID provided');
});
