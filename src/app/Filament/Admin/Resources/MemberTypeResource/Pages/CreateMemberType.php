<?php

namespace App\Filament\Admin\Resources\MemberTypeResource\Pages;

use App\Filament\Admin\Resources\MemberTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMemberType extends CreateRecord
{
    protected static string $resource = MemberTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
