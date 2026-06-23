<?php

namespace App\Notifications;

use App\Models\Loan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LoanDueReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Loan $loan) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pengingat Pengembalian Buku')
            ->greeting('Halo ' . $notifiable->name . '!')
            ->line('Buku yang Anda pinjam akan jatuh tempo dalam waktu dekat.')
            ->line('Judul Buku: ' . $this->loan->bookCopy->book->title)
            ->line('Barcode: ' . $this->loan->bookCopy->barcode)
            ->line('Tanggal Pinjam: ' . $this->loan->loan_date->format('d/m/Y'))
            ->line('Jatuh Tempo: ' . $this->loan->due_date->format('d/m/Y'))
            ->action('Kunjungi Perpustakaan', url('/'))
            ->line('Harap kembalikan buku tepat waktu untuk menghindari denda.');
    }
}
