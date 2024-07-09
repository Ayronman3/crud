<?php

namespace App\Livewire;

use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportGenerator extends Component
{
    public $data;
    public $reportPreview;
    public $templatePath = 'assets/sampleTemplate.xlsx';

    public function mount()
    {
        // Initialize your data or fetch from database
        $this->data = $this->fetchReportData();
    }

    public function fetchReportData()
    {
        // Replace this with your logic to fetch data
        return [
            ['John Doe', 100, '2024-01-01'],
            ['Jane Smith', 150, '2024-01-02']
        ];
    }

    public function generatePreview()
    {
        $spreadsheet = IOFactory::load($this->templatePath);

        // Fill in the data
        $sheet = $spreadsheet->getActiveSheet();
        $row = 2; // Assuming data starts at row 2
        foreach ($this->data as $record) {
            $sheet->fromArray($record, NULL, 'A' . $row++);
        }

        $writer = new Xlsx($spreadsheet);
        $previewPath = storage_path('app/public/report_preview.xlsx');
        $writer->save($previewPath);

        $this->reportPreview = asset('storage/report_preview.xlsx');
    }

    public function downloadExcel()
    {
        return response()->download(storage_path('app/public/report_preview.xlsx'), 'report.xlsx');
    }

    public function downloadPDF()
    {
        $spreadsheet = IOFactory::load($this->templatePath);

        // Fill in the data
        $sheet = $spreadsheet->getActiveSheet();
        $row = 2; // Assuming data starts at row 2
        foreach ($this->data as $record) {
            $sheet->fromArray($record, NULL, 'A' . $row++);
        }

        $writer = new Xlsx($spreadsheet);
        $pdfPath = storage_path('app/public/report.pdf');
        $writer->save($pdfPath);

        $pdf = PDF::loadView('livewire.report-pdf', ['data' => $this->data]);
        return $pdf->download('report.pdf');
    }

    public function reportGenerator(){
        $this->redirect('report-generator', navigate:true);
    }
    public function render()
    {
        return view('livewire.report-generator');
    }
}