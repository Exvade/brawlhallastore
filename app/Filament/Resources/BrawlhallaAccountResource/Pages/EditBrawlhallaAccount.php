<?php

namespace App\Filament\Resources\BrawlhallaAccountResource\Pages;

use App\Filament\Resources\BrawlhallaAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrawlhallaAccount extends EditRecord
{
    protected static string $resource = BrawlhallaAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
