<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FakturDetail extends Model
{
    use HasFactory;
    protected $fillable = ['faktur_id', 'nama_barang', 'kategori', 'harga', 'jumlah', 'subtotal'];
}

