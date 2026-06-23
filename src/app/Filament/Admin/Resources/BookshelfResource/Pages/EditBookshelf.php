<?php

namespace App\Filament\Admin\Resources\BookshelfResource\Pages;

use App\Filament\Admin\Resources\BookshelfResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookshelf extends EditRecord
{
    protected static string $resource = BookshelfResource::class;

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
