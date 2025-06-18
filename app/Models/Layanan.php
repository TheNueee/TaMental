<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'name',
        'description',
        'duration_minutes',
        'price',
    ];

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function konsultasi()
    {
        return $this->hasMany(Konsultasi::class, 'layanan_id');
    }
}
