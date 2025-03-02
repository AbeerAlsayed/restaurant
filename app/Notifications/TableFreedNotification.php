<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TableFreedNotification extends Notification
{
    use Queueable;

    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function via($notifiable)
    {
        return ['mail']; // أو أي قناة أخرى تريد استخدامها مثل 'database'
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Table Freed Notification')
            ->line('The table ' . $this->table->table_number . ' has been freed successfully.')
            ->action('View Table', url('/tables/' . $this->table->id));
    }
}
