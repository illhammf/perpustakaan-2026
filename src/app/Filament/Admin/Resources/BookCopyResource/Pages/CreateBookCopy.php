<?php

namespace App\Filament\Admin\Resources\BookCopyResource\Pages;

use App\Filament\Admin\Resources\BookCopyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookCopy extends CreateRecord
{
    protected static string $resource = BookCopyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
