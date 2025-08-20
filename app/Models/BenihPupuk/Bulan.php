<?php

namespace App\Models\BenihPupuk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bulan extends Model
{
    protected $table = 'benih_pupuk_bulan';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'nama'
    ];
    
    protected $casts = [
        'id' => 'integer'
    ];
    
    /**
     * Get the data records for this bulan.
     */
    public function data(): HasMany
    {
        return $this->hasMany(Data::class, 'id_bulan', 'id');
    }
}
