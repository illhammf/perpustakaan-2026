<?php

namespace App\Filament\Admin\Resources\MemberTypeResource\Pages;

use App\Filament\Admin\Resources\MemberTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMemberType extends EditRecord
{
    protected static string $resource = MemberTypeResource::class;

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
