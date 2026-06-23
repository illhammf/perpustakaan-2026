<?php

namespace App\Services;

use App\Models\BookCopy;
use App\Models\Loan;
use App\Models\Fine;
use App\Models\Member;
use App\Models\MemberType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanService
{
    public function borrow(Member $member, BookCopy $bookCopy, ?int $loanedById = null, ?int $durationDays = null): Loan
    {
        return DB::transaction(function () use ($member, $bookCopy, $loanedById, $durationDays) {
            $memberType = $member->memberType;
            $duration = $durationDays ?? ($memberType->loan_duration_days ?? 14);

            $activeLoans = $this->getActiveLoansCount($member);
            $maxLoans = $memberType->max_loans ?? 5;

            if ($activeLoans >= $maxLoans) {
                throw new \RuntimeException("Member已达到最大借阅数量 ({$maxLoans})");
            }

            if ($bookCopy->status !== 'available') {
                throw new \RuntimeException("此副本不可借阅");
            }

            $loan = Loan::create([
                'member_id' => $member->id,
                'book_copy_id' => $bookCopy->id,
                'loan_date' => now(),
                'due_date' => now()->addDays($duration),
                'status' => 'active',
                'loaned_by' => $loanedById,
            ]);

            $bookCopy->update(['status' => 'borrowed']);

            return $loan;
        });
    }

    public function returnLoan(Loan $loan, ?int $processedById = null): Loan
    {
        return DB::transaction(function () use ($loan, $processedById) {
            if (!in_array($loan->status, ['active', 'overdue'])) {
                throw new \RuntimeException("该借阅记录状态无效");
            }

            $loan->update([
                'return_date' => now(),
                'status' => 'returned',
                'processed_by' => $processedById,
            ]);

            $loan->bookCopy->update(['status' => 'available']);

            if ($loan->isOverdue) {
                $this->createFineForOverdue($loan);
            }

            return $loan;
        });
    }

    public function renewLoan(Loan $loan, ?int $processedById = null): Loan
    {
        return DB::transaction(function () use ($loan, $processedById) {
            if ($loan->status !== 'active' && $loan->status !== 'overdue') {
                throw new \RuntimeException("只能续借活跃或逾期的借阅记录");
            }

            $memberType = $loan->member->memberType;
            $renewalLimit = $memberType->renewal_limit ?? 1;

            if ($loan->renewal_count >= $renewalLimit) {
                throw new \RuntimeException("已达到最大续借次数 ({$renewalLimit})");
            }

            $loan->update([
                'due_date' => now()->addDays($memberType->loan_duration_days ?? 14),
                'status' => 'active',
                'renewal_count' => $loan->renewal_count + 1,
                'processed_by' => $processedById,
            ]);

            return $loan;
        });
    }

    public function markAsLost(Loan $loan, ?int $processedById = null): Loan
    {
        return DB::transaction(function () use ($loan, $processedById) {
            $loan->update([
                'status' => 'lost',
                'processed_by' => $processedById,
            ]);

            $loan->bookCopy->update(['status' => 'lost']);

            Fine::create([
                'loan_id' => $loan->id,
                'member_id' => $loan->member_id,
                'amount' => $loan->bookCopy->price ?? 50000,
                'reason' => 'lost',
                'description' => 'Buku hilang: ' . $loan->bookCopy->book->title,
                'status' => 'unpaid',
            ]);

            return $loan;
        });
    }

    public function getActiveLoans(): \Illuminate\Database\Eloquent\Collection
    {
        return Loan::whereIn('status', ['active', 'overdue'])
            ->with(['member', 'bookCopy.book'])
            ->get();
    }

    public function getOverdueLoans(): \Illuminate\Database\Eloquent\Collection
    {
        return Loan::whereIn('status', ['active'])
            ->whereDate('due_date', '<', now())
            ->with(['member', 'bookCopy.book'])
            ->get();
    }

    public function getActiveLoansCount(Member $member): int
    {
        return Loan::where('member_id', $member->id)
            ->whereIn('status', ['active', 'overdue'])
            ->count();
    }

    public function updateOverdueStatuses(): int
    {
        $count = 0;
        $overdueLoans = Loan::where('status', 'active')
            ->whereDate('due_date', '<', now())
            ->get();

        foreach ($overdueLoans as $loan) {
            $loan->update(['status' => 'overdue']);
            $count++;
        }

        return $count;
    }
}
