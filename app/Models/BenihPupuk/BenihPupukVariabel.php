<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenihPupukVariabel extends Model
{
    use HasFactory;

    protected $table = 'benih_pupuk_variabel';

    protected $fillable = [
        'topik_id',
        'kode',
        'nama_variabel',
        'deskripsi',
        'satuan'
    ];

    // Relationships
    public function topik()
    {
        return $this->belongsTo(BenihPupukTopik::class, 'topik_id');
    }

    public function klasifikasis()
    {
        return $this->belongsToMany(BenihPupukKlasifikasi::class, 
            'benih_pupuk_variabel_klasifikasi', 
            'variabel_id', 
            'klasifikasi_id'
        );
    }

    public function data()
    {
        return $this->hasMany(BenihPupukData::class, 'variabel_id');
    }
}
