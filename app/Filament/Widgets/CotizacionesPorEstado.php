<?php

namespace App\Filament\Widgets;

use App\Models\Cotizacion;
use Filament\Widgets\ChartWidget;

class CotizacionesPorEstado extends ChartWidget
{
    protected static ?string $heading = 'Cotizaciones por estado';
    protected int|string|array $columnSpan = 12;
    protected function getData(): array
    {
        $nueva = Cotizacion::where('estado', 'nueva')->count();
        $proceso = Cotizacion::where('estado', 'en_proceso')->count();
        $cerrada = Cotizacion::where('estado', 'cerrada')->count();
        $confirmada = Cotizacion::where('estado', 'confirmada')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad',
                    'data' => [$nueva, $proceso, $cerrada, $confirmada],
                ],
            ],
            'labels' => ['Nueva', 'En proceso', 'Cerrada', 'Confirmada'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // o 'pie', 'line', 'doughnut'
    }
}
