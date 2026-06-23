<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'member_type_id',
        'member_number',
        'name',
        'email',
        'phone',
        'address',
        'photo',
        'id_card_number',
        'birth_date',
        'gender',
        'member_card_number',
        'status',
        'registered_at',
        'expired_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'registered_at' => 'date',
            'expired_at' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function memberType()
    {
        return $this->belongsTo(MemberType::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function fines()
    {
        return $this->hasMany(Fine::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function getTotalFinesAttribute()
    {
        return $this->fines()->where('status', 'unpaid')->sum('amount');
    }
}
