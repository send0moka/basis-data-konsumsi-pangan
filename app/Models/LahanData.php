<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LahanData extends Model
{
    use HasFactory;
    
    protected $table = 'lahan_data';
    
    protected $fillable = [
        'tahun',
        'id_bulan',
        'id_wilayah',
        'id_variabel',
        'id_klasifikasi',
        'nilai',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:4',
            'tahun' => 'integer',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }

    public function bulan(): BelongsTo
    {
        return $this->belongsTo(Bulan::class, 'id_bulan');
    }

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah');
    }

    public function variabel(): BelongsTo
    {
        return $this->belongsTo(LahanVariabel::class, 'id_variabel');
    }

    public function klasifikasi(): BelongsTo
    {
        return $this->belongsTo(LahanKlasifikasi::class, 'id_klasifikasi');
    }

    // Get the topik through variabel relationship
    public function topik(): BelongsTo
    {
        return $this->belongsTo(LahanTopik::class, 'id_topik')
                    ->through('variabel');
    }
}
