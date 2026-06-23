<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Loan;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLoans extends BaseWidget
{
    protected int|string|array $columnSpan = 2;
    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::with(['member', 'bookCopy.book'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                    ->label('Anggota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bookCopy.book.title')
                    ->label('Buku')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('bookCopy.barcode')
                    ->label('Barcode')
                    ->badge(),
                Tables\Columns\TextColumn::make('loan_date')
                    ->label('Tanggal Pinjam')
                    ->date(),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date()
                    ->color(fn (Loan $record): string => 
                        $record->status === 'active' && now()->startOfDay()->gt($record->due_date) ? 'danger' : 'default'
                    ),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'warning',
                        'returned' => 'success',
                        'overdue' => 'danger',
                        'lost' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->paginated(false);
    }
}
