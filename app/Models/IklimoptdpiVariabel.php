<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IklimoptdpiVariabel extends Model
{
    use HasFactory;
    
    protected $table = 'iklimoptdpi_variabel';
    
    protected $fillable = [
        'nama',
        'satuan',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function iklimoptdpiData(): HasMany
    {
        return $this->hasMany(IklimoptdpiData::class, 'id_iklimoptdpi_variabel');
    }
}
