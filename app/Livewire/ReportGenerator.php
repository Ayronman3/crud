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

    // public function mount()
    // {
    //     // Initialize your data or fetch from database
    //     $this->data = $this->fetchReportData();
    // }

    // public function fetchReportData()
    // {
    //     // Replace this with your logic to fetch data
    //     return [
    //         ['John Doe', 100, '2024-01-01'],
    //         ['Jane Smith', 150, '2024-01-02']
    //     ];
    // }

    // public function generatePreview()
    // {   
    //     $template = 'storage/app/public/temp.xlsx';
    //     $spreadsheet = IOFactory::load($this->$template);

    //     // Fill in the data
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $row = 2; // Assuming data starts at row 2
    //     foreach ($this->data as $record) {
    //         $sheet->fromArray($record, NULL, 'A' . $row++);
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $previewPath = storage_path('app/public/report_preview.xlsx');
    //     $writer->save($previewPath);

    //     $this->reportPreview = asset('storage/report_preview.xlsx');
    //     // $spreadsheet = new Spreadsheet();
    //     // $activeWorksheet = $spreadsheet->getActiveSheet();
    //     // $activeWorksheet->setCellValue('A1', 'Hello World !');

    //     // $writer = new Xlsx($spreadsheet);
    //     // $writer->save('hello world.xlsx');
    //     // // echo "<meta http-equiv='refresh' content='0;url=hello world.xlsx' />";
    //     // echo "hello";
    // }

    // public function downloadExcel()
    // {
    //     return response()->download(storage_path('app/public/report_preview.xlsx'), 'report.xlsx');
    // }

    // public function downloadPDF()
    // {
    //     $template = public_path('storage/app/public/temp.xlsx');
    //     $spreadsheet = IOFactory::load($this->$template);

    //     // Fill in the data
    //     $sheet = $spreadsheet->getActiveSheet();
    //     $row = 2; // Assuming data starts at row 2
    //     foreach ($this->data as $record) {
    //         $sheet->fromArray($record, NULL, 'A' . $row++);
    //     }

    //     $writer = new Xlsx($spreadsheet);
    //     $pdfPath = storage_path('app/public/report.pdf');
    //     $writer->save($pdfPath);

    //     $pdf = PDF::loadView('livewire.report-pdf', ['data' => $this->data]);
    //     return $pdf->download('report.pdf');
    // }

    public $templatePath;

    public function mount()
    {
        // Set the path to the template file correctly
        $this->templatePath = storage_path('app/public/temp.xlsx');
        // Initialize your data or fetch from the database
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
        // Load the template
        $spreadsheet = IOFactory::load($this->templatePath);

        // Fill in the data
        $sheet = $spreadsheet->getActiveSheet();
        $row = 5; // Assuming data starts at row 2
        foreach ($this->data as $record) {
            $sheet->fromArray($record, NULL, 'A' . $row++);
        }

        // Save the preview file
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
        // Load the template
        $spreadsheet = IOFactory::load($this->templatePath);

        // Fill in the data
        $sheet = $spreadsheet->getActiveSheet();
        $row = 5; // Assuming data starts at row 2
        foreach ($this->data as $record) {
            $sheet->fromArray($record, NULL, 'A' . $row++);
        }

        // Save the modified Excel file
        $writer = new Xlsx($spreadsheet);
        $tempFilePath = storage_path('app/public/report_temp.xlsx');
        $writer->save($tempFilePath);

        // Convert the Excel file to PDF
        $pdf = PDF::loadView('livewire.report-pdf', ['data' => $this->data]);
        return $pdf->download('report.pdf');
    }

    public function reportGenerator(){
        $this->redirect('report-generator', navigate:true);
    }
    public function render()
    {
        return view('livewire.report-generator')
            ->extends('layouts.app') // Make sure this layout file exists
            ->section('content');
    }
}