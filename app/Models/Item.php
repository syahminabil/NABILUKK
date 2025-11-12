<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // 🟢 Ubah ke jamak 'items'
    protected $table = 'items';
    protected $primaryKey = 'id_item';
    public $timestamps = true;

    protected $fillable = [
        'nama_item',
        'lokasi',
        'deskripsi',
        'foto',
    ];

    public function listLokasi()
    {
        return $this->hasMany(ListLokasi::class, 'id_item');
    }
}
