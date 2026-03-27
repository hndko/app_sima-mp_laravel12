<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Hutang Piutang</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .sub {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
        }

        th {
            background: #f0f0f0;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            background: #f8f8f8;
            font-weight: bold;
        }

        .info-table td {
            border: none;
            padding: 3px 8px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table td {
            border: none;
            vertical-align: top;
            padding: 0;
        }

        .logo-box {
            width: 62px;
            height: 62px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    @php
    $companyName = trim((string) ($appSettings['nama_cv'] ?? '')) ?: config('app.name');
    $companyAddress = trim((string) ($appSettings['alamat'] ?? '')) ?: 'Alamat belum diatur';
    $companyPhone = trim((string) ($appSettings['telepon'] ?? '')) ?: '-';
    $companyEmail = trim((string) ($appSettings['email_cv'] ?? '')) ?: '-';
    $companyNote = trim((string) ($appSettings['kop_surat'] ?? '')) ?: 'Dokumen ini dibuat otomatis oleh sistem.';
    $logoPath = public_path('assets/img/icons/icon-48x48.png');
    if (!empty($appSettings['logo_perusahaan'])) {
    $uploadedLogo = public_path('storage/' . $appSettings['logo_perusahaan']);
    if (file_exists($uploadedLogo)) {
    $logoPath = $uploadedLogo;
    }
    }
    @endphp

    <table class="header-table">
        <tr>
            <td style="width:70px;"><img src="{{ $logoPath }}" class="logo-box" alt="Logo"></td>
            <td>
                <h2 style="text-align:left; margin:0 0 4px;">{{ strtoupper($companyName) }}</h2>
                <p style="margin:0; color:#666;">{{ $companyAddress }}</p>
                <p style="margin:2px 0 0; color:#666;">{{ $companyPhone }} | {{ $companyEmail }}</p>
            </td>
            <td style="text-align:right; color:#666; font-size:11px;">
                Dicetak: {{ now()->format('d M Y H:i') }}
            </td>
        </tr>
    </table>
    <h2>LAPORAN HUTANG PIUTANG</h2>
    <p class="sub"><em>{{ $companyNote }}</em></p>

    <table class="info-table">
        <tr>
            <td width="150"><strong>Karyawan</strong></td>
            <td>: {{ $karyawan->nama_karyawan }} ({{ $karyawan->id_karyawan }})</td>
        </tr>
        <tr>
            <td><strong>Bidang</strong></td>
            <td>: {{ $karyawan->bidang ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Total Hutang</strong></td>
            <td>: Rp {{ number_format($totalHutang, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Bayar</strong></td>
            <td>: Rp {{ number_format($totalBayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Saldo Sisa</strong></td>
            <td>: <strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong></td>
        </tr>
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