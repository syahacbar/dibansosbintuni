<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #0f172a; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        p { margin: 0 0 16px; color: #475569; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f1f5f9; text-align: left; font-weight: bold; }
        th, td { border: 1px solid #cbd5e1; padding: 6px; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Dicetak pada {{ $generatedAt->format('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                @foreach ($headings as $heading)
                    <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell ?: '-' }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headings) }}">Data laporan belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
