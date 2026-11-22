<?php

use Mydnic\VoletFeatureBoard\Http\Controllers\CommentController;
use Mydnic\VoletFeatureBoard\Http\Controllers\FeatureController;
use Mydnic\VoletFeatureBoard\Http\Controllers\VoteController;
use Mydnic\VoletFeatureBoard\Models\Comment;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Models\Vote;
use Mydnic\VoletFeatureBoard\Notifications\NewFeatureNotification;

return [
    'tables' => [
        'features' => 'volet_features',
        'votes' => 'volet_feature_user_votes',
        'comments' => 'volet_feature_comments',
    ],

    // The controller class to use for feedback endpoints
    'controllers' => [
        'features' => FeatureController::class,
        'votes' => VoteController::class,
        'comments' => CommentController::class,
    ],

    // The model class to use for feedback messages
    'models' => [
        'feature' => Feature::class,
        'vote' => Vote::class,
        'comment' => Comment::class,
    ],

    'routes' => [
        // The URI prefix for feedback message routes
        'prefix' => 'feature-board',

        // The middleware to apply to feedback message routes
        'middleware' => [
            'api',
            // Add your custom middleware here
            // 'auth',
            // 'verified',
        ],
    ],

    'content' => [
        'success-icon' => 'https://api.iconify.design/heroicons/check-circle.svg?color=%2322c55e',
    ],

    // Send a notification to the site's admin when a new feature is submitted
    // If you want to send other kind of notifications (slack, etc.), you should disable this and create your
    // own notification class and trigger it via an observer (see documentation)
    // Also, this will only work if you use the default model.
    'mail_notification' => [
        'enabled' => true,
        'send_mails_to' => [
            // List of emails to send the notification to
            // 'admin@example.com',
        ],
        'class' => NewFeatureNotification::class,
    ],
];
