<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LoanResource\Pages;
use App\Models\Loan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-s-arrow-right-on-rectangle';

    protected static ?string $navigationGroup = 'Transactions';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'active')->count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('member_id')
                            ->relationship('member', 'name')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('book_copy_id')
                            ->relationship('bookCopy', 'barcode')
                            ->searchable()
                            ->required(),
                        Forms\Components\DatePicker::make('loan_date')
                            ->required(),
                        Forms\Components\DatePicker::make('due_date')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'returned' => 'Returned',
                                'overdue' => 'Overdue',
                                'lost' => 'Lost',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('renewal_count')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Textarea::make('notes')
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
                Tables\Columns\TextColumn::make('bookCopy.barcode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bookCopy.book.title')
                    ->label('Book')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('return_date')
                    ->date()
                    ->placeholder('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'warning',
                        'returned' => 'success',
                        'overdue' => 'danger',
                        'lost' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('renewal_count')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'returned' => 'Returned',
                        'overdue' => 'Overdue',
                        'lost' => 'Lost',
                    ]),
                Tables\Filters\Filter::make('loan_date')
                    ->form([
                        Forms\Components\DatePicker::make('loan_date_from'),
                        Forms\Components\DatePicker::make('loan_date_until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['loan_date_from'], fn($q, $date) => $q->whereDate('loan_date', '>=', $date))
                            ->when($data['loan_date_until'], fn($q, $date) => $q->whereDate('loan_date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListLoans::route('/'),
            'create' => Pages\CreateLoan::route('/create'),
            'edit' => Pages\EditLoan::route('/{record}/edit'),
        ];
    }
}
