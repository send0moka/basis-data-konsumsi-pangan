<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenihPupukTopik extends Model
{
    use HasFactory;

    protected $table = 'benih_pupuk_topik';

    protected $fillable = [
        'kode',
        'nama_topik',
        'deskripsi'
    ];

    // Relationships
    public function variabels()
    {
        return $this->hasMany(BenihPupukVariabel::class, 'topik_id');
    }

    public function data()
    {
        return $this->hasMany(BenihPupukData::class, 'topik_id');
    }
}
