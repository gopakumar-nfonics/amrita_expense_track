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

        $totalAllocated = 0;
        $totalExpense = 0;
        $totalBalance = 0;
        $totalsubCategoryExpense=0;

        // Add empty rows for title and header
        $data[] = ['Amrita Vishwa Vidyapeetham (ASE/ASA)', '', '', '', '', '', ''];
        $data[] = ['Budget & Expense Report', '', '', '', '', '', ''];
        $data[] = ['Period: From 01-Jul-2024 To 26-Sep-2024', '', '', '', '', '', ''];

        // Add the header row after the title rows
        $data[] = ['#','Category','Allocated','Sub-Category','Expense','Total Expense','Balance']; // Add headings as a row

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

        $data[]= [
            '', 
            '',
            '', 
            '', 
            '', 
            '', 
            '', 
        ];
     
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
                $sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'name' => 'Verdana' // Set font to Verdana
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE2E2E2'], // Set background color
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'outline' => [ // Set black borders on the outer boundary of the merged cells
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'], // Black color
                        ],
                    ],
                ]);
                

                // Format the second title row
                $sheet->mergeCells('A2:G2');
                $sheet->getStyle('A2:G2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'name' => 'Verdana' // Set font to Verdana
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE2E2E2'], // Set background color
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'outline' => [ // Set black borders on the outer boundary of the merged cells
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'], // Black color
                        ],
                    ],
                ]);

                // Format the period row
                $sheet->mergeCells('A3:G3');
                $sheet->getStyle('A3:G3')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'name' => 'Verdana' // Set font to Verdana
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFE2E2E2'], // Set background color
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'outline' => [ // Set black borders on the outer boundary of the merged cells
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'], // Black color
                        ],
                    ],
                ]);

                $sheet->getStyle('A4:G4')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 11,
                        'color' => ['argb' => 'FFFFFFFF'], // Set font color to white
                        'name' => 'Verdana', // Set font to Verdana
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF0070C0'], // Set background color to a specific blue
                    ],
                    'borders' => [
                        'allBorders' => [ // Apply borders to all cells in the range
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'], // Set border color to black
                        ],
                    ],
                ]);

                  // Set auto-size for each column from A to G
                //   foreach (range('A', 'G') as $columnID) {
                //     $sheet->getColumnDimension($columnID)->setAutoSize(true);
                // }
              

                // Apply Verdana font with size 11 to all columns
$sheet->getStyle('A:G')->applyFromArray([
    'font' => [
        'name' => 'Verdana',  // Set font to Verdana
        'size' => 11,         // Set font size to 11
    ]
]);


                // Make columns C, E, F, G bold
                $sheet->getStyle('C')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT // Right alignment
                    ]
                ]);
                $sheet->getStyle('C')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT // Right alignment
                    ]
                ]);
                $sheet->getStyle('E')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT // Right alignment
                    ]
                ]);
                $sheet->getStyle('F')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT // Right alignment
                    ]
                ]);

                $sheet->getStyle('G')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT // Right alignment
                    ]
                ]);
              


                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(40);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(40);
                $sheet->getColumnDimension('E')->setWidth(25);
                $sheet->getColumnDimension('F')->setWidth(25);
                $sheet->getColumnDimension('G')->setWidth(25);

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

                              
             
            }
        ];
    }

    function convertToFloat($value) {
        // Remove commas and spaces, then convert to float
        return floatval(str_replace(',', '', $value));
    }
}