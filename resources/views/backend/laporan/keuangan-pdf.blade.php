<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
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

        .summary {
            margin-top: 15px;
        }

        .summary td {
            border: none;
            padding: 4px 8px;
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
    <h2>LAPORAN KEUANGAN</h2>
    <p class="sub">Periode: {{ $bulanLabel }} | <em>{{ $companyNote }}</em></p>

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
                <td class="text-right">{{ $k->pemasukan > 0 ? 'Rp ' . number_format($k->pemasukan, 0, ',', '.') : '-' }}
                </td>
                <td class="text-right">{{ $k->pengeluaran > 0 ? 'Rp ' . number_format($k->pengeluaran, 0, ',', '.') :
                    '-' }}</td>
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
                <td colspan="2" class="text-right">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.')
                    }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>