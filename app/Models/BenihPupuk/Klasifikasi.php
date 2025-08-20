<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Klasifikasi extends Model
{
    protected $table = 'benih_pupuk_klasifikasi';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'deskripsi'
    ];
    
    /**
     * Get the variabel records that have this klasifikasi.
     */
    public function variabels(): BelongsToMany
    {
        return $this->belongsToMany(Variabel::class, 'benih_pupuk_variabel_klasifikasi', 'id_klasifikasi', 'id_variabel')
                    ->withPivot(['keterangan']);
    }
    
    /**
     * Get the data records for this klasifikasi.
     */
    public function data(): HasMany
    {
        return $this->hasMany(Data::class, 'id_klasifikasi', 'id');
    }
}
