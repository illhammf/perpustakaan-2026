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
        th, td { border: 1px solid #333; padding: 5px; text-align: left; font-size: 10px; }
        th { background: #f0f0f0; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="header">
        <p>Total Buku: {{ $total_books }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Kategori</th>
                <th>ISBN</th>
                <th>Tahun</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->authors->pluck('name')->implode(', ') }}</td>
                <td>{{ $book->publisher?->name ?? '-' }}</td>
                <td>{{ $book->category?->name ?? '-' }}</td>
                <td>{{ $book->isbn ?? '-' }}</td>
                <td class="text-center">{{ $book->publication_year ?? '-' }}</td>
                <td class="text-center">{{ $book->bookCopies->count() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Dicetak pada: {{ $generated_at }}</p>
    </div>
</body>
</html>
