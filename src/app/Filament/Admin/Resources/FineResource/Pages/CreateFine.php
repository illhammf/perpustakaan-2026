<?php

namespace App\Filament\Admin\Resources\FineResource\Pages;

use App\Filament\Admin\Resources\FineResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFine extends CreateRecord
{
    protected static string $resource = FineResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
