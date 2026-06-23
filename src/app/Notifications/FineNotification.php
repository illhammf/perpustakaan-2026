<?php

namespace App\Notifications;

use App\Models\Fine;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class FineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Fine $fine) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pemberitahuan Denda Perpustakaan')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Anda memiliki denda perpustakaan yang perlu diselesaikan.')
            ->line('Jumlah Denda: Rp ' . number_format($this->fine->amount, 0, ',', '.'))
            ->line('Alasan: ' . ucfirst($this->fine->reason))
            ->line($this->fine->description)
            ->action('Bayar Denda', url('/'))
            ->line('Harap segera menyelesaikan pembayaran denda.');
    }
}
