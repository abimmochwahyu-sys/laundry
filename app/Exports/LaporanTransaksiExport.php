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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Carbon\Carbon;

class LaporanTransaksiExport implements 
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

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
        $this->rowCount = count($laporan);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->laporan;
    }

    public function title(): string
    {
        return 'Laporan Transaksi';
    }

    public function startCell(): string
    {
        return 'A4';
    }

    /**
     * Define the headings for the Excel file
     */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Kode Transaksi',
            'Pelanggan',
            'Layanan',
            'Berat (Kg)',
            'Total Harga',
            'Status',
        ];
    }

    /**
     * Map the data for each row
     */
    public function map($transaksi): array
    {
        static $counter = 0;
        $counter++;

        return [
            $counter,
            $transaksi->created_at->format('d/m/Y'),
            $transaksi->kode_transaksi ?? '-',
            $transaksi->user->name ?? 'Umum',
            $transaksi->layanan->jenis_layanan ?? '-',
            (float) $transaksi->berat,
            (float) $transaksi->total_harga,
            strtoupper($transaksi->status_pembayaran ?? 'PENDING'),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => '#,##0.0" Kg"',
            'G' => '"Rp "#,##0',
        ];
    }

    /**
     * Apply styles to the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        // Judul Laporan
        $sheet->setCellValue('A1', 'LAPORAN TRANSAKSI LAUNDRY - CLEANS3');
        $sheet->mergeCells('A1:H1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '4F46E5']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Subtitle / Info
        $sheet->setCellValue('A2', 'Dicetak pada: ' . Carbon::now()->format('d M Y H:i'));
        $sheet->mergeCells('A2:H2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Style untuk header tabel (Baris 4)
        $lastColumn = 'H';
        $headerRange = 'A4:' . $lastColumn . '4';
        
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ]);

        // Border untuk seluruh data
        $lastRow = 4 + $this->rowCount;
        $dataRange = 'A4:' . $lastColumn . $lastRow;
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        // Alignment untuk data
        $sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('F5:F' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('H5:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Row Total di bagian bawah
        $footerRow = $lastRow + 1;
        $sheet->setCellValue('A' . $footerRow, 'GRAND TOTAL');
        $sheet->mergeCells('A' . $footerRow . ':F' . $footerRow);
        
        // Menghitung total dari koleksi langsung untuk menghindari error formula excel
        $total = $this->laporan->sum('total_harga');
        $sheet->setCellValue('G' . $footerRow, $total);
        
        $sheet->getStyle('A' . $footerRow . ':' . $lastColumn . $footerRow)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E293B'],
            ],
        ]);
        $sheet->getStyle('G' . $footerRow)->getNumberFormat()->setFormatCode('"Rp "#,##0');

        // Freeze panes
        $sheet->freezePane('A5');

        return [
            4 => ['font' => ['bold' => true]],
        ];
    }
}
