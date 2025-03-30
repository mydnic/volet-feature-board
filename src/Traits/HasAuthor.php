<?php

namespace Mydnic\VoletFeatureBoard\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait HasAuthor
{
    protected function getAuthorId(): string
    {
        if (Auth::check()) {
            return 'user_' . Auth::id();
        }

        if (! Session::has('guest_id')) {
            Session::put('guest_id', 'guest_' . str_replace('-', '', (string) \Illuminate\Support\Str::uuid()));
        }

        return Session::get('guest_id');
    }

    protected function isUserAuthor(): bool
    {
        return Auth::check() && str_starts_with($this->author_id, 'user_');
    }

    protected function isGuestAuthor(): bool
    {
        return str_starts_with($this->author_id, 'guest_');
    }

    protected function getAuthorName(): string
    {
        if ($this->isUserAuthor()) {
            return optional(Auth::user())->name ?? 'Unknown User';
        }

        return 'Guest';
    }
}
