<?php

use Illuminate\Support\Facades\Route;
use Mydnic\VoletFeatureBoard\Http\Controllers\CommentController;
use Mydnic\VoletFeatureBoard\Http\Controllers\FeatureController;
use Mydnic\VoletFeatureBoard\Http\Controllers\VoteController;

Route::prefix('volet')->group(function () {

    Route::prefix(config('volet-feature-board.routes.prefix'))
        ->middleware(config('volet-feature-board.routes.middleware'))
        ->group(function () {
            Route::get('/features', [FeatureController::class, 'index'])->name('volet.feature-board.features.index');
            Route::post('/features', [FeatureController::class, 'store'])->name('volet.feature-board.features.store');
            Route::get('/features/{feature}', [FeatureController::class, 'show'])->name('volet.feature-board.features.show');
            Route::patch('/features/{feature}', [FeatureController::class, 'update'])->name('volet.feature-board.features.update');
            Route::post('/features/{feature}/vote', [VoteController::class, 'store'])->name('volet.feature-board.features.vote');
            Route::post('/features/{feature}/comments', [CommentController::class, 'store'])->name('volet.feature-board.features.comments.store');
        });

});
