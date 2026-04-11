<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaksi->kode_transaksi }}</title>
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
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 1px 0;
            font-size: 8px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
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

        .item-row td {
            padding-top: 5px;
        }

        .total-section {
            margin-top: 5px;
        }

        .total-section td {
            font-weight: bold;
        }

        .footer {
            margin-top: 15px;
            font-size: 10px;
        }

        .no-print {
            margin-top: 30px;
            text-align: center;
        }

        .btn-print {
            background-color: #1e40af;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: background-color 0.2s;
        }

        .btn-print:hover {
            background-color: #1e3a8a;
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
            /* Menghilangkan header/footer browser */
            @page { margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    {{-- HEADER --}}
    <div class="header text-center">
        <h2>SICLEAN LAUNDRY</h2>
        <p>Solusi Cuci Bersih & Wangi</p>
        <p>Jl. Raya Utama No. 45, SICLEAN</p>
        <p>Telp: 0812-3456-7890</p>
    </div>

    <div class="divider"></div>

    {{-- INFO TRANSAKSI --}}
    <table>
        <tr>
            <td>No. Struk</td>
            <td class="text-right font-bold">{{ $transaksi->kode_transaksi }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right">{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td class="text-right">{{ $transaksi->customer_name }}</td>
        </tr>
        @if($transaksi->customer_phone)
        <tr>
            <td>Telp</td>
            <td class="text-right">{{ $transaksi->customer_phone }}</td>
        </tr>
        @endif
    </table>

    <div class="divider"></div>

    {{-- DETAIL LAYANAN --}}
    <table>
        <tr class="item-row">
            <td colspan="2">{{ $transaksi->layanan->jenis_layanan }}</td>
        </tr>
        <tr>
            <td>{{ $transaksi->berat }} Kg x Rp {{ number_format($transaksi->layanan->harga, 0, ',', '.') }}</td>
            <td class="text-right">Rp {{ number_format($transaksi->subtotal, 0, ',', '.') }}</td>
        </tr>
        
        @if($transaksi->diskon > 0)
        <tr>
            <td>Diskon</td>
            <td class="text-right">- Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}</td>
        </tr>
        @endif
    </table>

    <div class="divider"></div>

    {{-- TOTAL --}}
    <table class="total-section">
        <tr>
            <td style="font-size: 10px;">TOTAL</td>
            <td class="text-right" style="font-size: 10px;">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="2" class="text-right" style="font-size: 8px; padding-top: 2px;">
                Status: {{ strtoupper($transaksi->status_pembayaran) }}
                ({{ strtoupper($transaksi->metode_pembayaran) }})
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- ESTIMASI SELESAI --}}
    @if($transaksi->tanggal_selesai)
    <div class="text-center" style="margin: 3px 0;">
        <p style="margin: 0; font-size: 7px;">Estimasi Selesai:</p>
        <p style="margin: 0; font-weight: bold; font-size: 8px;">{{ $transaksi->tanggal_selesai->format('d M Y') }}</p>
    </div>
    <div class="divider"></div>
    @endif

    {{-- FOOTER --}}
    <div class="footer text-center">
        <p style="margin: 1px 0;">Terima kasih!</p>
        <p style="margin: 1px 0; font-size: 6px;">SICLEAN v1.0</p>
    </div>

    {{-- TOMBOL PRINT (HANYA LAYAR) --}}
    <div class="no-print">
        <div class="divider"></div>
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-print"></i> CETAK STRUK SEKARANG
        </button>
        <p style="font-size: 10px; color: #666; margin-top: 8px;">
            Pastikan Printer Thermal Terhubung
        </p>
    </div>

</body>
</html>
