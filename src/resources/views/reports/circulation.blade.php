<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; font-size: 18px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background: #f0f0f0; font-weight: bold; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="header">
        <p>Periode: {{ $start_date }} - {{ $end_date }}</p>
        <p>Total Peminjaman: {{ $total_loans }} | Dikembalikan: {{ $returned }} | Aktif: {{ $active }} | Hilang: {{ $lost }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Barcode</th>
                <th>Tgl Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $loan->member->name ?? '-' }}</td>
                <td>{{ $loan->bookCopy->book->title ?? '-' }}</td>
                <td>{{ $loan->bookCopy->barcode ?? '-' }}</td>
                <td>{{ $loan->loan_date?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $loan->due_date?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $loan->return_date?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ ucfirst($loan->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Dicetak pada: {{ $generated_at }}</p>
    </div>
</body>
</html>
