<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jnsPajak extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pajak',
        'deskripsi',
        'tarif',
        'keterangan'
    ];
}