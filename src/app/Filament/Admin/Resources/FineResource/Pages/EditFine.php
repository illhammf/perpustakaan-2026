<?php

namespace App\Filament\Admin\Resources\FineResource\Pages;

use App\Filament\Admin\Resources\FineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFine extends EditRecord
{
    protected static string $resource = FineResource::class;

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
