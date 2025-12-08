<?php

namespace App\Filament\Resources\BrawlhallaAccountResource\Pages;

use App\Filament\Resources\BrawlhallaAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrawlhallaAccounts extends ListRecords
{
    protected static string $resource = BrawlhallaAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
