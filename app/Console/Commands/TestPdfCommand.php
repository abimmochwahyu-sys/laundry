<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Dompdf\Dompdf;
use Carbon\Carbon;

class TestPdfCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:pdf';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test PDF generation functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing PDF generation...');

        try {
            $data = [
                'message' => 'PDF Test Berhasil!',
                'timestamp' => Carbon::now()->format('Y-m-d H:i:s'),
            ];

            $this->info('Generating PDF...');
            $dompdf = new Dompdf();
            $html = view('owner.exports.test-pdf', $data)->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $fileName = 'test-pdf-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';
            $filePath = storage_path('app/public/' . $fileName);

            $this->info('Saving PDF to: ' . $filePath);
            file_put_contents($filePath, $dompdf->output());

            $this->info('✅ PDF generated successfully!');
            $this->info('File saved at: ' . $filePath);

        } catch (\Exception $e) {
            $this->error('❌ PDF generation failed!');
            $this->error('Error: ' . $e->getMessage());
            $this->error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            return 1;
        }

        return 0;
    }
}
