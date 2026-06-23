<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Loan;
use Illuminate\Database\Eloquent\Collection;

class BookStockService
{
    public function getAvailableCopies(Book $book): Collection
    {
        return $book->bookCopies()->where('status', 'available')->where('is_active', true)->get();
    }

    public function getAvailableCount(Book $book): int
    {
        return $book->bookCopies()->where('status', 'available')->where('is_active', true)->count();
    }

    public function getTotalCopies(Book $book): int
    {
        return $book->bookCopies()->where('is_active', true)->count();
    }

    public function isAvailable(Book $book): bool
    {
        return $this->getAvailableCount($book) > 0;
    }

    public function getAllAvailableBooks()
    {
        return Book::whereHas('bookCopies', function ($query) {
            $query->where('status', 'available')->where('is_active', true);
        })->where('is_active', true)->get();
    }

    public function getBooksByStatus(string $status)
    {
        return Book::whereHas('bookCopies', function ($query) use ($status) {
            $query->where('status', $status);
        })->get();
    }

    public function getStockReport()
    {
        $books = Book::with(['bookCopies' => function ($query) {
            $query->where('is_active', true);
        }])->where('is_active', true)->get();

        $report = [];
        foreach ($books as $book) {
            $total = $book->bookCopies->count();
            $available = $book->bookCopies->where('status', 'available')->count();
            $borrowed = $book->bookCopies->whereIn('status', ['borrowed'])->count();
            $damaged = $book->bookCopies->where('status', 'damaged')->count();
            $lost = $book->bookCopies->where('status', 'lost')->count();

            $report[] = [
                'book' => $book,
                'total' => $total,
                'available' => $available,
                'borrowed' => $borrowed,
                'damaged' => $damaged,
                'lost' => $lost,
            ];
        }

        return $report;
    }

    public function markCopyAsDamaged(BookCopy $bookCopy, string $notes = null): BookCopy
    {
        if ($bookCopy->status === 'borrowed') {
            throw new \RuntimeException("Tidak dapat menandai eksemplar yang sedang dipinjam sebagai rusak");
        }

        $bookCopy->update([
            'status' => 'damaged',
            'notes' => $notes ? ($bookCopy->notes ? $bookCopy->notes . "\n" . $notes : $notes) : $bookCopy->notes,
        ]);

        return $bookCopy;
    }

    public function markCopyAsWeeded(BookCopy $bookCopy, string $notes = null): BookCopy
    {
        if ($bookCopy->status === 'borrowed') {
            throw new \RuntimeException("Tidak dapat menyiangi eksemplar yang sedang dipinjam");
        }

        $bookCopy->update([
            'status' => 'weeded',
            'is_active' => false,
            'notes' => $notes ? ($bookCopy->notes ? $bookCopy->notes . "\n[Weeded] " . $notes : "[Weeded] " . $notes) : $bookCopy->notes,
        ]);

        return $bookCopy;
    }

    public function searchBooks(string $query)
    {
        return Book::where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('isbn', 'like', "%{$query}%")
              ->orWhereHas('authors', function ($authorQuery) use ($query) {
                  $authorQuery->where('name', 'like', "%{$query}%");
              })
              ->orWhereHas('publisher', function ($publisherQuery) use ($query) {
                  $publisherQuery->where('name', 'like', "%{$query}%");
              });
        })->where('is_active', true);
    }
}
