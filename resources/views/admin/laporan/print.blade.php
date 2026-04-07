<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - {{ request('start_date') ?? 'Semua' }} s/d {{ request('end_date') ?? 'Semua' }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            font-size: 11px;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 1000;
        }

        .print-button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px 4px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 11px;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tfoot {
            font-weight: bold;
            background-color: #e9ecef;
        }

        tfoot td {
            border-top: 2px solid #333;
        }

        .text-right {
            text-align: right !important;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        @media print {
            .print-button {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <button class="print-button" onclick="window.print()">
        🖨️ Cetak PDF
    </button>

    <div class="header">
        <h1>LAPORAN TRANSAKSI LAUNDRY</h1>
        <p>SICLEAN - Sistem Informasi Laundry</p>
        <p>Periode: {{ request('start_date') ?? 'Semua Tanggal' }} s/d {{ request('end_date') ?? 'Semua Tanggal' }}</p>
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Kode</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Pelanggan</th>
                <th width="12%">Layanan</th>
                <th width="8%">Berat</th>
                <th width="10%">Total</th>
                <th width="8%">Diskon</th>
                <th width="10%">Akhir</th>
                <th width="5%">Bayar</th>
                <th width="5%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $transaksi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                    <td>{{ $transaksi->tanggal_transaksi->format('d-m-Y') }}</td>
                    <td>{{ $transaksi->user->name }}</td>
                    <td>{{ $transaksi->layanan->jenis_layanan }}</td>
                    <td>{{ number_format($transaksi->berat, 2) }} Kg</td>
                    <td class="text-right">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
                    <td>{{ $transaksi->status_pembayaran === 'pending' ? 'Pending' : 'Lunas' }}</td>
                    <td>{{ ucfirst($transaksi->status_transaksi) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-right"><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksis->sum('total_harga'), 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksis->sum('diskon'), 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksis->sum('total_akhir'), 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak oleh Sistem SICLEAN - {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>

</body>
</html>
