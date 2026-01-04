<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnuncioResource\Pages;
use App\Filament\Resources\AnuncioResource\RelationManagers;
use App\Models\Anuncio;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnuncioResource extends Resource
{
    protected static ?string $model = Anuncio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('titulo')
                ->label('Título')
                ->required()
                ->maxLength(150),

            TextInput::make('subtitulo')
                ->label('Subtítulo')
                ->maxLength(200),

            TextInput::make('orden')
                ->label('Orden')
                ->numeric()
                ->default(1)
                ->required(),

            FileUpload::make('imagen')
                ->label('Imagen')
                ->disk('public')
                ->directory('anuncios')
                ->image()
                ->required()
                // tamaño estándar al subir (ajustá a tu diseño)
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(1920)
                ->imageResizeTargetHeight(800)
                ->imageResizeUpscale(false),

            Toggle::make('activo')
                ->label('Activo')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagen')
                    ->label('Imagen')
                    ->disk('public')
                    ->height(50),

                TextColumn::make('titulo')->label('Título')->searchable()->sortable(),
                TextColumn::make('subtitulo')->label('Subtítulo')->limit(30),

                TextColumn::make('orden')->label('Orden')->sortable(),

                ToggleColumn::make('activo')->label('Activo'),
            ])
            ->defaultSort('orden', 'asc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnuncios::route('/'),
            'create' => Pages\CreateAnuncio::route('/create'),
            'edit' => Pages\EditAnuncio::route('/{record}/edit'),
        ];
    }
}
