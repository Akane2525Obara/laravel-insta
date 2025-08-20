<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewMessageNotification extends Notification
{
    use Queueable;

    public $conversation;
    public $sender;

    public function __construct(Conversation $conversation, User $sender)
    {
        $this->conversation = $conversation;
        $this->sender = $sender;
    }

    public function via($notifiable)
    {
        return ['database']; // DB通知
    }

    public function toDatabase($notifiable)
    {
        return [
            'conversation_id' => $this->conversation->id,
            'sender_id' => $this->sender->id,
            'message' => $this->sender->name . ' sent you a message',
        ];
    }
}
