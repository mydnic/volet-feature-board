<?php

namespace Mydnic\VoletFeatureBoard\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function author(): BelongsTo
    {
        return $this->belongsTo(config('volet-feature-board.user_model'));
    }

    public function setAuthorId($authorId)
    {
        // If it's a guest ID, store it as is
        if (str_starts_with($authorId, 'guest_')) {
            $this->author_id = $authorId;

            return;
        }

        // If user is authenticated, use their ID
        if (auth()->check()) {
            $this->author_id = auth()->id();

            return;
        }

        // Fallback to the provided ID (should be a guest ID)
        $this->author_id = $authorId;
    }

    public function isAuthoredBy($authorId): bool
    {
        if (auth()->check()) {
            return $this->author_id === auth()->id();
        }

        return $this->author_id === $authorId;
    }

    public function getAuthorName(): string
    {
        // If it's a regular user
        if (! str_starts_with($this->author_id, 'guest_')) {
            $user = $this->author;

            return $user ? $user->name : 'Unknown User';
        }

        // If it's a guest
        return 'Guest';
    }
}
