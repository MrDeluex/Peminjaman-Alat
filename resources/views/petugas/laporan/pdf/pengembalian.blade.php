<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        h2 { text-align: center; margin-bottom: 5px; }
        .meta { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #eee; }
        .ttd { margin-top: 30px; width: 100%; }
        .ttd td { border: none; }
    </style>
</head>
<body>
    <h2>LAPORAN PENGEMBALIAN ALAT</h2>
    <div class="meta">Dicetak: {{ now()->format('d M Y') }}</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Pengembalian</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengembalians as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->peminjaman->user->username ?? '-' }}</td>
                <td>{{ $p->peminjaman->alat->nama_alat ?? '-' }}</td>
                <td>{{ $p->peminjaman->jumlah ?? '-' }}</td>
                <td>
                    {{ \Carbon\Carbon::parse($p->peminjaman->tanggal_pinjam)->format('d/m/Y') }}
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d/m/Y') }}
                </td>
                <td>
                    Rp {{ number_format($p->denda ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="ttd">
        <tr>
            <td width="70%"></td>
            <td>
                Petugas,<br><br><br>
                ( {{ auth()->user()->username ?? 'Petugas' }} )
            </td>
        </tr>
    </table>
</body>
</html>
