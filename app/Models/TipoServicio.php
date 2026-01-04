<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoServicio extends Model
{
    use HasFactory;

    protected $table = 'tipo_servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    // Relación futura (si luego migras cotizaciones a FK)
    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class, 'servicio');
    }
}
