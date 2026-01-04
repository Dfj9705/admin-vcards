<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = 'cotizaciones';

    protected $fillable = [
        'nombre',
        'fecha',
        'email',
        'telefono',
        'servicio',
        'observaciones',
        'estado',
    ];

    public function imagenes(): HasMany
    {
        return $this->hasMany(ImageCotizacion::class, 'cotizacion_id');
    }

    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class, 'servicio');
    }
}
