<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Proyek {{ $proyek->kode_proyek }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h2 { text-align: center; margin-bottom: 5px; }
        .sub { text-align: center; color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; }
        th { background: #f0f0f0; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .info-table td { border: none; padding: 3px 8px; }
        .total-row { background: #f8f8f8; font-weight: bold; }
        .badge { padding: 2px 8px; border-radius: 3px; color: white; font-size: 11px; }
        .bg-warning { background: #ffc107; color: #333; }
        .bg-success { background: #28a745; }
    </style>
</head>
<body>
    <h2>LAPORAN PROYEK {{ $proyek->kode_proyek }}</h2>
    <p class="sub">{{ config('app.name') }} — Dicetak: {{ now()->format('d M Y H:i') }}</p>

    <table class="info-table">
        <tr><td width="150"><strong>Kode Proyek</strong></td><td>: {{ $proyek->kode_proyek }}</td></tr>
        <tr><td><strong>Klien</strong></td><td>: {{ $proyek->klien->nama_klien }}</td></tr>
        <tr><td><strong>Uraian</strong></td><td>: {{ $proyek->uraian }}</td></tr>
        <tr><td><strong>Ukuran</strong></td><td>: {{ $proyek->ukuran }} {{ $proyek->satuan }}</td></tr>
        <tr><td><strong>Tanggal Mulai</strong></td><td>: {{ \Carbon\Carbon::parse($proyek->tanggal_mulai)->format('d M Y') }}</td></tr>
        <tr><td><strong>Tanggal Selesai</strong></td><td>: {{ $proyek->tanggal_selesai ? \Carbon\Carbon::parse($proyek->tanggal_selesai)->format('d M Y') : '-' }}</td></tr>
        <tr><td><strong>Status</strong></td><td>: {{ ucfirst($proyek->status) }} ({{ $proyek->progres }}%)</td></tr>
        <tr><td><strong>Nilai Dana</strong></td><td>: Rp {{ number_format($proyek->dana_proyek, 0, ',', '.') }}</td></tr>
    </table>

    <h3 style="margin-top: 25px;">Rincian Material</h3>
    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Material</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proyek->rincianProyeks as $i => $r)
            <tr>
                <td class="text-center">{{ $i+1 }}</td>
                <td>{{ $r->bahan }}</td>
                <td class="text-center">{{ $r->jumlah }} {{ $r->satuan }}</td>
                <td class="text-right">Rp {{ number_format($r->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($r->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">Total Biaya Material:</td>
                <td class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">Sisa Anggaran:</td>
                <td class="text-right">Rp {{ number_format($proyek->dana_proyek - $grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
