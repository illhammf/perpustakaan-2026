<?php

namespace App\Filament\Admin\Pages;

use App\Models\LibrarySetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class LibrarySettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.library-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = LibrarySetting::where('is_active', true)->get()->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General Settings')
                    ->schema([
                        Forms\Components\TextInput::make('library_name')
                            ->label('Nama Perpustakaan')
                            ->default('Perpustakaan Ilham Berkah'),
                        Forms\Components\TextInput::make('library_address')
                            ->label('Alamat Perpustakaan'),
                        Forms\Components\TextInput::make('library_phone')
                            ->label('Telepon'),
                        Forms\Components\TextInput::make('library_email')
                            ->label('Email'),
                        Forms\Components\TextInput::make('library_website')
                            ->label('Website'),
                    ])->columns(2),

                Forms\Components\Section::make('Loan Settings')
                    ->schema([
                        Forms\Components\TextInput::make('default_loan_duration')
                            ->label('Durasi Peminjaman Default (hari)')
                            ->numeric()
                            ->default(14),
                        Forms\Components\TextInput::make('max_loans_per_member')
                            ->label('Maksimal Peminjaman per Anggota')
                            ->numeric()
                            ->default(5),
                        Forms\Components\TextInput::make('fine_per_day')
                            ->label('Denda per Hari (Rp)')
                            ->numeric()
                            ->default(1000),
                        Forms\Components\TextInput::make('max_renewals')
                            ->label('Maksimal Perpanjangan')
                            ->numeric()
                            ->default(1),
                    ])->columns(2),

                Forms\Components\Section::make('Membership Settings')
                    ->schema([
                        Forms\Components\TextInput::make('member_card_prefix')
                            ->label('Prefix Kartu Anggota')
                            ->default('MB'),
                        Forms\Components\Select::make('member_card_auto_generate')
                            ->label('Generate Kartu Otomatis')
                            ->options([true => 'Ya', false => 'Tidak'])
                            ->default(true),
                        Forms\Components\TextInput::make('member_expiry_years')
                            ->label('Masa Berlaku Anggota (tahun)')
                            ->numeric()
                            ->default(1),
                    ])->columns(2),

                Forms\Components\Section::make('OPAC Settings')
                    ->schema([
                        Forms\Components\Toggle::make('opac_enabled')
                            ->label('Aktifkan OPAC')
                            ->default(true),
                        Forms\Components\TextInput::make('opac_title')
                            ->label('Judul OPAC')
                            ->default('Katalog Online Perpustakaan Ilham Berkah'),
                        Forms\Components\Textarea::make('opac_welcome_message')
                            ->label('Welcome Message'),
                    ])->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            LibrarySetting::updateOrCreate(
                ['key' => $key],
                ['value' => (string) $value, 'is_active' => true]
            );
        }

        Cache::forget('library_settings');

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
