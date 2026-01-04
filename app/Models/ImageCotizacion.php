<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImageCotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizacion_imagenes';

    protected $fillable = [
        'cotizacion_id',
        'path',
    ];

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }
    public function getPublicUrlAttribute(): string
    {
        $base = rtrim(config('app.public_uploads_url'), '/');
        $path = ltrim((string) $this->path, '/');

        return $base . '/' . $path;
    }
}
