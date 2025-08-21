<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LahanKlasifikasi extends Model
{
    use HasFactory;
    
    protected $table = 'lahan_klasifikasi';
    
    protected $fillable = [
        'nama',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function lahanData(): HasMany
    {
        return $this->hasMany(LahanData::class, 'id_lahan_klasifikasi');
    }
}
