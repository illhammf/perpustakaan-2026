<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'member_id',
        'book_copy_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'renewal_count',
        'notes',
        'loaned_by',
        'processed_by',
    ];

    protected function casts(): array
    {
        return [
            'loan_date' => 'date',
            'due_date' => 'date',
            'return_date' => 'date',
            'renewal_count' => 'integer',
        ];
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function fine()
    {
        return $this->hasOne(Fine::class);
    }

    public function loanedBy()
    {
        return $this->belongsTo(User::class, 'loaned_by');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function getIsOverdueAttribute()
    {
        return $this->status === 'active' && now()->startOfDay()->gt($this->due_date);
    }

    public function getDaysOverdueAttribute()
    {
        if ($this->is_overdue) {
            return (int) now()->startOfDay()->diffInDays($this->due_date, false);
        }

        return 0;
    }
}
