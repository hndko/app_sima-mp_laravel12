<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Hutang Piutang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; }
        .sub { text-align: center; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; }
        th { background: #f0f0f0; text-align: left; }
        .text-right { text-align: right; }
        .total-row { background: #f8f8f8; font-weight: bold; }
        .info-table td { border: none; padding: 3px 8px; }
    </style>
</head>
<body>
    <h2>LAPORAN HUTANG PIUTANG</h2>
    <p class="sub">{{ config('app.name') }} — Dicetak: {{ now()->format('d M Y H:i') }}</p>

    <table class="info-table">
        <tr><td width="150"><strong>Karyawan</strong></td><td>: {{ $karyawan->nama_karyawan }} ({{ $karyawan->id_karyawan }})</td></tr>
        <tr><td><strong>Bidang</strong></td><td>: {{ $karyawan->bidang ?? '-' }}</td></tr>
        <tr><td><strong>Total Hutang</strong></td><td>: Rp {{ number_format($totalHutang, 0, ',', '.') }}</td></tr>
        <tr><td><strong>Total Bayar</strong></td><td>: Rp {{ number_format($totalBayar, 0, ',', '.') }}</td></tr>
        <tr><td><strong>Saldo Sisa</strong></td><td>: <strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong></td></tr>
    </table>

    <h3 style="margin-top: 25px;">Riwayat Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rincians as $i => $r)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $r->tipe == 'hutang' ? 'Kasbon' : 'Bayar/Potong' }}</td>
                <td>{{ $r->keterangan ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($r->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
