<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MontajeServicio extends Model
{
    use HasFactory;

    protected $table = 'montaje_servicios';

    protected $fillable = [
        'titulo',
        'tipo_servicio_id',
        'descripcion',
        'fotos',
        'activo',
    ];

    protected $casts = [
        'fotos' => 'array',
        'activo' => 'boolean',
    ];

    public function tipoServicio(): BelongsTo
    {
        return $this->belongsTo(TipoServicio::class, 'tipo_servicio_id');
    }
}
