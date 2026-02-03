<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $transaksi->kode_transaksi }}</title>

    <style>
        body {
            font-family: monospace;
            background: #eaeaea;
        }

        .receipt {
            width: 320px;
            background: #fff;
            margin: 20px auto;
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,.15);
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .divider {
            border-top: 1px dashed #444;
            margin: 10px 0;
        }

        .header h2 {
            margin: 5px 0;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            font-size: 14px;
        }

        td {
            padding: 4px 0;
        }

        .label {
            color: #555;
        }

        .total-row td {
            font-size: 16px;
            font-weight: bold;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-top: 5px;
        }

        .footer {
            font-size: 12px;
            color: #555;
        }

        .no-print {
            margin-top: 15px;
            text-align: center;
        }

        button {
            padding: 6px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        @media print {
            body {
                background: #fff;
            }
            .receipt {
                box-shadow: none;
                border-radius: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="receipt">

    {{-- HEADER --}}
    <div class="header text-center">
        <h2>LAUNDRY BERSIH</h2>
        <small>
            Jl. Contoh No. 123<br>
            Telp: 08xxxxxxxx
        </small>
    </div>

    <div class="divider"></div>

    {{-- INFO --}}
    <table>
        <tr>
            <td class="label">Kode</td>
            <td class="text-right">{{ $transaksi->kode_transaksi }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="text-right">
                {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td class="text-right">
                {{ ucfirst($transaksi->status_pembayaran) }}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- DETAIL --}}
    <table>
        <tr>
            <td class="label">Layanan</td>
            <td class="text-right">{{ $transaksi->layanan->jenis_layanan }}</td>
        </tr>
        <tr>
            <td class="label">Berat</td>
            <td class="text-right">{{ $transaksi->berat }} Kg</td>
        </tr>
        <tr>
            <td class="label">Harga / Kg</td>
            <td class="text-right">
                Rp {{ number_format($transaksi->layanan->harga, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- HITUNGAN --}}
    <table>
        <tr>
            <td class="label">Subtotal</td>
            <td class="text-right">
                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td class="label">Diskon</td>
            <td class="text-right">
                - Rp {{ number_format($transaksi->diskon, 0, ',', '.') }}
            </td>
        </tr>
        <tr class="total-row">
            <td>Total Bayar</td>
            <td class="text-right">
                Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- GRAND TOTAL --}}
    <div class="grand-total">
        TOTAL<br>
        Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}
    </div>

    <div class="divider"></div>

    {{-- FOOTER --}}
    <div class="footer text-center">
        <p style="margin-bottom: 5px;">
            Terima kasih 🙏
        </p>
        <small>
            Simpan struk ini sebagai bukti transaksi
        </small>
    </div>

</div>

<div class="no-print">
    <button onclick="window.print()">Cetak Struk</button>
</div>

</body>
</html>
