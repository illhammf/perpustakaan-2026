<?php

namespace App\Filament\Admin\Resources\BookResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class BookCopiesRelationManager extends RelationManager
{
    protected static string $relationship = 'bookCopies';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('barcode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('bookshelf_id')
                    ->relationship('bookshelf', 'code')
                    ->searchable()
                    ->nullable(),
                Forms\Components\Select::make('condition')
                    ->options([
                        'good' => 'Baik',
                        'fair' => 'Cukup',
                        'damaged' => 'Rusak',
                        'lost' => 'Hilang',
                    ]),
                Forms\Components\Select::make('acquisition_type')
                    ->options([
                        'purchase' => 'Pembelian',
                        'donation' => 'Donasi',
                        'grant' => 'Hibah',
                    ]),
                Forms\Components\DatePicker::make('acquisition_date'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\Textarea::make('notes'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('barcode')
            ->columns([
                Tables\Columns\TextColumn::make('barcode'),
                Tables\Columns\TextColumn::make('bookshelf.code'),
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
                Tables\Columns\TextColumn::make('acquisition_date')
                    ->date(),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Tersedia',
                        'borrowed' => 'Dipinjam',
                        'reserved' => 'Dipesan',
                        'damaged' => 'Rusak',
                        'lost' => 'Hilang',
                        'weeded' => 'Disiangi',
                    ]),
                Tables\Filters\SelectFilter::make('condition')
                    ->options([
                        'good' => 'Baik',
                        'fair' => 'Cukup',
                        'damaged' => 'Rusak',
                        'lost' => 'Hilang',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
