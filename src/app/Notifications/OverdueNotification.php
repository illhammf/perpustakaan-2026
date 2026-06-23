<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Loan $loan) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $daysOverdue = $this->loan->days_overdue;
        $fineAmount = $daysOverdue * ($this->loan->member->memberType->fine_per_day ?? 1000);

        return (new MailMessage)
            ->subject('Peringatan Keterlambatan Pengembalian Buku')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Buku yang Anda pinjam telah melewati batas waktu pengembalian.')
            ->line('Judul Buku: ' . $this->loan->bookCopy->book->title)
            ->line('Keterlambatan: ' . $daysOverdue . ' hari')
            ->line('Total Denda: Rp ' . number_format($fineAmount, 0, ',', '.'))
            ->action('Segera Kembalikan', url('/'))
            ->line('Silakan segera kembalikan buku untuk menghindari akumulasi denda.');
    }
}
