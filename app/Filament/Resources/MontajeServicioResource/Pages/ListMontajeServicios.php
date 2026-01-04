<?php

namespace App\Filament\Resources\MontajeServicioResource\Pages;

use App\Filament\Resources\MontajeServicioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMontajeServicios extends ListRecords
{
    protected static string $resource = MontajeServicioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
