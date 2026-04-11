<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Laporan - {{ $tanggal }}</title>
    <style>
        /* Standar Label Thermal Receipt 58mm */
        @page {
            size: 58mm auto;
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            width: 58mm;
            margin: 0 auto;
            padding: 2mm;
            color: #000;
            background-color: #fff;
            font-size: 9px;
            line-height: 1.2;
            -webkit-print-color-adjust: exact;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .header {
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 0;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 1px 0;
            font-size: 8px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 6px 0;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .summary-title {
            font-weight: bold;
            text-decoration: underline;
            margin: 5px 0;
            display: block;
            font-size: 9px;
        }

        .footer {
            margin-top: 12px;
            font-size: 8px;
        }

        .no-print {
            margin-top: 25px;
            text-align: center;
        }

        .btn-print {
            background-color: #1e40af;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
        }

        @media print {
            .no-print {
                display: none;
            }
            body {
                width: 58mm;
                margin: 0;
                padding: 2mm;
            }
            @page { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header text-center">
        <h2>SICLEAN LAUNDRY</h2>
        <p>RINGKASAN LAPORAN TRANSAKSI</p>
        <p>Dicetak: {{ $tanggal }}</p>
    </div>

    <div class="divider"></div>

    <span class="summary-title">RINGKASAN:</span>
    <table>
        <tr>
            <td>Total Trx</td>
            <td class="text-right">{{ $total_transaksi }}</td>
        </tr>
        <tr>
            <td>Bruto</td>
            <td class="text-right">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Total Diskon</td>
            <td class="text-right">Rp {{ number_format($total_diskon, 0, ',', '.') }}</td>
        </tr>
        <tr class="font-bold">
            <td>NETTO</td>
            <td class="text-right">Rp {{ number_format($total_akhir, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <span class="summary-title">RIWAYAT TRANS:</span>
    <table>
        @foreach($transaksis as $item)
        <tr>
            <td>{{ substr($item->kode_transaksi, -8) }}</td>
            <td class="text-right">Rp{{ number_format($item->total_akhir, 0, '', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <div class="footer text-center">
        <p>Laporan Sistem SICLEAN</p>
        <p>Administrator Copy</p>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="btn-print">Cetak Struk Laporan</button>
    </div>

</body>
</html>
