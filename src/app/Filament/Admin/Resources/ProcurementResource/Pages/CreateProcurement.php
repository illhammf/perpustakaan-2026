<?php

namespace App\Filament\Admin\Resources\ProcurementResource\Pages;

use App\Filament\Admin\Resources\ProcurementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProcurement extends CreateRecord
{
    protected static string $resource = ProcurementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
