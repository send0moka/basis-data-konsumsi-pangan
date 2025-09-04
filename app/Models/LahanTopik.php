<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LahanTopik extends Model
{
    use HasFactory;
    
    protected $table = 'lahan_topik';
    public $timestamps = false;
    
    protected $fillable = [
        'deskripsi',
    ];

    public function variabels(): HasMany
    {
        return $this->hasMany(LahanVariabel::class, 'id_topik');
    }

    public function data(): HasMany
    {
        return $this->hasMany(LahanData::class, 'id_topik');
    }
}
