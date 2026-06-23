<?php

namespace App\Filament\Admin\Resources\BookCopyResource\Pages;

use App\Filament\Admin\Resources\BookCopyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookCopies extends ListRecords
{
    protected static string $resource = BookCopyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
