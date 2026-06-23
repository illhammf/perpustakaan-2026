<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookCopy extends Model
{
    /** @use HasFactory<\Database\Factories\BookCopyFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_id',
        'bookshelf_id',
        'barcode',
        'condition',
        'status',
        'acquisition_date',
        'acquisition_type',
        'price',
        'source',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'acquisition_date' => 'date',
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function bookshelf()
    {
        return $this->belongsTo(Bookshelf::class);
    }

    public function loan()
    {
        return $this->hasOne(Loan::class);
    }
}
