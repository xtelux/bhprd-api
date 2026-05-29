<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hakakses extends Model
{
    use HasFactory;
    protected $fillable = ['rolename', 'keterangan'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'hakakses_id', 'id');
    }
}
