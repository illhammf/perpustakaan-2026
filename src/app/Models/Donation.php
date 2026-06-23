<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    /** @use HasFactory<\Database\Factories\DonationFactory> */
    use HasFactory;

    protected $fillable = [
        'book_id',
        'donor_name',
        'donor_contact',
        'donor_email',
        'donation_type',
        'title',
        'quantity',
        'amount',
        'description',
        'donation_date',
        'thanks_message',
    ];

    protected function casts(): array
    {
        return [
            'donation_date' => 'date',
            'amount' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
