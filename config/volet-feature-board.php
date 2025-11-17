<?php

return [
    'tables' => [
        'features' => 'volet_features',
        'votes' => 'volet_feature_user_votes',
        'comments' => 'volet_feature_comments',
    ],

    // The controller class to use for feedback endpoints
    'controllers' => [
        'features' => \Mydnic\VoletFeatureBoard\Http\Controllers\FeatureController::class,
        'votes' => \Mydnic\VoletFeatureBoard\Http\Controllers\VoteController::class,
        'comments' => \Mydnic\VoletFeatureBoard\Http\Controllers\CommentController::class,
    ],

    // The model class to use for feedback messages
    'models' => [
        'feature' => \Mydnic\VoletFeatureBoard\Models\Feature::class,
        'vote' => \Mydnic\VoletFeatureBoard\Models\Vote::class,
        'comment' => \Mydnic\VoletFeatureBoard\Models\Comment::class,
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
        'success-icon' => 'https://api.iconify.design/heroicons:check-circle.svg?color=%2322c55e',
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
        'class' => \Mydnic\VoletFeatureBoard\Notifications\NewFeatureNotification::class,
    ],
];
