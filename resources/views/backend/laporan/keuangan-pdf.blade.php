<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; }
        .sub { text-align: center; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; }
        th { background: #f0f0f0; text-align: left; }
        .text-right { text-align: right; }
        .total-row { background: #f8f8f8; font-weight: bold; }
        .summary { margin-top: 15px; }
        .summary td { border: none; padding: 4px 8px; }
    </style>
</head>
<body>
    <h2>LAPORAN KEUANGAN</h2>
    <p class="sub">{{ config('app.name') }} — Periode: {{ $bulanLabel }} — Dicetak: {{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Uraian</th>
                <th class="text-right">Pemasukan</th>
                <th class="text-right">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keuangans as $i => $k)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $k->kategori ?? '-' }}</td>
                <td>{{ $k->uraian ?? '-' }}</td>
                <td class="text-right">{{ $k->pemasukan > 0 ? 'Rp ' . number_format($k->pemasukan, 0, ',', '.') : '-' }}</td>
                <td class="text-right">{{ $k->pengeluaran > 0 ? 'Rp ' . number_format($k->pengeluaran, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL:</td>
                <td class="text-right">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">SALDO:</td>
                <td colspan="2" class="text-right">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
