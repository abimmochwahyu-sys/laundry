<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class KaryawanExport implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    WithStyles, 
    ShouldAutoSize,
    WithCustomStartCell,
    WithTitle
{
    protected $karyawans;
    protected $rowCount = 0;

    public function __construct($karyawans)
    {
        $this->karyawans = $karyawans;
        $this->rowCount = count($karyawans);
    }

    public function collection()
    {
        return $this->karyawans;
    }

    public function title(): string
    {
        return 'Data Karyawan';
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Karyawan',
            'Email',
            'Alamat',
            'No Telepon',
            'Tanggal Bergabung',
        ];
    }

    public function map($karyawan): array
    {
        static $counter = 0;
        $counter++;

        return [
            $counter,
            $karyawan->user->name ?? 'N/A',
            $karyawan->user->email ?? 'N/A',
            $karyawan->alamat,
            $karyawan->telepon,
            $karyawan->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Judul
        $sheet->setCellValue('A1', 'DATA KARYAWAN SICLEAN LAUNDRY');
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '2563EB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Meta Info
        $sheet->setCellValue('A2', 'Dicetak pada: ' . Carbon::now()->format('d M Y H:i'));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'color' => ['rgb' => '64748B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Header Table
        $headerRange = 'A4:F4';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Borders
        $lastRow = 4 + $this->rowCount;
        $dataRange = 'A4:F' . $lastRow;
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        
        // Centering No column
        $sheet->getStyle('A5:A' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [
            4 => ['font' => ['bold' => true]],
        ];
    }
}
