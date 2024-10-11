<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProgramDataExport implements FromCollection, WithHeadings, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $exportData = [
            ['Amrita Vishwa Vidyapeetham (ASE/ASA)', '', '', '', '', '', ''],
            ['Budget & Expense Report', '', '', '', '', '', ''],
            
            // Add headings for the main data
            ['#', 'Programme', 'Category', 'Expense', 'Total Expense'],
        ];

        $serialNumber = 1; // Initialize the serial number

        foreach ($this->data as $stream) {
            $totalExpense = $stream['total_program_expense'];
            $streamRowCount = count($stream['categories']); // Count categories for merging

            // Add the stream name and total program expense for the first category
            $exportData[] = [
                $serialNumber++, // Serial Number
                $stream['stream_name'], // Stream Name
                $stream['categories'][0]['category_name'], // First category name
                $stream['categories'][0]['total_expense'] ?? 0, // First category expense
                $totalExpense // Total Program Expense
            ];

            // Add the remaining categories without stream name and total expense
            for ($i = 1; $i < $streamRowCount; $i++) {
                $exportData[] = [
                    '', // Empty for merging
                    '', // Empty for merging
                    $stream['categories'][$i]['category_name'], // Current category name
                    $stream['categories'][$i]['total_expense'] ?? 0, // Current category expense
                    '' // Empty to avoid duplication
                ];
            }
        }

        return collect($exportData);
    }

    public function headings(): array
    {
        return [
            '#', // Serial Number
            'Programme', // Stream Name
            'Category', // Category Name
            'Expense', // Category Total Expense
            'Total Expense' // Total Program Expense
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Apply styles to the header
                $event->sheet->getStyle('A1:D1')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                ]);

                // Merge cells for the report title
                $event->sheet->mergeCells('A1:E1'); // "Amrita Vishwa Vidyapeetham (ASE/ASA)"
                $event->sheet->setCellValue('A1', 'Amrita Vishwa Vidyapeetham (ASE/ASA)');

                $event->sheet->mergeCells('A2:E2'); // "Budget & Expense Report"
                $event->sheet->setCellValue('A2', 'Budget & Expense Report');

                $event->sheet->mergeCells('A3:E3'); // "Period: From 01-Jul-2024 To 26-Sep-2024"
                $event->sheet->setCellValue('A3', 'Period: From 01-Jul-2024 To 26-Sep-2024');

                // Set column widths and apply border styles as before
                $event->sheet->getColumnDimension('A')->setWidth(10); // For Serial Number
                $event->sheet->getColumnDimension('B')->setWidth(30);
                $event->sheet->getColumnDimension('C')->setWidth(30);
                $event->sheet->getColumnDimension('D')->setWidth(30);
                $event->sheet->getColumnDimension('E')->setWidth(30); // Total Expense

                // Apply borders for all relevant rows
                $totalRows = count($this->data) + 4; // +4 for the header and title rows
                $event->sheet->getStyle('A1:E' . $totalRows)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Set the header style for the main data
                $event->sheet->getStyle('A4:E4')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                ]);
            },
        ];
    }
}
