<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Mydnic\VoletFeatureBoard\Traits\HasAuthor;

uses(RefreshDatabase::class);

class ModelWithAuthor
{
    use HasAuthor;

    public $author_id;

    public function setRelation($relation, $value)
    {
        $this->$relation = $value;
    }

    public function isUserAuthor()
    {
        return ! str_starts_with($this->author_id, 'guest_');
    }
}

test('can set author id for authenticated user', function () {
    $model = new ModelWithAuthor;

    Auth::shouldReceive('check')
        ->andReturn(true);

    Auth::shouldReceive('id')
        ->andReturn(123);

    $model->setAuthorId('any_value');

    expect($model->author_id)->toBe(123);
});

test('can set author id for guest', function () {
    $model = new ModelWithAuthor;

    Auth::shouldReceive('check')
        ->andReturn(false);

    $model->setAuthorId('guest_456');

    expect($model->author_id)->toBe('guest_456');
});

test('can check if authored by specific author', function () {
    $model = new ModelWithAuthor;
    $model->author_id = 'guest_789';

    Auth::shouldReceive('check')
        ->andReturn(false);

    expect($model->isAuthoredBy('guest_789'))->toBeTrue();
    expect($model->isAuthoredBy('guest_999'))->toBeFalse();
});

test('can get author name for user', function () {
    $model = new ModelWithAuthor;
    $model->author_id = 1;

    $user = new class
    {
        public $name = 'John Doe';
    };

    $model->setRelation('author', $user);

    expect($model->getAuthorName())->toBe('John Doe');
});

test('can get author name for guest', function () {
    $model = new ModelWithAuthor;
    $model->author_id = 'guest_123';

    expect($model->getAuthorName())->toBe('Guest');
});
