<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageCotizacion extends Model
{
    use HasFactory;

    protected $table = 'image_cotizaciones';

    protected $fillable = [
        'cotizacion_id',
        'path',
    ];

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }
}
