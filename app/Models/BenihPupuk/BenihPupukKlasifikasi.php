<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenihPupukKlasifikasi extends Model
{
    use HasFactory;

    protected $table = 'benih_pupuk_klasifikasi';

    protected $fillable = [
        'kode',
        'nama_klasifikasi',
        'deskripsi'
    ];

    // Relationships
    public function variabels()
    {
        return $this->belongsToMany(BenihPupukVariabel::class, 
            'benih_pupuk_variabel_klasifikasi', 
            'klasifikasi_id', 
            'variabel_id'
        );
    }

    public function data()
    {
        return $this->hasMany(BenihPupukData::class, 'klasifikasi_id');
    }
}
