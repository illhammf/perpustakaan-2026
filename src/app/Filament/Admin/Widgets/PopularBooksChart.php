<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Loan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PopularBooksChart extends ChartWidget
{
    protected static ?string $heading = 'Buku Terpopuler';
    protected int|string|array $columnSpan = 1;
    protected static ?int $sort = 4;
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $popularBooks = Loan::select('book_copy_id', DB::raw('count(*) as total'))
            ->groupBy('book_copy_id')
            ->orderByDesc('total')
            ->limit(10)
            ->with('bookCopy.book')
            ->get()
            ->map(function ($loan) {
                return [
                    'title' => $loan->bookCopy?->book?->title ?? 'Unknown',
                    'total' => $loan->total,
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Kali Dipinjam',
                    'data' => $popularBooks->pluck('total')->toArray(),
                    'backgroundColor' => [
                        '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
                        '#ec4899', '#14b8a6', '#f97316', '#6366f1', '#84cc16',
                    ],
                ],
            ],
            'labels' => $popularBooks->pluck('title')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
