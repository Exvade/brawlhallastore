<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JokiBattlepassPackageResource\Pages;
use App\Models\JokiBattlepassPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class JokiBattlepassPackageResource extends Resource
{
    protected static ?string $model = JokiBattlepassPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Paket Battlepass';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Paket')
                    ->required(),

                TextInput::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                FileUpload::make('icon_url')
                    ->label('Gambar Banner')
                    ->image()
                    ->directory('battlepass-icons')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('icon_url')->label('Banner'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('price')->money('IDR')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJokiBattlepassPackages::route('/'),
            'create' => Pages\CreateJokiBattlepassPackage::route('/create'),
            'edit' => Pages\EditJokiBattlepassPackage::route('/{record}/edit'),
        ];
    }
}
