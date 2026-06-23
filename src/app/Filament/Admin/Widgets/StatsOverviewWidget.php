<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Visit;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalBooks = Book::where('is_active', true)->count();
        $totalCopies = BookCopy::where('is_active', true)->count();
        $availableCopies = BookCopy::where('status', 'available')->where('is_active', true)->count();
        $totalMembers = Member::where('status', 'active')->count();
        $activeLoans = Loan::whereIn('status', ['active', 'overdue'])->count();
        $overdueLoans = Loan::where('status', 'active')->whereDate('due_date', '<', now())->count();
        $todayVisits = Visit::whereDate('visited_at', today())->count();
        $totalUnpaidFines = Fine::where('status', 'unpaid')->sum('amount');

        return [
            Stat::make('Total Buku', $totalBooks)
                ->description("{$totalCopies} eksemplar ({$availableCopies} tersedia)")
                ->descriptionIcon('heroicon-m-book-open')
                ->color('success'),

            Stat::make('Anggota Aktif', $totalMembers)
                ->description('Total anggota terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Peminjaman Aktif', $activeLoans)
                ->description("{$overdueLoans} terlambat")
                ->descriptionIcon('heroicon-m-arrow-right-on-rectangle')
                ->color($overdueLoans > 0 ? 'warning' : 'success'),

            Stat::make('Denda Belum Dibayar', 'Rp ' . number_format($totalUnpaidFines, 0, ',', '.'))
                ->description('Total denda yang belum dibayar')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($totalUnpaidFines > 0 ? 'danger' : 'success'),

            Stat::make('Kunjungan Hari Ini', $todayVisits)
                ->description('Pengunjung perpustakaan')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('primary'),
        ];
    }
}
