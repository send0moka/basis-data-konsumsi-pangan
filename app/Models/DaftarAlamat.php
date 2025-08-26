<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarAlamat extends Model
{
    use HasFactory;

    protected $table = 'daftar_alamat';

    protected $fillable = [
        'no',
        'wilayah',
        'nama_dinas',
        'alamat',
        'telp',
        'faks',
        'email',
        'website',
        'posisi',
        'urut',
        'status',
        'kategori',
        'keterangan',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'urut' => 'integer',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopeByWilayah($query, $wilayah)
    {
        return $query->where('wilayah', 'like', '%' . $wilayah . '%');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeWithCoordinates($query)
    {
        return $query->whereNotNull('latitude')->whereNotNull('longitude');
    }

    // Accessors
    public function getHasCoordinatesAttribute()
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    public function getFormattedTelpAttribute()
    {
        if (!$this->telp) return null;
        
        // Clean and format phone number
        $telp = preg_replace('/[^0-9]/', '', $this->telp);
        if (strlen($telp) >= 10) {
            return substr($telp, 0, 4) . '-' . substr($telp, 4, 4) . '-' . substr($telp, 8);
        }
        return $this->telp;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Aktif' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'Tidak Aktif' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'Draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'Arsip' => 'bg-neutral-100 text-neutral-800 dark:bg-neutral-900 dark:text-neutral-300',
            'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        ];

        return $badges[$this->status] ?? 'bg-neutral-100 text-neutral-800';
    }

    // Static methods
    public static function getStatusOptions()
    {
        return [
            'Aktif' => 'Aktif',
            'Tidak Aktif' => 'Tidak Aktif',
            'Draft' => 'Draft',
            'Arsip' => 'Arsip',
            'Pending' => 'Pending',
        ];
    }

    public static function getKategoriOptions()
    {
        return [
            'Dinas Pertanian' => 'Dinas Pertanian',
            'Dinas Peternakan' => 'Dinas Peternakan',
            'Dinas Perkebunan' => 'Dinas Perkebunan',
            'Dinas Kehutanan' => 'Dinas Kehutanan',
            'Dinas Perikanan' => 'Dinas Perikanan',
            'Badan Ketahanan Pangan' => 'Badan Ketahanan Pangan',
            'Balai Pengkajian Teknologi' => 'Balai Pengkajian Teknologi',
            'Lainnya' => 'Lainnya',
        ];
    }
}
