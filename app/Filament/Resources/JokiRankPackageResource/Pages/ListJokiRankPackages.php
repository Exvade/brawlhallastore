<?php

namespace App\Filament\Resources\JokiRankPackageResource\Pages;

use App\Filament\Resources\JokiRankPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJokiRankPackages extends ListRecords
{
    protected static string $resource = JokiRankPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
