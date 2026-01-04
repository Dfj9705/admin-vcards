<?php

namespace App\Filament\Resources\CotizacionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImagenesRelationManager extends RelationManager
{
    protected static string $relationship = 'imagenes';

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Imagen')
                    ->getStateUsing(fn($record) => $record->public_url)
                    ->square()
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->headerActions([
                // Si NO quieres subir desde admin, déjalo vacío
            ])
            ->actions([
                Tables\Actions\Action::make('ver')
                    ->label('Ver')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn($record) => $record->public_url)
                    ->openUrlInNewTab(),

                // Opcional: borrar registro (no borra archivo físico)
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
