<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IklimoptdpiData extends Model
{
    use HasFactory;
    
    protected $table = 'iklimoptdpi_data';
    
    protected $fillable = [
        'nilai',
        'wilayah',
        'tahun',
        'status',
        'id_iklimoptdpi_topik',
        'id_iklimoptdpi_variabel',
        'id_iklimoptdpi_klasifikasi',
    ];

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:2',
            'tahun' => 'integer',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function iklimoptdpiTopik(): BelongsTo
    {
        return $this->belongsTo(IklimoptdpiTopik::class, 'id_iklimoptdpi_topik');
    }

    // Alias for iklimoptdpiTopik to match the relationship name used in the component
    public function topik()
    {
        return $this->belongsTo(IklimoptdpiTopik::class, 'id_iklimoptdpi_topik');
    }

    public function iklimoptdpiVariabel(): BelongsTo
    {
        return $this->belongsTo(IklimoptdpiVariabel::class, 'id_iklimoptdpi_variabel');
    }

    // Alias for iklimoptdpiVariabel to match the relationship name used in the component
    public function variabel()
    {
        return $this->belongsTo(IklimoptdpiVariabel::class, 'id_iklimoptdpi_variabel');
    }

    public function iklimoptdpiKlasifikasi(): BelongsTo
    {
        return $this->belongsTo(IklimoptdpiKlasifikasi::class, 'id_iklimoptdpi_klasifikasi');
    }

    // Alias for iklimoptdpiKlasifikasi to match the relationship name used in the component
    public function klasifikasi()
    {
        return $this->belongsTo(IklimoptdpiKlasifikasi::class, 'id_iklimoptdpi_klasifikasi');
    }
}
