<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor',
        'tanggal_terbit',
        'tanggal_expired',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_expired' => 'date',
    ];

    /**
     * The professionals that belong to the license.
     */
    public function professionals(): BelongsToMany
    {
        return $this->belongsToMany(Professional::class, 'professional_license')
                    ->withTimestamps();
    }
} 