<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JokiRankPackageResource\Pages;
use App\Models\JokiRankPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class JokiRankPackageResource extends Resource
{
    protected static ?string $model = JokiRankPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Paket Rank';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Rank') // Contoh: Mythic Grading
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                FileUpload::make('icon_url')
                    ->label('Icon Rank')
                    ->image() // Wajib gambar
                    ->directory('rank-icons') // Folder simpan
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon_url')->label('Icon'),

                TextColumn::make('name')
                    ->label('Nama Rank')
                    ->searchable(),

                TextColumn::make('price')
                    ->money('IDR') // Format Rp otomatis
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListJokiRankPackages::route('/'),
            'create' => Pages\CreateJokiRankPackage::route('/create'),
            'edit' => Pages\EditJokiRankPackage::route('/{record}/edit'),
        ];
    }
}
