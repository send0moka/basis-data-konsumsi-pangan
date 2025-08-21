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
        'nilai',
        'wilayah',
        'tahun',
        'status',
        'id_lahan_topik',
        'id_lahan_variabel',
        'id_lahan_klasifikasi',
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

    public function lahanTopik(): BelongsTo
    {
        return $this->belongsTo(LahanTopik::class, 'id_lahan_topik');
    }

    public function lahanVariabel(): BelongsTo
    {
        return $this->belongsTo(LahanVariabel::class, 'id_lahan_variabel');
    }

    public function lahanKlasifikasi(): BelongsTo
    {
        return $this->belongsTo(LahanKlasifikasi::class, 'id_lahan_klasifikasi');
    }
}
