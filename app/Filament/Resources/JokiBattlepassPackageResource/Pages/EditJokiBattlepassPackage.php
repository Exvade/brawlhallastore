<?php

namespace App\Filament\Resources\JokiBattlepassPackageResource\Pages;

use App\Filament\Resources\JokiBattlepassPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJokiBattlepassPackage extends EditRecord
{
    protected static string $resource = JokiBattlepassPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
