<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(config('volet-feature-board.tables.features', 'volet_features'), function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category')->index();
            $table->string('status')->default(FeatureStatus::PENDING)->index(); // pending, approved, rejected, completed
            $table->string('author_id');
            $table->timestamps();
        });

        Schema::create(config('volet-feature-board.tables.votes', 'volet_feature_user_votes'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feature_id');
            $table->string('author_id');
            $table->timestamps();

            $table->foreign('feature_id')
                ->references('id')
                ->on(config('volet-feature-board.tables.features', 'volet_features'))
                ->onDelete('cascade');

            $table->unique(['feature_id', 'author_id']);
        });

        Schema::create(config('volet-feature-board.tables.comments', 'volet_feature_comments'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feature_id');
            $table->string('author_id');
            $table->text('content');
            $table->timestamps();

            $table->foreign('feature_id')
                ->references('id')
                ->on(config('volet-feature-board.tables.features', 'volet_features'))
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(config('volet-feature-board.tables.comments', 'volet_feature_comments'));
        Schema::dropIfExists(config('volet-feature-board.tables.votes', 'volet_feature_user_votes'));
        Schema::dropIfExists(config('volet-feature-board.tables.features', 'volet_features'));
    }
};
