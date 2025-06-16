<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengujianDass21 extends Model
{
    use HasFactory;

    protected $table = 'pengujian_dass21';

    protected $fillable = [
        'user_id',
        'nama',
        'skor_depresi',
        'skor_kecemasan',
        'skor_stres',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'skor_depresi' => 'integer',
        'skor_kecemasan' => 'integer',
        'skor_stres' => 'integer',
    ];

    // Relationship dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk kategori depresi
    public function getKategoriDepresiAttribute()
    {
        return $this->kategorisasiDepresi($this->skor_depresi);
    }

    // Accessor untuk kategori kecemasan
    public function getKategoriKecemasanAttribute()
    {
        return $this->kategorisasiKecemasan($this->skor_kecemasan);
    }

    // Accessor untuk kategori stres
    public function getKategoriStresAttribute()
    {
        return $this->kategorisasiStres($this->skor_stres);
    }

    // Method untuk kategorisasi depresi
    private function kategorisasiDepresi($skor)
    {
        if ($skor <= 9)
            return 'Normal';
        if ($skor <= 13)
            return 'Ringan';
        if ($skor <= 20)
            return 'Sedang';
        if ($skor <= 27)
            return 'Parah';
        return 'Sangat Parah';
    }

    // Method untuk kategorisasi kecemasan
    private function kategorisasiKecemasan($skor)
    {
        if ($skor <= 7)
            return 'Normal';
        if ($skor <= 9)
            return 'Ringan';
        if ($skor <= 14)
            return 'Sedang';
        if ($skor <= 19)
            return 'Parah';
        return 'Sangat Parah';
    }

    // Method untuk kategorisasi stres
    private function kategorisasiStres($skor)
    {
        if ($skor <= 14)
            return 'Normal';
        if ($skor <= 18)
            return 'Ringan';
        if ($skor <= 25)
            return 'Sedang';
        if ($skor <= 33)
            return 'Parah';
        return 'Sangat Parah';
    }
}