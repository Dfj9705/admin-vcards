<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CotizacionResource\Pages;
use App\Filament\Resources\CotizacionResource\RelationManagers;
use App\Filament\Resources\CotizacionResource\RelationManagers\ImagenesRelationManager;
use App\Models\Cotizacion;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CotizacionResource extends Resource
{
    protected static ?string $model = Cotizacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Cotización';

    protected static ?string $pluralLabel = 'Cotizaciones';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nombre')->required()->maxLength(150),
            TextInput::make('fecha')->required()->maxLength(150),
            TextInput::make('email')->email()->required()->maxLength(150),
            TextInput::make('telefono')->required()->maxLength(30),
            Select::make('servicio')
                ->label('Servicio')
                ->relationship('tipoServicio', 'nombre')
                ->searchable()
                ->preload()
                ->required(),
            Textarea::make('observaciones')->rows(4),
            Select::make('estado')
                ->required()
                ->options([
                    'nueva' => 'Nueva',
                    'en_proceso' => 'En proceso',
                    'cerrada' => 'Cerrada',
                ])
                ->default('nueva'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('nombre')->searchable(),
                TextColumn::make('fecha')->searchable(),
                TextColumn::make('telefono')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('tipoServicio.nombre')
                    ->label('Servicio')
                    ->searchable()
                    ->sortable()

                ,
                TextColumn::make('imagenes_count')
                    ->label('Imgs')
                    ->counts('imagenes')
                    ->badge()
                    ->sortable(),
                TextColumn::make('observaciones')->searchable(),
                TextColumn::make('estado')->badge(),
                TextColumn::make('created_at')->dateTime('Y-m-d H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('estado')->options([
                    'nueva' => 'Nueva',
                    'en_proceso' => 'En proceso',
                    'cerrada' => 'Cerrada',
                    'confirmada' => 'Confirmada',
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('en_proceso')
                    ->label('En proceso')
                    ->icon('heroicon-o-arrow-path')
                    ->visible(fn($record) => $record->estado === 'nueva')
                    ->color('warning')
                    ->action(fn($record) => $record->update(['estado' => 'en_proceso']))
                    ->requiresConfirmation(),

                Tables\Actions\Action::make('confirmar')
                    ->icon('heroicon-o-check-circle')
                    ->visible(fn($record) => $record->estado !== 'cerrada')
                    ->color('success')
                    ->action(fn($record) => $record->update(['estado' => 'confirmada']))
                    ->requiresConfirmation(),

                Tables\Actions\Action::make('cerrar')
                    ->label('Cerrar')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn($record) => $record->estado !== 'cerrada')
                    ->action(fn($record) => $record->update(['estado' => 'cerrada']))
                    ->requiresConfirmation(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ImagenesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCotizacions::route('/'),
            'create' => Pages\CreateCotizacion::route('/create'),
            'edit' => Pages\EditCotizacion::route('/{record}/edit'),
        ];
    }
}
