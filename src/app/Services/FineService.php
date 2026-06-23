<?php

namespace App\Services;

use App\Models\Fine;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

class FineService
{
    public function createFineForOverdue(Loan $loan): Fine
    {
        $daysOverdue = $loan->days_overdue;
        $finePerDay = $loan->member->memberType->fine_per_day ?? 1000;
        $amount = $daysOverdue * $finePerDay;

        return Fine::create([
            'loan_id' => $loan->id,
            'member_id' => $loan->member_id,
            'amount' => $amount,
            'reason' => 'late',
            'description' => "Denda keterlambatan {$daysOverdue} hari x Rp " . number_format($finePerDay, 0, ',', '.'),
            'status' => 'unpaid',
        ]);
    }

    public function payFine(Fine $fine, float $amount): Fine
    {
        if ($fine->status === 'paid') {
            throw new \RuntimeException("Denda ini sudah dibayar");
        }

        $newPaid = $fine->paid_amount + $amount;

        if ($newPaid > $fine->amount) {
            throw new \RuntimeException("Jumlah pembayaran melebihi sisa denda");
        }

        $fine->update([
            'paid_amount' => $newPaid,
            'status' => $newPaid >= $fine->amount ? 'paid' : 'unpaid',
            'paid_at' => $newPaid >= $fine->amount ? now() : null,
        ]);

        return $fine;
    }

    public function waiveFine(Fine $fine, int $waivedBy, string $reason): Fine
    {
        if ($fine->status === 'paid') {
            throw new \RuntimeException("Denda ini sudah dibayar");
        }

        $fine->update([
            'status' => 'waived',
            'waived_by' => $waivedBy,
            'waived_reason' => $reason,
        ]);

        return $fine;
    }

    public function getMemberTotalFines(Member $member): float
    {
        return Fine::where('member_id', $member->id)
            ->where('status', 'unpaid')
            ->sum('amount');
    }

    public function getTotalUnpaidFines(): float
    {
        return Fine::where('status', 'unpaid')->sum('amount');
    }

    public function recalculateFine(Loan $loan): ?Fine
    {
        $fine = $loan->fine;

        if (!$loan->return_date) {
            return null;
        }

        $daysOverdue = (int) $loan->return_date->startOfDay()->diffInDays($loan->due_date, false);

        if ($daysOverdue <= 0) {
            if ($fine) {
                $fine->update(['status' => 'waived', 'waived_reason' => 'Denda dihapus karena perhitungan ulang']);
            }
            return null;
        }

        $finePerDay = $loan->member->memberType->fine_per_day ?? 1000;
        $newAmount = $daysOverdue * $finePerDay;

        if ($fine) {
            $fine->update(['amount' => $newAmount]);
        } else {
            $fine = Fine::create([
                'loan_id' => $loan->id,
                'member_id' => $loan->member_id,
                'amount' => $newAmount,
                'reason' => 'late',
                'description' => "Denda keterlambatan (perhitungan ulang)",
                'status' => 'unpaid',
            ]);
        }

        return $fine;
    }
}
