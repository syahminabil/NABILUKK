<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryItem extends Model
{
    use HasFactory;

    protected $table = 'temporary_item';
    protected $primaryKey = 'id_temporary';

    protected $fillable = [
        'id_item',
        'nama_barang_baru',
        'lokasi_barang_baru',
        'foto',
        'id_lokasi',
        'judul_pengaduan',
        'deskripsi_pengaduan',
        'foto_pengaduan',
        'deskripsi_barang_baru',
        'id_pengaduan',
        'id_user',
        'status',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'id_item', 'id_item');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
