<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MemberResource\Pages;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Membership';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pribadi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('address'),
                        Forms\Components\FileUpload::make('photo')
                            ->image()
                            ->directory('members/photos'),
                        Forms\Components\TextInput::make('id_card_number')
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('birth_date'),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Keanggotaan')
                    ->schema([
                        Forms\Components\TextInput::make('member_number')
                            ->required()
                            ->maxLength(255)
                            ->disabled(fn (string $context): bool => $context === 'edit'),
                        Forms\Components\Select::make('member_type_id')
                            ->relationship('memberType', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('member_card_number')
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Aktif',
                                'inactive' => 'Tidak Aktif',
                                'suspended' => 'Ditangguhkan',
                                'expired' => 'Kadaluarsa',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('registered_at'),
                        Forms\Components\DatePicker::make('expired_at'),
                        Forms\Components\Textarea::make('notes')
                            ->columnSpan('full'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Akun')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->nullable(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('memberType.name')
                    ->label('Tipe')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        'suspended' => 'warning',
                        'expired' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('active_loans_count')
                    ->label('Peminjaman Aktif')
                    ->getStateUsing(fn (Member $record): int => $record->loans()->where('status', 'active')->count())
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_fines')
                    ->label('Total Denda')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('registered_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Tidak Aktif',
                        'suspended' => 'Ditangguhkan',
                        'expired' => 'Kadaluarsa',
                    ]),
                Tables\Filters\SelectFilter::make('member_type_id')
                    ->relationship('memberType', 'name')
                    ->label('Tipe Member'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
