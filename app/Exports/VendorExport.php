<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class VendorExport implements FromArray, WithEvents
{
    protected $vendorData;

    public function __construct(array $vendorData)
    {
        $this->vendorData = $vendorData;
    }

    public function array(): array
    {
        $data[] = ['Amrita Vishwa Vidyapeetham (ASE/ASA)', '', '', '', '', '', '', '','',''];
        $data[] = ['Vendor Wise - Payment Reports', '', '', '', '', '', '', '','',''];
        $data[] = ['Period: From 01-Jul-2024 To 26-Sep-2024', '', '', '', '', '', '', '','',''];
        $data[] = ['#', 'Vendor', 'Proposal', 'RO #', 'Milestone', 'Invoice #', 'Payment Date', 'Amount', 'Total'];
    
        $serialNumber = 1; // Initialize serial number for vendors
    
        foreach ($this->vendorData as $vendor) {
            $vendorRowCount = 0; // Track rows added for each vendor
    
            foreach ($vendor['proposals'] as $proposal) {
                $proposalRowCount = 0; // Track rows added for each proposal
                $milestones = $proposal['milestones'];
    
                // Only include proposals with milestones
                if (!empty($milestones)) {
                    // Prepare the row for the vendor
                    if ($vendorRowCount === 0) {
                        $data[] = [
                            $serialNumber++, // Serial number for the vendor
                            $vendor['vendor_name'],  // Vendor Name
                            '', // Proposal Title
                            '', // RO
                            '', // Milestone Name
                            '', // Milestone Amount
                            '', // Invoice ID
                            '', // Transaction Date
                            ''  // Total (if any)
                        ];
                    }
    
                    // Prepare the row for the proposal
                    if ($proposalRowCount === 0) {
                        // Fill proposal title and RO for the first milestone
                        $data[count($data) - 1][2] = $proposal['proposal_title'];
                        $data[count($data) - 1][3] = $proposal['proposal_ro'];
                        $data[count($data) - 1][8] = $proposal['total_milestone_amount'];  // Set Total for the proposal
                    }
    
                    foreach ($milestones as $milestone) {
                        $data[] = [
                            '', // Serial number (leave empty for milestone rows)
                            '', // Vendor Name (leave empty for merged cell)
                            '', // Proposal Title (leave empty for merged cell)
                            '', // RO
                            $milestone['milestone_name'], // Milestone
                            $milestone['invoice_id'], // Invoice #
                            $milestone['transaction_date'], // Payment Date
                            $milestone['milestone_amount'], // Amount
                            '',  // Leave Total empty for milestone rows
                        ];
                    }
    
                    $vendorRowCount++;
                }
            }
        }
      

        // Total row
        $data[] = [
            'Total',
             '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ];

    
        return $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = 5; // Starting after headers (first 4 rows for titles and headers)
    
                // Title row styling
                $sheet->mergeCells('A1:I1');
                $sheet->mergeCells('A2:I2');
                $sheet->mergeCells('A3:I3');
                $this->applyTitleStyle($sheet, 'A1:I1');
                $this->applyTitleStyle($sheet, 'A2:I2');
                $this->applyTitleStyle($sheet, 'A3:I3');
    
                // Header row styling
                $sheet->getStyle('A4:I4')->applyFromArray($this->getHeaderStyle());
    
                // Apply default font and vertical alignment
                $sheet->getStyle('A:I')->applyFromArray([
                    'font' => ['name' => 'Verdana', 'size' => 11],
                    'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                ]);
    
                $serialNumber = 1;

                
            // Bold and align specific columns (C, E, F, G)
            $this->applyBoldRightAlign($sheet, 'H');
            $this->applyBoldRightAlign($sheet, 'I');

            // Set column widths
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(40);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(30);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(20);
            $sheet->getColumnDimension('H')->setWidth(25);
            $sheet->getColumnDimension('I')->setWidth(25);
    
                // Iterate over each vendor and their proposals
                foreach ($this->vendorData as $vendor) {
                    // Track the starting row for this vendor
                    $vendorRowStart = $rowCount;
    
                    // Count the total number of milestones for this vendor across all proposals
                    $totalMilestones = array_sum(array_map(function ($proposal) {
                        return count($proposal['milestones']);
                    }, $vendor['proposals']));
    
                    // Merge vendor name across the required number of rows
                    if ($totalMilestones > 1) {
                        $sheet->mergeCells("A$rowCount:A" . ($rowCount + $totalMilestones - 1));
                        $sheet->mergeCells("B$rowCount:B" . ($rowCount + $totalMilestones - 1));
                    }
    
                    // Set the vendor name and serial number in the first row for this vendor
                    $sheet->setCellValue("A$rowCount", $serialNumber++);
                    $sheet->setCellValue("B$rowCount", $vendor['vendor_name']);
    
                    // Loop through each proposal
                    foreach ($vendor['proposals'] as $proposal) {
                        // Track the starting row for this proposal
                        $proposalRowStart = $rowCount;
    
                        // Count the number of milestones for this proposal
                        $milestoneCount = count($proposal['milestones']);
    
                        // Merge proposal title and RO # across the required number of rows if there are multiple milestones
                        if ($milestoneCount > 1) {
                            $sheet->mergeCells("C$rowCount:C" . ($rowCount + $milestoneCount - 1));
                            $sheet->mergeCells("D$rowCount:D" . ($rowCount + $milestoneCount - 1));
                            $sheet->mergeCells("I$rowCount:I" . ($rowCount + $milestoneCount - 1)); // Merge total amount column
                        }
    
                        // Set the proposal title and RO number in the first row for this proposal
                        $sheet->setCellValue("C$rowCount", $proposal['proposal_title']);
                        $sheet->setCellValue("D$rowCount", $proposal['proposal_ro']);
                        $sheet->setCellValue("I$rowCount", $proposal['total_milestone_amount']);
    
                        // Loop through each milestone for this proposal
                        foreach ($proposal['milestones'] as $milestone) {
                            // Set the milestone details for each milestone row
                            $sheet->setCellValue("E$rowCount", $milestone['milestone_name']);
                            $sheet->setCellValue("F$rowCount", $milestone['invoice_id']);
                            $sheet->setCellValue("G$rowCount", $milestone['transaction_date']);
                            $sheet->setCellValue("H$rowCount", $milestone['milestone_amount']);
    
                            // Increment the row count after processing each milestone
                            $rowCount++;
                        }
                    }
                }
    
                $lastRow = $rowCount+2; // $rowIndex is the current row after all category and subcategory rows

                $sheet->getStyle("A$lastRow:I$lastRow")->applyFromArray($this->getTotalRowStyle());
                
                $sheet->mergeCells("A$lastRow:H$lastRow");
                $sheet->getStyle("A$lastRow:H$lastRow")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                
                // Apply borders to the data range
                $sheet->getStyle("A1:I$rowCount")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);
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