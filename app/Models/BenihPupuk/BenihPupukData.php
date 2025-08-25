<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenihPupukData extends Model
{
    use HasFactory;

    protected $table = 'benih_pupuk_data';

    protected $fillable = [
        'topik_id',
        'variabel_id',
        'klasifikasi_id',
        'wilayah_id',
        'bulan_id',
        'tahun',
        'nilai',
        'satuan'
    ];

    protected $casts = [
        'nilai' => 'decimal:2'
    ];

    // Relationships
    public function topik()
    {
        return $this->belongsTo(BenihPupukTopik::class, 'topik_id');
    }

    public function variabel()
    {
        return $this->belongsTo(BenihPupukVariabel::class, 'variabel_id');
    }

    public function klasifikasi()
    {
        return $this->belongsTo(BenihPupukKlasifikasi::class, 'klasifikasi_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(BenihPupukWilayah::class, 'wilayah_id');
    }

    public function bulan()
    {
        return $this->belongsTo(BenihPupukBulan::class, 'bulan_id');
    }

    // Scopes for filtering
    public function scopeByTopik($query, $topikId)
    {
        return $query->where('topik_id', $topikId);
    }

    public function scopeByVariabel($query, $variabelIds)
    {
        return $query->whereIn('variabel_id', (array) $variabelIds);
    }

    public function scopeByKlasifikasi($query, $klasifikasiIds)
    {
        return $query->whereIn('klasifikasi_id', (array) $klasifikasiIds);
    }

    public function scopeByWilayah($query, $wilayahIds)
    {
        return $query->whereIn('wilayah_id', (array) $wilayahIds);
    }

    public function scopeByBulan($query, $bulanIds)
    {
        return $query->whereIn('bulan_id', (array) $bulanIds);
    }

    public function scopeByTahun($query, $tahunAwal, $tahunAkhir = null)
    {
        if ($tahunAkhir) {
            return $query->whereBetween('tahun', [$tahunAwal, $tahunAkhir]);
        }
        return $query->where('tahun', $tahunAwal);
    }
}
