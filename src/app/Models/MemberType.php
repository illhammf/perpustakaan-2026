<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberType extends Model
{
    /** @use HasFactory<\Database\Factories\MemberTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'max_loans',
        'loan_duration_days',
        'fine_per_day',
        'renewal_limit',
        'can_reserve',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'can_reserve' => 'boolean',
            'is_active' => 'boolean',
            'fine_per_day' => 'decimal:2',
        ];
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
