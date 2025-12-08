<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrawlhallaAccountResource\Pages;
use App\Models\BrawlhallaAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select; // Penting buat pilih user
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class BrawlhallaAccountResource extends Resource
{
    protected static ?string $model = BrawlhallaAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group'; // Icon orang
    protected static ?string $navigationLabel = 'Jual Akun';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Akun')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul / Nama Akun')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('price')
                            ->label('Harga Jual')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),

                        // Dropdown untuk memilih siapa pemilik akun ini (User)
                        Select::make('created_by')
                            ->label('Penjual (User)')
                            ->relationship('seller', 'name') // Mengambil nama user dari relasi 'seller'
                            ->searchable() // Bisa dicari ketik nama
                            ->preload()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail & Gambar')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi Lengkap (Skin, Rank, dll)')
                            ->rows(5)
                            ->required()
                            ->columnSpanFull(), // Lebar penuh

                        FileUpload::make('image_url')
                            ->label('Screenshot Akun (Max 7)')
                            ->image()
                            ->multiple() // KUNCI UTAMA: Mengizinkan banyak file
                            ->maxFiles(7) // Batasi maksimal 7
                            ->reorderable() // Bisa geser-geser urutan gambar
                            ->disk('public')
                            ->directory('account-images')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Data Tambahan')
                    ->schema([
                        TextInput::make('rekber_number')
                            ->label('Nomor Rekber (Opsional)'),

                        TextInput::make('seller_number')
                            ->label('Nomor HP Penjual')
                            ->tel(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Galeri')
                    ->disk('public')
                    ->circular() // Bentuk bulat
                    ->stacked() // Gambar ditumpuk agar hemat tempat
                    ->limit(3), // Cuma tampilkan 3 tumpukan pertama

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->color('success'), // Warna hijau biar menarik

                TextColumn::make('seller.name') // Menampilkan nama penjual dari relasi
                    ->label('Penjual')
                    ->icon('heroicon-m-user')
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
            'index' => Pages\ListBrawlhallaAccounts::route('/'),
            'create' => Pages\CreateBrawlhallaAccount::route('/create'),
            'edit' => Pages\EditBrawlhallaAccount::route('/{record}/edit'),
        ];
    }
}
