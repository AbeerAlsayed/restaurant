<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TableReservedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // يمكن إرسال الإشعار عبر البريد أو حفظه في قاعدة البيانات
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Table Reserved')
            ->line('Table number ' . $this->table->table_number . ' has been reserved.')
            ->action('View Table', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Table number ' . $this->table->table_number . ' has been reserved.',
            'table_id' => $this->table->id,
        ];
    }
}
