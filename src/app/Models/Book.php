<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'isbn',
        'issn',
        'edition',
        'publisher_id',
        'category_id',
        'publication_year',
        'pages',
        'weight',
        'length',
        'width',
        'language',
        'description',
        'cover_image',
        'ddc_classification',
        'subject_headings',
        'abstract',
        'status',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'weight' => 'decimal:2',
            'length' => 'decimal:2',
            'width' => 'decimal:2',
        ];
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_author');
    }

    public function bookCopies()
    {
        return $this->hasMany(BookCopy::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
