<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookCopyResource\Pages;
use App\Models\BookCopy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookCopyResource extends Resource
{
    protected static ?string $model = BookCopy::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-duplicate';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('book_id')
                            ->relationship('book', 'title')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('bookshelf_id')
                            ->relationship('bookshelf', 'code')
                            ->searchable()
                            ->nullable(),
                        Forms\Components\TextInput::make('barcode')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('condition')
                            ->options([
                                'good' => 'Good',
                                'fair' => 'Fair',
                                'damaged' => 'Damaged',
                                'lost' => 'Lost',
                            ])
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'available' => 'Available',
                                'borrowed' => 'Borrowed',
                                'reserved' => 'Reserved',
                                'damaged' => 'Damaged',
                                'lost' => 'Lost',
                                'weeded' => 'Weeded',
                            ])
                            ->required(),
                        Forms\Components\Select::make('acquisition_type')
                            ->options([
                                'purchase' => 'Purchase',
                                'donation' => 'Donation',
                                'grant' => 'Grant',
                            ]),
                        Forms\Components\DatePicker::make('acquisition_date'),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('source')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('notes')
                            ->columnSpan('full'),
                        Forms\Components\Toggle::make('is_active'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('book.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bookshelf.code')
                    ->placeholder('-')
                    ->sortable(),
                Tables\Columns\TextColumn::make('condition')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'good' => 'success',
                        'fair' => 'warning',
                        'damaged' => 'danger',
                        'lost' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'borrowed' => 'warning',
                        'reserved' => 'info',
                        'damaged' => 'danger',
                        'lost' => 'gray',
                        'weeded' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('book.status')
                    ->label('Book Status')
                    ->badge()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'borrowed' => 'Borrowed',
                        'reserved' => 'Reserved',
                        'damaged' => 'Damaged',
                        'lost' => 'Lost',
                        'weeded' => 'Weeded',
                    ]),
                Tables\Filters\SelectFilter::make('condition')
                    ->options([
                        'good' => 'Good',
                        'fair' => 'Fair',
                        'damaged' => 'Damaged',
                        'lost' => 'Lost',
                    ]),
                Tables\Filters\SelectFilter::make('book_id')
                    ->relationship('book', 'title')
                    ->label('Book')
                    ->searchable(),
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
            'index' => Pages\ListBookCopies::route('/'),
            'create' => Pages\CreateBookCopy::route('/create'),
            'edit' => Pages\EditBookCopy::route('/{record}/edit'),
        ];
    }
}
