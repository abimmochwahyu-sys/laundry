<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan SICLEAN</title>
    <style>
        @page { margin: 0cm 0cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0; padding: 0;
            color: #1e293b;
            background-color: #ffffff;
            font-size: 11px;
            line-height: 1.5;
        }
        .header-bg {
            background-color: #2563eb;
            height: 120px;
            width: 100%;
            position: absolute;
            top: 0;
            z-index: -1;
        }
        .container { padding: 40px 50px; }
        .header { margin-bottom: 30px; color: white; }
        .header table { width: 100%; border: none; }
        .header td { border: none; vertical-align: top; }
        .brand-name { font-size: 24px; font-weight: bold; margin: 0; }
        .report-title { font-size: 14px; opacity: 0.9; margin: 5px 0 0 0; text-transform: uppercase; letter-spacing: 2px; }
        .date-info { text-align: right; font-size: 10px; }
        .summary-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            text-align: center;
            width: 200px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .summary-label { display: block; color: #64748b; font-size: 9px; text-transform: uppercase; font-weight: bold; }
        .summary-value { display: block; color: #0f172a; font-size: 16px; font-weight: bold; }
        .main-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .main-table th {
            background-color: #f1f5f9;
            color: #475569;
            font-weight: bold;
            text-align: left;
            padding: 12px 10px;
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 9px;
        }
        .main-table td { padding: 10px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        .text-center { text-align: center; }
        .footer { margin-top: 50px; }
        .footer-table { width: 100%; }
        .notes { color: #64748b; font-size: 9px; }
        .signature-box { text-align: center; width: 200px; float: right; }
        .signature-line { margin-top: 60px; border-top: 1px solid #1e293b; padding-top: 5px; font-weight: bold; }
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
                        <p class="report-title">Data Karyawan Terdaftar</p>
                    </td>
                    <td class="date-info">
                        <p>Tanggal Cetak: {{ $tanggal }}</p>
                    </td>
                </tr>
            </table>
        </div>

        <div class="summary-card">
            <span class="summary-label">Total Karyawan</span>
            <span class="summary-value">{{ $total_karyawan }} Org</span>
        </div>

        <table class="main-table">
            <thead>
                <tr>
                    <th class="text-center" width="5%">No</th>
                    <th width="20%">Nama</th>
                    <th width="20%">Email</th>
                    <th width="30%">Alamat</th>
                    <th width="15%">No. HP</th>
                    <th width="10%">Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawans as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td style="font-weight: bold;">{{ $item->user->name ?? 'N/A' }}</td>
                        <td>{{ $item->user->email ?? 'N/A' }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->telepon }}</td>
                        <td>{{ $item->created_at->format('d/m/y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td>
                        <div class="notes">
                            <strong>Catatan:</strong>
                            <p>- Data ini merupakan daftar karyawan aktif yang terdaftar di sistem SICLEAN.</p>
                        </div>
                    </td>
                    <td>
                        <div class="signature-box">
                            <p>Penanggung Jawab:</p>
                            <div class="signature-line">Owner SICLEAN</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
