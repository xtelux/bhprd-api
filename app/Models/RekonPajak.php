<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekonPajak extends Model
{
    use HasFactory;
    protected $fillable = ['sspd', 'no_objek_pajak', 'subjek_pajak', 'tgl_bayar', 'jumlah_bayar', 'kd_jns_pajak', 'kd_kelurahan', 'user_id']; 

    public function jenispajak(): BelongsTo {  
        return $this->belongsTo(jnsPajak::class, 'kd_jns_pajak', 'id');  
    }  
}
