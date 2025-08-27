<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $primaryKey = 'Id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'Kode',
        'Nama',
        'IdKategori',
        'IdParent',
        'Sorter'
    ];

    protected $casts = [
        'Id' => 'integer',
        'Kode' => 'integer',
        'IdKategori' => 'integer',
        'IdParent' => 'integer',
        'Sorter' => 'integer'
    ];

    /**
     * Get the kategori for this wilayah.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(WilayahKategori::class, 'IdKategori', 'id');
    }
}
