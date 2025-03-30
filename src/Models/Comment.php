<?php

namespace Mydnic\VoletFeatureBoard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mydnic\VoletFeatureBoard\Traits\HasAuthor;

class Comment extends Model
{
    use HasAuthor;

    protected $fillable = [
        'feature_id',
        'author_id',
        'content',
    ];

    protected $appends = [
        'author_name',
    ];

    public function getTable()
    {
        return config('volet-feature-board.tables.comments', 'volet_feature_comments');
    }

    public function feature(): BelongsTo
    {
        return $this->belongsTo(config('volet-feature-board.models.feature'));
    }

    public function author(): ?BelongsTo
    {
        if ($this->isUserAuthor()) {
            return $this->belongsTo(config('auth.providers.users.model'), 'author_id', 'id');
        }

        return null;
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->getAuthorName();
    }
}
