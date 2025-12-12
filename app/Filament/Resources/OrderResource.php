<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Order Masuk';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->latest();
        $user = Auth::user();

        // Worker hanya melihat job yang sudah dibayar & (belum diambil atau milik dia sendiri)
        if ($user->role === 'worker') {
            return $query->where('payment_status', 'paid')
                ->where(function ($q) use ($user) {
                    $q->whereNull('worker_id')
                        ->orWhere('worker_id', $user->id);
                });
        }
        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // === SECTION 1: INFO ORDER (READ ONLY) ===
                Section::make('Informasi Order')
                    ->schema([
                        // PERBAIKAN: Ganti $c jadi $component, $r jadi $record

                        TextInput::make('view_order_id')
                            ->label('Order ID')
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(fn($component, $record) => $component->state($record->order_id)),

                        TextInput::make('view_pembeli')
                            ->label('Pembeli')
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(fn($component, $record) => $component->state($record->user->name ?? '-')),

                        TextInput::make('view_layanan')
                            ->label('Layanan')
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(fn($component, $record) => $component->state($record->service_type)),

                        TextInput::make('view_status')
                            ->label('Status Bayar')
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(fn($component, $record) => $component->state(strtoupper($record->payment_status ?? 'UNKNOWN'))),
                    ])->columns(2),

                // === SECTION 2: DATA AKUN (VIRTUAL FIELDS) ===
                Section::make('Data Akun Target')
                    ->description('Data ini muncul setelah Anda mengambil job.')
                    ->schema([
                        // Username
                        TextInput::make('view_username')
                            ->label('Email / Username')
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(function ($component, $record) {
                                $data = $record->account_credentials;
                                if (is_string($data)) $data = json_decode($data, true); // Anti Double Encode
                                $component->state($data['username'] ?? '-');
                            }),

                        // Password
                        TextInput::make('view_password')
                            ->label('Password')
                            ->password()->revealable()
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(function ($component, $record) {
                                $data = $record->account_credentials;
                                if (is_string($data)) $data = json_decode($data, true);
                                $component->state($data['password'] ?? '-');
                            }),

                        // Login Method
                        TextInput::make('view_method')
                            ->label('Login Via')
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(function ($component, $record) {
                                $data = $record->account_credentials;
                                if (is_string($data)) $data = json_decode($data, true);
                                $component->state($data['method'] ?? '-');
                            }),

                        // Catatan
                        Textarea::make('view_notes')
                            ->label('Catatan User')
                            ->columnSpanFull()
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(function ($component, $record) {
                                $data = $record->account_credentials;
                                if (is_string($data)) $data = json_decode($data, true);
                                $component->state($data['notes'] ?? '-');
                            }),
                    ])
                    ->columns(3)
                    // Visibility: Admin lihat semua, Worker lihat jika ID cocok
                    ->visible(function ($record) {
                        if (!$record) return false;
                        $user = Auth::user();
                        if ($user->role === 'admin') return true;
                        return (int)$record->worker_id === (int)$user->id;
                    }),

                // === SECTION 3: STATUS SAAT INI (READ ONLY DI FORM DETAIL) ===
                Section::make('Status Pengerjaan')
                    ->schema([
                        TextInput::make('view_work_status')
                            ->label('Status Saat Ini')
                            ->disabled()->dehydrated(false)
                            ->afterStateHydrated(fn($component, $record) => $component->state(strtoupper($record->work_status))),
                    ])
                    ->visible(fn($record) => $record !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('package.name')->label('Paket'),

                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray'
                    }),

                // PERBAIKAN 1: TAMPILAN DI TABEL DISAMAKAN DENGAN DROPDOWN
                Tables\Columns\TextColumn::make('work_status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'done' => 'success',
                        'on_progress' => 'info',
                        'pending' => 'gray',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending (Hold)',
                        'on_progress' => 'Sedang Dikerjakan', // Sekarang tabel akan nulis ini, bukan on_progress
                        'done' => 'Selesai',
                        default => $state,
                    })
                    ->label('Status Joki'),

                Tables\Columns\TextColumn::make('worker.name')
                    ->label('Worker')
                    ->placeholder('Belum Diambil'),

                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                // 1. AMBIL JOB
                Action::make('take_job')
                    ->label('AMBIL JOB')
                    ->icon('heroicon-m-hand-raised')
                    ->color('primary')
                    ->button()
                    ->requiresConfirmation()
                    ->action(function (Order $record) {
                        $record->update(['worker_id' => Auth::id(), 'work_status' => 'on_progress']);
                        \Filament\Notifications\Notification::make()->title('Job Diambil!')->success()->send();
                    })
                    ->visible(fn(Order $record) => $record->payment_status === 'paid' && $record->worker_id === null),

                // 2. LIHAT DETAIL
                Tables\Actions\ViewAction::make()->label('Detail'),

                // 3. UPDATE STATUS
                Action::make('update_progress')
                    ->label('Update Status')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning')
                    ->modalHeading('Update Status Pengerjaan')
                    ->form([
                        Select::make('work_status')
                            ->label('Status Pengerjaan')
                            ->options([
                                'pending' => 'Pending (Hold)',
                                'on_progress' => 'Sedang Dikerjakan',
                                'done' => 'Selesai',
                            ])
                            ->required()
                            ->native(false)
                            // PERBAIKAN 2: OTOMATIS PILIH STATUS SAAT INI
                            ->default(fn(Order $record) => $record->work_status)
                    ])
                    ->action(function (Order $record, array $data) {
                        $record->update(['work_status' => $data['work_status']]);
                        \Filament\Notifications\Notification::make()->title('Status Diupdate!')->success()->send();
                    })
                    ->visible(function (Order $record) {
                        $user = Auth::user();
                        if ($user->role === 'admin') return true;
                        return $user->role === 'worker' && (int)$record->worker_id === (int)$user->id;
                    }),
            ])
            ->poll('5s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
