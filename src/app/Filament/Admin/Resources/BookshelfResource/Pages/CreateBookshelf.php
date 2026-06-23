<?php

namespace App\Filament\Admin\Resources\BookshelfResource\Pages;

use App\Filament\Admin\Resources\BookshelfResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookshelf extends CreateRecord
{
    protected static string $resource = BookshelfResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
