<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isProfessional()
    {
        return $this->role === 'professional';
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
    
    /**
     * Get the professional information associated with the user.
     */
    public function professional(): HasOne
    {
        return $this->hasOne(Professional::class);
    }

    public function konsultasiSebagaiClient()
    {
        return $this->hasMany(Konsultasi::class, 'client_id');
    }

    public function konsultasiSebagaiProfessional()
    {
        return $this->hasMany(Konsultasi::class, 'professional_id');
    }

    public function layanans()
    {
        return $this->hasMany(Layanan::class, 'professional_id');
    }

    public function pengujian()
    {
        return $this->hasMany(PengujianDass21::class);
    }
}
