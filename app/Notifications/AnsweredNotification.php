<?php

namespace App\Notifications;

use App\Channels\PusherChannel;
use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use JetBrains\PhpStorm\ArrayShape;

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
     *
     * @return array<string|class-string>
     */
    public function via(mixed $notifiable): array
    {
        return ['database', 'mail', PusherChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)->markdown('emails.questions.answered', ['answer' => $this->answer]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, array<string, string|null>|string|null>
     */
    #[ArrayShape(['title' => "mixed|null|string", 'author' => "array", 'body' => "mixed|string", 'url' => "string"])]
    public function toArray(): array
    {
        return [
            'title' => $this->answer->question?->title,
            'author' => [
                'name' => $this->answer->user?->name,
                'url' => route('users.show', $this->answer->user)
            ],
            'body' => $this->answer->body,
            'url' => route('questions.show', $this->answer->question)
        ];
    }

    /**
     * @return array<string, array<string, string|null>|string|null>
     */
    #[ArrayShape(['title' => "mixed|string", 'author' => "array", 'body' => "\mixed|string", 'url' => "string"])]
    public function toPusher(): array
    {
        return $this->toArray();
    }
}
