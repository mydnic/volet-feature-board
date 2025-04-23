<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;
use Mydnic\VoletFeatureBoard\Http\Controllers\CommentController;
use Mydnic\VoletFeatureBoard\Models\Feature;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->controller = new CommentController();

    // Create a test feature
    $this->feature = Feature::create([
        'title' => 'Test Feature',
        'description' => 'Test Description',
        'category' => 'bug',
        'status' => FeatureStatus::PENDING,
        'author_id' => 'guest_123',
    ]);
});

test('store creates a new comment', function () {

    $request = new Request([
        'content' => 'This is a test comment',
    ]);
    $request->headers->set('X-Guest-ID', 'guest_456');

    $request->validate = function () {
        return [
            'content' => 'This is a test comment',
        ];
    };

    $response = $this->controller->store($request, $this->feature);
    $data = $response->getData(true);

    expect($data['content'])->toBe('This is a test comment');
    expect($data['feature_id'])->toBe($this->feature->id);
    expect($data['author_id'])->toBe('guest_456');

    // Check database
    $this->assertDatabaseHas('volet_feature_comments', [
        'feature_id' => $this->feature->id,
        'author_id' => 'guest_456',
        'content' => 'This is a test comment',
    ]);
});

test('store returns error when no author id is provided', function () {
    $request = new Request([
        'content' => 'This is a test comment',
    ]);

    $request->validate = function () {
        return [
            'content' => 'This is a test comment',
        ];
    };

    $response = $this->controller->store($request, $this->feature);
    $data = $response->getData(true);

    expect($response->getStatusCode())->toBe(400);
    expect($data['error'])->toBe('No author ID provided');
});

test('store validates content is required', function () {
    $request = new Request();
    $request->headers->set('X-Guest-ID', 'guest_456');

    $request->validate = function () {
        throw new \Illuminate\Validation\ValidationException(
            Validator::make([], ['content' => 'required']),
            response()->json(['errors' => ['content' => ['The content field is required.']]], 422)
        );
    };

    try {
        $this->controller->store($request, $this->feature);
        $this->fail('Expected ValidationException was not thrown');
    } catch (\Illuminate\Validation\ValidationException $e) {
        expect($e->status)->toBe(422);
        expect($e->errors())->toHaveKey('content');
    }
});
