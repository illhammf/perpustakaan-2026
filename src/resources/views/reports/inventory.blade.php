<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; font-size: 18px; }
        .header { text-align: center; margin-bottom: 20px; }
        .summary { display: flex; justify-content: space-around; margin-bottom: 20px; flex-wrap: wrap; }
        .summary-item { text-align: center; padding: 10px; min-width: 100px; border: 1px solid #ddd; border-radius: 5px; margin: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; font-size: 10px; }
        th { background: #f0f0f0; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="summary">
        <div class="summary-item"><strong>{{ $total_books }}</strong><br>Judul Buku</div>
        <div class="summary-item"><strong>{{ $total_copies }}</strong><br>Total Eksemplar</div>
        <div class="summary-item"><strong>{{ $available }}</strong><br>Tersedia</div>
        <div class="summary-item"><strong>{{ $borrowed }}</strong><br>Dipinjam</div>
        <div class="summary-item"><strong>{{ $damaged }}</strong><br>Rusak</div>
        <div class="summary-item"><strong>{{ $lost }}</strong><br>Hilang</div>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>ISBN</th>
                <th>Penerbit</th>
                <th>Kategori</th>
                <th>Total</th>
                <th>Tersedia</th>
                <th>Dipinjam</th>
                <th>Rusak</th>
                <th>Hilang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->isbn ?? '-' }}</td>
                <td>{{ $book->publisher?->name ?? '-' }}</td>
                <td>{{ $book->category?->name ?? '-' }}</td>
                <td class="text-center">{{ $book->bookCopies->count() }}</td>
                <td class="text-center">{{ $book->bookCopies->where('status', 'available')->count() }}</td>
                <td class="text-center">{{ $book->bookCopies->whereIn('status', ['borrowed'])->count() }}</td>
                <td class="text-center">{{ $book->bookCopies->where('status', 'damaged')->count() }}</td>
                <td class="text-center">{{ $book->bookCopies->where('status', 'lost')->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Dicetak pada: {{ $generated_at }}</p>
    </div>
</body>
</html>
