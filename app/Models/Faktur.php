<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faktur extends Model
{
    use HasFactory;
    protected $fillable = ['invoice_number', 'alamat', 'kode_pos', 'total_harga'];
}

