<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DonationResource\Pages;
use App\Models\Donation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('donor_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('donor_contact')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('donor_email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\Select::make('donation_type')
                            ->options([
                                'book' => 'Book',
                                'cash' => 'Cash',
                                'supply' => 'Supply',
                            ])
                            ->required(),
                        Forms\Components\Select::make('book_id')
                            ->relationship('book', 'title')
                            ->searchable()
                            ->nullable()
                            ->visible(fn (Forms\Get $get): bool => $get('donation_type') === 'book'),
                        Forms\Components\TextInput::make('title')
                            ->maxLength(255)
                            ->nullable(),
                        Forms\Components\TextInput::make('quantity')
                            ->integer()
                            ->default(1),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->nullable(),
                        Forms\Components\DatePicker::make('donation_date'),
                        Forms\Components\Textarea::make('description')
                            ->columnSpan('full'),
                        Forms\Components\Textarea::make('thanks_message')
                            ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('donor_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('donation_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'book' => 'info',
                        'cash' => 'success',
                        'supply' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('book.title')
                    ->placeholder('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->placeholder('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('donation_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('donation_type')
                    ->options([
                        'book' => 'Book',
                        'cash' => 'Cash',
                        'supply' => 'Supply',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}
