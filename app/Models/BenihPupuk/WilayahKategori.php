<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WilayahKategori extends Model
{
    protected $table = 'benih_pupuk_wilayah_kategori';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'deskripsi'
    ];
    
    /**
     * Get the wilayah records for this kategori.
     */
    public function wilayahs(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'id_kategori', 'id');
    }
}
