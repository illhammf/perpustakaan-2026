<?php

namespace App\Filament\Admin\Resources\MemberResource\Pages;

use App\Filament\Admin\Resources\MemberResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListMembers extends ListRecords
{
    protected static string $resource = MemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('printCard')
                ->label('Cetak Kartu Anggota')
                ->icon('heroicon-o-printer')
                ->action(function () {
                    Notification::make()
                        ->title('Fitur cetak kartu anggota akan segera tersedia')
                        ->warning()
                        ->send();
                }),
        ];
    }
}
