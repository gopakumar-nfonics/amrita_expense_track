<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ProgramDataExport implements FromCollection, WithHeadings, WithEvents
{
    protected $data;
    protected $grandTotalExpense = 0;
    protected $grandTotalProgramExpense = 0;
    protected $financialYear;

    public function __construct(array $data, $financialYear)
    {
        $this->data = $data;
        $this->financialYear = $financialYear;
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
        $this->grandTotalProgramExpense += $this->convertToFloat($totalExpense ?? 0); // Accumulate total program expense
        $streamRowCount = count($stream['categories']); // Count categories for merging

        // Add the stream name and total program expense for the first category
        $exportData[] = [
            $serialNumber++, // Serial Number
            $stream['stream_name'], // Stream Name
            $stream['categories'][0]['category_name'], // First category name
            number_format_indian($stream['categories'][0]['total_expense']) ?? 0, // First category expense
            $totalExpense // Total Program Expense
        ];

        // Add the remaining categories without stream name and total expense
        for ($i = 1; $i < $streamRowCount; $i++) {
            $currentExpense = $this->convertToFloat($stream['categories'][$i]['total_expense'] ?? 0); // Current category expense
            $this->grandTotalExpense += $currentExpense; // Accumulate total expenses
            $exportData[] = [
                '', // Empty for merging
                '', // Empty for merging
                $stream['categories'][$i]['category_name'], // Current category name
                number_format_indian($stream['categories'][$i]['total_expense']) ?? 0, // Current category expense
                '' // Empty to avoid duplication
            ];
        }
    }

    $exportData[] = ['', '', '', '', '']; // Empty row before total

    // Total row
    $exportData[] = [
        'Total',
        '',
        '',
        '',
        '',
    ];

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
            $event->sheet->getStyle('A1:E1')->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ]);
                   // Apply default font and vertical alignment
                   $event->sheet->getStyle('A:E')->applyFromArray([
                    'font' => ['name' => 'Verdana', 'size' => 11],
                    'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                ]);

            
            // Merge cells for the report title
            $event->sheet->mergeCells('A1:E1'); // Title
            $event->sheet->setCellValue('A1', 'Amrita Vishwa Vidyapeetham (ASE/ASA)');

            $event->sheet->mergeCells('A2:E2'); // Subtitle
            $event->sheet->setCellValue('A2', 'Budget & Expense Report');

            $event->sheet->mergeCells('A3:E3'); // Period
            $event->sheet->setCellValue('A3', "Year: {$this->financialYear}");

            $this->applyTitleStyle($event->sheet, 'A1:E1');
            $this->applyTitleStyle($event->sheet, 'A2:E2');
            $this->applyTitleStyle($event->sheet, 'A3:E3');

            // Header row styling
            $event->sheet->getStyle('A4:E4')->applyFromArray($this->getHeaderStyle());

            // Set column widths
            $event->sheet->getColumnDimension('A')->setWidth(10); // Serial Number
            $event->sheet->getColumnDimension('B')->setWidth(30);
            $event->sheet->getColumnDimension('C')->setWidth(30);
            $event->sheet->getColumnDimension('D')->setWidth(30);
            $event->sheet->getColumnDimension('E')->setWidth(30); // Total Expense

            // Bold and align specific columns (C, E, F, G)
            $this->applyBoldRightAlign($event->sheet, 'D');
            $this->applyBoldRightAlign($event->sheet, 'E');

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

            // Merging cells A, B, E based on stream name changes
            $rowCount = 5; // Start after header rows
            $currentStreamName = null; // Track the current stream name
            $startRow = 5; // Start row for merging

            foreach ($this->data as $stream) {
                $streamRowCount = count($stream['categories']);

                // If there are categories, handle merging
                if ($streamRowCount > 0) {
                    // Add the stream name and total expense
                    if ($currentStreamName !== $stream['stream_name']) {
                        // Merge for the previous stream if applicable
                        if ($currentStreamName !== null && $startRow < $rowCount) {
                            $event->sheet->mergeCells("A$startRow:A" . ($rowCount - 1)); // Merge A
                            $event->sheet->mergeCells("B$startRow:B" . ($rowCount - 1)); // Merge B
                            $event->sheet->mergeCells("E$startRow:E" . ($rowCount - 1)); // Merge E
                        }

                        // Update to the new stream name
                        $currentStreamName = $stream['stream_name'];
                        $startRow = $rowCount; // Reset startRow to the current row
                    }

                    // Increment the row count for each category
                    $rowCount += $streamRowCount;
                }
            }

            // Merge cells for the last stream name if applicable
            if ($currentStreamName !== null && $startRow < $rowCount) {
                $event->sheet->mergeCells("A$startRow:A" . ($rowCount - 1)); // Merge A
                $event->sheet->mergeCells("B$startRow:B" . ($rowCount - 1)); // Merge B
                $event->sheet->mergeCells("E$startRow:E" . ($rowCount - 1)); // Merge E
            }

            // Apply total row styling dynamically
            //$lastRow = count($this->categories) + 6;
            $lastRow = $rowCount + 1; // $rowIndex is the current row after all category and subcategory rows

            $event->sheet->getStyle("A$lastRow:E$lastRow")->applyFromArray($this->getTotalRowStyle());
            $event->sheet->mergeCells("A$lastRow:D$lastRow");

            $event->sheet->setCellValue("A$lastRow", 'Grand Total ');
            $event->sheet->setCellValue("E$lastRow", number_format_indian($this->grandTotalProgramExpense)); // Accessing the class property

            $event->sheet->getStyle("A$lastRow:D$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
           

            // Apply black borders from start row (4) to the last row
            $event->sheet->getStyle("A4:E$lastRow")->applyFromArray($this->getBorderStyle());
        },
    ];
}    

    // Helper to get border style
private function getBorderStyle()
{
    return [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => 'FF000000'],
            ],
        ],
    ];
}


    // Helper to style title rows
    private function applyTitleStyle($sheet, $range)
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'name' => 'Verdana'],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE2E2E2'],
            ],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
    }

    // Helper to apply bold and right alignment to specific columns
    private function applyBoldRightAlign($sheet, $column)
    {
        $sheet->getStyle($column)->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
            ],
        ]);
    }

    // Helper to get header row style
    private function getHeaderStyle()
    {
        return [
            'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF'], 'name' => 'Verdana'],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0070C0'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
    }

    // Helper to get total row style
    private function getTotalRowStyle()
    {
        return [
            'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF'], 'name' => 'Verdana'],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF0070C0'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];
    }

    // Helper to convert values to float
    private function convertToFloat($value)
    {
        return floatval(str_replace(',', '', $value));
    }
}