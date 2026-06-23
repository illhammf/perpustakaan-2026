<?php

namespace App\Filament\Admin\Resources\VisitResource\Pages;

use App\Filament\Admin\Resources\VisitResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVisit extends CreateRecord
{
    protected static string $resource = VisitResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
