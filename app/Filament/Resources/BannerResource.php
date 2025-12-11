<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo'; // Icon Foto
    protected static ?string $navigationLabel = 'Manajemen Banner';
    protected static ?string $navigationGroup = 'Website Content'; // Kelompokkan menu

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Banner')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Banner')
                            ->required()
                            ->maxLength(255),

                        Select::make('category')
                            ->label('Kategori / Posisi')
                            ->options([
                                'Jual Beli' => 'Halaman Stok Akun (Jual Beli)',
                                'Home' => 'Halaman Utama (Home)',
                                'Promo' => 'Promo Spesial',
                            ])
                            ->required()
                            ->native(false),

                        FileUpload::make('image_url')
                            ->label('Gambar Banner (Landscape)')
                            ->image()
                            ->directory('banners') // Simpan di folder storage/app/public/banners
                            ->disk('public')
                            ->required()
                            ->columnSpanFull(),

                        // Input tersembunyi untuk menyimpan ID Admin yang sedang login
                        Hidden::make('created_by')
                            ->default(fn() => auth()->id()),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Preview')
                    ->disk('public')
                    ->height(50),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('category')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Jual Beli' => 'info',
                        'Home' => 'success',
                        'Promo' => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('creator.name')
                    ->label('Diapload Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter berdasarkan kategori
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Jual Beli' => 'Jual Beli',
                        'Home' => 'Home',
                    ]),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
