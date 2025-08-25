<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenihPupukBulan extends Model
{
    use HasFactory;

    protected $table = 'benih_pupuk_bulan';

    protected $fillable = [
        'nomor_bulan',
        'nama_bulan',
        'nama_singkat'
    ];

    // Relationships
    public function data()
    {
        return $this->hasMany(BenihPupukData::class, 'bulan_id');
    }
}
