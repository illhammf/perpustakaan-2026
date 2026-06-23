<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookResource\Pages;
use App\Filament\Admin\Resources\BookResource\RelationManagers\BookCopiesRelationManager;
use App\Models\Book;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-s-book-open';

    protected static ?string $navigationGroup = 'Catalog';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Bibliografi')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subtitle')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('isbn')
                            ->label('ISBN')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('issn')
                            ->label('ISSN')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('edition')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Klasifikasi')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->nullable(),
                        Forms\Components\TextInput::make('ddc_classification')
                            ->label('DDC')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('subject_headings'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Publikasi')
                    ->schema([
                        Forms\Components\Select::make('publisher_id')
                            ->relationship('publisher', 'name')
                            ->searchable()
                            ->nullable(),
                        Forms\Components\TextInput::make('publication_year')
                            ->numeric(),
                        Forms\Components\TextInput::make('language')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('pages')
                            ->numeric(),
                        Forms\Components\TextInput::make('weight')
                            ->numeric()
                            ->suffix('gram'),
                        Forms\Components\TextInput::make('length')
                            ->numeric()
                            ->suffix('cm'),
                        Forms\Components\TextInput::make('width')
                            ->numeric()
                            ->suffix('cm'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Deskripsi')
                    ->schema([
                        Forms\Components\RichEditor::make('description'),
                        Forms\Components\RichEditor::make('abstract'),
                        Forms\Components\FileUpload::make('cover_image')
                            ->image()
                            ->directory('books/covers'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'available' => 'Tersedia',
                                'limited' => 'Terbatas',
                                'unavailable' => 'Tidak Tersedia',
                            ])
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Penulis')
                    ->schema([
                        Forms\Components\Select::make('authors')
                            ->multiple()
                            ->relationship('authors', 'name')
                            ->preload()
                            ->searchable(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('isbn')
                    ->label('ISBN')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('publisher.name')
                    ->label('Penerbit')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('available_copies')
                    ->label('Tersedia')
                    ->getStateUsing(fn (Book $record): int => $record->bookCopies()->where('status', 'available')->count()),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'limited' => 'warning',
                        'unavailable' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Tersedia',
                        'limited' => 'Terbatas',
                        'unavailable' => 'Tidak Tersedia',
                    ]),
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori'),
                Tables\Filters\SelectFilter::make('publisher_id')
                    ->relationship('publisher', 'name')
                    ->label('Penerbit'),
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
            BookCopiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
