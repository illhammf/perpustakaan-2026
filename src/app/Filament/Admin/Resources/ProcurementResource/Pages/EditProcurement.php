<?php

namespace App\Filament\Admin\Resources\ProcurementResource\Pages;

use App\Filament\Admin\Resources\ProcurementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProcurement extends EditRecord
{
    protected static string $resource = ProcurementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
