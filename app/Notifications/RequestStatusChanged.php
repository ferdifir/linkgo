<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public string $villageSlug,
        public string $trackingCode,
        public string $title,
        public string $status,
        public string $adminNote,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Pembaruan permintaan warga: '.$this->title)
            ->greeting('Status permintaan Anda diperbarui')
            ->line('Desa: '.str_replace('-', ' ', ucfirst($this->villageSlug)))
            ->line('Permintaan: '.$this->title)
            ->line('Kode tiket: '.$this->trackingCode)
            ->line('Status terbaru: '.$this->status);

        if ($this->adminNote !== '') {
            $message->line('Catatan dari desa: '.$this->adminNote);
        }

        return $message->action('Lihat laman desa', url('/desa/'.$this->villageSlug));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
