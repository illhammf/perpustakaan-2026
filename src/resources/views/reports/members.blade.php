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
        th { background: #f0f0f0; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="header">
        <p>Total Anggota: {{ $total_members }} | Aktif: {{ $active_members }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Anggota</th>
                <th>Nama</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Pinjaman Aktif</th>
                <th>Telepon</th>
                <th>Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $member->member_number }}</td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->memberType?->name ?? '-' }}</td>
                <td>{{ ucfirst($member->status) }}</td>
                <td class="text-center">{{ $member->loans->count() }}</td>
                <td>{{ $member->phone ?? '-' }}</td>
                <td>{{ $member->registered_at?->format('d/m/Y') ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        <p>Dicetak pada: {{ $generated_at }}</p>
    </div>
</body>
</html>
