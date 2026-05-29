<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subjek extends Model
{
    use HasFactory;
    protected $fillable = ['kd_kelurahan', 'nama', 'jalan', 'blok_rtrw', 'kelurahan', 'kecamatan', 'kota', 'telp', 'foto', 'deskripsi', 'keterangan', 'jns_subjek'];

    // TempPerhitunganPdrd
    public function temptperhitungan(): BelongsTo
    {
        return $this->belongsTo(TempPerhitunganPdrd::class, 'kd_kelurahan', 'kd_kelurahan');
    }

    public function getRouteKeyName()
    {
        return 'kd_kelurahan';
    }
}
