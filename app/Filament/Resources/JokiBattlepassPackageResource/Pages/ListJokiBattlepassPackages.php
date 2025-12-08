<?php

namespace App\Filament\Resources\JokiBattlepassPackageResource\Pages;

use App\Filament\Resources\JokiBattlepassPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJokiBattlepassPackages extends ListRecords
{
    protected static string $resource = JokiBattlepassPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
