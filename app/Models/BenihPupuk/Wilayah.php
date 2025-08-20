<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wilayah extends Model
{
    protected $table = 'benih_pupuk_wilayah';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'kode',
        'nama',
        'id_kategori',
        'id_parent',
        'sorter'
    ];
    
    protected $casts = [
        'kode' => 'integer',
        'id_kategori' => 'integer',
        'id_parent' => 'integer',
        'sorter' => 'integer'
    ];
    
    /**
     * Get the kategori for this wilayah.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(WilayahKategori::class, 'id_kategori', 'id');
    }
    
    /**
     * Get the parent wilayah.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'id_parent', 'id');
    }
    
    /**
     * Get the child wilayah records.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'id_parent', 'id');
    }
    
    /**
     * Get the data records for this wilayah.
     */
    public function data(): HasMany
    {
        return $this->hasMany(Data::class, 'id_wilayah', 'id');
    }
}
