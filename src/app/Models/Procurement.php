<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procurement extends Model
{
    /** @use HasFactory<\Database\Factories\ProcurementFactory> */
    use HasFactory;

    protected $fillable = [
        'book_id',
        'supplier_name',
        'supplier_contact',
        'quantity',
        'unit_price',
        'total_price',
        'procurement_date',
        'invoice_number',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'procurement_date' => 'date',
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
