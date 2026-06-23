<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MemberTypeResource\Pages;
use App\Models\MemberType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MemberTypeResource extends Resource
{
    protected static ?string $model = MemberType::class;

    protected static ?string $navigationIcon = 'heroicon-s-identification';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('max_loans')
                            ->required()
                            ->numeric()
                            ->default(5),
                        Forms\Components\TextInput::make('loan_duration_days')
                            ->required()
                            ->numeric()
                            ->default(7),
                        Forms\Components\TextInput::make('fine_per_day')
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('renewal_limit')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('can_reserve'),
                        Forms\Components\Toggle::make('is_active'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_loans')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_duration_days')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fine_per_day')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListMemberTypes::route('/'),
            'create' => Pages\CreateMemberType::route('/create'),
            'edit' => Pages\EditMemberType::route('/{record}/edit'),
        ];
    }
}
