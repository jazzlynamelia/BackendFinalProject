<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_id', 'nama', 'harga', 'jumlah', 'foto'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
