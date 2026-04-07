<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class TransaksiExport implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    WithStyles, 
    ShouldAutoSize,
    WithColumnFormatting, 
    WithCustomStartCell,
    WithTitle
{
    protected $laporan;
    protected $rowCount = 0;

    public function __construct($startDate = null, $endDate = null)
    {
        $query = Transaksi::with(['user', 'layanan']);
        if ($startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end   = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('tanggal_transaksi', [$start, $end]);
        }
        
        $this->laporan = $query->orderBy('tanggal_transaksi', 'desc')->get();
        $this->rowCount = $this->laporan->count();
    }

    public function collection()
    {
        return $this->laporan;
    }

    public function title(): string
    {
        return 'Laporan Admin';
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'Tanggal',
            'Pelanggan',
            'Layanan',
            'Berat (Kg)',
            'Harga / Kg',
            'Total Bruto',
            'Diskon',
            'Total Akhir',
            'Status Bayar',
            'Status Trx',
        ];
    }

    public function map($transaksi): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $transaksi->kode_transaksi ?? '-',
            $transaksi->tanggal_transaksi->format('d/m/Y'),
            $transaksi->user->name ?? '-',
            $transaksi->layanan->jenis_layanan ?? '-',
            (float) $transaksi->berat,
            (float) ($transaksi->layanan->harga ?? 0),
            (float) $transaksi->total_harga,
            (float) $transaksi->diskon,
            (float) $transaksi->total_akhir,
            strtoupper($transaksi->status_pembayaran ?? 'PENDING'),
            ucfirst($transaksi->status_transaksi),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => '#,##0.0" Kg"',
            'G' => '"Rp "#,##0',
            'H' => '"Rp "#,##0',
            'I' => '"Rp "#,##0',
            'J' => '"Rp "#,##0',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Judul
        $sheet->setCellValue('A1', 'LAPORAN TRANSAKSI ADMIN - CLEANS3');
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->setCellValue('A2', 'Generated at: ' . Carbon::now()->format('d/m/Y H:i'));
        $sheet->mergeCells('A2:L2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Header Tabel
        $lastColumn = 'L';
        $headerRange = 'A4:' . $lastColumn . '4';
        
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['outline' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        // Border & Alignment untuk data
        $lastRow = 4 + $this->rowCount;
        $dataRange = 'A4:' . $lastColumn . $lastRow;
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        $sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C5:C' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F5:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K5:L' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Grand Total Row
        if ($this->rowCount > 0) {
            $footerRow = $lastRow + 1;
            $sheet->setCellValue('A' . $footerRow, 'GRAND TOTAL (Penerimaan Bersih)');
            $sheet->mergeCells('A' . $footerRow . ':I' . $footerRow);
            
            $totalAkhir = $this->laporan->sum('total_akhir');
            $sheet->setCellValue('J' . $footerRow, $totalAkhir);
            
            $sheet->getStyle('A' . $footerRow . ':' . $lastColumn . $footerRow)->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E293B'],
                ],
            ]);
            $sheet->getStyle('J' . $footerRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');
        }

        $sheet->freezePane('A5');

        return [
            4 => ['font' => ['bold' => true]],
        ];
    }
}
