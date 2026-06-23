<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Loan;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OverdueLoansWidget extends BaseWidget
{
    protected int|string|array $columnSpan = 1;
    protected static ?int $sort = 5;
    protected static ?string $heading = 'Peminjaman Terlambat';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Loan::whereIn('status', ['active', 'overdue'])
                    ->whereDate('due_date', '<', now())
                    ->with(['member', 'bookCopy.book'])
                    ->latest('due_date')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('member.name')
                    ->label('Anggota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bookCopy.book.title')
                    ->label('Buku')
                    ->limit(30),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Jatuh Tempo')
                    ->date()
                    ->color('danger'),
                Tables\Columns\TextColumn::make('days_overdue')
                    ->label('Terlambat')
                    ->badge()
                    ->color('danger'),
            ])
            ->paginated(false);
    }
}
