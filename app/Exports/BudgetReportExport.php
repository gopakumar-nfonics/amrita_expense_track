<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BudgetReportExport implements FromArray, WithEvents
{
    protected $categories;
    public $financialYear;

    public function __construct($categories, $financialYear)
    {
        $this->categories = $categories;
        $this->financialYear = $financialYear;
    }

    public function array(): array
    {
        $data = [];
        $counter = 1;

        $totalAllocated = 0;
        $totalExpense = 0;
        $totalBalance = 0;
        $totalsubCategoryExpense = 0;

        $year = $this->financialYear ?? 'All';
        
        // Title and Header rows
        $data[] = ['Amrita Vishwa Vidyapeetham (ASE/ASA)', '', '', '', '', '', ''];
        $data[] = ['Budget & Expense Report', '', '', '', '', '', ''];
        $data[] = ["Financial Year: {$year} ", '', '', '', '', '', ''];
        $data[] = ['#', 'Category', 'Budget Allocated', 'Sub-Category', 'Used Amount', 'Total Usage', 'Balance'];

        foreach ($this->categories as $category) {
            $subCategoryCount = count($category['sub_categories']);
            $allocated = $category['allocated'] ?? 0;
            $totalExp = $category['total_expense'] ?? 0;
            $balance = $category['balance'] ?? 0;

            $totalAllocated += $this->convertToFloat($allocated);
            $totalExpense += $this->convertToFloat($totalExp);
            $totalBalance += $this->convertToFloat($balance);

            if ($subCategoryCount > 0) {
                foreach ($category['sub_categories'] as $index => $subCategory) {
                    $subCategoryExpense = $subCategory['expense'] ?? 0;
                    $totalsubCategoryExpense += $this->convertToFloat($subCategoryExpense);
                    $row = [];

                    if ($index === 0) {
                        $row[] = $counter;
                        $row[] = $category['category'];
                        $row[] = $category['allocated'] != 0 ? $category['allocated'] : '-';
                    } else {
                        $row[] = '';
                        $row[] = '';
                        $row[] = '';
                    }

                    $row[] = $subCategory['name'];
                    $row[] = $subCategory['expense'] != 0 ? $subCategory['expense'] : '0.00';

                    if ($index === 0) {
                        $row[] = $category['total_expense'] != 0 ? $category['total_expense'] : '-';
                        $row[] = $category['balance'] != 0 ? $category['balance'] : '-';
                    } else {
                        $row[] = '';
                        $row[] = '';
                    }

                    $data[] = $row;
                }
            } else {
                $data[] = [
                    $counter,
                    $category['category'],
                    $category['allocated'] != 0 ? $category['allocated'] : '-',
                    '-',
                    '-',
                    $category['total_expense'] != 0 ? $category['total_expense'] : '-',
                    $category['balance'] != 0 ? $category['balance'] : '-'
                ];
            }

            $counter++;
        }

        $data[] = ['', '', '', '', '', '', '']; // Empty row before total

        // Total row
        $data[] = [
            '',
            'Total',
            number_format_indian($totalAllocated, 2),
            '',
            number_format_indian($totalsubCategoryExpense, 2),
            number_format_indian($totalExpense, 2),
            number_format_indian($totalBalance, 2),
        ];

        return $data;
    }


    public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet;

            // Title row styling
            $sheet->mergeCells('A1:G1');
            $sheet->mergeCells('A2:G2');
            $sheet->mergeCells('A3:G3');
            $this->applyTitleStyle($sheet, 'A1:G1');
            $this->applyTitleStyle($sheet, 'A2:G2');
            $this->applyTitleStyle($sheet, 'A3:G3');

            // Header row styling
            $sheet->getStyle('A4:G4')->applyFromArray($this->getHeaderStyle());

            // Apply default font and vertical alignment
            $sheet->getStyle('A:G')->applyFromArray([
                'font' => ['name' => 'Verdana', 'size' => 11],
                'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
            ]);

            // Bold and align specific columns (C, E, F, G)
            $this->applyBoldRightAlign($sheet, 'C');
            $this->applyBoldRightAlign($sheet, 'E');
            $this->applyBoldRightAlign($sheet, 'F');
            $this->applyBoldRightAlign($sheet, 'G');

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(50);
            $sheet->getColumnDimension('C')->setWidth(30);
            $sheet->getColumnDimension('D')->setWidth(50);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(30);
            $sheet->getColumnDimension('G')->setWidth(30);

            // Merge cells for categories with sub-categories
            $rowIndex = 5;
            foreach ($this->categories as $category) {
                $subCategoryCount = count($category['sub_categories']);
                if ($subCategoryCount > 0) {
                    $sheet->mergeCells("A$rowIndex:A" . ($rowIndex + $subCategoryCount - 1));
                    $sheet->mergeCells("B$rowIndex:B" . ($rowIndex + $subCategoryCount - 1));
                    $sheet->mergeCells("C$rowIndex:C" . ($rowIndex + $subCategoryCount - 1));
                    $sheet->mergeCells("F$rowIndex:F" . ($rowIndex + $subCategoryCount - 1));
                    $sheet->mergeCells("G$rowIndex:G" . ($rowIndex + $subCategoryCount - 1));
                    $rowIndex += $subCategoryCount;
                } else {
                    $rowIndex++;
                }
            }

            // Apply total row styling dynamically
            //$lastRow = count($this->categories) + 6;
            $lastRow = $rowIndex + 1; // $rowIndex is the current row after all category and subcategory rows

            $sheet->getStyle("A$lastRow:G$lastRow")->applyFromArray($this->getTotalRowStyle());

            // Apply black borders from start row (4) to the last row
            $sheet->getStyle("A4:G$lastRow")->applyFromArray($this->getBorderStyle());
        }
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