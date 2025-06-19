<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spesialisasi',
        'pengalaman_tahun',
        'str_number',
        'bio',
    ];

    /**
     * Get the user that owns the professional profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The licenses that belong to the professional.
     */
    public function licenses(): BelongsToMany
    {
        return $this->belongsToMany(License::class, 'professional_license')
                    ->withTimestamps();
    }
} 