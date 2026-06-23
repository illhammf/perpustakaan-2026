<?php

namespace App\Filament\Admin\Resources\BookshelfResource\Pages;

use App\Filament\Admin\Resources\BookshelfResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookshelves extends ListRecords
{
    protected static string $resource = BookshelfResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
