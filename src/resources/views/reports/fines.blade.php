<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; font-size: 18px; }
        .header { text-align: center; margin-bottom: 20px; }
        .summary { display: flex; justify-content: space-around; margin-bottom: 20px; }
        .summary-item { text-align: center; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background: #f0f0f0; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="header">
        <p>Periode: {{ $start_date }} - {{ $end_date }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Alasan</th>
                <th>Jumlah</th>
                <th>Dibayar</th>
                <th>Sisa</th>
                <th>Status</th>
                <th>Tgl Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fines as $fine)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $fine->member->name ?? '-' }}</td>
                <td>{{ ucfirst($fine->reason) }}</td>
                <td class="text-right">Rp {{ number_format($fine->amount, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($fine->paid_amount, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($fine->remaining_amount, 0, ',', '.') }}</td>
                <td>{{ ucfirst($fine->status) }}</td>
                <td>{{ $fine->paid_at?->format('d/m/Y') ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th class="text-right">Rp {{ number_format($total_fines, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($total_paid, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($total_unpaid, 0, ',', '.') }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
    <div class="footer">
        <p>Dicetak pada: {{ $generated_at }}</p>
    </div>
</body>
</html>
