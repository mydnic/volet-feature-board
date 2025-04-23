<?php

use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;

test('feature status enum has correct cases', function () {
    expect(FeatureStatus::PENDING->value)->toBe('pending');
    expect(FeatureStatus::APPROVED->value)->toBe('approved');
    expect(FeatureStatus::REJECTED->value)->toBe('rejected');
    expect(FeatureStatus::COMPLETED->value)->toBe('completed');
});

test('feature status enum returns correct labels', function () {
    expect(FeatureStatus::PENDING->label())->toBe('Pending');
    expect(FeatureStatus::APPROVED->label())->toBe('Approved');
    expect(FeatureStatus::REJECTED->label())->toBe('Rejected');
    expect(FeatureStatus::COMPLETED->label())->toBe('Completed');
});
