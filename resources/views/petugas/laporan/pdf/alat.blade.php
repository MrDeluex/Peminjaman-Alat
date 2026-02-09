<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Alat</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 16px;
            font-size: 11px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .meta {
            margin-bottom: 10px;
            font-size: 11px;
        }

        .footer {
            margin-top: 20px;
            font-size: 11px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>Laporan Inventaris Alat</h2>
    <div class="subtitle">
        {{ $filterKategori ? 'Kategori: ' . $filterKategori : 'Semua Kategori' }}
    </div>

    <div class="meta">
        Dicetak pada: {{ now()->format('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Alat</th>
                <th width="25%">Kategori</th>
                <th width="10%">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alats as $i => $alat)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $alat->nama_alat }}</td>
                    <td>{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $alat->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Sistem Peminjaman Alat
    </div>
</body>
</html>
