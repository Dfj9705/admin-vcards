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
                    ->getStateUsing(fn($record) => $record->url) // usa accessor
                    ->square(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('Y-m-d H:i'),
            ])
            ->headerActions([
                // Opcional: permitir agregar manualmente desde admin (si quieres)
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
