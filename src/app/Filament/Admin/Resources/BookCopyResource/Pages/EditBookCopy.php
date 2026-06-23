<?php

namespace App\Filament\Admin\Resources\BookCopyResource\Pages;

use App\Filament\Admin\Resources\BookCopyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookCopy extends EditRecord
{
    protected static string $resource = BookCopyResource::class;

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
