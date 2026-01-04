<?php

namespace App\Filament\Widgets;

use App\Models\Cotizacion;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UltimasCotizaciones extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Ultimas cotizaciones';
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Cotizacion::query()->latest('created_at')->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('nombre')->searchable(),
                Tables\Columns\TextColumn::make('telefono')->searchable(),
                Tables\Columns\TextColumn::make('tipoServicio.nombre')->label('Servicio')->toggleable(),
                Tables\Columns\TextColumn::make('estado')->badge(),
                Tables\Columns\TextColumn::make('created_at')->label('Fecha')->dateTime('Y-m-d H:i'),
            ])
            ->actions([
                Tables\Actions\Action::make('ver')->url(fn($record) => \App\Filament\Resources\CotizacionResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
