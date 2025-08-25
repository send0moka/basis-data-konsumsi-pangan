<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenihPupukWilayah extends Model
{
    use HasFactory;

    protected $table = 'benih_pupuk_wilayah';

    protected $fillable = [
        'kode',
        'nama_wilayah',
        'jenis_wilayah',
        'parent_id'
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function data()
    {
        return $this->hasMany(BenihPupukData::class, 'wilayah_id');
    }

    // Scopes
    public function scopeProvinces($query)
    {
        return $query->where('jenis_wilayah', 'provinsi');
    }

    public function scopeKabupatenKota($query)
    {
        return $query->where('jenis_wilayah', 'kabupaten_kota');
    }
}
