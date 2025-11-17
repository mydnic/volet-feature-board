<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Notifications\NewFeatureNotification;

uses(RefreshDatabase::class);

it('sends NewFeatureNotification when enabled and recipients are configured', function () {
    Notification::fake();

    config()->set('volet-feature-board.mail_notification.enabled', true);
    config()->set('volet-feature-board.mail_notification.send_mails_to', ['admin@example.com']);

    $feature = Feature::create([
        'title' => 'Test feature',
        'description' => 'A description',
        'category' => 'general',
        'status' => 'pending',
        'author_id' => 1,
    ]);

    Notification::assertSentOnDemand(NewFeatureNotification::class, function ($notification, $channels, $notifiable) use ($feature) {
        return in_array('admin@example.com', $notifiable->routes['mail'] ?? [])
            && $notification->feature->is($feature);
    });
});

it('does not send notification when feature notifications are disabled', function () {
    Notification::fake();

    config()->set('volet-feature-board.mail_notification.enabled', false);
    config()->set('volet-feature-board.mail_notification.send_mails_to', ['admin@example.com']);

    Feature::create([
        'title' => 'Test feature',
        'description' => 'A description',
        'category' => 'general',
        'status' => 'pending',
        'author_id' => 1,
    ]);

    Notification::assertNothingSent();
});

it('does not send notification when no recipients are configured', function () {
    Notification::fake();

    config()->set('volet-feature-board.mail_notification.enabled', true);
    config()->set('volet-feature-board.mail_notification.send_mails_to', []);

    Feature::create([
        'title' => 'Test feature',
        'description' => 'A description',
        'category' => 'general',
        'status' => 'pending',
        'author_id' => 1,
    ]);

    Notification::assertNothingSent();
});
