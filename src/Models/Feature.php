<?php

namespace Mydnic\VoletFeatureBoard\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mydnic\VoletFeatureBoard\Enums\FeatureStatus;
use Mydnic\VoletFeatureBoard\Traits\HasAuthor;

class Feature extends Model
{
    use HasAuthor;

    protected $fillable = [
        'title',
        'description',
        'category',
        'status',
        'author_id',
    ];

    protected $casts = [
        'status' => FeatureStatus::class,
    ];

    protected $appends = [
        'author_name',
    ];

    public function getTable()
    {
        return config('volet-feature-board.tables.features', 'volet_features');
    }

    public function author(): ?BelongsTo
    {
        if ($this->isUserAuthor()) {
            return $this->belongsTo(config('auth.providers.users.model'), 'author_id', 'id');
        }

        return null;
    }

    public function votes(): HasMany
    {
        return $this->hasMany(config('volet-feature-board.models.vote'));
    }

    public function comments(): HasMany
    {
        return $this->hasMany(config('volet-feature-board.models.comment'));
    }

    public function votesCount(): int
    {
        return $this->votes()->count();
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->getAuthorName();
    }
}
