<?php

namespace Mydnic\VoletFeatureBoard\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Mydnic\VoletFeatureBoard\Models\Feature;

class NewFeatureNotification extends Notification
{
    public function __construct(public Feature $feature)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('[Volet] New Feature')
            ->line('Title: '.$this->feature->title)
            ->line('Description: '.$this->feature->description)
            ->line('Category: '.$this->feature->category);
    }
}
