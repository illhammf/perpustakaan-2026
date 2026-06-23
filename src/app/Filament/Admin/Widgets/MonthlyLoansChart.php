<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Loan;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class MonthlyLoansChart extends ChartWidget
{
    protected static ?string $heading = 'Peminjaman Per Bulan';
    protected int|string|array $columnSpan = 1;
    protected static ?int $sort = 3;
    protected static ?string $pollingInterval = null;

    protected function getData(): array
    {
        $data = Trend::model(Loan::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peminjaman',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#2563eb',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => \Carbon\Carbon::parse($value->date)->format('M')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
