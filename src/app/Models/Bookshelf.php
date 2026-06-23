<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookshelf extends Model
{
    /** @use HasFactory<\Database\Factories\BookshelfFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'location',
        'description',
        'capacity',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }
}
