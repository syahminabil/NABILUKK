<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id', 
        'nama',
        'gender',
        'telp',
        'password', // penting untuk login
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 🔹 Relasi ke tabel pengaduan
     * Satu petugas bisa menangani banyak pengaduan
     */
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_petugas', 'id_petugas');
    }

    /**
     * 🔹 Relasi opsional ke User (berdasarkan nama)
     * Catatan: ini hanya berfungsi kalau 'nama' petugas == 'name' user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
