<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use Carbon\Carbon;

class ReportService
{
    public function circulationReport(Carbon $startDate, Carbon $endDate, string $format = 'pdf')
    {
        $loans = Loan::with(['member', 'bookCopy.book'])
            ->whereBetween('loan_date', [$startDate, $endDate])
            ->orWhereBetween('return_date', [$startDate, $endDate])
            ->get();

        $data = [
            'title' => 'Laporan Sirkulasi Perpustakaan',
            'start_date' => $startDate->format('d/m/Y'),
            'end_date' => $endDate->format('d/m/Y'),
            'loans' => $loans,
            'total_loans' => $loans->count(),
            'returned' => $loans->where('status', 'returned')->count(),
            'active' => $loans->whereIn('status', ['active', 'overdue'])->count(),
            'lost' => $loans->where('status', 'lost')->count(),
            'generated_at' => now()->format('d/m/Y H:i:s'),
        ];

        return $this->generateOutput('reports.circulation', $data, 'laporan_sirkulasi', $format);
    }

    public function fineReport(Carbon $startDate, Carbon $endDate, string $format = 'pdf')
    {
        $fines = Fine::with(['member', 'loan.bookCopy.book'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate])
                  ->orWhereBetween('paid_at', [$startDate, $endDate]);
            })->get();

        $data = [
            'title' => 'Laporan Denda Perpustakaan',
            'start_date' => $startDate->format('d/m/Y'),
            'end_date' => $endDate->format('d/m/Y'),
            'fines' => $fines,
            'total_fines' => $fines->sum('amount'),
            'total_paid' => $fines->sum('paid_amount'),
            'total_unpaid' => $fines->where('status', 'unpaid')->sum('amount'),
            'total_waived' => $fines->where('status', 'waived')->sum('amount'),
            'generated_at' => now()->format('d/m/Y H:i:s'),
        ];

        return $this->generateOutput('reports.fines', $data, 'laporan_denda', $format);
    }

    public function inventoryReport(string $format = 'pdf')
    {
        $books = Book::with(['publisher', 'category', 'bookCopies' => function ($q) {
            $q->where('is_active', true);
        }])->where('is_active', true)->get();

        $totalBooks = $books->count();
        $totalCopies = $books->sum(fn ($b) => $b->bookCopies->count());
        $available = $books->sum(fn ($b) => $b->bookCopies->where('status', 'available')->count());
        $borrowed = $books->sum(fn ($b) => $b->bookCopies->whereIn('status', ['borrowed'])->count());
        $damaged = $books->sum(fn ($b) => $b->bookCopies->where('status', 'damaged')->count());
        $lost = $books->sum(fn ($b) => $b->bookCopies->where('status', 'lost')->count());

        $data = [
            'title' => 'Laporan Inventaris Buku',
            'books' => $books,
            'total_books' => $totalBooks,
            'total_copies' => $totalCopies,
            'available' => $available,
            'borrowed' => $borrowed,
            'damaged' => $damaged,
            'lost' => $lost,
            'generated_at' => now()->format('d/m/Y H:i:s'),
        ];

        return $this->generateOutput('reports.inventory', $data, 'laporan_inventaris', $format);
    }

    public function memberReport(?string $status = null, string $format = 'pdf')
    {
        $members = Member::with(['memberType', 'loans' => function ($q) {
            $q->whereIn('status', ['active', 'overdue']);
        }])->when($status, fn ($q) => $q->where('status', $status))->get();

        $data = [
            'title' => 'Laporan Anggota Perpustakaan',
            'members' => $members,
            'total_members' => $members->count(),
            'active_members' => $members->where('status', 'active')->count(),
            'filter_status' => $status,
            'generated_at' => now()->format('d/m/Y H:i:s'),
        ];

        return $this->generateOutput('reports.members', $data, 'laporan_anggota', $format);
    }

    public function catalogReport(?int $categoryId = null, string $format = 'pdf')
    {
        $books = Book::with(['publisher', 'authors', 'category', 'bookCopies' => function ($q) {
            $q->where('status', 'available');
        }])->where('is_active', true)
          ->when($categoryId, fn ($q) => $q->where('category_id', $categoryId))
          ->get();

        $data = [
            'title' => 'Katalog Buku Perpustakaan',
            'books' => $books,
            'total_books' => $books->count(),
            'generated_at' => now()->format('d/m/Y H:i:s'),
        ];

        return $this->generateOutput('reports.catalog', $data, 'katalog_buku', $format);
    }

    private function generateOutput(string $view, array $data, string $filename, string $format)
    {
        if ($format === 'excel') {
            return Excel::download(new GenericExport($view, $data), $filename . '.xlsx');
        }

        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download($filename . '.pdf');
    }
}
