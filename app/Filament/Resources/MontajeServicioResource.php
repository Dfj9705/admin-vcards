<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MontajeServicioResource\Pages;
use App\Filament\Resources\MontajeServicioResource\RelationManagers;
use App\Models\MontajeServicio;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;

class MontajeServicioResource extends Resource
{
    protected static ?string $model = MontajeServicio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Montaje de servicios';
    protected static ?string $modelLabel = 'Montaje de servicio';
    protected static ?string $pluralModelLabel = 'Montaje de servicios';
    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('titulo')
                ->label('Título')
                ->required()
                ->maxLength(150),

            Select::make('tipo_servicio_id')
                ->label('Tipo de servicio')
                ->relationship('tipoServicio', 'nombre', fn($query) => $query->where('activo', true))
                ->searchable()
                ->preload()
                ->required(),

            RichEditor::make('descripcion')
                ->label('Descripción')
                ->columnSpanFull(),

            FileUpload::make('fotos')
                ->label('Fotos')
                ->disk('public')
                ->directory('montajes')
                ->image()
                ->multiple()
                ->reorderable()
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(1440)
                ->imageResizeTargetHeight(1440)
                ->imageResizeUpscale(false)
                ->maxFiles(10)
                ->appendFiles()
                ->columnSpanFull(),

            Toggle::make('activo')
                ->label('Activo')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('fotos.0')
                    ->label('Foto')
                    ->disk('public')
                    ->height(60)
                    ->width(60)
                    ->circular(),

                TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tipoServicio.nombre')
                    ->label('Tipo de servicio')
                    ->sortable(),

                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListMontajeServicios::route('/'),
            'create' => Pages\CreateMontajeServicio::route('/create'),
            'edit' => Pages\EditMontajeServicio::route('/{record}/edit'),
        ];
    }
}
