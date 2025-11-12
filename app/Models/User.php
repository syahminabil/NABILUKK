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
        'role', // admin / user / petugas
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 🔹 Relasi ke tabel pengaduan
     */
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_user', 'id');
    }

    /**
     * 🔹 Relasi opsional ke Petugas (berdasarkan nama)
     * Catatan: hanya berfungsi jika name == nama di tabel petugas
     */
    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'nama', 'name');
    }
}
