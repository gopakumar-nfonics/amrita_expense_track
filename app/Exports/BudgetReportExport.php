<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BudgetReportExport implements FromArray, WithEvents
{
    protected $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
    }

   
    public function array(): array
    {
        $data = [];
        $counter = 1;

        // Add empty rows for title and header
        $data[] = ['Amrita Vishwa Vidyapeetham (ASE/ASA)', '', '', '', '', '', ''];
        $data[] = ['Budget & Expense Report', '', '', '', '', '', ''];
        $data[] = ['Period: From 01-Jul-2024 To 26-Sep-2024', '', '', '', '', '', ''];

        // Add the header row after the title rows
        $data[] = ['#','Category','Allocated','Sub-Category','Expense','Total Expense','Balance']; // Add headings as a row

        foreach ($this->categories as $category) {
            $subCategoryCount = count($category['sub_categories']);

            if ($subCategoryCount > 0) {
                foreach ($category['sub_categories'] as $index => $subCategory) {
                    $row = [];

                    if ($index === 0) {
                        // First row for the category, include category and total amounts with rowspan logic
                        $row[] = $counter;
                        $row[] = $category['category'];
                        $row[] = $category['allocated'] != 0 ? $category['allocated'] : '-';
                    } else {
                        // Empty cells for the next rows in this category
                        $row[] = ''; // For the '#'
                        $row[] = ''; // For the 'Category'
                        $row[] = ''; // For the 'Allocated'
                    }

                    // Sub-category details
                    $row[] = $subCategory['name'];
                    $row[] = $subCategory['expense'] != 0 ? $subCategory['expense'] : '0.00';

                    if ($index === 0) {
                        // Only the first row for this category should have total expense and balance
                        $row[] = $category['total_expense'] != 0 ? $category['total_expense'] : '-';
                        $row[] = $category['balance'] != 0 ? $category['balance'] : '-';
                    } else {
                        $row[] = ''; // For the 'Total Expense'
                        $row[] = ''; // For the 'Balance'
                    }

                    $data[] = $row;
                }
            } else {
                // No sub-categories, so we only display the category details
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

        return $data;
    }

    /**
     * Register events to modify the sheet after creation.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Format the first title row
                $sheet->mergeCells('A1:G1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                ]);

                // Format the second title row
                $sheet->mergeCells('A2:G2');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                ]);

                // Format the period row
                $sheet->mergeCells('A3:G3');
                $sheet->getStyle('A3')->applyFromArray([
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->getStyle('A4:G4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['argb' => 'FFFFFFFF'], // Set font color to white
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF0070C0'], // Set background color to a specific blue
                    ],
                ]);

                // Merging cells based on the number of subcategories
                $rowIndex = 5; // Start after the title and headings
                foreach ($this->categories as $category) {
                    $subCategoryCount = count($category['sub_categories']);
                    
                    if ($subCategoryCount > 0) {
                        // Merge cells for the first row of the category and its subcategories
                        $sheet->mergeCells("A$rowIndex:A" . ($rowIndex + $subCategoryCount - 1)); // Merging '#'
                        $sheet->mergeCells("B$rowIndex:B" . ($rowIndex + $subCategoryCount - 1)); // Merging 'Category'
                        $sheet->mergeCells("C$rowIndex:C" . ($rowIndex + $subCategoryCount - 1)); // Merging 'Allocated'
                        $sheet->mergeCells("F$rowIndex:F" . ($rowIndex + $subCategoryCount - 1)); // Merging 'Total Expense'
                        $sheet->mergeCells("G$rowIndex:G" . ($rowIndex + $subCategoryCount - 1)); // Merging 'Balance'

                        // Move the row index by the number of subcategories plus the header
                        $rowIndex += $subCategoryCount;
                    } else {
                        // Just move to the next row for categories without subcategories
                        $rowIndex++;
                    }
                }

                // Set auto-size for columns
                foreach (range('A', 'G') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
