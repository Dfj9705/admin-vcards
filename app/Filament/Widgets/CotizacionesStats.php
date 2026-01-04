<?php

namespace App\Filament\Widgets;

use App\Models\Cotizacion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CotizacionesStats extends BaseWidget
{
    protected int|string|array $columnSpan = 12;

    protected function getStats(): array
    {
        return [
            Stat::make('Total', Cotizacion::query()->count())->icon('heroicon-o-document-text')->color('primary'),
            Stat::make('Nuevas', Cotizacion::query()->where('estado', 'nueva')->count())->icon('heroicon-o-document-text')->color('success'),
            Stat::make('En proceso', Cotizacion::query()->where('estado', 'en_proceso')->count())->icon('heroicon-o-document-text')->color('warning'),
            Stat::make('Cerradas', Cotizacion::query()->where('estado', 'cerrada')->count())->icon('heroicon-o-document-text')->color('danger'),
            Stat::make('Confirmadas', Cotizacion::query()->where('estado', 'confirmada')->count())->icon('heroicon-o-document-text')->color('warning'),
        ];
    }
}
