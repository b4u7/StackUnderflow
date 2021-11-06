<?php

namespace App\Notifications;

use App\Channels\PusherChannel;
use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnsweredNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Answer $answer)
    {
        $this->answer->load('question');
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        // TODO: [PusherChannel::class, 'mail']
        return [PusherChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            'title' => $this->answer->question->title,
            'body' => $this->answer->body,
            'url' => route('questions.show', $this->answer->question->id)
        ];
    }

    public function toPusher(mixed $notifiable): array
    {
        return [
            'title' => $this->answer->question->title,
            'body' => $this->answer->body,
            'url' => route('questions.show', $this->answer->question)
        ];
    }
}
