<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk {{ $transaksi->kode_transaksi }}</title>

    <style>
        body {
            font-family: "Courier New", monospace;
            background: #f5f5f5;
        }

        .struk {
            width: 300px;
            margin: 20px auto;
            background: #fff;
            padding: 15px;
            font-size: 13px;
            color: #000;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
        }

        .no-print {
            margin-top: 15px;
            text-align: center;
        }

        @media print {
            body {
                background: none;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="struk">

    {{-- HEADER --}}
    <div class="text-center">
        <strong>LAUNDRY BERSIH JAYA</strong><br>
        Jl. Contoh No. 123<br>
        Telp: 08xxxxxxxxxx
    </div>

    <div class="divider"></div>

    {{-- INFO TRANSAKSI --}}
    <table>
        <tr>
            <td>Kode</td>
            <td class="text-right">{{ $transaksi->kode_transaksi }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right">
                {{ $transaksi->tanggal_transaksi->format('d-m-Y') }}
            </td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td class="text-right">{{ $transaksi->user->name }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- DETAIL --}}
    <table>
        <tr>
            <td>{{ $transaksi->layanan->jenis_layanan }}</td>
            <td class="text-right">
                {{ number_format($transaksi->berat, 2) }} Kg
            </td>
        </tr>
        <tr>
            <td>Harga / Kg</td>
            <td class="text-right">
                Rp {{ number_format($transaksi->layanan->harga_per_kg, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td>Subtotal</td>
            <td class="text-right">
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td>Diskon</td>
            <td class="text-right">
                Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- TOTAL --}}
    <table>
        <tr class="total">
            <td>TOTAL</td>
            <td class="text-right">
                Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- FOOTER --}}
    <div class="text-center">
        Terima kasih 🙏<br>
        Cucian bersih & wangi ✨
    </div>

    {{-- PRINT --}}
    <div class="no-print">
        <button onclick="window.print()">🖨 Cetak Struk</button>
    </div>

</div>

</body>
</html>
