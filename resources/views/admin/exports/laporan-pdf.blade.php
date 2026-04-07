<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Laundry (Admin) - CLEANS3</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #1e293b;
            background-color: #ffffff;
            font-size: 10px; /* Sedikit lebih kecil untuk muat lebih banyak kolom */
            line-height: 1.4;
        }

        /* Header Gradient Background */
        .header-bg {
            background-color: #0284c7;
            height: 120px;
            width: 100%;
            position: absolute;
            top: 0;
            z-index: -1;
        }

        .container {
            padding: 40px 40px;
        }

        .header {
            margin-bottom: 25px;
            color: white;
        }

        .header table {
            width: 100%;
            border: none;
        }

        .header td {
            border: none;
            vertical-align: top;
        }

        .brand-name {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
        }

        .report-title {
            font-size: 12px;
            opacity: 0.9;
            margin: 5px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .date-info {
            text-align: right;
            font-size: 9px;
        }

        /* Summary Cards */
        .summary-wrapper {
            margin-bottom: 25px;
            margin-top: 10px;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px 0;
            margin: 0 -10px;
        }

        .summary-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: center;
            width: 25%; /* 4 columns for admin */
            border-radius: 8px;
        }

        .summary-label {
            display: block;
            color: #64748b;
            font-size: 8px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .summary-value {
            display: block;
            color: #0f172a;
            font-size: 14px;
            font-weight: bold;
        }

        /* Transaction Table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .main-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
            text-align: left;
            padding: 10px 8px;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 8px;
        }

        .main-table td {
            padding: 8px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .main-table tr:nth-child(even) {
            background-color: #fafbfd;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* Status Badges */
        .badge {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .badge-success { background-color: #dcfce7; color: #15803d; }
        .badge-warning { background-color: #fef9c3; color: #854d0e; }
        .badge-danger { background-color: #fee2e2; color: #b91c1c; }
        .badge-info { background-color: #e0f2fe; color: #0369a1; }

        /* Footer Section */
        .footer {
            margin-top: 40px;
        }

        .footer-table {
            width: 100%;
        }

        .footer td {
            width: 50%;
            vertical-align: top;
        }

        .notes {
            color: #64748b;
            font-size: 8px;
        }

        .signature-box {
            text-align: center;
            width: 180px;
            float: right;
        }

        .signature-line {
            margin-top: 50px;
            border-top: 1px solid #1e293b;
            padding-top: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header-bg"></div>
    <div class="container">
        <div class="header">
            <table>
                <tr>
                    <td>
                        <h1 class="brand-name">SICLEAN</h1>
                        <p class="report-title">Laporan Transaksi Admin</p>
                    </td>
                    <td class="date-info">
                        <p>Tanggal Cetak: {{ $tanggal }}</p>
                        <p>ID Laporan: #ADM-{{ time() }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td class="summary-card">
                        <span class="summary-label">Total Transaksi</span>
                        <span class="summary-value">{{ $total_transaksi }}</span>
                    </td>
                    <td class="summary-card">
                        <span class="summary-label">Pendapatan Bruto</span>
                        <span class="summary-value">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
                    </td>
                    <td class="summary-card">
                        <span class="summary-label">Total Diskon</span>
                        <span class="summary-value">Rp {{ number_format($total_diskon ?? 0, 0, ',', '.') }}</span>
                    </td>
                    <td class="summary-card">
                        <span class="summary-label">Pendapatan Bersih</span>
                        <span class="summary-value">Rp {{ number_format($total_akhir ?? 0, 0, ',', '.') }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th width="12%">Kode</th>
                    <th width="12%">Tanggal</th>
                    <th width="15%">Pelanggan</th>
                    <th width="12%">Layanan</th>
                    <th class="text-center" width="8%">Berat</th>
                    <th class="text-right" width="12%">Total</th>
                    <th class="text-center" width="12%">Status Bayar</th>
                    <th class="text-center" width="12%">Status Trx</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="font-bold">{{ $item->kode_transaksi ?? '-' }}</td>
                        <td>{{ $item->tanggal_transaksi->format('d/m/Y') }}</td>
                        <td>{{ $item->user->name ?? 'Umum' }}</td>
                        <td>{{ $item->layanan->jenis_layanan ?? '-' }}</td>
                        <td class="text-center">{{ number_format($item->berat, 1) }} Kg</td>
                        <td class="text-right font-bold">Rp {{ number_format($item->total_akhir, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->status_pembayaran == 'dibayar' || $item->status_pembayaran == 'lunas' ? 'badge-success' : 'badge-warning' }}">
                                {{ $item->status_pembayaran }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $item->status_transaksi == 'selesai' ? 'badge-success' : ($item->status_transaksi == 'proses' ? 'badge-info' : 'badge-warning') }}">
                                {{ $item->status_transaksi }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center" style="padding: 30px;">Data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($transaksis->count() > 0)
        <div style="text-align: right; margin-top: -10px; margin-bottom: 30px;">
            <table style="width: 100%;">
                <tr>
                    <td width="60%"></td>
                    <td width="40%" style="background-color: #0284c7; color: white; padding: 10px; border-radius: 4px;">
                        <table style="width: 100%; color: white;">
                            <tr>
                                <td><strong>GRAND TOTAL (Bersih)</strong></td>
                                <td align="right"><strong>Rp {{ number_format($total_akhir, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        @endif

        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td>
                        <div class="notes">
                            <strong>Catatan:</strong>
                            <p>- Laporan ini dibuat secara otomatis oleh sistem CLEANS3 Admin.</p>
                            <p>- Data mencakup seluruh transaksi dalam periode yang difilter.</p>
                        </div>
                    </td>
                    <td>
                        <div class="signature-box">
                            <p>Dicetak oleh:</p>
                            <div class="signature-line">
                                Administrator CLEANS3
                            </div>
                            <p style="font-size: 8px; margin-top: 5px;">{{ $tanggal }}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
