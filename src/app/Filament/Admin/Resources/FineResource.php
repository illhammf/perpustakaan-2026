<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FineResource\Pages;
use App\Models\Fine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FineResource extends Resource
{
    protected static ?string $model = Fine::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('loan_id')
                            ->relationship('loan', 'id')
                            ->searchable()
                            ->nullable()
                            ->getOptionLabelFromRecordUsing(fn ($record) => '#' . $record->id),
                        Forms\Components\Select::make('member_id')
                            ->relationship('member', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        Forms\Components\TextInput::make('paid_amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        Forms\Components\Select::make('reason')
                            ->options([
                                'late' => 'Late',
                                'damaged' => 'Damaged',
                                'lost' => 'Lost',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'unpaid' => 'Unpaid',
                                'paid' => 'Paid',
                                'waived' => 'Waived',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpan('full'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan.id')
                    ->label('Loan #')
                    ->formatStateUsing(fn ($state) => '#' . $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_amount')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('remaining_amount')
                    ->label('Remaining')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'paid' => 'success',
                        'waived' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('reason')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'late' => 'warning',
                        'damaged' => 'danger',
                        'lost' => 'gray',
                        default => 'info',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'paid' => 'Paid',
                        'waived' => 'Waived',
                    ]),
                Tables\Filters\SelectFilter::make('reason')
                    ->options([
                        'late' => 'Late',
                        'damaged' => 'Damaged',
                        'lost' => 'Lost',
                        'other' => 'Other',
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
            'index' => Pages\ListFines::route('/'),
            'create' => Pages\CreateFine::route('/create'),
            'edit' => Pages\EditFine::route('/{record}/edit'),
        ];
    }
}
